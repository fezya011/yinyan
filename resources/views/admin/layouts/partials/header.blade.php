{{-- admin/layouts/partials/header.blade.php --}}
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
