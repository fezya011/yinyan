<?php
// app/Http/Controllers/Web/ProductController.php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Services\RelatedProductsService;

class ProductController extends BasePageController
{
    public function __construct(
        private readonly RelatedProductsService $relatedProductsService
    ) {}

    public function __invoke(string $slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Увеличиваем счётчик просмотров
        $product->increment('views_count');

        // Получаем связанные продукты
        $relatedProducts = $this->relatedProductsService->getForProduct($product, 4);

        return view('pages.product.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    private function getSpecifications(Product $product): array
    {
        return [
            'weight' => $product->weight_grams ? $product->weight_grams . ' г' : null,
            'packaging' => $product->packaging_type,
            'shelf_life' => $product->shelf_life_days ? $product->shelf_life_days . ' дн.' : null,
            'pieces_per_box' => $product->pieces_per_box,
            'barcode' => $product->barcode,
            'tnved_code' => $product->tnved_code,
            'has_eac' => $product->has_eac,
            'has_honest_sign' => $product->has_honest_sign,
        ];
    }

    private function getProductImages(Product $product): array
    {
        $images = [];

        if ($product->main_image) {
            $images[] = asset('storage/' . $product->main_image);
        }

        // Если есть дополнительные изображения
        if ($product->images) {
            foreach ($product->images as $image) {
                $images[] = asset('storage/' . $image);
            }
        }

        return $images;
    }
}
