<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlbumImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('album_images', function(Blueprint $table){
            $table->id();
            $table->string('image_name');
            $table->string('image_size');
            $table->string('image_extension');
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_album')->references('id')->on('album_plants');
            $table->timeStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
