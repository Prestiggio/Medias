<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Resizings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ry_medias_resizings', function (Blueprint $table) {
            $table->increments('id');
            $table->char("filename");
            $table->char("type", 10);
            $table->float("width");
            $table->float("height");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ry_medias_resizings');
    }
}
