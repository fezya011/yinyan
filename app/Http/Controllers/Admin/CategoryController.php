<?php
// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $categories = Category::withCount('products')
            ->sorted()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $category = Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно создана');
    }

    public function edit(Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $data = $request->validated();
        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    public function destroy(Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Нельзя удалить категорию с товарами');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно удалена');
    }

    public function toggleStatus(Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'активирована' : 'деактивирована';

        return back()->with('success', "Категория {$status}");
    }
}
