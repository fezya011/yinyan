@extends('layouts.app')

@section('title', 'Каталог товаров – Инь Ян Экспорт и импорт из Китая')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }

        :root { --header-height: 80px; }

        .catalog-wrapper {
            padding-top: var(--header-height);
            overflow-x: hidden;
        }

        /* ===== АНИМАЦИЯ ПОЯВЛЕНИЯ (CSS) ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        .fade-in-up-delay-1 { animation-delay: 0.1s; }
        .fade-in-up-delay-2 { animation-delay: 0.2s; }
        .fade-in-up-delay-3 { animation-delay: 0.3s; }

        /* ===== ХЛЕБНЫЕ КРОШКИ ===== */
        .breadcrumbs {
            padding: 20px 0 10px;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.3);
            font-weight: 500;
        }
        .breadcrumbs a { color: rgba(26,26,26,0.4); text-decoration: none; transition: color 0.3s; font-weight: 500; }
        .breadcrumbs a:hover { color: #1A1A1A; }
        .breadcrumbs .separator { margin: 0 8px; color: rgba(26,26,26,0.12); }
        .breadcrumbs .current { color: rgba(26,26,26,0.5); }

        /* ===== ЗАГОЛОВОК ===== */
        .catalog-header {
            padding: 20px 0 40px;
            border-bottom: 1px solid rgba(26,26,26,0.04);
            position: relative; z-index: 2;
        }
        .catalog-header h1 {
            font-weight: 900;
            font-size: clamp(32px, 4vw, 52px);
            letter-spacing: -1.5px;
            text-transform: uppercase;
            color: #1A1A1A;
            line-height: 1.05;
        }
        .catalog-header .subtitle {
            font-size: 14px; color: rgba(26,26,26,0.35);
            margin-top: 8px; max-width: 500px;
            font-weight: 400; line-height: 1.6;
        }

        /* ===== ПОИСК ===== */
        .search-bar { position: relative; margin-bottom: 20px; }
        .search-bar input {
            width: 100%; padding: 14px 48px 14px 20px;
            border: 1px solid rgba(26,26,26,0.08);
            background: #FAFAFA; font-size: 14px; color: #1A1A1A;
            font-family: 'Inter', sans-serif; transition: all 0.3s ease; outline: none;
        }
        .search-bar input:focus {
            border-color: rgba(26,26,26,0.2); background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(26,26,26,0.03);
        }
        .search-bar input::placeholder { color: rgba(26,26,26,0.2); }
        .search-bar .search-icon {
            position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
            color: rgba(26,26,26,0.3); pointer-events: none;
        }
        .search-bar .clear-search {
            position: absolute; right: 44px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: rgba(26,26,26,0.3);
            cursor: pointer; font-size: 18px; padding: 4px 8px;
            display: none; transition: color 0.3s;
        }
        .search-bar .clear-search:hover { color: #1A1A1A; }
        .search-results-count {
            font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase;
            color: rgba(26,26,26,0.3); margin-bottom: 16px; font-weight: 500;
        }

        /* ===== ФИЛЬТРЫ ===== */
        .filters-wrapper {
            border-bottom: 1px solid rgba(26,26,26,0.04);
            padding-bottom: 12px; margin-bottom: 20px;
        }
        .filters-bar {
            display: flex; flex-wrap: wrap; gap: 12px; padding: 0;
            position: relative; z-index: 2;
        }
        .filter-group { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        .filter-group-label {
            font-size: 9px; letter-spacing: 2px; text-transform: uppercase;
            color: rgba(26,26,26,0.25); margin-right: 4px; font-weight: 600;
        }
        .filter-btn {
            padding: 8px 18px; border: 1px solid rgba(26,26,26,0.08);
            border-radius: 100px; background: transparent;
            font-size: 11px; font-weight: 500; color: rgba(26,26,26,0.5);
            cursor: pointer; transition: all 0.3s ease;
            font-family: 'Inter', sans-serif; white-space: nowrap;
        }
        .filter-btn:hover { border-color: rgba(26,26,26,0.2); color: #1A1A1A; }
        .filter-btn.active { background: #1A1A1A; color: #FFFFFF; border-color: #1A1A1A; }

        .custom-select-wrap {
            position: relative;
            display: inline-block;
        }
        .custom-select-wrap select.filter-btn {
            padding-right: 32px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="rgba(26,26,26,0.4)" d="M6 8L1 3h10z"/></svg>');
            background-repeat: no-repeat; background-position: right 12px center;
            cursor: pointer; appearance: none; -webkit-appearance: none; -moz-appearance: none;
            position: relative; z-index: 2;
        }
        .custom-select-wrap select.filter-btn:focus {
            border-color: rgba(26,26,26,0.3);
            outline: none;
            box-shadow: 0 0 0 2px rgba(26,26,26,0.04);
        }
        .custom-select-wrap select.filter-btn option {
            padding: 10px 16px;
            font-size: 12px;
            background: #FFFFFF;
            color: #1A1A1A;
        }

        .filter-divider {
            width: 1px; height: 28px;
            background: rgba(26,26,26,0.06); margin: 0 4px;
        }

        .advanced-filters { display: none; margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(26,26,26,0.04); }
        .advanced-filters.visible { display: block; }
        .filter-range { display: flex; align-items: center; gap: 8px; }
        .filter-range input {
            width: 100px; padding: 6px 10px;
            border: 1px solid rgba(26,26,26,0.08); background: #FAFAFA;
            font-size: 12px; color: #1A1A1A; font-family: 'Inter', sans-serif;
            outline: none; transition: all 0.3s;
        }
        .filter-range input:focus { border-color: rgba(26,26,26,0.2); }
        .filter-range span { font-size: 12px; color: rgba(26,26,26,0.3); }
        .toggle-advanced {
            font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase;
            color: rgba(26,26,26,0.4); cursor: pointer; font-weight: 500;
            display: inline-flex; align-items: center; gap: 4px;
            transition: color 0.3s; padding-top: 17px;
            background: none; border: none; font-family: 'Inter', sans-serif;
        }
        .toggle-advanced:hover { color: #1A1A1A; }
        .toggle-advanced .arrow { transition: transform 0.3s; font-size: 8px; }
        .toggle-advanced.expanded .arrow { transform: rotate(180deg); }

        .active-filters { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
        .active-filter-tag {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 10px; background: rgba(26,26,26,0.03);
            font-size: 10px; color: rgba(26,26,26,0.5);
            cursor: pointer; transition: all 0.3s; font-weight: 450;
        }
        .active-filter-tag:hover { background: rgba(26,26,26,0.06); color: #1A1A1A; }
        .active-filter-tag .remove { font-size: 14px; line-height: 1; }
        .reset-filters {
            font-size: 10px; color: rgba(26,26,26,0.3); cursor: pointer;
            text-decoration: underline; transition: color 0.3s; font-weight: 500;
            background: none; border: none; font-family: 'Inter', sans-serif;
        }
        .reset-filters:hover { color: #1A1A1A; }

        /* ===== СЕТКА ТОВАРОВ (УВЕЛИЧЕННЫЕ ШРИФТЫ) ===== */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1px;
            padding: 0;
            background: rgba(26,26,26,0.04);
        }
        .product-card {
            background: #FFFFFF; padding: 28px 32px 32px;
            transition: all 0.4s cubic-bezier(0.25,0.8,0.25,1);
            position: relative; display: flex; flex-direction: column;
            z-index: 1; text-decoration: none; color: inherit;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(26,26,26,0.06);
            z-index: 10;
        }
        .product-card .image-wrap {
            width: 100%; height: 240px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px; background: #FFFFFF;
            overflow: hidden; position: relative;
        }
        .product-card .badge {
            position: absolute; top: 14px; right: 14px;
            font-size: 9px;                  /* было 8px */
            letter-spacing: 2px; text-transform: uppercase;
            padding: 5px 12px; font-weight: 600;
            background: #1A1A1A; color: #FFFFFF; z-index: 2;
        }
        .product-card .image-wrap img {
            width: 100%; height: 100%; object-fit: contain;
            transition: transform 0.6s cubic-bezier(0.34,1.56,0.64,1);
            padding: 24px; position: relative; z-index: 1;
        }
        .product-card:hover .image-wrap img { transform: scale(1.06); }
        .product-card .image-wrap .no-image {
            font-family: 'Inter', sans-serif; font-size: 11px;
            color: rgba(26,26,26,0.15); letter-spacing: 2px;
            text-transform: uppercase; font-weight: 500;
        }
        .product-card .category-tag {
            font-size: 10px;                 /* было 9px */
            letter-spacing: 2.5px; text-transform: uppercase;
            color: rgba(26,26,26,0.25); margin-bottom: 8px; font-weight: 600;
        }
        .product-card .product-name {
            font-weight: 700; font-size: 20px;  /* было 18px */
            color: #1A1A1A;
            line-height: 1.3; margin-bottom: 8px; letter-spacing: -0.3px;
        }
        .product-card .product-desc {
            font-size: 14px;                 /* было 13px */
            color: rgba(26,26,26,0.4);
            line-height: 1.6; flex-grow: 1; margin-bottom: 20px;
            font-weight: 400;
        }
        .product-card .certificates { display: flex; gap: 6px; margin-bottom: 12px; }
        .product-card .cert-badge {
            font-size: 8px;                  /* было 7px */
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 3px 8px; background: rgba(26,26,26,0.03);
            color: rgba(26,26,26,0.3); font-weight: 500;
        }
        .product-card .cert-badge.has { background: #1A1A1A; color: #FFFFFF; }

        .product-card .product-meta {
            display: flex; flex-wrap: wrap; gap: 8px 16px;
            margin-bottom: 20px; padding-top: 16px;
            border-top: 1px solid rgba(26,26,26,0.04);
        }
        .product-card .product-meta .meta-item {
            font-size: 11px;                 /* было 10px */
            color: rgba(26,26,26,0.3);
            display: flex; align-items: center; gap: 4px; font-weight: 450;
        }
        .product-card .product-meta .meta-item strong {
            color: rgba(26,26,26,0.5); font-weight: 500;
        }

        .product-card .product-meta-mobile { display: none; }

        .product-card .product-footer {
            display: flex; justify-content: space-between;
            align-items: center; margin-top: auto;
        }
        .product-card .price {
            font-weight: 700; font-size: 22px;  /* было 20px */
            color: #1A1A1A; letter-spacing: -0.5px;
        }
        .product-card .price .from {
            font-weight: 400; font-size: 12px;  /* было 11px */
            color: rgba(26,26,26,0.3); margin-right: 2px;
        }

        .pagination-wrap { display: flex; justify-content: center; align-items: center; gap: 6px; padding: 40px 0 80px; }

        .empty-catalog {
            grid-column: 1 / -1; text-align: center;
            padding: 80px 20px; color: rgba(26,26,26,0.2); background: #FFFFFF;
        }
        .empty-catalog .empty-icon {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 64px; font-weight: 900; opacity: 0.2;
            display: block; margin-bottom: 16px;
        }
        .empty-catalog .empty-text {
            font-size: 12px; letter-spacing: 2px;
            text-transform: uppercase; font-weight: 500;
        }

        .loading-overlay {
            position: absolute; inset: 0;
            background: rgba(255,255,255,0.7);
            display: flex; align-items: center; justify-content: center;
            z-index: 100; opacity: 0; pointer-events: none; transition: opacity 0.3s;
        }
        .loading-overlay.active { opacity: 1; pointer-events: all; }
        .loading-spinner {
            width: 30px; height: 30px;
            border: 2px solid rgba(26,26,26,0.1);
            border-top-color: #1A1A1A;
            border-radius: 50%; animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .hanzi-decor {
            position: absolute; pointer-events: none; user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900; color: #1A1A1A; line-height: 1; z-index: 0;
        }
        .hanzi-decor.xl { font-size: 140px; }
        .hanzi-decor.lg { font-size: 100px; }
        .hanzi-decor.md { font-size: 70px; }
        .hanzi-decor.sm { font-size: 45px; }
        .hanzi-decor.xs { font-size: 28px; }

        /* ===== АДАПТИВ (с увеличенными шрифтами) ===== */
        @media (max-width: 768px) {
            .catalog-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                background: none;
                padding: 0;
            }
            .product-card {
                padding: 16px 14px 20px;
                border: 1px solid rgba(26,26,26,0.05);
            }
            .product-card:hover {
                transform: none;
                box-shadow: 0 6px 20px rgba(26,26,26,0.05);
                border-color: rgba(26,26,26,0.1);
            }
            .product-card .image-wrap { height: 170px; margin-bottom: 14px; }
            .product-card .image-wrap img { padding: 14px; }
            .product-card .badge { top: 8px; right: 8px; font-size: 8px; letter-spacing: 1.5px; padding: 4px 9px; }
            .product-card .category-tag { font-size: 9px; letter-spacing: 2px; margin-bottom: 5px; }
            .product-card .product-name { font-size: 17px; margin-bottom: 5px; line-height: 1.25; }  /* было 15px */
            .product-card .product-desc { font-size: 12px; line-height: 1.5; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }  /* было 11px */
            .product-card .certificates { gap: 4px; margin-bottom: 8px; }
            .product-card .cert-badge { font-size: 7px; letter-spacing: 1px; padding: 2px 6px; }
            .product-card .product-meta { display: none; }
            .product-card .product-meta-mobile { display: flex; flex-wrap: wrap; gap: 4px 10px; margin-bottom: 10px; }
            .product-card .product-meta-mobile .meta-item { font-size: 11px; color: rgba(26,26,26,0.4); font-weight: 450; }  /* было 10px */
            .product-card .btn-order { display: none; }
            .product-card .product-footer { margin-top: auto; }
            .product-card .price { font-size: 19px; }  /* было 17px */
            .product-card .price .from { font-size: 11px; }  /* было 10px */
            .filters-bar {
                gap: 8px; overflow-x: auto; flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            .filters-bar::-webkit-scrollbar { display: none; }
            .filter-divider { flex-shrink: 0; }
            .filter-group { flex-shrink: 0; }
            .hanzi-decor.xl { font-size: 100px; opacity: 0.04 !important; }
            .hanzi-decor.lg { font-size: 70px; opacity: 0.03 !important; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.02 !important; }
        }

        @media (max-width: 480px) {
            .catalog-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .product-card { padding: 14px 12px 18px; }
            .product-card .image-wrap { height: 150px; margin-bottom: 12px; }
            .product-card .image-wrap img { padding: 12px; }
            .product-card .badge { top: 6px; right: 6px; font-size: 7px; letter-spacing: 1px; padding: 3px 7px; }
            .product-card .category-tag { font-size: 8px; letter-spacing: 1.5px; margin-bottom: 4px; }  /* было 7px */
            .product-card .product-name { font-size: 15px; margin-bottom: 4px; }  /* было 14px */
            .product-card .product-desc { font-size: 11px; -webkit-line-clamp: 2; margin-bottom: 8px; }  /* было 10px */
            .product-card .product-meta-mobile { gap: 3px 8px; margin-bottom: 8px; }
            .product-card .product-meta-mobile .meta-item { font-size: 10px; }  /* было 9px */
            .product-card .price { font-size: 17px; }  /* было 16px */
            .product-card .cert-badge { font-size: 7px; padding: 2px 5px; }  /* было 6px */
            .hanzi-decor { display: none; }
        }
    </style>
@endpush

@section('content')
    <div class="catalog-wrapper" id="catalogApp">
        <div class="px-4 md:px-12 lg:px-16">
            <div class="breadcrumbs fade-in-up">
                <a href="{{ route('home') }}">Главная</a>
                <span class="separator">/</span>
                <span class="current">Каталог</span>
            </div>
        </div>

        <div class="px-4 md:px-12 lg:px-16 catalog-header relative section-with-hanzi">
            <h1 class="fade-in-up fade-in-up-delay-1">Каталог товаров</h1>
            <p class="subtitle fade-in-up fade-in-up-delay-2">Оптовые поставки продуктов питания из Китая. Минимальный заказ от 100 000 руб.</p>
            <span class="hanzi-decor xl" style="top:10px;right:40px;opacity:0.04;transform:rotate(5deg);">品</span>
            <span class="hanzi-decor lg" style="bottom:-20px;left:20px;opacity:0.03;transform:rotate(-8deg);">类</span>
        </div>

        <div class="px-4 md:px-12 lg:px-16 fade-in-up fade-in-up-delay-3">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Поиск по названию, описанию..." value="{{ request('search') }}">
                <button class="clear-search" id="clearSearch" style="{{ request('search') ? 'display:block' : '' }}">×</button>
                <span class="search-icon">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M11 11l3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </span>
            </div>

            <div class="filters-wrapper">
                <div class="filters-bar" id="filtersBar">
                    <div class="filter-group">
                        <span class="filter-group-label">Категория</span>
                        <button class="filter-btn {{ !request('category') || request('category') === 'all' ? 'active' : '' }}" data-filter="category" data-value="all">Все</button>
                        @foreach($categories as $category)
                            <button class="filter-btn {{ request('category') === $category->slug ? 'active' : '' }}" data-filter="category" data-value="{{ $category->slug }}">{{ $category->name }}</button>
                        @endforeach
                    </div>
                    <div class="filter-divider"></div>
                    <div class="filter-group">
                        <span class="filter-group-label">Упаковка</span>
                        <button class="filter-btn {{ !request('pack') || request('pack') === 'all-pack' ? 'active' : '' }}" data-filter="pack" data-value="all-pack">Все</button>
                        @foreach($packagingTypes as $type)
                            <button class="filter-btn {{ request('pack') === $type ? 'active' : '' }}" data-filter="pack" data-value="{{ $type }}">{{ $type }}</button>
                        @endforeach
                    </div>

                    <div class="filter-divider"></div>
                    <div class="filter-group">
                        <span class="filter-group-label">Сортировка</span>
                        <div class="custom-select-wrap">
                            <select class="filter-btn" id="sortOrder">
                                <option value="default" {{ !request('sort') || request('sort') === 'default' ? 'selected' : '' }}>По умолчанию</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Название: А → Я</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Популярные</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Новинки</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="toggle-advanced {{ request('weight_from') || request('weight_to') || request('price_from') || request('price_to') || request('shelf_life') ? 'expanded' : '' }}" id="toggleAdvanced">Расширенные фильтры <span class="arrow">▼</span></button>
                <div class="advanced-filters {{ request('weight_from') || request('weight_to') || request('price_from') || request('price_to') || request('shelf_life') ? 'visible' : '' }}" id="advancedFilters">
                    <div class="filters-bar" style="border-bottom:none;padding-bottom:0;">
                        <div class="filter-group">
                            <span class="filter-group-label">Цена (₽)</span>
                            <div class="filter-range">
                                <input type="number" id="priceFrom" placeholder="От" value="{{ request('price_from') }}">
                                <span>—</span>
                                <input type="number" id="priceTo" placeholder="До" value="{{ request('price_to') }}">
                            </div>
                        </div>
                        <div class="filter-divider"></div>
                        <div class="filter-group">
                            <span class="filter-group-label">Вес (г)</span>
                            <div class="filter-range">
                                <input type="number" id="weightFrom" placeholder="От" value="{{ request('weight_from') }}">
                                <span>—</span>
                                <input type="number" id="weightTo" placeholder="До" value="{{ request('weight_to') }}">
                            </div>
                        </div>
                        <div class="filter-divider"></div>
                        <div class="filter-group">
                            <span class="filter-group-label">Срок годности</span>
                            <div class="custom-select-wrap">
                                <select class="filter-btn" id="shelfLife">
                                    <option value="">Любой</option>
                                    <option value="90" {{ request('shelf_life') == '90' ? 'selected' : '' }}>До 90 дней</option>
                                    <option value="180" {{ request('shelf_life') == '180' ? 'selected' : '' }}>До 180 дней</option>
                                    <option value="365" {{ request('shelf_life') == '365' ? 'selected' : '' }}>До 365 дней</option>
                                    <option value="366" {{ request('shelf_life') == '366' ? 'selected' : '' }}>Более 365 дней</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="active-filters" id="activeFilters"></div>
            </div>
        </div>

        <div class="px-4 md:px-12 lg:px-16" style="position:relative;">
            <div class="loading-overlay" id="loadingOverlay"><div class="loading-spinner"></div></div>
            <div class="catalog-grid" id="catalogGrid">
                @include('partials.catalog.products', ['products' => $products])
            </div>
        </div>

        <div class="px-4 md:px-12 lg:px-16" id="paginationContainer">
            @include('partials.catalog.pagination', ['products' => $products])
        </div>

        <div class="px-4 md:px-12 lg:px-16 py-12 lg:py-16 border-t border-black/5 mt-8 relative section-with-hanzi fade-in-up fade-in-up-delay-3">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative z-10">
                <div>
                    <h2 class="font-bold text-[20px] text-black tracking-[-0.3px]">Не нашли нужный товар?</h2>
                    <p class="text-[14px] text-black/30 mt-1 font-light">Мы поставим любую позицию под ваш запрос</p>
                </div>
                <a href="#" data-lead-modal class="inline-block px-10 py-4 bg-black text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02]">Связаться с нами</a>
            </div>
            <span class="hanzi-decor md" style="bottom:10px;right:60px;opacity:0.03;transform:rotate(-5deg);">求</span>
            <span class="hanzi-decor sm" style="top:20px;left:40px;opacity:0.03;transform:rotate(10deg);">需</span>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS инициализируется, но не используется для каталога (можно удалить, если не нужен на других страницах)
        // AOS.init({ duration: 500, once: true, offset: 20, easing: 'ease-out' });

        (function() {
            'use strict';

            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const catalogGrid = document.getElementById('catalogGrid');
            const paginationContainer = document.getElementById('paginationContainer');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const activeFiltersContainer = document.getElementById('activeFilters');
            const toggleAdvanced = document.getElementById('toggleAdvanced');
            const advancedFilters = document.getElementById('advancedFilters');

            let filters = {
                category: '{{ request('category', 'all') }}',
                pack: '{{ request('pack', 'all-pack') }}',
                cert: '{{ request('cert', 'all-cert') }}',
                sort: '{{ request('sort', 'default') }}',
                search: '{{ request('search', '') }}',
                price_from: '{{ request('price_from', '') }}',
                price_to: '{{ request('price_to', '') }}',
                weight_from: '{{ request('weight_from', '') }}',
                weight_to: '{{ request('weight_to', '') }}',
                shelf_life: '{{ request('shelf_life', '') }}'
            };
            let searchTimeout;

            const updateURL = (p) => {
                const url = new URL(window.location);
                Object.keys(p).forEach(k => {
                    if (p[k] && p[k] !== 'all' && p[k] !== 'all-pack' && p[k] !== 'all-cert' && p[k] !== 'default') {
                        url.searchParams.set(k, p[k]);
                    } else {
                        url.searchParams.delete(k);
                    }
                });
                window.history.pushState({}, '', url);
            };

            const loadProducts = () => {
                loadingOverlay.classList.add('active');
                fetch('{{ route("catalog") }}?' + new URLSearchParams(filters).toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(r => r.json())
                    .then(d => {
                        catalogGrid.innerHTML = d.html;
                        paginationContainer.innerHTML = d.pagination;
                        updateActiveFilters();
                        updateURL(filters);
                    })
                    .catch(e => console.error(e))
                    .finally(() => loadingOverlay.classList.remove('active'));
            };

            const updateActiveFilters = () => {
                let h = '';
                const addTag = (key, label) => {
                    h += `<span class="active-filter-tag" data-remove="${key}">${label} <span class="remove">×</span></span>`;
                };

                if (filters.category !== 'all') {
                    const btn = document.querySelector(`[data-filter="category"][data-value="${filters.category}"]`);
                    addTag('category', btn ? btn.textContent : filters.category);
                }
                if (filters.pack !== 'all-pack') {
                    const btn = document.querySelector(`[data-filter="pack"][data-value="${filters.pack}"]`);
                    addTag('pack', btn ? btn.textContent : filters.pack);
                }
                if (filters.cert !== 'all-cert') {
                    const btn = document.querySelector(`[data-filter="cert"][data-value="${filters.cert}"]`);
                    addTag('cert', btn ? btn.textContent : filters.cert);
                }
                if (filters.price_from || filters.price_to) {
                    addTag('price', `Цена ${filters.price_from ? 'от '+filters.price_from : ''} ${filters.price_to ? 'до '+filters.price_to : ''} ₽`);
                }
                if (filters.weight_from || filters.weight_to) {
                    addTag('weight', `Вес ${filters.weight_from ? 'от '+filters.weight_from : ''} ${filters.weight_to ? 'до '+filters.weight_to : ''} г`);
                }
                if (filters.shelf_life) {
                    addTag('shelf_life', `Срок: ${filters.shelf_life} дн.`);
                }
                if (filters.search) {
                    addTag('search', `"${filters.search}"`);
                }
                if (h) {
                    h += `<button class="reset-filters" id="resetAll">Сбросить все</button>`;
                }
                activeFiltersContainer.innerHTML = h;

                document.querySelectorAll('.active-filter-tag').forEach(tag => {
                    tag.addEventListener('click', function() {
                        const k = this.dataset.remove;
                        if (k === 'price') {
                            filters.price_from = ''; filters.price_to = '';
                            document.getElementById('priceFrom').value = ''; document.getElementById('priceTo').value = '';
                        } else if (k === 'weight') {
                            filters.weight_from = ''; filters.weight_to = '';
                            document.getElementById('weightFrom').value = ''; document.getElementById('weightTo').value = '';
                        } else if (k === 'search') {
                            filters.search = ''; searchInput.value = ''; clearSearch.style.display = 'none';
                        } else if (k === 'shelf_life') {
                            filters.shelf_life = ''; document.getElementById('shelfLife').value = '';
                        } else {
                            const allVal = k === 'category' ? 'all' : k === 'pack' ? 'all-pack' : 'all-cert';
                            filters[k] = allVal;
                            document.querySelectorAll(`[data-filter="${k}"]`).forEach(b => {
                                b.classList.remove('active');
                                if (b.dataset.value === allVal) b.classList.add('active');
                            });
                        }
                        loadProducts();
                    });
                });

                const resetBtn = document.getElementById('resetAll');
                if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);
            };

            const resetAllFilters = () => {
                filters = {
                    category: 'all', pack: 'all-pack', cert: 'all-cert', sort: 'default',
                    search: '', price_from: '', price_to: '', weight_from: '', weight_to: '', shelf_life: ''
                };
                searchInput.value = ''; clearSearch.style.display = 'none';
                document.getElementById('priceFrom').value = ''; document.getElementById('priceTo').value = '';
                document.getElementById('weightFrom').value = ''; document.getElementById('weightTo').value = '';
                document.getElementById('shelfLife').value = '';
                document.getElementById('sortOrder').value = 'default';
                document.querySelectorAll('.filter-btn.active').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('[data-value="all"], [data-value="all-pack"], [data-value="all-cert"]').forEach(b => b.classList.add('active'));
                loadProducts();
            };

            // Обработчики фильтров
            document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const group = this.closest('.filter-group');
                    if (group) {
                        group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    }
                    this.classList.add('active');
                    filters[this.dataset.filter] = this.dataset.value;
                    loadProducts();
                });
            });

            document.getElementById('sortOrder').addEventListener('change', function() {
                filters.sort = this.value;
                loadProducts();
            });

            searchInput.addEventListener('input', function() {
                const v = this.value.trim();
                clearSearch.style.display = v ? 'block' : 'none';
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filters.search = v;
                    loadProducts();
                }, 400);
            });

            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                this.style.display = 'none';
                filters.search = '';
                loadProducts();
            });

            toggleAdvanced.addEventListener('click', function() {
                this.classList.toggle('expanded');
                advancedFilters.classList.toggle('visible');
            });

            ['priceFrom','priceTo','weightFrom','weightTo'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                let timer;
                el.addEventListener('input', function() {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        const map = {
                            priceFrom: 'price_from',
                            priceTo: 'price_to',
                            weightFrom: 'weight_from',
                            weightTo: 'weight_to'
                        };
                        filters[map[id]] = this.value;
                        loadProducts();
                    }, 500);
                });
            });

            document.getElementById('shelfLife').addEventListener('change', function() {
                filters.shelf_life = this.value;
                loadProducts();
            });

            // Пагинация
            document.addEventListener('click', function(e) {
                const link = e.target.closest('#paginationContainer a');
                if (link) {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page');
                    if (page) {
                        filters.page = page;
                        loadProducts();
                        window.scrollTo({ top: document.getElementById('catalogApp').offsetTop - 100, behavior: 'smooth' });
                    }
                }
            });

            // Обновление при навигации назад/вперёд
            window.addEventListener('popstate', function() {
                const p = new URLSearchParams(window.location.search);
                filters.category = p.get('category') || 'all';
                filters.pack = p.get('pack') || 'all-pack';
                filters.cert = p.get('cert') || 'all-cert';
                filters.sort = p.get('sort') || 'default';
                filters.search = p.get('search') || '';
                filters.price_from = p.get('price_from') || '';
                filters.price_to = p.get('price_to') || '';
                filters.weight_from = p.get('weight_from') || '';
                filters.weight_to = p.get('weight_to') || '';
                filters.shelf_life = p.get('shelf_life') || '';
                searchInput.value = filters.search;
                clearSearch.style.display = filters.search ? 'block' : 'none';
                loadProducts();
            });

            // Инициализация активных фильтров
            updateActiveFilters();
        })();
    </script>
@endpush
