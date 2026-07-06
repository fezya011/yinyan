<?php
// app/Http/Controllers/Admin/CategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {}

    public function index()
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $categories = $this->categoryService->getAllPaginated(20);

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
        $category = $this->categoryService->create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно создана');
    }

    public function edit(Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $category->loadCount('products');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $data = $request->validated();
        $this->categoryService->update($category, $data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно обновлена');
    }

    public function destroy(Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        if ($category->products()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Нельзя удалить категорию с товарами');
        }

        $this->categoryService->delete($category);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Категория успешно удалена');
    }

    public function toggleStatus(Category $category)
    {
        Gate::forUser(auth('admin')->user())->authorize('manage-categories');

        $status = $this->categoryService->toggleStatus($category);
        $statusText = $status ? 'активирована' : 'деактивирована';

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Категория {$statusText}");
    }
}
