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
            $table->string('nombre');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('estado')->default('nuevo');
            $table->string('color')->default('#0d6efd');
            $table->string('tipo')->default('meeting');
            $table->text('descripcion')->nullable();
            $table->boolean('todo_el_dia')->default(false);
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('nuevo_proyecto')->onDelete('cascade');
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