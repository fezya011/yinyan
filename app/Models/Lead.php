<?php
// app/Models/Lead.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'product_id',
        'interested_products',
        'estimated_budget',
        'delivery_city',
        'status',
    ];

    protected $casts = [
        'interested_products' => 'array',
        'estimated_budget' => 'string',
    ];

    // Статусы для удобства
    const STATUS_NEW = 'new';
    const STATUS_CONTACTED = 'contacted';
    const STATUS_QUALIFIED = 'qualified';
    const STATUS_PROPOSAL_SENT = 'proposal_sent';
    const STATUS_NEGOTIATION = 'negotiation';
    const STATUS_WON = 'won';
    const STATUS_LOST = 'lost';
    const STATUS_SPAM = 'spam';

    // Заявка может быть связана с конкретным товаром
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope для новых заявок
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    // Scope для активных заявок (не закрытые)
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_WON, self::STATUS_LOST, self::STATUS_SPAM]);
    }

    // Scope для выигранных заявок
    public function scopeWon($query)
    {
        return $query->where('status', self::STATUS_WON);
    }

    // Scope за сегодня
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope за этот месяц
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    // Получение заинтересованных товаров
    public function interestedProducts()
    {
        if (empty($this->interested_products)) {
            return collect();
        }

        return Product::whereIn('id', $this->interested_products)->get();
    }

    // Изменение статуса
    public function changeStatus(string $status): void
    {
        $this->update(['status' => $status]);
    }

    // Получение статусов для select
    public static function getStatuses(): array
    {
        return [
            self::STATUS_NEW => 'Новая',
            self::STATUS_CONTACTED => 'Связались',
            self::STATUS_QUALIFIED => 'Квалифицирован',
            self::STATUS_PROPOSAL_SENT => 'КП отправлено',
            self::STATUS_NEGOTIATION => 'Переговоры',
            self::STATUS_WON => 'Выиграна',
            self::STATUS_LOST => 'Проиграна',
            self::STATUS_SPAM => 'Спам',
        ];
    }

    // Получение цвета для статуса
    public function getStatusColor(): string
    {
        return match($this->status) {
            self::STATUS_NEW => '#3B82F6',          // синий
            self::STATUS_CONTACTED => '#8B5CF6',      // фиолетовый
            self::STATUS_QUALIFIED => '#F59E0B',      // желтый
            self::STATUS_PROPOSAL_SENT => '#EC4899',  // розовый
            self::STATUS_NEGOTIATION => '#F97316',    // оранжевый
            self::STATUS_WON => '#10B981',            // зеленый
            self::STATUS_LOST => '#EF4444',           // красный
            self::STATUS_SPAM => '#6B7280',           // серый
            default => '#6B7280',
        };
    }
}
