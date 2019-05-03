<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Submenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('submenu', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('kepunyaan')->nullable();
        $table->string('nama');
        $table->string('link');
      });
      Schema::table('submenu', function(Blueprint $kolom){
      $kolom->foreign('kepunyaan')->references('id')->on('dashmenu')->onDelete('cascade')->onUpdate('cascade');
      });

      DB::table('submenu')->insert(
        array(
            'kepunyaan' => 5,
            'nama' => 'Menu Sidebar',
            'link' => '/sidebarsettings'
        )
      );
      DB::table('submenu')->insert(
        array(
            'kepunyaan' => 5,
            'nama' => 'Logo dan Favicon',
            'link' => '/logodanfavicon'
        )
      );
      DB::table('submenu')->insert(
        array(
            'kepunyaan' => 5,
            'nama' => 'Judul dan Slogan',
            'link' => '/juduldanslogan'
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
        Schema::dropIfExists('submenu');
    }
}
