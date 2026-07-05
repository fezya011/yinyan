{{-- layouts/partials/core-scripts.blade.php --}}
{{-- Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Header Hide/Show Script --}}
@include('layouts.partials.header-script')

{{-- Vite assets (если используете) --}}
@if(config('app.env') === 'production' || config('app.env') === 'local')
    @vite(['resources/js/app.js'])
@endif

{{-- Инициализация глобальных объектов --}}
<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}',
        baseUrl: '{{ url('/') }}',
        currentRoute: '{{ request()->route()->getName() }}',
        env: '{{ config('app.env') }}',
        isProduction: '{{ config('app.env') === 'production' }}',
    };
</script>
