<?php
// app/Http/Controllers/Web/SearchController.php

namespace App\Http\Controllers\Web;

use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends BasePageController
{
    public function __construct(
        private readonly SearchService $searchService
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!$request->filled('query')) {
            return response()->json([]);
        }

        $products = $this->searchService->search($request->query);

        return response()->json(
            $products->map(fn($product) => $this->formatSearchResult($product))
        );
    }

    private function formatSearchResult($product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => number_format($product->wholesale_price ?? 0, 0, '.', ' '),
            'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
            'url' => route('product', $product->slug),
        ];
    }
}
