{{-- resources/views/admin/leads/index.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Заявки')
@section('page-title', 'Заявки')

@section('content')
    <div class="flex flex-wrap gap-4 justify-between items-center mb-6">
        <div>
            <p class="text-muted">Управление заявками от клиентов</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.leads.export', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-file-export"></i>
                Экспорт CSV
            </a>
        </div>
    </div>

    {{-- Статистика статусов --}}
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('admin.leads.index') }}" class="status-badge {{ !request('status') ? 'active' : '' }}" style="cursor: pointer; text-decoration: none;">
            Все ({{ array_sum($statusCounts) }})
        </a>
        @foreach($statuses as $key => $label)
            <a href="{{ route('admin.leads.index', ['status' => $key]) }}" class="status-badge {{ $key }} {{ request('status') == $key ? 'active' : '' }}" style="cursor: pointer; text-decoration: none; {{ request('status') == $key ? 'border: 2px solid #0f172a;' : '' }}">
                {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
            </a>
        @endforeach
    </div>

    {{-- Фильтры --}}
    <form method="GET" action="{{ route('admin.leads.index') }}" class="flex flex-wrap gap-3 mb-6">
        <div class="flex-1 min-w-[200px]">
            <input class="form-control" type="text" name="search" value="{{ request('search') }}" placeholder="Поиск по имени, телефону, email...">
        </div>
        <div>
            <input class="form-control" type="date" name="date_from" value="{{ request('date_from') }}" placeholder="С">
        </div>
        <div>
            <input class="form-control" type="date" name="date_to" value="{{ request('date_to') }}" placeholder="По">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Фильтр
            </button>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline">
                <i class="fas fa-times"></i>
                Сброс
            </a>
        </div>
    </form>

    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Клиент</th>
                <th>Контакты</th>
                <th>Товар</th>
                <th>Бюджет</th>
                <th>Город</th>
                <th>Статус</th>
                <th>Дата</th>
                <th style="text-align: center;">Действия</th>
            </tr>
            </thead>
            <tbody>
            @forelse($leads as $lead)
                <tr>
                    <td class="text-muted text-sm">#{{ $lead->id }}</td>
                    <td>
                        <a href="{{ route('admin.leads.show', $lead) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $lead->name }}
                        </a>
                    </td>
                    <td>
                        <div class="text-sm">
                            <div><i class="fas fa-phone text-xs text-muted"></i> {{ $lead->phone ?? '—' }}</div>
                            <div><i class="fas fa-envelope text-xs text-muted"></i> {{ $lead->email ?? '—' }}</div>
                        </div>
                    </td>
                    <td>{{ $lead->product?->name ?? 'Не указан' }}</td>
                    <td class="font-medium">{{ $lead->estimated_budget ? number_format($lead->estimated_budget, 0, '.', ' ') . ' ₽' : '—' }}</td>
                    <td>{{ $lead->delivery_city ?? '—' }}</td>
                    <td>
                    <span class="status-badge {{ $lead->status }}" style="font-size: 10px; padding: 2px 10px;">
                        <span class="dot"></span>
                        {{ $statuses[$lead->status] ?? $lead->status }}
                    </span>
                    </td>
                    <td class="text-sm text-muted">{{ $lead->created_at->format('d.m.Y H:i') }}</td>
                    <td style="text-align: center;">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-primary" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Удалить заявку от {{ $lead->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-8">
                        <i class="fas fa-envelope text-3xl block mb-3" style="opacity: 0.3;"></i>
                        Заявки не найдены
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $leads->links() }}
    </div>
@endsection
