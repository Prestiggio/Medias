<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Photos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ry_medias_medias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("owner_id", false, true); //user owner
            $table->string('title')->nullable();
            $table->string('descriptif')->nullable();
            $table->text("path");
            $table->enum("type", ['image','video','embed']);
            $table->float("height")->nullable();
            $table->char("mediable_type")->nullable();
            $table->integer("mediable_id", false, true)->nullable();
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
        Schema::drop('ry_medias_medias');
    }
}
