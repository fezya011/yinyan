{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Товары')
@section('page-title', 'Товары')
@section('sub-title', 'каталог')

@push('styles')
    <style>
        .product-thumbnail {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid rgba(26, 26, 26, 0.06);
            background: #FAFAFA;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-thumbnail:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 10;
            position: relative;
        }

        .product-thumbnail-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            border: 1px solid rgba(26, 26, 26, 0.06);
            background: #FAFAFA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            opacity: 0.4;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .product-details {
            flex: 1;
            min-width: 0;
        }

        .product-details .name {
            color: #1A1A1A;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-details .name:hover {
            opacity: 0.6;
        }

        .product-details .description {
            font-size: 11px;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }

        /* Модальное окно для быстрого просмотра */
        .quick-view-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .quick-view-modal.active {
            display: flex;
        }

        .quick-view-content {
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.06);
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        }

        .quick-view-content img {
            width: 100%;
            height: 300px;
            object-fit: contain;
            background: #FAFAFA;
            border-bottom: 1px solid rgba(26, 26, 26, 0.06);
            padding: 20px;
        }

        .quick-view-info {
            padding: 20px;
        }

        .quick-view-close {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.1);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            color: #1A1A1A;
            transition: all 0.2s ease;
            z-index: 10;
        }

        .quick-view-close:hover {
            background: #1A1A1A;
            color: #FFFFFF;
        }

        @media (max-width: 768px) {
            .product-details .description {
                max-width: 150px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-wrap gap-4 justify-between items-center mb-6">
        <div>
            <p class="text-muted">Управление товарами</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Добавить товар
        </a>
    </div>

    {{-- Фильтры --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3 mb-6">
        <div class="flex-1 min-w-[200px]">
            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="Поиск товаров...">
        </div>
        <div>
            <select class="form-control" name="category">
                <option value="">Все категории</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select class="form-control" name="status">
                <option value="">Все статусы</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Активен</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Неактивен</option>
                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Нет в наличии</option>
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Фильтр
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                <i class="fas fa-times"></i>
                Сброс
            </a>
        </div>
    </form>

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
                            {{-- Миниатюра --}}
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

                            {{-- Информация --}}
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
                            <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 18px; transition: transform 0.2s ease; color: {{ $product->is_featured ? '#B8860B' : '#CCCCCC' }};" title="{{ $product->is_featured ? 'Убрать из избранного' : 'Добавить в избранное' }}" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="fas fa-star"></i>
                            </button>
                        </form>
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="status-badge {{ $product->status }}" style="font-size: 10px; padding: 4px 12px; border: 1px solid transparent; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.borderColor='#1A1A1A'" onmouseout="this.style.borderColor='transparent'">
                                <span class="dot"></span>
                                {{ match($product->status) { 'active' => 'Активен', 'inactive' => 'Неактивен', 'out_of_stock' => 'Нет в наличии', default => $product->status } }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align: center;">
                        <div class="flex items-center justify-center gap-2">
                            @can('manage-products')
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Удалить товар «{{ $product->name }}»?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline" style="color: #999; border-color: rgba(26,26,26,0.1);" onmouseover="this.style.color='#CC5555'; this.style.borderColor='#CC5555'" onmouseout="this.style.color='#999'; this.style.borderColor='rgba(26,26,26,0.1)'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
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

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    {{-- Модальное окно быстрого просмотра --}}
    <div class="quick-view-modal" id="quickViewModal">
        <div class="quick-view-content">
            <button class="quick-view-close" onclick="closeQuickView()">
                <i class="fas fa-times"></i>
            </button>
            <img src="" alt="" id="quickViewImage">
            <div class="quick-view-info">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                    <span style="font-size: 9px; letter-spacing: 2px; text-transform: uppercase; background: #1A1A1A; color: #FFF; padding: 3px 10px; font-weight: 600;" id="quickViewTag"></span>
                </div>
                <h3 style="font-weight: 700; font-size: 18px; color: #1A1A1A; margin-bottom: 8px;" id="quickViewName"></h3>
                <p style="font-size: 12px; color: #777; line-height: 1.5; margin-bottom: 12px;" id="quickViewDesc"></p>
                <div style="display: flex; gap: 12px;">
                    <span style="font-weight: 600; font-size: 14px; color: #1A1A1A; background: rgba(26,26,26,0.06); padding: 6px 14px;" id="quickViewPrice"></span>
                    <span style="font-size: 11px; color: #999; padding: 6px 0;" id="quickViewCategory"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor md rotate-n8" style="top: 5%; right: 2%; opacity: 0.02 !important;">品</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 5%; left: 2%; opacity: 0.02 !important;">类</span>
    <span class="hanzi-decor xs rotate-8" style="top: 30%; left: 1%; opacity: 0.015 !important;">丰</span>
    <span class="hanzi-decor xs rotate-n5" style="bottom: 30%; right: 1%; opacity: 0.015 !important;">富</span>

    @push('scripts')
        <script>
            // Быстрый просмотр товара
            function openQuickView(imageUrl, name, category, price, tag, description) {
                const modal = document.getElementById('quickViewModal');
                const img = document.getElementById('quickViewImage');
                const nameEl = document.getElementById('quickViewName');
                const categoryEl = document.getElementById('quickViewCategory');
                const priceEl = document.getElementById('quickViewPrice');
                const tagEl = document.getElementById('quickViewTag');
                const descEl = document.getElementById('quickViewDesc');

                if (img) {
                    img.src = imageUrl;
                    img.alt = name;
                    img.onerror = function() {
                        this.src = '';
                        this.alt = 'Изображение недоступно';
                    };
                }
                if (nameEl) nameEl.textContent = name;
                if (categoryEl) categoryEl.textContent = category;
                if (priceEl) priceEl.textContent = price;
                if (descEl) descEl.textContent = description || 'Описание отсутствует';

                if (tagEl) {
                    if (tag) {
                        tagEl.textContent = tag;
                        tagEl.style.display = 'inline-block';
                    } else {
                        tagEl.style.display = 'none';
                    }
                }

                if (modal) modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeQuickView() {
                const modal = document.getElementById('quickViewModal');
                if (modal) modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Закрытие по клику на фон
            document.getElementById('quickViewModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeQuickView();
                }
            });

            // Закрытие по Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeQuickView();
                }
            });

            // Обработка ошибок загрузки изображений
            document.querySelectorAll('.product-thumbnail').forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = this.nextElementSibling;
                    if (placeholder && placeholder.classList.contains('product-thumbnail-placeholder')) {
                        placeholder.style.display = 'flex';
                    }
                });

                img.addEventListener('load', function() {
                    this.style.display = 'block';
                    const placeholder = this.nextElementSibling;
                    if (placeholder && placeholder.classList.contains('product-thumbnail-placeholder')) {
                        placeholder.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection
