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
        Schema::create('sesiones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_grupo');
            $table->date('fecha');

            $table->string('tema')->nullable();
            $table->enum('tipo_sesion', ['virtual', 'presencial'])->default('presencial');

            $table->enum('estado_sesion', ['programada', 'realizada', 'cancelada'])
                ->default('programada');

            $table->string('observacion')->nullable();

            $table->boolean('estado')->default(1);

            $table->timestamps();

            $table->foreign('id_grupo')->references('id')->on('grupos')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesiones');
    }
};
