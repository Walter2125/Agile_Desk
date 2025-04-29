<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdToHistorialcambiosTable extends Migration
{
    public function up()
    {
        Schema::table('historialcambios', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('nuevo_proyecto')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('historialcambios', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
} 