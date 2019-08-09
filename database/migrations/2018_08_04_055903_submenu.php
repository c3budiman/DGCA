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

      DB::table('submenu')->insert([
          ['kepunyaan' => 5, 'nama' => 'Menu Sidebar',          'link' => '/sidebarsettings'],
          ['kepunyaan' => 5, 'nama' => 'Logo dan Favicon',      'link' => '/logodanfavicon'],
          ['kepunyaan' => 5, 'nama' => 'Judul dan Slogan',      'link' => '/juduldanslogan'],
          ['kepunyaan' => 8, 'nama' => 'Soal UAS Assessment',   'link' => '/parameter/soal'],
          ['kepunyaan' => 9, 'nama' => 'Approval Remote Pilot', 'link' => '/approveidentitas'],
          ['kepunyaan' => 9, 'nama' => 'Approval Drones',       'link' => '/approvedrones'],
      ]);
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
