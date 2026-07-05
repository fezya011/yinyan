{{-- pages/product/partials/price-block.blade.php --}}
<div class="price-block">
    <div class="price-block-title">Условия поставки</div>

    @if($product->wholesale_price)
        <div class="price-row">
            <span class="price-label">Оптовая цена</span>
            <div class="price-value wholesale">
                {{ number_format($product->wholesale_price, 2, '.', ' ') }} <span class="unit">₽ / шт</span>
            </div>
        </div>
    @endif

    @if($product->retail_price)
        <div class="price-row">
            <span class="price-label">Рекомендованная розница</span>
            <div class="price-value">{{ number_format($product->retail_price, 2, '.', ' ') }} <span class="unit">₽</span></div>
        </div>
    @endif

    @if($product->distributor_price)
        <div class="price-row">
            <span class="price-label">Дистрибьюторская</span>
            <div class="price-value">{{ number_format($product->distributor_price, 2, '.', ' ') }} <span class="unit">₽</span></div>
        </div>
    @endif

    @if($product->getMarginPercent() !== null)
        <div class="price-row">
            <span class="price-label">Маржинальность</span>
            <div class="price-value margin-positive">{{ $product->getMarginPercent() }}%</div>
        </div>
    @endif

    @if($product->min_order_amount)
        <div class="price-row">
            <span class="price-label">Минимальный заказ</span>
            <div class="price-value">{{ number_format($product->min_order_amount, 2, '.', ' ') }} <span class="unit">₽</span></div>
        </div>
    @endif

    @if($product->vat_rate)
        <div class="price-row">
            <span class="price-label">НДС</span>
            <div class="price-value">{{ $product->vat_rate }}%</div>
        </div>
    @endif
</div>
