{{-- admin/products/edit.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    @vite(['resources/css/pages/admin/products.css'])
@endpush

@section('title', 'Редактирование товара')
@section('page-title', 'Редактирование товара')
@section('sub-title', 'изменение')

@section('content')
    <div class="edit-layout">
        {{-- Форма --}}
        <div class="form-card">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                @include('admin.products.partials.form', ['product' => $product])
            </form>
        </div>

        {{-- Превью --}}
        @include('admin.products.partials.preview', ['product' => $product])
    </div>

    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">编</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">辑</span>
@endsection

@push('scripts')
    @vite(['resources/js/pages/admin/products.js'])
@endpush
