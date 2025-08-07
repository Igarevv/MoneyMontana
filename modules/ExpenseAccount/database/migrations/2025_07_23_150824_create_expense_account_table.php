<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_accounts', static function (Blueprint $table) {
            $table->unsignedBigInteger('id')->generatedAs()->always()->primary();
            $table->string('label');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('amount')->default(0);
            $table->char('currency', 3)->default('USD');
            $table->tinyInteger('duration_type')->nullable();
            $table->unsignedInteger('duration_value')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_accounts');
    }
};
