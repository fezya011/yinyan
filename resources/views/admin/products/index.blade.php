{{-- admin/products/index.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    @vite(['resources/css/pages/admin/products.css'])
@endpush

@section('title', 'Товары')
@section('page-title', 'Товары')
@section('sub-title', 'каталог')

@section('content')
    <div class="flex flex-wrap gap-4 justify-between items-center mb-6">
        <div>
            <p class="text-muted">Управление товарами</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Добавить товар
        </a>
    </div>

    {{-- Фильтры --}}
    @include('admin.products.partials.filters')

    {{-- Таблица --}}
    @include('admin.products.partials.table')

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    {{-- Быстрый просмотр --}}
    @include('admin.products.partials.quick-view')

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor md rotate-n8" style="top: 5%; right: 2%; opacity: 0.02 !important;">品</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 5%; left: 2%; opacity: 0.02 !important;">类</span>
    <span class="hanzi-decor xs rotate-8" style="top: 30%; left: 1%; opacity: 0.015 !important;">丰</span>
    <span class="hanzi-decor xs rotate-n5" style="bottom: 30%; right: 1%; opacity: 0.015 !important;">富</span>
@endsection

@push('scripts')
    @vite(['resources/js/pages/admin/products.js'])
@endpush
