{{-- admin/leads/partials/status-form.blade.php --}}
<div class="bg-white p-6 border border-gray-200 mb-6">
    <h3 class="font-semibold text-lg mb-4">Статус</h3>

    <form method="POST" action="{{ route('admin.leads.update-status', $lead) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <select class="form-control" name="status">
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ $lead->status == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-full">
            <i class="fas fa-save"></i>
            Обновить статус
        </button>
    </form>

    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="text-sm text-muted">Текущий статус</div>
        <span class="status-badge {{ $lead->status }} mt-1">
            <span class="dot"></span>
            {{ $statuses[$lead->status] ?? $lead->status }}
        </span>
    </div>
</div>
