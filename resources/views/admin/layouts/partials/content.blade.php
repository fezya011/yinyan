{{-- admin/layouts/partials/content.blade.php --}}
<main class="admin-content">
    {{-- Декоративные иероглифы для контента --}}
    @include('admin.layouts.partials.hanzi-decor')

    {{-- Алерты --}}
    @include('admin.layouts.partials.alerts')

    {{-- Основной контент страницы --}}
    @yield('content')
</main>
