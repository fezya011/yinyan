{{-- pages/catalog/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Каталог товаров – Инь Ян Экспорт и импорт из Китая')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/pages/catalog.css'])
@endpush

@section('content')
    <div class="catalog-wrapper" id="catalogApp">
        {{-- Хлебные крошки --}}
        @include('pages.catalog.partials.breadcrumbs')

        {{-- Заголовок --}}
        @include('pages.catalog.partials.header')

        <div class="px-4 md:px-12 lg:px-16 fade-in-up fade-in-up-delay-3">
            {{-- Поиск --}}
            @include('pages.catalog.partials.search-bar')

            {{-- Фильтры --}}
            <div class="filters-wrapper">
                @include('pages.catalog.partials.filters', [
                    'categories' => $categories,
                    'packagingTypes' => $packagingTypes
                ])

                {{-- Активные фильтры --}}
                @include('pages.catalog.partials.active-filters')
            </div>
        </div>

        {{-- Сетка товаров --}}
        <div class="px-4 md:px-12 lg:px-16" style="position:relative;">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner"></div>
            </div>
            <div class="catalog-grid" id="catalogGrid">
                @include('pages.catalog.partials.product-card', ['products' => $products])
            </div>
        </div>

        {{-- Пагинация --}}
        <div class="px-4 md:px-12 lg:px-16" id="paginationContainer">
            @include('pages.catalog.partials.pagination', ['products' => $products])
        </div>

        {{-- CTA секция --}}
        @include('pages.catalog.partials.cta')
    </div>
@endsection

{{-- Данные для JS --}}
@include('pages.catalog.partials.scripts-data')

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @vite(['resources/js/pages/catalog.js'])
@endpush
