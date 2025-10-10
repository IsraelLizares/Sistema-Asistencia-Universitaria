<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estudiante', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('ap_paterno', 50);
            $table->string('ap_materno', 50)->nullable();
            $table->string('ci', 20)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->foreignId('id_carrera')->constrained('carrera');
            $table->enum('turno', ['mañana', 'noche']);
            $table->string('matricula', 30)->unique();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante');
    }
};
