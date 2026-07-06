{{-- pages/contacts/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Контакты – Инь Ян Экспорт и импорт из Китая')
@section('meta_description', 'Контакты компании Инь Ян. Адрес офиса и склада в г. Артём, Приморский край. Телефоны, email.')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/pages/contacts.css'])
@endpush

@section('content')
    <div class="contacts-wrapper">

        {{-- Бегущая строка --}}
        @include('pages.contacts.partials.marquee')

        {{-- Hero секция --}}
        @include('pages.contacts.partials.hero')

        {{-- Информация --}}
        @include('pages.contacts.partials.info')

        {{-- Карта --}}
        @include('pages.contacts.partials.map')

        {{-- FAQ --}}
        @include('pages.contacts.partials.faq')

    </div>
@endsection

@push('scripts')
    <script>
        window.YANDEX_API_KEY = '{{ config('services.yandex.maps_api_key') }}';
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" type="text/javascript"></script>
    @vite(['resources/js/pages/contacts.js'])
@endpush
