{{-- resources/views/admin/categories/edit.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Редактирование категории')
@section('page-title', 'Редактирование категории')
@section('sub-title', 'изменение')

@push('styles')
    <style>
        .edit-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .edit-layout {
                grid-template-columns: 1fr;
            }
            .preview-panel {
                position: static !important;
                top: auto !important;
            }
        }

        .form-card {
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.06);
            padding: 24px;
        }

        .form-section-title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #1A1A1A;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(26, 26, 26, 0.06);
        }

        .preview-panel {
            position: sticky;
            top: 92px;
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.06);
            overflow: hidden;
        }

        .preview-panel-header {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(26, 26, 26, 0.06);
            background: #FAFAFA;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preview-panel-header .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #1A1A1A;
            animation: preview-pulse 2s infinite;
        }

        @keyframes preview-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .preview-panel-header .title {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #1A1A1A;
        }

        .preview-panel-body {
            padding: 20px;
            background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
        }

        .preview-card {
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.06);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .preview-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        }

        .preview-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .preview-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            background: #FAFAFA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            border: 1px solid rgba(26, 26, 26, 0.04);
            transition: all 0.3s ease;
        }

        .preview-card:hover .preview-icon {
            background: #1A1A1A;
            transform: scale(1.05);
        }

        .preview-name {
            font-weight: 700;
            font-size: 16px;
            color: #1A1A1A;
            letter-spacing: -0.3px;
        }

        .preview-slug {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }

        .preview-tag {
            display: inline-block;
            background: #1A1A1A;
            color: #FFFFFF;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 10px;
            margin-bottom: 12px;
        }

        .preview-desc {
            font-size: 12px;
            color: #777;
            line-height: 1.5;
            margin-bottom: 16px;
        }

        .preview-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 600;
            color: #1A1A1A;
        }

        .preview-status .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .preview-status .dot.active {
            background: #1A1A1A;
        }

        .preview-status .dot.inactive {
            background: #CCC;
        }

        .preview-stats {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(26, 26, 26, 0.06);
        }

        .preview-stat {
            text-align: center;
            flex: 1;
        }

        .preview-stat .value {
            font-weight: 700;
            font-size: 14px;
            color: #1A1A1A;
        }

        .preview-stat .label {
            font-size: 7px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            margin-top: 2px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #1A1A1A;
            cursor: pointer;
        }

        .checkbox-group label {
            font-size: 12px;
            font-weight: 500;
            color: #1A1A1A;
            cursor: pointer;
            user-select: none;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        @media (max-width: 640px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        .current-products {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(26, 26, 26, 0.06);
        }

        .current-products .label {
            font-size: 9px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            margin-bottom: 8px;
        }

        .product-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .product-chip {
            font-size: 10px;
            font-weight: 500;
            color: #1A1A1A;
            background: #FAFAFA;
            border: 1px solid rgba(26, 26, 26, 0.06);
            padding: 4px 10px;
            border-radius: 100px;
            transition: all 0.2s ease;
        }

        .product-chip:hover {
            background: #1A1A1A;
            color: #FFFFFF;
            border-color: #1A1A1A;
        }
    </style>
@endpush

@section('content')
    <div class="edit-layout">
        {{-- Форма --}}
        <div class="form-card">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" id="categoryForm">
                @csrf
                @method('PUT')

                <div class="form-section-title">Основная информация</div>

                <div class="form-group">
                    <label class="form-label" for="name">Название <span style="color: #999;">*</span></label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required oninput="updatePreview()">
                    @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="slug">URL-адрес (Slug)</label>
                        <input class="form-control" id="slug" type="text" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="lapscha" oninput="updatePreview()">
                        @error('slug')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Порядок сортировки</label>
                        <input class="form-control" id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                        @error('sort_order')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-section-title">Визуальное оформление</div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="icon">Иконка (эмодзи)</label>
                        <input class="form-control" id="icon" type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="🍜" oninput="updatePreview()" maxlength="2">
                        @error('icon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tag_prefix">Префикс тега</label>
                        <input class="form-control" id="tag_prefix" type="text" name="tag_prefix" value="{{ old('tag_prefix', $category->tag_prefix) }}" placeholder="Лапша · Стакан" oninput="updatePreview()">
                        @error('tag_prefix')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="3" oninput="updatePreview()">{{ old('description', $category->description) }}</textarea>
                    @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="form-section-title">Настройки</div>

                <div class="checkbox-group mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $category->is_active) ? 'checked' : '' }} onchange="updatePreview()">
                    <label for="is_active">Категория активна</label>
                </div>

                <div class="flex gap-3" style="padding-top: 8px; border-top: 1px solid rgba(26, 26, 26, 0.06);">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Обновить категорию
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Отмена</a>
                </div>
            </form>
        </div>

        {{-- Превью --}}
        <div class="preview-panel">
            <div class="preview-panel-header">
                <span class="dot"></span>
                <span class="title">Предпросмотр карточки</span>
            </div>
            <div class="preview-panel-body">
                <div class="preview-card">
                    <div class="preview-card-header">
                        <div class="preview-icon" id="previewIcon">{{ $category->icon ?? '📁' }}</div>
                        <div>
                            <div class="preview-name" id="previewName">{{ $category->name }}</div>
                            <div class="preview-slug" id="previewSlug">{{ $category->slug }}</div>
                        </div>
                    </div>

                    <span class="preview-tag" id="previewTag">{{ $category->tag_prefix ?: 'Префикс тега' }}</span>

                    <div class="preview-desc" id="previewDesc">
                        {{ $category->description ?: 'Описание категории будет здесь' }}
                    </div>

                    <div class="preview-status">
                        <span class="dot {{ $category->is_active ? 'active' : 'inactive' }}" id="previewStatusDot"></span>
                        <span id="previewStatusText">{{ $category->is_active ? 'Активна' : 'Неактивна' }}</span>
                    </div>

                    <div class="preview-stats">
                        <div class="preview-stat">
                            <div class="value">{{ $category->products_count ?? 0 }}</div>
                            <div class="label">Товаров</div>
                        </div>
                        <div class="preview-stat">
                            <div class="value">{{ $category->products()->where('status', 'active')->count() }}</div>
                            <div class="label">Активных</div>
                        </div>
                    </div>

                    {{-- Товары категории --}}
                    @php
                        $catProducts = $category->products()->take(5)->get();
                    @endphp
                    @if($catProducts->count() > 0)
                        <div class="current-products">
                            <div class="label">Товары в категории</div>
                            <div class="product-chips">
                                @foreach($catProducts as $product)
                                    <a href="{{ route('admin.products.edit', $product) }}" class="product-chip">
                                        {{ $product->emoji_icon ?: '📦' }} {{ Str::limit($product->name, 20) }}
                                    </a>
                                @endforeach
                                @if($category->products_count > 5)
                                    <span class="product-chip" style="background: #1A1A1A; color: #FFF;">
                                        +{{ $category->products_count - 5 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">编</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">辑</span>

    @push('scripts')
        <script>
            function updatePreview() {
                const name = document.getElementById('name')?.value || 'Название категории';
                const slug = document.getElementById('slug')?.value || 'slug';
                const icon = document.getElementById('icon')?.value || '📁';
                const tag = document.getElementById('tag_prefix')?.value || 'Префикс тега';
                const desc = document.getElementById('description')?.value || 'Описание категории будет здесь';
                const isActive = document.getElementById('is_active')?.checked;

                document.getElementById('previewName').textContent = name;
                document.getElementById('previewSlug').textContent = slug;
                document.getElementById('previewIcon').textContent = icon;
                document.getElementById('previewTag').textContent = tag || 'Префикс тега';
                document.getElementById('previewDesc').textContent = desc || 'Описание категории будет здесь';

                // Статус
                const statusDot = document.getElementById('previewStatusDot');
                const statusText = document.getElementById('previewStatusText');
                if (isActive) {
                    statusDot.className = 'dot active';
                    statusText.textContent = 'Активна';
                } else {
                    statusDot.className = 'dot inactive';
                    statusText.textContent = 'Неактивна';
                }
            }

            document.addEventListener('DOMContentLoaded', updatePreview);
        </script>
    @endpush
@endsection
