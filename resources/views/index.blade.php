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
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ===== CSS-ПЕРЕМЕННЫЕ ===== */
        :root {
            --carousel-accent-r: 255;
            --carousel-accent-g: 107;
            --carousel-accent-b: 0;
            --carousel-gradient-from: rgba(255, 107, 0, 0.12);
            --carousel-gradient-to: rgba(255, 255, 255, 0);
            --carousel-radial-opacity: 0.06;
            --carousel-glow-opacity: 0.3;
            --carousel-left-gradient-from: rgba(255, 107, 0, 0.06);
            --carousel-left-gradient-to: rgba(255, 255, 255, 0);
        }

        /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: rgb(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b));
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

        .hanzi-decor.rotate-5 { transform: rotate(5deg); }
        .hanzi-decor.rotate-8 { transform: rotate(8deg); }
        .hanzi-decor.rotate-10 { transform: rotate(10deg); }
        .hanzi-decor.rotate-12 { transform: rotate(12deg); }
        .hanzi-decor.rotate-n5 { transform: rotate(-5deg); }
        .hanzi-decor.rotate-n8 { transform: rotate(-8deg); }
        .hanzi-decor.rotate-n10 { transform: rotate(-10deg); }
        .hanzi-decor.rotate-n12 { transform: rotate(-12deg); }

        .section-with-hanzi {
            position: relative;
            overflow: visible !important;
        }

        @media(max-width:768px){
            .hanzi-decor.xl{font-size:100px;opacity:.12!important}
            .hanzi-decor.lg{font-size:70px;opacity:.10!important}
            .hanzi-decor.md{font-size:50px;opacity:.08!important}
            .hanzi-decor.sm{font-size:35px;opacity:.06!important}
            .hanzi-decor.xs{font-size:22px;opacity:.05!important}
        }

        @media(max-width:480px){
            .hanzi-decor.xl{font-size:80px;opacity:.08!important}
            .hanzi-decor.lg{font-size:55px;opacity:.06!important}
            .hanzi-decor.md{font-size:40px;opacity:.05!important}
            .hanzi-decor.sm{font-size:28px;opacity:.04!important}
            .hanzi-decor.xs{font-size:18px;opacity:.03!important}
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
            padding-bottom: 80px;
            border-bottom: none !important;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0 0 -50px 0;
            z-index: 3;
            pointer-events: none;
            background: linear-gradient(
                225deg,
                rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.10) 0%,
                rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.06) 20%,
                rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.02) 40%,
                transparent 55%
            );
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: background;
        }

        @media (max-width: 1024px) {
            .hero-section {
                grid-template-columns: 1fr;
                min-height: auto;
                max-height: none;
                padding-top: 80px;
            }

            .hero-section::before {
                inset: 0 0 -40px 0;
                background: linear-gradient(
                    180deg,
                    rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.08) 0%,
                    rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.03) 30%,
                    transparent 40%
                );
            }
        }

        /* ===== ЛЕВАЯ КОЛОНКА ===== */
        .hero-left {
            padding: 85px 56px 48px 72px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #FFFFFF;
            position: relative;
            z-index: 2;
            overflow: hidden !important;
        }

        .hero-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(
                circle at 30% 50%,
                rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.08) 0%,
                transparent 70%
            );
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
            pointer-events: none;
            will-change: background;
        }

        .hero-left > * {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 1200px) {
            .hero-left { padding: 40px 36px 40px 48px; }
        }

        @media (max-width: 1024px) {
            .hero-left { padding: 40px 32px 32px; order: 1; }
        }

        @media (max-width: 640px) {
            .hero-left { padding: 24px 20px 24px; }
        }

        /* ===== БЕЙДЖ ===== */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.4);
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
        }

        .hero-badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #1A1A1A;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(1.8); }
        }

        /* ===== ЗАГОЛОВОК ===== */
        .hero-title {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: clamp(42px, 5.5vw, 72px);
            line-height: 0.9;
            text-transform: uppercase;
            color: #1A1A1A;
            letter-spacing: -2.5px;
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
        }

        .hero-title-outline {
            -webkit-text-stroke: 1.5px #1A1A1A;
            color: transparent;
        }

        /* ===== ОПИСАНИЕ ===== */
        .hero-desc {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 15px;
            color: #2A2A2A;
            line-height: 1.7;
            max-width: 460px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        /* ===== МИНИМАЛЬНЫЙ ЗАКАЗ ===== */
        .hero-min-order {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
            position: relative;
            z-index: 1;
            padding: 10px 16px;
            background: rgba(26, 26, 26, 0.05);
            max-width: 320px;
        }

        .hero-min-order .min-order-line {
            display: none;
        }

        .hero-min-order .min-order-label {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.4);
        }

        .hero-min-order .min-order-amount {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #1A1A1A;
            letter-spacing: 0;
            margin-left: auto;
        }

        /* ===== ПРЕИМУЩЕСТВА ===== */
        .hero-benefits {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 28px;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
        }

        .hero-benefit-item {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 12px;
            color: #3A3A3A;
            letter-spacing: 0.3px;
        }

        .hero-benefit-item::before {
            content: '—';
            margin-right: 6px;
            color: #AAAAAA;
        }

        /* ===== ДОПОЛНИТЕЛЬНАЯ ИНФОРМАЦИЯ ===== */
        .hero-extra-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
            padding: 16px 0;
            border-top: 1px solid rgba(26, 26, 26, 0.06);
            border-bottom: 1px solid rgba(26, 26, 26, 0.06);
        }

        .hero-extra-item {
            font-family: 'Inter', sans-serif;
        }

        .hero-extra-item .label {
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            font-weight: 500;
            display: block;
            margin-bottom: 2px;
        }

        .hero-extra-item .value {
            font-size: 13px;
            font-weight: 500;
            color: #1A1A1A;
        }

        /* ===== КНОПКИ ===== */
        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            align-items: center;
            position: relative;
            z-index: 1;
            margin-top: 4px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            padding: 16px 40px;
            background: #1A1A1A;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.35s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #000000;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(26, 26, 26, 0.15);
        }

        .btn-ghost {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.4);
            text-decoration: none;
            padding-bottom: 3px;
            border-bottom: 1.5px solid rgba(26, 26, 26, 0.1);
            transition: all 0.35s ease;
            font-weight: 500;
        }

        .btn-ghost::after {
            content: '→';
            margin-left: 6px;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .btn-ghost:hover::after { transform: translateX(4px); }
        .btn-ghost:hover { color: #1A1A1A; border-bottom-color: #1A1A1A; }

        /* ===== КЛИЕНТЫ ===== */
        .hero-clients {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 20px;
            position: relative;
            z-index: 1;
            padding-top: 20px;
            border-top: 1px solid rgba(26, 26, 26, 0.05);
        }

        .hero-clients-label {
            font-family: 'Inter', sans-serif;
            font-size: 7px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.2);
            font-weight: 500;
        }

        .hero-clients-logos {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .hero-clients-logos span {
            font-family: 'Inter', sans-serif;
            font-size: 9px;
            font-weight: 500;
            color: rgba(26, 26, 26, 0.15);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }

        .hero-clients-logos span:hover {
            color: rgba(26, 26, 26, 0.3);
        }

        /* ===== ПРАВАЯ КОЛОНКА ===== */
        .hero-right {
            background: #FFFFFF;
            position: relative;
            overflow: hidden !important;
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
            transition: opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1),
            background 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(
                circle,
                rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.3) 0%,
                transparent 70%
            );
            will-change: background, opacity;
        }

        .hero-right-glow.visible {
            opacity: 0.3;
        }

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
            .hero-benefits {
                gap: 4px 16px;
            }
            .hero-benefit-item {
                font-size: 10px;
            }
            .hero-extra-info {
                grid-template-columns: 1fr 1fr;
                gap: 8px 16px;
            }
            .hero-clients {
                flex-wrap: wrap;
                gap: 8px;
            }
        }

        /* ===== КАРУСЕЛЬ ===== */
        .carousel-container {
            width: 100%;
            height: 100%;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .carousel-track-wrapper {
            flex: 1;
            width: 100%;
            overflow: hidden;
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0px 40px 50px;
            box-sizing: border-box;
            position: relative;
        }

        @media (max-width: 640px) {
            .carousel-slide { padding: 16px 20px 70px; }
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

        .product-card-visual .fallback-emoji {
            font-size: min(160px, 16vw);
            line-height: 1;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            user-select: none;
        }

        @media (max-width: 1024px) {
            .product-card-visual img { max-height: 40vh; }
        }

        @media (max-width: 640px) {
            .product-card-visual img { max-height: 30vh; }
        }

        .carousel-slide:hover .product-card-visual img {
            transform: scale(1.04) rotateY(1deg);
            filter: drop-shadow(0 15px 30px rgba(26, 26, 26, 0.04));
        }

        .carousel-slide.active-slide .product-card-visual img,
        .carousel-slide.active-slide .product-card-visual .fallback-emoji {
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
            0% { opacity: 0; transform: translateY(12px) scale(0.97); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .carousel-slide:not(.active-slide) .product-card-visual img,
        .carousel-slide:not(.active-slide) .product-card-visual .fallback-emoji,
        .carousel-slide:not(.active-slide) .product-card-info {
            animation: none;
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
            background: rgba(26, 26, 26, 0.06);
            padding: 4px 12px;
            font-family: 'Inter', sans-serif;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.4);
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .carousel-slide:hover .product-card-tag {
            background: #1A1A1A;
            color: #FFFFFF;
        }

        .product-card-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 20px;
            color: #1A1A1A;
            margin-bottom: 4px;
            line-height: 1.2;
            letter-spacing: -0.3px;
        }

        @media (max-width: 640px) { .product-card-name { font-size: 17px; } }

        .product-card-desc {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: rgba(26, 26, 26, 0.4);
            line-height: 1.5;
            font-weight: 350;
            max-width: 300px;
            margin: 0 auto;
        }

        .product-card-price-wrap {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .product-card-price {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            color: #1A1A1A;
            background: rgba(26, 26, 26, 0.06);
            padding: 5px 16px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .product-card-price-note {
            font-family: 'Inter', sans-serif;
            font-size: 8px;
            font-weight: 400;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.25);
            transition: all 0.3s ease;
        }

        .carousel-slide:hover .product-card-price {
            background: #1A1A1A;
            color: #FFFFFF;
            transform: scale(1.04);
        }

        .carousel-slide:hover .product-card-price-note {
            color: rgba(255, 255, 255, 0.5);
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
            background: rgba(26, 26, 26, 0.12);
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 0;
            position: relative;
        }

        .carousel-dot.active {
            background: #1A1A1A;
            width: 22px;
            border-radius: 3px;
        }

        .carousel-dot:hover {
            background: rgba(26, 26, 26, 0.3);
            transform: scale(1.3);
        }

        .carousel-dot.active:hover {
            transform: scale(1);
            background: #1A1A1A;
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

        @media (max-width: 640px) {
            .carousel-arrow { width: 32px; height: 32px; font-size: 13px; }
            .carousel-arrow.prev { left: 8px; }
            .carousel-arrow.next { right: 8px; }
            .carousel-nav { bottom: 14px; }
        }

        .carousel-counter {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 300;
            letter-spacing: 2.5px;
            color: rgba(26, 26, 26, 0.1);
            z-index: 5;
        }

        @media (max-width: 640px) {
            .carousel-counter { bottom: 52px; font-size: 8px; }
        }

        /* ===== БЕГУЩАЯ СТРОКА ===== */
        .marquee-section {
            background: #FFFFFF;
            overflow: hidden;
            position: relative;
            height: 60px;
            border-top: none !important;
            border-bottom: none !important;
        }

        /* ===== СТАТИСТИКА ===== */
        .stats-grid {
            position: relative;
            overflow: visible !important;
            border-top: none !important;
            border-bottom: none !important;
            background: #FFFFFF;
        }

        .stats-grid .border-r {
            border-color: rgba(26, 26, 26, 0.04) !important;
        }

        /* ===== СЕКЦИИ ===== */
        #why {
            background: #FFFFFF;
        }

        #products {
            background: #FFFFFF;
            border-top: none !important;
            border-bottom: none !important;
        }

        #products .grid {
            border-top: none !important;
        }

        #products .border-r,
        #products .border-b {
            border-color: rgba(26, 26, 26, 0.04) !important;
        }

        .cta-section {
            border-bottom: none !important;
            background: #FFFFFF;
        }

        #contacts {
            background: #FFFFFF;
        }

        .section-divider {
            height: 40px;
            background: linear-gradient(
                to bottom,
                #FFFFFF 0%,
                rgba(26, 26, 26, 0.01) 50%,
                #FFFFFF 100%
            );
            pointer-events: none;
        }

        [data-aos] {
            transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .marquee-char {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            font-size: 32px;
            color: rgb(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b));
            opacity: 0.15;
            letter-spacing: 6px;
            transition: color 1.5s cubic-bezier(0.4, 0, 0.2, 1),
            opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: color;
        }

        .marquee-separator {
            color: rgb(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b));
            opacity: 0.5;
            font-size: 20px;
            font-weight: 300;
            transition: color 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: color;
        }

        @media (prefers-reduced-motion: reduce) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .carousel-track { transition: none !important; }
            .carousel-slide:hover .product-card-visual img,
            .carousel-slide:hover .product-card-visual .fallback-emoji { transform: none !important; }
            .carousel-slide .product-card-visual img,
            .carousel-slide .product-card-visual .fallback-emoji,
            .carousel-slide .product-card-info {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .carousel-arrow:hover { transform: translateY(-50%) !important; }
            .hero-right-glow { display: none !important; }
            .hero-section::before,
            .hero-left::after { transition: none !important; }
            .hero-section { min-height: auto !important; max-height: none !important; }
            .hero-right { max-height: none !important; min-height: 500px !important; }
            .hanzi-decor { display: none !important; }
            .marquee-track { animation: none !important; }
            .marquee-char,
            .marquee-separator { transition: none !important; }
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FFFFFF; }
        ::-webkit-scrollbar-thumb { background: rgba(26, 26, 26, 0.12); border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(26, 26, 26, 0.2); }

        @keyframes marqueeScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-track {
            display: flex;
            align-items: center;
            white-space: nowrap;
            animation: marqueeScroll 30s linear infinite;
            will-change: transform;
        }

        .marquee-track:hover { animation-play-state: paused; }

        @media (prefers-reduced-motion: reduce) {
            .marquee-track { animation: none !important; }
        }

        .hero-left .flex {
            position: relative;
            z-index: 1;
        }

        .hero-left a {
            position: relative;
            z-index: 1;
        }

        .hero-right,
        .hero-left {
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .hero-section::before,
        .hero-left::after,
        .hero-right-glow {
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1),
            opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: background, opacity;
        }

        .hero-section::before {
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-left::after {
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hanzi-decor {
            transition: color 1.5s cubic-bezier(0.4, 0, 0.2, 1),
            opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: color;
        }

        .hanzi-decor,
        .marquee-char {
            font-family: 'Noto Serif SC', 'SimSun', serif;
        }

        #ammapContainer {
            width: 100%;
            height: 500px;
        }
        .am5-legend {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <!-- ===== HERO ===== -->
    <section class="hero-section">
        <!-- Левая колонка -->
        <div class="hero-left">
            <!-- B2B-бейдж -->
            <div class="hero-badge" data-aos="fade-up" data-aos-duration="600">
                <span class="hero-badge-dot"></span>
                Прямой импортёр №1 в РФ
            </div>

            <!-- Заголовок -->
            <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                Экспорт<br>
                <span class="hero-title-outline">Импорт</span><br>
                Инь Янь
            </h1>

            <!-- Описание -->
            <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">
                Оптовые поставки продуктов питания из Китая.<br>
                Прямой импорт без посредников. Работаем с 2013 года.
            </p>

            <!-- Минимальный заказ -->
            <div class="hero-min-order" data-aos="fade-up" data-aos-delay="150">
                <span class="min-order-label">Минимальный заказ</span>
                <span class="min-order-amount">100 000 ₽</span>
            </div>

            <!-- Преимущества -->
            <div class="hero-benefits" data-aos="fade-up" data-aos-delay="250">
                <span class="hero-benefit-item">Сертификаты ЕАС</span>
                <span class="hero-benefit-item">Честный знак</span>
                <span class="hero-benefit-item">Собственный склад</span>
                <span class="hero-benefit-item">Отгрузка за 24 ч</span>
                <span class="hero-benefit-item">Прямые контракты</span>
                <span class="hero-benefit-item">10+ лет на рынке</span>
            </div>

            <!-- Дополнительная информация -->
            <div class="hero-extra-info" data-aos="fade-up" data-aos-delay="200">
                <div class="hero-extra-item">
                    <span class="label">Склад в РФ</span>
                    <span class="value">г. Артём, Приморский край</span>
                </div>
                <div class="hero-extra-item">
                    <span class="label">Доставка</span>
                    <span class="value">По всей России</span>
                </div>
                <div class="hero-extra-item">
                    <span class="label">Ассортимент</span>
                    <span class="value">50+ позиций</span>
                </div>
                <div class="hero-extra-item">
                    <span class="label">Гарантия</span>
                    <span class="value">100% качество</span>
                </div>
            </div>

            <!-- Кнопки -->
            <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
                <a href="#contacts" class="btn-primary">Запросить прайс</a>
                <a href="#products" class="btn-ghost">Каталог</a>
            </div>

            <!-- Иероглифы -->
            <div class="absolute inset-0 pointer-events-none select-none overflow-visible z-0">
                <span class="hanzi-decor xl rotate-n8" style="bottom: 20px; right: 20px; opacity: 0.20;" data-aos="fade-up" data-aos-delay="400">和</span>
                <span class="hanzi-decor lg rotate-n10" style="top: 30px; left: 30px; opacity: 0.15;" data-aos="fade-down" data-aos-delay="200">福</span>
                <span class="hanzi-decor md rotate-10" style="top: 60px; right: 40px; opacity: 0.18;" data-aos="fade-down" data-aos-delay="300">龙</span>
                <span class="hanzi-decor lg rotate-12" style="bottom: 30%; right: 30px; opacity: 0.15;" data-aos="fade-left" data-aos-delay="350">宝</span>
                <span class="hanzi-decor md rotate-10" style="bottom: 60%; right: 25%; opacity: 0.18;" data-aos="fade-up" data-aos-delay="400">祥</span>
                <span class="hanzi-decor xl rotate-n5" style="top: 45%; left: 45%; opacity: 0.14;" data-aos="zoom-in" data-aos-delay="600">安</span>
            </div>
        </div>

        <!-- Правая колонка — карусель из БД -->
        <div class="hero-right" data-aos="fade-in" data-aos-delay="200" data-aos-duration="700">
            <div class="hero-right-glow visible" id="heroGlow"></div>
            <div class="carousel-container">
                <div class="carousel-track-wrapper">
                    <div class="carousel-track" id="carouselTrack">
                        @if($slides->count() > 0)
                            @foreach($slides as $index => $slide)
                                <div class="carousel-slide {{ $index === 0 ? 'active-slide' : '' }}"
                                     data-index="{{ $index }}"
                                     data-accent="{{ $slide['accent'] }}">
                                    <div class="product-card-visual">
                                        @if($slide['image'])
                                            <img src="{{ $slide['image'] }}"
                                                 alt="{{ $slide['name'] }}"
                                                 loading="lazy"
                                                 decoding="async"
                                                 width="400"
                                                 height="400">
                                        @else
                                            <span class="fallback-emoji">{{ $slide['emoji'] }}</span>
                                        @endif
                                    </div>

                                    <div class="product-card-info">
                                        <span class="product-card-tag">{{ $slide['tag'] }}</span>
                                        <div class="product-card-name">{{ $slide['name'] }}</div>
                                        <div class="product-card-desc">{{ Str::limit($slide['desc'], 90) }}</div>

                                        {{-- БЛОК ЦЕНЫ --}}
                                        <div class="product-card-price-wrap">
                                            <span class="product-card-price">{{ $slide['price'] }}</span>
                                            <span class="product-card-price-note">{{ $slide['price_note'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Запасной вариант, если товаров нет --}}
                            <div class="carousel-slide active-slide" data-index="0" data-accent="#FF6B00">
                                <div class="product-card-visual">
                                    <span class="fallback-emoji">📦</span>
                                </div>
                                <div class="product-card-info">
                                    <span class="product-card-tag">Скоро</span>
                                    <div class="product-card-name">Товары добавляются</div>
                                    <div class="product-card-desc">Следите за обновлениями каталога</div>
                                    <div class="product-card-price-wrap">
                                        <span class="product-card-price">скоро</span>
                                        <span class="product-card-price-note">ожидайте</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <button class="carousel-arrow prev" id="carouselPrev" aria-label="Предыдущий">←</button>
                <button class="carousel-arrow next" id="carouselNext" aria-label="Следующий">→</button>

                <div class="carousel-counter" id="carouselCounter">01 / {{ max($slides->count(), 1) }}</div>

                <div class="carousel-nav">
                    @for($i = 0; $i < max($slides->count(), 1); $i++)
                        <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}" aria-label="Слайд {{ $i + 1 }}"></button>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- ===== СТАТИСТИКА ===== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 stats-grid section-with-hanzi">
        @php
            $stats = [
                ['number' => '10 000+', 'label' => 'Тонн импортировано'],
                ['number' => '100+', 'label' => 'Активных клиентов'],
                ['number' => '98%', 'label' => 'Поставок вовремя'],
                ['number' => '10+', 'label' => 'Лет на рынке'],
            ];
        @endphp
        @foreach($stats as $index => $stat)
            <div class="px-6 py-8 lg:p-10 text-center border-r {{ $loop->last ? 'border-r-0' : '' }} {{ $loop->index === 1 ? 'max-lg:border-r-0' : '' }} transition-colors duration-300 hover:bg-black/5 stat-item" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}" data-target="{{ preg_replace('/[^0-9]/', '', $stat['number']) }}">
                <div class="font-black text-[32px] lg:text-[40px] text-[#1A1A1A] tracking-[-1px] leading-none stat-number">{{ $stat['number'] }}</div>
                <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-2">{{ $stat['label'] }}</div>
            </div>
        @endforeach
        <span class="hanzi-decor md rotate-10" style="top: 50%; left: 8%; transform: translateY(-50%) rotate(10deg); opacity: 0.015;">数</span>
        <span class="hanzi-decor md rotate-n8" style="top: 50%; right: 8%; transform: translateY(-50%) rotate(-8deg); opacity: 0.015;">据</span>
    </div>

    <!-- ===== БЕГУЩАЯ СТРОКА ===== -->
    <div class="marquee-section">
        <div class="absolute top-0 left-0 w-full h-full flex items-center overflow-hidden">
            <div class="marquee-track" id="marqueeTrack"></div>
        </div>
    </div>

    <!-- ===== КАРТА ПОСТАВОК ===== -->
    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] bg-white section-with-hanzi" id="map">
        <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">География</p>
        <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] mb-[48px] text-[#1A1A1A]" data-aos="fade-up" data-aos-delay="100">
            Маршруты поставок
        </h2>

        <div class="relative" data-aos="fade-up" data-aos-delay="200">
            <div class="relative w-full border border-[#1A1A1A]/8 overflow-hidden bg-[#FAFAFA]">
                <div id="ammapContainer"></div>

                <div class="absolute bottom-4 left-4 right-4 z-10 flex flex-wrap gap-3">
                    <div class="bg-white/90 backdrop-blur-sm border border-[#1A1A1A]/8 px-4 py-3 shadow-sm flex-1 min-w-[140px]">
                        <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/35 mb-1 font-medium">Прямые поставки</div>
                        <div class="font-bold text-xs text-[#1A1A1A]">Пекин, Шанхай, Гуанчжоу</div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-sm border border-[#1A1A1A]/8 px-4 py-3 shadow-sm flex-1 min-w-[140px]">
                        <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/35 mb-1 font-medium">Основной хаб</div>
                        <div class="font-bold text-xs text-[#1A1A1A]">Владивосток (г. Артём)</div>
                    </div>
                    <div class="bg-white/90 backdrop-blur-sm border border-[#1A1A1A]/8 px-4 py-3 shadow-sm flex-1 min-w-[140px]">
                        <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/35 mb-1 font-medium">География</div>
                        <div class="font-bold text-xs text-[#1A1A1A]">Вся Россия</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8 mt-8 text-center">
                <div>
                    <div class="font-black text-2xl text-[#1A1A1A]">3</div>
                    <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-1">Города в Китае</div>
                </div>
                <div>
                    <div class="font-black text-2xl text-[#1A1A1A]">14-21</div>
                    <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-1">Дней доставки</div>
                </div>
                <div>
                    <div class="font-black text-2xl text-[#1A1A1A]">50+</div>
                    <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-1">Городов в РФ</div>
                </div>
            </div>
        </div>

        <span class="hanzi-decor lg rotate-10" style="top: 5%; right: 3%; opacity: 0.015;">路</span>
        <span class="hanzi-decor md rotate-n8" style="bottom: 5%; left: 3%; opacity: 0.015;">线</span>
    </section>

    <!-- ===== ПОЧЕМУ МЫ ===== -->
    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] section-with-hanzi" id="why">
        <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">О нас</p>
        <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] mb-[48px] text-[#1A1A1A]" data-aos="fade-up" data-aos-delay="100">Партнёры доверяют нам</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-[1px] bg-transparent">
            @php
                $reasons = [
                    ['num' => '01', 'title' => 'Выгода', 'desc' => 'Прямой импорт без посредников. Никаких наценок в цепочке поставок.'],
                    ['num' => '02', 'title' => 'Надёжность', 'desc' => 'Декларации, ЕАС, Честный знак — всё оформлено под ключ.'],
                    ['num' => '03', 'title' => 'Оперативность', 'desc' => 'Собственный склад. Отгрузка на следующий день после оплаты.'],
                ];
            @endphp
            @foreach($reasons as $index => $reason)
                <div class="bg-white p-8 lg:p-10 transition-all duration-300 hover:bg-black/[0.02]" data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}">
                    <div class="font-black text-3xl text-[#1A1A1A]/5 leading-none mb-4">{{ $reason['num'] }}</div>
                    <div class="font-bold text-[10px] tracking-[3px] uppercase text-[#1A1A1A] mb-3">{{ $reason['title'] }}</div>
                    <p class="text-sm text-[#1A1A1A]/40 leading-relaxed font-light">{{ $reason['desc'] }}</p>
                </div>
            @endforeach
        </div>
        <span class="hanzi-decor lg rotate-n10" style="top: 10%; right: 3%; opacity: 0.015;">信</span>
        <span class="hanzi-decor md rotate-12" style="bottom: 10%; left: 3%; opacity: 0.015;">德</span>
        <span class="hanzi-decor sm rotate-n8" style="top: 30%; left: 8%; opacity: 0.01;">诚</span>
        <span class="hanzi-decor sm rotate-8" style="bottom: 30%; right: 8%; opacity: 0.01;">誉</span>
    </section>

    <!-- ===== КАТАЛОГ С КАРУСЕЛЬЮ ИЗ БД ===== -->
    <section class="bg-white py-[60px] lg:py-[80px] section-with-hanzi" id="products">
        <div class="px-6 md:px-12 lg:px-16 pb-8">
            <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">Ассортимент</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] text-[#1A1A1A]" data-aos="fade-up" data-aos-delay="100">Наша продукция</h2>
        </div>

        <!-- Карусель товаров -->
        <div class="px-6 md:px-12 lg:px-16 relative" data-aos="fade-up" data-aos-delay="200">
            <div class="overflow-hidden">
                <div class="carousel-track-products flex gap-5 transition-transform duration-500 ease-out" id="carouselTrackProducts">
                    @foreach($slides as $slide)
                        <div class="carousel-slide-product w-[280px] md:w-[320px] lg:w-[350px] flex-shrink-0 bg-[#F8F8F8] rounded-xl p-5 border border-[#1A1A1A]/6 hover:border-[#1A1A1A]/20 transition-all duration-300 hover:shadow-md">
                            <div class="aspect-square bg-white rounded-lg mb-3 overflow-hidden flex items-center justify-center relative">
                                @if($slide['image'])
                                    <img src="{{ $slide['image'] }}" alt="{{ $slide['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-5xl opacity-30">{{ $slide['emoji'] }}</span>
                                @endif
                                <span class="absolute top-2 right-2 bg-[#1A1A1A] text-white text-[8px] font-semibold tracking-[1px] px-2.5 py-1 rounded-full">{{ $slide['price'] }}</span>
                            </div>
                            <div>
                                <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/40 mb-1">{{ $slide['tag'] }}</div>
                                <h3 class="font-bold text-[13px] leading-tight text-[#1A1A1A] line-clamp-2">{{ $slide['name'] }}</h3>
                                <p class="text-[10px] text-[#1A1A1A]/50 leading-relaxed line-clamp-2 mt-1">{{ Str::limit($slide['desc'], 70) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Стрелки -->
            <button id="carouselProductsPrev" class="absolute left-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white shadow border border-[#1A1A1A]/10 hover:border-[#1A1A1A]/30 flex items-center justify-center transition-all hover:scale-110 z-10 -ml-3">
                <svg class="w-3.5 h-3.5 text-[#1A1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button id="carouselProductsNext" class="absolute right-0 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white shadow border border-[#1A1A1A]/10 hover:border-[#1A1A1A]/30 flex items-center justify-center transition-all hover:scale-110 z-10 -mr-3">
                <svg class="w-3.5 h-3.5 text-[#1A1A1A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <!-- Точки -->
            <div class="flex justify-center gap-1.5 mt-5" id="carouselProductsDots">
                @foreach($slides as $index => $slide)
                    <button class="carousel-product-dot w-1.5 h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-[#1A1A1A] w-5' : 'bg-[#1A1A1A]/30 hover:bg-[#1A1A1A]/50' }}" data-index="{{ $index }}"></button>
                @endforeach
            </div>
        </div>

        <!-- Кнопка -->
        <div class="px-6 md:px-12 lg:px-16 pt-8 text-center" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('catalog') }}" class="inline-block px-6 py-2.5 bg-[#1A1A1A] text-white text-[9px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02]">Полный каталог</a>
        </div>

        <!-- Иероглифы -->
        <span class="hanzi-decor lg rotate-10" style="top: 5%; left: 2%; opacity: 0.015;">品</span>
        <span class="hanzi-decor md rotate-n12" style="bottom: 5%; right: 2%; opacity: 0.015;">类</span>
        <span class="hanzi-decor sm rotate-8" style="top: 20%; right: 5%; opacity: 0.01;">丰</span>
        <span class="hanzi-decor xs rotate-n8" style="bottom: 15%; left: 5%; opacity: 0.01;">富</span>
    </section>

    <!-- ===== CTA ===== -->
    <div class="px-6 md:px-12 lg:px-16 py-14 lg:py-16 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 cta-section section-with-hanzi">
        <h2 class="font-black text-[clamp(24px,2.8vw,38px)] uppercase tracking-[-1px] leading-none text-[#1A1A1A]" data-aos="fade-right">Готовы начать<br><span class="text-[#1A1A1A]/40">сотрудничество?</span></h2>
        <a href="#contacts" class="inline-block px-8 py-3 bg-[#1A1A1A] text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02] flex-shrink-0" data-aos="fade-left" data-aos-delay="150">Связаться</a>
        <span class="hanzi-decor sm rotate-10" style="top: 10%; right: 30%; opacity: 0.015;">赢</span>
        <span class="hanzi-decor xs rotate-n5" style="bottom: 10%; left: 10%; opacity: 0.01;">合</span>
        <span class="hanzi-decor xs rotate-8" style="bottom: 10%; right: 25%; opacity: 0.01;">作</span>
    </div>

    <!-- ===== КОНТАКТЫ ===== -->
    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] section-with-hanzi" id="contacts">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            <div>
                <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">Контакты</p>
                <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[500px] mb-10 text-[#1A1A1A]" data-aos="fade-up" data-aos-delay="100">Свяжитесь с нами</h2>
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
                        <div class="text-[9px] tracking-[3px] uppercase text-[#1A1A1A]/40 mb-1">{{ $contact['label'] }}</div>
                        @if($contact['type'] === 'tel' || $contact['type'] === 'email')
                            <a href="{{ $contact['href'] }}" class="font-semibold text-[16px] text-[#1A1A1A] no-underline transition-colors duration-300 hover:text-[#1A1A1A]/60">{{ $contact['value'] }}</a>
                        @else
                            <span class="font-semibold text-[16px] text-[#1A1A1A]">{{ $contact['value'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div data-aos="fade-up" data-aos-delay="300">
                <div class="border border-[#1A1A1A]/10 p-6 bg-white">
                    <div class="text-[12px] text-[#1A1A1A]/50 space-y-3">
                        <div><strong class="text-[#1A1A1A]/60 block text-[9px] tracking-[2px] uppercase mb-0.5 font-medium">Организация</strong>ООО «Экспорт-Импорт Инь-Ян»</div>
                        <div><strong class="text-[#1A1A1A]/60 block text-[9px] tracking-[2px] uppercase mb-0.5 font-medium">ОГРН</strong>1232500004846</div>
                        <div><strong class="text-[#1A1A1A]/60 block text-[9px] tracking-[2px] uppercase mb-0.5 font-medium">ИНН / КПП</strong>2502071087 / 250201001</div>
                    </div>
                </div>
                <div class="mt-4 p-6 border border-[#1A1A1A]/10 border-t-0 bg-white">
                    <p class="text-[12px] text-[#1A1A1A]/40 leading-relaxed font-light">Стабильные поставки, конкурентные цены и широкий ассортимент продуктов из Китая.</p>
                </div>
            </div>
        </div>
        <span class="hanzi-decor lg rotate-n8" style="top: 5%; right: 5%; opacity: 0.015;">联</span>
        <span class="hanzi-decor md rotate-10" style="bottom: 5%; left: 5%; opacity: 0.015;">系</span>
        <span class="hanzi-decor sm rotate-n12" style="top: 40%; left: 2%; opacity: 0.01;">友</span>
        <span class="hanzi-decor sm rotate-8" style="bottom: 40%; right: 2%; opacity: 0.01;">好</span>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        // ===== ИНИЦИАЛИЗАЦИЯ AOS =====
        AOS.init({
            duration: 600,
            once: true,
            offset: 30,
            easing: 'ease-out'
        });

        // ===== ГЛОБАЛЬНЫЕ ПЕРЕМЕННЫЕ ДЛЯ БЕГУЩЕЙ СТРОКИ =====
        const marqueeChars = ['信', '誉', '第', '一', '品', '质', '为', '本', '诚', '信', '合', '作', '共', '赢', '未', '来', '中', '俄', '贸', '易', '直', '接', '进', '口'];

        function updateMarqueeColors() {
            const track = document.getElementById('marqueeTrack');
            if (!track) return;

            let html = '';
            html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
            marqueeChars.forEach((char, i) => {
                if (i > 0 && i % 4 === 0) {
                    html += `<span class="marquee-separator">|</span>`;
                }
                html += `<span class="marquee-char">${char}</span>`;
            });
            html += '</span>';

            html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
            marqueeChars.forEach((char, i) => {
                if (i > 0 && i % 4 === 0) {
                    html += `<span class="marquee-separator">|</span>`;
                }
                html += `<span class="marquee-char">${char}</span>`;
            });
            html += '</span>';

            track.innerHTML = html;
        }

        updateMarqueeColors();

        // ===== ИНИЦИАЛИЗАЦИЯ КАРТЫ =====
        const mapContainer = document.getElementById('map');
        if (mapContainer) {
            const mapObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        am5.ready(function() {
                            var root = am5.Root.new("ammapContainer");

                            root.setThemes([
                                am5themes_Animated.new(root)
                            ]);

                            var chart = root.container.children.push(
                                am5map.MapChart.new(root, {
                                    panX: "none",
                                    panY: "none",
                                    projection: am5map.geoMercator(),
                                    minZoomLevel: 2,
                                    maxZoomLevel: 2,
                                    wheelable: false,
                                    pinchZoom: false
                                })
                            );

                            // Создаем серию полигонов (страны)
                            var polygonSeries = chart.series.push(
                                am5map.MapPolygonSeries.new(root, {
                                    geoJSON: am5geodata_worldLow,
                                    exclude: ["AQ"]
                                })
                            );

                            polygonSeries.mapPolygons.template.setAll({
                                fill: am5.color(0xf5f5f5),
                                stroke: am5.color(0xffffff),
                                strokeWidth: 0.5,
                                tooltipText: "{name}"
                            });

                            // Подсветка России и Китая
                            polygonSeries.mapPolygons.template.adapters.add("fill", function(fill, target) {
                                if (target.dataItem.get("id") === "RU") {
                                    return am5.color(0xeeeeee);
                                }
                                if (target.dataItem.get("id") === "CN") {
                                    return am5.color(0xe8e8e8);
                                }
                                return fill;
                            });

                            // Добавляем точки (города)
                            var pointSeries = chart.series.push(
                                am5map.MapPointSeries.new(root, {})
                            );

                            // Города Китая
                            var beijing = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [116.4074, 39.9042] },
                                name: "Пекин",
                                type: "china"
                            });

                            var shanghai = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [121.4737, 31.2304] },
                                name: "Шанхай",
                                type: "china"
                            });

                            var guangzhou = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [113.2644, 23.1291] },
                                name: "Гуанчжоу",
                                type: "china"
                            });

                            // Хаб во Владивостоке
                            var vladivostok = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [131.8856, 43.1056] },
                                name: "Владивосток (Артём)",
                                type: "hub"
                            });

                            // Города России
                            var moscow = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [37.6173, 55.7558] },
                                name: "Москва",
                                type: "russia"
                            });

                            var spb = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [30.3141, 59.9386] },
                                name: "Санкт-Петербург",
                                type: "russia"
                            });

                            var novosibirsk = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [82.9346, 55.0084] },
                                name: "Новосибирск",
                                type: "russia"
                            });

                            var ekaterinburg = pointSeries.pushDataItem({
                                geometry: { type: "Point", coordinates: [60.6122, 56.8389] },
                                name: "Екатеринбург",
                                type: "russia"
                            });

                            // Стили для точек с подписями
                            pointSeries.bullets.push(function(root, series, dataItem) {
                                if (!dataItem || !dataItem.dataContext) {
                                    return am5.Bullet.new(root, {
                                        sprite: am5.Circle.new(root, {
                                            radius: 5,
                                            fill: am5.color(0x1A1A1A),
                                            stroke: am5.color(0xffffff),
                                            strokeWidth: 2
                                        })
                                    });
                                }

                                var type = dataItem.dataContext.type;
                                var radius = (type === "hub") ? 8 : 5;
                                var strokeWidth = (type === "hub") ? 3 : 2;

                                var container = am5.Container.new(root, {});

                                var circle = am5.Circle.new(root, {
                                    radius: radius,
                                    fill: am5.color(0x1A1A1A),
                                    stroke: am5.color(0xffffff),
                                    strokeWidth: strokeWidth,
                                    tooltipText: "{name}"
                                });

                                var label = am5.Label.new(root, {
                                    text: "{name}",
                                    fontSize: 12,
                                    fontWeight: "bold",
                                    fill: am5.color(0x000000),
                                    centerX: am5.p100,
                                    centerY: am5.p0,
                                    dx: 12,
                                    dy: -8,
                                    visible: true,
                                    forceHidden: false
                                });

                                container.children.push(circle);
                                container.children.push(label);

                                return am5.Bullet.new(root, {
                                    sprite: container
                                });
                            });

                            // Добавляем линии маршрутов
                            var lineSeries = chart.series.push(
                                am5map.MapLineSeries.new(root, {})
                            );

                            // Линии из Китая во Владивосток (импорт)
                            var chinaCities = [beijing, shanghai, guangzhou];

                            chinaCities.forEach(function(city) {
                                lineSeries.pushDataItem({
                                    pointsToConnect: [city, vladivostok],
                                    stroke: am5.color(0x1A1A1A),
                                    strokeWidth: 1.5,
                                    strokeDasharray: [8, 4],
                                    strokeOpacity: 0.4
                                });
                            });

                            // Линии из Владивостока в города России (доставка)
                            var russiaCities = [moscow, spb, novosibirsk, ekaterinburg];

                            russiaCities.forEach(function(city) {
                                lineSeries.pushDataItem({
                                    pointsToConnect: [vladivostok, city],
                                    stroke: am5.color(0x1A1A1A),
                                    strokeWidth: 1,
                                    strokeDasharray: [4, 4],
                                    strokeOpacity: 0.2
                                });
                            });

                            // Анимация появления линий
                            lineSeries.mapLines.template.setAll({
                                animationDuration: 2000,
                                animationEasing: am5.ease.out(am5.ease.cubic)
                            });

                            // ВАЖНО: Устанавливаем зум ПОСЛЕ создания всех слоёв
                            setTimeout(function() {
                                chart.zoomToGeoPoint(
                                    { longitude: 90, latitude: 55 },  // Центр между РФ и КНР
                                    3.5,  // Уровень зума
                                    false,  // Без анимации
                                    0  // Мгновенно
                                );
                            }, 300);  // Небольшая задержка для гарантии загрузки

                        });
                        mapObserver.disconnect();
                    }
                });
            });
            mapObserver.observe(mapContainer);
        }

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

        // ===== КАРУСЕЛЬ НА HERO С ПЛАВНЫМИ ПЕРЕХОДАМИ =====
        (function() {
            const track = document.getElementById('carouselTrack');
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            const prevBtn = document.getElementById('carouselPrev');
            const nextBtn = document.getElementById('carouselNext');
            const glow = document.getElementById('heroGlow');
            const counter = document.getElementById('carouselCounter');
            const root = document.documentElement;

            if (!track || !slides.length) return;

            let currentIndex = 0;
            const totalSlides = slides.length;
            let autoPlayInterval;
            let isInteracting = false;
            let isTransitioning = false;

            function updateAccentColor(index) {
                const slide = slides[index];
                if (!slide) return;

                const accent = slide.dataset.accent || '#FF6B00';
                const hex = accent.replace('#', '');
                const r = parseInt(hex.substring(0, 2), 16);
                const g = parseInt(hex.substring(2, 4), 16);
                const b = parseInt(hex.substring(4, 6), 16);

                requestAnimationFrame(() => {
                    root.style.setProperty('--carousel-accent-r', r);
                    root.style.setProperty('--carousel-accent-g', g);
                    root.style.setProperty('--carousel-accent-b', b);

                    if (glow) {
                        glow.style.background = `radial-gradient(circle, rgba(${r}, ${g}, ${b}, 0.3) 0%, transparent 70%)`;
                    }

                    document.querySelectorAll('.hanzi-decor').forEach(el => {
                        el.style.color = `rgb(${r}, ${g}, ${b})`;
                    });

                    document.querySelectorAll('.marquee-char').forEach(el => {
                        el.style.color = `rgb(${r}, ${g}, ${b})`;
                    });

                    document.querySelectorAll('.marquee-separator').forEach(el => {
                        el.style.color = `rgb(${r}, ${g}, ${b})`;
                    });
                });
            }

            function updateGlow(index) {
                if (!glow) return;
                glow.style.opacity = '0';
                setTimeout(() => {
                    glow.style.transition = 'opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    glow.style.opacity = '0.3';
                    glow.classList.add('visible');
                }, 500);
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

                requestAnimationFrame(() => {
                    track.style.transform = `translateX(-${currentIndex * 100}%)`;
                });

                slides.forEach((slide, i) => {
                    slide.classList.toggle('active-slide', i === currentIndex);
                });

                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === currentIndex);
                });

                updateAccentColor(currentIndex);
                updateGlow(currentIndex);
                updateCounter(currentIndex);

                setTimeout(() => {
                    isTransitioning = false;
                }, 800);
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
                }, 6000);
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

        // ===== КАРУСЕЛЬ ТОВАРОВ В СЕКЦИИ ПРОДУКТОВ =====
        window.addEventListener('load', function() {
            const track = document.getElementById('carouselTrackProducts');
            const slides = document.querySelectorAll('.carousel-slide-product');
            const dots = document.querySelectorAll('.carousel-product-dot');
            const prevBtn = document.getElementById('carouselProductsPrev');
            const nextBtn = document.getElementById('carouselProductsNext');

            if (!track || !slides.length) {
                console.error('❌ Карусель товаров: элементы не найдены');
                return;
            }

            console.log('✅ Карусель товаров: найдено', slides.length, 'слайдов, ширина:', slides[0].offsetWidth);

            let currentIndex = 0;
            let autoPlayInterval;
            let isInteracting = false;
            let isTransitioning = false;

            function getGap() {
                return 20; // gap-5 = 20px
            }

            function getMaxIndex() {
                const containerWidth = track.parentElement.offsetWidth;
                const slideWidth = slides[0].offsetWidth;
                const gap = getGap();
                const visibleSlides = Math.floor((containerWidth + gap) / (slideWidth + gap));
                return Math.max(0, slides.length - visibleSlides);
            }

            function updateCarousel() {
                if (currentIndex > getMaxIndex()) {
                    currentIndex = getMaxIndex();
                }

                const slideWidth = slides[0].offsetWidth;
                const gap = getGap();
                const offset = currentIndex * (slideWidth + gap);

                track.style.transform = `translateX(-${offset}px)`;

                dots.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.classList.add('bg-[#1A1A1A]', 'w-5');
                        dot.classList.remove('bg-[#1A1A1A]/30', 'w-1.5');
                    } else {
                        dot.classList.remove('bg-[#1A1A1A]', 'w-5');
                        dot.classList.add('bg-[#1A1A1A]/30', 'w-1.5');
                    }
                });
            }

            function goTo(index) {
                if (isTransitioning) return;

                const newIndex = Math.max(0, Math.min(index, getMaxIndex()));
                if (newIndex === currentIndex) return;

                isTransitioning = true;
                currentIndex = newIndex;
                updateCarousel();

                setTimeout(() => {
                    isTransitioning = false;
                }, 500);
            }

            function nextSlide() {
                if (currentIndex < getMaxIndex()) {
                    goTo(currentIndex + 1);
                } else {
                    goTo(0);
                }
            }

            function prevSlide() {
                if (currentIndex > 0) {
                    goTo(currentIndex - 1);
                } else {
                    goTo(getMaxIndex());
                }
            }

            function startAutoPlay() {
                stopAutoPlay();
                autoPlayInterval = setInterval(() => {
                    if (!isInteracting && !isTransitioning) {
                        nextSlide();
                    }
                }, 4000);
            }

            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            // Обработчики событий
            prevBtn?.addEventListener('click', () => {
                prevSlide();
                stopAutoPlay();
                startAutoPlay();
            });

            nextBtn?.addEventListener('click', () => {
                nextSlide();
                stopAutoPlay();
                startAutoPlay();
            });

            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    if (index !== currentIndex && !isTransitioning) {
                        goTo(index);
                        stopAutoPlay();
                        startAutoPlay();
                    }
                });
            });

            // Пауза при наведении
            const container = track.closest('.relative');
            container?.addEventListener('mouseenter', () => {
                isInteracting = true;
            });
            container?.addEventListener('mouseleave', () => {
                isInteracting = false;
            });

            // Ресайз
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    updateCarousel();
                }, 150);
            });

            // Запуск
            updateCarousel();
            startAutoPlay();
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
