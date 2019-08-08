<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('active', 2);
            $table->string('approved', 2);
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('dokumen_sertifikasi')->nullable();
            $table->text('dokumen_identitas')->nullable();
            $table->unsignedInteger('roles_id')->nullable();
            $table->unsignedInteger('uas_id')->nullable();
            $table->string('avatar');
            $table->string('password', 60);
            $table->string('verif_token')->nullable();
            $table->string('api_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function(Blueprint $kolom) {
          $kolom->increments('id');
          $kolom->string('namaRule');
        });

        Schema::table('users', function(Blueprint $kolom){
          $kolom->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');
        });

        DB::table('roles')->insert(
          ['id' => 1, 'namaRule' => 'Super Admin']
        );
        DB::table('roles')->insert(
          ['id' => 2, 'namaRule' => 'Admin']
        );
        DB::table('roles')->insert(
          ['id' => 3, 'namaRule' => 'Pengguna']
        );

        DB::table('users')->insert(
          array(
              'nama' => 'Cecep Budiman',
              'email' => 'c3budiman@gmail.com',
              'roles_id' => 1,
              'avatar' => '/gambar/avatar.png',
              'password' => '$2y$10$31eYZUJ169CnT/tPGZFMGe5bMWezB5o8XNGKms4eI98o3M.pCvBZm',
              'active' => '1',
              'verif_token' => '',
              'api_token' => ''
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
         Schema::dropIfExists('users');
         Schema::dropIfExists('roles');
     }
}
