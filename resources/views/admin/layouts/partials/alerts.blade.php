{{-- admin/layouts/partials/alerts.blade.php --}}
@if(session('success'))
    <div class="alert"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert" style="border-left-color: #666;"><i class="fas fa-exclamation-circle"></i>{{ session('error') }}</div>
@endif
