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
              'namaSitus'   => 'DGCA',
              'slogan'      => 'Pendaftaran, Drone dan Lisensi Pilot.' ,
              'favicon'     => '/gambar/logo.png',
              'logo'        => 'https://imsis-djpu.dephub.go.id/regdrone/assets/web/images/logo22.png',
              'alamatSitus' => 'http://localhost:8000',
              'footer'      => '2019 © Copyright <strong>DGCA</strong>. All Rights Reserved'
            ],
         ]);

         Schema::create('persetujuan', function (Blueprint $table) {
             $table->increments('id');
             $table->string('method');
             $table->string('title');
             $table->text('content');
             $table->timestamps();
         });

         DB::table('persetujuan')->insert([
             [
              'method' => 'Persetujuan Pendaftaran Remote Pilot',
              'title' => 'RemotePilotAggreement' ,
              'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
            ],
         ]);
     }

     public function down()
     {
         Schema::dropIfExists('setting_situses');
         Schema::dropIfExists('persetujuan');
     }
}
