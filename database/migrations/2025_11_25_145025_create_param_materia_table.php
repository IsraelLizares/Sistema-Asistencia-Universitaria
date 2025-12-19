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
        Schema::create('param_materia', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_materia');
            $table->string('codigo_materia')->unique();

            $table->unsignedBigInteger('id_carrera');

            $table->boolean('estado')->default(1);

            $table->timestamps();

            $table->foreign('id_carrera')->references('id')->on('param_carrera')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('param_materia');
    }
};
