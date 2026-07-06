{{-- admin/leads/partials/table.blade.php --}}
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
                    <a href="{{ route('admin.leads.show', $lead) }}" class="font-medium hover:underline" style="color: #1A1A1A;">
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
                <td class="font-medium">
                    @if($lead->estimated_budget && is_numeric(str_replace(',', '.', $lead->estimated_budget)))
                        {{ number_format((float)$lead->estimated_budget, 0, '.', ' ') }} ₽
                    @elseif($lead->estimated_budget)
                        {{ $lead->estimated_budget }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $lead->delivery_city ?? '—' }}</td>
                <td>
                    <span class="status-badge {{ $lead->status }}">
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
                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline"
                              onsubmit="return confirm('Удалить заявку от {{ $lead->name }}?')">
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
