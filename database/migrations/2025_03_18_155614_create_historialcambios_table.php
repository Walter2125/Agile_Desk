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
        Schema::create('historialcambios', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha'); // Columna para almacenar la fecha del cambio
            $table->string('usuario'); // Columna para el nombre del usuario
            $table->string('accion'); // Columna para el tipo de acción (Creación, Edición, Eliminación)
            $table->text('detalles'); // Columna para detalles sobre el cambio
            $table->unsignedBigInteger('sprint')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historialcambios');
    }
};
