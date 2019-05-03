<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frontmenu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('method');
            $table->text('content');
            $table->timestamps();
        });

        DB::table('frontmenu')->insert([
            [
             'nama' => 'Beranda',
             'method' => 'home' ,
             'content' => ''
           ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('frontmenu');
    }
}
