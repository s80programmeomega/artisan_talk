<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contact_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->unique(['user_id', 'email', 'phone']);
            $table->userstamps();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
