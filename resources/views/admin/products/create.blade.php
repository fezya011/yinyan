{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Создание товара')
@section('page-title', 'Создание товара')
@section('sub-title', 'новый')

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
            position: relative;
            background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
        }

        .preview-card {
            background: #FFFFFF;
            border: 1px solid rgba(26, 26, 26, 0.06);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .preview-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            border-color: rgba(26, 26, 26, 0.12);
        }

        .preview-card-image {
            width: 100%;
            height: 220px;
            background: #FAFAFA;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .preview-card-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 20px;
            transition: transform 0.4s ease;
        }

        .preview-card:hover .preview-card-image img {
            transform: scale(1.05);
        }

        .preview-card-image .emoji-placeholder {
            font-size: 80px;
            line-height: 1;
            opacity: 0.6;
        }

        .preview-card-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #1A1A1A;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            font-size: 8px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 10px;
            z-index: 1;
        }

        .preview-card-status {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 8px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            font-weight: 600;
            z-index: 1;
            font-family: 'Inter', sans-serif;
        }

        .preview-card-status.active {
            background: #1A1A1A;
            color: #FFFFFF;
        }

        .preview-card-status.inactive {
            background: #E5E5E5;
            color: #999;
        }

        .preview-card-status.out_of_stock {
            background: #FAFAFA;
            color: #999;
            border: 1px solid rgba(26, 26, 26, 0.1);
        }

        .preview-card-info {
            padding: 16px;
        }

        .preview-card-name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: #1A1A1A;
            margin-bottom: 6px;
            line-height: 1.3;
            letter-spacing: -0.2px;
        }

        .preview-card-desc {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: rgba(26, 26, 26, 0.4);
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .preview-card-price {
            display: inline-block;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            color: #1A1A1A;
            background: rgba(26, 26, 26, 0.06);
            padding: 6px 14px;
        }

        .preview-card-featured {
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
            color: #B8860B;
            font-size: 16px;
            z-index: 1;
            filter: drop-shadow(0 2px 4px rgba(184, 134, 11, 0.3));
        }

        .preview-indicators {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: rgba(26, 26, 26, 0.04);
            margin-top: 16px;
        }

        .preview-indicator {
            padding: 10px 14px;
            background: #FFFFFF;
            text-align: center;
        }

        .preview-indicator .value {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 13px;
            color: #1A1A1A;
            letter-spacing: -0.3px;
        }

        .preview-indicator .label {
            font-size: 7px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(26, 26, 26, 0.3);
            margin-top: 2px;
        }

        .preview-accent-bar {
            height: 3px;
            width: 100%;
            transition: background-color 0.3s ease;
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

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .form-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        @media (max-width: 768px) {
            .form-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .form-grid-2,
            .form-grid-3,
            .form-grid-4 {
                grid-template-columns: 1fr;
            }
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

        .text-muted {
            color: #94a3b8;
        }
        .text-xs {
            font-size: 11px;
        }
        .text-red-500 {
            color: #ef4444;
        }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mt-2 { margin-top: 8px; }
        .gap-3 { gap: 12px; }
        .flex { display: flex; }
        .flex-wrap { flex-wrap: wrap; }
        .items-center { align-items: center; }
    </style>
@endpush

@section('content')
    <div class="edit-layout">
        {{-- ФОРМА --}}
        <div class="form-card">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" id="productForm">
                @csrf

                {{-- ===== 1. ОСНОВНАЯ ИНФОРМАЦИЯ ===== --}}
                <div class="form-section-title">Основная информация</div>

                <div class="form-group mb-3">
                    <label class="form-label" for="name">Название <span style="color: #999;">*</span></label>
                    <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required oninput="updatePreview()" placeholder="Например: Лапша в стакане">
                    @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="category_id">Категория <span style="color: #999;">*</span></label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="">Выберите категорию</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="barcode">Штрих-код</label>
                        <input class="form-control" id="barcode" type="text" name="barcode" value="{{ old('barcode') }}" placeholder="4601234567890">
                        @error('barcode')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="3" oninput="updatePreview()" placeholder="Подробное описание товара">{{ old('description') }}</textarea>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="card_subtitle">Подзаголовок (для карточки)</label>
                    <input class="form-control" id="card_subtitle" type="text" name="card_subtitle" value="{{ old('card_subtitle') }}" placeholder="Говядина или курица. Удобная упаковка." oninput="updatePreview()">
                </div>

                {{-- ===== 2. ХАРАКТЕРИСТИКИ ===== --}}
                <div class="form-section-title">Характеристики</div>

                <div class="form-grid-3 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="packaging_type">Тип упаковки</label>
                        <input class="form-control" id="packaging_type" type="text" name="packaging_type" value="{{ old('packaging_type') }}" placeholder="Стакан">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="weight_grams">Вес нетто (грамм)</label>
                        <input class="form-control" id="weight_grams" type="number" step="0.01" name="weight_grams" value="{{ old('weight_grams') }}" placeholder="85" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="shelf_life_days">Срок годности (дней)</label>
                        <input class="form-control" id="shelf_life_days" type="number" name="shelf_life_days" value="{{ old('shelf_life_days') }}" placeholder="365" oninput="updatePreview()">
                    </div>
                </div>

                <div class="form-grid-3 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="pieces_per_box">Вложимость (шт в коробке)</label>
                        <input class="form-control" id="pieces_per_box" type="number" name="pieces_per_box" value="{{ old('pieces_per_box') }}" placeholder="12" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="boxes_per_pallet">Вместимость паллеты (шт)</label>
                        <input class="form-control" id="boxes_per_pallet" type="number" name="boxes_per_pallet" value="{{ old('boxes_per_pallet') }}" placeholder="100" oninput="updatePreview()">
                    </div>
                </div>

                {{-- ===== 3. ЛОГИСТИКА ===== --}}
                <div class="form-section-title">Логистика</div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="box_volume">Объём коробки (м³)</label>
                        <input class="form-control" id="box_volume" type="number" step="0.001" name="box_volume" value="{{ old('box_volume') }}" placeholder="0.012">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="box_weight_kg">Вес коробки (кг)</label>
                        <input class="form-control" id="box_weight_kg" type="number" step="0.01" name="box_weight_kg" value="{{ old('box_weight_kg') }}" placeholder="0.5">
                    </div>
                </div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="vat_rate">Ставка НДС (%)</label>
                        <input class="form-control" id="vat_rate" type="number" step="0.01" name="vat_rate" value="{{ old('vat_rate', 20) }}" placeholder="20">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tnved_code">Код ТНВЭД</label>
                        <input class="form-control" id="tnved_code" type="text" name="tnved_code" value="{{ old('tnved_code') }}" placeholder="1902.30.1000">
                    </div>
                </div>

                {{-- ===== 4. ЦЕНЫ ===== --}}
                <div class="form-section-title">Цены</div>

                <div class="form-grid-4 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="wholesale_price">Оптовая цена (₽)</label>
                        <input class="form-control" id="wholesale_price" type="number" step="0.01" name="wholesale_price" value="{{ old('wholesale_price') }}" placeholder="45.00" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="retail_price">Цена для сетей (₽)</label>
                        <input class="form-control" id="retail_price" type="number" step="0.01" name="retail_price" value="{{ old('retail_price') }}" placeholder="65.00">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="distributor_price">Цена дистрибьютор (₽)</label>
                        <input class="form-control" id="distributor_price" type="number" step="0.01" name="distributor_price" value="{{ old('distributor_price') }}" placeholder="38.00">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cost_price">Себестоимость (₽)</label>
                        <input class="form-control" id="cost_price" type="number" step="0.01" name="cost_price" value="{{ old('cost_price') }}" placeholder="30.00">
                    </div>
                </div>

                <div class="form-grid-2 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="min_order_amount">Мин. заказ (₽)</label>
                        <input class="form-control" id="min_order_amount" type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', 100000) }}" placeholder="100000">
                    </div>

                </div>

                {{-- ===== 5. ВИЗУАЛЬНОЕ ОФОРМЛЕНИЕ ===== --}}
                <div class="form-section-title">Визуальное оформление</div>

                <div class="form-grid-3 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="emoji_icon">Emoji-иконка</label>
                        <input class="form-control" id="emoji_icon" type="text" name="emoji_icon" value="{{ old('emoji_icon', '🍜') }}" placeholder="🍜" oninput="updatePreview()" maxlength="2">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tag">Тег (Хит/Новинка)</label>
                        <input class="form-control" id="tag" type="text" name="tag" value="{{ old('tag', 'Хит продаж') }}" placeholder="Хит продаж" oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="accent_color">Цвет акцента</label>
                        <input class="form-control" id="accent_color" type="color" name="accent_color" value="{{ old('accent_color', '#83BF32') }}" oninput="updatePreview()" style="height: 42px; padding: 4px 8px;">
                    </div>
                </div>

                {{-- ===== 6. ИЗОБРАЖЕНИЯ ===== --}}
                <div class="form-section-title">Изображения</div>

                <div class="form-group mb-3">
                    <label class="form-label" for="main_image">Главное изображение</label>
                    <input class="form-control" id="main_image" type="file" name="main_image" accept="image/*" onchange="previewMainImage(event)">
                    <span class="text-xs text-muted">Рекомендуемый размер: 800x800px</span>
                    @error('main_image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="gallery">Галерея (несколько изображений)</label>
                    <input class="form-control" id="gallery" type="file" name="gallery[]" accept="image/*" multiple>
                    <span class="text-xs text-muted">Выберите несколько изображений</span>
                    @error('gallery.*')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                {{-- ===== 7. СТАТУСЫ И НАСТРОЙКИ ===== --}}
                <div class="form-section-title">Статус и настройки</div>

                <div class="form-grid-3 mb-4">
                    <div class="form-group">
                        <label class="form-label" for="status">Статус <span style="color: #999;">*</span></label>
                        <select class="form-control" id="status" name="status" required onchange="updatePreview()">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Активен</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Неактивен</option>
                            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Нет в наличии</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sort_order">Порядок сортировки</label>
                        <input class="form-control" id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    </div>

                    <div class="form-group" style="display: flex; align-items: center; padding-top: 24px;">
                        <div class="checkbox-group" style="padding: 0;">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured') ? 'checked' : '' }} onchange="updatePreview()">
                            <label for="is_featured">В избранное</label>
                        </div>
                    </div>
                </div>

                {{-- ===== 8. СЕРТИФИКАЦИЯ ===== --}}
                <div class="form-section-title">Сертификация</div>

                <div class="form-grid-2 mb-4">
                    <div class="checkbox-group">
                        <input type="hidden" name="has_eac" value="0">
                        <input type="checkbox" name="has_eac" value="1" id="has_eac" {{ old('has_eac', true) ? 'checked' : '' }}>
                        <label for="has_eac">Сертификат ЕАС</label>
                    </div>

                    <div class="checkbox-group">
                        <input type="hidden" name="has_honest_sign" value="0">
                        <input type="checkbox" name="has_honest_sign" value="1" id="has_honest_sign" {{ old('has_honest_sign', true) ? 'checked' : '' }}>
                        <label for="has_honest_sign">Честный знак</label>
                    </div>
                </div>

                {{-- ===== 9. SEO ===== --}}
                <div class="form-section-title">SEO</div>

                <div class="form-group mb-3">
                    <label class="form-label" for="meta_title">Meta Title</label>
                    <input class="form-control" id="meta_title" type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="SEO заголовок">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="2" placeholder="Краткое описание для поисковиков">{{ old('meta_description') }}</textarea>
                </div>

                {{-- ===== 10. КОММЕНТАРИЙ ===== --}}
                <div class="form-section-title">Дополнительно</div>

                <div class="form-group mb-4">
                    <label class="form-label" for="comment">Комментарий (внутренний)</label>
                    <textarea class="form-control" id="comment" name="comment" rows="2" placeholder="Внутренний комментарий">{{ old('comment') }}</textarea>
                </div>

                {{-- ===== КНОПКИ ===== --}}
                <div class="flex gap-3" style="padding-top: 8px; border-top: 1px solid rgba(26, 26, 26, 0.06);">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Сохранить товар
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Отмена</a>
                </div>
            </form>
        </div>

        {{-- ===== ПРЕВЬЮ ===== --}}
        <div class="preview-panel" id="previewPanel">
            <div class="preview-panel-header">
                <span class="dot"></span>
                <span class="title">Предпросмотр карточки</span>
            </div>
            <div class="preview-panel-body">
                <div class="preview-card" id="previewCard">
                    <div class="preview-accent-bar" id="previewAccentBar" style="background-color: #83BF32;"></div>

                    <div class="preview-card-image">
                        <span class="preview-card-featured" id="previewFeatured" style="display: none;">⭐</span>
                        <span class="preview-card-tag" id="previewTag">Хит продаж</span>
                        <span class="preview-card-status active" id="previewStatus">Активен</span>
                        <span class="emoji-placeholder" id="previewEmoji">🍜</span>
                        <img src="" alt="Превью" id="previewImage" style="display: none;" onerror="this.style.display='none'; document.getElementById('previewEmoji').style.display='block';">
                    </div>

                    <div class="preview-card-info">
                        <div class="preview-card-name" id="previewName">Название товара</div>
                        <div class="preview-card-desc" id="previewDesc">Описание товара</div>
                        <span class="preview-card-price" id="previewPrice">от 0 ₽ / шт</span>
                    </div>
                </div>

                <div class="preview-indicators">
                    <div class="preview-indicator">
                        <div class="value" id="previewWeight">—</div>
                        <div class="label">Вес</div>
                    </div>
                    <div class="preview-indicator">
                        <div class="value" id="previewPieces">—</div>
                        <div class="label">В коробке</div>
                    </div>
                    <div class="preview-indicator">
                        <div class="value" id="previewShelf">—</div>
                        <div class="label">Срок годности</div>
                    </div>
                    <div class="preview-indicator">
                        <div class="value" id="previewBoxes">—</div>
                        <div class="label">На паллете</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="hanzi-decor md rotate-n8" style="top: 3%; right: 2%; opacity: 0.02 !important;">新</span>
    <span class="hanzi-decor sm rotate-10" style="bottom: 3%; left: 2%; opacity: 0.02 !important;">建</span>

    @push('scripts')
        <script>
            function previewMainImage(event) {
                const file = event.target.files[0];
                const previewImg = document.getElementById('previewImage');
                const previewEmoji = document.getElementById('previewEmoji');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (previewImg) {
                            previewImg.src = e.target.result;
                            previewImg.style.display = 'block';
                            previewImg.onerror = null;
                        }
                        if (previewEmoji) {
                            previewEmoji.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (previewImg) {
                        previewImg.src = '';
                        previewImg.style.display = 'none';
                    }
                    if (previewEmoji) {
                        previewEmoji.style.display = 'block';
                    }
                }
            }

            function updatePreview() {
                const name = document.getElementById('name')?.value || 'Название товара';
                const tag = document.getElementById('tag')?.value || 'Тег';
                const emoji = document.getElementById('emoji_icon')?.value || '🍜';
                const subtitle = document.getElementById('card_subtitle')?.value || document.getElementById('description')?.value?.substring(0, 80) || 'Описание товара';
                const priceDisplay = document.getElementById('price_display')?.value;
                const wholesalePrice = document.getElementById('wholesale_price')?.value;
                const status = document.getElementById('status')?.value || 'active';
                const isFeatured = document.getElementById('is_featured')?.checked;
                const accentColor = document.getElementById('accent_color')?.value || '#83BF32';

                const previewName = document.getElementById('previewName');
                const previewTag = document.getElementById('previewTag');
                const previewDesc = document.getElementById('previewDesc');
                const previewPrice = document.getElementById('previewPrice');
                const previewEmoji = document.getElementById('previewEmoji');
                const previewStatus = document.getElementById('previewStatus');
                const previewFeatured = document.getElementById('previewFeatured');
                const previewAccentBar = document.getElementById('previewAccentBar');

                if (previewName) previewName.textContent = name;
                if (previewTag) previewTag.textContent = tag;
                if (previewDesc) previewDesc.textContent = subtitle;
                if (previewAccentBar) previewAccentBar.style.backgroundColor = accentColor;

                const previewImg = document.getElementById('previewImage');
                if (previewEmoji && (!previewImg || previewImg.style.display === 'none')) {
                    previewEmoji.textContent = emoji;
                }

                if (previewPrice) {
                    if (priceDisplay) {
                        previewPrice.textContent = priceDisplay;
                    } else if (wholesalePrice) {
                        previewPrice.textContent = 'от ' + new Intl.NumberFormat('ru-RU').format(wholesalePrice) + ' ₽ / шт';
                    } else {
                        previewPrice.textContent = 'от 0 ₽ / шт';
                    }
                }

                if (previewStatus) {
                    previewStatus.className = 'preview-card-status ' + status;
                    const statusLabels = {
                        'active': 'Активен',
                        'inactive': 'Неактивен',
                        'out_of_stock': 'Нет в наличии'
                    };
                    previewStatus.textContent = statusLabels[status] || status;
                }

                if (previewFeatured) {
                    previewFeatured.style.display = isFeatured ? 'block' : 'none';
                }

                const weight = document.getElementById('weight_grams')?.value;
                const pieces = document.getElementById('pieces_per_box')?.value;
                const shelf = document.getElementById('shelf_life_days')?.value;
                const boxes = document.getElementById('boxes_per_pallet')?.value;

                const previewWeight = document.getElementById('previewWeight');
                const previewPieces = document.getElementById('previewPieces');
                const previewShelf = document.getElementById('previewShelf');
                const previewBoxes = document.getElementById('previewBoxes');

                if (previewWeight) previewWeight.textContent = weight ? weight + ' г' : '—';
                if (previewPieces) previewPieces.textContent = pieces ? pieces + ' шт' : '—';
                if (previewShelf) previewShelf.textContent = shelf ? shelf + ' дн' : '—';
                if (previewBoxes) previewBoxes.textContent = boxes || '—';
            }

            document.addEventListener('DOMContentLoaded', function() {
                updatePreview();
            });
        </script>
    @endpush
@endsection
