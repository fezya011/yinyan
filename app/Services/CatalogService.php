<?php
// app/Services/CatalogService.php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class CatalogService
{
    private const PER_PAGE = 12;

    public function getFilteredProducts(array $filters): LengthAwarePaginator
    {
        $query = Product::with('category')
            ->where('status', 'active');

        // Применяем фильтры
        $this->applyFilters($query, $filters);

        // Применяем сортировку
        $this->applySorting($query, $filters['sort'] ?? null);

        return $query->paginate(self::PER_PAGE);
    }

    private function applyFilters($query, array $filters): void
    {
        // Категория
        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $query->whereHas('category', fn($q) =>
            $q->where('slug', $filters['category'])
            );
        }

        // ✅ Упаковка - исправлено с 'packaging' на 'pack'
        if (!empty($filters['pack']) && $filters['pack'] !== 'all-pack') {
            $query->where('packaging_type', $filters['pack']);
        }

        // Сертификаты
        if (!empty($filters['cert']) && $filters['cert'] !== 'all-cert') {
            match ($filters['cert']) {
                'eac' => $query->where('has_eac', true),
                'honest' => $query->where('has_honest_sign', true),
                default => null
            };
        }

        // Поиск
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('card_subtitle', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('tnved_code', 'like', "%{$search}%");
            });
        }

        // Цена
        if (isset($filters['price_from']) && $filters['price_from'] !== '') {
            $query->where('wholesale_price', '>=', (float)$filters['price_from']);
        }
        if (isset($filters['price_to']) && $filters['price_to'] !== '') {
            $query->where('wholesale_price', '<=', (float)$filters['price_to']);
        }

        // Вес
        if (isset($filters['weight_from']) && $filters['weight_from'] !== '') {
            $query->where('weight_grams', '>=', (float)$filters['weight_from']);
        }
        if (isset($filters['weight_to']) && $filters['weight_to'] !== '') {
            $query->where('weight_grams', '<=', (float)$filters['weight_to']);
        }

        // Срок годности
        if (isset($filters['shelf_life']) && $filters['shelf_life'] !== '') {
            $shelfLife = (int)$filters['shelf_life'];
            if ($shelfLife > 365) {
                $query->where('shelf_life_days', '>', 365);
            } else {
                $query->where('shelf_life_days', '<=', $shelfLife);
            }
        }

        // Количество в коробке
        if (isset($filters['pieces_per_box']) && $filters['pieces_per_box'] !== '') {
            $query->where('pieces_per_box', (int)$filters['pieces_per_box']);
        }
    }

    private function applySorting($query, ?string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('wholesale_price', 'asc'),
            'price_desc' => $query->orderBy('wholesale_price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'popular' => $query->orderByDesc('views_count'),
            'newest' => $query->orderByDesc('created_at'),
            default => $query->orderBy('sort_order')
        };
    }
}
