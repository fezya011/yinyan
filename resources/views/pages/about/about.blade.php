{{-- pages/about/index.blade.php --}}
@extends('layouts.app')

@section('title', 'О компании – Инь Ян Экспорт и импорт из Китая')
@section('meta_description', 'Инь Ян — надёжный партнёр по импорту продуктов питания из Китая. 10+ лет на рынке, прямой импорт, собственный склад, полное юридическое сопровождение.')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/pages/about.css'])
@endpush

@section('content')
    <div class="page-wrapper">

        {{-- Хлебные крошки --}}
        @include('pages.about.partials.breadcrumbs')

        {{-- Hero секция --}}
        @include('pages.about.partials.hero')

        {{-- Миссия --}}
        @include('pages.about.partials.mission')

        {{-- История --}}
        @include('pages.about.partials.history')

        {{-- Ценности --}}
        @include('pages.about.partials.values')

        {{-- Сертификаты --}}
        @include('pages.about.partials.certificates')

    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @vite(['resources/js/pages/about.js'])
@endpush
