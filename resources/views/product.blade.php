{{-- resources/views/product.blade.php --}}
@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' – Инь Ян')

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
            position: relative;
        }

        /* ===== ОБЩИЙ ЕДВА ЗАМЕТНЫЙ ГРАДИЕНТ НА ВСЮ СТРАНИЦУ ===== */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(
                    circle at 80% 20%,
                    rgba(var(--accent-r), var(--accent-g), var(--accent-b), 0.06) 0%,
                    transparent 50%
                ),
                radial-gradient(
                    circle at 20% 80%,
                    rgba(var(--accent-r), var(--accent-g), var(--accent-b), 0.04) 0%,
                    transparent 50%
                ),
                linear-gradient(
                    180deg,
                    rgba(var(--accent-r), var(--accent-g), var(--accent-b), 0.03) 0%,
                    rgba(var(--accent-r), var(--accent-g), var(--accent-b), 0.01) 50%,
                    transparent 100%
                );
            transition: background 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: background;
        }

        :root {
            --header-height: 80px;
            --accent-r: 255;
            --accent-g: 107;
            --accent-b: 0;
        }

        .product-wrapper {
            padding-top: var(--header-height);
            overflow-x: hidden;
            position: relative;
            z-index: 1;
        }

        /* ===== ХЛЕБНЫЕ КРОШКИ ===== */
        .breadcrumbs {
            padding: 20px 0 10px;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            font-weight: 500;
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .breadcrumbs::-webkit-scrollbar { display: none; }
        .breadcrumbs a {
            color: rgba(26, 26, 26, 0.4);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
            flex-shrink: 0;
        }
        .breadcrumbs a:hover { color: #1A1A1A; }
        .breadcrumbs .separator {
            margin: 0 8px;
            color: rgba(26, 26, 26, 0.12);
            flex-shrink: 0;
        }
        .breadcrumbs .current {
            color: rgba(26, 26, 26, 0.5);
            flex-shrink: 0;
        }

        /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: rgb(var(--accent-r), var(--accent-g), var(--accent-b));
            line-height: 1;
            z-index: 0;
            transition: color 1.2s cubic-bezier(0.4, 0, 0.2, 1),
            opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hanzi-decor.xl { font-size: 140px; }
        .hanzi-decor.lg { font-size: 100px; }
        .hanzi-decor.md { font-size: 70px; }
        .hanzi-decor.sm { font-size: 45px; }
        .hanzi-decor.xs { font-size: 28px; }

        .section-with-hanzi {
            position: relative;
            overflow: visible !important;
        }

        @media (max-width: 768px) {
            .hanzi-decor.xl { font-size: 100px; opacity: 0.12 !important; }
            .hanzi-decor.lg { font-size: 70px; opacity: 0.10 !important; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.08 !important; }
            .hanzi-decor.sm { font-size: 35px; opacity: 0.06 !important; }
            .hanzi-decor.xs { font-size: 22px; opacity: 0.05 !important; }
        }

        @media (max-width: 480px) {
            .hanzi-decor.xl { font-size: 80px; opacity: 0.08 !important; }
            .hanzi-decor.lg { font-size: 55px; opacity: 0.06 !important; }
            .hanzi-decor.md { font-size: 40px; opacity: 0.05 !important; }
            .hanzi-decor.sm { font-size: 28px; opacity: 0.04 !important; }
            .hanzi-decor.xs { font-size: 18px; opacity: 0.03 !important; }
        }

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
            position: relative;
            z-index: 1;
        }
        .status-badge.in-stock { background: #1A1A1A; color: #FFFFFF; }
        .status-badge.out-of-stock { background: rgba(26,26,26,0.03); color: rgba(26,26,26,0.45); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; }
        .in-stock .status-dot { background: #4ADE80; animation: pulse-dot 2s infinite; }
        .out-of-stock .status-dot { background: rgba(26,26,26,0.25); }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.8); }
        }

        /* ===== ГАЛЕРЕЯ ===== */
        .gallery-section {
            position: relative;
            background: transparent;
            margin-bottom: 56px;
            overflow: visible;
        }

        .carousel-container {
            width: 100%;
            height: 600px;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }
        .carousel-track-wrapper {
            flex: 1;
            width: 100%;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .carousel-track {
            display: flex;
            height: 100%;
            transition: transform 0.8s cubic-bezier(0.65, 0, 0.35, 1);
            will-change: transform;
        }
        .carousel-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            box-sizing: border-box;
            position: relative;
            background: transparent;
        }
        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform;
            position: relative;
            z-index: 2;
        }
        .carousel-slide.active-slide img {
            animation: slideReveal 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        @keyframes slideReveal {
            0% { opacity: 0; transform: scale(0.94) translateY(20px); filter: blur(3px); }
            100% { opacity: 1; transform: scale(1) translateY(0); filter: blur(0); }
        }
        .carousel-slide:not(.active-slide) img { animation: none; }
        .carousel-slide .no-image-placeholder {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 160px;
            font-weight: 900;
            color: rgba(var(--accent-r), var(--accent-g), var(--accent-b), 0.06);
            user-select: none;
            position: relative;
            z-index: 2;
        }

        .carousel-slide::after {
            content: '';
            position: absolute;
            top: 10%;
            left: 10%;
            right: 10%;
            bottom: 10%;
            background: radial-gradient(
                circle at center,
                rgba(255, 255, 255, 0.5) 0%,
                rgba(255, 255, 255, 0.2) 60%,
                transparent 100%
            );
            border-radius: 24px;
            z-index: 0;
            pointer-events: none;
        }

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(26, 26, 26, 0.06);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            color: #1A1A1A;
            font-size: 16px;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(26, 26, 26, 0.02);
        }
        .carousel-arrow:hover {
            background: #1A1A1A;
            color: #FFFFFF;
            border-color: #1A1A1A;
            box-shadow: 0 6px 20px rgba(26, 26, 26, 0.06);
            transform: translateY(-50%) scale(1.06);
        }
        .carousel-arrow:active { transform: translateY(-50%) scale(0.92); }
        .carousel-arrow.prev { left: 16px; }
        .carousel-arrow.next { right: 16px; }

        .carousel-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            gap: 6px;
            z-index: 10;
        }
        .carousel-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(26, 26, 26, 0.12);
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 0;
        }
        .carousel-dot.active {
            background: #1A1A1A;
            width: 22px;
            border-radius: 3px;
        }
        .carousel-dot:hover { background: rgba(26, 26, 26, 0.3); transform: scale(1.3); }
        .carousel-dot.active:hover { transform: scale(1); background: #1A1A1A; }

        .gallery-thumbs {
            display: flex;
            gap: 10px;
            padding: 20px 0;
            justify-content: center;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            position: relative;
            z-index: 1;
        }
        .gallery-thumbs::-webkit-scrollbar { display: none; }
        .gallery-thumb {
            width: 72px;
            height: 72px;
            min-width: 72px;
            border: 1px solid rgba(26,26,26,0.04);
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
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
            min-width: 0;
        }
        .product-hero-right {
            padding-top: 8px;
            min-width: 0;
        }
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
            word-break: break-word;
        }
        .product-subtitle {
            font-size: 15px;
            color: rgba(26,26,26,0.45);
            line-height: 1.7;
            margin-bottom: 36px;
            font-weight: 400;
            max-width: 480px;
            word-break: break-word;
        }

        /* ===== ЦЕНЫ ===== */
        .price-block {
            background: rgba(26,26,26,0.02);
            padding: 28px;
            margin-bottom: 36px;
            min-width: 0;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }
        .price-block-title {
            font-size: 8px; letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.25);
            margin-bottom: 18px;
            font-weight: 600;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid rgba(26,26,26,0.04);
            gap: 12px;
        }
        .price-row:last-child { border-bottom: none; padding-bottom: 0; }
        .price-label {
            font-size: 11px; letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.4);
            font-weight: 500;
            flex-shrink: 0;
        }
        .price-value {
            font-weight: 700; font-size: 18px;
            color: #1A1A1A; text-align: right;
            white-space: nowrap;
        }
        .price-value.wholesale { font-size: 28px; letter-spacing: -0.5px; }
        .price-value .unit { font-weight: 400; font-size: 11px; color: rgba(26,26,26,0.25); margin-left: 3px; }
        .price-value.margin-positive { color: #059669; }

        /* ===== КНОПКА ===== */
        .btn-contact {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 18px 32px;
            background: #1A1A1A;
            color: #FFFFFF;
            border: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.35s ease;
            font-family: 'Inter', sans-serif;
            text-decoration: none;
            margin-bottom: 40px;
            width: 100%;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .btn-contact:hover {
            background: #000;
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
        }
        .btn-contact .arrow { display: inline-block; transition: transform 0.3s; font-size: 16px; font-weight: 400; }
        .btn-contact:hover .arrow { transform: translateX(4px); }

        /* ===== СЕКЦИИ ===== */
        .section-title {
            font-weight: 900;
            font-size: 18px;
            letter-spacing: -0.3px;
            text-transform: uppercase;
            color: #1A1A1A;
            margin-bottom: 28px;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(26,26,26,0.06);
        }
        .specs-logistics-section, .description-section, .flavors-section { margin-bottom: 64px; }

        .unified-specs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: rgba(26,26,26,0.03);
            border: 1px solid rgba(26,26,26,0.03);
        }
        .unified-spec-item {
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            padding: 22px 28px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            transition: background 0.2s;
            min-width: 0;
        }
        .unified-spec-item:hover { background: rgba(255,255,255,0.8); }
        .unified-spec-label {
            font-size: 8px; letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(26,26,26,0.25);
            font-weight: 600;
        }
        .unified-spec-value { font-size: 15px; font-weight: 600; color: #1A1A1A; line-height: 1.3; word-break: break-word; }
        .unified-spec-value.mono { font-family: 'SF Mono', 'Fira Code', 'Consolas', monospace; font-size: 13px; font-weight: 500; letter-spacing: 0; }
        .unified-spec-sub { font-weight: 400; color: rgba(26,26,26,0.3); font-size: 11px; margin-left: 6px; }

        .description-content {
            font-size: 14px; line-height: 1.9;
            color: rgba(26,26,26,0.6);
            font-weight: 400; max-width: 720px;
            word-wrap: break-word; overflow-wrap: break-word;
            hyphens: auto;
        }
        .description-content p { margin-bottom: 18px; max-width: 100%; word-break: break-word; }
        .description-collapsed { max-height: 200px; overflow: hidden; position: relative; }
        .description-collapsed::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 60px;
            background: linear-gradient(to bottom, transparent, #FFFFFF);
            pointer-events: none; transition: opacity 0.3s;
        }
        .description-expanded { max-height: none; }
        .description-expanded::after { opacity: 0; }
        .read-more-btn {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 12px; padding: 8px 20px;
            background: transparent;
            border: 1px solid rgba(26,26,26,0.1);
            color: rgba(26,26,26,0.5);
            font-size: 10px; font-weight: 600;
            letter-spacing: 2px; text-transform: uppercase;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.3s;
        }
        .read-more-btn:hover { border-color: rgba(26,26,26,0.3); color: #1A1A1A; }

        .flavors-list { display: flex; flex-wrap: wrap; gap: 8px; }
        .flavor-tag {
            padding: 10px 22px; border: 1px solid rgba(26,26,26,0.05);
            font-size: 12px; color: rgba(26,26,26,0.55); font-weight: 450;
            transition: all 0.3s; background: rgba(26,26,26,0.02); white-space: nowrap;
        }
        .flavor-tag:hover { border-color: rgba(26,26,26,0.15); color: #1A1A1A; background: rgba(26,26,26,0.04); }

        .internal-note {
            background: rgba(26,26,26,0.02);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 20px 24px;
            margin-bottom: 48px;
            border-left: 2px solid rgba(26,26,26,0.08);
            min-width: 0; overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .internal-note-label {
            font-size: 8px; letter-spacing: 3px;
            text-transform: uppercase; color: rgba(26,26,26,0.2);
            font-weight: 600; margin-bottom: 8px;
        }
        .internal-note-text {
            font-size: 12px; color: rgba(26,26,26,0.35);
            font-style: italic; line-height: 1.6;
            word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;
        }

        .related-section { margin-bottom: 80px; }
        .related-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1px; background: rgba(26,26,26,0.03);
            border: 1px solid rgba(26,26,26,0.03);
        }
        .related-card {
            background: rgba(255,255,255,0.5);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            padding: 28px 24px;
            text-decoration: none; color: inherit;
            transition: all 0.35s; display: flex; flex-direction: column;
        }
        .related-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.04); background: rgba(255,255,255,0.8); }
        .related-card .image-wrap {
            height: 180px; display: flex; align-items: center; justify-content: center;
            background: rgba(26,26,26,0.02); margin-bottom: 18px; overflow: hidden;
        }
        .related-card .image-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 24px; transition: transform 0.5s; }
        .related-card:hover .image-wrap img { transform: scale(1.04); }
        .related-card .no-related-image { font-family: 'Noto Serif SC', 'SimSun', serif; font-size: 48px; font-weight: 900; color: rgba(var(--accent-r), var(--accent-g), var(--accent-b), 0.06); }
        .related-card .related-name { font-weight: 600; font-size: 15px; color: #1A1A1A; margin-bottom: 6px; line-height: 1.3; word-break: break-word; }
        .related-card .related-meta { font-size: 10px; color: rgba(26,26,26,0.3); margin-bottom: 8px; }
        .related-card .related-price { font-weight: 700; font-size: 16px; color: #1A1A1A; margin-top: auto; }

        .cta-section {
            border-top: 1px solid rgba(26,26,26,0.05);
            padding: 48px 0;
            position: relative;
            background: transparent;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 1024px) {
            .product-hero { grid-template-columns: 1fr; gap: 48px; }
            .product-hero-left { position: static; }
            .carousel-container { height: 500px; }
            .unified-specs-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .breadcrumbs { padding: 16px 0 8px; font-size: 10px; letter-spacing: 2px; }
            .breadcrumbs .separator { margin: 0 8px; }
            .carousel-container { height: 420px; }
            .carousel-slide { padding: 24px; }
            .gallery-section { margin-bottom: 32px; }
            .product-hero { gap: 32px; margin-bottom: 48px; }
            .price-block { padding: 20px; margin-bottom: 24px; }
            .price-row { padding: 12px 0; flex-wrap: wrap; }
            .price-label { font-size: 10px; letter-spacing: 1px; }
            .price-value { font-size: 16px; }
            .price-value.wholesale { font-size: 22px; }
            .unified-specs-grid { grid-template-columns: 1fr; }
            .unified-spec-item { padding: 18px 20px; }
            .specs-logistics-section, .description-section, .flavors-section { margin-bottom: 40px; }
            .section-title { font-size: 15px; margin-bottom: 20px; padding-bottom: 14px; }
            .btn-contact { padding: 16px 24px; font-size: 11px; margin-bottom: 28px; }
            .gallery-thumb { width: 56px; height: 56px; min-width: 56px; }
            .gallery-thumbs { gap: 8px; padding: 16px 0; }
            .carousel-arrow { width: 32px; height: 32px; font-size: 13px; }
            .carousel-arrow.prev { left: 8px; }
            .carousel-arrow.next { right: 8px; }
            .related-grid { grid-template-columns: 1fr 1fr; }
            .related-card { padding: 20px 16px; }
            .related-card .image-wrap { height: 140px; }
        }

        @media (max-width: 480px) {
            .breadcrumbs { padding: 12px 0 8px; font-size: 9px; letter-spacing: 1.5px; }
            .breadcrumbs .separator { margin: 0 6px; }
            .carousel-container { height: 360px; }
            .carousel-slide { padding: 16px; }
            .product-title { font-size: 26px; letter-spacing: -1px; }
            .product-subtitle { font-size: 14px; margin-bottom: 24px; }
            .price-block { padding: 16px; margin-bottom: 20px; }
            .price-row { padding: 10px 0; }
            .price-label { font-size: 9px; max-width: 50%; }
            .price-value { font-size: 15px; }
            .price-value.wholesale { font-size: 20px; }
            .price-value .unit { font-size: 10px; }
            .btn-contact { padding: 14px 20px; font-size: 10px; letter-spacing: 1px; margin-bottom: 24px; }
            .unified-spec-item { padding: 16px; }
            .unified-spec-value { font-size: 14px; }
            .description-content { font-size: 13px; line-height: 1.7; }
            .flavors-list { gap: 6px; }
            .flavor-tag { padding: 8px 16px; font-size: 11px; }
            .related-grid { grid-template-columns: 1fr; }
            .related-card { padding: 16px; }
            .related-card .image-wrap { height: 160px; }
            .internal-note { padding: 16px; margin-bottom: 32px; }
            .gallery-thumb { width: 48px; height: 48px; min-width: 48px; }
            .gallery-thumbs { gap: 6px; padding: 12px 0; }
            .section-title { font-size: 14px; }
            .carousel-slide::after {
                top: 5%;
                left: 5%;
                right: 5%;
                bottom: 5%;
            }
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FFFFFF; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 2px; }

        [data-aos] { transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1); }
    </style>
@endpush

@section('content')
    <div class="product-wrapper">
        {{-- ХЛЕБНЫЕ КРОШКИ --}}
        <div class="px-4 md:px-12 lg:px-16">
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

        {{-- ГАЛЕРЕЯ --}}
        <div class="px-4 md:px-12 lg:px-16">
            <div class="gallery-section relative section-with-hanzi" data-aos="fade-up">
                @php
                    $allImages = [];
                    if ($product->main_image) $allImages[] = asset('storage/' . $product->main_image);
                    foreach (($product->gallery ?? []) as $img) {
                        if ($img !== $product->main_image) $allImages[] = asset('storage/' . $img);
                    }
                @endphp

                <div class="carousel-container">
                    <div class="carousel-track-wrapper">
                        <div class="carousel-track" id="productCarouselTrack">
                            @if(count($allImages) > 0)
                                @foreach($allImages as $index => $image)
                                    <div class="carousel-slide {{ $index === 0 ? 'active-slide' : '' }}" data-index="{{ $index }}">
                                        <img src="{{ $image }}" alt="{{ $product->name }} – {{ $index + 1 }}" loading="lazy">
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-slide active-slide" data-index="0">
                                    <span class="no-image-placeholder">无图</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(count($allImages) > 1)
                        <button class="carousel-arrow prev" id="productCarouselPrev" aria-label="Предыдущий">←</button>
                        <button class="carousel-arrow next" id="productCarouselNext" aria-label="Следующий">→</button>
                        <div class="carousel-nav">
                            @for($i = 0; $i < count($allImages); $i++)
                                <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}" aria-label="Слайд {{ $i + 1 }}"></button>
                            @endfor
                        </div>
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

                {{-- Иероглифы — теперь видны сквозь общий градиент и прозрачную карусель --}}
                <span class="hanzi-decor xl" style="top: -30px; right: -20px; opacity: 0.18; transform: rotate(5deg);">图</span>
                <span class="hanzi-decor md" style="bottom: 0px; left: -15px; opacity: 0.12; transform: rotate(-8deg);">像</span>
                <span class="hanzi-decor lg" style="top: 40%; left: -30px; opacity: 0.08; transform: rotate(12deg);">展</span>
                <span class="hanzi-decor sm" style="top: 20%; right: -10px; opacity: 0.07; transform: rotate(-5deg);">示</span>
            </div>
        </div>

        {{-- HERO --}}
        <div class="px-4 md:px-12 lg:px-16">
            <div class="product-hero">
                {{-- ЛЕВАЯ КОЛОНКА --}}
                <div class="product-hero-left section-with-hanzi" data-aos="fade-up">
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

                    <a href="#contacts" class="btn-contact">
                        <span>Связаться</span>
                        <span class="arrow">→</span>
                    </a>

                    <div class="internal-note" style="opacity: 0.85;">
                        <div class="internal-note-label">Информация для заказа</div>
                        <div class="internal-note-text">
                            Все цены без учёта доставки. Отгрузка со склада в г. Артём, Приморский край. Доставка по РФ транспортными компаниями. Прямые контейнерные поставки из КНР.
                        </div>
                    </div>

                    {{-- Иероглифы --}}
                    <span class="hanzi-decor lg" style="bottom: 40px; right: -20px; opacity: 0.18; transform: rotate(-12deg);">价</span>
                    <span class="hanzi-decor sm" style="top: 28%; left: -30px; opacity: 0.10; transform: rotate(8deg);">值</span>
                </div>

                {{-- ПРАВАЯ КОЛОНКА --}}
                <div class="product-hero-right relative section-with-hanzi" data-aos="fade-up" data-aos-delay="100">

                    {{-- ОПИСАНИЕ --}}
                    @if($product->description)
                        <div class="description-section" data-aos="fade-up">
                            <h2 class="section-title">Описание товара</h2>
                            @php
                                $descText = $product->description;
                                $descLength = mb_strlen($descText);
                                $isLong = $descLength > 600;
                            @endphp
                            <div class="description-content {{ $isLong ? 'description-collapsed' : '' }}" id="descriptionText">
                                {!! nl2br(e($descText)) !!}
                            </div>
                            @if($isLong)
                                <button class="read-more-btn" id="readMoreBtn" onclick="toggleDescription()">
                                    <span id="readMoreText">Читать полностью</span>
                                    <span id="readMoreArrow" style="transition: transform 0.3s;">↓</span>
                                </button>
                            @endif
                        </div>
                    @endif

                    {{-- ХАРАКТЕРИСТИКИ --}}
                    <div class="specs-logistics-section" data-aos="fade-up">
                        <h2 class="section-title">Характеристики и логистика</h2>
                        <div class="unified-specs-grid">
                            @if($product->weight_grams)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Вес единицы</span>
                                    <span class="unified-spec-value">{{ number_format($product->weight_grams, 0, '.', ' ') }} г<span class="unified-spec-sub">{{ number_format($product->getWeightKg(), 3, '.', '') }} кг</span></span>
                                </div>
                            @endif
                            @if($product->packaging_type)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Тип упаковки</span>
                                    <span class="unified-spec-value">{{ $product->packaging_type }}</span>
                                </div>
                            @endif
                            @if($product->pieces_per_box)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Штук в коробке</span>
                                    <span class="unified-spec-value">{{ $product->pieces_per_box }} шт</span>
                                </div>
                            @endif
                            @if($product->box_weight_kg)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Вес коробки</span>
                                    <span class="unified-spec-value">{{ number_format($product->box_weight_kg, 2, '.', '') }} кг</span>
                                </div>
                            @endif
                            @if($product->box_volume)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Объём коробки</span>
                                    <span class="unified-spec-value">{{ number_format($product->box_volume, 3, '.', '') }} м³</span>
                                </div>
                            @endif
                            @if($product->shelf_life_days)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Срок годности</span>
                                    <span class="unified-spec-value">{{ $product->shelf_life_days }} дн<span class="unified-spec-sub">{{ round($product->shelf_life_days / 30, 1) }} мес</span></span>
                                </div>
                            @endif
                            @if($product->boxes_per_pallet)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Коробок на паллете</span>
                                    <span class="unified-spec-value">{{ $product->boxes_per_pallet }} кор</span>
                                </div>
                            @endif
                            @if($product->boxes_per_pallet && $product->pieces_per_box)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Штук на паллете</span>
                                    <span class="unified-spec-value">{{ number_format($product->pieces_per_box * $product->boxes_per_pallet, 0, '.', ' ') }}</span>
                                </div>
                            @endif
                            @if($product->boxes_per_pallet && $product->box_weight_kg)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Вес паллеты (≈)</span>
                                    <span class="unified-spec-value">{{ number_format($product->boxes_per_pallet * $product->box_weight_kg, 0, '.', ' ') }} кг</span>
                                </div>
                            @endif
                            <div class="unified-spec-item">
                                <span class="unified-spec-label">Доставка из КНР</span>
                                <span class="unified-spec-value">14–21 дн</span>
                            </div>
                            @if($product->tnved_code)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Код ТН ВЭД</span>
                                    <span class="unified-spec-value mono">{{ $product->tnved_code }}</span>
                                </div>
                            @endif
                            @if($product->barcode)
                                <div class="unified-spec-item">
                                    <span class="unified-spec-label">Штрихкод</span>
                                    <span class="unified-spec-value mono">{{ chunk_split($product->barcode, 4, ' ') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ВКУСЫ --}}
                    @if($product->flavors && count($product->flavors) > 0)
                        <div class="flavors-section" data-aos="fade-up">
                            <h2 class="section-title">Доступные вкусы</h2>
                            <div class="flavors-list">
                                @foreach($product->flavors as $flavor)
                                    <span class="flavor-tag">{{ $flavor }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Иероглиф --}}
                    <span class="hanzi-decor md" style="top: 10%; right: -20px; opacity: 0.10; transform: rotate(10deg);">详</span>
                </div>
            </div>

            {{-- СЛУЖЕБНАЯ ЗАМЕТКА --}}
            @if($product->comment)
                <div class="internal-note" data-aos="fade-up">
                    <div class="internal-note-label">Служебная информация</div>
                    <div class="internal-note-text">{!! nl2br(e($product->comment)) !!}</div>
                </div>
            @endif
        </div>

        {{-- ПОХОЖИЕ ТОВАРЫ --}}
        @if($relatedProducts && $relatedProducts->count() > 0)
            <div class="px-4 md:px-12 lg:px-16">
                <div class="related-section relative section-with-hanzi" data-aos="fade-up">
                    <h2 class="section-title">Похожие товары</h2>
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
                    {{-- Иероглифы --}}
                    <span class="hanzi-decor md" style="top: 10px; right: -20px; opacity: 0.10; transform: rotate(7deg);">类</span>
                    <span class="hanzi-decor sm" style="bottom: -10px; left: -15px; opacity: 0.08; transform: rotate(-8deg);">似</span>
                </div>
            </div>
        @endif

        {{-- CTA --}}
        <div class="px-4 md:px-12 lg:px-16">
            <div class="cta-section" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative z-10">
                    <div>
                        <h2 class="font-black text-[22px] text-black tracking-[-0.3px] uppercase">Готовы обсудить поставку?</h2>
                        <p class="text-[14px] text-black/30 mt-1 font-light">Рассчитаем точную стоимость партии с учётом логистики</p>
                    </div>
                    <a href="{{ route('contacts') }}" class="inline-block px-10 py-4 bg-black text-white text-[10px] font-semibold tracking-[2.5px] uppercase transition-all duration-300 hover:bg-black/85 hover:scale-[1.02]">
                        Получить КП
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 500, once: true, offset: 20, easing: 'ease-out' });

        function setAccentColor(hexColor) {
            if (!hexColor || hexColor === '#') hexColor = '#FF6B00';
            const hex = hexColor.replace('#', '');
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            document.documentElement.style.setProperty('--accent-r', r);
            document.documentElement.style.setProperty('--accent-g', g);
            document.documentElement.style.setProperty('--accent-b', b);
        }
        setAccentColor('{{ $product->accent_color ?? "#FF6B00" }}');

        (function() {
            const track = document.getElementById('productCarouselTrack');
            if (!track) return;
            const slides = track.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.gallery-section .carousel-dot');
            const thumbs = document.querySelectorAll('.gallery-thumb');
            const prevBtn = document.getElementById('productCarouselPrev');
            const nextBtn = document.getElementById('productCarouselNext');
            if (!slides.length) return;
            let currentIndex = 0;
            const totalSlides = slides.length;
            let isTransitioning = false;

            function goToSlide(index) {
                if (isTransitioning || totalSlides <= 1) return;
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;
                isTransitioning = true;
                currentIndex = index;
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                slides.forEach((slide, i) => slide.classList.toggle('active-slide', i === currentIndex));
                dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
                thumbs.forEach((thumb, i) => thumb.classList.toggle('active', i === currentIndex));
                setTimeout(() => { isTransitioning = false; }, 800);
            }

            prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));
            nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));
            dots.forEach(dot => dot.addEventListener('click', () => { const idx = parseInt(dot.dataset.index); if (idx !== currentIndex) goToSlide(idx); }));
            thumbs.forEach(thumb => thumb.addEventListener('click', () => { const idx = parseInt(thumb.dataset.index); if (idx !== currentIndex) goToSlide(idx); }));

            let touchStartX = 0;
            track.addEventListener('touchstart', (e) => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
            track.addEventListener('touchend', (e) => {
                const diffX = touchStartX - e.changedTouches[0].screenX;
                if (Math.abs(diffX) > 40) diffX > 0 ? goToSlide(currentIndex + 1) : goToSlide(currentIndex - 1);
            }, { passive: true });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') goToSlide(currentIndex - 1);
                if (e.key === 'ArrowRight') goToSlide(currentIndex + 1);
            });
            goToSlide(0);
        })();

        function toggleDescription() {
            const desc = document.getElementById('descriptionText');
            const btn = document.getElementById('readMoreBtn');
            const text = document.getElementById('readMoreText');
            const arrow = document.getElementById('readMoreArrow');
            if (desc.classList.contains('description-collapsed')) {
                desc.classList.remove('description-collapsed'); desc.classList.add('description-expanded');
                text.textContent = 'Свернуть'; arrow.textContent = '↑';
            } else {
                desc.classList.add('description-collapsed'); desc.classList.remove('description-expanded');
                text.textContent = 'Читать полностью'; arrow.textContent = '↓';
                desc.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>
@endpush
