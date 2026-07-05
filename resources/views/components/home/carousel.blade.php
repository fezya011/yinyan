{{-- components/home/carousel.blade.php --}}
<div class="carousel-container">
    <div class="carousel-track-wrapper">
        <div class="carousel-track" id="carouselTrack">
            @if($slides->count() > 0)
                @foreach($slides as $index => $slide)
                    <div class="carousel-slide {{ $index === 0 ? 'active-slide' : '' }}"
                         data-index="{{ $index }}"
                         data-accent="{{ $slide['accent'] }}">
                        <div class="product-card-visual">
                            @if($slide['image'])
                                <img src="{{ $slide['image'] }}"
                                     alt="{{ $slide['name'] }}"
                                     loading="lazy"
                                     decoding="async"
                                     width="400"
                                     height="400">
                            @else
                                <span class="fallback-emoji">{{ $slide['emoji'] }}</span>
                            @endif
                        </div>

                        <div class="product-card-info">
                            <span class="product-card-tag">{{ $slide['tag'] }}</span>
                            <div class="product-card-name">{{ $slide['name'] }}</div>
                            <div class="product-card-desc">{{ Str::limit($slide['desc'], 90) }}</div>
                            <div class="product-card-price-wrap">
                                <span class="product-card-price">{{ $slide['price'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback --}}
                <div class="carousel-slide active-slide" data-index="0" data-accent="#FF6B00">
                    <div class="product-card-visual">
                        <span class="fallback-emoji">📦</span>
                    </div>
                    <div class="product-card-info">
                        <span class="product-card-tag">Скоро</span>
                        <div class="product-card-name">Товары добавляются</div>
                        <div class="product-card-desc">Следите за обновлениями каталога</div>
                        <div class="product-card-price-wrap">
                            <span class="product-card-price">скоро</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <button class="carousel-arrow prev" id="carouselPrev" aria-label="Предыдущий">←</button>
    <button class="carousel-arrow next" id="carouselNext" aria-label="Следующий">→</button>

    <div class="carousel-counter" id="carouselCounter">01 / {{ max($slides->count(), 1) }}</div>

    <div class="carousel-nav">
        @for($i = 0; $i < max($slides->count(), 1); $i++)
            <button class="carousel-dot {{ $i === 0 ? 'active' : '' }}"
                    data-index="{{ $i }}"
                    aria-label="Слайд {{ $i + 1 }}"></button>
        @endfor
    </div>
</div>
