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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('cascade');
            $table->foreignId('receiver_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreignId('sender_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->enum('role', ['editor', 'viewer'])->default('viewer');
            $table->dateTime('expired_at');
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
