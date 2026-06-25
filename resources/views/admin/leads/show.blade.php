{{-- resources/views/admin/leads/show.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Заявка #' . $lead->id)
@section('page-title', 'Заявка #' . $lead->id)

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Основная информация --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-xl border border-gray-200 mb-6">
                <h3 class="font-semibold text-lg mb-4">Информация о клиенте</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-muted">Имя</div>
                        <div class="font-medium">{{ $lead->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Телефон</div>
                        <div class="font-medium">{{ $lead->phone ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Email</div>
                        <div class="font-medium">{{ $lead->email ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Город доставки</div>
                        <div class="font-medium">{{ $lead->delivery_city ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Бюджет</div>
                        <div class="font-medium">{{ $lead->estimated_budget ? number_format($lead->estimated_budget, 0, '.', ' ') . ' ₽' : '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-muted">Товар</div>
                        <div class="font-medium">{{ $lead->product?->name ?? 'Не указан' }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <div class="text-sm text-muted">Сообщение</div>
                        <div class="p-3 bg-gray-50 rounded-lg mt-1">{{ $lead->message ?? 'Нет сообщения' }}</div>
                    </div>
                </div>
            </div>

            {{-- Заинтересованные товары --}}
            @if($lead->interested_products)
                <div class="bg-white p-6 rounded-xl border border-gray-200">
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
        </div>

        {{-- Боковая панель --}}
        <div>
            {{-- Статус --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200 mb-6">
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

            {{-- Информация --}}
            <div class="bg-white p-6 rounded-xl border border-gray-200">
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
                    <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="flex-1" onsubmit="return confirm('Удалить заявку?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-full">
                            <i class="fas fa-trash"></i>
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
