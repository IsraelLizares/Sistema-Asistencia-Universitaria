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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_user');

            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno')->nullable();
            $table->string('ci')->unique();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();

            $table->unsignedBigInteger('id_carrera');

            $table->enum('turno', ['mañana', 'noche']);

            $table->string('matricula')->unique();

            $table->string('genero')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('estado_academico')->nullable();
            $table->string('foto_url')->nullable();

            $table->boolean('estado')->default(1);

            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_carrera')->references('id')->on('param_carrera')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
