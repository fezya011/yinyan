<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function index()
    {
        Gate::forUser(auth('admin')->user())->authorize('admin');

        $stats = $this->dashboardService->getStats();
        $recentLeads = $this->dashboardService->getRecentLeads(10);
        $recentProducts = $this->dashboardService->getRecentProducts(5);
        $topProducts = $this->dashboardService->getTopProducts(5);

        return view('admin.dashboard.dashboard', compact(
            'stats',
            'recentLeads',
            'recentProducts',
            'topProducts'
        ));
    }
}
