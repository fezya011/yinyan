{{-- resources/views/partials/catalog/products.blade.php --}}
@if($products->count() > 0)
    @foreach($products as $index => $product)
        <a href="{{ route('product', $product->slug) }}" class="product-card"
           data-category="{{ $product->category?->slug ?? '' }}"
           data-pack="{{ $product->packaging_type ?? '' }}"
           data-id="{{ $product->id }}"
           style="text-decoration: none; color: inherit;">

            {{-- Изображение --}}
            <div class="image-wrap">
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <span class="no-image">Нет фото</span>
                @endif
                @if($product->tag)
                    <span class="badge">{{ $product->tag }}</span>
                @endif
            </div>

            {{-- Контент --}}
            <div class="card-content">
                <div class="category-tag">{{ $product->category?->name ?? 'Без категории' }}</div>
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-desc">{{ Str::limit($product->card_subtitle ?? $product->description ?? '', 80) }}</div>

                {{-- Десктопная мета --}}
                <div class="product-meta">
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

                {{-- Футер с ценой --}}
                <div class="product-footer">
                    <span class="price">
                        <span class="from">от</span>
                        {{ number_format($product->wholesale_price ?? 0, 0, '.', ' ') }} ₽
                    </span>
                </div>
            </div>
        </a>
    @endforeach
@else
    <div class="empty-catalog">
        <span class="empty-icon">空</span>
        <span class="empty-text">Товаров не найдено</span>
    </div>
@endif
