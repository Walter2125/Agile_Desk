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
        Schema::create('columnas', function (Blueprint $table) {
            $table->id();
            // Relación con el tablero del sprint
            $table->foreignId('tablero_id')
                ->constrained('tableros')
                ->cascadeOnDelete();
            $table->string('nombre'); // Ejemplo: "Backlog", "En Progreso", "Terminado"
            $table->integer('position')->default(0); // Para ordenar las columnas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columnas');
    }
};
