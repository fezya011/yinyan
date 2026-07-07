<?php
// database/migrations/2026_xx_xx_xxxxxx_create_notification_emails_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->string('name')->nullable(); // Имя получателя
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_emails');
    }
};
