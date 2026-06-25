{{-- resources/views/admin/categories/index.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Категории')
@section('page-title', 'Категории')
@section('sub-title', 'структура')

@push('styles')
    <style>
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1px;
            background: rgba(26, 26, 26, 0.04);
            margin-bottom: 24px;
        }

        @media (max-width: 640px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }
        }

        .category-card {
            background: #FFFFFF;
            padding: 24px;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 16px;
            overflow: hidden;
            cursor: pointer;
        }

        .category-card:hover {
            background: #FAFAFA;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        }

        .category-card::after {
            content: 'Редактировать →';
            position: absolute;
            bottom: 24px;
            right: 24px;
            font-family: 'Inter', sans-serif;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 1;
        }

        .category-card:hover::after {
            color: rgba(26, 26, 26, 0.5);
        }

        .category-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .category-icon {
            width: 52px;
            height: 52px;
            border-radius: 8px;
            background: #FAFAFA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            border: 1px solid rgba(26, 26, 26, 0.04);
        }

        .category-card:hover .category-icon {
            background: #1A1A1A;
            transform: scale(1.05);
        }

        .category-card:hover .category-icon span {
            filter: brightness(1.2);
        }

        .category-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 6px;
            position: relative;
            z-index: 2;
        }

        .category-status-dot.active {
            background: #1A1A1A;
            box-shadow: 0 0 0 4px rgba(26, 26, 26, 0.1);
        }

        .category-status-dot.inactive {
            background: #CCCCCC;
        }

        .category-info {
            flex: 1;
        }

        .category-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #1A1A1A;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .category-slug {
            font-size: 11px;
            color: #999;
            font-family: 'Inter', sans-serif;
            background: #F5F5F5;
            padding: 2px 8px;
            border-radius: 3px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .category-stats {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .category-stat {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #777;
        }

        .category-stat .value {
            font-weight: 700;
            color: #1A1A1A;
            font-size: 16px;
            letter-spacing: -0.3px;
        }

        .category-stat .label {
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.35);
        }

        .category-actions {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(26, 26, 26, 0.04);
            opacity: 0;
            transition: opacity 0.3s ease;
            position: relative;
            z-index: 2;
            pointer-events: none;
        }

        .category-card:hover .category-actions {
            opacity: 1;
            pointer-events: all;
        }

        .category-actions .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid rgba(26, 26, 26, 0.08);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #777;
            font-size: 13px;
            text-decoration: none;
        }

        .category-actions .btn-action:hover {
            background: #1A1A1A;
            color: #FFFFFF;
            border-color: #1A1A1A;
        }

        .category-actions .btn-action.delete:hover {
            background: #CC5555;
            border-color: #CC5555;
            color: #FFFFFF;
        }

        .category-actions .btn-action:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .category-actions .btn-action:disabled:hover {
            background: transparent;
            color: #777;
            border-color: rgba(26, 26, 26, 0.08);
        }

        /* Мини-превью товаров категории */
        .category-products-preview {
            display: flex;
            gap: 4px;
            margin-top: 4px;
            position: relative;
            z-index: 2;
        }

        .category-products-preview .mini-thumb {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid rgba(26, 26, 26, 0.06);
            background: #FAFAFA;
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .category-products-preview .mini-thumb:hover {
            transform: scale(1.15);
            z-index: 10;
            position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .category-products-preview .mini-thumb-placeholder {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            border: 1px solid rgba(26, 26, 26, 0.06);
            background: #FAFAFA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            opacity: 0.4;
        }

        .more-products {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            background: #1A1A1A;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .more-products:hover {
            background: #000;
            transform: scale(1.1);
        }
    </style>
@endpush

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-muted">Управление категориями товаров</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Добавить категорию
        </a>
    </div>

    {{-- Сетка категорий --}}
    <div class="categories-grid">
        @forelse($categories as $category)
            @php
                // Получаем до 3 товаров категории для превью
                $categoryProducts = $category->products()->take(3)->get();
            @endphp
            <div class="category-card" onclick="window.location='{{ route('admin.categories.edit', $category) }}'" title="Нажмите для редактирования">
                {{-- Заголовок карточки --}}
                <div class="category-card-header">
                    <div class="category-icon">
                        <span>{{ $category->icon ?? '📁' }}</span>
                    </div>
                    <div class="category-status-dot {{ $category->is_active ? 'active' : 'inactive' }}"
                         title="{{ $category->is_active ? 'Активна' : 'Неактивна' }}"
                         onclick="event.stopPropagation();">
                    </div>
                </div>

                {{-- Информация --}}
                <div class="category-info">
                    <div class="category-name">{{ $category->name }}</div>
                    <span class="category-slug">{{ $category->slug }}</span>

                    {{-- Мини-превью товаров --}}
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
                </div>

                {{-- Статистика --}}
                <div class="category-stats">
                    <div class="category-stat">
                        <span class="value">{{ $category->products_count }}</span>
                        <span class="label">товаров</span>
                    </div>
                    @if($category->products_count > 0)
                        <div class="category-stat">
                            <span class="value">
                                {{ $category->products()->where('status', 'active')->count() }}
                            </span>
                            <span class="label">активных</span>
                        </div>
                    @endif
                </div>

                {{-- Действия --}}
                <div class="category-actions" onclick="event.stopPropagation();">
                    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="btn-action"
                                title="{{ $category->is_active ? 'Деактивировать' : 'Активировать' }}">
                            <i class="fas {{ $category->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                        </button>
                    </form>

                    @can('manage-categories')
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="btn-action"
                           title="Редактировать">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn-action delete"
                                    title="Удалить"
                                {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #FFFFFF;">
                <div style="font-family: 'Noto Serif SC', 'SimSun', serif; font-size: 48px; font-weight: 900; opacity: 0.08; margin-bottom: 16px;">空</div>
                <p style="font-size: 12px; letter-spacing: 2px; text-transform: uppercase; color: rgba(26, 26, 26, 0.3);">Категории не найдены</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-4" style="display: inline-flex;">
                    <i class="fas fa-plus"></i>
                    Создать категорию
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor lg rotate-10" style="top: 5%; right: 2%; opacity: 0.02 !important;">类</span>
    <span class="hanzi-decor md rotate-n8" style="bottom: 5%; left: 2%; opacity: 0.02 !important;">目</span>
    <span class="hanzi-decor sm rotate-8" style="top: 40%; left: 1%; opacity: 0.015 !important;">分</span>
    <span class="hanzi-decor sm rotate-n5" style="bottom: 40%; right: 1%; opacity: 0.015 !important;">组</span>

    @push('scripts')
        <script>
            // Обработка ошибок загрузки миниатюр
            document.querySelectorAll('.mini-thumb').forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = this.nextElementSibling;
                    if (placeholder && placeholder.classList.contains('mini-thumb-placeholder')) {
                        placeholder.style.display = 'flex';
                    }
                });

                img.addEventListener('load', function() {
                    this.style.display = 'block';
                    const placeholder = this.nextElementSibling;
                    if (placeholder && placeholder.classList.contains('mini-thumb-placeholder')) {
                        placeholder.style.display = 'none';
                    }
                });
            });

            // Добавляем клавиатурную навигацию
            document.querySelectorAll('.category-card').forEach(card => {
                card.setAttribute('tabindex', '0');
                card.setAttribute('role', 'button');
                card.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        </script>
    @endpush
@endsection
