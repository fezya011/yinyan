{{-- admin/categories/components/category-products-preview.blade.php --}}
@php
    $categoryProducts = $category->products()->take(3)->get();
@endphp

@if($categoryProducts->count() > 0)
    <div class="category-products-preview" onclick="event.stopPropagation();">
        @foreach($categoryProducts as $catProduct)
            @php
                $thumbUrl = $catProduct->main_image
                    ? (Str::startsWith($catProduct->main_image, 'http')
                        ? $catProduct->main_image
                        : asset('storage/' . $catProduct->main_image))
                    : null;
            @endphp
            @if($thumbUrl)
                <img src="{{ $thumbUrl }}"
                     alt="{{ $catProduct->name }}"
                     class="mini-thumb"
                     onclick="event.stopPropagation(); window.location='{{ route('admin.products.edit', $catProduct) }}'"
                     onerror="this.style.display='none'; this.nextElementSibling ? this.nextElementSibling.style.display='flex' : null;"
                     loading="lazy"
                     title="{{ $catProduct->name }} — нажмите для редактирования">
                <div class="mini-thumb-placeholder" style="display: none;"
                     onclick="event.stopPropagation(); window.location='{{ route('admin.products.edit', $catProduct) }}'">
                    {{ $catProduct->emoji_icon ?: '📦' }}
                </div>
            @else
                <div class="mini-thumb-placeholder"
                     onclick="event.stopPropagation(); window.location='{{ route('admin.products.edit', $catProduct) }}'">
                    {{ $catProduct->emoji_icon ?: '📦' }}
                </div>
            @endif
        @endforeach

        @if($category->products_count > 3)
            <a href="{{ route('admin.products.index', ['category' => $category->id]) }}"
               class="more-products"
               title="Показать все товары"
               onclick="event.stopPropagation();">
                +{{ $category->products_count - 3 }}
            </a>
        @endif
    </div>
@endif
