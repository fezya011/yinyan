{{-- admin/leads/export.blade.php --}}
@extends('admin.layouts.admin')

@push('styles')
    @vite(['resources/css/pages/admin/leads.css'])
@endpush

@section('title', 'Экспорт заявок')
@section('page-title', 'Экспорт заявок')
@section('sub-title', 'выгрузка')

@section('content')
    <div class="max-w-2xl">
        @include('admin.leads.partials.export-form')
    </div>
@endsection
