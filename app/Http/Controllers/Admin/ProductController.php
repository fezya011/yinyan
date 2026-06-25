<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $products = Product::with('category')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            })
            ->when($request->filled('category'), function ($q) use ($request) {
                $q->where('category_id', $request->category);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->sorted()
            ->paginate(20);

        $categories = Category::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $categories = Category::active()->sorted()->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        // Обработка изображений
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

        $data['has_eac'] = $request->boolean('has_eac', true);
        $data['has_honest_sign'] = $request->boolean('has_honest_sign', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        $product = Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно создан');
    }

    public function edit(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $categories = Category::active()->sorted()->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $data = $request->validated();

        if ($request->hasFile('main_image')) {
            if ($product->main_image) {
                \Storage::disk('public')->delete($product->main_image);
            }
            $data['main_image'] = $request->file('main_image')
                ->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            if ($product->gallery) {
                foreach ($product->gallery as $file) {
                    \Storage::disk('public')->delete($file);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $data['has_eac'] = $request->boolean('has_eac', true);
        $data['has_honest_sign'] = $request->boolean('has_honest_sign', true);
        $data['is_featured'] = $request->boolean('is_featured', false);

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен');
    }

    public function destroy(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        if ($product->main_image) {
            \Storage::disk('public')->delete($product->main_image);
        }
        if ($product->gallery) {
            foreach ($product->gallery as $file) {
                \Storage::disk('public')->delete($file);
            }
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно удален');
    }

    public function toggleStatus(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $newStatus = match ($product->status) {
            'active' => 'inactive',
            'inactive' => 'active',
            'out_of_stock' => 'active',
            default => 'active',
        };

        $product->update(['status' => $newStatus]);

        return back()->with('success', 'Статус товара обновлен');
    }

    public function toggleFeatured(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'добавлен в избранное' : 'удален из избранного';

        return back()->with('success', "Товар {$status}");
    }
}
