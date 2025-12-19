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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_docente');
            $table->unsignedBigInteger('id_turno');
            $table->unsignedBigInteger('id_aula');

            $table->unsignedBigInteger('id_semestre');


            $table->boolean('estado')->default(1);

            $table->timestamps();

            $table->foreign('id_semestre')->references('id')->on('param_semestre');
            $table->foreign('id_materia')->references('id')->on('param_materia')->onDelete('cascade');
            $table->foreign('id_docente')->references('id')->on('docentes')->onDelete('cascade');
            $table->foreign('id_turno')->references('id')->on('param_turno')->onDelete('cascade');
            $table->foreign('id_aula')->references('id')->on('param_aula')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
