{{-- pages/product/partials/gallery.blade.php --}}
<div class="px-4 md:px-12 lg:px-16">
    <div class="gallery-section relative section-with-hanzi" data-aos="fade-up">
        @php
            $allImages = [];
            if ($product->main_image) {
                $allImages[] = asset('storage/' . $product->main_image);
            }
            if ($product->gallery) {
                foreach ($product->gallery as $img) {
                    if ($img !== $product->main_image) {
                        $allImages[] = asset('storage/' . $img);
                    }
                }
            }
        @endphp

        <div class="carousel-container">
            <div class="carousel-track-wrapper">
                <div class="carousel-track" id="productCarouselTrack">
                    @if(count($allImages) > 0)
                        @foreach($allImages as $index => $image)
                            <div class="carousel-slide {{ $index === 0 ? 'active-slide' : '' }}" data-index="{{ $index }}">
                                <img src="{{ $image }}" alt="{{ $product->name }} – {{ $index + 1 }}" loading="lazy">
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-slide active-slide" data-index="0">
                            <span class="no-image-placeholder">无图</span>
                        </div>
                    @endif
                </div>
            </div>

            @if(count($allImages) > 1)
                <button class="carousel-arrow prev" id="productCarouselPrev" aria-label="Предыдущий">←</button>
                <button class="carousel-arrow next" id="productCarouselNext" aria-label="Следующий">→</button>
                <div class="carousel-nav">
                    @for($i = 0; $i < count($allImages); $i++)
                        <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}" aria-label="Слайд {{ $i + 1 }}"></button>
                    @endfor
                </div>
            @endif
        </div>

        @if(count($allImages) > 1)
            <div class="gallery-thumbs">
                @foreach($allImages as $i => $img)
                    <div class="gallery-thumb {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}">
                        <img src="{{ $img }}" alt="Миниатюра {{ $i + 1 }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Иероглифы --}}
        <span class="hanzi-decor xl" style="top: -30px; right: -20px; opacity: 0.18; transform: rotate(5deg);">图</span>
        <span class="hanzi-decor md" style="bottom: 0px; left: -15px; opacity: 0.12; transform: rotate(-8deg);">像</span>
        <span class="hanzi-decor lg" style="top: 40%; left: -30px; opacity: 0.08; transform: rotate(12deg);">展</span>
        <span class="hanzi-decor sm" style="top: 20%; right: -10px; opacity: 0.07; transform: rotate(-5deg);">示</span>
    </div>
</div>
