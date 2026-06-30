{{-- resources/views/catalog/partials/pagination.blade.php --}}
@if($products->hasPages())
    <div class="pagination-wrap">
        {{-- Предыдущая --}}
        @if($products->onFirstPage())
            <span class="page-btn arrow" style="opacity: 0.3; cursor: default;">←</span>
        @else
            <a href="{{ $products->previousPageUrl() }}" class="page-btn arrow">←</a>
        @endif

        {{-- Страницы --}}
        @foreach($products->links()->elements[0] as $page => $url)
            @if($page == $products->currentPage())
                <span class="page-btn active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Следующая --}}
        @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="page-btn arrow">→</a>
        @else
            <span class="page-btn arrow" style="opacity: 0.3; cursor: default;">→</span>
        @endif
    </div>
@endif
