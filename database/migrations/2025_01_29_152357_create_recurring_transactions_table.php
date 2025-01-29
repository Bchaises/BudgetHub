<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->double('amount');
            $table->enum('status', ['debit', 'credit']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'yearly']);
            $table->foreignId('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->foreignId('category_id')
                ->nullable()
                ->references('id')
                ->on('transaction_categories')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recuringTransactions');
    }
};
