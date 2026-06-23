@extends('layouts.app')

@section('title', 'Инь Ян – Экспорт и импорт из Китая')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ===== БАЗА ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: #111827;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ (ГЛОБАЛЬНЫЙ КЛАСС) ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: #FF6B00;
            opacity: 0.02;
            line-height: 1;
            z-index: 0;
        }

        .hanzi-decor.light {
            opacity: 0.025;
        }

        .hanzi-decor.dark {
            opacity: 0.07;
        }

        .hanzi-decor.xl {
            font-size: 140px;
        }

        .hanzi-decor.lg {
            font-size: 100px;
        }

        .hanzi-decor.md {
            font-size: 70px;
        }

        .hanzi-decor.sm {
            font-size: 45px;
        }

        .hanzi-decor.xs {
            font-size: 28px;
        }

        .hanzi-decor.rotate-5 { transform: rotate(5deg); }
        .hanzi-decor.rotate-8 { transform: rotate(8deg); }
        .hanzi-decor.rotate-10 { transform: rotate(10deg); }
        .hanzi-decor.rotate-12 { transform: rotate(12deg); }
        .hanzi-decor.rotate-n5 { transform: rotate(-5deg); }
        .hanzi-decor.rotate-n8 { transform: rotate(-8deg); }
        .hanzi-decor.rotate-n10 { transform: rotate(-10deg); }
        .hanzi-decor.rotate-n12 { transform: rotate(-12deg); }

        /* ===== СЕКЦИИ С ПОЗИЦИЕЙ ДЛЯ ИЕРОГЛИФОВ ===== */
        .section-with-hanzi {
            position: relative;
            overflow: visible !important;
        }

        /* ===== HERO ===== */
        .hero-section {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            align-items: stretch;
            min-height: calc(100vh - 80px);
            max-height: 100vh;
            background: #FFFFFF;
            position: relative;
            overflow: visible !important;
            padding-top: 64px;
        }

        @media (max-width: 1024px) {
            .hero-section {
                grid-template-columns: 1fr;
                min-height: auto;
                max-height: none;
                padding-top: 80px;
            }
        }

        /* Левая колонка — компактная */
        .hero-left {
            padding: 40px 60px 40px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #FFFFFF;
            position: relative;
            z-index: 2;
            overflow: visible !important;
        }

        @media (max-width: 1200px) {
            .hero-left {
                padding: 40px 40px 40px 48px;
            }
        }

        @media (max-width: 1024px) {
            .hero-left {
                padding: 40px 32px 32px;
                order: 1;
            }
        }

        @media (max-width: 640px) {
            .hero-left {
                padding: 24px 20px 24px;
            }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 9px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(0, 0, 0, 0.3);
            margin-bottom: 28px;
        }

        .hero-badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #111827;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.8); }
        }

        .hero-title {
            font-weight: 900;
            font-size: clamp(38px, 5vw, 68px);
            line-height: 0.9;
            text-transform: uppercase;
            color: #000000;
            letter-spacing: -2.5px;
            margin-bottom: 24px;
        }

        .hero-title-outline {
            -webkit-text-stroke: 1.5px #111827;
            color: transparent;
            margin-bottom: 4px;
        }

        .hero-title-underline {
            display: inline-block;
            position: relative;
        }

        .hero-title-underline::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #111827;
            transform: scaleX(0);
            transform-origin: right;
            animation: underlineReveal 1s cubic-bezier(0.34, 1.56, 0.64, 1) 0.6s forwards;
        }

        @keyframes underlineReveal {
            0% { transform: scaleX(0); transform-origin: right; }
            100% { transform: scaleX(1); transform-origin: left; }
        }

        .hero-desc {
            font-size: 14px;
            color: rgba(0, 0, 0, 0.4);
            line-height: 1.6;
            max-width: 380px;
            margin-bottom: 36px;
            font-weight: 350;
        }

        .hero-desc strong {
            color: rgba(0, 0, 0, 0.7);
            font-weight: 500;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            padding: 14px 36px;
            background: #111827;
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.35s ease;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-primary:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            background: #000000;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-ghost {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(0, 0, 0, 0.35);
            text-decoration: none;
            padding-bottom: 4px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.35s ease;
            position: relative;
        }

        .btn-ghost::after {
            content: '→';
            margin-left: 6px;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .btn-ghost:hover::after {
            transform: translateX(4px);
        }

        .btn-ghost:hover {
            color: #111827;
            border-bottom-color: #111827;
        }

        /* ===== ПРАВАЯ КОЛОНКА — КАРУСЕЛЬ ===== */
        .hero-right {
            background: #FFFFFF;
            position: relative;
            overflow: visible !important;
            min-height: 100%;
            max-height: 100vh;
        }

        .hero-right-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            height: 70%;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0;
            transition: opacity 0.6s ease;
            pointer-events: none;
            z-index: 0;
        }

        .hero-right-glow.visible {
            opacity: 0.25;
        }

        .hero-right-glow.glow-1 { background: radial-gradient(circle, rgba(255, 107, 53, 0.3), transparent 70%); }
        .hero-right-glow.glow-2 { background: radial-gradient(circle, rgba(255, 193, 7, 0.3), transparent 70%); }
        .hero-right-glow.glow-3 { background: radial-gradient(circle, rgba(76, 175, 80, 0.3), transparent 70%); }
        .hero-right-glow.glow-4 { background: radial-gradient(circle, rgba(33, 150, 243, 0.3), transparent 70%); }

        @media (max-width: 1024px) {
            .hero-right {
                min-height: 60vh;
                max-height: 70vh;
                height: 500px;
                order: 2;
            }
        }

        @media (max-width: 640px) {
            .hero-right {
                height: 420px;
                min-height: auto;
                max-height: 60vh;
            }
        }

        .carousel-container {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .carousel-track-wrapper {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .carousel-track {
            display: flex;
            height: 100%;
            transition: transform 0.6s cubic-bezier(0.65, 0, 0.35, 1);
            will-change: transform;
        }

        .carousel-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0px 40px 50px;
            box-sizing: border-box;
            position: relative;
        }

        @media (max-width: 640px) {
            .carousel-slide {
                padding: 16px 20px 70px;
            }
        }

        .product-card-visual {
            width: 100%;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 0;
            position: relative;
            z-index: 1;
        }

        .product-card-visual img {
            width: 100%;
            height: 100%;
            max-height: 55vh;
            object-fit: contain;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform;
            filter: drop-shadow(0 0 0 rgba(0,0,0,0));
        }

        @media (max-width: 1024px) {
            .product-card-visual img {
                max-height: 40vh;
            }
        }

        @media (max-width: 640px) {
            .product-card-visual img {
                max-height: 30vh;
            }
        }

        .carousel-slide:hover .product-card-visual img {
            transform: scale(1.04) rotateY(1deg);
            filter: drop-shadow(0 15px 30px rgba(0,0,0,0.06));
        }

        .carousel-slide.active-slide .product-card-visual img {
            animation: slideReveal 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @keyframes slideReveal {
            0% {
                opacity: 0;
                transform: scale(0.94) translateY(20px);
                filter: blur(3px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: blur(0);
            }
        }

        .carousel-slide.active-slide .product-card-info {
            animation: infoReveal 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.1s forwards;
        }

        @keyframes infoReveal {
            0% {
                opacity: 0;
                transform: translateY(12px) scale(0.97);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .carousel-slide:not(.active-slide) .product-card-visual img,
        .carousel-slide:not(.active-slide) .product-card-info {
            animation: none;
        }

        .product-card-emoji {
            font-size: min(160px, 16vw);
            line-height: 1;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            user-select: none;
        }

        .carousel-slide:hover .product-card-emoji {
            transform: scale(1.06) rotate(-2deg);
        }

        .product-card-info {
            text-align: center;
            flex-shrink: 0;
            margin-top: 16px;
            opacity: 0;
            transform: translateY(12px) scale(0.97);
            transition: opacity 0.4s ease, transform 0.4s ease;
            position: relative;
            z-index: 1;
        }

        .carousel-slide.active-slide .product-card-info {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .product-card-tag {
            display: inline-block;
            background: #F5F5F5;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(0, 0, 0, 0.4);
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .carousel-slide:hover .product-card-tag {
            background: #111827;
            color: #FFFFFF;
        }

        .product-card-name {
            font-weight: 700;
            font-size: 20px;
            color: #111827;
            margin-bottom: 4px;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        @media (max-width: 640px) {
            .product-card-name {
                font-size: 17px;
            }
        }

        .product-card-desc {
            font-size: 12px;
            color: rgba(0, 0, 0, 0.35);
            line-height: 1.5;
            font-weight: 350;
            max-width: 300px;
            margin: 0 auto;
        }

        .product-card-price {
            margin-top: 12px;
            font-weight: 600;
            font-size: 13px;
            color: #111827;
            background: #F5F5F5;
            padding: 5px 16px;
            border-radius: 100px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .carousel-slide:hover .product-card-price {
            background: #111827;
            color: #FFFFFF;
            transform: scale(1.04);
        }

        /* ===== НАВИГАЦИЯ КАРУСЕЛИ ===== */
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
            background: rgba(0, 0, 0, 0.12);
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 0;
            position: relative;
        }

        .carousel-dot.active {
            background: #111827;
            width: 22px;
            border-radius: 3px;
        }

        .carousel-dot:hover {
            background: rgba(0, 0, 0, 0.3);
            transform: scale(1.3);
        }

        .carousel-dot.active:hover {
            transform: scale(1);
            background: #111827;
        }

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            color: #111827;
            font-size: 16px;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .carousel-arrow:hover {
            background: #111827;
            color: #FFFFFF;
            border-color: #111827;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-50%) scale(1.06);
        }

        .carousel-arrow:active {
            transform: translateY(-50%) scale(0.92);
        }

        .carousel-arrow.prev {
            left: 16px;
        }

        .carousel-arrow.next {
            right: 16px;
        }

        @media (max-width: 640px) {
            .carousel-arrow {
                width: 32px;
                height: 32px;
                font-size: 13px;
            }
            .carousel-arrow.prev {
                left: 8px;
            }
            .carousel-arrow.next {
                right: 8px;
            }
            .carousel-nav {
                bottom: 14px;
            }
        }

        .carousel-counter {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            font-weight: 300;
            letter-spacing: 2.5px;
            color: rgba(0, 0, 0, 0.1);
            z-index: 5;
        }

        @media (max-width: 640px) {
            .carousel-counter {
                bottom: 52px;
                font-size: 8px;
            }
        }

        /* ===== ДОРОЖНАЯ РАЗМЕТКА ===== */
        .road-dash {
            background: repeating-linear-gradient(
                90deg,
                rgba(0,0,0,0.04) 0px,
                rgba(0,0,0,0.04) 30px,
                transparent 30px,
                transparent 60px
            );
        }

        /* ===== ПОИСК ===== */
        .search-wrapper {
            position: relative;
            overflow: visible !important;
        }

        /* ===== СТАТИСТИКА ===== */
        .stats-grid {
            position: relative;
            overflow: visible !important;
        }

        /* ===== ДОРОГА ===== */
        .road-wrapper {
            position: relative;
            overflow: visible !important;
        }

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
            .truck-animation {
                display: none !important;
            }
            .carousel-track {
                transition: none !important;
            }
            .carousel-slide:hover .product-card-visual img,
            .carousel-slide:hover .product-card-emoji {
                transform: none !important;
            }
            .carousel-slide .product-card-visual img,
            .carousel-slide .product-card-info {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .carousel-arrow:hover {
                transform: translateY(-50%) !important;
            }
            .hero-title-underline::after {
                animation: none !important;
                transform: scaleX(1) !important;
            }
            .hero-right-glow {
                display: none !important;
            }
            .hero-section {
                min-height: auto !important;
                max-height: none !important;
            }
            .hero-right {
                max-height: none !important;
                min-height: 500px !important;
            }
            .hanzi-decor {
                display: none !important;
            }
        }

        /* ===== СКРОЛЛБАР ===== */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #FFFFFF;
        }

        ::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 2px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #D1D5DB;
        }

        /* ===== БЕГУЩАЯ СТРОКА ===== */
        @keyframes marqueeScroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .marquee-track {
            display: flex;
            align-items: center;
            white-space: nowrap;
            animation: marqueeScroll 30s linear infinite;
            will-change: transform;
        }

        .marquee-track:hover {
            animation-play-state: paused;
        }

        @media (prefers-reduced-motion: reduce) {
            .marquee-track {
                animation: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <!-- ===== HERO ===== -->
    <section class="hero-section">
        <!-- Левая колонка — детализированная -->
        <div class="hero-left">
            <div class="hero-badge" data-aos="fade-up" data-aos-duration="600">
                <span class="hero-badge-dot"></span>
                Прямой импортёр №1 в РФ
            </div>

            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                Экспорт<br>
                <span class="hero-title-outline hero-title-underline">Импорт</span><br>
                Инь Ян
            </h1>

            <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">
                Оптовые поставки продуктов питания из Китая — лапша, вонтоны, рис.
                <br>
                <strong>Минимальный заказ 100 000 ₽</strong>
            </p>

            <!-- Мини-статистика в hero -->
            <div class="flex gap-6 mb-6" data-aos="fade-up" data-aos-delay="250">
                <div>
                    <div class="text-[20px] font-black text-black leading-none">10+</div>
                    <div class="text-[8px] tracking-[1px] uppercase text-black/25">Лет на рынке</div>
                </div>
                <div class="w-px bg-black/10"></div>
                <div>
                    <div class="text-[20px] font-black text-black leading-none">100+</div>
                    <div class="text-[8px] tracking-[1px] uppercase text-black/25">Клиентов</div>
                </div>
                <div class="w-px bg-black/10"></div>
                <div>
                    <div class="text-[20px] font-black text-black leading-none">98%</div>
                    <div class="text-[8px] tracking-[1px] uppercase text-black/25">Отгрузок вовремя</div>
                </div>
            </div>

            <!-- Список преимуществ -->
            <div class="flex flex-wrap gap-x-6 gap-y-2 mb-6" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-black/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-[10px] text-black/40 font-light">Сертификаты ЕАС</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-black/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-[10px] text-black/40 font-light">Честный знак</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-black/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-[10px] text-black/40 font-light">Собственный склад</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-black/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-[10px] text-black/40 font-light">Отгрузка за 24 ч</span>
                </div>
            </div>

            <!-- Партнёры -->
            <div class="flex items-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="350">
                <span class="text-[7px] tracking-[2px] uppercase text-black/20">С нами работают</span>
                <div class="flex gap-3">
                    <span class="text-[9px] font-bold text-black/10 tracking-wider">MAGNIT</span>
                    <span class="text-[9px] font-bold text-black/10 tracking-wider">X5 GROUP</span>
                    <span class="text-[9px] font-bold text-black/10 tracking-wider">LENTA</span>
                </div>
            </div>

            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
                <a href="#contacts" class="btn-primary">Запросить прайс</a>
                <a href="#products" class="btn-ghost">Каталог</a>
            </div>

            <!-- ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ (HERO LEFT) ===== -->
            <div class="absolute inset-0 pointer-events-none select-none overflow-visible z-0">
                <span class="hanzi-decor xl rotate-n8" style="bottom: 20px; right: 20px; opacity: 0.28;" data-aos="fade-up" data-aos-delay="400">和</span>
                <span class="hanzi-decor lg rotate-n10" style="top: 30px; left: 30px; opacity: 0.22;" data-aos="fade-down" data-aos-delay="200">福</span>
                <span class="hanzi-decor md rotate-10" style="top: 60px; right: 40px; opacity: 0.25;" data-aos="fade-down" data-aos-delay="300">龙</span>
                <span class="hanzi-decor lg rotate-12" style="bottom: 30%; right: 30px; opacity: 0.21;" data-aos="fade-left" data-aos-delay="350">宝</span>
                <span class="hanzi-decor md rotate-10" style="bottom: 60%; right: 25%; opacity: 0.25;" data-aos="fade-up" data-aos-delay="400">祥</span>
                <span class="hanzi-decor xl rotate-n5" style="top: 45%; left: 45%; opacity: 0.20;" data-aos="zoom-in" data-aos-delay="600">安</span>
            </div>
        </div>

        <!-- Правая колонка — карусель -->
        <div class="hero-right" data-aos="fade-in" data-aos-delay="200" data-aos-duration="700">
            <div class="hero-right-glow glow-1 visible" id="heroGlow"></div>
            <div class="carousel-container">
                <div class="carousel-track-wrapper">
                    <div class="carousel-track" id="carouselTrack">
                        @php
                            $slides = [
                                [
                                    'image' => 'images/product-1.png',
                                    'emoji' => '🍜',
                                    'tag' => 'Хит продаж',
                                    'name' => 'Лапша в стакане',
                                    'desc' => 'Говядина, курица. Удобный формат.',
                                    'price' => 'от 45 ₽ / шт',
                                    'glow' => 'glow-1',
                                ],
                                [
                                    'image' => 'images/product-2.png',
                                    'emoji' => '🥟',
                                    'tag' => 'Уникальная позиция',
                                    'name' => 'Лапша с вонтонами',
                                    'desc' => 'Фирменный продукт. Мало конкурентов.',
                                    'price' => 'от 85 ₽ / шт',
                                    'glow' => 'glow-2',
                                ],
                                [
                                    'image' => 'images/product-3.png',
                                    'emoji' => '🥣',
                                    'tag' => 'Высокая маржа',
                                    'name' => 'Сублимированная лапша',
                                    'desc' => 'Говядина, курица, морепродукты.',
                                    'price' => 'от 55 ₽ / шт',
                                    'glow' => 'glow-3',
                                ],
                                [
                                    'image' => 'images/product-1.png',
                                    'emoji' => '🍚',
                                    'tag' => 'Новинка',
                                    'name' => 'Рис быстрого приготовления',
                                    'desc' => 'Бекон, говядина, курица, тушёное мясо.',
                                    'price' => 'от 65 ₽ / шт',
                                    'glow' => 'glow-4',
                                ],
                            ];
                        @endphp

                        @foreach($slides as $index => $slide)
                            <div class="carousel-slide {{ $index === 0 ? 'active-slide' : '' }}" data-index="{{ $index }}" data-glow="{{ $slide['glow'] }}">
                                <div class="product-card-visual">
                                    @if($slide['image'])
                                        <img
                                            src="{{ asset($slide['image']) }}"
                                            alt="{{ $slide['name'] }}"
                                            loading="lazy"
                                        >
                                    @else
                                        <span class="product-card-emoji">{{ $slide['emoji'] }}</span>
                                    @endif
                                </div>

                                <div class="product-card-info">
                                    <span class="product-card-tag">{{ $slide['tag'] }}</span>
                                    <div class="product-card-name">{{ $slide['name'] }}</div>
                                    <div class="product-card-desc">{{ $slide['desc'] }}</div>
                                    <span class="product-card-price">{{ $slide['price'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="carousel-arrow prev" id="carouselPrev" aria-label="Предыдущий">←</button>
                <button class="carousel-arrow next" id="carouselNext" aria-label="Следующий">→</button>

                <div class="carousel-counter" id="carouselCounter">01 / 04</div>

                <div class="carousel-nav">
                    @foreach($slides as $index => $slide)
                        <button
                            class="carousel-dot {{ $index === 0 ? 'active' : '' }}"
                            data-index="{{ $index }}"
                            aria-label="Слайд {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ПОИСК ===== -->
    <div class="px-6 md:px-12 lg:px-16 pb-6 relative z-10 -mt-4 pt-4 search-wrapper section-with-hanzi" data-aos="fade-up" data-aos-delay="150">
        <div class="max-w-[560px] mx-auto relative">
            <form action="{{ route('search') }}" method="GET" class="flex items-center bg-white border border-black/10 rounded-full overflow-hidden transition-all duration-300 focus-within:border-black/30 focus-within:shadow-[0_0_0_3px_rgba(0,0,0,0.02)]">
                <input
                    type="text"
                    name="query"
                    id="searchInput"
                    class="flex-1 bg-transparent border-none px-5 py-3 text-black text-sm placeholder-black/20 focus:outline-none"
                    placeholder="Поиск товаров..."
                    value="{{ request('query') }}"
                    autocomplete="off"
                >
                <button type="submit" class="bg-black text-white border-none py-2.5 px-5 m-1 rounded-full text-xs font-medium tracking-[1px] uppercase transition-all duration-300 hover:bg-black/80">
                    Найти
                </button>
            </form>

            <div id="autocompleteDropdown" class="absolute top-[calc(100%+6px)] left-0 right-0 bg-white border border-black/10 rounded-xl max-h-[260px] overflow-y-auto hidden z-[100] shadow-[0_20px_40px_rgba(0,0,0,0.06)]"></div>
        </div>
        <!-- Иероглифы для секции поиска -->
        <span class="hanzi-decor xs rotate-10" style="bottom: -10px; right: 5%; opacity: 0.08;">寻</span>
        <span class="hanzi-decor xs rotate-n8" style="top: -10px; left: 8%; opacity: 0.08;">品</span>
    </div>

    <!-- ===== СТАТИСТИКА ===== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 border-t border-b border-black/5 stats-grid section-with-hanzi">
        @php
            $stats = [
                ['number' => '10 000+', 'label' => 'Тонн импортировано'],
                ['number' => '100+', 'label' => 'Активных клиентов'],
                ['number' => '98%', 'label' => 'Поставок вовремя'],
                ['number' => '10+', 'label' => 'Лет на рынке'],
            ];
        @endphp

        @foreach($stats as $index => $stat)
            <div class="px-6 py-8 lg:p-10 text-center border-r border-black/5 {{ $loop->last ? 'border-r-0' : '' }} {{ $loop->index === 1 ? 'max-lg:border-r-0' : '' }} transition-colors duration-300 hover:bg-black/5 stat-item" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}" data-target="{{ preg_replace('/[^0-9]/', '', $stat['number']) }}">
                <div class="font-black text-[32px] lg:text-[40px] text-black tracking-[-1px] leading-none stat-number">
                    {{ $stat['number'] }}
                </div>
                <div class="text-[9px] tracking-[2px] uppercase text-black/30 mt-2">
                    {{ $stat['label'] }}
                </div>
            </div>
        @endforeach

        <!-- Иероглифы для статистики -->
        <span class="hanzi-decor md rotate-10" style="top: 50%; left: 8%; transform: translateY(-50%) rotate(10deg); opacity: 0.02;">数</span>
        <span class="hanzi-decor md rotate-n8" style="top: 50%; right: 8%; transform: translateY(-50%) rotate(-8deg); opacity: 0.02;">据</span>
    </div>

    <!-- ===== БЕГУЩАЯ СТРОКА С ИЕРОГЛИФАМИ ===== -->
    <div class="bg-white border-b border-black/5 overflow-hidden" style="position: relative; height: 60px;">
        <!-- Фоновая дорожка -->
        <div class="absolute top-1/2 left-0 right-0 h-[1px] bg-black/5"></div>
        <div class="absolute top-1/2 left-0 right-0 h-[1px] mt-3 road-dash"></div>

        <!-- БЕГУЩАЯ СТРОКА -->
        <div class="absolute top-0 left-0 w-full h-full flex items-center overflow-hidden">
            <div class="marquee-track">
                <!-- Первый набор -->
                <span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px; font-family: 'Noto Serif SC', 'SimSun', serif; font-weight: 900; font-size: 32px; color: #FF6B00; opacity: 0.15; letter-spacing: 6px;">
                <span>信</span>
                <span>誉</span>
                <span>第</span>
                <span>一</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>品</span>
                <span>质</span>
                <span>为</span>
                <span>本</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>诚</span>
                <span>信</span>
                <span>合</span>
                <span>作</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>共</span>
                <span>赢</span>
                <span>未</span>
                <span>来</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>中</span>
                <span>俄</span>
                <span>贸</span>
                <span>易</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>直</span>
                <span>接</span>
                <span>进</span>
                <span>口</span>
            </span>
                <!-- Дубликат для бесшовной анимации -->
                <span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px; font-family: 'Noto Serif SC', 'SimSun', serif; font-weight: 900; font-size: 32px; color: #FF6B00; opacity: 0.15; letter-spacing: 6px;">
                <span>信</span>
                <span>誉</span>
                <span>第</span>
                <span>一</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>品</span>
                <span>质</span>
                <span>为</span>
                <span>本</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>诚</span>
                <span>信</span>
                <span>合</span>
                <span>作</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>共</span>
                <span>赢</span>
                <span>未</span>
                <span>来</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>中</span>
                <span>俄</span>
                <span>贸</span>
                <span>易</span>
                <span style="color: #FF6B00; opacity: 0.5; font-size: 20px; font-weight: 300;">|</span>
                <span>直</span>
                <span>接</span>
                <span>进</span>
                <span>口</span>
            </span>
            </div>
        </div>
    </div>

    <!-- ===== ПОЧЕМУ МЫ ===== -->
    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] section-with-hanzi" id="why">
        <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">О нас</p>
        <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] mb-[48px]" data-aos="fade-up" data-aos-delay="100">
            Партнёры доверяют нам
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-[1px] bg-black/5">
            @php
                $reasons = [
                    ['num' => '01', 'title' => 'Выгода', 'desc' => 'Прямой импорт без посредников. Никаких наценок в цепочке поставок.'],
                    ['num' => '02', 'title' => 'Надёжность', 'desc' => 'Декларации, ЕАС, Честный знак — всё оформлено под ключ.'],
                    ['num' => '03', 'title' => 'Оперативность', 'desc' => 'Собственный склад. Отгрузка на следующий день после оплаты.'],
                ];
            @endphp

            @foreach($reasons as $index => $reason)
                <div class="bg-white p-8 lg:p-10 transition-all duration-300 hover:bg-black/5" data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}">
                    <div class="font-black text-3xl text-black/5 leading-none mb-4">{{ $reason['num'] }}</div>
                    <div class="font-bold text-[10px] tracking-[3px] uppercase text-black mb-3">{{ $reason['title'] }}</div>
                    <p class="text-sm text-black/40 leading-relaxed font-light">{{ $reason['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Иероглифы для секции "Почему мы" -->
        <span class="hanzi-decor lg rotate-n10" style="top: 10%; right: 3%; opacity: 0.025;">信</span>
        <span class="hanzi-decor md rotate-12" style="bottom: 10%; left: 3%; opacity: 0.025;">德</span>
        <span class="hanzi-decor sm rotate-n8" style="top: 30%; left: 8%; opacity: 0.02;">诚</span>
        <span class="hanzi-decor sm rotate-8" style="bottom: 30%; right: 8%; opacity: 0.02;">誉</span>
    </section>

    <!-- ===== КАТАЛОГ ===== -->
    <section class="bg-white py-[60px] lg:py-[80px] border-t border-b border-black/5 section-with-hanzi" id="products">
        <div class="px-6 md:px-12 lg:px-16 pb-10">
            <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">Ассортимент</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px]" data-aos="fade-up" data-aos-delay="100">Наша продукция</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 border-t border-black/5">
            @php
                $products = [
                    ['icon' => '🍜', 'tag' => 'Лапша · Стакан', 'name' => 'Лапша быстрого приготовления в стакане', 'desc' => 'Говядина или курица. Удобная упаковка.'],
                    ['icon' => '🥣', 'tag' => 'Лапша · Мягкая упаковка', 'name' => 'Сублимированная лапша', 'desc' => 'Говядина, курица, морепродукты. Высокая маржинальность.'],
                    ['icon' => '🥟', 'tag' => 'Вонтоны', 'name' => 'Лапша с вонтонами', 'desc' => 'Фирменная позиция. Уникальный продукт на рынке.'],
                    ['icon' => '🍚', 'tag' => 'Рис', 'name' => 'Рис быстрого приготовления', 'desc' => 'Бекон, говядина с перцем, курица, тушёное мясо.'],
                ];
            @endphp

            @foreach($products as $index => $product)
                <div class="p-6 lg:p-8 border-r border-b border-black/5 {{ $loop->last ? 'lg:border-r-0' : '' }} {{ $loop->index % 2 === 1 ? 'max-lg:border-r-0' : '' }} max-sm:border-r-0 transition-all duration-300 hover:bg-black/5" data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}">
                    <span class="text-2xl mb-4 block transition-transform duration-300 hover:scale-110">{{ $product['icon'] }}</span>
                    <div class="text-[8px] tracking-[3px] uppercase text-black/30 mb-2">{{ $product['tag'] }}</div>
                    <div class="font-bold text-[13px] leading-tight text-black mb-2">{{ $product['name'] }}</div>
                    <p class="text-[11px] text-black/30 leading-relaxed font-light">{{ $product['desc'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="px-6 md:px-12 lg:px-16 pt-10 text-center" data-aos="fade-up" data-aos-delay="400">
            <a href="#contacts" class="inline-block px-8 py-3 bg-black text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02]">
                Полный прайс
            </a>
        </div>

        <!-- Иероглифы для каталога -->
        <span class="hanzi-decor lg rotate-10" style="top: 5%; left: 2%; opacity: 0.025;">品</span>
        <span class="hanzi-decor md rotate-n12" style="bottom: 5%; right: 2%; opacity: 0.025;">类</span>
        <span class="hanzi-decor sm rotate-8" style="top: 20%; right: 5%; opacity: 0.02;">丰</span>
        <span class="hanzi-decor xs rotate-n8" style="bottom: 15%; left: 5%; opacity: 0.02;">富</span>
    </section>

    <!-- ===== CTA ===== -->
    <div class="px-6 md:px-12 lg:px-16 py-14 lg:py-16 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-black/5 bg-white section-with-hanzi">
        <h2 class="font-black text-[clamp(24px,2.8vw,38px)] uppercase tracking-[-1px] leading-none" data-aos="fade-right">
            Готовы начать<br>
            <span class="text-black/20">сотрудничество?</span>
        </h2>
        <a href="#contacts" class="inline-block px-8 py-3 bg-black text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02] flex-shrink-0" data-aos="fade-left" data-aos-delay="150">
            Связаться
        </a>
        <!-- Иероглифы для CTA -->
        <span class="hanzi-decor sm rotate-10" style="top: 10%; right: 30%; opacity: 0.025;">赢</span>
        <span class="hanzi-decor xs rotate-n5" style="bottom: 10%; left: 10%; opacity: 0.02;">合</span>
        <span class="hanzi-decor xs rotate-8" style="bottom: 10%; right: 25%; opacity: 0.02;">作</span>
    </div>

    <!-- ===== КОНТАКТЫ ===== -->
    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] section-with-hanzi" id="contacts">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            <div>
                <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">Контакты</p>
                <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[500px] mb-10" data-aos="fade-up" data-aos-delay="100">Свяжитесь с нами</h2>

                @php
                    $contacts = [
                        ['label' => 'Коммерческий директор', 'value' => 'Алексей Ерышев', 'type' => 'text'],
                        ['label' => 'Телефон', 'value' => '+7 999 618 28 82', 'type' => 'tel', 'href' => 'tel:+79996182882'],
                        ['label' => 'Email', 'value' => 'eksport.inyan@mail.ru', 'type' => 'email', 'href' => 'mailto:eksport.inyan@mail.ru'],
                        ['label' => 'Адрес', 'value' => '692771, Приморский край, г. Артём, ул. Постникова, д. 2а, каб. 21', 'type' => 'text'],
                    ];
                @endphp

                @foreach($contacts as $index => $contact)
                    <div class="mb-6" data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}">
                        <div class="text-[9px] tracking-[3px] uppercase text-black/30 mb-1">{{ $contact['label'] }}</div>
                        @if($contact['type'] === 'tel' || $contact['type'] === 'email')
                            <a href="{{ $contact['href'] }}" class="font-semibold text-[16px] text-black no-underline transition-colors duration-300 hover:text-black/60">
                                {{ $contact['value'] }}
                            </a>
                        @else
                            <span class="font-semibold text-[16px] text-black">{{ $contact['value'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>

            <div data-aos="fade-up" data-aos-delay="300">
                <div class="border border-black/10 p-6 bg-white">
                    <div class="text-[12px] text-black/50 space-y-3">
                        <div>
                            <strong class="text-black/60 block text-[9px] tracking-[2px] uppercase mb-0.5 font-medium">Организация</strong>
                            ООО «Экспорт-Импорт Инь-Ян»
                        </div>
                        <div>
                            <strong class="text-black/60 block text-[9px] tracking-[2px] uppercase mb-0.5 font-medium">ОГРН</strong>
                            1232500004846
                        </div>
                        <div>
                            <strong class="text-black/60 block text-[9px] tracking-[2px] uppercase mb-0.5 font-medium">ИНН / КПП</strong>
                            2502071087 / 250201001
                        </div>
                    </div>
                </div>
                <div class="mt-4 p-6 border border-black/10 border-t-0 bg-white">
                    <p class="text-[12px] text-black/30 leading-relaxed font-light">
                        Стабильные поставки, конкурентные цены и широкий ассортимент продуктов из Китая.
                    </p>
                </div>
            </div>
        </div>

        <!-- Иероглифы для контактов -->
        <span class="hanzi-decor lg rotate-n8" style="top: 5%; right: 5%; opacity: 0.025;">联</span>
        <span class="hanzi-decor md rotate-10" style="bottom: 5%; left: 5%; opacity: 0.025;">系</span>
        <span class="hanzi-decor sm rotate-n12" style="top: 40%; left: 2%; opacity: 0.02;">友</span>
        <span class="hanzi-decor sm rotate-8" style="bottom: 40%; right: 2%; opacity: 0.02;">好</span>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // ===== ИНИЦИАЛИЗАЦИЯ AOS =====
        AOS.init({
            duration: 600,
            once: true,
            offset: 30,
            easing: 'ease-out'
        });

        // ===== АНИМАЦИЯ СТАТИСТИКИ =====
        (function() {
            const statItems = document.querySelectorAll('.stat-item');
            let animated = false;

            function animateStats() {
                if (animated) return;
                animated = true;

                statItems.forEach(item => {
                    const target = parseInt(item.dataset.target);
                    if (!target) return;
                    const numberEl = item.querySelector('.stat-number');
                    let current = 0;
                    const step = Math.ceil(target / 50);

                    const timer = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            clearInterval(timer);
                            current = target;
                            numberEl.textContent = current.toLocaleString() + '+';
                        } else {
                            numberEl.textContent = current.toLocaleString() + '+';
                        }
                    }, 20);
                });
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.3 });

            if (statItems.length) observer.observe(statItems[0]);
        })();

        // ===== КАРУСЕЛЬ =====
        (function() {
            const track = document.getElementById('carouselTrack');
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            const prevBtn = document.getElementById('carouselPrev');
            const nextBtn = document.getElementById('carouselNext');
            const glow = document.getElementById('heroGlow');
            const counter = document.getElementById('carouselCounter');

            if (!track || !slides.length) return;

            let currentIndex = 0;
            const totalSlides = slides.length;
            let autoPlayInterval;
            let isInteracting = false;
            let isTransitioning = false;

            function updateGlow(index) {
                if (!glow) return;
                const slide = slides[index];
                if (!slide) return;

                glow.className = 'hero-right-glow';
                const glowClass = slide.dataset.glow || 'glow-1';
                glow.classList.add(glowClass);

                requestAnimationFrame(() => {
                    glow.classList.add('visible');
                });
            }

            function updateCounter(index) {
                if (!counter) return;
                const num = String(index + 1).padStart(2, '0');
                const total = String(totalSlides).padStart(2, '0');
                counter.textContent = `${num} / ${total}`;
            }

            function goToSlide(index) {
                if (isTransitioning) return;
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;

                isTransitioning = true;
                currentIndex = index;

                track.style.transform = `translateX(-${currentIndex * 100}%)`;

                slides.forEach((slide, i) => {
                    slide.classList.toggle('active-slide', i === currentIndex);
                });

                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === currentIndex);
                });

                updateGlow(currentIndex);
                updateCounter(currentIndex);

                setTimeout(() => {
                    isTransitioning = false;
                }, 650);
            }

            function nextSlide() {
                if (!isTransitioning) goToSlide(currentIndex + 1);
            }

            function prevSlide() {
                if (!isTransitioning) goToSlide(currentIndex - 1);
            }

            function startAutoPlay() {
                stopAutoPlay();
                autoPlayInterval = setInterval(() => {
                    if (!isInteracting && !isTransitioning) nextSlide();
                }, 4000);
            }

            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            prevBtn?.addEventListener('click', () => { prevSlide(); stopAutoPlay(); startAutoPlay(); });
            nextBtn?.addEventListener('click', () => { nextSlide(); stopAutoPlay(); startAutoPlay(); });

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const index = parseInt(dot.dataset.index);
                    if (index !== currentIndex && !isTransitioning) {
                        goToSlide(index);
                        stopAutoPlay();
                        startAutoPlay();
                    }
                });
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') { prevSlide(); stopAutoPlay(); startAutoPlay(); }
                if (e.key === 'ArrowRight') { nextSlide(); stopAutoPlay(); startAutoPlay(); }
            });

            const container = track.closest('.carousel-container');
            container?.addEventListener('mouseenter', () => { isInteracting = true; });
            container?.addEventListener('mouseleave', () => { isInteracting = false; });

            let touchStartX = 0;
            let touchStartY = 0;

            track.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                touchStartY = e.changedTouches[0].screenY;
                isInteracting = true;
            }, { passive: true });

            track.addEventListener('touchend', (e) => {
                const diffX = touchStartX - e.changedTouches[0].screenX;
                const diffY = Math.abs(touchStartY - e.changedTouches[0].screenY);
                isInteracting = false;

                if (Math.abs(diffX) > 40 && Math.abs(diffX) > diffY * 1.5) {
                    diffX > 0 ? nextSlide() : prevSlide();
                    stopAutoPlay();
                    startAutoPlay();
                }
            }, { passive: true });

            goToSlide(0);
            startAutoPlay();

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) stopAutoPlay();
                else startAutoPlay();
            });
        })();

        // ===== ПОИСК =====
        const searchInput = document.getElementById('searchInput');
        const dropdown = document.getElementById('autocompleteDropdown');
        let debounceTimer, abortController = null;

        function debounce(fn, delay) {
            return (...args) => { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fn(...args), delay); };
        }

        async function searchSuggestions(query) {
            if (!query || query.length < 2) { dropdown.innerHTML = ''; dropdown.classList.add('hidden'); return; }
            if (abortController) abortController.abort();
            abortController = new AbortController();
            dropdown.innerHTML = '<div class="px-5 py-3 text-black/40 text-sm">Поиск...</div>';
            dropdown.classList.remove('hidden');

            try {
                const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=6&accept-language=ru&featureType=city`, {
                    signal: abortController.signal,
                    headers: { 'User-Agent': 'InYanLanding/1.0' }
                });
                let data = res.ok ? await res.json() : [];
                if (!data.length) { dropdown.innerHTML = '<div class="px-5 py-3 text-black/40 text-sm">Ничего не найдено</div>'; return; }

                dropdown.innerHTML = data.map(item => {
                    const addr = item.address || {};
                    const city = addr.city || addr.town || addr.village || '';
                    const country = addr.country || '';
                    return `<div class="autocomplete-item px-5 py-3 cursor-pointer border-b border-black/5 last:border-b-0 flex justify-between items-center hover:bg-black/5 transition-colors" data-value="${city}"><span class="font-medium text-black text-sm">${city}</span>${country ? `<span class="text-xs text-black/30">${country}</span>` : ''}</div>`;
                }).join('');

                dropdown.querySelectorAll('.autocomplete-item').forEach(el => {
                    el.addEventListener('click', function() {
                        searchInput.value = this.dataset.value;
                        dropdown.classList.add('hidden');
                        searchInput.closest('form').submit();
                    });
                });
            } catch (e) {
                if (e.name !== 'AbortError') dropdown.innerHTML = '<div class="px-5 py-3 text-black/40 text-sm">Ошибка</div>';
            }
        }

        const debouncedSearch = debounce(searchSuggestions, 300);
        searchInput?.addEventListener('input', e => debouncedSearch(e.target.value.trim()));
        document.addEventListener('click', e => { if (!searchInput?.contains(e.target) && !dropdown?.contains(e.target)) dropdown?.classList.add('hidden'); });

        // ===== ГРУЗОВИК =====
        const truck = document.getElementById('truck');
        const road = document.getElementById('road');
        let running = false;

        function runTruck() {
            if (running || !truck) return;
            running = true;
            let x = -340;
            const target = window.innerWidth + 60;
            function step() {
                x += 3;
                truck.style.left = x + 'px';
                if (x < target) requestAnimationFrame(step);
                else { truck.style.left = '-340px'; running = false; }
            }
            requestAnimationFrame(step);
        }

        if (road) {
            new IntersectionObserver(entries => { if (entries[0].isIntersecting) runTruck(); }, { threshold: 0.3 }).observe(road);
        }

        let lastY = 0, cooldown = false;
        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            if (y > lastY && y > window.innerHeight * 0.5 && !cooldown) {
                cooldown = true;
                runTruck();
                setTimeout(() => { cooldown = false; }, 4000);
            }
            lastY = y;
        });

        // ===== ПЛАВНЫЙ СКРОЛЛ =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
@endpush
