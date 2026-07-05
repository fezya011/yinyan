{{-- pages/product/partials/breadcrumbs.blade.php --}}
<div class="px-4 md:px-12 lg:px-16">
    <div class="breadcrumbs" data-aos="fade-up">
        <a href="{{ route('home') }}">Главная</a>
        <span class="separator">/</span>
        <a href="{{ route('catalog') }}">Каталог</a>
        @if($product->category)
            <span class="separator">/</span>
            <a href="{{ route('catalog', ['category' => $product->category->slug]) }}">
                {{ $product->category->name }}
            </a>
        @endif
        <span class="separator">/</span>
        <span class="current">{{ $product->name }}</span>
    </div>
</div>
