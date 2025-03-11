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
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historia_id')->constrained('historias_usuarios')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->string('estado', 50)->check("estado IN ('Activo', 'En Proceso', 'Terminado')");
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};