{{-- admin/categories/create.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Создание категории')
@section('page-title', 'Создание категории')
@section('sub-title', 'новая')

@push('styles')
    @vite(['resources/css/pages/admin/categories/form.css'])
@endpush

@section('content')
    <div class="create-layout">
        {{-- Форма --}}
        <div class="form-card">
            @include('admin.categories.partials.form', [
                'action' => route('admin.categories.store'),
                'method' => 'POST',
                'category' => null,
                'buttonText' => 'Сохранить категорию'
            ])
        </div>

        {{-- Превью --}}
        @include('admin.categories.partials.preview', ['category' => null])
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">新</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">类</span>

    @push('scripts')
        @vite(['resources/js/pages/admin/categories/form.js'])
    @endpush
@endsection
