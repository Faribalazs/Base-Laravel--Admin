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
        Schema::create('worker_tracker', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('hits');
            $table->string('device');
            $table->string('browser');
            $table->date('visit_date');
            $table->time('visit_time');
            $table->unique(array('ip', 'visit_date'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_tracker');
    }
};
