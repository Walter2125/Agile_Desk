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
        Schema::create('historias_usuarios', function (Blueprint $table) {
            $table->id();
            // Si tienes una tabla 'sprints', mantén la FK. Si no, ponlo como nullable o quítalo.
            $table->foreignId('sprint_id')->nullable()->constrained('sprints')->onDelete('cascade');

            $table->string('titulo', 255);      // Equivale a 'nombreHistoria'
            $table->text('descripcion')->nullable();
            
            // Campos extra que usas en los formularios
            $table->integer('trabajo_estimado')->nullable();
            $table->string('responsable')->nullable();
            // Alta, Media, Baja
            $table->string('prioridad')->default('Media');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias_usuarios');
    }
};

/*
return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('historias_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->constrained('sprints')->onDelete('cascade');
            $table->string('titulo', 255);
            $table->text('descripcion');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('historias_usuarios');
    }
};

*/