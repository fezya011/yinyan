{{-- resources/views/admin/layouts/partials/sidebar.blade.php --}}
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

        <div class="nav-label">Заявки</div>
        <a href="{{ route('admin.leads.index') }}" class="sidebar-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-envelope"></i></span>
            Все заявки
            @php $newLeadsCount = \App\Models\Lead::new()->count(); @endphp
            @if($newLeadsCount > 0)
                <span class="badge badge-new">{{ $newLeadsCount }} новых</span>
            @endif
        </a>
        <a href="{{ route('admin.leads.export-page') }}" class="sidebar-link">
            <span class="icon"><i class="fas fa-file-export"></i></span>
            Экспорт в CSV
        </a>

        <div class="nav-label">Система</div>
        <a href="{{ route('admin.settings.notifications') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="icon"><i class="fas fa-gear"></i></span>
            Настройки
            <span class="badge" style="background: #3b82f6; color: white;">{{ \App\Models\NotificationEmail::active()->count() }}</span>
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
