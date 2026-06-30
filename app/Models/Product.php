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

        // ===== НОВЫЕ ПОЛЯ =====
        'barcode',
        'weight_grams',
        'pieces_per_box',
        'boxes_per_pallet',
        'shelf_life_days',
        'box_volume',
        'box_weight_kg',
        'vat_rate',
        'tnved_code',

        // Цены
        'retail_price',
        'wholesale_price',
        'distributor_price',
        'cost_price',
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
        'comment', // ===== НОВОЕ ПОЛЕ =====
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
        'distributor_price' => 'decimal:2', // ===== НОВОЕ =====
        'cost_price' => 'decimal:2',        // ===== НОВОЕ =====
        'min_order_amount' => 'decimal:2',
        'weight_grams' => 'decimal:2',
        'box_volume' => 'decimal:3',        // ===== НОВОЕ =====
        'box_weight_kg' => 'decimal:2',     // ===== НОВОЕ =====
        'vat_rate' => 'decimal:2',          // ===== НОВОЕ =====
        'views_count' => 'integer',
        'orders_count' => 'integer',
        'sort_order' => 'integer',
    ];

    // ===== СВЯЗИ =====
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    // ===== BOOT =====
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

    // ===== SCOPES =====
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->active();
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopePopular($query)
    {
        return $query->orderByDesc('views_count');
    }

    // ===== МЕТОДЫ =====
    public function isInStock(): bool
    {
        return $this->status !== 'out_of_stock';
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price_display ?? number_format($this->wholesale_price ?? 0, 0, '.', ' ') . ' ₽ / шт';
    }

    public function getMainVisualAttribute()
    {
        return $this->main_image ?? $this->emoji_icon ?? '📦';
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementOrders(): void
    {
        $this->increment('orders_count');
    }

    // ===== НОВЫЕ МЕТОДЫ =====

    /**
     * Получить цену для оптового клиента
     */
    public function getWholesalePrice(): ?float
    {
        return $this->wholesale_price;
    }

    /**
     * Получить цену для розничной сети
     */
    public function getRetailPrice(): ?float
    {
        return $this->retail_price;
    }

    /**
     * Получить цену для дистрибьютора
     */
    public function getDistributorPrice(): ?float
    {
        return $this->distributor_price;
    }

    /**
     * Получить маржинальность (%)
     */
    public function getMarginPercent(): ?float
    {
        if (!$this->cost_price || !$this->wholesale_price || $this->cost_price == 0) {
            return null;
        }

        return round((($this->wholesale_price - $this->cost_price) / $this->cost_price) * 100, 2);
    }

    /**
     * Получить вес в кг
     */
    public function getWeightKg(): ?float
    {
        return $this->weight_grams ? $this->weight_grams / 1000 : null;
    }

    /**
     * Проверить, есть ли сертификаты
     */
    public function hasCertificates(): bool
    {
        return $this->has_eac || $this->has_honest_sign;
    }
}
