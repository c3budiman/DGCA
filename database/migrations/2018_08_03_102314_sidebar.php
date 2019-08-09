<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sidebar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('dashmenu', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('kepunyaan')->nullable();
        $table->string('class_css');
        $table->string('nama');
        $table->string('link');
      });

      Schema::table('dashmenu', function(Blueprint $kolom){
        $kolom->foreign('kepunyaan')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
      });

      DB::table('dashmenu')->insert([
          ['kepunyaan' => 1, 'class_css' => 'dripicons-home',           'nama' => 'Home',                'link' => '/dashboard'],
          ['kepunyaan' => 1, 'class_css' => 'dripicons-browser',        'nama' => 'Frontend`s Menu',     'link' => '/front'],
          ['kepunyaan' => 1, 'class_css' => 'dripicons-lock',           'nama' => 'Roles',               'link' => '/roles'],
          ['kepunyaan' => 1, 'class_css' => 'dripicons-user-group',     'nama' => 'Pengguna',            'link' => '/manageuser'],
          ['kepunyaan' => 1, 'class_css' => 'dripicons-device-desktop', 'nama' => 'Website',             'link' => '/manageweb'],
          ['kepunyaan' => 2, 'class_css' => 'dripicons-home',           'nama' => 'Home',                'link' => '/dashboard'],
          ['kepunyaan' => 2, 'class_css' => 'dripicons-browser',        'nama' => 'Frontend`s Menu',     'link' => '/front'],
          ['kepunyaan' => 2, 'class_css' => 'fa fa-car',                'nama' => 'Parameter',           'link' => '/params'],
          ['kepunyaan' => 2, 'class_css' => 'fa fa-list-ul',            'nama' => 'Approval',            'link' => '/approval'],
          ['kepunyaan' => 3, 'class_css' => 'dripicons-home',           'nama' => 'Home',                'link' => '/dashboard'],
          ['kepunyaan' => 3, 'class_css' => 'dripicons-clipboard',      'nama' => 'UAS Assesment',       'link' => '/uas_assesment'],
          ['kepunyaan' => 3, 'class_css' => 'dripicons-user',           'nama' => 'Remote Pilot',        'link' => '/identitas'],
          ['kepunyaan' => 3, 'class_css' => 'dripicons-rocket',         'nama' => 'Drones',              'link' => '/drones'],
      ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
         Schema::dropIfExists('dashmenu');
     }
}
