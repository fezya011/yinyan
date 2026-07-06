{{-- admin/categories/edit.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Редактирование категории')
@section('page-title', 'Редактирование категории')
@section('sub-title', 'изменение')

@push('styles')
    @vite(['resources/css/pages/admin/categories/form.css'])
@endpush

@section('content')
    <div class="edit-layout">
        {{-- Форма --}}
        <div class="form-card">
            @include('admin.categories.partials.form', [
                'action' => route('admin.categories.update', $category),
                'method' => 'PUT',
                'category' => $category,
                'buttonText' => 'Обновить категорию'
            ])
        </div>

        {{-- Превью --}}
        @include('admin.categories.partials.preview', ['category' => $category])
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">编</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">辑</span>

    @push('scripts')
        @vite(['resources/js/pages/admin/categories/form.js'])
    @endpush
@endsection
