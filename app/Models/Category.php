<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'tag_prefix',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // У категории много товаров
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Только активные товары
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('status', 'active');
    }

    // Количество товаров в категории
    public function productsCount()
    {
        return $this->products()->count();
    }

    // Scope для активных категорий
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope для сортировки
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }
}
