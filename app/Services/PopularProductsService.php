<?php
// app/Services/PopularProductsService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class PopularProductsService
{
    public function getProducts(int $limit = 8): Collection
    {
        $products = Product::with('category')
            ->where('status', 'active')
            ->orderByDesc('views_count')
            ->limit($limit)
            ->get();

        if ($products->isEmpty()) {
            $products = Product::where('status', 'active')
                ->orderBy('sort_order')
                ->limit($limit)
                ->get();
        }

        return $products;
    }
}
