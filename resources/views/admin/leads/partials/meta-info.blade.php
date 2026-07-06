{{-- admin/leads/partials/meta-info.blade.php --}}
<div class="bg-white p-6 border border-gray-200">
    <h3 class="font-semibold text-lg mb-4">Информация</h3>

    <div class="space-y-3 text-sm">
        <div>
            <span class="text-muted">Создана:</span>
            <span class="font-medium block">{{ $lead->created_at->format('d.m.Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-muted">Обновлена:</span>
            <span class="font-medium block">{{ $lead->updated_at->format('d.m.Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-muted">ID:</span>
            <span class="font-medium block">#{{ $lead->id }}</span>
        </div>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-200 flex gap-2">
        <a href="{{ route('admin.leads.index') }}" class="btn btn-outline flex-1">
            <i class="fas fa-arrow-left"></i>
            Назад
        </a>
        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="flex-1"
              onsubmit="return confirm('Удалить заявку?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-full">
                <i class="fas fa-trash"></i>
                Удалить
            </button>
        </form>
    </div>
</div>
