<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_sesion');
            $table->unsignedBigInteger('id_estudiante');

            $table->enum('estado_asistencia', ['presente', 'ausente', 'tardanza', 'justificado'])
                ->default('presente');

            $table->string('observacion')->nullable();

            $table->unsignedBigInteger('id_usuario_registro');

            $table->boolean('estado')->default(1);

            $table->timestamps();

            $table->foreign('id_sesion')->references('id')->on('sesiones')->onDelete('cascade');
            $table->foreign('id_estudiante')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->foreign('id_usuario_registro')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
