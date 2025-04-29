<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('formatohistorias', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->after('tablero_id');
            $table->foreign('project_id')->references('id')->on('nuevo_proyecto')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('formatohistorias', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
};
