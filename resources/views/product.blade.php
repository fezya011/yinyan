{{-- resources/views/product.blade.php --}}
@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' – Инь Ян')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }

        :root { --header-height: 80px; }

        .product-wrapper {
            padding-top: var(--header-height);
            overflow-x: hidden;
            background: #FFFFFF;
        }

        /* ===== ХЛЕБНЫЕ КРОШКИ ===== */
        .breadcrumbs {
            padding: 24px 0 12px;
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.25);
            font-weight: 500;
        }
        .breadcrumbs a {
            color: rgba(26, 26, 26, 0.35);
            text-decoration: none;
            transition: color 0.3s;
        }
        .breadcrumbs a:hover { color: #1A1A1A; }
        .breadcrumbs .separator { margin: 0 10px; color: rgba(26, 26, 26, 0.08); }
        .breadcrumbs .current { color: rgba(26, 26, 26, 0.5); }

        /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ (как на главной) ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: #1A1A1A;
            line-height: 1;
            z-index: 0;
        }
        .hanzi-decor.xl { font-size: 160px; }
        .hanzi-decor.lg { font-size: 110px; }
        .hanzi-decor.md { font-size: 75px; }
        .hanzi-decor.sm { font-size: 50px; }
        .hanzi-decor.xs { font-size: 32px; }

        /* ===== СТАТУС ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 8px 18px;
            margin-bottom: 24px;
        }
        .status-badge.in-stock { background: #1A1A1A; color: #FFFFFF; }
        .status-badge.out-of-stock { background: #F5F5F5; color: rgba(26,26,26,0.45); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
        .in-stock .status-dot { background: #4ADE80; animation: pulse-dot 2s infinite; }
        .out-of-stock .status-dot { background: rgba(26,26,26,0.25); }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.8); }
        }

        /* ===== ГАЛЕРЕЯ (КРУПНАЯ) ===== */
        .gallery-section {
            position: relative;
            background: #FAFAFA;
            margin-bottom: 56px;
        }
        .swiper {
            width: 100%;
            height: 600px;
        }
        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FAFAFA;
        }
        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 48px;
        }
        .swiper-slide .no-image-placeholder {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 160px;
            font-weight: 900;
            color: rgba(26,26,26,0.03);
            user-select: none;
        }
        .swiper-button-next, .swiper-button-prev {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(26,26,26,0.05);
            color: #1A1A1A;
            transition: all 0.3s;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: #1A1A1A; color: #FFFFFF;
        }
        .swiper-button-next::after, .swiper-button-prev::after { font-size: 15px; font-weight: 700; }
        .swiper-pagination { bottom: 20px !important; }
        .swiper-pagination-bullet {
            width: 6px; height: 6px;
            background: rgba(26,26,26,0.2);
            opacity: 1;
        }
        .swiper-pagination-bullet-active {
            background: #1A1A1A;
            width: 20px;
            border-radius: 3px;
        }
        .gallery-thumbs {
            display: flex; gap: 10px;
            padding: 20px 0;
            justify-content: center;
        }
        .gallery-thumb {
            width: 72px; height: 72px;
            border: 1px solid rgba(26,26,26,0.04);
            background: #FFFFFF;
            cursor: pointer;
            overflow: hidden;
            opacity: 0.35;
            transition: all 0.3s;
        }
        .gallery-thumb.active { border-color: #1A1A1A; opacity: 1; }
        .gallery-thumb img { width: 100%; height: 100%; object-fit: contain; padding: 8px; }

        /* ===== HERO ===== */
        .product-hero {
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            gap: 80px;
            margin-bottom: 80px;
        }
        .product-hero-left {
            position: sticky;
            top: calc(var(--header-height) + 32px);
            align-self: start;
        }
        .product-hero-right { padding-top: 8px; }
        .product-category-tag {
            font-size: 9px; letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.25);
            margin-bottom: 12px;
            font-weight: 600;
        }
        .product-title {
            font-weight: 900;
            font-size: clamp(28px, 3.5vw, 44px);
            letter-spacing: -1.5px;
            text-transform: uppercase;
            color: #1A1A1A;
            line-height: 1.05;
            margin-bottom: 20px;
        }
        .product-subtitle {
            font-size: 15px;
            color: rgba(26,26,26,0.45);
            line-height: 1.7;
            margin-bottom: 36px;
            font-weight: 400;
            max-width: 480px;
        }

        /* ===== ЦЕНЫ ===== */
        .price-block {
            background: #FAFAFA;
            padding: 28px;
            margin-bottom: 36px;
        }
        .price-block-title {
            font-size: 8px; letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.25);
            margin-bottom: 18px;
            font-weight: 600;
        }
        .price-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid rgba(26,26,26,0.04);
        }
        .price-row:last-child { border-bottom: none; padding-bottom: 0; }
        .price-label {
            font-size: 11px; letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.4);
            font-weight: 500;
        }
        .price-value {
            font-weight: 700; font-size: 18px;
            color: #1A1A1A; text-align: right;
        }
        .price-value.wholesale { font-size: 28px; letter-spacing: -0.5px; }
        .price-value .unit { font-weight: 400; font-size: 11px; color: rgba(26,26,26,0.25); margin-left: 3px; }
        .price-value.margin-positive { color: #059669; }

        /* ===== КНОПКИ ===== */
        .action-buttons { display: flex; gap: 12px; margin-bottom: 40px; }
        .btn-primary-lg {
            flex: 1; padding: 18px 28px;
            background: #1A1A1A; color: #FFFFFF;
            border: none;
            font-size: 10px; font-weight: 600; letter-spacing: 2.5px;
            text-transform: uppercase; cursor: pointer;
            transition: all 0.35s ease; font-family: 'Inter', sans-serif;
            text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-primary-lg:hover { background: #000; transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,0,0,0.12); }
        .btn-ghost-lg {
            padding: 18px 28px; border: 1px solid rgba(26,26,26,0.08);
            background: transparent; color: rgba(26,26,26,0.45);
            font-size: 10px; font-weight: 500; letter-spacing: 2.5px;
            text-transform: uppercase; cursor: pointer;
            transition: all 0.3s; font-family: 'Inter', sans-serif;
            text-decoration: none; display: flex; align-items: center; justify-content: center;
        }
        .btn-ghost-lg:hover { border-color: rgba(26,26,26,0.25); color: #1A1A1A; }

        /* ===== СЕКЦИИ ===== */
        .section-title {
            font-weight: 900; font-size: 18px;
            letter-spacing: -0.3px; text-transform: uppercase;
            color: #1A1A1A; margin-bottom: 28px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(26,26,26,0.06);
            display: flex; align-items: center; gap: 12px;
        }
        .section-title .title-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px;
            background: #1A1A1A; color: #FFFFFF;
            font-size: 9px; font-weight: 700;
        }
        .specs-section, .certificates-section, .flavors-section, .description-section, .logistics-section { margin-bottom: 64px; }

        /* ===== ХАРАКТЕРИСТИКИ ===== */
        .specs-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1px; background: rgba(26,26,26,0.03);
            border: 1px solid rgba(26,26,26,0.03);
        }
        .spec-item {
            background: #FFFFFF; padding: 22px 28px;
            display: flex; flex-direction: column; gap: 6px;
        }
        .spec-label {
            font-size: 8px; letter-spacing: 2.5px;
            text-transform: uppercase; color: rgba(26,26,26,0.25); font-weight: 600;
        }
        .spec-value { font-size: 15px; font-weight: 600; color: #1A1A1A; line-height: 1.3; }
        .spec-value .spec-sub { font-weight: 400; color: rgba(26,26,26,0.3); font-size: 11px; margin-left: 6px; }
        .spec-value.mono { font-family: 'SF Mono', 'Fira Code', 'Consolas', monospace; font-size: 13px; font-weight: 500; letter-spacing: 0; }

        /* ===== СЕРТИФИКАТЫ ===== */
        .cert-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1px; background: rgba(26,26,26,0.03);
            border: 1px solid rgba(26,26,26,0.03);
        }
        .cert-card {
            background: #FFFFFF; padding: 32px 24px; text-align: center; transition: all 0.3s;
        }
        .cert-card.has-cert { background: #1A1A1A; color: #FFFFFF; }
        .cert-indicator {
            width: 14px; height: 14px; border-radius: 50%;
            margin: 0 auto 16px; display: block;
            background: rgba(26,26,26,0.08);
        }
        .cert-card.has-cert .cert-indicator { background: #4ADE80; box-shadow: 0 0 16px rgba(74,222,128,0.4); }
        .cert-name { font-weight: 700; font-size: 15px; margin-bottom: 6px; }
        .cert-card.has-cert .cert-name { color: #FFFFFF; }
        .cert-status { font-size: 9px; letter-spacing: 2px; text-transform: uppercase; font-weight: 500; }
        .cert-card.has-cert .cert-status { color: rgba(255,255,255,0.55); }
        .cert-card:not(.has-cert) .cert-status { color: rgba(26,26,26,0.18); }

        /* ===== ВКУСЫ ===== */
        .flavors-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .flavor-tag {
            padding: 10px 22px; border: 1px solid rgba(26,26,26,0.05);
            font-size: 12px; color: rgba(26,26,26,0.55); font-weight: 450;
            transition: all 0.3s; background: #FAFAFA;
        }
        .flavor-tag:hover { border-color: rgba(26,26,26,0.15); color: #1A1A1A; background: #FFFFFF; }

        /* ===== ОПИСАНИЕ ===== */
        .description-content {
            font-size: 14px; line-height: 1.9;
            color: rgba(26,26,26,0.6); font-weight: 400;
            max-width: 720px;
        }
        .description-content p { margin-bottom: 18px; }

        /* ===== ЛОГИСТИКА ===== */
        .logistics-grid {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            gap: 1px; background: rgba(26,26,26,0.03);
            border: 1px solid rgba(26,26,26,0.03);
        }
        .logistics-item { background: #FFFFFF; padding: 24px 28px; text-align: center; }
        .logistics-value { font-weight: 700; font-size: 22px; color: #1A1A1A; margin-bottom: 4px; }
        .logistics-label {
            font-size: 8px; letter-spacing: 2.5px;
            text-transform: uppercase; color: rgba(26,26,26,0.25); font-weight: 600;
        }

        /* ===== СЛУЖЕБНАЯ ЗАМЕТКА ===== */
        .internal-note {
            background: #FAFAFA; padding: 20px 24px;
            margin-bottom: 48px; border-left: 2px solid rgba(26,26,26,0.08);
        }
        .internal-note-label {
            font-size: 8px; letter-spacing: 3px;
            text-transform: uppercase; color: rgba(26,26,26,0.2);
            font-weight: 600; margin-bottom: 8px;
        }
        .internal-note-text { font-size: 12px; color: rgba(26,26,26,0.35); font-style: italic; line-height: 1.6; }

        /* ===== ПОХОЖИЕ ===== */
        .related-section { margin-bottom: 80px; }
        .related-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1px; background: rgba(26,26,26,0.03);
            border: 1px solid rgba(26,26,26,0.03);
        }
        .related-card {
            background: #FFFFFF; padding: 28px 24px;
            text-decoration: none; color: inherit;
            transition: all 0.35s; display: flex; flex-direction: column;
        }
        .related-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.04); }
        .related-card .image-wrap {
            height: 180px; display: flex; align-items: center; justify-content: center;
            background: #FAFAFA; margin-bottom: 18px; overflow: hidden;
        }
        .related-card .image-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 24px; transition: transform 0.5s; }
        .related-card:hover .image-wrap img { transform: scale(1.04); }
        .related-card .no-related-image {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 48px; font-weight: 900; color: rgba(26,26,26,0.03);
        }
        .related-card .related-name { font-weight: 600; font-size: 15px; color: #1A1A1A; margin-bottom: 6px; line-height: 1.3; }
        .related-card .related-meta { font-size: 10px; color: rgba(26,26,26,0.3); margin-bottom: 8px; }
        .related-card .related-price { font-weight: 700; font-size: 16px; color: #1A1A1A; margin-top: auto; }

        /* ===== CTA ===== */
        .cta-section {
            border-top: 1px solid rgba(26,26,26,0.05);
            padding: 48px 0; position: relative;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 1024px) {
            .product-hero { grid-template-columns: 1fr; gap: 48px; }
            .product-hero-left { position: static; }
            .swiper { height: 450px; }
            .specs-grid { grid-template-columns: 1fr 1fr; }
            .logistics-grid { grid-template-columns: 1fr 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .swiper { height: 340px; }
            .specs-grid { grid-template-columns: 1fr; }
            .cert-grid { grid-template-columns: 1fr 1fr; }
            .logistics-grid { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .gallery-thumb { width: 52px; height: 52px; }
            .hanzi-decor.xl { font-size: 100px; opacity: 0.04 !important; }
            .hanzi-decor.lg { font-size: 70px; opacity: 0.03 !important; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.02 !important; }
        }
        @media (max-width: 480px) {
            .swiper { height: 260px; }
            .cert-grid { grid-template-columns: 1fr; }
            .product-title { font-size: 24px; }
            .price-value.wholesale { font-size: 22px; }
            .hanzi-decor { display: none; }
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FFFFFF; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 2px; }

        [data-aos] { transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1); }
    </style>
@endpush

@section('content')
    <div class="product-wrapper">
        <!-- ХЛЕБНЫЕ КРОШКИ -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="breadcrumbs" data-aos="fade-up">
                <a href="{{ route('home') }}">Главная</a>
                <span class="separator">/</span>
                <a href="{{ route('catalog') }}">Каталог</a>
                @if($product->category)
                    <span class="separator">/</span>
                    <a href="{{ route('catalog', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                @endif
                <span class="separator">/</span>
                <span class="current">{{ $product->name }}</span>
            </div>
        </div>

        <!-- ГАЛЕРЕЯ -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="gallery-section relative section-with-hanzi" data-aos="fade-up">
                @php
                    $allImages = [];
                    if ($product->main_image) $allImages[] = asset('storage/' . $product->main_image);
                    foreach (($product->gallery ?? []) as $img) {
                        if ($img !== $product->main_image) $allImages[] = asset('storage/' . $img);
                    }
                @endphp

                <div class="swiper product-swiper">
                    <div class="swiper-wrapper">
                        @if(count($allImages) > 0)
                            @foreach($allImages as $image)
                                <div class="swiper-slide">
                                    <img src="{{ $image }}" alt="{{ $product->name }} – {{ $loop->index + 1 }}" loading="lazy">
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <span class="no-image-placeholder">无图</span>
                            </div>
                        @endif
                    </div>
                    @if(count($allImages) > 1)
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    @endif
                </div>

                @if(count($allImages) > 1)
                    <div class="gallery-thumbs">
                        @foreach($allImages as $i => $img)
                            <div class="gallery-thumb {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                                <img src="{{ $img }}" alt="Миниатюра {{ $i + 1 }}" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Иероглифы в галерее --}}
                <span class="hanzi-decor xl" style="top: -20px; right: -30px; opacity: 0.03; transform: rotate(5deg);">图</span>
                <span class="hanzi-decor md" style="bottom: -10px; left: -20px; opacity: 0.03; transform: rotate(-8deg);">像</span>
            </div>
        </div>

        <!-- HERO -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="product-hero">
                <!-- ЛЕВАЯ КОЛОНКА -->
                <div class="product-hero-left" data-aos="fade-up">
                    <div class="status-badge {{ $product->status === 'active' ? 'in-stock' : 'out-of-stock' }}">
                        <span class="status-dot"></span>
                        {{ $product->status === 'active' ? 'В наличии на складе' : 'Под заказ' }}
                    </div>

                    @if($product->category)
                        <div class="product-category-tag">{{ $product->category->name }}</div>
                    @endif

                    <h1 class="product-title">{{ $product->name }}</h1>

                    @if($product->card_subtitle)
                        <p class="product-subtitle">{{ $product->card_subtitle }}</p>
                    @endif

                    <div class="price-block">
                        <div class="price-block-title">Условия поставки</div>
                        @if($product->wholesale_price)
                            <div class="price-row">
                                <span class="price-label">Оптовая цена</span>
                                <div class="price-value wholesale">
                                    {{ number_format($product->wholesale_price, 2, '.', ' ') }} <span class="unit">₽ / шт</span>
                                </div>
                            </div>
                        @endif
                        @if($product->retail_price)
                            <div class="price-row">
                                <span class="price-label">Рекомендованная розница</span>
                                <div class="price-value">{{ number_format($product->retail_price, 2, '.', ' ') }} <span class="unit">₽</span></div>
                            </div>
                        @endif
                        @if($product->distributor_price)
                            <div class="price-row">
                                <span class="price-label">Дистрибьюторская</span>
                                <div class="price-value">{{ number_format($product->distributor_price, 2, '.', ' ') }} <span class="unit">₽</span></div>
                            </div>
                        @endif
                        @php $margin = $product->getMarginPercent(); @endphp
                        @if($margin !== null)
                            <div class="price-row">
                                <span class="price-label">Маржинальность</span>
                                <div class="price-value margin-positive">{{ $margin }}%</div>
                            </div>
                        @endif
                        @if($product->min_order_amount)
                            <div class="price-row">
                                <span class="price-label">Минимальный заказ</span>
                                <div class="price-value">{{ number_format($product->min_order_amount, 2, '.', ' ') }} <span class="unit">₽</span></div>
                            </div>
                        @endif
                        @if($product->vat_rate)
                            <div class="price-row">
                                <span class="price-label">НДС</span>
                                <div class="price-value">{{ $product->vat_rate }}%</div>
                            </div>
                        @endif
                    </div>

                    <div class="action-buttons">
                        <a href="tel:+79996182882" class="btn-primary-lg">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2A19.79 19.79 0 0 1 11 18.85a19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            Позвонить
                        </a>
                        <a href="mailto:eksport.inyan@mail.ru" class="btn-ghost-lg">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Написать
                        </a>
                    </div>

                    <div class="internal-note" style="opacity: 0.85;">
                        <div class="internal-note-label">Информация для заказа</div>
                        <div class="internal-note-text">
                            Все цены без учёта доставки. Отгрузка со склада в г. Артём, Приморский край. Доставка по РФ транспортными компаниями. Прямые контейнерные поставки из КНР.
                        </div>
                    </div>

                    {{-- Иероглифы в левой колонке --}}
                    <span class="hanzi-decor lg" style="bottom: 40px; right: -20px; opacity: 0.025; transform: rotate(-12deg);">价</span>
                    <span class="hanzi-decor sm" style="top: 30%; left: -10px; opacity: 0.02; transform: rotate(8deg);">值</span>
                </div>

                <!-- ПРАВАЯ КОЛОНКА -->
                <div class="product-hero-right relative section-with-hanzi" data-aos="fade-up" data-aos-delay="100">
                    <!-- Характеристики -->
                    <div class="specs-section">
                        <h2 class="section-title">
                            <span class="title-icon">ТХ</span>
                            Технические характеристики
                        </h2>
                        <div class="specs-grid">
                            @if($product->weight_grams)
                                <div class="spec-item">
                                    <span class="spec-label">Вес единицы</span>
                                    <span class="spec-value">{{ number_format($product->weight_grams, 0, '.', ' ') }} г<span class="spec-sub">{{ number_format($product->getWeightKg(), 3, '.', '') }} кг</span></span>
                                </div>
                            @endif
                            @if($product->packaging_type)
                                <div class="spec-item">
                                    <span class="spec-label">Тип упаковки</span>
                                    <span class="spec-value">{{ $product->packaging_type }}</span>
                                </div>
                            @endif
                            @if($product->pieces_per_box)
                                <div class="spec-item">
                                    <span class="spec-label">Штук в коробке</span>
                                    <span class="spec-value">{{ $product->pieces_per_box }} шт</span>
                                </div>
                            @endif
                            @if($product->boxes_per_pallet)
                                <div class="spec-item">
                                    <span class="spec-label">Коробок на паллете</span>
                                    <span class="spec-value">{{ $product->boxes_per_pallet }} кор</span>
                                </div>
                            @endif
                            @if($product->box_weight_kg)
                                <div class="spec-item">
                                    <span class="spec-label">Вес коробки</span>
                                    <span class="spec-value">{{ number_format($product->box_weight_kg, 2, '.', '') }} кг</span>
                                </div>
                            @endif
                            @if($product->box_volume)
                                <div class="spec-item">
                                    <span class="spec-label">Объём коробки</span>
                                    <span class="spec-value">{{ number_format($product->box_volume, 3, '.', '') }} м³</span>
                                </div>
                            @endif
                            @if($product->shelf_life_days)
                                <div class="spec-item">
                                    <span class="spec-label">Срок годности</span>
                                    <span class="spec-value">{{ $product->shelf_life_days }} дн<span class="spec-sub">{{ round($product->shelf_life_days / 30, 1) }} мес</span></span>
                                </div>
                            @endif
                            @if($product->tnved_code)
                                <div class="spec-item">
                                    <span class="spec-label">Код ТН ВЭД</span>
                                    <span class="spec-value mono">{{ $product->tnved_code }}</span>
                                </div>
                            @endif
                            @if($product->barcode)
                                <div class="spec-item">
                                    <span class="spec-label">Штрихкод</span>
                                    <span class="spec-value mono">{{ chunk_split($product->barcode, 4, ' ') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Сертификаты -->
                    <div class="certificates-section">
                        <h2 class="section-title">
                            <span class="title-icon">СР</span>
                            Сертификация
                        </h2>
                        <div class="cert-grid">
                            <div class="cert-card {{ $product->has_eac ? 'has-cert' : '' }}">
                                <span class="cert-indicator"></span>
                                <div class="cert-name">ЕАС</div>
                                <div class="cert-status">{{ $product->has_eac ? 'Декларация оформлена' : 'Не требуется' }}</div>
                            </div>
                            <div class="cert-card {{ $product->has_honest_sign ? 'has-cert' : '' }}">
                                <span class="cert-indicator"></span>
                                <div class="cert-name">Честный знак</div>
                                <div class="cert-status">{{ $product->has_honest_sign ? 'Система подключена' : 'Не требуется' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Вкусы -->
                    @if($product->flavors && count($product->flavors) > 0)
                        <div class="flavors-section">
                            <h2 class="section-title">
                                <span class="title-icon">ВК</span>
                                Доступные вкусы
                            </h2>
                            <div class="flavors-list">
                                @foreach($product->flavors as $flavor)
                                    <span class="flavor-tag">{{ $flavor }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Иероглифы в правой колонке --}}
                    <span class="hanzi-decor md" style="top: 10%; right: -20px; opacity: 0.025; transform: rotate(10deg);">规</span>
                    <span class="hanzi-decor sm" style="bottom: 20%; left: -15px; opacity: 0.02; transform: rotate(-6deg);">格</span>
                </div>
            </div>

            <!-- Описание -->
            @if($product->description)
                <div class="description-section relative section-with-hanzi" data-aos="fade-up">
                    <h2 class="section-title">
                        <span class="title-icon">ОП</span>
                        Описание товара
                    </h2>
                    <div class="description-content">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    <span class="hanzi-decor lg" style="top: -40px; right: -40px; opacity: 0.025; transform: rotate(5deg);">详</span>
                    <span class="hanzi-decor md" style="bottom: -20px; left: -30px; opacity: 0.02; transform: rotate(-10deg);">情</span>
                </div>
            @endif

            <!-- Логистика -->
            <div class="logistics-section relative section-with-hanzi" data-aos="fade-up">
                <h2 class="section-title">
                    <span class="title-icon">ЛГ</span>
                    Логистика и поставки
                </h2>
                <div class="logistics-grid">
                    <div class="logistics-item">
                        <div class="logistics-value">
                            @if($product->boxes_per_pallet && $product->pieces_per_box)
                                {{ number_format($product->pieces_per_box * $product->boxes_per_pallet, 0, '.', ' ') }}
                            @else
                                —
                            @endif
                        </div>
                        <div class="logistics-label">Штук на паллете</div>
                    </div>
                    <div class="logistics-item">
                        <div class="logistics-value">
                            @if($product->boxes_per_pallet && $product->box_weight_kg)
                                {{ number_format($product->boxes_per_pallet * $product->box_weight_kg, 0, '.', ' ') }}
                            @else
                                —
                            @endif
                        </div>
                        <div class="logistics-label">Кг на паллете (≈)</div>
                    </div>
                    <div class="logistics-item">
                        <div class="logistics-value">14–21</div>
                        <div class="logistics-label">Дней доставки из КНР</div>
                    </div>
                </div>
                <span class="hanzi-decor sm" style="top: -10px; right: 10px; opacity: 0.02; transform: rotate(8deg);">物</span>
                <span class="hanzi-decor xs" style="bottom: -5px; left: 10px; opacity: 0.015; transform: rotate(-5deg);">流</span>
            </div>

            <!-- Служебная заметка -->
            @if($product->comment)
                <div class="internal-note" data-aos="fade-up">
                    <div class="internal-note-label">Служебная информация</div>
                    <div class="internal-note-text">{!! nl2br(e($product->comment)) !!}</div>
                </div>
            @endif
        </div>

        <!-- Похожие товары -->
        @if($relatedProducts && $relatedProducts->count() > 0)
            <div class="px-6 md:px-12 lg:px-16">
                <div class="related-section relative section-with-hanzi" data-aos="fade-up">
                    <h2 class="section-title">
                        <span class="title-icon">ПХ</span>
                        Похожие товары
                    </h2>
                    <div class="related-grid">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('product', $related->slug) }}" class="related-card">
                                <div class="image-wrap">
                                    @if($related->main_image)
                                        <img src="{{ asset('storage/' . $related->main_image) }}" alt="{{ $related->name }}" loading="lazy">
                                    @else
                                        <span class="no-related-image">无图</span>
                                    @endif
                                </div>
                                <div class="related-name">{{ $related->name }}</div>
                                @if($related->category)
                                    <div class="related-meta">{{ $related->category->name }}</div>
                                @endif
                                <div class="related-price">
                                    @if($related->wholesale_price)
                                        от {{ number_format($related->wholesale_price, 2, '.', ' ') }} ₽
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <span class="hanzi-decor md" style="top: 10px; right: -20px; opacity: 0.025; transform: rotate(7deg);">类</span>
                    <span class="hanzi-decor sm" style="bottom: -10px; left: -15px; opacity: 0.02; transform: rotate(-8deg);">似</span>
                </div>
            </div>
        @endif

        <!-- CTA -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="cta-section relative section-with-hanzi" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative z-10">
                    <div>
                        <h2 class="font-black text-[22px] text-black tracking-[-0.3px] uppercase">Готовы обсудить поставку?</h2>
                        <p class="text-[14px] text-black/30 mt-1 font-light">Рассчитаем точную стоимость партии с учётом логистики</p>
                    </div>
                    <a href="{{ route('contacts') }}" class="inline-block px-10 py-4 bg-black text-white text-[10px] font-semibold tracking-[2.5px] uppercase transition-all duration-300 hover:bg-black/85 hover:scale-[1.02]">
                        Получить КП
                    </a>
                </div>
                <span class="hanzi-decor lg" style="bottom: -30px; right: 60px; opacity: 0.03; transform: rotate(-8deg);">优</span>
                <span class="hanzi-decor md" style="top: -20px; left: 40px; opacity: 0.03; transform: rotate(12deg);">质</span>
                <span class="hanzi-decor sm" style="bottom: 10px; left: 30%; opacity: 0.02; transform: rotate(-5deg);">合</span>
                <span class="hanzi-decor xs" style="top: 10px; right: 30%; opacity: 0.015; transform: rotate(8deg);">作</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        AOS.init({ duration: 500, once: true, offset: 20, easing: 'ease-out' });

        const swiper = new Swiper('.product-swiper', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        document.querySelectorAll('.gallery-thumb').forEach(thumb => {
            thumb.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                swiper.slideTo(index);
                document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        swiper.on('slideChange', function() {
            document.querySelectorAll('.gallery-thumb').forEach((thumb, index) => {
                thumb.classList.toggle('active', index === swiper.activeIndex);
            });
        });
    </script>
@endpush
