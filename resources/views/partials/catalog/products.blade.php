{{-- resources/views/partials/catalog/products.blade.php --}}
@if($products->count() > 0)
    @foreach($products as $index => $product)
        <a href="{{ route('product', $product->slug) }}" class="product-card"
           data-category="{{ $product->category?->slug ?? '' }}"
           data-pack="{{ $product->packaging_type ?? '' }}"
           data-id="{{ $product->id }}"
           style="text-decoration: none; color: inherit;">

            <div class="image-wrap">
                @if($product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <span class="no-image">Нет фото</span>
                @endif
            </div>

            {{-- Бейдж поверх карточки --}}
            @if($product->tag)
                <span class="badge">{{ $product->tag }}</span>
            @endif

            <div class="category-tag">{{ $product->category?->name ?? 'Без категории' }}</div>
            <div class="product-name">{{ $product->name }}</div>
            <div class="product-desc">{{ Str::limit($product->card_subtitle ?? $product->description ?? '', 80) }}</div>

            {{-- Сертификаты --}}
            @if($product->has_eac || $product->has_honest_sign)
                <div class="certificates">
                    @if($product->has_eac)
                        <span class="cert-badge has">ЕАС</span>
                    @endif
                    @if($product->has_honest_sign)
                        <span class="cert-badge has">Честный знак</span>
                    @endif
                </div>
            @endif

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

            <div class="product-footer">
                <span class="price">
                    <span class="from">от</span>
                    {{ number_format($product->wholesale_price ?? 0, 0, '.', ' ') }} ₽
                </span>
                <span class="btn-order"
                      data-product="{{ $product->id }}"
                      data-name="{{ $product->name }}"
                      data-price="{{ $product->wholesale_price ?? 0 }}"
                      onclick="event.preventDefault(); event.stopPropagation();">
                    Заказать
                </span>
            </div>
        </a>
    @endforeach
@else
    <div class="empty-catalog">
        <span class="empty-icon">空</span>
        <span class="empty-text">Товаров не найдено</span>
    </div>
@endif
