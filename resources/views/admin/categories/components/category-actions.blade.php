{{-- admin/categories/components/category-actions.blade.php --}}
<div class="category-actions" onclick="event.stopPropagation();">
    <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="inline">
        @csrf
        <button type="submit"
                class="btn-action"
                title="{{ $category->is_active ? 'Деактивировать' : 'Активировать' }}">
            <i class="fas {{ $category->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
        </button>
    </form>

    @can('manage-categories')
        <a href="{{ route('admin.categories.edit', $category) }}"
           class="btn-action"
           title="Редактировать">
            <i class="fas fa-edit"></i>
        </a>

        <form action="{{ route('admin.categories.destroy', $category) }}"
              method="POST"
              class="inline"
              onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="btn-action delete"
                    title="Удалить"
                {{ $category->products_count > 0 ? 'disabled' : '' }}>
                <i class="fas fa-trash"></i>
            </button>
        </form>
    @endcan
</div>
