<?php
// app/Services/Admin/CategoryService.php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAllPaginated(int $perPage = 20): LengthAwarePaginator
    {
        return Category::withCount('products')
            ->sorted()
            ->paginate($perPage);
    }

    public function create(array $data): Category
    {
        if (empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name'], $category->id);
        }

        $category->update($data);

        return $category;
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    public function toggleStatus(Category $category): bool
    {
        $category->update(['is_active' => !$category->is_active]);

        return $category->is_active;
    }

    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);

        $query = Category::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            $slug = $slug . '-' . Str::random(4);
        }

        return $slug;
    }
}
