<?php
// app/Http/Controllers/Web/HomeController.php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Services\CarouselService;
use App\Services\PopularProductsService;

class HomeController extends BasePageController
{
    public function __construct(
        private readonly CarouselService $carouselService,
        private readonly PopularProductsService $popularProductsService
    ) {}

    public function __invoke()
    {
        $slides = $this->carouselService->getSlides();
        $popularProducts = $this->popularProductsService->getProducts(8);

        return view('pages.home.index', compact('slides', 'popularProducts'));
    }
}
