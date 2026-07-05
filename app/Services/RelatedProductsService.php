<?php
// app/Services/RelatedProductsService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class RelatedProductsService
{
    public function getForProduct(Product $product, int $limit = 4): Collection
    {
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit($limit)
            ->get();
    }
}
