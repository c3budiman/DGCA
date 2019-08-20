<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserStep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('status_list', function (Blueprint $table) {
            $table->increments('kode_status');
            $table->string('keterangan');
            $table->timestamps();
      });

      DB::table('status_list')->insert([
        ['kode_status' => 1,'keterangan'  => 'Berhasil Mendaftar Awal'],
        ['kode_status' => 2,'keterangan'  => 'Berhasil Memverifikasi Email'],

        ['kode_status' => 3,'keterangan'  => 'Berhasil Mendaftarkan Identitas'],
        ['kode_status' => 4,'keterangan'  => 'Berhasil Mendaftarkan Drones %s'],
        ['kode_status' => 5,'keterangan'  => 'Berhasil Melakukan Assesment'],

        ['kode_status' => 6,'keterangan'  => 'Assesment telah dinilai oleh admin dan lulus'],
        ['kode_status' => 7,'keterangan'  => 'Assesment telah dinilai oleh admin dan tidak lulus'],

        ['kode_status' => 8,'keterangan' => 'Identitas remote pilot telah ditolak oleh admin'],
        ['kode_status' => 9,'keterangan' => 'Identitas remote pilot diterima oleh admin'],

        ['kode_status' => 10,'keterangan'  => 'Drone telah dinyatakan layak oleh admin'],
        ['kode_status' => 11,'keterangan'  => 'Drone telah dinyatakan tidak layak oleh admin'],
      ]);

      Schema::create('user_step', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('user_id')->nullable();
          $table->unsignedInteger('kode_status')->nullable();
          $table->string('status')->nullable();
          $table->boolean('softdelete')->default(0);
          $table->timestamps();

          $table->foreign('kode_status')->references('kode_status')->on('status_list');
      });

      Schema::table('user_step', function(Blueprint $kolom){
        $kolom->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_step');
        Schema::dropIfExists('status_list');
    }
}
