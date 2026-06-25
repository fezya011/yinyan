<?php
// database/migrations/2024_01_01_000002_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');

            // Основная информация
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Информация для карточки товара (как на главной)
            $table->string('card_subtitle')->nullable(); // "Говядина или курица. Удобная упаковка."
            $table->string('emoji_icon')->nullable(); // 🍜, 🥣, 🥟, 🍚
            $table->string('tag')->nullable(); // "Хит продаж", "Новинка"
            $table->string('accent_color', 7)->nullable(); // #83BF32

            // Характеристики
            $table->string('packaging_type')->nullable(); // "Стакан"
            $table->json('flavors')->nullable(); // ["Говядина", "Курица"]
            $table->decimal('weight_grams', 8, 2)->nullable();
            $table->integer('pieces_per_box')->nullable();
            $table->integer('boxes_per_pallet')->nullable();
            $table->integer('shelf_life_days')->nullable();

            // Цены
            $table->decimal('retail_price', 12, 2)->nullable();
            $table->decimal('wholesale_price', 12, 2)->nullable();
            $table->decimal('min_order_amount', 12, 2)->default(100000);
            $table->string('price_display')->nullable(); // "от 45 ₽ / шт"

            // Изображения
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();

            // Сертификация
            $table->boolean('has_eac')->default(true);
            $table->boolean('has_honest_sign')->default(true);
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Статистика
            $table->integer('views_count')->default(0);
            $table->integer('orders_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
