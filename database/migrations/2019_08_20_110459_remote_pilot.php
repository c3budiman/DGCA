<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemotePilot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('remote_pilot', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('user_id');
          $table->unsignedInteger('uas_regs');
          $table->string('nomor_pilot')->unique();
          $table->text('sertifikasi_pilot');
          $table->timestamps();
      });
      Schema::table('remote_pilot', function(Blueprint $kolom){
        $kolom->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
      });

      Schema::table('remote_pilot', function(Blueprint $kolom){
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
        Schema::dropIfExists('remote_pilot');
    }
}
