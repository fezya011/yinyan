{{-- pages/product/partials/hero.blade.php --}}
<div class="px-4 md:px-12 lg:px-16">
    <div class="product-hero">
        {{-- Левая колонка --}}
        <div class="product-hero-left section-with-hanzi" data-aos="fade-up">
            <div class="status-badge {{ $product->status === 'active' ? 'in-stock' : 'out-of-stock' }}">
                <span class="status-dot"></span>
                {{ $product->status === 'active' ? 'В наличии на складе' : 'Под заказ' }}
            </div>

            @if($product->category)
                <div class="product-category-tag">{{ $product->category->name }}</div>
            @endif

            <h1 class="product-title">{{ $product->name }}</h1>

            @if($product->card_subtitle)
                <p class="product-subtitle">{{ $product->card_subtitle }}</p>
            @endif

            {{-- Блок цен --}}
            @include('pages.product.partials.price-block', ['product' => $product])

            <a href="#"
               class="btn-contact"
               data-lead-modal
               data-lead-product="{{ $product->id }}">
                <span>Связаться</span>
                <span class="arrow">→</span>
            </a>

            <div class="internal-note" style="opacity: 0.85;">
                <div class="internal-note-label">Информация для заказа</div>
                <div class="internal-note-text">
                    Все цены без учёта доставки. Отгрузка со склада в г. Артём, Приморский край. Доставка по РФ транспортными компаниями. Прямые контейнерные поставки из КНР.
                </div>
            </div>

            {{-- Иероглифы --}}
            <span class="hanzi-decor lg" style="bottom: 40px; right: -20px; opacity: 0.18; transform: rotate(-12deg);">价</span>
            <span class="hanzi-decor sm" style="top: 28%; left: -30px; opacity: 0.10; transform: rotate(8deg);">值</span>
        </div>

        {{-- Правая колонка --}}
        <div class="product-hero-right relative section-with-hanzi" data-aos="fade-up" data-aos-delay="100">
            {{-- Описание --}}
            @include('pages.product.partials.description', ['product' => $product])

            {{-- Характеристики --}}
            @include('pages.product.partials.specifications', ['product' => $product])

            {{-- Иероглиф --}}
            <span class="hanzi-decor md" style="top: 10%; right: -20px; opacity: 0.10; transform: rotate(10deg);">详</span>
        </div>
    </div>
</div>
