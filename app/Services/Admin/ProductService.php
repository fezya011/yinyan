<?php
// app/Services/Admin/ProductService.php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function getFilteredProducts(Request $request): LengthAwarePaginator
    {
        return Product::with('category')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where(function($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('barcode', 'like', "%{$search}%")
                        ->orWhere('tnved_code', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->sorted()
            ->paginate(20);
    }

    public function create(array $data, Request $request): Product
    {
        // Slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Вкусы (из строки в массив)
        if ($request->filled('flavors_string')) {
            $data['flavors'] = array_map('trim', explode(',', $request->flavors_string));
        }

        // Изображения
        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')
                ->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        // Булевы поля
        $data['has_eac'] = $request->boolean('has_eac', true);
        $data['has_honest_sign'] = $request->boolean('has_honest_sign', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        return Product::create($data);
    }

    public function update(Product $product, array $data, Request $request): Product
    {
        // Вкусы (из строки в массив)
        if ($request->filled('flavors_string')) {
            $data['flavors'] = array_map('trim', explode(',', $request->flavors_string));
        } else {
            $data['flavors'] = null;
        }

        // Изображения
        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                Storage::disk('public')->delete($product->main_image);
            }
            $data['main_image'] = $request->file('main_image')
                ->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            if ($product->gallery) {
                foreach ($product->gallery as $file) {
                    Storage::disk('public')->delete($file);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        // Булевы поля
        $data['has_eac'] = $request->boolean('has_eac', true);
        $data['has_honest_sign'] = $request->boolean('has_honest_sign', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        $product->update($data);

        return $product;
    }

    public function delete(Product $product): void
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
        if ($product->gallery) {
            foreach ($product->gallery as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $product->delete();
    }

    public function toggleStatus(Product $product): string
    {
        $newStatus = match ($product->status) {
            'active' => 'inactive',
            'inactive' => 'active',
            'out_of_stock' => 'active',
            default => 'active',
        };

        $product->update(['status' => $newStatus]);

        return $newStatus;
    }

    public function toggleFeatured(Product $product): bool
    {
        $product->update(['is_featured' => !$product->is_featured]);

        return $product->is_featured;
    }
}
