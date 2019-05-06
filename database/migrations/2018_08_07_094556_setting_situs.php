<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingSitus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('setting_situses', function (Blueprint $table) {
             $table->increments('id');
             $table->string('namaSitus');
             $table->string('slogan');
             $table->string('favicon');
             $table->string('logo');
             $table->string('alamatSitus');
             $table->string('footer');
             $table->timestamps();
         });
         DB::table('setting_situses')->insert([
             [
              'namaSitus' => 'DGCA',
              'slogan' => 'Pendaftaran, Drone dan Lisensi Pilot.' ,
              'favicon' => '/gambar/logo.png',
              'logo' => 'https://imsis-djpu.dephub.go.id/regdrone/assets/web/images/logo22.png',
              'alamatSitus' => 'http://localhost:8000',
              'footer' => '2019 © Copyright <strong>DGCA</strong>. All Rights Reserved'
            ],
         ]);
     }

     public function down()
     {
         Schema::dropIfExists('setting_situses');
     }
}
