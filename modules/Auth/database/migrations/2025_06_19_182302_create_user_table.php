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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->generatedAs()->always();
            $table->uuid('user_id')->unique();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->char('country_code', 2);
            $table->char('currency_code', 3);
            $table->char('preferred_theme', 10)->default('light');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
