{{-- components/home/product-card-compact.blade.php --}}
<a href="{{ route('product', $product->slug) }}" class="product-card compact-card">
    <div class="image-wrap compact-image">
        @if($product->main_image)
            <img src="{{ asset('storage/' . $product->main_image) }}"
                 alt="{{ $product->name }}"
                 loading="lazy">
        @else
            <span class="no-image">Нет фото</span>
        @endif
        @if($product->tag)
            <span class="badge compact-badge">{{ $product->tag }}</span>
        @endif
    </div>

    <div class="card-content compact-content">
        <div class="category-tag">{{ $product->category?->name ?? 'Без категории' }}</div>
        <div class="product-name compact-name">{{ $product->name }}</div>
        <div class="product-desc compact-desc">{{ Str::limit($product->card_subtitle ?? $product->description ?? '', 70) }}</div>

        {{-- Десктопная мета --}}
        <div class="product-meta compact-meta">
            <span class="meta-item">
                <strong>Мин. заказ:</strong> {{ number_format($product->min_order_amount ?? 100000, 0, '.', ' ') }} ₽
            </span>
            @if($product->weight_grams)
                <span class="meta-item">
                    <strong>Вес:</strong> {{ $product->weight_grams }} г
                </span>
            @endif
            @if($product->shelf_life_days)
                <span class="meta-item">
                    <strong>Срок:</strong> {{ $product->shelf_life_days }} дн.
                </span>
            @endif
            @if($product->pieces_per_box)
                <span class="meta-item">
                    <strong>В коробке:</strong> {{ $product->pieces_per_box }} шт.
                </span>
            @endif
        </div>

        {{-- Мобильная мета --}}
        <div class="product-meta-mobile">
            @if($product->weight_grams)
                <span class="meta-item">{{ $product->weight_grams }} г</span>
            @endif
            @if($product->pieces_per_box)
                <span class="meta-item">{{ $product->pieces_per_box }} шт/кор</span>
            @endif
            @if($product->shelf_life_days)
                <span class="meta-item">{{ $product->shelf_life_days }} дн.</span>
            @endif
        </div>

        <div class="product-footer compact-footer">
            <span class="price compact-price">
                <span class="from">от</span>
                {{ number_format($product->wholesale_price ?? 0, 0, '.', ' ') }} ₽
            </span>
        </div>
    </div>
</a>
