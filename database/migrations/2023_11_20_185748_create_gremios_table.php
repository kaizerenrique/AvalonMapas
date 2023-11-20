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
        Schema::create('gremios', function (Blueprint $table) {
            $table->id();
            $table->string('id_albion_gremio'); //id del gremio generado por albion
            $table->string('nombre_gremio'); //nombre del gremio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gremios');
    }
};
