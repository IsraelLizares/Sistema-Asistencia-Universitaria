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
        Schema::create('param_aula', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_aula');
            $table->integer('capacidad')->default(30);
            $table->enum('tipo', ['teorica', 'laboratorio'])->default('teorica');

            $table->boolean('estado')->default(1);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('param_aula');
    }
};
