{{-- admin/products/partials/form.blade.php --}}
{{-- 1. ОСНОВНАЯ ИНФОРМАЦИЯ --}}
<div class="form-section-title">Основная информация</div>

<div class="form-group mb-3">
    <label class="form-label" for="name">Название <span style="color: #999;">*</span></label>
    <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $product?->name ?? '') }}" required oninput="updatePreview()" placeholder="Например: Лапша в стакане">
    @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
</div>

<div class="form-grid-2 mb-4">
    <div class="form-group">
        <label class="form-label" for="category_id">Категория <span style="color: #999;">*</span></label>
        <select class="form-control" id="category_id" name="category_id" required>
            <option value="">Выберите категорию</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product?->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="barcode">Штрих-код</label>
        <input class="form-control" id="barcode" type="text" name="barcode" value="{{ old('barcode', $product?->barcode ?? '') }}" placeholder="4601234567890">
        @error('barcode')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>
</div>

<div class="form-group mb-4">
    <label class="form-label" for="description">Описание</label>
    <textarea class="form-control" id="description" name="description" rows="3" oninput="updatePreview()" placeholder="Подробное описание товара">{{ old('description', $product?->description ?? '') }}</textarea>
</div>

<div class="form-group mb-4">
    <label class="form-label" for="card_subtitle">Подзаголовок (для карточки)</label>
    <input class="form-control" id="card_subtitle" type="text" name="card_subtitle" value="{{ old('card_subtitle', $product?->card_subtitle ?? '') }}" placeholder="Говядина или курица. Удобная упаковка." oninput="updatePreview()">
</div>

{{-- 2. ХАРАКТЕРИСТИКИ --}}
<div class="form-section-title">Характеристики</div>

<div class="form-grid-3 mb-4">
    <div class="form-group">
        <label class="form-label" for="packaging_type">Тип упаковки</label>
        <input class="form-control" id="packaging_type" type="text" name="packaging_type" value="{{ old('packaging_type', $product?->packaging_type ?? '') }}" placeholder="Стакан">
    </div>

    <div class="form-group">
        <label class="form-label" for="weight_grams">Вес нетто (грамм)</label>
        <input class="form-control" id="weight_grams" type="number" step="0.01" name="weight_grams" value="{{ old('weight_grams', $product?->weight_grams ?? '') }}" placeholder="85" oninput="updatePreview()">
    </div>

    <div class="form-group">
        <label class="form-label" for="shelf_life_days">Срок годности (дней)</label>
        <input class="form-control" id="shelf_life_days" type="number" name="shelf_life_days" value="{{ old('shelf_life_days', $product?->shelf_life_days ?? '') }}" placeholder="365" oninput="updatePreview()">
    </div>
</div>

<div class="form-grid-3 mb-4">
    <div class="form-group">
        <label class="form-label" for="pieces_per_box">Вложимость (шт в коробке)</label>
        <input class="form-control" id="pieces_per_box" type="number" name="pieces_per_box" value="{{ old('pieces_per_box', $product?->pieces_per_box ?? '') }}" placeholder="12" oninput="updatePreview()">
    </div>

    <div class="form-group">
        <label class="form-label" for="boxes_per_pallet">Вместимость паллеты (шт)</label>
        <input class="form-control" id="boxes_per_pallet" type="number" name="boxes_per_pallet" value="{{ old('boxes_per_pallet', $product?->boxes_per_pallet ?? '') }}" placeholder="100" oninput="updatePreview()">
    </div>

</div>

{{-- 3. ЛОГИСТИКА --}}
<div class="form-section-title">Логистика</div>

<div class="form-grid-2 mb-4">
    <div class="form-group">
        <label class="form-label" for="box_volume">Объём коробки (м³)</label>
        <input class="form-control" id="box_volume" type="number" step="0.001" name="box_volume" value="{{ old('box_volume', $product?->box_volume ?? '') }}" placeholder="0.012">
    </div>

    <div class="form-group">
        <label class="form-label" for="box_weight_kg">Вес коробки (кг)</label>
        <input class="form-control" id="box_weight_kg" type="number" step="0.01" name="box_weight_kg" value="{{ old('box_weight_kg', $product?->box_weight_kg ?? '') }}" placeholder="0.5">
    </div>
