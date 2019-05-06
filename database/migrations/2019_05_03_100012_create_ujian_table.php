<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ujian_regs');
            $table->unsignedInteger('id_soal');
            $table->unsignedInteger('user_id');
            $table->text('jawaban')->nullable();
            $table->integer('satisfy')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });

        Schema::table('ujian', function(Blueprint $kolom){
          $kolom->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('ujian', function(Blueprint $kolom){
          $kolom->foreign('ujian_regs')->references('id')->on('uas_regs')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('ujian', function(Blueprint $kolom){
          $kolom->foreign('id_soal')->references('id')->on('soal')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('uas_regs');
    }
}
