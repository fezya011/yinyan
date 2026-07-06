{{-- admin/products/create.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    @vite(['resources/css/pages/admin/products.css'])
@endpush

@section('title', 'Создание товара')
@section('page-title', 'Создание товара')
@section('sub-title', 'новый')

@section('content')
    <div class="edit-layout">
        {{-- Форма --}}
        <div class="form-card">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                @csrf
                @include('admin.products.partials.form', ['product' => null])
            </form>
        </div>

        {{-- Превью --}}
        @include('admin.products.partials.preview', ['product' => null])
    </div>

    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">新</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">建</span>
@endsection

@push('scripts')
    @vite(['resources/js/pages/admin/products.js'])
@endpush
