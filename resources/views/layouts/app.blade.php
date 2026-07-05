{{-- layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Инь Янь'))</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

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
