<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ══════════════════════════════════════════════════════════
        // Registrar Gates dinámicos basados en la tabla permissions
        // ══════════════════════════════════════════════════════════
        try {
            if (Schema::hasTable('permissions') && Schema::hasTable('role_permissions')) {
                // Cargar todos los permisos y sus roles asignados una sola vez
                $permissions = DB::table('permissions')->pluck('name');
                $rolePermissions = DB::table('role_permissions')
                    ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
                    ->select('role_permissions.role_name', 'permissions.name as permission_name')
                    ->get()
                    ->groupBy('permission_name')
                    ->map(fn($items) => $items->pluck('role_name')->toArray());

                foreach ($permissions as $permissionName) {
                    $allowedRoles = $rolePermissions->get($permissionName, []);
                    Gate::define($permissionName, function ($user) use ($allowedRoles) {
                        // Super Admin siempre tiene acceso total
                        if ($user->role === 'Super Admin') {
                            return true;
                        }
                        return in_array($user->role, $allowedRoles);
                    });
                }

                // Redefinir gate asignar-cursos para que use permisos dinámicos
                Gate::define('asignar-cursos', function ($user) use ($rolePermissions) {
                    if ($user->role === 'Super Admin') return true;
                    $allowed = $rolePermissions->get('config.asignacion', []);
                    return in_array($user->role, $allowed);
                });

                // Gate especial: "menu.configuracion" - muestra el menú Configuración
                // si el usuario tiene al menos un permiso de configuración
                $configPerms = ['users.view', 'config.categorias', 'config.areas', 'config.cursos',
                                'config.servicios', 'config.vinculacion', 'config.sedes',
                                'config.asignacion', 'config.certificados', 'config.publicidad',
                                'roles.manage', 'permissions.manage'];
                Gate::define('menu.configuracion', function ($user) use ($rolePermissions, $configPerms) {
                    if ($user->role === 'Super Admin') return true;
                    foreach ($configPerms as $perm) {
                        $allowed = $rolePermissions->get($perm, []);
                        if (in_array($user->role, $allowed)) return true;
                    }
                    return false;
                });
            } else {
                // Fallback si las tablas no existen aún
                Gate::define('asignar-cursos', function ($user) {
                    return in_array($user->role, ['Super Admin', 'Administrador', 'Operador']);
                });
            }
        } catch (\Throwable $e) {
            // Fallback en caso de error de BD
            Gate::define('asignar-cursos', function ($user) {
                return in_array($user->role, ['Super Admin', 'Administrador', 'Operador']);
            });
        }
        
        // Asegurar que la zona horaria de PHP y Carbon coincidan con la configuración de la app
        try {
            $tz = config('app.timezone', 'UTC');
            if ($tz) {
                date_default_timezone_set($tz);
                ini_set('date.timezone', $tz);
            }

            if (class_exists(\Carbon\Carbon::class)) {
                \Carbon\Carbon::setLocale(config('app.locale'));
            }
        } catch (\Throwable $e) {
            // No bloquear la aplicación si falla el ajuste de timezone
        }
    }
}
