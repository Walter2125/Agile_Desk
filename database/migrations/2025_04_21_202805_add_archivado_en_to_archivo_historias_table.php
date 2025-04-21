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
    Schema::table('archivo_historias', function (Blueprint $table) {
        $table->timestamp('archivado_en')->nullable();
    });
}

public function down()
{
    Schema::table('archivo_historias', function (Blueprint $table) {
        $table->dropColumn('archivado_en');
    });
}
};
