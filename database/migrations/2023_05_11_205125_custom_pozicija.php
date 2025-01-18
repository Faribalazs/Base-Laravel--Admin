<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CustomPozicija extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_pozicija', function (Blueprint $table) {
            $table->id()->startingValue(20000);
            $table->foreignIdFor(\App\Models\Worker::class,'worker_id')->constrained();
            $table->bigInteger('custom_subcategory_id')->unsigned();
            $table->foreignIdFor(\App\Models\Units::class,'unit_id')->constrained()->references('id_unit')->cascadeOnDelete();
            $table->text('title');
            $table->text('description');
            $table->tinyInteger('is_pozicija_deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_pozicija');
    }
}
