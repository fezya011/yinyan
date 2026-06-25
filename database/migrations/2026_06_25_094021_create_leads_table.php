<?php
// database/migrations/2024_01_01_000003_create_leads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Контактные данные
            $table->string('name'); // ФИО
            $table->string('phone')->nullable();;
            $table->string('email')->nullable();

            // Информация о заявке
            $table->text('message')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->json('interested_products')->nullable();
            $table->decimal('estimated_budget', 12, 2)->nullable();
            $table->string('delivery_city')->nullable();

            // Статус
            $table->enum('status', [
                'new', 'contacted', 'qualified', 'proposal_sent',
                'negotiation', 'won', 'lost', 'spam'
            ])->default('new');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
