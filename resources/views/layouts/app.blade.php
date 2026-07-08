{{-- layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Все мета-теги в одном месте --}}
    @include('layouts.partials.meta')

    <title>@yield('title', config('app.name', 'Инь Ян'))</title>

    {{-- Tailwind --}}
    @include('layouts.partials.tailwind')

    {{-- Core Styles --}}
    @include('layouts.partials.core-styles')

    {{-- Modal Styles --}}
    @vite(['resources/css/partials/lead-modal.css'])

    {{-- Page Specific Styles --}}
    @stack('styles')
</head>

<body>
{{-- Header --}}
@include('partials.header')

{{-- Main Content --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('partials.footer')

{{-- Core Scripts --}}
@include('layouts.partials.core-scripts')

{{-- Lead Modal --}}
@include('partials.lead-modal.index')
@vite(['resources/js/partials/lead-modal.js'])

{{-- Page Specific Scripts --}}
@stack('scripts')
</body>
</html>
