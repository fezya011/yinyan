{{-- resources/views/admin/categories/create.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Создание категории')
@section('page-title', 'Создание категории')
@section('sub-title', 'новая')

@push('styles')
    <style>
        .create-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .create-layout {
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
    </style>
@endpush

@section('content')
    <div class="create-layout">
        {{-- Форма --}}
        <div class="form-card">
            {{-- ВАЖНО: Убрал id="categoryForm" у формы, чтобы не было конфликтов --}}
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                <div class="form-section-title">Основная информация</div>

                <div class="form-group">
                    <label class="form-label" for="name">Название <span style="color: #999;">*</span></label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Например: Лапша" oninput="updatePreview()">
                    @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="slug">URL-адрес (Slug)</label>
                        <input class="form-control" id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="lapscha" oninput="updatePreview()">
                        <span class="text-xs text-muted">Оставьте пустым для автогенерации</span>
                        @error('slug')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Порядок сортировки</label>
                        <input class="form-control" id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                        @error('sort_order')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-section-title">Визуальное оформление</div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="icon">Иконка (эмодзи)</label>
                        {{-- Убрал maxlength="2" так как некоторые эмодзи занимают больше символов --}}
                        <input class="form-control" id="icon" type="text" name="icon" value="{{ old('icon', '📁') }}" placeholder="🍜" oninput="updatePreview()">
                        @error('icon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tag_prefix">Префикс тега</label>
                        <input class="form-control" id="tag_prefix" type="text" name="tag_prefix" value="{{ old('tag_prefix') }}" placeholder="Лапша · Стакан" oninput="updatePreview()">
                        @error('tag_prefix')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Краткое описание категории" oninput="updatePreview()">{{ old('description') }}</textarea>
                    @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="form-section-title">Настройки</div>

                <div class="checkbox-group mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }} onchange="updatePreview()">
                    <label for="is_active">Категория активна</label>
                </div>

                {{-- ВАЖНО: Кнопка отправки формы --}}
                <div class="flex gap-3" style="padding-top: 8px; border-top: 1px solid rgba(26, 26, 26, 0.06);">
                    <button type="submit" class="btn btn-primary" style="cursor: pointer;">
                        <i class="fas fa-save"></i>
                        Сохранить категорию
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
                        <div class="preview-icon" id="previewIcon">📁</div>
                        <div>
                            <div class="preview-name" id="previewName">Название категории</div>
                            <div class="preview-slug" id="previewSlug">slug</div>
                        </div>
                    </div>

                    <span class="preview-tag" id="previewTag">Префикс тега</span>

                    <div class="preview-desc" id="previewDesc">
                        Описание категории будет здесь
                    </div>

                    <div class="preview-status">
                        <span class="dot active" id="previewStatusDot"></span>
                        <span id="previewStatusText">Активна</span>
                    </div>

                    <div class="preview-stats">
                        <div class="preview-stat">
                            <div class="value">0</div>
                            <div class="label">Товаров</div>
                        </div>
                        <div class="preview-stat">
                            <div class="value">0</div>
                            <div class="label">Активных</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Декоративные иероглифы --}}
    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">新</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">类</span>

    @push('scripts')
        <script>
            function updatePreview() {
                const name = document.getElementById('name')?.value || 'Название категории';
                const slug = document.getElementById('slug')?.value || 'slug';
                const icon = document.getElementById('icon')?.value || '📁';
                const tag = document.getElementById('tag_prefix')?.value || 'Префикс тега';
                const desc = document.getElementById('description')?.value || 'Описание категории будет здесь';
                const isActive = document.getElementById('is_active')?.checked;

                const previewName = document.getElementById('previewName');
                const previewSlug = document.getElementById('previewSlug');
                const previewIcon = document.getElementById('previewIcon');
                const previewTag = document.getElementById('previewTag');
                const previewDesc = document.getElementById('previewDesc');
                const statusDot = document.getElementById('previewStatusDot');
                const statusText = document.getElementById('previewStatusText');

                if (previewName) previewName.textContent = name;
                if (previewSlug) previewSlug.textContent = slug;
                if (previewIcon) previewIcon.textContent = icon;
                if (previewTag) previewTag.textContent = tag || 'Префикс тега';
                if (previewDesc) previewDesc.textContent = desc || 'Описание категории будет здесь';

                // Статус
                if (statusDot && statusText) {
                    if (isActive) {
                        statusDot.className = 'dot active';
                        statusText.textContent = 'Активна';
                    } else {
                        statusDot.className = 'dot inactive';
                        statusText.textContent = 'Неактивна';
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                updatePreview();

                // Отладка: проверяем что форма существует и может отправляться
                const form = document.querySelector('form');
                if (form) {
                    console.log('Форма найдена, action:', form.action);

                    form.addEventListener('submit', function(e) {
                        console.log('Форма отправляется...');
                        // Если есть ошибки, можно раскомментировать чтобы увидеть данные
                        // e.preventDefault();
                        // console.log('Данные формы:', new FormData(form));
                        // return false;
                    });
                } else {
                    console.error('Форма не найдена!');
                }
            });
        </script>
    @endpush
@endsection
