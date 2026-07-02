<?php
// app/Http/Controllers/Web/PageController.php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Главная страница с каруселью.
     */
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
                'tag' => $product->tag ?? $product->category?->tag_prefix ?? 'В наличии',
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
        $popularProducts = Product::with('category')
            ->where('status', 'active')
            ->orderByDesc('views_count')   // или orderBy('sort_order')
            ->limit(8)
            ->get();

        // Если популярных нет – подгружаем любые активные
        if ($popularProducts->isEmpty()) {
            $popularProducts = Product::where('status', 'active')
                ->orderBy('sort_order')
                ->limit(8)
                ->get();
        }

        return view('index', compact('slides', 'popularProducts'));
    }

    /**
     * Каталог товаров с фильтрацией и пагинацией.
     */
    public function catalog(Request $request)
    {
        // Получаем все категории для фильтров
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Получаем все уникальные типы упаковки из БД
        $packagingTypes = Product::where('status', 'active')
            ->whereNotNull('packaging_type')
            ->where('packaging_type', '!=', '')
            ->distinct()
            ->orderBy('packaging_type')
            ->pluck('packaging_type')
            ->toArray();

        // Базовый запрос
        $query = Product::with('category')
            ->where('status', 'active')
            ->orderBy('sort_order');

        // Фильтр по категории
        if ($request->filled('category') && $request->category !== 'all') {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Фильтр по упаковке
        if ($request->filled('pack') && $request->pack !== 'all-pack') {
            $query->where('packaging_type', $request->pack);
        }

        // Фильтр по сертификатам
        if ($request->filled('cert')) {
            if ($request->cert === 'eac') {
                $query->where('has_eac', true);
            } elseif ($request->cert === 'honest') {
                $query->where('has_honest_sign', true);
            }
        }

        // Поиск
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('card_subtitle', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%")
                    ->orWhere('tnved_code', 'like', "%{$search}%");
            });
        }

        // Фильтр по цене
        if ($request->filled('price_from')) {
            $query->where('wholesale_price', '>=', (float)$request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('wholesale_price', '<=', (float)$request->price_to);
        }

        // Фильтр по весу
        if ($request->filled('weight_from')) {
            $query->where('weight_grams', '>=', (float)$request->weight_from);
        }
        if ($request->filled('weight_to')) {
            $query->where('weight_grams', '<=', (float)$request->weight_to);
        }

        // Фильтр по сроку годности
        if ($request->filled('shelf_life')) {
            $shelfLife = (int)$request->shelf_life;
            if ($shelfLife === 366) {
                // Более 365 дней
                $query->where('shelf_life_days', '>', 365);
            } else {
                $query->where('shelf_life_days', '<=', $shelfLife);
            }
        }

        // Фильтр по количеству в коробке
        if ($request->filled('pieces_per_box')) {
            $query->where('pieces_per_box', (int)$request->pieces_per_box);
        }

        // Сортировка
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('wholesale_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('wholesale_price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'popular':
                    $query->orderByDesc('views_count');
                    break;
                case 'newest':
                    $query->orderByDesc('created_at');
                    break;
                default:
                    $query->orderBy('sort_order');
            }
        }

        // Пагинация
        $products = $query->paginate(12);

        // Если это AJAX-запрос (для фильтрации без перезагрузки)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.catalog.products', compact('products'))->render(),
                'pagination' => view('partials.catalog.pagination', compact('products'))->render(),
                'total' => $products->total(),
            ]);
        }

        return view('catalog', compact('products', 'categories', 'packagingTypes'));
    }

    /**
     * Страница товара.
     */
    public function product($slug)
    {
        $product = Product::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Увеличиваем счётчик просмотров
        $product->increment('views_count');

        // Похожие товары (из той же категории)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }

    /**
     * Поиск товаров (для автоподсказок).
     */
    public function search(Request $request)
    {
        if (!$request->filled('query')) {
            return response()->json([]);
        }

        $products = Product::where('status', 'active')
            ->where('name', 'like', "%{$request->query}%")
            ->limit(6)
            ->get(['id', 'name', 'slug', 'wholesale_price', 'main_image']);

        return response()->json($products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format($product->wholesale_price ?? 0, 0, '.', ' '),
                'image' => $product->main_image ? asset('storage/' . $product->main_image) : null,
                'url' => route('product', $product->slug),
            ];
        }));
    }

    public function privacy()
    {
        return view('privacy');
    }
}
