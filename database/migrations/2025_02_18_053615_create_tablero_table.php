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
        Schema::create('tablero', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // <- CREAS primero la columna
            $table->foreign('project_id')->references('id')->on('nuevo_proyecto')->onDelete('cascade'); // <- luego FOREIGN KEY
            $table->string('nombre');  // nombre del tablero
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tablero');
    }
};
