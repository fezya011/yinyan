<?php
// database/migrations/2024_xx_xx_xxxxxx_add_logistic_and_price_fields_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ===== НОВЫЕ ПОЛЯ =====

            // Штрих-код
            $table->string('barcode', 50)->nullable()->unique()->after('flavors');

            // Логистика
            $table->decimal('box_volume', 10, 3)->nullable()->after('weight_grams'); // Объём коробки (м³)
            $table->decimal('box_weight_kg', 8, 2)->nullable()->after('box_volume'); // Вес коробки (кг)

            // Налоги и коды
            $table->decimal('vat_rate', 5, 2)->nullable()->after('box_weight_kg'); // Ставка НДС (%)
            $table->string('tnved_code', 20)->nullable()->after('vat_rate'); // Код ТНВЭД

            // Дополнительные цены
            $table->decimal('distributor_price', 12, 2)->nullable()->after('retail_price'); // Цена Дистрибьютор
            $table->decimal('cost_price', 12, 2)->nullable()->after('distributor_price'); // Себестоимость

            // Комментарий
            $table->text('comment')->nullable()->after('meta_description');

            // ===== ИНДЕКСЫ =====
            $table->index('barcode');
            $table->index('tnved_code');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'barcode',
                'box_volume',
                'box_weight_kg',
                'vat_rate',
                'tnved_code',
                'distributor_price',
                'cost_price',
                'comment',
            ]);
        });
    }
};
