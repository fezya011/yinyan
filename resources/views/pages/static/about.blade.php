@extends('layouts.app')

@section('title', 'О компании – Инь Ян Экспорт и импорт из Китая')

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

        .page-wrapper {
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

        /* ===== HERO СТРАНИЦЫ ===== */
        .about-hero {
            padding: 40px 0 60px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: relative;
            overflow: hidden;
        }

        .about-hero h1 {
            font-weight: 900;
            font-size: clamp(36px, 5vw, 56px);
            letter-spacing: -2px;
            text-transform: uppercase;
            color: #000;
            line-height: 1.05;
            max-width: 700px;
        }

        .about-hero .subtitle {
            font-size: 15px;
            color: rgba(0,0,0,0.45);
            margin-top: 16px;
            max-width: 520px;
            line-height: 1.6;
        }

        /* ===== СЕКЦИЯ МИССИЯ ===== */
        .mission-section {
            padding: 60px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: relative;
            overflow: visible !important;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .mission-text .label {
            font-size: 9px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(0,0,0,0.25);
            font-weight: 500;
            display: block;
            margin-bottom: 12px;
        }

        .mission-text h2 {
            font-weight: 800;
            font-size: clamp(24px, 2.8vw, 36px);
            letter-spacing: -0.5px;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .mission-text p {
            font-size: 14px;
            color: rgba(0,0,0,0.45);
            line-height: 1.7;
            margin-bottom: 16px;
        }

        .mission-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .mission-stat-item .number {
            font-weight: 800;
            font-size: 32px;
            color: #000;
            letter-spacing: -1px;
            display: block;
        }

        .mission-stat-item .label {
            font-size: 10px;
            color: rgba(0,0,0,0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== ИСТОРИЯ ===== */
        .history-section {
            padding: 60px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: relative;
            overflow: visible !important;
        }

        .history-timeline {
            display: flex;
            flex-direction: column;
            gap: 32px;
            margin-top: 32px;
        }

        .history-item {
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 32px;
            padding: 20px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-item:hover {
            padding-left: 12px;
            background: rgba(0,0,0,0.01);
            border-radius: 4px;
        }

        .history-year {
            font-weight: 800;
            font-size: 28px;
            color: #000;
            letter-spacing: -1px;
            line-height: 1;
        }

        .history-content h3 {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .history-content p {
            font-size: 13px;
            color: rgba(0,0,0,0.4);
            line-height: 1.5;
        }

        /* ===== ЦЕННОСТИ ===== */
        .values-section {
            padding: 60px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: relative;
            overflow: visible !important;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2px;
            background: rgba(0,0,0,0.04);
            margin-top: 32px;
        }

        .value-card {
            background: #FFFFFF;
            padding: 32px 24px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .value-card:hover {
            background: rgba(0,0,0,0.02);
            transform: translateY(-4px);
        }

        .value-card .icon {
            font-size: 28px;
            display: block;
            margin-bottom: 12px;
        }

        .value-card .title {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .value-card .desc {
            font-size: 12px;
            color: rgba(0,0,0,0.35);
            line-height: 1.5;
        }

        /* ===== КОМАНДА ===== */
        .team-section {
            padding: 60px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            position: relative;
            overflow: visible !important;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
            background: rgba(0,0,0,0.04);
            margin-top: 32px;
        }

        .team-card {
            background: #FFFFFF;
            padding: 32px 24px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .team-card:hover {
            background: rgba(0,0,0,0.02);
            transform: translateY(-2px);
        }

        .team-card .avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: #F5F5F5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 28px;
            font-weight: 300;
            color: rgba(0,0,0,0.2);
        }

        .team-card .name {
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 2px;
        }

        .team-card .position {
            font-size: 11px;
            color: rgba(0,0,0,0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ===== СЕРТИФИКАТЫ ===== */
        .certificates-section {
            padding: 60px 0;
            border-bottom: 1px solid rgba(0,0,0,0.04);
        }

        .cert-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 32px;
        }

        .cert-item {
            border: 1px solid rgba(0,0,0,0.06);
            padding: 24px 16px;
            text-align: center;
            transition: all 0.3s ease;
            background: #FFFFFF;
            border-radius: 4px;
        }

        .cert-item:hover {
            border-color: rgba(0,0,0,0.12);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        }

        .cert-item .icon {
            font-size: 32px;
            display: block;
            margin-bottom: 8px;
        }

        .cert-item .name {
            font-weight: 600;
            font-size: 12px;
        }

        .cert-item .desc {
            font-size: 10px;
            color: rgba(0,0,0,0.3);
            margin-top: 4px;
        }

        /* ===== CTA ===== */
        .cta-section {
            padding: 60px 0;
        }

        .cta-box {
            background: #F8F8F8;
            padding: 48px 56px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 24px;
            border-radius: 4px;
        }

        .cta-box h2 {
            font-weight: 800;
            font-size: clamp(22px, 2.5vw, 32px);
            letter-spacing: -0.5px;
        }

        .cta-box p {
            color: rgba(0,0,0,0.4);
            font-size: 14px;
            margin-top: 4px;
        }

        .btn-primary {
            display: inline-block;
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
            flex-shrink: 0;
        }

        .btn-primary:hover {
            background: #000000;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        /* ===== ИЕРОГЛИФЫ ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: rgb(var(--accent-r), var(--accent-g), var(--accent-b));
            line-height: 1;
            z-index: 0;
            transition: color 0.6s ease, opacity 0.6s ease;
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

        @media (max-width: 768px) {
            .hanzi-decor.xl { font-size: 100px; opacity: 0.12 !important; }
            .hanzi-decor.lg { font-size: 70px; opacity: 0.10 !important; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.08 !important; }
            .hanzi-decor.sm { font-size: 35px; opacity: 0.06 !important; }
            .hanzi-decor.xs { font-size: 22px; opacity: 0.05 !important; }

            .mission-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .values-grid {
                grid-template-columns: 1fr 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr 1fr;
            }

            .cert-grid {
                grid-template-columns: 1fr 1fr;
            }

            .history-item {
                grid-template-columns: 1fr;
                gap: 4px;
            }

            .cta-box {
                padding: 32px 24px;
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .values-grid {
                grid-template-columns: 1fr;
            }

            .team-grid {
                grid-template-columns: 1fr;
            }

            .cert-grid {
                grid-template-columns: 1fr;
            }

            .mission-stats {
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .mission-stat-item .number {
                font-size: 24px;
            }
        }

        /* ===== AOS ===== */
        [data-aos] {
            transition-timing-function: cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        @media (prefers-reduced-motion: reduce) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .value-card:hover,
            .team-card:hover,
            .cert-item:hover,
            .history-item:hover {
                transform: none !important;
            }
            .hanzi-decor {
                display: none !important;
            }
        }

        /* ===== СКРОЛЛБАР ===== */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FFFFFF; }
        ::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #D1D5DB; }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <!-- ===== ХЛЕБНЫЕ КРОШКИ ===== -->
        <div class="px-6 md:px-12 lg:px-16">
            <div class="breadcrumbs" data-aos="fade-up">
                <a href="/">Главная</a>
                <span class="separator">/</span>
                <span class="current">О компании</span>
            </div>
        </div>

        <!-- ===== HERO ===== -->
        <section class="about-hero px-6 md:px-12 lg:px-16 section-with-hanzi">
            <h1 data-aos="fade-up" data-aos-delay="100">
                О компании<br>
                <span style="color: rgba(0,0,0,0.15);">Инь Ян</span>
            </h1>
            <p class="subtitle" data-aos="fade-up" data-aos-delay="200">
                Мы — надёжный партнёр по импорту продуктов питания из Китая.
                Прямые контракты, собственный склад, полное юридическое сопровождение.
            </p>

            <span class="hanzi-decor xl rotate-10" style="top: 0; right: 0; opacity: 0.06;">信</span>
            <span class="hanzi-decor lg rotate-n8" style="bottom: 10%; left: 5%; opacity: 0.05;">诚</span>
        </section>

        <!-- ===== МИССИЯ И ЦИФРЫ ===== -->
        <section class="mission-section px-6 md:px-12 lg:px-16 section-with-hanzi">
            <div class="mission-grid">
                <div class="mission-text" data-aos="fade-up" data-aos-delay="100">
                    <span class="label">Миссия</span>
                    <h2>Соединяем Россию и Китай<br>через качественные продукты</h2>
                    <p>
                        Мы создаём надёжный мост между производителями в Китае и российскими
                        предпринимателями. Наша цель — сделать импорт продуктов питания простым,
                        прозрачным и выгодным для каждого партнёра.
                    </p>
                    <p>
                        За 10 лет работы мы построили систему, где каждый клиент получает
                        стабильные поставки, полный пакет документов и персональное сопровождение.
                    </p>
                </div>
                <div class="mission-stats" data-aos="fade-up" data-aos-delay="200">
                    <div class="mission-stat-item">
                        <span class="number">10+</span>
                        <span class="label">Лет на рынке</span>
                    </div>
                    <div class="mission-stat-item">
                        <span class="number">10 000+</span>
                        <span class="label">Тонн импортировано</span>
                    </div>
                    <div class="mission-stat-item">
                        <span class="number">100+</span>
                        <span class="label">Постоянных клиентов</span>
                    </div>
                    <div class="mission-stat-item">
                        <span class="number">98%</span>
                        <span class="label">Поставок вовремя</span>
                    </div>
                </div>
            </div>

            <span class="hanzi-decor md rotate-12" style="top: 10%; right: 5%; opacity: 0.04;">德</span>
            <span class="hanzi-decor sm rotate-n10" style="bottom: 10%; right: 8%; opacity: 0.03;">信</span>
        </section>

        <!-- ===== ИСТОРИЯ ===== -->
        <section class="history-section px-6 md:px-12 lg:px-16 section-with-hanzi">
            <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">История</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
                Как мы росли
            </h2>

            <div class="history-timeline">
                @php
                    $history = [
                        [
                            'year' => '2014',
                            'title' => 'Основание компании',
                            'desc' => 'Инь Ян начинает свою деятельность как небольшой импортёр продуктов питания из Китая.'
                        ],
                        [
                            'year' => '2016',
                            'title' => 'Расширение ассортимента',
                            'desc' => 'Первые прямые контракты с крупными фабриками. Запуск поставок лапши и вонтонов.'
                        ],
                        [
                            'year' => '2018',
                            'title' => 'Собственный склад',
                            'desc' => 'Открытие склада в Артёме. Поставки по Дальнему Востоку и в центральную Россию.'
                        ],
                        [
                            'year' => '2020',
                            'title' => 'Сертификация',
                            'desc' => 'Получение всех необходимых сертификатов ЕАС, внедрение системы Честный знак.'
                        ],
                        [
                            'year' => '2023',
                            'title' => 'Новые горизонты',
                            'desc' => 'Запуск собственной линии продуктов. Рост клиентской базы до 100+ постоянных партнёров.'
                        ]
                    ];
                @endphp

                @foreach($history as $index => $item)
                    <div class="history-item" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 50 }}">
                        <div class="history-year">{{ $item['year'] }}</div>
                        <div class="history-content">
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <span class="hanzi-decor lg rotate-n10" style="top: 0; right: 3%; opacity: 0.04;">史</span>
            <span class="hanzi-decor md rotate-8" style="bottom: 5%; left: 3%; opacity: 0.03;">历</span>
        </section>

        <!-- ===== ЦЕННОСТИ ===== -->
        <section class="values-section px-6 md:px-12 lg:px-16 section-with-hanzi">
            <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">Ценности</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
                Наши принципы
            </h2>

            <div class="values-grid">
                @php
                    $values = [
                        ['icon' => '🤝', 'title' => 'Честность', 'desc' => 'Прозрачные условия, без скрытых комиссий и наценок.'],
                        ['icon' => '⚡', 'title' => 'Скорость', 'desc' => 'Отгрузка на следующий день. Собственный склад.'],
                        ['icon' => '📋', 'title' => 'Юридическая чистота', 'desc' => 'Все документы, сертификаты, ЕАС и Честный знак.'],
                        ['icon' => '🌟', 'title' => 'Качество', 'desc' => 'Только проверенные производители и контроль каждой партии.'],
                    ];
                @endphp

                @foreach($values as $index => $value)
                    <div class="value-card" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 80 }}">
                        <span class="icon">{{ $value['icon'] }}</span>
                        <div class="title">{{ $value['title'] }}</div>
                        <div class="desc">{{ $value['desc'] }}</div>
                    </div>
                @endforeach
            </div>

            <span class="hanzi-decor md rotate-10" style="top: 10%; left: 2%; opacity: 0.03;">义</span>
            <span class="hanzi-decor sm rotate-n8" style="bottom: 10%; right: 5%; opacity: 0.03;">礼</span>
        </section>

        <!-- ===== КОМАНДА ===== -->
        <section class="team-section px-6 md:px-12 lg:px-16 section-with-hanzi">
            <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">Команда</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
                Люди, которым<br>доверяют
            </h2>

            <div class="team-grid">
                @php
                    $team = [
                        ['name' => 'Алексей Ерышев', 'position' => 'Коммерческий директор', 'emoji' => '👔'],
                        ['name' => 'Мария Соколова', 'position' => 'Руководитель отдела закупок', 'emoji' => '📋'],
                        ['name' => 'Сергей Иванов', 'position' => 'Логист, складской комплекс', 'emoji' => '🚚'],
                    ];
                @endphp

                @foreach($team as $index => $member)
                    <div class="team-card" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}">
                        <div class="avatar">{{ $member['emoji'] }}</div>
                        <div class="name">{{ $member['name'] }}</div>
                        <div class="position">{{ $member['position'] }}</div>
                    </div>
                @endforeach
            </div>

            <span class="hanzi-decor lg rotate-10" style="top: 0; right: 2%; opacity: 0.04;">人</span>
            <span class="hanzi-decor md rotate-n12" style="bottom: 5%; left: 3%; opacity: 0.03;">才</span>
        </section>

        <!-- ===== СЕРТИФИКАТЫ ===== -->
        <section class="certificates-section px-6 md:px-12 lg:px-16">
            <p class="text-[9px] tracking-[4px] uppercase text-black/30 mb-3" data-aos="fade-up">Сертификаты</p>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
                Работаем по закону
            </h2>

            <div class="cert-grid">
                @php
                    $certs = [
                        ['icon' => '📜', 'name' => 'Декларации ЕАС', 'desc' => 'Все продукты сертифицированы'],
                        ['icon' => '✅', 'name' => 'Честный знак', 'desc' => 'Маркировка под ключ'],
                        ['icon' => '🏢', 'name' => 'ОГРН', 'desc' => '1232500004846'],
                        ['icon' => '📄', 'name' => 'ИНН', 'desc' => '2502071087 / 250201001'],
                    ];
                @endphp

                @foreach($certs as $index => $cert)
                    <div class="cert-item" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 80 }}">
                        <span class="icon">{{ $cert['icon'] }}</span>
                        <div class="name">{{ $cert['name'] }}</div>
                        <div class="desc">{{ $cert['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- ===== CTA ===== -->
        <section class="cta-section px-6 md:px-12 lg:px-16">
            <div class="cta-box" data-aos="fade-up">
                <div>
                    <h2>Готовы к сотрудничеству?</h2>
                    <p>Запросите коммерческое предложение с актуальными ценами</p>
                </div>
                <a href="/#contacts" class="btn-primary">Связаться с нами</a>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 600,
            once: true,
            offset: 30,
            easing: 'ease-out'
        });

        // ===== ПЛАВНЫЙ СКРОЛЛ =====
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                }
            });
        });
    </script>
@endpush
