{{-- admin/categories/components/category-card.blade.php --}}
<div class="category-card" onclick="window.location='{{ route('admin.categories.edit', $category) }}'" title="Нажмите для редактирования">
    <div class="category-card-header">
        <div class="category-icon">
            <span>{{ $category->icon ?? '📁' }}</span>
        </div>
        <div class="category-status-dot {{ $category->is_active ? 'active' : 'inactive' }}"
             title="{{ $category->is_active ? 'Активна' : 'Неактивна' }}"
             onclick="event.stopPropagation();">
        </div>
    </div>

    <div class="category-info">
        <div class="category-name">{{ $category->name }}</div>
        <span class="category-slug">{{ $category->slug }}</span>

        @include('admin.categories.components.category-products-preview', ['category' => $category])
    </div>

    @include('admin.categories.components.category-stats', ['category' => $category])

    @include('admin.categories.components.category-actions', ['category' => $category])
</div>
