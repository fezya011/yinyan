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
            color: #111827;
            -webkit-font-smoothing: antialiased;
        }

        :root {
            --accent-r: 255;
            --accent-g: 107;
            --accent-b: 0;
            --header-height: 80px;
        }

        /* ===== ОТСТУП ПОД ХЕДЕР ===== */
        .catalog-wrapper {
            padding-top: var(--header-height);
        }

        /* ===== ХЛЕБНЫЕ КРОШКИ ===== */
        .breadcrumbs {
            padding: 20px 0 10px;
            font-size: 12px;
            color: rgba(0,0,0,0.3);
        }

        .breadcrumbs a {
            color: rgba(0,0,0,0.5);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumbs a:hover {
            color: #111827;
        }

        .breadcrumbs .separator {
            margin: 0 8px;
            color: rgba(0,0,0,0.15);
        }

        .breadcrumbs .current {
            color: rgba(0,0,0,0.6);
            font-weight: 500;
        }

        /* ===== ЗАГОЛОВОК КАТАЛОГА ===== */
        .catalog-header {
            padding: 20px 0 40px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        .catalog-header h1 {
            font-weight: 900;
            font-size: clamp(32px, 4vw, 52px);
            letter-spacing: -1.5px;
            text-transform: uppercase;
            color: #000;
            line-height: 1.1;
        }

        .catalog-header .subtitle {
            font-size: 14px;
            color: rgba(0,0,0,0.35);
            margin-top: 8px;
            max-width: 500px;
        }

        /* ===== ФИЛЬТРЫ ===== */
        .filters-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding: 24px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
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
            color: rgba(0,0,0,0.25);
            margin-right: 4px;
            font-weight: 600;
        }

        .filter-btn {
            padding: 6px 16px;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 100px;
            background: transparent;
            font-size: 11px;
            font-weight: 500;
            color: rgba(0,0,0,0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .filter-btn:hover {
            border-color: rgba(0,0,0,0.15);
            color: #111827;
        }

        .filter-btn.active {
            background: #111827;
            color: #FFFFFF;
            border-color: #111827;
        }

        .filter-divider {
            width: 1px;
            height: 28px;
            background: rgba(0,0,0,0.06);
            margin: 0 4px;
        }

        /* ===== СЕТКА ТОВАРОВ ===== */
        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2px;
            padding: 32px 0 60px;
            background: rgba(0,0,0,0.02);
        }

        .product-card {
            background: #FFFFFF;
            padding: 28px 24px 32px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            border: 1px solid transparent;
        }

        .product-card:hover {
            transform: translateY(-4px);
            border-color: rgba(0,0,0,0.04);
            box-shadow: 0 12px 40px rgba(0,0,0,0.04);
            z-index: 2;
        }

        .product-card .badge {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 7px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 100px;
            font-weight: 600;
            background: #F5F5F5;
            color: rgba(0,0,0,0.3);
        }

        .product-card .badge.hit {
            background: #111827;
            color: #FFFFFF;
        }

        .product-card .badge.new {
            background: rgb(var(--accent-r), var(--accent-g), var(--accent-b));
            color: #FFFFFF;
        }

        .product-card .image-wrap {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            background: #FAFAFA;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-card .image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 12px;
        }

        .product-card:hover .image-wrap img {
            transform: scale(1.04);
        }

        .product-card .emoji-big {
            font-size: 64px;
            line-height: 1;
        }

        .product-card .category-tag {
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(0,0,0,0.2);
            margin-bottom: 6px;
            font-weight: 500;
        }

        .product-card .product-name {
            font-weight: 700;
            font-size: 16px;
            color: #111827;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .product-card .product-desc {
            font-size: 12px;
            color: rgba(0,0,0,0.3);
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 12px;
        }

        .product-card .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 16px;
            margin-bottom: 12px;
            padding-top: 10px;
            border-top: 1px solid rgba(0,0,0,0.04);
        }

        .product-card .product-meta .meta-item {
            font-size: 10px;
            color: rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .product-card .product-meta .meta-item .meta-icon {
            font-size: 11px;
            line-height: 1;
        }

        .product-card .product-meta .meta-item strong {
            color: rgba(0,0,0,0.5);
            font-weight: 500;
        }

        .product-card .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 4px;
        }

        .product-card .price {
            font-weight: 700;
            font-size: 18px;
            color: #111827;
            letter-spacing: -0.3px;
        }

        .product-card .price .from {
            font-weight: 400;
            font-size: 11px;
            color: rgba(0,0,0,0.25);
        }

        .product-card .btn-order {
            padding: 8px 20px;
            background: #111827;
            color: #FFFFFF;
            border: none;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            border-radius: 4px;
        }

        .product-card .btn-order:hover {
            background: #000000;
            transform: scale(1.02);
        }

        /* ===== ПАГИНАЦИЯ ===== */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            padding: 20px 0 60px;
        }

        .pagination-wrap .page-btn {
            width: 40px;
            height: 40px;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 4px;
            background: transparent;
            font-size: 13px;
            font-weight: 500;
            color: rgba(0,0,0,0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .pagination-wrap .page-btn:hover {
            border-color: rgba(0,0,0,0.15);
            color: #111827;
        }

        .pagination-wrap .page-btn.active {
            background: #111827;
            color: #FFFFFF;
            border-color: #111827;
        }

        .pagination-wrap .page-btn.arrow {
            font-size: 14px;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 768px) {
            .catalog-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 1px;
            }

            .product-card {
                padding: 20px 16px 24px;
            }

            .product-card .image-wrap {
                height: 140px;
            }

            .filters-bar {
                gap: 8px;
                padding: 16px 0;
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
        }

        @media (max-width: 480px) {
            .catalog-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1px;
            }

            .product-card {
                padding: 14px 12px 18px;
            }

            .product-card .image-wrap {
                height: 110px;
            }

            .product-card .product-name {
                font-size: 13px;
            }

            .product-card .price {
                font-size: 15px;
            }

            .product-card .btn-order {
                padding: 6px 12px;
                font-size: 7px;
            }

            .product-card .product-meta .meta-item {
                font-size: 8px;
            }
        }

        /* ===== СКРОЛЛБАР ===== */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FFFFFF; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }

        /* ===== AOS ===== */
        [data-aos] {
            transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* ===== REDUCED MOTION ===== */
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
    <div class="catalog-wrapper">
        <!-- ===== ХЛЕБНЫЕ КРОШКИ ===== -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="breadcrumbs" data-aos="fade-up">
                <a href="/">Главная</a>
                <span class="separator">/</span>
                <span class="current">Каталог</span>
            </div>
        </div>

        <!-- ===== ЗАГОЛОВОК ===== -->
        <div class="px-6 md:px-12 lg:px-16 catalog-header" data-aos="fade-up" data-aos-delay="100">
            <h1>Каталог товаров</h1>
            <p class="subtitle">Оптовые поставки продуктов питания из Китая. Минимальный заказ от 100 000 руб.</p>
        </div>

        <!-- ===== ФИЛЬТРЫ ===== -->
        <div class="px-6 md:px-12 lg:px-16 filters-bar" data-aos="fade-up" data-aos-delay="150">
            <div class="filter-group">
                <span class="filter-group-label">Категория</span>
                <button class="filter-btn active" data-filter="all">Все</button>
                <button class="filter-btn" data-filter="noodles">Лапша</button>
                <button class="filter-btn" data-filter="wonton">Вонтоны</button>
                <button class="filter-btn" data-filter="rice">Рис</button>
                <button class="filter-btn" data-filter="soup">Супы</button>
            </div>

            <div class="filter-divider"></div>

            <div class="filter-group">
                <span class="filter-group-label">Упаковка</span>
                <button class="filter-btn active" data-filter="all-pack">Все</button>
                <button class="filter-btn" data-filter="cup">Стакан</button>
                <button class="filter-btn" data-filter="pouch">Мягкая</button>
                <button class="filter-btn" data-filter="box">Коробка</button>
            </div>
        </div>

        <!-- ===== СЕТКА ТОВАРОВ ===== -->
        <div class="px-6 md:px-12 lg:px-16 catalog-grid" id="catalogGrid">
            @php
                $catalogProducts = [
                    [
                        'id' => 1,
                        'name' => 'Лапша быстрого приготовления в стакане',
                        'desc' => 'Говядина. Удобный формат для розничных сетей и HoReCa.',
                        'category' => 'noodles',
                        'pack' => 'cup',
                        'badge' => 'Хит',
                        'badgeType' => 'hit',
                        'image' => 'images/product-1.png',
                        'price' => '45',
                        'priceUnit' => 'шт',
                        'minOrder' => '1000 шт',
                        'weight' => '85 г',
                        'shelfLife' => '12 мес',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Лапша с вонтонами',
                        'desc' => 'Фирменный продукт. Уникальная позиция с высокой маржинальностью.',
                        'category' => 'wonton',
                        'pack' => 'cup',
                        'badge' => 'Уникальный',
                        'badgeType' => 'new',
                        'image' => 'images/product-2.png',
                        'price' => '85',
                        'priceUnit' => 'шт',
                        'minOrder' => '500 шт',
                        'weight' => '120 г',
                        'shelfLife' => '12 мес',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Сублимированная лапша',
                        'desc' => 'Говядина, курица, морепродукты. Высокая маржинальность.',
                        'category' => 'noodles',
                        'pack' => 'pouch',
                        'badge' => 'Маржа 40%',
                        'badgeType' => 'hit',
                        'image' => 'images/product-3.png',
                        'price' => '55',
                        'priceUnit' => 'шт',
                        'minOrder' => '800 шт',
                        'weight' => '70 г',
                        'shelfLife' => '18 мес',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Рис быстрого приготовления',
                        'desc' => 'Бекон, говядина с перцем, курица, тушёное мясо. 4 вкуса.',
                        'category' => 'rice',
                        'pack' => 'pouch',
                        'badge' => 'Новинка',
                        'badgeType' => 'new',
                        'image' => 'images/product-1.png',
                        'price' => '65',
                        'priceUnit' => 'шт',
                        'minOrder' => '500 шт',
                        'weight' => '100 г',
                        'shelfLife' => '14 мес',
                    ],
                    [
                        'id' => 5,
                        'name' => 'Лапша с говядиной в стакане',
                        'desc' => 'Классический вкус. Стабильные продажи во всех каналах.',
                        'category' => 'noodles',
                        'pack' => 'cup',
                        'badge' => 'Бестселлер',
                        'badgeType' => 'hit',
                        'image' => 'images/product-1.png',
                        'price' => '42',
                        'priceUnit' => 'шт',
                        'minOrder' => '1500 шт',
                        'weight' => '80 г',
                        'shelfLife' => '12 мес',
                    ],
                    [
                        'id' => 6,
                        'name' => 'Лапша с курицей в стакане',
                        'desc' => 'Нежный вкус. Хит среди детского и семейного ассортимента.',
                        'category' => 'noodles',
                        'pack' => 'cup',
                        'badge' => 'Хит',
                        'badgeType' => 'hit',
                        'image' => 'images/product-1.png',
                        'price' => '42',
                        'priceUnit' => 'шт',
                        'minOrder' => '1500 шт',
                        'weight' => '80 г',
                        'shelfLife' => '12 мес',
                    ],
                    [
                        'id' => 7,
                        'name' => 'Вонтоны с креветкой',
                        'desc' => 'Премиальная позиция. Для ресторанов и дорогих розничных сетей.',
                        'category' => 'wonton',
                        'pack' => 'box',
                        'badge' => 'Премиум',
                        'badgeType' => 'new',
                        'image' => 'images/product-2.png',
                        'price' => '120',
                        'priceUnit' => 'шт',
                        'minOrder' => '300 шт',
                        'weight' => '150 г',
                        'shelfLife' => '10 мес',
                    ],
                    [
                        'id' => 8,
                        'name' => 'Суп мисо с тофу',
                        'desc' => 'Сублимированный суп. Быстрое приготовление, высокий спрос.',
                        'category' => 'soup',
                        'pack' => 'pouch',
                        'badge' => 'Тренд',
                        'badgeType' => 'new',
                        'image' => 'images/product-3.png',
                        'price' => '38',
                        'priceUnit' => 'шт',
                        'minOrder' => '1000 шт',
                        'weight' => '50 г',
                        'shelfLife' => '18 мес',
                    ],
                ];
            @endphp

            @foreach($catalogProducts as $index => $product)
                <div class="product-card"
                     data-aos="fade-up"
                     data-aos-delay="{{ 50 + ($index % 4) * 100 }}"
                     data-category="{{ $product['category'] }}"
                     data-pack="{{ $product['pack'] }}"
                     data-id="{{ $product['id'] }}">

                    @if($product['badge'])
                        <span class="badge {{ $product['badgeType'] }}">{{ $product['badge'] }}</span>
                    @endif

                    <div class="image-wrap">
                        @if($product['image'] && file_exists(public_path($product['image'])))
                            <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" loading="lazy">
                        @else
                            <span class="emoji-big">&#127836;</span>
                        @endif
                    </div>

                    <div class="category-tag">{{ strtoupper(str_replace('_', ' ', $product['category'])) }}</div>
                    <div class="product-name">{{ $product['name'] }}</div>
                    <div class="product-desc">{{ $product['desc'] }}</div>

                    <div class="product-meta">
                        <span class="meta-item">
                            <span class="meta-icon">&#128230;</span>
                            <strong>{{ $product['minOrder'] }}</strong>
                        </span>
                        <span class="meta-item">
                            <span class="meta-icon">&#9886;</span>
                            <strong>{{ $product['weight'] }}</strong>
                        </span>
                        <span class="meta-item">
                            <span class="meta-icon">&#128197;</span>
                            <strong>{{ $product['shelfLife'] }}</strong>
                        </span>
                    </div>

                    <div class="product-footer">
                        <span class="price"><span class="from">от</span> {{ $product['price'] }} руб. / {{ $product['priceUnit'] }}</span>
                        <button class="btn-order" data-product="{{ $product['id'] }}" data-name="{{ $product['name'] }}" data-price="{{ $product['price'] }}">
                            Заказать
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ===== ПАГИНАЦИЯ ===== -->
        <div class="pagination-wrap" data-aos="fade-up" data-aos-delay="400">
            <button class="page-btn arrow">&#8592;</button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">4</button>
            <button class="page-btn arrow">&#8594;</button>
        </div>

        <!-- ===== СЕКЦИЯ СВЯЗАТЬСЯ ===== -->
        <div class="px-6 md:px-12 lg:px-16 py-12 border-t border-black/5" data-aos="fade-up">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-[18px] text-black">Не нашли нужный товар?</h2>
                    <p class="text-[13px] text-black/30">Мы поставим любую позицию под ваш запрос</p>
                </div>
                <a href="#contacts" class="inline-block px-8 py-3 bg-black text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02]">Связаться с нами</a>
            </div>
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
            var filterBtns = document.querySelectorAll('.filter-btn');
            var productCards = document.querySelectorAll('.product-card');
            var activeCategory = 'all';
            var activePack = 'all-pack';

            function applyFilters() {
                productCards.forEach(function(card) {
                    var category = card.dataset.category || '';
                    var pack = card.dataset.pack || '';

                    var categoryMatch = activeCategory === 'all' || category === activeCategory;
                    var packMatch = activePack === 'all-pack' || pack === activePack;

                    card.style.display = (categoryMatch && packMatch) ? 'flex' : 'none';
                });
            }

            function updateActiveButtons(group, activeValue) {
                var btns = group.querySelectorAll('.filter-btn');
                btns.forEach(function(btn) {
                    if (btn.dataset.filter === activeValue) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }

            var filterGroups = document.querySelectorAll('.filter-group');

            filterGroups.forEach(function(group) {
                var btns = group.querySelectorAll('.filter-btn');
                btns.forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var filterValue = this.dataset.filter;
                        var parentGroup = this.closest('.filter-group');
                        var label = parentGroup.querySelector('.filter-group-label');
                        var isCategory = label && label.textContent.indexOf('Категория') !== -1;
                        var isPack = label && label.textContent.indexOf('Упаковка') !== -1;

                        if (isCategory) {
                            activeCategory = filterValue;
                            updateActiveButtons(parentGroup, filterValue);
                        } else if (isPack) {
                            activePack = filterValue;
                            updateActiveButtons(parentGroup, filterValue);
                        }

                        applyFilters();
                    });
                });
            });

            document.querySelectorAll('.btn-order').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var name = this.dataset.name || 'Товар';
                    var price = this.dataset.price || '0';
                    alert('Заявка на "' + name + '"\nЦена: от ' + price + ' руб. / шт\n\nСвяжитесь с нами для оформления заказа.\nТел: +7 999 618 28 82');
                });
            });

            document.querySelectorAll('.page-btn:not(.arrow)').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.page-btn').forEach(function(b) {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');
                    var header = document.querySelector('.catalog-header');
                    if (header) {
                        header.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            var prevArrow = document.querySelector('.page-btn.arrow:first-child');
            var nextArrow = document.querySelector('.page-btn.arrow:last-child');

            if (prevArrow && nextArrow) {
                prevArrow.addEventListener('click', function() {
                    var active = document.querySelector('.page-btn.active');
                    if (active) {
                        var prev = active.previousElementSibling;
                        if (prev && prev.classList && !prev.classList.contains('arrow')) {
                            prev.click();
                        }
                    }
                });

                nextArrow.addEventListener('click', function() {
                    var active = document.querySelector('.page-btn.active');
                    if (active) {
                        var next = active.nextElementSibling;
                        if (next && next.classList && !next.classList.contains('arrow')) {
                            next.click();
                        }
                    }
                });
            }

            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    var target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        var headerOffset = 80;
                        var elementPosition = target.getBoundingClientRect().top;
                        var offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                    }
                });
            });
        })();
    </script>
@endpush
