<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable();
            $table->double('amount');
            $table->date('date');
            $table->foreignId('account_id')->constrained(
                table: 'account',
                column: 'id'
            );
            $table->foreignId('category_id')->constrained(
                table: 'transaction_category',
                column: 'id'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
