<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Gate para asignación de cursos - Solo Super Admin, Administrador y Operador
        Gate::define('asignar-cursos', function ($user) {
            return in_array($user->role, ['Super Admin', 'Administrador', 'Operador']);
        });
        
        // Asegurar que la zona horaria de PHP y Carbon coincidan con la configuración de la app
        try {
            $tz = config('app.timezone', 'UTC');
            if ($tz) {
                // Setear timezone de PHP
                date_default_timezone_set($tz);
                ini_set('date.timezone', $tz);
            }

            if (class_exists(\Carbon\Carbon::class)) {
                \Carbon\Carbon::setLocale(config('app.locale'));
                // Carbon usa la timezone de PHP por defecto al crear instancias
            }
        } catch (\Throwable $e) {
            // No bloquear la aplicación si falla el ajuste de timezone
            // Log opcional si se desea: \Log::warning('No se pudo ajustar timezone: ' . $e->getMessage());
        }
    }
}
