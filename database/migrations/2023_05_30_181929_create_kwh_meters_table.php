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
        Schema::create('kwh_meters', function (Blueprint $table) {
            $table->string('id', 12)->primary();
            $table->float('kwh');
            $table->float('kwhUsed');
            $table->string('password');
            $table->string('accessCode', 10);
            $table->string('name')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamp('updated_at');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kwh_meters');
    }
};
