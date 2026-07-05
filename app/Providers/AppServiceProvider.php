<?php

namespace App\Providers;

use App\Services\CarouselService;
use App\Services\CatalogService;
use App\Services\CategoryService;
use App\Services\FilterService;
use App\Services\PopularProductsService;
use App\Services\RelatedProductsService;
use App\Services\SearchService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CarouselService::class);
        $this->app->singleton(CatalogService::class);
        $this->app->singleton(CategoryService::class);
        $this->app->singleton(FilterService::class);
        $this->app->singleton(PopularProductsService::class);
        $this->app->singleton(RelatedProductsService::class);
        $this->app->singleton(SearchService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
