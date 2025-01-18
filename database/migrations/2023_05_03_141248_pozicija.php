<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pozicija extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pozicija', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Default_subcategory::class,'subcategory_id')->constrained();
            $table->foreignIdFor(\App\Models\Units::class,'unit_id')->constrained()->references('id_unit')->cascadeOnDelete();
            $table->json('title');
            $table->json('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pozicija');
    }
}
