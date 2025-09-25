<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carrera::insert([
            [
            'nombre' => 'Ingeniería de Sistemas',
            'descripcion' => 'Carrera enfocada en el desarrollo de software y sistemas informáticos.',
            'estado' => true,
            'created_at' => now(),
            ],
            [
            'nombre' => 'Administración de Empresas',
            'descripcion' => 'Carrera orientada a la gestión y administración de organizaciones.',
            'estado' => true,
            'created_at' => now(),
            ],
            [
            'nombre' => 'Contabilidad',
            'descripcion' => 'Carrera centrada en la gestión financiera y contable de empresas.',
            'estado' => true,
            'created_at' => now(),
            ],
            [
            'nombre' => 'Derecho',
            'descripcion' => 'Carrera dedicada al estudio de las leyes y el sistema jurídico.',
            'estado' => true,
            'created_at' => now(),
            ],
            [
            'nombre' => 'Psicología',
            'descripcion' => 'Carrera enfocada en el estudio del comportamiento humano y la mente.',
            'estado' => true,
            'created_at' => now(),
            ],
        ]);
    }
}
