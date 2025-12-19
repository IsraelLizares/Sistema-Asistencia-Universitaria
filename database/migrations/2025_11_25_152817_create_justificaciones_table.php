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
        Schema::create('justificaciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_asistencia');

            $table->string('motivo');
            $table->string('documento_url')->nullable();

            $table->enum('estado_justificacion', ['pendiente', 'aceptada', 'rechazada'])
                ->default('pendiente');

            $table->date('fecha_solicitud');
            $table->date('fecha_resolucion')->nullable();

            $table->unsignedBigInteger('id_usuario_revisor')->nullable();

            $table->boolean('estado')->default(1);

            $table->timestamps();

            $table->foreign('id_asistencia')->references('id')->on('asistencias')->onDelete('cascade');
            $table->foreign('id_usuario_revisor')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('justificaciones');
    }
};
