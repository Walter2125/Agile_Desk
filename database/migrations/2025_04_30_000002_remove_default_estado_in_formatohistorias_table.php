<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('formatohistorias', function (Blueprint $table) {
            $table->string('estado')->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('formatohistorias', function (Blueprint $table) {
            $table->string('estado')->default('Pendiente')->change();
        });
    }
};
