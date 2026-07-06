{{-- admin/products/partials/filters.blade.php --}}
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
