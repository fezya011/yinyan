{{-- pages/home/partials/popular-products.blade.php --}}
<section class="px-4 md:px-12 lg:px-16 py-12 lg:py-16 relative section-with-hanzi" id="products">
    <div class="mb-8 relative z-10" data-aos="fade-up">
        <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3">Ассортимент</p>
        <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] text-[#1A1A1A]">
            Популярные позиции
        </h2>
    </div>

    @if($popularProducts->isNotEmpty())
        <div class="catalog-grid compact-grid" data-aos="fade-up">
            @foreach($popularProducts as $product)
                @include('components.home.product-card-compact', ['product' => $product])
            @endforeach
        </div>

        <div class="text-center mt-8 relative z-10" data-aos="fade-up" data-aos-delay="150">
            <a href="{{ route('catalog') }}"
               class="btn-catalog inline-block px-8 py-3 bg-[#1A1A1A] text-white text-[10px] font-semibold tracking-[2px] uppercase transition-transform duration-300 hover:scale-[1.02] active:scale-[0.98] no-underline">
                Перейти в каталог
            </a>
        </div>
    @else
        <p class="text-center text-gray-400 text-sm relative z-10 py-10">Товары скоро появятся</p>
    @endif

    {{-- Иероглифы --}}
    <span class="hanzi-decor xl rotate-n8" style="bottom: 6%; left: 0%; opacity: 0.2; z-index: -1;" >品</span>
    <span class="hanzi-decor xl rotate-12" style="top: 9%; right: 0%; opacity: 0.2; z-index: -1">味</span>
</section>
