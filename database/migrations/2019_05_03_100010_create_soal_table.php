<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoalParentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal_parent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('index');
            $table->integer('aktif')->nullable();
            $table->text('soal')->nullable();
            $table->string('change_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('soal_parent');
    }
}
