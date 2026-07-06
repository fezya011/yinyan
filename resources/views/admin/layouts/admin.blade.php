{{-- admin/layouts/admin.blade.php --}}
    <!DOCTYPE html>
<html lang="ru">
<head>
    @include('admin.layouts.partials.head')
    @vite(['resources/css/pages/admin/layout.css'])
    @stack('styles')
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- Сайдбар --}}
@include('admin.layouts.partials.sidebar')

{{-- Основной контент --}}
<div class="admin-main">
    {{-- Хедер --}}
    @include('admin.layouts.partials.header')

    {{-- Контент --}}
    @include('admin.layouts.partials.content')
</div>

{{-- Скрипты --}}
@vite(['resources/js/pages/admin/layout.js'])
@stack('scripts')

</body>
</html>
