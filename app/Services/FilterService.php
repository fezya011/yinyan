<?php
// app/Services/FilterService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class FilterService
{
    public function prepareFilters(Request $request): array
    {
        return [
            'category' => $request->filled('category') && $request->category !== 'all'
                ? $request->category
                : null,
            // ✅ ПРАВИЛЬНО - ключ 'pack'
            'pack' => $request->filled('pack') && $request->pack !== 'all-pack'
                ? $request->pack
                : null,
            'cert' => $request->filled('cert') && $request->cert !== 'all-cert'
                ? $request->cert
                : null,
            'search' => $request->filled('search')
                ? $request->search
                : null,
            'price_from' => $request->filled('price_from')
                ? $request->price_from
                : null,
            'price_to' => $request->filled('price_to')
                ? $request->price_to
                : null,
            'weight_from' => $request->filled('weight_from')
                ? $request->weight_from
                : null,
            'weight_to' => $request->filled('weight_to')
                ? $request->weight_to
                : null,
            'shelf_life' => $request->filled('shelf_life')
                ? $request->shelf_life
                : null,
            'pieces_per_box' => $request->filled('pieces_per_box')
                ? $request->pieces_per_box
                : null,
            'sort' => $request->filled('sort')
                ? $request->sort
                : null,
        ];
    }

    public function getPackagingTypes(): array
    {
        return Product::where('status', 'active')
            ->whereNotNull('packaging_type')
            ->where('packaging_type', '!=', '')
            ->distinct()
            ->orderBy('packaging_type')
            ->pluck('packaging_type')
            ->toArray();
    }
}
