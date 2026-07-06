{{-- admin/categories/index.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Категории')
@section('page-title', 'Категории')
@section('sub-title', 'структура')

@push('styles')
    @vite(['resources/css/pages/admin/categories/index.css'])
@endpush

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-muted">Управление категориями товаров</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Добавить категорию
        </a>
    </div>

    {{-- Сетка категорий --}}
    @include('admin.categories.components.category-grid', ['categories' => $categories])

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor lg rotate-10" style="top: 5%; right: 2%; opacity: 0.02 !important;">类</span>
    <span class="hanzi-decor md rotate-n8" style="bottom: 5%; left: 2%; opacity: 0.02 !important;">目</span>
    <span class="hanzi-decor sm rotate-8" style="top: 40%; left: 1%; opacity: 0.015 !important;">分</span>
    <span class="hanzi-decor sm rotate-n5" style="bottom: 40%; right: 1%; opacity: 0.015 !important;">组</span>

    @push('scripts')
        @vite(['resources/js/pages/admin/categories/index.js'])
    @endpush
@endsection
