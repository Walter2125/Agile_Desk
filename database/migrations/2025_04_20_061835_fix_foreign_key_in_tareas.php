<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropForeign(['historia_id']);
            $table->foreign('historia_id')->references('id')->on('formatohistorias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropForeign(['historia_id']);
            $table->foreign('historia_id')->references('id')->on('historias')->onDelete('cascade');
        });
    }
};
