{{-- pages/product/partials/description.blade.php --}}
@if($product->description)
    <div class="description-section" data-aos="fade-up">
        <h2 class="section-title">Описание товара</h2>
        @php
            $descText = $product->description;
            $descLength = mb_strlen($descText);
            $isLong = $descLength > 600;
        @endphp
        <div class="description-content {{ $isLong ? 'description-collapsed' : '' }}" id="descriptionText">
            {!! nl2br(e($descText)) !!}
        </div>
        @if($isLong)
            <button class="read-more-btn" id="readMoreBtn" onclick="toggleDescription()">
                <span id="readMoreText">Читать полностью</span>
                <span id="readMoreArrow" style="transition: transform 0.3s;">↓</span>
            </button>
        @endif
    </div>
@endif
