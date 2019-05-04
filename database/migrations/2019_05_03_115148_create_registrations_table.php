<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('drone_id')->nullable();
            $table->unsignedInteger('uas_id')->nullable();
            $table->timestamps();
        });

        Schema::table('registrations', function(Blueprint $kolom){
          $kolom->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('registrations', function(Blueprint $kolom){
          $kolom->foreign('drone_id')->references('id')->on('drones')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('registrations', function(Blueprint $kolom){
          $kolom->foreign('uas_id')->references('id')->on('uas_regs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registrations');
    }
}
