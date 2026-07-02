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
            transition: color 1.2s cubic-bezier(0.4, 0, 0.2, 1) !important;,
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
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
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
            transition: background 1.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
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

        /* ===== ИСПРАВЛЕННЫЙ GLOW ===== */
        .hero-right-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            height: 70%;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            z-index: 0;

            /* Начальное состояние: прозрачный */
            opacity: 0;

            /* Анимируем opacity и background-color (если бы он был сплошным),
               но для градиента нам поможет хак ниже */
            transition: opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1);

            /* Используем переменную для цвета, чтобы CSS мог отслеживать изменения */
            background: radial-gradient(
                circle,
                rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.3) 0%,
                transparent 70%
            );

            /* ВАЖНО: Добавляем transition для background, хотя он работает плохо,
               но с will-change браузер постарается */
            will-change: opacity, background;
        }

        .hero-right-glow.visible {
            opacity: 0.3; /* Или 1, если хочешь, чтобы прозрачность контролировалась внутри градиента */
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
            padding-top: 50px;
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
            .product-card-visual img { max-height: 60vh; }
        }

        @media (max-width: 640px) {
            .carousel-slide .product-card-visual img {
                max-height: 100vh !important;   /* было 60vh (или 55vh по умолчанию) – увеличиваем */
            }

            /* Если используется эмодзи-заглушка – тоже увеличиваем */
            .carousel-slide .product-card-visual .fallback-emoji {
                font-size: 22vw !important;    /* было 16vw – делаем крупнее */
            }

            /* Уменьшаем отступы вокруг картинки, чтобы она занимала больше места */
            .carousel-slide {
                padding: 12px 16px 60px !important;  /* уменьшаем боковые и верхние отступы */
            }

            /* Если нужно – можно немного уменьшить нижнюю навигацию, чтобы не перекрывала */
            .carousel-nav {
                bottom: 12px !important;
            }
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

        .cta-section {
            border-bottom: none !important;
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
            font-size: 60px;
            color: rgb(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b));
            opacity: 0.15;
            letter-spacing: 6px;
            transition: color 1.5s cubic-bezier(0.4, 0, 0.2, 1) !important;,
            opacity 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: color;
        }

        .marquee-separator {
            color: rgb(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b));
            opacity: 0.5;
            font-size: 29px;
            font-weight: 300;
            transition: color 1.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
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
        /* ===== УВЕЛИЧЕНИЕ ШРИФТОВ В КАРУСЕЛИ ===== */
        .carousel-slide .product-card-name {
            font-size: 26px !important;   /* было 20px */
        }

        .carousel-slide .product-card-desc {
            font-size: 14px !important;   /* было 12px */
            max-width: 340px;             /* чуть шире для длинных названий */
        }

        .carousel-slide .product-card-price {
            font-size: 16px !important;   /* было 13px */
        }

        .carousel-slide .product-card-tag {
            font-size: 9px !important;    /* было 8px */
            letter-spacing: 2.5px;
        }

        /* Адаптив для мобильных */
        @media (max-width: 640px) {
            .carousel-slide .product-card-name {
                font-size: 22px !important;
            }
            .carousel-slide .product-card-desc {
                font-size: 13px !important;
            }
            .carousel-slide .product-card-price {
                font-size: 15px !important;
            }
        }

        /* ===== СЕКЦИЯ ПОПУЛЯРНЫХ ТОВАРОВ (как в каталоге, но компактнее) ===== */

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(26, 26, 26, 0.04);
        }

        .product-card {
            background: #FFFFFF;
            padding: 24px 28px 28px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(26, 26, 26, 0.06);
            z-index: 10;
        }

        /* ------ ИЗОБРАЖЕНИЕ (УМЕНЬШЕННОЕ) ------ */
        .product-card .image-wrap {
            width: 100%;
            height: 250px;              /* было 240px – сделал компактнее */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            background: #ffffff;
            overflow: hidden;
            position: relative;
        }
        .product-card .image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;        /* вписывается без искажений */
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            padding: 20px;              /* отступы внутри рамки */
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

        /* ------ БЕЙДЖ (тег) ------ */
        .product-card .badge {
            position: absolute;
            top: 14px;
            right: 14px;
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 12px;
            font-weight: 600;
            background: #1A1A1A;
            color: #FFFFFF;
            z-index: 2;
        }

        /* ------ КОНТЕНТ КАРТОЧКИ ------ */
        .product-card .card-content {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .product-card .category-tag {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.25);
            margin-bottom: 8px;
            font-weight: 600;
        }
        .product-card .product-name {
            font-weight: 700;
            font-size: 21px;
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
            margin-bottom: 16px;
            font-weight: 400;
        }

        /* ------ МЕТА-ДАННЫЕ (десктоп) ------ */
        .product-card .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 16px;
            margin-bottom: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(26, 26, 26, 0.04);
        }
        .product-card .product-meta .meta-item {
            font-size: 12px;
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

        /* ------ МЕТА-ДАННЫЕ (мобильная, скрыта на десктопе) ------ */
        .product-card .product-meta-mobile {
            display: none;
        }

        /* ------ ФУТЕР С ЦЕНОЙ ------ */
        .product-card .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }
        .product-card .price {
            font-weight: 700;
            font-size: 23px;
            color: #1A1A1A;
            letter-spacing: -0.5px;
        }
        .product-card .price .from {
            font-weight: 400;
            font-size: 11px;
            color: rgba(26, 26, 26, 0.3);
            margin-right: 2px;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 1024px) {
            .catalog-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 768px) {
            .catalog-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                background: none;
                padding: 0;
            }
            .product-card {
                padding: 16px 14px 20px;
                border: 1px solid rgba(26, 26, 26, 0.05);
            }
            .product-card:hover {
                transform: none;
                box-shadow: 0 6px 20px rgba(26, 26, 26, 0.05);
                border-color: rgba(26, 26, 26, 0.1);
            }
            .product-card .image-wrap {
                height: 160px;          /* ещё меньше на мобилках */
                margin-bottom: 14px;
            }
            .product-card .image-wrap img {
                padding: 14px;
            }
            .product-card .badge {
                top: 8px;
                right: 8px;
                font-size: 7px;
                letter-spacing: 1.5px;
                padding: 4px 9px;
            }
            .product-card .category-tag {
                font-size: 8px;
                letter-spacing: 2px;
                margin-bottom: 5px;
            }
            .product-card .product-name {
                font-size: 15px;
                margin-bottom: 5px;
                line-height: 1.25;
            }
            .product-card .product-desc {
                font-size: 11px;
                line-height: 1.5;
                margin-bottom: 10px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .product-card .product-meta {
                display: none;          /* скрываем десктопную мету */
            }
            .product-card .product-meta-mobile {
                display: flex;
                flex-wrap: wrap;
                gap: 4px 10px;
                margin-bottom: 10px;
            }
            .product-card .product-meta-mobile .meta-item {
                font-size: 10px;
                color: rgba(26, 26, 26, 0.4);
                font-weight: 450;
            }
            .product-card .product-footer {
                margin-top: auto;
            }
            .product-card .price {
                font-size: 17px;
            }
            .product-card .price .from {
                font-size: 10px;
            }
        }
        @media (max-width: 480px) {
            .catalog-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .product-card {
                padding: 14px 12px 18px;
            }
            .product-card .image-wrap {
                height: 140px;
                margin-bottom: 12px;
            }
            .product-card .image-wrap img {
                padding: 12px;
            }
            .product-card .badge {
                top: 6px;
                right: 6px;
                font-size: 6px;
                letter-spacing: 1px;
                padding: 3px 7px;
            }
            .product-card .product-name {
                font-size: 14px;
                margin-bottom: 4px;
            }
            .product-card .product-desc {
                font-size: 10px;
                -webkit-line-clamp: 2;
                margin-bottom: 8px;
            }
            .product-card .category-tag {
                font-size: 7px;
                letter-spacing: 1.5px;
                margin-bottom: 4px;
            }
            .product-card .product-meta-mobile {
                gap: 3px 8px;
                margin-bottom: 8px;
            }
            .product-card .product-meta-mobile .meta-item {
                font-size: 9px;
            }
            .product-card .price {
                font-size: 16px;
            }
        }
        /* ===== КОМПАКТНАЯ СЕКЦИЯ ПОПУЛЯРНЫХ ТОВАРОВ (ЧУТЬ БОЛЬШЕ ШРИФТ) ===== */

        /* Паддинги карточек */
        .compact-card {
            padding: 16px 18px 18px !important;
        }

        /* Изображение */
        .compact-image {
            height: 180px !important;
            margin-bottom: 14px !important;
        }
        .compact-image img {
            padding: 14px !important;
        }

        /* Бейдж */
        .compact-badge {
            top: 10px !important;
            right: 10px !important;
            font-size: 8px !important;   /* было 7px */
            padding: 4px 10px !important;
        }

        /* Контент */
        .compact-content .category-tag {
            margin-bottom: 4px !important;
            font-size: 10px !important;  /* было 9px */
        }
        .compact-content .product-name {
            font-size: 19px !important;  /* было 17px */
            margin-bottom: 4px !important;
        }
        .compact-content .product-desc {
            font-size: 14px !important;  /* было 12px */
            margin-bottom: 10px !important;
            -webkit-line-clamp: 2 !important;
        }

        /* Мета */
        .compact-meta {
            padding-top: 10px !important;
            margin-bottom: 10px !important;
            gap: 4px 12px !important;
        }
        .compact-meta .meta-item {
            font-size: 10px !important;
            /* было 9px */
        }

        /* Цена */
        .compact-price {
            font-size: 20px !important;  /* было 18px */
        }
        .compact-price .from {
            font-size: 11px !important;  /* было 10px */
        }

        /* Сетка */
        .compact-grid {
            gap: 1px !important;
        }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 768px) {
            .compact-image {
                height: 150px !important;
            }
            .compact-content .product-name {
                font-size: 17px !important;  /* было 15px */
            }
            .compact-content .product-desc {
                font-size: 13px !important;  /* было 11px */
            }
            .compact-price {
                font-size: 18px !important;  /* было 16px */
            }
        }

        @media (max-width: 480px) {
            .compact-image {
                height: 130px !important;
            }
            .compact-card {
                padding: 12px 12px 14px !important;
            }
            .compact-content .product-name {
                font-size: 15px !important;  /* было 13px */
            }
            .compact-content .product-desc {
                font-size: 12px !important;  /* было 10px */
            }
            .compact-price {
                font-size: 16px !important;  /* было 15px */
            }
        }
        @media (max-width: 768px) {
            .section-with-hanzi .hanzi-decor {
                z-index: -1;
                opacity: 0.03;
            }
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
                Инь-Ян
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

    <span class="hanzi-decor md rotate-12" style="top: 30%; left: 20%; opacity: 0.02;">统</span>
    <span class="hanzi-decor md rotate-n10" style="top: 30%; right: 20%; opacity: 0.02;">计</span>

    <!-- ===== СТАТИСТИКА ===== -->
    <div class="grid grid-cols-2 lg:grid-cols-4 stats-grid section-with-hanzi pb-10">
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
    </div>

    <!-- ===== БЕГУЩАЯ СТРОКА ===== -->
    <div class="marquee-section">
        <div class="absolute top-0 left-0 w-full h-full flex items-center overflow-hidden">
            <div class="marquee-track" id="marqueeTrack"></div>
        </div>
    </div>

    {{-- ===== ПОПУЛЯРНЫЕ ТОВАРЫ (КОМПАКТНАЯ ВЕРСИЯ) ===== --}}
    <section class="px-4 md:px-12 lg:px-16 py-12 lg:py-16 relative section-with-hanzi" id="products">
        {{-- Заголовок --}}
        <div class="mb-8 relative z-10" data-aos="fade-up">
            <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3">Ассортимент</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] text-[#1A1A1A]">
                Популярные позиции
            </h2>
        </div>

        @if($popularProducts->isNotEmpty())
            <div class="catalog-grid compact-grid" data-aos="fade-up">
                @foreach($popularProducts as $product)
                    <a href="{{ route('product', $product->slug) }}" class="product-card compact-card">
                        {{-- Изображение --}}
                        <div class="image-wrap compact-image">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <span class="no-image">Нет фото</span>
                            @endif
                            @if($product->tag)
                                <span class="badge compact-badge">{{ $product->tag }}</span>
                            @endif
                        </div>

                        {{-- Контент --}}
                        <div class="card-content compact-content">
                            <div class="category-tag">{{ $product->category?->name ?? 'Без категории' }}</div>
                            <div class="product-name compact-name">{{ $product->name }}</div>
                            <div class="product-desc compact-desc">{{ Str::limit($product->card_subtitle ?? $product->description ?? '', 70) }}</div>

                            {{-- Десктопная мета --}}
                            <div class="product-meta compact-meta">
                            <span class="meta-item">
                                <strong>Мин. заказ:</strong> {{ number_format($product->min_order_amount ?? 100000, 0, '.', ' ') }} ₽
                            </span>
                                @if($product->weight_grams)
                                    <span class="meta-item">
                                    <strong>Вес:</strong> {{ $product->weight_grams }} г
                                </span>
                                @endif
                                @if($product->shelf_life_days)
                                    <span class="meta-item">
                                    <strong>Срок:</strong> {{ $product->shelf_life_days }} дн.
                                </span>
                                @endif
                                @if($product->pieces_per_box)
                                    <span class="meta-item">
                                    <strong>В коробке:</strong> {{ $product->pieces_per_box }} шт.
                                </span>
                                @endif
                            </div>

                            {{-- Мобильная мета --}}
                            <div class="product-meta-mobile">
                                @if($product->weight_grams)
                                    <span class="meta-item">{{ $product->weight_grams }} г</span>
                                @endif
                                @if($product->pieces_per_box)
                                    <span class="meta-item">{{ $product->pieces_per_box }} шт/кор</span>
                                @endif
                                @if($product->shelf_life_days)
                                    <span class="meta-item">{{ $product->shelf_life_days }} дн.</span>
                                @endif
                            </div>

                            {{-- Футер с ценой --}}
                            <div class="product-footer compact-footer">
                            <span class="price compact-price">
                                <span class="from">от</span>
                                {{ number_format($product->wholesale_price ?? 0, 0, '.', ' ') }} ₽
                            </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Кнопка --}}
            <div class="text-center mt-8 relative z-10" data-aos="fade-up" data-aos-delay="150">
                <a href="{{ route('catalog') }}"
                   class="btn-catalog inline-block px-8 py-3 bg-[#1A1A1A] text-white text-[10px] font-semibold tracking-[2px] uppercase transition-transform duration-300 hover:scale-[1.02] active:scale-[0.98] no-underline">
                    Перейти в каталог
                </a>
            </div>
        @else
            <p class="text-center text-gray-400 text-sm relative z-10 py-10">Товары скоро появятся</p>
        @endif

        {{-- Иероглифы --}}
        <span class="hanzi-decor xl rotate-n8" style="bottom: 6%; left: 0%; opacity: 0.2;">品</span>
        <span class="hanzi-decor xl rotate-12" style="top: 9%; right: 1%; opacity: 0.2;">味</span>
    </section>

    <!-- ===== КАРТА ПОСТАВОК ===== -->
    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] bg-white section-with-hanzi" id="map"
             style="border-top: 1px solid rgba(26,26,26,0.04);">
        <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">География</p>
        <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] mb-[48px] text-[#1A1A1A]" data-aos="fade-up" data-aos-delay="100">
            Маршруты поставок
        </h2>

        <div class="relative" data-aos="fade-up" data-aos-delay="200">
            <div class="relative w-full border border-[#1A1A1A]/8 overflow-hidden bg-[#FAFAFA]">
                <span class="hanzi-decor lg rotate-5" style="top: 15%; right: 15%; opacity: 0.02;">通</span>
                <span class="hanzi-decor md rotate-n12" style="bottom: 25%; left: 15%; opacity: 0.02;">达</span>
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
    </section>

    <section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] section-with-hanzi" id="why">
        <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">О нас</p>
        <div class="flex items-center gap-4 mb-[48px]" data-aos="fade-up" data-aos-delay="100">
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight text-[#1A1A1A]">
                Партнёры доверяют нам
            </h2>
            <span class="hidden md:block flex-1 h-[1px] bg-[#1A1A1A]/10"></span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $reasons = [
                    [
                        'num' => '01',
                        'title' => 'Выгода',
                        'desc' => 'Прямой импорт без посредников. Никаких наценок в цепочке поставок.',
                    ],
                    [
                        'num' => '02',
                        'title' => 'Надёжность',
                        'desc' => 'Декларации, ЕАС, Честный знак — всё оформлено под ключ.',
                    ],
                    [
                        'num' => '03',
                        'title' => 'Оперативность',
                        'desc' => 'Собственный склад. Отгрузка на следующий день после оплаты.',
                    ],
                ];
            @endphp

            @foreach($reasons as $index => $reason)
                <div class="group relative bg-white p-8 lg:p-10 border border-[#1A1A1A]/5 transition-all duration-300 hover:border-[#1A1A1A]/20 hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1"
                     data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}">
                    <!-- Крупная цифра в круге -->
                    <div class="flex items-center justify-center w-14 h-14 rounded-full border border-[#1A1A1A]/10 text-[#1A1A1A] font-black text-2xl mb-6 transition-colors duration-300 group-hover:border-[#1A1A1A]/30 group-hover:bg-[#1A1A1A]/5">
                        {{ $reason['num'] }}
                    </div>

                    <div class="font-bold text-[11px] tracking-[3px] uppercase text-[#1A1A1A] mb-3">
                        {{ $reason['title'] }}
                    </div>
                    <p class="text-[15px] text-[#1A1A1A]/50 leading-relaxed font-light">
                        {{ $reason['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </section>

    <!-- ===== CTA ===== -->
    <div class="px-6 md:px-12 lg:px-16 py-14 lg:py-16 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 cta-section section-with-hanzi">
        <h2 class="font-black text-[clamp(24px,2.8vw,38px)] uppercase tracking-[-1px] leading-none text-[#1A1A1A]" data-aos="fade-right">Готовы начать<br><span class="text-[#1A1A1A]/40">сотрудничество?</span></h2>

        <a href="#" data-lead-modal class="inline-block px-8 py-3 bg-[#1A1A1A] text-white text-[10px] font-semibold tracking-[2px] uppercase transition-all duration-300 hover:bg-black/80 hover:scale-[1.02] flex-shrink-0" data-aos="fade-left" data-aos-delay="150">Связаться</a>
    </div>
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

                // 1. Обновляем глобальные переменные для других элементов
                root.style.setProperty('--carousel-accent-r', r);
                root.style.setProperty('--carousel-accent-g', g);
                root.style.setProperty('--carousel-accent-b', b);

                // 2. ПЛАВНОЕ ОБНОВЛЕНИЕ GLOW
                // Вместо прямой замены background, мы полагаемся на то,
                // что CSS уже использует эти переменные в градиенте.
                // НО! Браузеры плохо анимируют градиенты при смене переменных.

                // ХАК ДЛЯ ПЛАВНОСТИ:
                // Мы создадим временный элемент или используем requestAnimationFrame,
                // но проще всего заставить браузер "перерисовать" градиент плавно,
                // если мы не меняем структуру градиента, а только цвета.

                // В современных браузерах (Chrome 111+, Safari 16.4+) transition для background
                // работает при смене CSS variables, если свойство transition указано явно.

                // Если у тебя старый браузер или дергается, используй этот fallback:
                if (glow) {
                    // Принудительно запускаем reflow, чтобы transition подхватился (иногда помогает)
                    // Но главное - убедиться, что мы не удаляем класс visible

                    // Просто обновляем переменные. CSS transition: background должен сработать
                    // благодаря will-change и явному указанию в CSS выше.

                    // Дополнительная страховка: если не работает, можно анимировать opacity:
                    glow.style.opacity = '0';
                    setTimeout(() => {
                         glow.style.background = `radial-gradient(circle, rgba(${r}, ${g}, ${b}, 0.3) 0%, transparent 70%)`;
                         glow.style.opacity = '0.3';
                     }, 50);
                }

                // Прямое изменение цвета для иероглифов и бегущей строки
                document.querySelectorAll('.hanzi-decor, .marquee-char, .marquee-separator').forEach(el => {
                    el.style.color = `rgb(${r}, ${g}, ${b})`;
                });
            }

            function updateGlow(index) {
                if (!glow) return;
                if (!glow.classList.contains('visible')) {
                    glow.classList.add('visible');
                }
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
