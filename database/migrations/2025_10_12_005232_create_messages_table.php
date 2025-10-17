<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('content');

            $table->morphs('conversation');
            $table->morphs('sender');
            $table->enum('status', ['sent', 'received', 'read'])->default('sent');
            $table->timestamp('read_at')->nullable();
            $table->userstamps();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
