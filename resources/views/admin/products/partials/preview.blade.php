{{-- admin/products/partials/preview.blade.php --}}
<div class="preview-panel" id="previewPanel">
    <div class="preview-panel-header">
        <span class="dot"></span>
        <span class="title">Предпросмотр карточки</span>
    </div>
    <div class="preview-panel-body">
        <div class="preview-card" id="previewCard">
            <div class="preview-accent-bar" id="previewAccentBar" style="background-color: {{ $product?->accent_color ?? '#83BF32' }};"></div>

            <div class="preview-card-image">
                <span class="preview-card-featured" id="previewFeatured" style="display: {{ ($product?->is_featured ?? false) ? 'block' : 'none' }};">⭐</span>
                <span class="preview-card-tag" id="previewTag">{{ $product?->tag ?? 'Тег' }}</span>
                <span class="preview-card-status {{ $product?->status ?? 'active' }}" id="previewStatus">
                    @if($product)
                        {{ match($product->status) { 'active' => 'Активен', 'inactive' => 'Неактивен', 'out_of_stock' => 'Нет в наличии', default => $product->status } }}
                    @else
                        Активен
                    @endif
                </span>

                @if($product && $product->main_image)
                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" id="previewImage">
                @else
                    <span class="emoji-placeholder" id="previewEmoji">{{ $product?->emoji_icon ?? '🍜' }}</span>
                @endif
            </div>

            <div class="preview-card-info">
                <div class="preview-card-name" id="previewName">{{ $product?->name ?? 'Название товара' }}</div>
                <div class="preview-card-desc" id="previewDesc">{{ $product?->card_subtitle ?: ($product ? Str::limit($product->description, 80) : 'Описание товара') }}</div>
                <span class="preview-card-price" id="previewPrice">
                    @if($product && $product->wholesale_price)
                        от {{ number_format($product->wholesale_price, 0, '.', ' ') }} ₽ / шт
                    @else
                        от 0 ₽ / шт
                    @endif
                </span>
            </div>
        </div>

        <div class="preview-indicators">
            <div class="preview-indicator">
                <div class="value" id="previewWeight">{{ $product?->weight_grams ? $product->weight_grams . ' г' : '—' }}</div>
                <div class="label">Вес</div>
            </div>
            <div class="preview-indicator">
                <div class="value" id="previewPieces">{{ $product?->pieces_per_box ? $product->pieces_per_box . ' шт' : '—' }}</div>
                <div class="label">В коробке</div>
            </div>
            <div class="preview-indicator">
                <div class="value" id="previewShelf">{{ $product?->shelf_life_days ? $product->shelf_life_days . ' дн' : '—' }}</div>
                <div class="label">Срок годности</div>
            </div>
            <div class="preview-indicator">
                <div class="value" id="previewBoxes">{{ $product?->boxes_per_pallet ? $product->boxes_per_pallet : '—' }}</div>
                <div class="label">На паллете</div>
            </div>
        </div>
    </div>
</div>
