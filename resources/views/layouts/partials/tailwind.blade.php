{{-- layouts/partials/tailwind.blade.php --}}
{{-- Tailwind CSS via CDN --}}
<script src="https://cdn.tailwindcss.com"></script>

@if(config('app.env') === 'production')
    {{-- Если используете Tailwind сборку через Vite --}}
    @vite(['resources/css/app.css'])
@endif