</div>

<div class="form-grid-2 mb-4">
    <div class="form-group">
        <label class="form-label" for="vat_rate">Ставка НДС (%)</label>
        <input class="form-control" id="vat_rate" type="number" step="0.01" name="vat_rate" value="{{ old('vat_rate', $product?->vat_rate ?? 20) }}" placeholder="20">
    </div>

    <div class="form-group">
        <label class="form-label" for="tnved_code">Код ТНВЭД</label>
        <input class="form-control" id="tnved_code" type="text" name="tnved_code" value="{{ old('tnved_code', $product?->tnved_code ?? '') }}" placeholder="1902.30.1000">
    </div>
</div>

{{-- 4. ЦЕНЫ --}}
<div class="form-section-title">Цены</div>

<div class="form-grid-4 mb-4">
    <div class="form-group">
        <label class="form-label" for="wholesale_price">Оптовая цена (₽)</label>
        <input class="form-control" id="wholesale_price" type="number" step="0.01" name="wholesale_price" value="{{ old('wholesale_price', $product?->wholesale_price ?? '') }}" placeholder="45.00" oninput="updatePreview()">
    </div>

    <div class="form-group">
        <label class="form-label" for="retail_price">Цена для сетей (₽)</label>
        <input class="form-control" id="retail_price" type="number" step="0.01" name="retail_price" value="{{ old('retail_price', $product?->retail_price ?? '') }}" placeholder="65.00">
    </div>

    <div class="form-group">
        <label class="form-label" for="distributor_price">Цена дистрибьютор (₽)</label>
        <input class="form-control" id="distributor_price" type="number" step="0.01" name="distributor_price" value="{{ old('distributor_price', $product?->distributor_price ?? '') }}" placeholder="38.00">
    </div>

    <div class="form-group">
        <label class="form-label" for="cost_price">Себестоимость (₽)</label>
        <input class="form-control" id="cost_price" type="number" step="0.01" name="cost_price" value="{{ old('cost_price', $product?->cost_price ?? '') }}" placeholder="30.00">
    </div>
</div>

<div class="form-grid-2 mb-4">
    <div class="form-group">
        <label class="form-label" for="min_order_amount">Мин. заказ (₽)</label>
        <input class="form-control" id="min_order_amount" type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $product?->min_order_amount ?? 100000) }}" placeholder="100000">
    </div>
</div>

{{-- 5. ВИЗУАЛЬНОЕ ОФОРМЛЕНИЕ --}}
<div class="form-section-title">Визуальное оформление</div>

<div class="form-grid-3 mb-4">
    <div class="form-group">
        <label class="form-label" for="tag">Тег (Хит/Новинка)</label>
        <input class="form-control" id="tag" type="text" name="tag" value="{{ old('tag', $product?->tag ?? 'Хит продаж') }}" placeholder="Хит продаж" oninput="updatePreview()">
    </div>

    <div class="form-group">
        <label class="form-label" for="accent_color">Цвет акцента</label>
        <input class="form-control" id="accent_color" type="color" name="accent_color" value="{{ old('accent_color', $product?->accent_color ?? '#83BF32') }}" oninput="updatePreview()" style="height: 42px; padding: 4px 8px;">
    </div>
</div>

{{-- 6. ИЗОБРАЖЕНИЯ --}}
<div class="form-section-title">Изображения</div>

@if($product && $product->main_image)
    <div class="form-group mb-3">
        <label class="form-label">Текущее главное изображение</label>
        <div>
            <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" style="max-width: 150px; max-height: 150px; border: 1px solid rgba(26, 26, 26, 0.06); border-radius: 8px; object-fit: cover;">
        </div>
    </div>
@endif

