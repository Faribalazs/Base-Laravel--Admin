<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PozicijaTemporary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pozicija_temporary', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_of_ponuda')->unsigned();
            $table->text('temporary_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pozicija_temporary');
    }
}
