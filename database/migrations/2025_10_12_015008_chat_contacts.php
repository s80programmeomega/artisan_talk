<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->userstamps();
            $table->timestamps();

            $table->unique(['chat_id', 'contact_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_contacts');
    }
};
