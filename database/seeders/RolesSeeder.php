<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\ParamRol;
use App\Models\User;
use App\Models\UserRol;
use App\Models\Docente;
use App\Models\Estudiante;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar Roles en param_rol
        $roles = [
            ['id' => 1, 'rol' => 'Administrador', 'estado' => 1],
            ['id' => 2, 'rol' => 'Admin Parámetros', 'estado' => 1],
            ['id' => 3, 'rol' => 'Docente', 'estado' => 1],
            ['id' => 4, 'rol' => 'Coordinador', 'estado' => 1],
            ['id' => 5, 'rol' => 'Estudiante', 'estado' => 1],
        ];

        foreach ($roles as $rol) {
            ParamRol::updateOrCreate(['id' => $rol['id']], $rol);
        }

        $this->command->info('✅ Roles insertados correctamente');

        // Crear Usuarios de Prueba

        // 1. Usuario Administrador
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@asistencia.edu'],
            [
                'name' => 'Administrador Sistema',
                'password' => Hash::make('admin123'),
            ]
        );

        UserRol::updateOrCreate(
            ['id_user' => $adminUser->id, 'id_rol' => 1],
            ['estado' => 1]
        );

        // 2. Usuario Admin Parámetros
        $adminParamUser = User::updateOrCreate(
            ['email' => 'admin.param@asistencia.edu'],
            [
                'name' => 'Admin Parámetros',
                'password' => Hash::make('param123'),
            ]
        );

        UserRol::updateOrCreate(
            ['id_user' => $adminParamUser->id, 'id_rol' => 2],
            ['estado' => 1]
        );

        // 3. Usuario Docente
        $docenteUser = User::updateOrCreate(
            ['email' => 'docente@asistencia.edu'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('docente123'),
            ]
        );

        UserRol::updateOrCreate(
            ['id_user' => $docenteUser->id, 'id_rol' => 3],
            ['estado' => 1]
        );

        // Crear perfil de docente
        Docente::updateOrCreate(
            ['id_user' => $docenteUser->id],
            [
                'nombre' => 'Juan',
                'ap_paterno' => 'Pérez',
                'ap_materno' => 'García',
                'ci' => '1234567',
                'celular' => '71234567',
                'email' => 'docente@asistencia.edu',
                'direccion' => 'Av. Principal #123',
                'profesion' => 'Ingeniero de Sistemas',
                'estado' => 1,
                'fecha_contratacion' => now(),
            ]
        );

        // 4. Usuario Coordinador
        $coordinadorUser = User::updateOrCreate(
            ['email' => 'coordinador@asistencia.edu'],
            [
                'name' => 'María López',
                'password' => Hash::make('coord123'),
            ]
        );

        UserRol::updateOrCreate(
            ['id_user' => $coordinadorUser->id, 'id_rol' => 4],
            ['estado' => 1]
        );

        // 5. Usuario Estudiante
        $estudianteUser = User::updateOrCreate(
            ['email' => 'estudiante@asistencia.edu'],
            [
                'name' => 'Carlos Rodríguez',
                'password' => Hash::make('estudiante123'),
            ]
        );

        UserRol::updateOrCreate(
            ['id_user' => $estudianteUser->id, 'id_rol' => 5],
            ['estado' => 1]
        );

        // Crear perfil de estudiante solo si existe al menos una carrera
        $primeraCarrera = \App\Models\ParamCarrera::where('estado', 1)->first();

        if ($primeraCarrera) {
            Estudiante::updateOrCreate(
                ['id_user' => $estudianteUser->id],
                [
                    'nombre' => 'Carlos',
                    'ap_paterno' => 'Rodríguez',
                    'ap_materno' => 'Mamani',
                    'ci' => '7654321',
                    'telefono' => '72345678',
                    'email' => 'estudiante@asistencia.edu',
                    'direccion' => 'Calle Secundaria #456',
                    'fecha_nacimiento' => '2000-05-15',
                    'id_carrera' => $primeraCarrera->id,
                    'turno' => 'mañana',
                    'matricula' => '2025-001',
                    'estado' => true,
                    'genero' => 'M',
                    'fecha_ingreso' => now(),
                    'estado_academico' => 'Regular',
                ]
            );
            $this->command->info('✅ Perfil de estudiante creado');
        } else {
            $this->command->warn('⚠️  No se creó perfil de estudiante (no hay carreras registradas)');
        }        $this->command->info('✅ Usuarios de prueba creados correctamente');
        $this->command->info('');
        $this->command->info('Credenciales de acceso:');
        $this->command->info('Admin: admin@asistencia.edu / admin123');
        $this->command->info('Admin Parámetros: admin.param@asistencia.edu / param123');
        $this->command->info('Docente: docente@asistencia.edu / docente123');
        $this->command->info('Coordinador: coordinador@asistencia.edu / coord123');
        $this->command->info('Estudiante: estudiante@asistencia.edu / estudiante123');
    }
}
