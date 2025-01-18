<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SwapPonuda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swap_ponuda', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Worker::class,'worker_id')->constrained();
            $table->bigInteger('original_id')->unsigned();
            $table->bigInteger('swap_id')->unsigned();
            $table->json('temp_ponuda_name');
            $table->json('temp_note')->nullable();
            $table->json('temp_opis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swap_ponuda');
    }
}
