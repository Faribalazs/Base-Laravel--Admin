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
        Schema::create('custom_work_types', function (Blueprint $table) {
            $table->id()->startingValue(2000);
            $table->foreignIdFor(\App\Models\Worker::class,'worker_id')->constrained();
            $table->json('name');
            $table->tinyInteger('is_work_type_deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_work_types');
    }
};
