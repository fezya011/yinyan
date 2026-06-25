<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Lead;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        // Проверяем через Gate
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_categories' => Category::count(),
            'new_leads' => Lead::new()->count(),
            'active_leads' => Lead::active()->count(),
            'won_leads' => Lead::won()->count(),
            'today_leads' => Lead::today()->count(),
            'this_month_leads' => Lead::thisMonth()->count(),
        ];

        $recentLeads = Lead::with('product')
            ->latest()
            ->take(10)
            ->get();

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::with('category')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentLeads',
            'recentProducts',
            'topProducts'
        ));
    }
}
