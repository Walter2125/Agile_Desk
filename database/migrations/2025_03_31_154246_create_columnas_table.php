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
        Schema::create('columnas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tablero_id')->constrained('tableros')->onDelete('cascade');
            $table->string('nombre'); // nombre de la columna
            $table->integer('orden')->default(0); // campo para el orden de columnas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('columnas');
    }

};
