<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_child', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->integer('index');
            $table->integer('aktif')->nullable();
            $table->text('soal')->nullable();
            $table->string('change_by')->nullable();
            $table->timestamps();
        });

        Schema::table('soal_child', function(Blueprint $kolom){
          $kolom->foreign('parent_id')->references('id')->on('soal_parent')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('soal_child');
    }
}
