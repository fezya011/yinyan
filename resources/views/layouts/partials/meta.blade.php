{{-- layouts/partials/meta.blade.php --}}
{{-- Базовые мета-теги --}}
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- SEO мета-теги --}}
@hasSection('meta_description')
    <meta name="description" content="@yield('meta_description')">
@else
    <meta name="description" content="{{ config('app.description', 'Инь Янь - экспорт и импорт из Китая') }}">
@endif

@hasSection('meta_keywords')
    <meta name="keywords" content="@yield('meta_keywords')">
@endif

{{-- Open Graph --}}
<meta property="og:title" content="@yield('title', config('app.name', 'Инь Янь'))">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
@hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')">
@else
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
@endif
<meta property="og:description" content="@yield('meta_description', config('app.description', ''))">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', config('app.name', 'Инь Янь'))">
<meta name="twitter:description" content="@yield('meta_description', config('app.description', ''))">
<meta name="twitter:image" content="@hasSection('og_image')@yield('og_image')@else{{ asset('images/og-image.jpg') }}@endif">

{{-- Favicon и Apple Touch --}}
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ url()->current() }}">

{{-- Robots --}}
@if(config('app.env') === 'production')
    <meta name="robots" content="index, follow">
@else
    <meta name="robots" content="noindex, nofollow">
@endif
