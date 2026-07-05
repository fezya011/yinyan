<?php
// app/Services/SearchService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class SearchService
{
    private const LIMIT = 6;

    public function search(string $query): Collection
    {
        return Product::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('card_subtitle', 'like', "%{$query}%")
                    ->orWhere('barcode', 'like', "%{$query}%");
            })
            ->limit(self::LIMIT)
            ->get([
                'id',
                'name',
                'slug',
                'wholesale_price',
                'retail_price',
                'main_image'
            ]);
    }

    /**
     * Поиск с дополнительными фильтрами (если понадобится).
     */
    public function advancedSearch(array $params): Collection
    {
        $query = Product::where('status', 'active');

        if (!empty($params['query'])) {
            $searchTerm = $params['query'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if (!empty($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (!empty($params['min_price'])) {
            $query->where('wholesale_price', '>=', $params['min_price']);
        }

        return $query->limit($params['limit'] ?? self::LIMIT)->get();
    }
}
