{{-- admin/categories/components/category-grid.blade.php --}}
<div class="categories-grid">
    @forelse($categories as $category)
        @include('admin.categories.components.category-card', ['category' => $category])
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
