<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fizicka_lica_temporary', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Worker::class,'worker_id')->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('city');
            $table->string('zip_code');
            $table->string('address');
            $table->string('email');
            $table->string('tel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fizicka_lica_temporary');
    }
};
