{{-- admin/leads/partials/export-form.blade.php --}}
<div class="bg-white p-6 border border-gray-200 mb-6">
    <p class="text-sm text-muted mb-4">
        Выберите параметры для экспорта заявок в CSV-файл.
        Файл будет содержать все заявки, соответствующие выбранным фильтрам.
    </p>

    <form method="GET" action="{{ route('admin.leads.export') }}" class="space-y-4">
        <div class="form-group">
            <label class="form-label" for="status">Статус заявки</label>
            <select class="form-control" id="status" name="status">
                <option value="">Все статусы</option>
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="form-group">
                <label class="form-label" for="date_from">Дата от</label>
                <input class="form-control" id="date_from" type="date" name="date_from"
                       value="{{ request('date_from') }}">
            </div>
            <div class="form-group">
                <label class="form-label" for="date_to">Дата до</label>
                <input class="form-control" id="date_to" type="date" name="date_to"
                       value="{{ request('date_to') }}">
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-100">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-file-export"></i>
                Экспортировать CSV
            </button>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
    </form>
</div>

<div class="export-info">
    <p class="font-semibold text-black mb-2">Информация о выгрузке:</p>
    <ul>
        <li>• Формат: CSV с разделителями запятая</li>
        <li>• Кодировка: UTF-8 с BOM (поддерживается Excel)</li>
        <li>• Поля: ID, Имя, Телефон, Email, Сообщение, Товар, Бюджет, Город, Статус, Дата создания</li>
        <li>• Всего заявок: <span class="font-semibold text-black">{{ $totalLeads }}</span></li>
    </ul>
</div>
