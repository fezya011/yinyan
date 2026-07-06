{{-- admin/dashboard.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/pages/admin/dashboard.css'])
@endpush

@section('title', 'Дашборд')
@section('page-title', 'Дашборд')
@section('sub-title', 'обзор')

@section('content')
    <div class="content-wrapper">
        {{-- Статистика --}}
        @include('admin.dashboard.partials.stats')

        {{-- Быстрые действия --}}
        @include('admin.dashboard.partials.actions')

        {{-- Последние заявки и популярные товары --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8" data-aos="fade-up" data-aos-delay="200">
            @include('admin.dashboard.partials.recent-leads')
            @include('admin.dashboard.partials.top-products')
        </div>

        {{-- Дополнительная статистика --}}
        @include('admin.dashboard.partials.mini-stats')
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor lg rotate-10" style="bottom: 3%; right: 2%;">统</span>
    <span class="hanzi-decor md rotate-n8" style="top: 8%; left: 1%;">计</span>
    <span class="hanzi-decor sm rotate-10" style="top: 20%; right: 3%;">管</span>
    <span class="hanzi-decor sm rotate-n5" style="bottom: 15%; left: 2%;">理</span>
    <span class="hanzi-decor xs rotate-8" style="top: 60%; right: 1%;">财</span>
    <span class="hanzi-decor xs rotate-n12" style="bottom: 25%; left: 1%;">务</span>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @vite(['resources/js/pages/admin/dashboard.js'])
@endpush
