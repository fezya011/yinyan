{{-- admin/products/partials/table.blade.php --}}
<div class="table-container">
    <table>
        <thead>
        <tr>
            <th style="width: 60px;">№</th>
            <th>Товар</th>
            <th>Категория</th>
            <th>Цена (опт)</th>
            <th style="text-align: center; width: 80px;">Избранное</th>
            <th style="text-align: center; width: 130px;">Статус</th>
            <th style="text-align: center; width: 120px;">Действия</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            @php
                $imageUrl = $product->main_image
                    ? (Str::startsWith($product->main_image, 'http')
                        ? $product->main_image
                        : asset('storage/' . $product->main_image))
                    : null;
            @endphp
            <tr>
                <td class="text-muted" style="font-size: 12px; font-weight: 600;">#{{ $product->id }}</td>
                <td>
                    <div class="product-info">
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}"
                                 alt="{{ $product->name }}"
                                 class="product-thumbnail"
                                 onclick="openQuickView('{{ $imageUrl }}', '{{ $product->name }}', '{{ $product->category?->name ?? '—' }}', '{{ number_format($product->wholesale_price ?? 0, 0, '.', ' ') }} ₽', '{{ $product->tag ?: '' }}', '{{ $product->card_subtitle ?: Str::limit($product->description, 100) }}')"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                 loading="lazy">
                            <div class="product-thumbnail-placeholder" style="display: none;">
                                {{ $product->emoji_icon ?: '📦' }}
                            </div>
                        @else
                            <div class="product-thumbnail-placeholder">
                                {{ $product->emoji_icon ?: '📦' }}
                            </div>
                        @endif

                        <div class="product-details">
                            <a href="{{ route('admin.products.edit', $product) }}" class="name">
                                {{ $product->name }}
                            </a>
                            @if($product->description)
                                <div class="text-muted description">{{ Str::limit($product->description, 60) }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <span style="font-size: 12px; color: #555;">
                        {{ $product->category?->name ?? '—' }}
                    </span>
                </td>
                <td class="font-medium" style="font-weight: 600;">
                    {{ number_format($product->wholesale_price ?? 0, 0, '.', ' ') }} ₽
                </td>
                <td style="text-align: center;">
                    <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 18px; transition: transform 0.2s ease; color: {{ $product->is_featured ? '#B8860B' : '#CCCCCC' }};" title="{{ $product->is_featured ? 'Убрать из избранного' : 'Добавить в избранное' }}">
                            <i class="fas fa-star"></i>
                        </button>
                    </form>
                </td>
                <td style="text-align: center;">
                    <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="status-badge {{ $product->status }}" style="font-size: 10px; padding: 4px 12px; border: 1px solid transparent; cursor: pointer; transition: all 0.2s ease;">
                            <span class="dot"></span>
                            {{ match($product->status) { 'active' => 'Активен', 'inactive' => 'Неактивен', 'out_of_stock' => 'Нет в наличии', default => $product->status } }}
                        </button>
                    </form>
                </td>
                <td style="text-align: center;">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Удалить товар «{{ $product->name }}»?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline" style="color: #999; border-color: rgba(26,26,26,0.1);">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-8">
                    <div style="font-family: 'Noto Serif SC', 'SimSun', serif; font-size: 32px; font-weight: 900; opacity: 0.15; margin-bottom: 8px;">无</div>
                    <span style="font-size: 11px; letter-spacing: 2px; text-transform: uppercase;">Товары не найдены</span>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
