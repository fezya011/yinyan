{{-- admin/leads/show.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    @vite(['resources/css/pages/admin/leads.css'])
@endpush

@section('title', 'Заявка #' . $lead->id)
@section('page-title', 'Заявка #' . $lead->id)
@section('sub-title', 'просмотр')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Основная информация --}}
        <div class="lg:col-span-2">
            @include('admin.leads.partials.info')
        </div>

        {{-- Боковая панель --}}
        <div>
            @include('admin.leads.partials.status-form')
            @include('admin.leads.partials.meta-info')
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/pages/admin/leads.js'])
@endpush
