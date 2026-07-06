<?php
// app/Services/Admin/DashboardService.php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Lead;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_categories' => Category::count(),
            'new_leads' => Lead::new()->count(),
            'active_leads' => Lead::active()->count(),
            'won_leads' => Lead::won()->count(),
            'today_leads' => Lead::today()->count(),
            'this_month_leads' => Lead::thisMonth()->count(),
        ];
    }

    public function getRecentLeads(int $limit = 10): Collection
    {
        return Lead::with('product')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getRecentProducts(int $limit = 5): Collection
    {
        return Product::with('category')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getTopProducts(int $limit = 5): Collection
    {
        return Product::with('category')
            ->orderByDesc('orders_count')
            ->take($limit)
            ->get();
    }
}
