{{-- admin/leads/index.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    @vite(['resources/css/pages/admin/leads.css'])
@endpush

@section('title', 'Заявки')
@section('page-title', 'Заявки')
@section('sub-title', 'список')

@section('content')
    <div class="flex flex-wrap gap-4 justify-between items-center mb-6">
        <div>
            <p class="text-muted">Управление заявками от клиентов</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.leads.export', request()->all()) }}" class="btn btn-primary">
                <i class="fas fa-file-export"></i>
                Экспорт CSV
            </a>
        </div>
    </div>

    {{-- Статистика статусов --}}
    @include('admin.leads.partials.stats')

    {{-- Фильтры --}}
    @include('admin.leads.partials.filters')

    {{-- Таблица --}}
    @include('admin.leads.partials.table')

    <div class="mt-4">
        {{ $leads->links() }}
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/pages/admin/leads.js'])
@endpush
