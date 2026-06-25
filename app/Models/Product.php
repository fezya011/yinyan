<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'card_subtitle',
        'emoji_icon',
        'tag',
        'accent_color',
        'packaging_type',
        'flavors',
        'weight_grams',
        'pieces_per_box',
        'boxes_per_pallet',
        'shelf_life_days',
        'retail_price',
        'wholesale_price',
        'min_order_amount',
        'price_display',
        'main_image',
        'gallery',
        'has_eac',
        'has_honest_sign',
        'status',
        'is_featured',
        'sort_order',
        'meta_title',
        'meta_description',
        'views_count',
        'orders_count',
    ];

    protected $casts = [
        'flavors' => 'array',
        'gallery' => 'array',
        'has_eac' => 'boolean',
        'has_honest_sign' => 'boolean',
        'is_featured' => 'boolean',
        'retail_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'weight_grams' => 'decimal:2',
        'views_count' => 'integer',
        'orders_count' => 'integer',
        'sort_order' => 'integer',
    ];

    // Товар принадлежит категории
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Заявки на этот товар
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    // Автоматическая генерация slug из name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Scope для активных товаров
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope для featured товаров (на главной)
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->active();
    }

    // Scope для сортировки
    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    // Scope для популярных товаров
    public function scopePopular($query)
    {
        return $query->orderByDesc('views_count');
    }

    // Проверка наличия на складе
    public function isInStock(): bool
    {
        return $this->status !== 'out_of_stock';
    }

    // Получение форматированной цены
    public function getFormattedPriceAttribute()
    {
        return $this->price_display ?? number_format($this->wholesale_price, 0, '.', ' ') . ' ₽ / шт';
    }

    // Получение главного изображения или эмодзи
    public function getMainVisualAttribute()
    {
        return $this->main_image ?? $this->emoji_icon ?? '📦';
    }

    // Увеличение счетчика просмотров
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    // Увеличение счетчика заказов
    public function incrementOrders(): void
    {
        $this->increment('orders_count');
    }
}
