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
        Schema::create('lista_historias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('responsable')->nullable();
            $table->unsignedInteger('sprint')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_historias');
    }
};