<div class="form-group mb-3">
    <label class="form-label" for="main_image">{{ $product ? 'Заменить' : '' }} Главное изображение</label>
    <input class="form-control" id="main_image" type="file" name="main_image" accept="image/*" onchange="previewMainImage(event)">
    <span class="text-xs text-muted">{{ $product ? 'Оставьте пустым, чтобы не менять' : 'Рекомендуемый размер: 800x800px' }}</span>
    @error('main_image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
</div>

@if($product && $product->gallery)
    <div class="form-group mb-3">
        <label class="form-label">Текущая галерея</label>
        <div class="current-gallery">
            @foreach($product->gallery as $image)
                <img src="{{ asset('storage/' . $image) }}" alt="Gallery">
            @endforeach
        </div>
    </div>
@endif

<div class="form-group mb-4">
    <label class="form-label" for="gallery">{{ $product ? 'Заменить' : '' }} Галерея</label>
    <input class="form-control" id="gallery" type="file" name="gallery[]" accept="image/*" multiple>
    <span class="text-xs text-muted">{{ $product ? 'Оставьте пустым, чтобы не менять' : 'Выберите несколько изображений' }}</span>
    @error('gallery.*')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
</div>

{{-- 7. СТАТУСЫ И НАСТРОЙКИ --}}
<div class="form-section-title">Статус и настройки</div>

<div class="form-grid-3 mb-4">
    <div class="form-group">
        <label class="form-label" for="status">Статус <span style="color: #999;">*</span></label>
        <select class="form-control" id="status" name="status" required onchange="updatePreview()">
            <option value="active" {{ old('status', $product?->status ?? 'active') == 'active' ? 'selected' : '' }}>Активен</option>
            <option value="inactive" {{ old('status', $product?->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Неактивен</option>
            <option value="out_of_stock" {{ old('status', $product?->status ?? 'active') == 'out_of_stock' ? 'selected' : '' }}>Нет в наличии</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="sort_order">Порядок сортировки</label>
        <input class="form-control" id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $product?->sort_order ?? 0) }}" min="0">
    </div>

    <div class="form-group" style="display: flex; align-items: center; padding-top: 24px;">
        <div class="checkbox-group" style="padding: 0;">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product?->is_featured ?? false) ? 'checked' : '' }} onchange="updatePreview()">
            <label for="is_featured">В избранное</label>
        </div>
    </div>
</div>

{{-- 8. СЕРТИФИКАЦИЯ --}}
<div class="form-section-title">Сертификация</div>

<div class="form-grid-2 mb-4">
    <div class="checkbox-group">
        <input type="hidden" name="has_eac" value="0">
        <input type="checkbox" name="has_eac" value="1" id="has_eac" {{ old('has_eac', $product?->has_eac ?? true) ? 'checked' : '' }}>
        <label for="has_eac">Сертификат ЕАС</label>
    </div>

    <div class="checkbox-group">
        <input type="hidden" name="has_honest_sign" value="0">
        <input type="checkbox" name="has_honest_sign" value="1" id="has_honest_sign" {{ old('has_honest_sign', $product?->has_honest_sign ?? true) ? 'checked' : '' }}>
        <label for="has_honest_sign">Честный знак</label>
    </div>
</div>

{{-- 9. SEO --}}
<div class="form-section-title">SEO</div>

<div class="form-group mb-3">
    <label class="form-label" for="meta_title">Meta Title</label>
    <input class="form-control" id="meta_title" type="text" name="meta_title" value="{{ old('meta_title', $product?->meta_title ?? '') }}" placeholder="SEO заголовок">
</div>

<div class="form-group mb-4">
    <label class="form-label" for="meta_description">Meta Description</label>
    <textarea class="form-control" id="meta_description" name="meta_description" rows="2" placeholder="Краткое описание для поисковиков">{{ old('meta_description', $product?->meta_description ?? '') }}</textarea>
</div>

{{-- 10. КОММЕНТАРИЙ --}}
<div class="form-section-title">Дополнительно</div>

<div class="form-group mb-4">
    <label class="form-label" for="comment">Комментарий (внутренний)</label>
    <textarea class="form-control" id="comment" name="comment" rows="2" placeholder="Внутренний комментарий">{{ old('comment', $product?->comment ?? '') }}</textarea>
</div>

{{-- КНОПКИ --}}
<div class="flex gap-3" style="padding-top: 8px; border-top: 1px solid rgba(26, 26, 26, 0.06);">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i>
        {{ $product ? 'Обновить товар' : 'Сохранить товар' }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Отмена</a>
</div>
