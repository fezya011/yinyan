{{-- resources/views/catalog.blade.php --}}
@extends('layouts.app')

@section('title', 'Каталог товаров – Инь Ян Экспорт и импорт из Китая')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }

        :root {
            --header-height: 80px;
        }

        .catalog-wrapper {
            padding-top: var(--header-height);
            overflow-x: hidden;
        }

        /* ХЛЕБНЫЕ КРОШКИ */
        .breadcrumbs {
            padding: 20px 0 10px;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            font-weight: 500;
        }

        .breadcrumbs a {
            color: rgba(26, 26, 26, 0.4);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }

        .breadcrumbs a:hover {
            color: #1A1A1A;
        }

        .breadcrumbs .separator {
            margin: 0 8px;
            color: rgba(26, 26, 26, 0.12);
        }

        .breadcrumbs .current {
            color: rgba(26, 26, 26, 0.5);
        }

        /* ЗАГОЛОВОК */
        .catalog-header {
            padding: 20px 0 40px;
            border-bottom: 1px solid rgba(26, 26, 26, 0.04);
            position: relative;
            z-index: 2;
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
            font-size: 14px;
            color: rgba(26, 26, 26, 0.35);
            margin-top: 8px;
            max-width: 500px;
            font-weight: 400;
            line-height: 1.6;
        }

        /* ПОИСК */
        .search-bar {
            position: relative;
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 100%;
            padding: 14px 48px 14px 20px;
            border: 1px solid rgba(26, 26, 26, 0.08);
            background: #FAFAFA;
            font-size: 14px;
            color: #1A1A1A;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .search-bar input:focus {
            border-color: rgba(26, 26, 26, 0.2);
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(26, 26, 26, 0.03);
        }

        .search-bar input::placeholder {
            color: rgba(26, 26, 26, 0.2);
        }

        .search-bar .search-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(26, 26, 26, 0.3);
            pointer-events: none;
        }

        .search-bar .clear-search {
            position: absolute;
            right: 44px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(26, 26, 26, 0.3);
            cursor: pointer;
            font-size: 18px;
            padding: 4px 8px;
            display: none;
            transition: color 0.3s;
        }

        .search-bar .clear-search:hover {
            color: #1A1A1A;
        }

        /* РЕЗУЛЬТАТЫ ПОИСКА */
        .search-results-count {
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            margin-bottom: 16px;
            font-weight: 500;
        }

        /* ФИЛЬТРЫ */
        .filters-wrapper {
            border-bottom: 1px solid rgba(26, 26, 26, 0.04);
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .filters-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 0;
            position: relative;
            z-index: 2;
        }

        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }

        .filter-group-label {
            font-size: 9px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.25);
            margin-right: 4px;
            font-weight: 600;
        }

        .filter-btn {
            padding: 8px 18px;
            border: 1px solid rgba(26, 26, 26, 0.08);
            border-radius: 100px;
            background: transparent;
            font-size: 11px;
            font-weight: 500;
            color: rgba(26, 26, 26, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            appearance: none;
            -webkit-appearance: none;
            text-align: center;
            white-space: nowrap;
        }

        .filter-btn:hover {
            border-color: rgba(26, 26, 26, 0.2);
            color: #1A1A1A;
        }

        .filter-btn.active {
            background: #1A1A1A;
            color: #FFFFFF;
            border-color: #1A1A1A;
        }

        select.filter-btn {
            padding-right: 32px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="rgba(26,26,26,0.4)" d="M6 8L1 3h10z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 12px center;
            cursor: pointer;
        }

        .filter-divider {
            width: 1px;
            height: 28px;
            background: rgba(26, 26, 26, 0.06);
            margin: 0 4px;
        }

        /* ПРОДВИНУТЫЕ ФИЛЬТРЫ */
        .advanced-filters {
            display: none;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(26, 26, 26, 0.04);
        }

        .advanced-filters.visible {
            display: block;
        }

        .filter-range {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-range input {
            width: 100px;
            padding: 6px 10px;
            border: 1px solid rgba(26, 26, 26, 0.08);
            background: #FAFAFA;
            font-size: 12px;
            color: #1A1A1A;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s;
        }

        .filter-range input:focus {
            border-color: rgba(26, 26, 26, 0.2);
        }

        .filter-range span {
            font-size: 12px;
            color: rgba(26, 26, 26, 0.3);
        }

        .filter-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 12px;
            color: rgba(26, 26, 26, 0.5);
        }

        .filter-checkbox input {
            accent-color: #1A1A1A;
        }

        .toggle-advanced {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.4);
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 0;
            transition: color 0.3s;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
        }

        .toggle-advanced:hover {
            color: #1A1A1A;
        }

        .toggle-advanced .arrow {
            transition: transform 0.3s;
            font-size: 8px;
        }

        .toggle-advanced.expanded .arrow {
            transform: rotate(180deg);
        }

        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .active-filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(26, 26, 26, 0.03);
            font-size: 10px;
            color: rgba(26, 26, 26, 0.5);
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 450;
        }

        .active-filter-tag:hover {
            background: rgba(26, 26, 26, 0.06);
            color: #1A1A1A;
        }

        .active-filter-tag .remove {
            font-size: 14px;
            line-height: 1;
        }

        .reset-filters {
            font-size: 10px;
            color: rgba(26, 26, 26, 0.3);
            cursor: pointer;
            text-decoration: underline;
            transition: color 0.3s;
            font-weight: 500;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
        }

        .reset-filters:hover {
            color: #1A1A1A;
        }

        /* СЕТКА ТОВАРОВ */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1px;
            padding: 0;
            background: rgba(26, 26, 26, 0.04);
        }

        .product-card {
            background: #FFFFFF;
            padding: 24px 32px 32px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            border: none;
            z-index: 1;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(26, 26, 26, 0.06);
            z-index: 10;
        }

        /* ИСПРАВЛЕННЫЙ БЕЙДЖ */
        .product-card .image-wrap {
            width: 100%;
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            background: #FAFAFA;
            overflow: hidden;
            position: relative;
        }

        .product-card .badge {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 12px;
            font-weight: 600;
            background: #1A1A1A;
            color: #FFFFFF;
            z-index: 2;
        }

        .product-card .image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 24px;
            position: relative;
            z-index: 1;
        }

        .product-card:hover .image-wrap img {
            transform: scale(1.06);
        }

        .product-card .image-wrap .no-image {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: rgba(26, 26, 26, 0.15);
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .product-card .category-tag {
            font-size: 9px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.25);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .product-card .product-name {
            font-weight: 700;
            font-size: 18px;
            color: #1A1A1A;
            line-height: 1.3;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .product-card .product-desc {
            font-size: 13px;
            color: rgba(26, 26, 26, 0.4);
            line-height: 1.6;
            flex-grow: 1;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .product-card .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 16px;
            margin-bottom: 20px;
            padding-top: 16px;
            border-top: 1px solid rgba(26, 26, 26, 0.04);
        }

        .product-card .product-meta .meta-item {
            font-size: 10px;
            color: rgba(26, 26, 26, 0.3);
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 450;
        }

        .product-card .product-meta .meta-item strong {
            color: rgba(26, 26, 26, 0.5);
            font-weight: 500;
        }

        .product-card .certificates {
            display: flex;
            gap: 6px;
            margin-bottom: 12px;
        }

        .product-card .cert-badge {
            font-size: 7px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 8px;
            background: rgba(26, 26, 26, 0.03);
            color: rgba(26, 26, 26, 0.3);
            font-weight: 500;
        }

        .product-card .cert-badge.has {
            background: #1A1A1A;
            color: #FFFFFF;
        }

        .product-card .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .product-card .price {
            font-weight: 700;
            font-size: 20px;
            color: #1A1A1A;
            letter-spacing: -0.5px;
        }

        .product-card .price .from {
            font-weight: 400;
            font-size: 11px;
            color: rgba(26, 26, 26, 0.3);
            margin-right: 2px;
        }

        .product-card .btn-order {
            padding: 10px 24px;
            background: #1A1A1A;
            color: #FFFFFF;
            border: none;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .product-card .btn-order:hover {
            background: #000000;
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(26, 26, 26, 0.1);
        }

        /* ПАГИНАЦИЯ */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            padding: 40px 0 80px;
        }

        /* ПУСТОЙ КАТАЛОГ */
        .empty-catalog {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            color: rgba(26, 26, 26, 0.2);
            background: #FFFFFF;
        }

        .empty-catalog .empty-icon {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 64px;
            font-weight: 900;
            opacity: 0.2;
            display: block;
            margin-bottom: 16px;
        }

        .empty-catalog .empty-text {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* ЗАГРУЗКА */
        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .loading-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .loading-spinner {
            width: 30px;
            height: 30px;
            border: 2px solid rgba(26, 26, 26, 0.1);
            border-top-color: #1A1A1A;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: #1A1A1A;
            line-height: 1;
            z-index: 0;
            transition: opacity 1s ease;
        }

        .hanzi-decor.xl { font-size: 140px; }
        .hanzi-decor.lg { font-size: 100px; }
        .hanzi-decor.md { font-size: 70px; }
        .hanzi-decor.sm { font-size: 45px; }
        .hanzi-decor.xs { font-size: 28px; }

        /* АДАПТИВ */
        @media (max-width: 768px) {
            .catalog-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }

            .product-card {
                padding: 20px 20px 24px;
            }

            .product-card .image-wrap {
                height: 180px;
            }

            .filters-bar {
                gap: 8px;
                padding: 0;
                overflow-x: auto;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
            }

            .filters-bar::-webkit-scrollbar {
                display: none;
            }

            .filter-divider {
                flex-shrink: 0;
            }

            .filter-group {
                flex-shrink: 0;
            }

            .hanzi-decor.xl { font-size: 100px; opacity: 0.04 !important; }
            .hanzi-decor.lg { font-size: 70px; opacity: 0.03 !important; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.02 !important; }
        }

        @media (max-width: 480px) {
            .catalog-grid {
                grid-template-columns: 1fr 1fr;
            }

            .product-card {
                padding: 14px 12px 18px;
            }

            .product-card .image-wrap {
                height: 140px;
            }

            .product-card .product-name {
                font-size: 14px;
            }

            .product-card .price {
                font-size: 16px;
            }

            .product-card .btn-order {
                padding: 8px 14px;
                font-size: 8px;
            }

            .filter-range input {
                width: 70px;
            }

            .hanzi-decor { display: none; }
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FFFFFF; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }

        [data-aos] {
            transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .product-card:hover {
                transform: none !important;
            }
            .product-card:hover .image-wrap img {
                transform: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="catalog-wrapper" id="catalogApp">
        <!-- ХЛЕБНЫЕ КРОШКИ -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="breadcrumbs" data-aos="fade-up">
                <a href="{{ route('home') }}">Главная</a>
                <span class="separator">/</span>
                <span class="current">Каталог</span>
            </div>
        </div>

        <!-- ЗАГОЛОВОК -->
        <div class="px-6 md:px-12 lg:px-16 catalog-header relative section-with-hanzi">
            <h1 data-aos="fade-up" data-aos-delay="100">Каталог товаров</h1>
            <p class="subtitle" data-aos="fade-up" data-aos-delay="200">
                Оптовые поставки продуктов питания из Китая. Минимальный заказ от 100 000 руб.
            </p>
            <span class="hanzi-decor xl" style="top: 10px; right: 40px; opacity: 0.04; transform: rotate(5deg);" data-aos="fade-left" data-aos-delay="300">品</span>
            <span class="hanzi-decor lg" style="bottom: -20px; left: 20px; opacity: 0.03; transform: rotate(-8deg);" data-aos="fade-right" data-aos-delay="400">类</span>
        </div>

        <!-- ПОИСК И ФИЛЬТРЫ -->
        <div class="px-6 md:px-12 lg:px-16" data-aos="fade-up" data-aos-delay="150">
            <!-- Поисковая строка -->
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

            <!-- Счётчик результатов -->
            <div class="search-results-count" id="resultsCount">
                Найдено: {{ $products->total() }} товаров
            </div>

            <div class="filters-wrapper">
                <!-- Основные фильтры -->
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
                        <button class="filter-btn {{ request('pack') === 'cup' ? 'active' : '' }}" data-filter="pack" data-value="cup">Стакан</button>
                        <button class="filter-btn {{ request('pack') === 'pouch' ? 'active' : '' }}" data-filter="pack" data-value="pouch">Мягкая</button>
                        <button class="filter-btn {{ request('pack') === 'box' ? 'active' : '' }}" data-filter="pack" data-value="box">Коробка</button>
                    </div>

                    <div class="filter-divider"></div>

                    <div class="filter-group">
                        <span class="filter-group-label">Сертификаты</span>
                        <button class="filter-btn {{ !request('cert') || request('cert') === 'all-cert' ? 'active' : '' }}" data-filter="cert" data-value="all-cert">Все</button>
                        <button class="filter-btn {{ request('cert') === 'eac' ? 'active' : '' }}" data-filter="cert" data-value="eac">ЕАС</button>
                        <button class="filter-btn {{ request('cert') === 'honest' ? 'active' : '' }}" data-filter="cert" data-value="honest">Честный знак</button>
                    </div>

                    <div class="filter-divider"></div>

                    <div class="filter-group">
                        <span class="filter-group-label">Сортировка</span>
                        <select class="filter-btn" id="sortOrder">
                            <option value="default" {{ !request('sort') || request('sort') === 'default' ? 'selected' : '' }}>По умолчанию</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Цена: низкая → высокая</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Цена: высокая → низкая</option>
                            <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Название: А → Я</option>
                            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Популярные</option>
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Новинки</option>
                        </select>
                    </div>
                </div>

                <!-- Кнопка расширенных фильтров -->
                <button class="toggle-advanced {{ request('weight_from') || request('weight_to') || request('price_from') || request('price_to') || request('shelf_life') || request('pieces_per_box') ? 'expanded' : '' }}" id="toggleAdvanced">
                    Расширенные фильтры <span class="arrow">▼</span>
                </button>

                <!-- Расширенные фильтры -->
                <div class="advanced-filters {{ request('weight_from') || request('weight_to') || request('price_from') || request('price_to') || request('shelf_life') || request('pieces_per_box') ? 'visible' : '' }}" id="advancedFilters">
                    <div class="filters-bar" style="border-bottom: none; padding-bottom: 0;">
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
                            <select class="filter-btn" id="shelfLife">
                                <option value="">Любой</option>
                                <option value="90" {{ request('shelf_life') == '90' ? 'selected' : '' }}>До 90 дней</option>
                                <option value="180" {{ request('shelf_life') == '180' ? 'selected' : '' }}>До 180 дней</option>
                                <option value="365" {{ request('shelf_life') == '365' ? 'selected' : '' }}>До 365 дней</option>
                                <option value="366" {{ request('shelf_life') == '366' ? 'selected' : '' }}>Более 365 дней</option>
                            </select>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-group">
                            <span class="filter-group-label">Штук в коробке</span>
                            <select class="filter-btn" id="piecesPerBox">
                                <option value="">Любое</option>
                                <option value="12" {{ request('pieces_per_box') == '12' ? 'selected' : '' }}>12</option>
                                <option value="24" {{ request('pieces_per_box') == '24' ? 'selected' : '' }}>24</option>
                                <option value="36" {{ request('pieces_per_box') == '36' ? 'selected' : '' }}>36</option>
                                <option value="48" {{ request('pieces_per_box') == '48' ? 'selected' : '' }}>48</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Активные фильтры -->
                <div class="active-filters" id="activeFilters"></div>
            </div>
        </div>

        <!-- СЕТКА ТОВАРОВ -->
        <div class="px-6 md:px-12 lg:px-16" style="position: relative;">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner"></div>
            </div>
            <div class="catalog-grid" id="catalogGrid">
                @include('partials.catalog.products', ['products' => $products])
            </div>
        </div>

        <!-- ПАГИНАЦИЯ -->
        <div class="px-6 md:px-12 lg:px-16" id="paginationContainer">
            @include('partials.catalog.pagination', ['products' => $products])
        </div>

        <!-- СЕКЦИЯ СВЯЗАТЬСЯ -->
        <div class="px-6 md:px-12 lg:px-16 py-12 lg:py-16 border-t border-black/5 mt-8 relative section-with-hanzi" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative z-10">
                <div>
                    <h2 class="font-bold text-[20px] text-black tracking-[-0.3px]">Не нашли нужный товар?</h2>
                    <p class="text-[14px] text-black/30 mt-1 font-light">Мы поставим любую позицию под ваш запрос</p>
                </div>
                <a href="{{ route('contacts') }}" class="inline-block px-10 py-4 bg-black text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02]">Связаться с нами</a>
            </div>
            <span class="hanzi-decor md" style="bottom: 10px; right: 60px; opacity: 0.03; transform: rotate(-5deg);">求</span>
            <span class="hanzi-decor sm" style="top: 20px; left: 40px; opacity: 0.03; transform: rotate(10deg);">需</span>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 500,
            once: true,
            offset: 20,
            easing: 'ease-out'
        });

        (function() {
            // Элементы
            const searchInput = document.getElementById('searchInput');
            const clearSearch = document.getElementById('clearSearch');
            const resultsCount = document.getElementById('resultsCount');
            const catalogGrid = document.getElementById('catalogGrid');
            const paginationContainer = document.getElementById('paginationContainer');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const activeFiltersContainer = document.getElementById('activeFilters');
            const toggleAdvanced = document.getElementById('toggleAdvanced');
            const advancedFilters = document.getElementById('advancedFilters');

            // Состояние фильтров
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
                shelf_life: '{{ request('shelf_life', '') }}',
                pieces_per_box: '{{ request('pieces_per_box', '') }}'
            };

            let searchTimeout;

            // Функция для обновления URL без перезагрузки
            function updateURL(params) {
                const url = new URL(window.location);
                Object.keys(params).forEach(key => {
                    if (params[key] && params[key] !== 'all' && params[key] !== 'all-pack' && params[key] !== 'all-cert' && params[key] !== 'default') {
                        url.searchParams.set(key, params[key]);
                    } else {
                        url.searchParams.delete(key);
                    }
                });
                window.history.pushState({}, '', url);
            }

            // Функция для загрузки товаров через AJAX
            function loadProducts() {
                loadingOverlay.classList.add('active');

                const params = new URLSearchParams(filters);

                fetch('{{ route("catalog") }}?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        catalogGrid.innerHTML = data.html;
                        paginationContainer.innerHTML = data.pagination;
                        updateResultsCount(data.total || 0);
                        updateActiveFilters();
                        updateURL(filters);

                        // Реинициализация AOS для новых элементов
                        AOS.refresh();
                    })
                    .catch(error => {
                        console.error('Ошибка загрузки:', error);
                    })
                    .finally(() => {
                        loadingOverlay.classList.remove('active');
                    });
            }

            // Обновление счётчика
            function updateResultsCount(total) {
                resultsCount.textContent = `Найдено: ${total} товаров`;
            }

            // Обновление активных фильтров
            function updateActiveFilters() {
                let html = '';

                if (filters.category !== 'all') {
                    const btn = document.querySelector(`[data-filter="category"][data-value="${filters.category}"]`);
                    const name = btn ? btn.textContent : filters.category;
                    html += `<span class="active-filter-tag" data-remove="category">${name} <span class="remove">×</span></span>`;
                }

                if (filters.pack !== 'all-pack') {
                    const btn = document.querySelector(`[data-filter="pack"][data-value="${filters.pack}"]`);
                    const name = btn ? btn.textContent : filters.pack;
                    html += `<span class="active-filter-tag" data-remove="pack">${name} <span class="remove">×</span></span>`;
                }

                if (filters.cert !== 'all-cert') {
                    const btn = document.querySelector(`[data-filter="cert"][data-value="${filters.cert}"]`);
                    const name = btn ? btn.textContent : filters.cert;
                    html += `<span class="active-filter-tag" data-remove="cert">${name} <span class="remove">×</span></span>`;
                }

                if (filters.price_from || filters.price_to) {
                    const from = filters.price_from ? `от ${filters.price_from}` : '';
                    const to = filters.price_to ? `до ${filters.price_to}` : '';
                    html += `<span class="active-filter-tag" data-remove="price">Цена ${from} ${to} ₽ <span class="remove">×</span></span>`;
                }

                if (filters.weight_from || filters.weight_to) {
                    const from = filters.weight_from ? `от ${filters.weight_from}` : '';
                    const to = filters.weight_to ? `до ${filters.weight_to}` : '';
                    html += `<span class="active-filter-tag" data-remove="weight">Вес ${from} ${to} г <span class="remove">×</span></span>`;
                }

                if (filters.shelf_life) {
                    html += `<span class="active-filter-tag" data-remove="shelf_life">Срок: ${filters.shelf_life} дн. <span class="remove">×</span></span>`;
                }

                if (filters.pieces_per_box) {
                    html += `<span class="active-filter-tag" data-remove="pieces_per_box">${filters.pieces_per_box} шт/кор <span class="remove">×</span></span>`;
                }

                if (filters.search) {
                    html += `<span class="active-filter-tag" data-remove="search">"${filters.search}" <span class="remove">×</span></span>`;
                }

                if (html) {
                    html += `<button class="reset-filters" id="resetAll">Сбросить все</button>`;
                }

                activeFiltersContainer.innerHTML = html;

                // Обработчики для удаления фильтров
                document.querySelectorAll('.active-filter-tag').forEach(tag => {
                    tag.addEventListener('click', function() {
                        const removeKey = this.dataset.remove;
                        if (removeKey === 'price') {
                            filters.price_from = '';
                            filters.price_to = '';
                            document.getElementById('priceFrom').value = '';
                            document.getElementById('priceTo').value = '';
                        } else if (removeKey === 'weight') {
                            filters.weight_from = '';
                            filters.weight_to = '';
                            document.getElementById('weightFrom').value = '';
                            document.getElementById('weightTo').value = '';
                        } else if (removeKey === 'search') {
                            filters.search = '';
                            searchInput.value = '';
                            clearSearch.style.display = 'none';
                        } else {
                            filters[removeKey] = removeKey === 'category' ? 'all' :
                                removeKey === 'pack' ? 'all-pack' :
                                    removeKey === 'cert' ? 'all-cert' : '';

                            // Обновить кнопки
                            document.querySelectorAll(`[data-filter="${removeKey}"]`).forEach(btn => {
                                btn.classList.remove('active');
                                if (btn.dataset.value === filters[removeKey]) {
                                    btn.classList.add('active');
                                }
                            });
                        }

                        loadProducts();
                    });
                });

                // Сброс всех фильтров
                const resetBtn = document.getElementById('resetAll');
                if (resetBtn) {
                    resetBtn.addEventListener('click', resetAllFilters);
                }
            }

            function resetAllFilters() {
                filters = {
                    category: 'all',
                    pack: 'all-pack',
                    cert: 'all-cert',
                    sort: 'default',
                    search: '',
                    price_from: '',
                    price_to: '',
                    weight_from: '',
                    weight_to: '',
                    shelf_life: '',
                    pieces_per_box: ''
                };

                searchInput.value = '';
                clearSearch.style.display = 'none';
                document.getElementById('priceFrom').value = '';
                document.getElementById('priceTo').value = '';
                document.getElementById('weightFrom').value = '';
                document.getElementById('weightTo').value = '';
                document.getElementById('shelfLife').value = '';
                document.getElementById('piecesPerBox').value = '';
                document.getElementById('sortOrder').value = 'default';

                document.querySelectorAll('.filter-btn.active').forEach(btn => {
                    btn.classList.remove('active');
                });
                document.querySelectorAll('[data-value="all"], [data-value="all-pack"], [data-value="all-cert"]').forEach(btn => {
                    btn.classList.add('active');
                });

                loadProducts();
            }

            // Обработчики фильтров
            document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const filterKey = this.dataset.filter;
                    const filterValue = this.dataset.value;

                    // Обновить активный класс
                    const group = this.closest('.filter-group');
                    group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    filters[filterKey] = filterValue;
                    loadProducts();
                });
            });

            // Сортировка
            document.getElementById('sortOrder').addEventListener('change', function() {
                filters.sort = this.value;
                loadProducts();
            });

            // Поиск с задержкой
            searchInput.addEventListener('input', function() {
                const value = this.value.trim();
                clearSearch.style.display = value ? 'block' : 'none';

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filters.search = value;
                    loadProducts();
                }, 400);
            });

            // Очистка поиска
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                this.style.display = 'none';
                filters.search = '';
                loadProducts();
            });

            // Расширенные фильтры
            toggleAdvanced.addEventListener('click', function() {
                this.classList.toggle('expanded');
                advancedFilters.classList.toggle('visible');
            });

            // Применение диапазонов цен и веса
            ['priceFrom', 'priceTo', 'weightFrom', 'weightTo'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;

                let timeout;
                el.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        if (id === 'priceFrom') filters.price_from = this.value;
                        if (id === 'priceTo') filters.price_to = this.value;
                        if (id === 'weightFrom') filters.weight_from = this.value;
                        if (id === 'weightTo') filters.weight_to = this.value;
                        loadProducts();
                    }, 500);
                });
            });

            // Срок годности
            document.getElementById('shelfLife').addEventListener('change', function() {
                filters.shelf_life = this.value;
                loadProducts();
            });

            // Штук в коробке
            document.getElementById('piecesPerBox').addEventListener('change', function() {
                filters.pieces_per_box = this.value;
                loadProducts();
            });

            // Обработчики кнопок "Заказать"
            document.addEventListener('click', function(e) {
                if (e.target.closest('.btn-order')) {
                    const btn = e.target.closest('.btn-order');
                    const name = btn.dataset.name || 'Товар';
                    const price = btn.dataset.price || '0';
                    const formattedPrice = new Intl.NumberFormat('ru-RU').format(price);

                    alert(`Заявка на "${name}"\nЦена: от ${formattedPrice} руб.\n\nСвяжитесь с нами для оформления заказа.\nТел: +7 999 618 28 82\nEmail: eksport.inyan@mail.ru`);
                }
            });

            // Обработчики пагинации (делегирование)
            document.addEventListener('click', function(e) {
                const pageLink = e.target.closest('#paginationContainer a');
                if (pageLink) {
                    e.preventDefault();
                    const url = new URL(pageLink.href);
                    const page = url.searchParams.get('page');
                    if (page) {
                        filters.page = page;
                        loadProducts();
                        window.scrollTo({ top: document.getElementById('catalogApp').offsetTop - 100, behavior: 'smooth' });
                    }
                }
            });

            // Инициализация активных фильтров при загрузке
            updateActiveFilters();

            // Обработка кнопок "назад/вперёд" браузера
            window.addEventListener('popstate', function() {
                const params = new URLSearchParams(window.location.search);
                filters.category = params.get('category') || 'all';
                filters.pack = params.get('pack') || 'all-pack';
                filters.cert = params.get('cert') || 'all-cert';
                filters.sort = params.get('sort') || 'default';
                filters.search = params.get('search') || '';
                filters.price_from = params.get('price_from') || '';
                filters.price_to = params.get('price_to') || '';
                filters.weight_from = params.get('weight_from') || '';
                filters.weight_to = params.get('weight_to') || '';
                filters.shelf_life = params.get('shelf_life') || '';
                filters.pieces_per_box = params.get('pieces_per_box') || '';

                searchInput.value = filters.search;
                clearSearch.style.display = filters.search ? 'block' : 'none';

                loadProducts();
            });
        })();
    </script>
@endpush
