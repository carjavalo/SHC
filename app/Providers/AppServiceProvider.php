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

        // Lista maestra de todos los gates que usa el menú y el sistema.
        // Sirve como fallback cuando las tablas de permisos no existen en producción.
        $allKnownGates = [
            'tracking.logins', 'tracking.operations',
            'academic.courses', 'academic.control',
            'menu.configuracion', 'asignar-cursos',
            'users.view', 'users.create', 'users.edit', 'users.delete', 'users.import',
            'roles.manage', 'permissions.manage',
            'config.categorias', 'config.areas', 'config.cursos',
            'config.servicios', 'config.vinculacion', 'config.sedes',
            'config.asignacion', 'config.certificados', 'config.publicidad',
            'chat.access',
            'cursos.view', 'cursos.create', 'cursos.edit', 'cursos.delete',
            'cursos.inscribir', 'cursos.materiales', 'cursos.actividades', 'cursos.calificar',
            'categorias.view', 'categorias.create', 'categorias.edit', 'categorias.delete',
            'areas.view', 'areas.create', 'areas.edit', 'areas.delete',
            'publicidad.view', 'publicidad.create', 'publicidad.edit', 'publicidad.delete', 'publicidad.banner',
            'ayuda.view', 'ayuda.create', 'ayuda.edit', 'ayuda.delete',
            'reportes.view', 'reportes.edit', 'reportes.delete', 'reportes.print', 'reportes.export',
        ];

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
                                'ayuda.view', 'ayuda.create', 'ayuda.edit', 'ayuda.delete',
                                'roles.manage', 'permissions.manage'];
                Gate::define('menu.configuracion', function ($user) use ($rolePermissions, $configPerms) {
                    if ($user->role === 'Super Admin') return true;
                    foreach ($configPerms as $perm) {
                        $allowed = $rolePermissions->get($perm, []);
                        if (in_array($user->role, $allowed)) return true;
                    }
                    return false;
                });

                // Asegurar que todos los gates conocidos estén definidos (por si faltan en BD)
                foreach ($allKnownGates as $gateName) {
                    if (!Gate::has($gateName)) {
                        Gate::define($gateName, function ($user) {
                            return $user->role === 'Super Admin';
                        });
                    }
                }
            } else {
                // Fallback si las tablas no existen aún:
                // Definir todos los gates conocidos para que Super Admin vea todo el menú
                foreach ($allKnownGates as $gateName) {
                    Gate::define($gateName, function ($user) {
                        return $user->role === 'Super Admin'
                            || in_array($user->role, ['Administrador']);
                    });
                }
            }
        } catch (\Throwable $e) {
            // Fallback en caso de error de BD:
            // Definir todos los gates conocidos para que Super Admin vea todo el menú
            foreach ($allKnownGates as $gateName) {
                if (!Gate::has($gateName)) {
                    Gate::define($gateName, function ($user) {
                        return $user->role === 'Super Admin'
                            || in_array($user->role, ['Administrador']);
                    });
                }
            }
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
