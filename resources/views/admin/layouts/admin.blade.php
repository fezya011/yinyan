{{-- resources/views/admin/layouts/admin.blade.php --}}
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Админ-панель') — Инь Ян</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;700;900&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; max-width: 100%; overflow-x: hidden; }

        body {
            font-family: 'Inter', sans-serif;
            background: #FFFFFF;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        :root {
            --brand: #1A1A1A;
            --surface: #FFFFFF;
            --surface-alt: #FAFAFA;
            --border: rgba(26, 26, 26, 0.06);
            --text-primary: #1A1A1A;
            --text-secondary: #777777;
            --text-muted: #999999;
            --accent: #B8860B;
            --accent-subtle: rgba(184, 134, 11, 0.08);
        }

        /* ===== ИЕРОГЛИФЫ ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: #1A1A1A;
            line-height: 1;
            z-index: 0;
            opacity: 0.015;
        }
        .hanzi-decor.xl { font-size: 120px; }
        .hanzi-decor.lg { font-size: 80px; }
        .hanzi-decor.md { font-size: 56px; }
        .hanzi-decor.sm { font-size: 36px; }
        .hanzi-decor.rotate-8 { transform: rotate(8deg); }
        .hanzi-decor.rotate-10 { transform: rotate(10deg); }
        .hanzi-decor.rotate-n5 { transform: rotate(-5deg); }
        .hanzi-decor.rotate-n8 { transform: rotate(-8deg); }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background: #0D0D0D;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 50;
            transition: transform 0.3s ease;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.04);
        }
        .admin-sidebar::-webkit-scrollbar { width: 3px; }
        .admin-sidebar::-webkit-scrollbar-track { background: #1A1A1A; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: #444; border-radius: 2px; }

        /* ===== ЛОГОТИП ===== */
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 4px;
        }
        .sidebar-brand a {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
        }
        .sidebar-brand .logo-img {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            object-fit: contain;
            flex-shrink: 0;
            background: #FFFFFF;
            padding: 4px;
        }
        .sidebar-brand .brand-text {
            color: #FFFFFF;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }
        .sidebar-brand .brand-sub {
            color: #666;
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            font-weight: 500;
            display: block;
            margin-top: 2px;
        }

        /* ===== НАВИГАЦИЯ ===== */
        .sidebar-nav { padding: 12px 12px 20px; }
        .sidebar-nav .nav-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #444;
            padding: 20px 12px 10px;
            font-weight: 600;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #888;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 2px;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.03); color: #CCC; }
        .sidebar-link.active { background: rgba(255,255,255,0.05); color: #FFF; font-weight: 600; }
        .sidebar-link .icon { width: 20px; text-align: center; font-size: 14px; flex-shrink: 0; opacity: 0.5; }
        .sidebar-link.active .icon { opacity: 0.9; }
        .sidebar-link:hover .icon { opacity: 0.7; }
        .sidebar-link .badge {
            margin-left: auto;
            background: #1A1A1A;
            color: #888;
            font-size: 9px;
            padding: 2px 9px;
            border-radius: 100px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .sidebar-link .badge-new { background: #1A1A1A; color: #CC5555; }
        .sidebar-link.logout-link { color: #666; margin-top: 8px; }
        .sidebar-link.logout-link:hover { color: #CC5555; background: rgba(204,85,85,0.06); }

        /* ===== MAIN ===== */
        .admin-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #FAFAFA;
        }

        /* ===== HEADER ===== */
        .admin-header {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .admin-header .page-title {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }
        .admin-header .page-title .sub {
            font-weight: 400;
            color: var(--text-muted);
            font-size: 13px;
            margin-left: 8px;
        }
        .admin-user { display: flex; align-items: center; gap: 12px; }
        .admin-user .user-name { font-size: 13px; font-weight: 500; color: var(--text-primary); }
        .admin-user .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--brand);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFF;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        /* ===== CONTENT ===== */
        .admin-content { padding: 32px; flex: 1; position: relative; }

        /* ===== КАРТОЧКИ ===== */
        .stat-card, .quick-action {
            background: var(--surface);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover, .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.04);
            border-color: rgba(26,26,26,0.15);
            background: #FAFAFA;
        }
        .stat-card { padding: 24px; }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; background: #FAFAFA; color: #1A1A1A;
        }
        .stat-card .stat-number {
            font-size: 28px; font-weight: 800; color: var(--text-primary);
            line-height: 1.2; letter-spacing: -0.5px;
        }
        .stat-card .stat-label { font-size: 12px; color: var(--text-muted); font-weight: 500; }
        .quick-action { padding: 24px; text-align: center; }
        .quick-action .icon { font-size: 28px; margin-bottom: 12px; display: block; }
        .quick-action .title { font-weight: 600; font-size: 13px; color: var(--text-primary); }
        .quick-action .desc { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

        /* ===== ТАБЛИЦЫ ===== */
        .table-container { background: var(--surface); border: 1px solid var(--border); overflow: hidden; }
        .table-container .table-header {
            padding: 18px 24px; border-bottom: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px; background: #FAFAFA;
        }
        .table-container .table-header .title { font-weight: 600; font-size: 14px; color: var(--text-primary); }
        .table-container .table-header .actions { display: flex; gap: 16px; font-size: 12px; }
        .table-container .table-header .actions a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; font-weight: 500; }
        .table-container .table-header .actions a:hover { color: var(--text-primary); }
        .table-container table { width: 100%; border-collapse: collapse; }
        .table-container table th {
            text-align: left; padding: 12px 20px; font-size: 10px;
            text-transform: uppercase; letter-spacing: 1.5px;
            color: var(--text-muted); font-weight: 600;
            border-bottom: 1px solid var(--border); background: #FAFAFA;
        }
        .table-container table td {
            padding: 14px 20px; font-size: 13px;
            border-bottom: 1px solid rgba(26,26,26,0.03);
            color: var(--text-primary); vertical-align: middle;
        }
        .table-container table tr:hover td { background: #FAFAFA; }
        .table-container table tr:last-child td { border-bottom: none; }

        /* ===== СТАТУСЫ ===== */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 100px;
            font-size: 10px; font-weight: 600; letter-spacing: 0.5px;
            background: #F5F5F5; color: #1A1A1A;
        }
        .status-badge .dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
        .status-badge.active .dot,
        .status-badge.won .dot { background: var(--accent); }
        .status-badge.new .dot { background: #1A1A1A; }
        .status-badge.contacted .dot { background: #666; }
        .status-badge.inactive .dot,
        .status-badge.lost .dot { background: #BBB; }
        .status-badge.out_of_stock .dot { background: #888; }

        /* ===== КНОПКИ ===== */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: 0;
            font-size: 12px; font-weight: 600; text-decoration: none;
            cursor: pointer; border: none; transition: all 0.25s ease;
            font-family: 'Inter', sans-serif; letter-spacing: 0.5px;
        }
        .btn-primary { background: #1A1A1A; color: #FFF; }
        .btn-primary:hover { background: #000; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,0.12); }
        .btn-outline { background: transparent; color: #1A1A1A; border: 1px solid rgba(26,26,26,0.15); }
        .btn-outline:hover { background: #FAFAFA; border-color: rgba(26,26,26,0.25); }
        .btn-sm { padding: 5px 14px; font-size: 11px; }

        /* ===== ФОРМЫ ===== */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 11px; font-weight: 600; color: #1A1A1A; margin-bottom: 6px; letter-spacing: 0.5px; text-transform: uppercase; }
        .form-control {
            width: 100%; padding: 12px 16px; border: 1px solid rgba(26,26,26,0.1);
            font-size: 14px; font-family: 'Inter', sans-serif; transition: all 0.2s ease;
            background: #FFF; color: #1A1A1A;
        }
        .form-control:focus { outline: none; border-color: #1A1A1A; box-shadow: 0 0 0 3px rgba(26,26,26,0.04); background: #FAFAFA; }
        .form-control::placeholder { color: #AAA; }

        /* ===== АЛЕРТЫ ===== */
        .alert {
            padding: 14px 20px; margin-bottom: 24px; font-size: 13px;
            border-left: 3px solid #1A1A1A; background: #FAFAFA;
            color: #1A1A1A; display: flex; align-items: center; gap: 10px;
        }
        .alert i { opacity: 0.6; }

        /* ===== АДАПТИВ ===== */
        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main { margin-left: 0; }
            .admin-header { padding: 0 16px; }
            .admin-content { padding: 20px; }
            .admin-header .page-title { font-size: 15px; }
            .admin-header .page-title .sub { display: none; }
            .sidebar-toggle { display: flex !important; }
        }
        .sidebar-toggle {
            display: none; background: none; border: none;
            font-size: 22px; color: #1A1A1A; cursor: pointer; padding: 6px; border-radius: 4px;
        }
        .sidebar-toggle:hover { background: #F5F5F5; }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4); z-index: 45; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        /* ===== УТИЛИТЫ ===== */
        .text-muted { color: #999; }
        .flex { display: flex; }
        .flex-wrap { flex-wrap: wrap; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; } .gap-3 { gap: 12px; } .gap-4 { gap: 16px; } .gap-6 { gap: 24px; }
        .mb-2 { margin-bottom: 8px; } .mb-4 { margin-bottom: 16px; } .mb-6 { margin-bottom: 24px; } .mb-8 { margin-bottom: 32px; }
        .mt-4 { margin-top: 16px; } .mt-6 { margin-top: 24px; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        .w-full { width: 100%; }
        .relative { position: relative; }
        @media (max-width: 1024px) { .grid-cols-4 { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .grid-cols-2, .grid-cols-3, .grid-cols-4 { grid-template-columns: 1fr; } }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #FAFAFA; }
        ::-webkit-scrollbar-thumb { background: #DDD; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #CCC; }
    </style>

    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- SIDEBAR --}}
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Инь Ян" class="logo-img">
            <div>
                <span class="brand-text">Инь Ян</span>
                <span class="brand-sub">Администратор</span>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Основное</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-chart-simple"></i></span>
            Дашборд
        </a>

        {{-- Раздел КАТАЛОГ — переработан --}}
        <div class="nav-label">Каталог</div>
        <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-box"></i></span>
            Товары
            <span class="badge">{{ \App\Models\Product::count() }}</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-tags"></i></span>
            Категории
            <span class="badge">{{ \App\Models\Category::count() }}</span>
        </a>

        {{-- Раздел ЗАЯВКИ — переработан --}}
        <div class="nav-label">Заявки</div>
        <a href="{{ route('admin.leads.index') }}" class="sidebar-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            Все заявки
            @php $newLeadsCount = \App\Models\Lead::new()->count(); @endphp
            @if($newLeadsCount > 0)
                <span class="badge badge-new">{{ $newLeadsCount }} новых</span>
            @endif
        </a>
        <a href="{{ route('admin.leads.export') }}" class="sidebar-link">
            <span class="icon"><i class="fas fa-file-export"></i></span>
            Экспорт в CSV
        </a>

        <div class="nav-label">Система</div>
        <a href="#" class="sidebar-link">
            <span class="icon"><i class="fas fa-gear"></i></span>
            Настройки
        </a>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 12px;">
            @csrf
            <button type="submit" class="sidebar-link logout-link" style="width: 100%; background: none; border: none; cursor: pointer; font-family: 'Inter', sans-serif; font-size: 13px; text-align: left;">
                <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                Выйти
            </button>
        </form>
    </nav>
</aside>

{{-- MAIN --}}
<div class="admin-main">
    <header class="admin-header">
        <div style="display: flex; align-items: center; gap: 14px;">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <span class="page-title">
                @yield('page-title', 'Панель управления')
                <span class="sub">/ @yield('sub-title', 'обзор')</span>
            </span>
        </div>
        <div class="admin-user">
            <span class="user-name">{{ auth('admin')->user()->name ?? 'Администратор' }}</span>
            <div class="user-avatar">
                {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 2)) }}
            </div>
        </div>
    </header>

    <main class="admin-content">
        {{-- Декоративные иероглифы для всего контента --}}
        <span class="hanzi-decor xl rotate-n8" style="top: 3%; right: 2%;">管</span>
        <span class="hanzi-decor lg rotate-10" style="bottom: 3%; left: 2%;">理</span>

        @if(session('success'))
            <div class="alert"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert" style="border-left-color: #666;"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    function toggleSidebar() {
        sidebar.classList.contains('open') ? closeSidebar() : (sidebar.classList.add('open'), overlay.classList.add('active'), document.body.style.overflow = 'hidden');
    }

    toggleBtn?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && sidebar.classList.contains('open')) closeSidebar(); });
    window.addEventListener('resize', () => { if (window.innerWidth > 768) closeSidebar(); });
</script>
@stack('scripts')
</body>
</html>
