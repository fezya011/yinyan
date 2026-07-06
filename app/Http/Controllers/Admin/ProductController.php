<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $products = $this->productService->getFilteredProducts($request);
        $categories = Category::active()->sorted()->get();

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
        $product = $this->productService->create($data, $request);

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
        $this->productService->update($product, $data, $request);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно обновлен');
    }

    public function destroy(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $this->productService->delete($product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно удален');
    }

    public function toggleStatus(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $newStatus = $this->productService->toggleStatus($product);
        $statusText = $newStatus === 'active' ? 'активирован' : 'деактивирован';

        return back()->with('success', "Товар {$statusText}");
    }

    public function toggleFeatured(Product $product)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-products');

        $isFeatured = $this->productService->toggleFeatured($product);
        $statusText = $isFeatured ? 'добавлен в избранное' : 'удален из избранного';

        return back()->with('success', "Товар {$statusText}");
    }
}
