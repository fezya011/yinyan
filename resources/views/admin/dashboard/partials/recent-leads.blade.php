{{-- admin/dashboard/partials/recent-leads.blade.php --}}
<div class="table-container">
    <div class="table-header">
        <span class="title">Последние заявки</span>
        <div class="actions">
            <a href="{{ route('admin.leads.index') }}">Все</a>
            <a href="{{ route('admin.leads.export-page') }}">CSV</a>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>Клиент</th>
            <th>Товар</th>
            <th>Статус</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        @forelse($recentLeads as $lead)
            <tr>
                <td>
                    <a href="{{ route('admin.leads.show', $lead) }}" style="color: #1A1A1A; text-decoration: none; font-weight: 600; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.6'" onmouseout="this.style.opacity='1'">
                        {{ $lead->name }}
                    </a>
                </td>
                <td class="text-muted">{{ $lead->product?->name ?? 'Не указан' }}</td>
                <td>
                    <span class="status-badge {{ $lead->status }}">
                        <span class="dot"></span>
                        {{ \App\Models\Lead::getStatuses()[$lead->status] ?? $lead->status }}
                    </span>
                </td>
                <td class="text-muted">{{ $lead->created_at->format('d.m.Y H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <div class="empty-state">
                        <div class="empty-icon">空</div>
                        <span class="empty-text">Нет заявок</span>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
