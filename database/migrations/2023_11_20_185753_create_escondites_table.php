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
        Schema::create('escondites', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['HO' , 'HQ'])->nullable(); //tipo de mapa
            
            $table->foreignId('gremio_id') // UNSIGNED BIG INT
                    ->nullable() // <-- IMPORTANTE: LA COLUMNA DEBE ACEPTAR NULL COMO VALOR VALIDO
                    ->constrained()  // <-- DEFINE LA RESTRICCION DE LLAVE FORANEA
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            
            $table->foreignId('mapa_id') // UNSIGNED BIG INT
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
        Schema::dropIfExists('escondites');
    }
};
