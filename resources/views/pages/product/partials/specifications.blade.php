{{-- pages/product/partials/specifications.blade.php --}}
<div class="specs-logistics-section" data-aos="fade-up">
    <h2 class="section-title">Характеристики и логистика</h2>
    <div class="unified-specs-grid">
        @if($product->weight_grams)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Вес единицы</span>
                <span class="unified-spec-value">
                    {{ number_format($product->weight_grams, 0, '.', ' ') }} г
                    <span class="unified-spec-sub">{{ number_format($product->getWeightKg(), 3, '.', '') }} кг</span>
                </span>
            </div>
        @endif

        @if($product->packaging_type)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Тип упаковки</span>
                <span class="unified-spec-value">{{ $product->packaging_type }}</span>
            </div>
        @endif

        @if($product->pieces_per_box)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Штук в коробке</span>
                <span class="unified-spec-value">{{ $product->pieces_per_box }} шт</span>
            </div>
        @endif

        @if($product->box_weight_kg)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Вес коробки</span>
                <span class="unified-spec-value">{{ number_format($product->box_weight_kg, 2, '.', '') }} кг</span>
            </div>
        @endif

        @if($product->box_volume)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Объём коробки</span>
                <span class="unified-spec-value">{{ number_format($product->box_volume, 3, '.', '') }} м³</span>
            </div>
        @endif

        @if($product->shelf_life_days)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Срок годности</span>
                <span class="unified-spec-value">
                    {{ $product->shelf_life_days }} дн
                    <span class="unified-spec-sub">{{ round($product->shelf_life_days / 30, 1) }} мес</span>
                </span>
            </div>
        @endif

        @if($product->boxes_per_pallet)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Коробок на паллете</span>
                <span class="unified-spec-value">{{ $product->boxes_per_pallet }} кор</span>
            </div>
        @endif

        @if($product->boxes_per_pallet && $product->pieces_per_box)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Штук на паллете</span>
                <span class="unified-spec-value">
                    {{ number_format($product->pieces_per_box * $product->boxes_per_pallet, 0, '.', ' ') }}
                </span>
            </div>
        @endif

        @if($product->boxes_per_pallet && $product->box_weight_kg)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Вес паллеты (≈)</span>
                <span class="unified-spec-value">
                    {{ number_format($product->boxes_per_pallet * $product->box_weight_kg, 0, '.', ' ') }} кг
                </span>
            </div>
        @endif

        <div class="unified-spec-item">
            <span class="unified-spec-label">Доставка из КНР</span>
            <span class="unified-spec-value">14–21 дн</span>
        </div>

        @if($product->tnved_code)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Код ТН ВЭД</span>
                <span class="unified-spec-value mono">{{ $product->tnved_code }}</span>
            </div>
        @endif

        @if($product->barcode)
            <div class="unified-spec-item">
                <span class="unified-spec-label">Штрихкод</span>
                <span class="unified-spec-value mono">{{ chunk_split($product->barcode, 4, ' ') }}</span>
            </div>
        @endif
    </div>
</div>
