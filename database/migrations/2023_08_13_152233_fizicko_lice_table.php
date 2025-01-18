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
        Schema::create('fizicka_lica', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Worker::class,'worker_id')->constrained();
            $table->json('first_name');
            $table->json('last_name');
            $table->json('city');
            $table->integer('zip_code');
            $table->json('address');
            $table->string('email');
            $table->string('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fizicka_lica');
    }
};
