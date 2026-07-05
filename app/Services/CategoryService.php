<?php
// app/Services/CategoryService.php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }
}
