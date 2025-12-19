<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\UserRol;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Las políticas de autorización para los modelos.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Registrar los servicios de autorización.
     */
    public function boot(): void
    {
        // 🔒 Gate para Administrador (acceso total)
        Gate::define('es-admin', function ($user) {
            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return in_array(1, $roles);
        });

        // 🔒 Gate para Admin Parámetros (gestiona tablas paramétricas)
        Gate::define('gestionar-parametros', function ($user) {
            $rolesPermitidos = [1, 2]; // Admin y Admin Parámetros

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });

        // 🔒 Gate para Docentes (registra asistencias)
        Gate::define('gestionar-asistencias', function ($user) {
            $rolesPermitidos = [1, 3]; // Admin y Docente

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });

        // 🔒 Gate para gestionar Grupos (Admin y Docente)
        Gate::define('gestionar-grupos', function ($user) {
            $rolesPermitidos = [1, 3]; // Admin y Docente

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });

        // 🔒 Gate para Coordinador (consulta reportes, aprueba justificaciones)
        Gate::define('ver-reportes', function ($user) {
            $rolesPermitidos = [1, 3, 4]; // Admin, Docente y Coordinador

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });

        // 🔒 Gate para gestionar Justificaciones (Coordinador)
        Gate::define('gestionar-justificaciones', function ($user) {
            $rolesPermitidos = [1, 4]; // Admin y Coordinador

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });

        // 🔒 Gate para Estudiantes (consulta su asistencia)
        Gate::define('ver-mi-asistencia', function ($user) {
            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return in_array(5, $roles); // Solo Estudiante
        });

        // 🔒 Gate para gestionar Estudiantes (Admin y Coordinador)
        Gate::define('gestionar-estudiantes', function ($user) {
            $rolesPermitidos = [1, 4]; // Admin y Coordinador

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });

        // 🔒 Gate para gestionar Docentes (Solo Admin)
        Gate::define('gestionar-docentes', function ($user) {
            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return in_array(1, $roles);
        });

        // 🔒 Gate para ver Carreras y Materias (Todos excepto Estudiante)
        Gate::define('ver-carreras-materias', function ($user) {
            $rolesPermitidos = [1, 2, 3, 4]; // Todos excepto Estudiante

            $roles = UserRol::where('id_user', $user->id)
                ->where('estado', 1)
                ->pluck('id_rol')
                ->toArray();

            return !empty(array_intersect($rolesPermitidos, $roles));
        });
    }
}
