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
        Schema::create('param_turno', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_turno'); // mañana - tarde - noche
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('dias'); // Ej: L-M-M-J-V

            $table->boolean('estado')->default(1);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('param_turno');
    }
};
