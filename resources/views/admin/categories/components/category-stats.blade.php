{{-- admin/categories/components/category-stats.blade.php --}}
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
