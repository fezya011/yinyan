{{-- admin/leads/partials/info.blade.php --}}
<div class="bg-white p-6 border border-gray-200 mb-6">
    <h3 class="font-semibold text-lg mb-4">Информация о клиенте</h3>

    <div class="lead-info-grid">
        <div class="field">
            <span class="label">Имя</span>
            <span class="value">{{ $lead->name }}</span>
        </div>
        <div class="field">
            <span class="label">Телефон</span>
            <span class="value">{{ $lead->phone ?? '—' }}</span>
        </div>
        <div class="field">
            <span class="label">Email</span>
            <span class="value">{{ $lead->email ?? '—' }}</span>
        </div>
        <div class="field">
            <span class="label">Город доставки</span>
            <span class="value">{{ $lead->delivery_city ?? '—' }}</span>
        </div>
        <div class="field">
            <span class="label">Бюджет</span>
            <span class="value">
                @if($lead->estimated_budget && is_numeric(str_replace(',', '.', $lead->estimated_budget)))
                    {{ number_format((float)$lead->estimated_budget, 0, '.', ' ') }} ₽
                @elseif($lead->estimated_budget)
                    {{ $lead->estimated_budget }}
                @else
                    —
                @endif
            </span>
        </div>
        <div class="field">
            <span class="label">Товар</span>
            <span class="value">{{ $lead->product?->name ?? 'Не указан' }}</span>
        </div>
        <div class="field field-full">
            <span class="label">Сообщение</span>
            <div class="lead-message">{{ $lead->message ?? 'Нет сообщения' }}</div>
        </div>
    </div>
</div>

{{-- Заинтересованные товары --}}
@if($lead->interested_products)
    <div class="bg-white p-6 border border-gray-200">
        <h3 class="font-semibold text-lg mb-4">Заинтересованные товары</h3>
        <div class="flex flex-wrap gap-2">
            @php
                $interested = $lead->interestedProducts();
            @endphp
            @if($interested->count())
                @foreach($interested as $product)
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">{{ $product->name }}</span>
                @endforeach
            @else
                <span class="text-muted text-sm">Нет данных</span>
            @endif
        </div>
    </div>
@endif
