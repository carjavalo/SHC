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
    }
}
