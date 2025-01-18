<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompanyData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('worker_id')->unsigned();
            $table->json('company_name');
            $table->json('country');
            $table->json('city');
            $table->string('zip_code');
            $table->json('address');
            $table->string('phone');
            $table->string('email');
            $table->string('pib');
            $table->string('maticni_broj');
            $table->string('tekuci_racun');
            $table->string('bank_name');
            $table->string('logo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_data');
    }
}
