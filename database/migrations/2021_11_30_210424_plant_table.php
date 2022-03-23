<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('plants', function(Blueprint $table){
            $table->id();
            $table->String('name');
      //      $table->String('image');
            $table->String('especie');
            $table->String('germinacao');
            $table->String('floracao');
            $table->foreignId('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('plants');
    }
}
