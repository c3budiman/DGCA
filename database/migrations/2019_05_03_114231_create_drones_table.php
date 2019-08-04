<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDronesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('status')->nullable();
            $table->unsignedInteger('uas_id')->nullable();

            //drone bio :
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('specific_model')->nullable();
            $table->string('model_year')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('condition')->nullable();
            $table->string('max_weight_take_off')->nullable();

            //kepemilikan UAS
            $table->string('termofowenership')->nullable();
            $table->string('owner')->nullable();
            $table->string('address')->nullable();
            $table->string('evidenceofowenership')->nullable();
            $table->string('dateownership')->nullable();

            //penguasaan uas
            $table->string('termofposession')->nullable();
            $table->string('reference')->nullable();
            $table->string('namapemberisewa')->nullable();
            $table->string('alamatpemberisewa')->nullable();
            $table->string('emailpemberisewa')->nullable();
            $table->string('nomorteleponpemberisewa')->nullable();

            //berkas :
            $table->string('pic_of_drones')->nullable();
            $table->string('pic_of_drones_with_sn')->nullable();
            $table->string('scan_proof_of_ownership')->nullable();
            $table->string('proof_of_ownership')->nullable();

            // $table->string('date_of_proof')->nullable();
            //
            //
            // //conditional :
            // $table->string('term_possession')->nullable();
            // $table->string('aggreement_on_possession')->nullable();
            // $table->string('leaser_name')->nullable();
            // $table->string('leaser_address')->nullable();
            // $table->string('leaser_email')->nullable();
            // $table->string('leaser_phone')->nullable();
            // $table->string('lessee_type')->nullable();
            // $table->string('lessee_address')->nullable();
            // $table->string('lessee_email')->nullable();
            // $table->string('lessee_phone')->nullable();
            $table->string('approval')->default(0);
            $table->boolean('softdelete')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('drones', function(Blueprint $kolom){
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
        Schema::drop('drones');
    }
}
