<?php
// app/Http/Controllers/Web/PageController.php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class PageController extends Controller
{
    public function home()
    {
        // Получаем товары для карусели
        $carouselProducts = Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get();

        // Если избранных меньше 3, добираем обычными
        if ($carouselProducts->count() < 3) {
            $additional = Product::with('category')
                ->where('status', 'active')
                ->where('is_featured', false)
                ->orderBy('sort_order')
                ->limit(5 - $carouselProducts->count())
                ->get();

            $carouselProducts = $carouselProducts->merge($additional);
        }

        $slides = $carouselProducts->map(function($product) {
            // Формируем цену - приоритет оптовой цене
            if ($product->wholesale_price) {
                $price = 'от ' . number_format($product->wholesale_price, 0, '.', ' ') . ' ₽';
                $priceNote = 'оптовая цена';
            } elseif ($product->retail_price) {
                $price = 'от ' . number_format($product->retail_price, 0, '.', ' ') . ' ₽';
                $priceNote = 'розничная цена';
            } elseif ($product->price_display) {
                $price = $product->price_display;
                $priceNote = 'цена указана';
            } else {
                $price = 'Цена по запросу';
                $priceNote = 'уточняйте';
            }

            return [
                'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
                'emoji' => $product->emoji_icon ?? '📦',
                'tag' => $product->tag ?? $product->category->tag_prefix ?? 'В наличии',
                'name' => $product->name,
                'desc' => $product->card_subtitle ?? $product->description ?? '',
                'price' => $price,
                'price_note' => $priceNote,
                'accent' => $product->accent_color ?? '#FF6B00',
            ];
        });

        // Если слайдов нет — создаём заглушку
        if ($slides->isEmpty()) {
            $slides = collect([
                [
                    'image' => null,
                    'emoji' => '📦',
                    'tag' => 'Скоро',
                    'name' => 'Товары добавляются',
                    'desc' => 'Следите за обновлениями каталога',
                    'price' => 'скоро',
                    'price_note' => 'ожидайте',
                    'accent' => '#FF6B00',
                ]
            ]);
        }

        return view('index', compact('slides'));
    }
}
