<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estudiante;
use App\Models\User;
use App\Models\UserRol;
use Illuminate\Support\Facades\Hash;

class EstudianteSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = [
            [
                'nombre' => 'Juan',
                'ap_paterno' => 'Perez',
                'ap_materno' => 'Lopez',
                'ci' => '1234567',
                'telefono' => '78945612',
                'email' => 'juan.perez@example.com',
                'direccion' => 'Calle 1',
                'fecha_nacimiento' => '2000-01-01',
                'id_carrera' => 1,
                'turno' => 'mañana',
                'matricula' => 'SIS2025001',
                'estado' => true
            ],
            [
                'nombre' => 'Maria',
                'ap_paterno' => 'Gomez',
                'ap_materno' => 'Torrez',
                'ci' => '2345678',
                'telefono' => '78945613',
                'email' => 'maria.gomez@example.com',
                'direccion' => 'Calle 2',
                'fecha_nacimiento' => '2001-02-02',
                'id_carrera' => 2,
                'turno' => 'noche',
                'matricula' => 'ADM2025002',
                'estado' => true
            ],
            [
                'nombre' => 'Carlos',
                'ap_paterno' => 'Sanchez',
                'ap_materno' => 'Rojas',
                'ci' => '3456789',
                'telefono' => '78945614',
                'email' => 'carlos.sanchez@example.com',
                'direccion' => 'Calle 3',
                'fecha_nacimiento' => '2002-03-03',
                'id_carrera' => 3,
                'turno' => 'mañana',
                'matricula' => 'CON2025003',
                'estado' => true
            ],
            [
                'nombre' => 'Ana',
                'ap_paterno' => 'Vargas',
                'ap_materno' => 'Mendez',
                'ci' => '4567890',
                'telefono' => '78945615',
                'email' => 'ana.vargas@example.com',
                'direccion' => 'Calle 4',
                'fecha_nacimiento' => '2003-04-04',
                'id_carrera' => 4,
                'turno' => 'noche',
                'matricula' => 'DER2025004',
                'estado' => true
            ],
            [
                'nombre' => 'Luis',
                'ap_paterno' => 'Flores',
                'ap_materno' => 'Castro',
                'ci' => '5678901',
                'telefono' => '78945616',
                'email' => 'luis.flores@example.com',
                'direccion' => 'Calle 5',
                'fecha_nacimiento' => '2004-05-05',
                'id_carrera' => 5,
                'turno' => 'mañana',
                'matricula' => 'PSI2025005',
                'estado' => true
            ],
        ];

        foreach ($estudiantes as $estudianteData) {
            // 1. Crear usuario
            $user = User::create([
                'name' => $estudianteData['nombre'] . ' ' . $estudianteData['ap_paterno'],
                'email' => $estudianteData['email'],
                'password' => Hash::make('estudiante123'),
            ]);

            // 2. Asignar rol de Estudiante (ID 5)
            UserRol::create([
                'id_user' => $user->id,
                'id_rol' => 5,
                'estado' => 1,
            ]);

            // 3. Crear perfil de estudiante
            Estudiante::create(array_merge($estudianteData, [
                'id_user' => $user->id,
            ]));
        }

        $this->command->info(count($estudiantes) . ' estudiantes creados correctamente');
    }
}
