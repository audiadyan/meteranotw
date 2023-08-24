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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('meter_id');
            $table->float('kwhAdd');
            $table->float('kwhPrev');
            $table->float('kwhCurr');
            $table->string('price');
            $table->boolean('status');
            $table->timestamp('time');

            $table->foreign('meter_id')->references('id')->on('kwh_meters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
