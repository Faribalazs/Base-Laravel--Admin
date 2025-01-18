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
        Schema::create('free_trial', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Worker::class,'worker_id')->constrained();
            $table->tinyInteger('count_offers')->default(0);
            $table->tinyInteger('count_my_categories')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_trial');
    }
};
