<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('formatohistorias', function (Blueprint $table) {
            $table->unsignedBigInteger('sprint_id')->nullable()->after('tablero_id');
            $table->foreign('sprint_id')
                  ->references('id')
                  ->on('sprints')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('formatohistorias', function (Blueprint $table) {
            $table->dropForeign(['sprint_id']);
            $table->dropColumn('sprint_id');
        });
    }
};
