<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('image');
            $table->text('description');
            //$table->timestamps();
        });

        DB::table('slider')->insert(
          array(
              'title' => '',
              'image' => '/gambar/bn1.jpg',
              'description' => ''
          )
        );
        DB::table('slider')->insert(
          array(
              'title' => '',
              'image' => '/gambar/bn2.jpg',
              'description' => ''
          )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slider');
    }
}
