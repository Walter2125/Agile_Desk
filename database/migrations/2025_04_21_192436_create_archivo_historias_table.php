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
        Schema::create('archivo_historias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historia_id');
            $table->timestamps();
        
            $table->foreign('historia_id')->references('id')->on('formatohistorias')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('archivo_historias');
    }
};
