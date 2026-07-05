{{-- pages/home/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Инь Ян – Экспорт и импорт из Китая')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/pages/home.css'])
@endpush

@section('content')
    {{-- HERO с каруселью --}}
    @include('pages.home.partials.hero', ['slides' => $slides])

    {{-- СТАТИСТИКА --}}
    @include('pages.home.partials.stats')

    {{-- БЕГУЩАЯ СТРОКА --}}
    @include('pages.home.partials.marquee')

    {{-- ПОПУЛЯРНЫЕ ТОВАРЫ --}}
    @include('pages.home.partials.popular-products', ['popularProducts' => $popularProducts])

    {{-- КАРТА ПОСТАВОК --}}
    @include('pages.home.partials.map')

    {{-- ОБРАТНАЯ БЕГУЩАЯ СТРОКА --}}
    @include('pages.home.partials.marquee-reverse')

    {{-- ПОЧЕМУ МЫ --}}
    @include('pages.home.partials.reasons')

    {{-- CTA --}}
    @include('pages.home.partials.cta')
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    @vite(['resources/js/pages/home.js'])
@endpush
