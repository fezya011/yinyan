<?php
// app/Http/Controllers/Web/BasePageController.php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

abstract class BasePageController extends Controller
{
    /**
     * Форматирование цены продукта.
     */
    protected function formatProductPrice(Product $product): array
    {
        if ($product->wholesale_price) {
            return [
                'price' => 'от ' . number_format($product->wholesale_price, 0, '.', ' ') . ' ₽',
                'price_note' => 'оптовая цена',
            ];
        }

        if ($product->retail_price) {
            return [
                'price' => 'от ' . number_format($product->retail_price, 0, '.', ' ') . ' ₽',
                'price_note' => 'розничная цена',
            ];
        }

        if ($product->price_display) {
            return [
                'price' => $product->price_display,
                'price_note' => 'цена указана',
            ];
        }

        return [
            'price' => 'Цена по запросу',
            'price_note' => 'уточняйте',
        ];
    }

    /**
     * Формирование данных для карточки товара.
     */
    protected function formatProductCard(Product $product): array
    {
        $priceData = $this->formatProductPrice($product);

        return [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
            'emoji' => $product->emoji_icon ?? '📦',
            'tag' => $product->tag ?? $product->category?->tag_prefix ?? 'В наличии',
            'desc' => $product->card_subtitle ?? $product->description ?? '',
            'accent' => $product->accent_color ?? '#FF6B00',
            'price' => $priceData['price'],
            'price_note' => $priceData['price_note'],
            'packaging_type' => $product->packaging_type,
            'has_eac' => $product->has_eac,
            'has_honest_sign' => $product->has_honest_sign,
        ];
    }
}
