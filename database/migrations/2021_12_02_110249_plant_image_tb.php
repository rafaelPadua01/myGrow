<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlantImageTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	Schema::create('plant_images', function(Blueprint $table){
		$table->id();
		$table->string('name_image')->unique;
		$table->text('size');
		$table->text('type');
		$table->foreignId('id_user')->references('id')->on('users');
		$table->foreignId('id_plant')->references('id')->on('plants');
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
