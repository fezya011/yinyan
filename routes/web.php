<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Web\PageController;
use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', [PageController::class, 'home'])->name('home');

// ===== АДМИНКА =====
Route::prefix('admin')->name('admin.')->group(function () {
    // Гостевые маршруты (используем guard admin)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Защищенные маршруты (наш middleware)
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])
            ->name('products.toggle-status');
        Route::post('products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])
            ->name('products.toggle-featured');

        // Leads
        Route::get('leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::get('leads/{lead}', [AdminLeadController::class, 'show'])->name('leads.show');
        Route::put('leads/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('leads.update-status');
        Route::delete('leads/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');
        Route::get('leads/export', [AdminLeadController::class, 'export'])->name('leads.export');
    });
});


Route::get('/catalog', function () {
    return view('catalog'); // создайте при необходимости
})->name('catalog');

Route::get('/about', function () {
    return view('about'); // создайте при необходимости
})->name('about');

Route::get('/faq', function () {
    return view('faq'); // создайте при необходимости
})->name('faq');

Route::get('/contacts', function () {
    return view('landing#contacts'); // или отдельная страница
})->name('contacts');

Route::get('/search', function () {
    return view('search-results'); // страница результатов
})->name('search');

