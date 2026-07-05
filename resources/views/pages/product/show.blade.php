{{-- pages/product/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' – Инь Ян')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite(['resources/css/pages/product.css'])
@endpush

@section('content')
    <div class="product-wrapper" data-accent-color="{{ $product->accent_color ?? '#FF6B00' }}">
        {{-- Хлебные крошки --}}
        @include('pages.product.partials.breadcrumbs', ['product' => $product])

        {{-- Галерея --}}
        @include('pages.product.partials.gallery', ['product' => $product])

        {{-- Hero секция --}}
        @include('pages.product.partials.hero', ['product' => $product])

        {{-- Похожие товары --}}
        @if($relatedProducts && $relatedProducts->count() > 0)
            @include('pages.product.partials.related-products', ['relatedProducts' => $relatedProducts])
        @endif

        {{-- CTA секция --}}
        @include('pages.product.partials.cta')
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @vite(['resources/js/pages/product.js'])
@endpush
