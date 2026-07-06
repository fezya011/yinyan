<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Web\CatalogController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Lead\LeadController;
use App\Http\Controllers\Web\Lead\LeadCityController;



// Главная
Route::get('/', HomeController::class)->name('home');

// Каталог
Route::get('/catalog', CatalogController::class)->name('catalog');

// Товар
Route::get('/product/{slug}', ProductController::class)->name('product');

// Поиск (API)
Route::get('/search', SearchController::class)->name('search');

// Статические страницы
Route::view('/privacy', 'pages.static.privacy')->name('privacy');
Route::view('/about', 'pages.static.about')->name('about');
Route::view('/contacts', 'pages.contacts.contacts')->name('contacts');


// Заявки
Route::post('/lead', [LeadController::class, 'store'])->name('lead.store');
Route::get('/cities', [LeadCityController::class, 'index'])->name('cities');

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
        Route::get('leads/export-page', [AdminLeadController::class, 'exportPage'])->name('leads.export-page');
        Route::get('leads/export', [AdminLeadController::class, 'export'])->name('leads.export');
        Route::get('leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::get('leads/{lead}', [AdminLeadController::class, 'show'])->name('leads.show');
        Route::put('leads/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('leads.update-status');
        Route::delete('leads/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');
    });
});


