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
        Schema::create('tableros', function (Blueprint $table) {
            $table->id();
            // Cada tablero se relaciona con un sprint
            $table->foreignId('sprint_id')
                ->constrained('sprints')
                ->cascadeOnDelete();
            $table->string('nombre'); // Ejemplo: "Tablero de Sprint 1"
            $table->timestamps();

            // Se asegura que un sprint tenga únicamente un tablero
            $table->unique('sprint_id');
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
