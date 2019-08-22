<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AutoIncrement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_seq', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('increment_remote_pilot');
            $table->unsignedInteger('increment_drone');
            $table->timestamps();
        });

        DB::table('auto_seq')->insert(
          array(
              'increment_remote_pilot' => 1,
              'increment_drone' => 1,
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
        Schema::dropIfExists('auto_seq');
    }
}
