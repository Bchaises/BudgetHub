<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->decimal('balance', 65, 30)->default(0.00);
            $table->string('description')->nullable();
            $table->text('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
