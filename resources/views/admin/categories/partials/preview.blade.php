{{-- admin/categories/partials/preview.blade.php --}}
<div class="preview-panel">
    <div class="preview-panel-header">
        <span class="dot"></span>
        <span class="title">Предпросмотр карточки</span>
    </div>
    <div class="preview-panel-body">
        <div class="preview-card">
            <div class="preview-card-header">
                <div class="preview-icon" id="previewIcon">{{ $category?->icon ?? '📁' }}</div>
                <div>
                    <div class="preview-name" id="previewName">{{ $category?->name ?? 'Название категории' }}</div>
                    <div class="preview-slug" id="previewSlug">{{ $category?->slug ?? 'slug' }}</div>
                </div>
            </div>

            <span class="preview-tag" id="previewTag">{{ $category?->tag_prefix ?? 'Префикс тега' }}</span>

            <div class="preview-desc" id="previewDesc">
                {{ $category?->description ?? 'Описание категории будет здесь' }}
            </div>

            <div class="preview-status">
                <span class="dot {{ ($category?->is_active ?? true) ? 'active' : 'inactive' }}" id="previewStatusDot"></span>
                <span id="previewStatusText">{{ ($category?->is_active ?? true) ? 'Активна' : 'Неактивна' }}</span>
            </div>

            <div class="preview-stats">
                <div class="preview-stat">
                    <div class="value">{{ $category?->products_count ?? 0 }}</div>
                    <div class="label">Товаров</div>
                </div>
                <div class="preview-stat">
                    <div class="value">{{ $category?->products()->where('status', 'active')->count() ?? 0 }}</div>
                    <div class="label">Активных</div>
                </div>
            </div>

            {{-- Превью товаров с маленькими фото --}}
            @if($category && $category->products()->count() > 0)
                @php
                    $previewProducts = $category->products()->take(3)->get();
                @endphp
                <div class="current-products">
                    <div class="label">Товары в категории</div>
                    <div class="product-chips">
                        @foreach($previewProducts as $product)
                            <a href="{{ route('admin.products.edit', $product) }}" class="product-chip" title="{{ $product->name }}">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}"
                                         alt="{{ $product->name }}"
                                         style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px; margin-right: 4px;">
                                @else
                                    <span style="font-size: 14px;">{{ $product->emoji_icon ?: '📦' }}</span>
                                @endif
                                {{ Str::limit($product->name, 15) }}
                            </a>
                        @endforeach
                        @if($category->products_count > 3)
                            <a href="{{ route('admin.products.index', ['category' => $category->id]) }}"
                               class="product-chip"
                               style="background: #1A1A1A; color: #FFFFFF; border-color: #1A1A1A;">
                                +{{ $category->products_count - 3 }}
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
