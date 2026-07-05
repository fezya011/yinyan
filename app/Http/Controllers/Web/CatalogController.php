<?php
// app/Http/Controllers/Web/CatalogController.php

namespace App\Http\Controllers\Web;

use App\Services\CatalogService;
use App\Services\CategoryService;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class CatalogController extends BasePageController
{
    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly CategoryService $categoryService,
        private readonly FilterService $filterService
    ) {}

    public function __invoke(Request $request): View|JsonResponse
    {
        // Получаем данные для фильтров
        $categories = $this->categoryService->getActiveCategories();
        $packagingTypes = $this->filterService->getPackagingTypes();

        // Получаем отфильтрованные продукты
        $filters = $this->filterService->prepareFilters($request);
        $products = $this->catalogService->getFilteredProducts($filters);

        // AJAX запрос
        if ($request->ajax()) {
            return $this->ajaxResponse($products);
        }

        return view('pages.catalog.index', compact('products', 'categories', 'packagingTypes'));
    }

    private function ajaxResponse($products): JsonResponse
    {
        return response()->json([
            'html' => view('pages.catalog.partials.product-card', compact('products'))->render(),
            'pagination' => view('pages.catalog.partials.pagination', compact('products'))->render(),
            'total' => $products->total(),
        ]);
    }
}
