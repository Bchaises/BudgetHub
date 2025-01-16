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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->double('amount');
            $table->enum('status', ['debit', 'credit']);
            $table->dateTime('date');
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
        Schema::dropIfExists('transactions');
    }
};
