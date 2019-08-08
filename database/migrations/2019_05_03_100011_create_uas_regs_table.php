<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUasRegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uas_regs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('nilai');
            $table->integer('status');
            $table->string('change_by')->nullable();
            $table->text('backup_soal');
            $table->text('backup_jawaban');
            $table->timestamps();
        });

        Schema::table('uas_regs', function(Blueprint $kolom){
          $kolom->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

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

        Schema::drop('ujian');
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
