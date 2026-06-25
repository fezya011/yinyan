{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Дашборд')
@section('page-title', 'Дашборд')
@section('sub-title', 'обзор')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
    <style>
        :root {
            /* Цвет по умолчанию для иероглифов в админке (можно синхронизировать с главной) */
            --admin-accent-r: 26;
            --admin-accent-g: 26;
            --admin-accent-b: 26;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ ===== */
        .hanzi-decor {
            position: fixed;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: rgb(var(--admin-accent-r), var(--admin-accent-g), var(--admin-accent-b));
            line-height: 1;
            z-index: 0;
            transition: opacity 1.2s ease;
        }
        .hanzi-decor.xl { font-size: 140px; }
        .hanzi-decor.lg { font-size: 100px; }
        .hanzi-decor.md { font-size: 70px; }
        .hanzi-decor.sm { font-size: 45px; }
        .hanzi-decor.xs { font-size: 28px; }
        .hanzi-decor.rotate-10 { transform: rotate(10deg); }
        .hanzi-decor.rotate-n8 { transform: rotate(-8deg); }

        /* Переопределяем прозрачность для админки */
        .hanzi-decor { opacity: 0.04 !important; }

        @media (max-width: 768px) {
            .hanzi-decor.xl { font-size: 100px; opacity: 0.03 !important; }
            .hanzi-decor.lg { font-size: 70px; opacity: 0.025 !important; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.02 !important; }
            .hanzi-decor.sm { font-size: 35px; opacity: 0.015 !important; }
            .hanzi-decor.xs { font-size: 22px; opacity: 0.01 !important; }
        }

        /* ===== КАРТОЧКИ СТАТИСТИКИ ===== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(26, 26, 26, 0.04);
            position: relative;
            z-index: 1;
        }

        @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .stat-grid { grid-template-columns: 1fr; } }

        .stat-card {
            position: relative;
            padding: 28px 24px;
            background: #FFFFFF;
            border: none;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #1A1A1A;
            overflow: hidden;
            min-height: 140px;
            transition: background 0.35s ease;
        }

        .stat-card:hover {
            background: #FAFAFA;
        }

        .stat-card .stat-index {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 48px;
            color: rgba(26, 26, 26, 0.03);
            line-height: 1;
            position: absolute;
            top: 12px;
            right: 16px;
            transition: color 0.35s ease;
        }

        .stat-card:hover .stat-index {
            color: rgba(26, 26, 26, 0.06);
        }

        .stat-card .stat-value {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 38px;
            letter-spacing: -1.5px;
            line-height: 1;
            color: #1A1A1A;
            margin-bottom: 6px;
        }

        .stat-card .stat-label {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 9px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.35);
            margin-top: auto;
        }

        /* ===== БЫСТРЫЕ ДЕЙСТВИЯ ===== */
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(26, 26, 26, 0.04);
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) { .actions-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .actions-grid { grid-template-columns: 1fr; } }

        .action-card {
            display: flex;
            flex-direction: column;
            padding: 24px;
            background: #FFFFFF;
            text-decoration: none;
            color: #1A1A1A;
            transition: background 0.35s ease;
            position: relative;
            overflow: hidden;
        }

        .action-card:hover {
            background: #FAFAFA;
        }

        .action-card .action-index {
            position: absolute;
            top: 8px;
            right: 14px;
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 48px;
            color: rgba(26, 26, 26, 0.02);
            line-height: 1;
            pointer-events: none;
            transition: color 0.35s ease;
        }

        .action-card:hover .action-index {
            color: rgba(26, 26, 26, 0.06);
        }

        .action-card .action-title {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: -0.2px;
            color: #1A1A1A;
            margin-bottom: 4px;
        }

        .action-card .action-desc {
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 11px;
            color: rgba(26, 26, 26, 0.4);
            line-height: 1.4;
        }

        /* ===== ТАБЛИЦЫ ===== */
        .table-container {
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.06);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            border-bottom: 1px solid rgba(26, 26, 26, 0.06);
            background: #FFFFFF;
        }

        .table-header .title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1A1A1A;
        }

        .table-header .actions a {
            font-family: 'Inter', sans-serif;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.4);
            text-decoration: none;
            margin-left: 18px;
            transition: all 0.3s ease;
            padding-bottom: 2px;
            border-bottom: 1px solid transparent;
        }

        .table-header .actions a:hover {
            color: #1A1A1A;
            border-bottom-color: #1A1A1A;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            text-align: left;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(26, 26, 26, 0.04);
            background: #FAFAFA;
        }

        td {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(26, 26, 26, 0.03);
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #1A1A1A;
            font-weight: 500;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(26, 26, 26, 0.01);
        }

        .text-muted {
            color: rgba(26, 26, 26, 0.4) !important;
            font-weight: 400 !important;
        }

        /* ===== СТАТУСЫ ===== */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 0;
            color: #1A1A1A;
        }

        .status-badge .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #1A1A1A;
        }

        .status-badge.new .dot { background: #1A1A1A; }
        .status-badge.processing .dot { background: #555555; }
        .status-badge.completed .dot, .status-badge.won .dot { background: #1A1A1A; }
        .status-badge.cancelled .dot, .status-badge.lost .dot { background: #AAAAAA; }

        /* ===== МИНИ-СТАТИСТИКА ===== */
        .mini-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(26, 26, 26, 0.04);
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) { .mini-stat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .mini-stat-grid { grid-template-columns: 1fr; } }

        .mini-stat {
            padding: 20px;
            background: #FFFFFF;
            text-align: center;
            transition: background 0.3s ease;
        }

        .mini-stat:hover {
            background: #FAFAFA;
        }

        .mini-stat .value {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            font-size: 24px;
            letter-spacing: -0.5px;
            color: #1A1A1A;
        }

        .mini-stat .label {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.35);
            margin-top: 4px;
        }

        /* ===== ПУСТЫЕ СОСТОЯНИЯ ===== */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: rgba(26, 26, 26, 0.15);
        }

        .empty-state .empty-icon {
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 8px;
            opacity: 0.3;
        }

        .empty-state .empty-text {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        @media (prefers-reduced-motion: reduce) {
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .hanzi-decor { display: none !important; }
        }
    </style>

    <div class="content-wrapper">
        {{-- ===== СТАТИСТИКА ===== --}}
        <div class="stat-grid mb-8">
            <a href="{{ route('admin.products.index') }}" class="stat-card" data-aos="fade-up" data-aos-delay="0">
                <span class="stat-index">01</span>
                <div class="stat-value">{{ $stats['total_products'] }}</div>
                <div class="stat-label">Всего товаров</div>
            </a>

            <a href="{{ route('admin.products.index', ['status' => 'active']) }}" class="stat-card" data-aos="fade-up" data-aos-delay="50">
                <span class="stat-index">02</span>
                <div class="stat-value">{{ $stats['active_products'] }}</div>
                <div class="stat-label">Активных товаров</div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <span class="stat-index">03</span>
                <div class="stat-value">{{ $stats['total_categories'] }}</div>
                <div class="stat-label">Категорий</div>
            </a>

            <a href="{{ route('admin.leads.index', ['status' => 'new']) }}" class="stat-card" data-aos="fade-up" data-aos-delay="150">
                <span class="stat-index">04</span>
                <div class="stat-value">{{ $stats['new_leads'] }}</div>
                <div class="stat-label">Новых заявок</div>
            </a>
        </div>

        {{-- ===== БЫСТРЫЕ ДЕЙСТВИЯ ===== --}}
        <div class="actions-grid mb-8">
            <a href="{{ route('admin.products.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="0">
                <span class="action-index">+</span>
                <span class="action-title">Добавить товар</span>
                <span class="action-desc">Новая позиция в каталог</span>
            </a>

            <a href="{{ route('admin.categories.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="50">
                <span class="action-index">+</span>
                <span class="action-title">Добавить категорию</span>
                <span class="action-desc">Структурировать каталог</span>
            </a>

            <a href="{{ route('admin.leads.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="100">
                <span class="action-index">→</span>
                <span class="action-title">Все заявки</span>
                <span class="action-desc">Просмотр и обработка</span>
            </a>

            <a href="{{ route('admin.leads.export') }}" class="action-card" data-aos="fade-up" data-aos-delay="150">
                <span class="action-index">↓</span>
                <span class="action-title">Экспорт заявок</span>
                <span class="action-desc">Выгрузить в CSV</span>
            </a>
        </div>

        {{-- ===== ПОСЛЕДНИЕ ЗАЯВКИ И ТОВАРЫ ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8" data-aos="fade-up" data-aos-delay="200">
            {{-- Заявки --}}
            <div class="table-container">
                <div class="table-header">
                    <span class="title">Последние заявки</span>
                    <div class="actions">
                        <a href="{{ route('admin.leads.index') }}">Все</a>
                        <a href="{{ route('admin.leads.export') }}">CSV</a>
                    </div>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Клиент</th>
                        <th>Товар</th>
                        <th>Статус</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recentLeads as $lead)
                        <tr>
                            <td>
                                <a href="{{ route('admin.leads.show', $lead) }}" style="color: #1A1A1A; text-decoration: none; font-weight: 600; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.6'" onmouseout="this.style.opacity='1'">
                                    {{ $lead->name }}
                                </a>
                            </td>
                            <td class="text-muted">{{ $lead->product?->name ?? 'Не указан' }}</td>
                            <td>
                                <span class="status-badge {{ $lead->status }}">
                                    <span class="dot"></span>
                                    {{ \App\Models\Lead::getStatuses()[$lead->status] ?? $lead->status }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $lead->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">空</div>
                                    <span class="empty-text">Нет заявок</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Товары --}}
            <div class="table-container">
                <div class="table-header">
                    <span class="title">Популярные товары</span>
                    <div class="actions">
                        <a href="{{ route('admin.products.index') }}">Все</a>
                        <a href="{{ route('admin.products.create') }}">Добавить</a>
                    </div>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Категория</th>
                        <th style="text-align: center;">Заказов</th>
                        <th>Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($topProducts as $product)
                        <tr>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" style="color: #1A1A1A; text-decoration: none; font-weight: 600; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.6'" onmouseout="this.style.opacity='1'">
                                    {{ Str::limit($product->name, 30) }}
                                </a>
                            </td>
                            <td class="text-muted">{{ $product->category?->name ?? '—' }}</td>
                            <td style="text-align: center; font-weight: 700; color: #1A1A1A;">{{ $product->orders_count }}</td>
                            <td>
                                <span class="status-badge {{ $product->status }}">
                                    <span class="dot"></span>
                                    {{ match($product->status) { 'active' => 'Активен', 'inactive' => 'Неактивен', 'out_of_stock' => 'Нет в наличии', default => $product->status } }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">无</div>
                                    <span class="empty-text">Нет товаров</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== ДОПОЛНИТЕЛЬНАЯ СТАТИСТИКА ===== --}}
        <div class="mini-stat-grid" data-aos="fade-up" data-aos-delay="250">
            <div class="mini-stat">
                <div class="value">{{ $stats['active_leads'] }}</div>
                <div class="label">Активных заявок</div>
            </div>
            <div class="mini-stat">
                <div class="value">{{ $stats['won_leads'] }}</div>
                <div class="label">Выигранных</div>
            </div>
            <div class="mini-stat">
                <div class="value">{{ $stats['today_leads'] }}</div>
                <div class="label">За сегодня</div>
            </div>
            <div class="mini-stat">
                <div class="value">{{ $stats['this_month_leads'] }}</div>
                <div class="label">За месяц</div>
            </div>
        </div>
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor lg rotate-10" style="bottom: 3%; right: 2%;">统</span>
    <span class="hanzi-decor md rotate-n8" style="top: 8%; left: 1%;">计</span>
    <span class="hanzi-decor sm rotate-10" style="top: 20%; right: 3%;">管</span>
    <span class="hanzi-decor sm rotate-n5" style="bottom: 15%; left: 2%;">理</span>
    <span class="hanzi-decor xs rotate-8" style="top: 60%; right: 1%;">财</span>
    <span class="hanzi-decor xs rotate-n12" style="bottom: 25%; left: 1%;">务</span>

    @push('scripts')
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 600,
                once: true,
                offset: 20,
                easing: 'ease-out'
            });
        </script>
    @endpush
@endsection
