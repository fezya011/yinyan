{{-- pages/product/partials/related-products.blade.php --}}
<div class="px-4 md:px-12 lg:px-16">
    <div class="related-section relative section-with-hanzi" data-aos="fade-up">
        <h2 class="section-title">Похожие товары</h2>
        <div class="related-grid">
            @foreach($relatedProducts as $related)
                <a href="{{ route('product', $related->slug) }}" class="related-card">
                    <div class="image-wrap">
                        @if($related->main_image)
                            <img src="{{ asset('storage/' . $related->main_image) }}" alt="{{ $related->name }}" loading="lazy">
                        @else
                            <span class="no-related-image">无图</span>
                        @endif
                    </div>
                    <div class="related-name">{{ $related->name }}</div>
                    @if($related->category)
                        <div class="related-meta">{{ $related->category->name }}</div>
                    @endif
                    <div class="related-price">
                        @if($related->wholesale_price)
                            от {{ number_format($related->wholesale_price, 2, '.', ' ') }} ₽
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        {{-- Иероглифы --}}
        <span class="hanzi-decor md" style="top: 10px; right: -20px; opacity: 0.10; transform: rotate(7deg);">类</span>
        <span class="hanzi-decor sm" style="bottom: -10px; left: -15px; opacity: 0.08; transform: rotate(-8deg);">似</span>
    </div>
</div>
