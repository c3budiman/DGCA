<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Perusahaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_perusahaan')->unique();
            $table->string('nama_perusahaan')->unique();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->text('dokumen_siup')->nullable();
            $table->text('dokumen_ktp_penanggung')->nullable();
            $table->text('dokumen_npwp')->nullable();
            $table->boolean('softdelete')->default(0);
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
        //
        Schema::dropIfExists('perusahaan');
    }
}
