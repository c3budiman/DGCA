<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegisteredDrone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('registered_drone', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->unsignedInteger('uas_regs');
          $table->string('nomor_drone')->unique();
          $table->text('sertifikasi_drone');
          $table->timestamps();
      });

      Schema::table('registered_drone', function(Blueprint $kolom){
        $kolom->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
      });

      Schema::table('registered_drone', function(Blueprint $kolom){
        $kolom->foreign('uas_regs')->references('id')->on('uas_regs')->onDelete('cascade')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_seq');
        Schema::dropIfExists('remote_pilot');
    }
}
