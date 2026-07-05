{{-- pages/catalog/partials/filters.blade.php --}}
<div class="filters-bar" id="filtersBar">
    {{-- Категории --}}
    <div class="filter-group">
        <span class="filter-group-label">Категория</span>
        <button class="filter-btn {{ !request('category') || request('category') === 'all' ? 'active' : '' }}"
                data-filter="category" data-value="all">Все</button>
        @foreach($categories as $category)
            <button class="filter-btn {{ request('category') === $category->slug ? 'active' : '' }}"
                    data-filter="category" data-value="{{ $category->slug }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div class="filter-divider"></div>

    {{-- Упаковка --}}
    <div class="filter-group">
        <span class="filter-group-label">Упаковка</span>
        <button class="filter-btn {{ !request('pack') || request('pack') === 'all-pack' ? 'active' : '' }}"
                data-filter="pack" data-value="all-pack">Все</button>
        @foreach($packagingTypes as $type)
            <button class="filter-btn {{ request('pack') === $type ? 'active' : '' }}"
                    data-filter="pack" data-value="{{ $type }}">
                {{ $type }}
            </button>
        @endforeach
    </div>

    <div class="filter-divider"></div>

    {{-- Сортировка --}}
    <div class="filter-group">
        <span class="filter-group-label">Сортировка</span>
        <div class="custom-select-wrap">
            <select class="filter-btn" id="sortOrder">
                <option value="default" {{ !request('sort') || request('sort') === 'default' ? 'selected' : '' }}>По умолчанию</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Название: А → Я</option>
                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Популярные</option>
                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Новинки</option>
            </select>
        </div>
    </div>
</div>

{{-- Расширенные фильтры --}}
<button class="toggle-advanced {{ request('weight_from') || request('weight_to') || request('price_from') || request('price_to') || request('shelf_life') ? 'expanded' : '' }}"
        id="toggleAdvanced">
    Расширенные фильтры <span class="arrow">▼</span>
</button>

<div class="advanced-filters {{ request('weight_from') || request('weight_to') || request('price_from') || request('price_to') || request('shelf_life') ? 'visible' : '' }}"
     id="advancedFilters">
    <div class="filters-bar" style="border-bottom:none;padding-bottom:0;">
        {{-- Цена --}}
        <div class="filter-group">
            <span class="filter-group-label">Цена (₽)</span>
            <div class="filter-range">
                <input type="number" id="priceFrom" placeholder="От" value="{{ request('price_from') }}">
                <span>—</span>
                <input type="number" id="priceTo" placeholder="До" value="{{ request('price_to') }}">
            </div>
        </div>

        <div class="filter-divider"></div>

        {{-- Вес --}}
        <div class="filter-group">
            <span class="filter-group-label">Вес (г)</span>
            <div class="filter-range">
                <input type="number" id="weightFrom" placeholder="От" value="{{ request('weight_from') }}">
                <span>—</span>
                <input type="number" id="weightTo" placeholder="До" value="{{ request('weight_to') }}">
            </div>
        </div>

        <div class="filter-divider"></div>

        {{-- Срок годности --}}
        <div class="filter-group">
            <span class="filter-group-label">Срок годности</span>
            <div class="custom-select-wrap">
                <select class="filter-btn" id="shelfLife">
                    <option value="">Любой</option>
                    <option value="90" {{ request('shelf_life') == '90' ? 'selected' : '' }}>До 90 дней</option>
                    <option value="180" {{ request('shelf_life') == '180' ? 'selected' : '' }}>До 180 дней</option>
                    <option value="365" {{ request('shelf_life') == '365' ? 'selected' : '' }}>До 365 дней</option>
                    <option value="366" {{ request('shelf_life') == '366' ? 'selected' : '' }}>Более 365 дней</option>
                </select>
            </div>
        </div>
    </div>
</div>
