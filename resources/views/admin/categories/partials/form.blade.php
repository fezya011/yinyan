{{-- admin/categories/partials/form.blade.php --}}
<form method="POST" action="{{ $action }}" id="categoryForm">
    @csrf
    @if($method === 'PUT' || $method === 'PATCH')
        @method($method)
    @endif

    <div class="form-section-title">Основная информация</div>

    <div class="form-group">
        <label class="form-label" for="name">Название <span style="color: #999;">*</span></label>
        <input class="form-control" id="name" type="text" name="name"
               value="{{ old('name', $category?->name ?? '') }}" required
               placeholder="Например: Лапша" oninput="updatePreview()">
        @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="form-grid-2 mb-4">
        <div class="form-group">
            <label class="form-label" for="slug">URL-адрес (Slug)</label>
            <input class="form-control" id="slug" type="text" name="slug"
                   value="{{ old('slug', $category?->slug ?? '') }}"
                   placeholder="lapscha" oninput="updatePreview()">
            <span class="text-xs text-muted">Оставьте пустым для автогенерации</span>
            @error('slug')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="sort_order">Порядок сортировки</label>
            <input class="form-control" id="sort_order" type="number" name="sort_order"
                   value="{{ old('sort_order', $category?->sort_order ?? 0) }}" min="0">
            @error('sort_order')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-section-title">Визуальное оформление</div>

    <div class="form-grid-2 mb-4">
        <div class="form-group">
            <label class="form-label" for="icon">Иконка (эмодзи)</label>
            <input class="form-control" id="icon" type="text" name="icon"
                   value="{{ old('icon', $category?->icon ?? '📁') }}"
                   placeholder="🍜" oninput="updatePreview()">
            @error('icon')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="tag_prefix">Префикс тега</label>
            <input class="form-control" id="tag_prefix" type="text" name="tag_prefix"
                   value="{{ old('tag_prefix', $category?->tag_prefix ?? '') }}"
                   placeholder="Лапша · Стакан" oninput="updatePreview()">
            @error('tag_prefix')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="form-group mb-4">
        <label class="form-label" for="description">Описание</label>
        <textarea class="form-control" id="description" name="description" rows="3"
                  placeholder="Краткое описание категории" oninput="updatePreview()">{{ old('description', $category?->description ?? '') }}</textarea>
        @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
    </div>

    <div class="form-section-title">Настройки</div>

    <div class="checkbox-group mb-4">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" id="is_active"
               {{ old('is_active', $category?->is_active ?? true) ? 'checked' : '' }}
               onchange="updatePreview()">
        <label for="is_active">Категория активна</label>
    </div>

    <div class="flex gap-3" style="padding-top: 8px; border-top: 1px solid rgba(26, 26, 26, 0.06);">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            {{ $buttonText }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Отмена</a>
    </div>
</form>
