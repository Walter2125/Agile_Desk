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
        // Verifica si la columna existe antes de intentar crearla
        if (!Schema::hasColumn('formatohistorias', 'project_id')) {
            Schema::table('formatohistorias', function (Blueprint $table) {
                $table->unsignedBigInteger('project_id')->nullable()->after('tablero_id');
                $table->foreign('project_id')->references('id')->on('nuevo_proyecto')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Solo elimina la columna si existe
        if (Schema::hasColumn('formatohistorias', 'project_id')) {
            Schema::table('formatohistorias', function (Blueprint $table) {
                $table->dropForeign(['project_id']);
                $table->dropColumn('project_id');
            });
        }
    }
};