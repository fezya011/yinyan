{{-- resources/views/admin/settings/notifications.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Настройки уведомлений')
@section('page-title', 'Настройки уведомлений')
@section('sub-title', 'email-уведомления о заявках')

@section('content')
    <div class="max-w-3xl">
        {{-- Добавление email --}}
        <div class="bg-white p-6 border border-gray-200 mb-6">
            <h3 class="font-semibold text-sm mb-4">Добавить email для уведомлений</h3>
            <form method="POST" action="{{ route('admin.settings.notifications.store') }}" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <div class="flex-1">
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                    @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <input type="text" name="name" class="form-control" placeholder="Имя получателя (необязательно)">
                </div>
                <button type="submit" class="btn btn-primary flex-shrink-0">
                    <i class="fas fa-plus"></i> Добавить
                </button>
            </form>
        </div>

        {{-- Список email-ов --}}
        <div class="bg-white border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                <span class="font-semibold text-sm">Список получателей</span>
                <span class="text-xs text-muted">{{ $emails->count() }} получателей</span>
            </div>

            @if($emails->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($emails as $item)
                        <div class="p-4 flex flex-wrap items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                <span class="status-badge {{ $item->is_active ? 'active' : 'inactive' }}" style="font-size: 9px; padding: 2px 10px;">
                                    <span class="dot"></span>
                                    {{ $item->is_active ? 'Активен' : 'Отключён' }}
                                </span>
                                </div>
                                <div>
                                    <div class="font-medium text-sm">{{ $item->email }}</div>
                                    @if($item->name)
                                        <div class="text-xs text-muted">{{ $item->name }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.settings.notifications.toggle', $item) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $item->is_active ? 'Отключить' : 'Включить' }}">
                                        <i class="fas {{ $item->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.settings.notifications.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Удалить email {{ $item->email }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center text-muted">
                    <i class="fas fa-envelope text-2xl block mb-3 opacity-30"></i>
                    <p class="text-sm">Нет добавленных email-адресов</p>
                    <p class="text-xs">Добавьте email, чтобы получать уведомления о новых заявках</p>
                </div>
            @endif
        </div>

        {{-- Информация --}}
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 text-sm text-muted">
            <p><i class="fas fa-info-circle mr-2"></i> Уведомления отправляются на все активные email-адреса при создании новой заявки.</p>
            <p class="mt-1">Для отправки писем необходимо настроить почтовый драйвер в <code>.env</code> (MAIL_MAILER, MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD).</p>
        </div>
    </div>
@endsection
