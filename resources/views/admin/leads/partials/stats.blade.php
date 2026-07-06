{{-- admin/leads/partials/stats.blade.php --}}
<div class="flex flex-wrap gap-2 mb-6 leads-stats">
    <a href="{{ route('admin.leads.index') }}"
       class="stat-item {{ !request('status') ? 'active' : '' }}">
        Все <span class="count">({{ array_sum($statusCounts) }})</span>
    </a>
    @foreach($statuses as $key => $label)
        <a href="{{ route('admin.leads.index', ['status' => $key]) }}"
           class="stat-item {{ request('status') == $key ? 'active' : '' }}">
            {{ $label }} <span class="count">({{ $statusCounts[$key] ?? 0 }})</span>
        </a>
    @endforeach
</div>
