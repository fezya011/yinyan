<?php
// app/Services/CarouselService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CarouselService
{
    private const MIN_SLIDES = 3;
    private const MAX_SLIDES = 5;

    public function getSlides(): Collection
    {
        $products = $this->getFeaturedProducts();
        $products = $this->fillWithRegular($products);

        return $this->formatSlides($products);
    }

    private function getFeaturedProducts(): Collection
    {
        return Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(self::MAX_SLIDES)
            ->get();
    }

    private function fillWithRegular(Collection $products): Collection
    {
        if ($products->count() < self::MIN_SLIDES) {
            $additional = Product::with('category')
                ->where('status', 'active')
                ->where('is_featured', false)
                ->orderBy('sort_order')
                ->limit(self::MAX_SLIDES - $products->count())
                ->get();

            $products = $products->merge($additional);
        }

        return $products;
    }

    private function formatSlides(Collection $products): Collection
    {
        $slides = $products->map(function($product) {
            $priceData = $this->formatPrice($product);

            return [
                'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
                'emoji' => $product->emoji_icon ?? '📦',
                'tag' => $product->tag ?? $product->category?->tag_prefix ?? 'В наличии',
                'name' => $product->name,
                'desc' => $product->card_subtitle ?? $product->description ?? '',
                'price' => $priceData['price'],
                'price_note' => $priceData['note'],
                'accent' => $product->accent_color ?? '#FF6B00',
            ];
        });

        return $slides->isNotEmpty() ? $slides : $this->getEmptySlide();
    }

    private function formatPrice(Product $product): array
    {
        if ($product->wholesale_price) {
            return [
                'price' => 'от ' . number_format($product->wholesale_price, 0, '.', ' ') . ' ₽',
                'note' => 'оптовая цена',
            ];
        }

        if ($product->retail_price) {
            return [
                'price' => 'от ' . number_format($product->retail_price, 0, '.', ' ') . ' ₽',
                'note' => 'розничная цена',
            ];
        }

        if ($product->price_display) {
            return [
                'price' => $product->price_display,
                'note' => 'цена указана',
            ];
        }

        return [
            'price' => 'Цена по запросу',
            'note' => 'уточняйте',
        ];
    }

    private function getEmptySlide(): Collection
    {
        return collect([
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
}
