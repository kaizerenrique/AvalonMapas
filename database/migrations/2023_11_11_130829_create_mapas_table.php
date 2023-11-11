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
        Schema::create('mapas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //nombre del mapa
            $table->string('nivel'); //nivel o tier del mapa
            $table->enum('tipo',['Cruce' , 'Corredor' , 'Santuario' , 'Descanso'])->nullable(); //tipo de mapa
            $table->string('foto_mapa', 2048)->nullable();
            $table->string('slug');// slug para rutas

            $table->foreignId('user_id') // UNSIGNED BIG INT
                    ->nullable() // <-- IMPORTANTE: LA COLUMNA DEBE ACEPTAR NULL COMO VALOR VALIDO
                    ->constrained()  // <-- DEFINE LA RESTRICCION DE LLAVE FORANEA
                    ->onDelete('SET NULL')
                    ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapas');
    }
};
