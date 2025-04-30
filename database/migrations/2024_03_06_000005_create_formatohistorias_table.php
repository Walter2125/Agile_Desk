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
        Schema::create('formatohistorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('estado')->default('Pendiente');
            $table->integer('sprint')->nullable();
            $table->integer('trabajo_estimado')->nullable();
            $table->string('responsable')->nullable();
            $table->enum('prioridad', ['Alta', 'Media', 'Baja'])->default('Media');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('columna_id')->nullable();
            $table->foreign('columna_id')->references('id')->on('columnas')->onDelete('cascade');
            $table->unsignedBigInteger('tablero_id'); // Nueva columna
            $table->foreign('tablero_id')->references('id')->on('tablero')->onDelete('cascade'); 
            $table->timestamps();

            $table->unique(['nombre', 'tablero_id'], 'formatohistorias_nombre_tablero_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formatohistorias');
        Schema::table('formatohistorias', function (Blueprint $table) {

        });
    }
};
