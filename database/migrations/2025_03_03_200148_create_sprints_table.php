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
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('estado', 50)->check("estado IN ('PLANEADO', 'EN CURSO', 'FINALIZADO')");
            $table->foreignId('proyecto_id')->constrained();
            $table->string('responsable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprints');
    }
};
