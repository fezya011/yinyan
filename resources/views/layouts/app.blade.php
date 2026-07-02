<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Инь Янь'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        @media (max-width: 768px) {
            .backdrop-blur-sm {
                backdrop-filter: blur(5px);
            }
        }

        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')

</head>

<body>

@include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')

{{-- Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Скрипт для скрытия хедера при скролле --}}
<script>
    let lastScrollTop = 0;
    const header = document.querySelector('header');
    const scrollThreshold = 100;

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
            header.style.transform = 'translateY(-100%)';
            header.style.transition = 'transform 0.3s ease';
        } else {
            header.style.transform = 'translateY(0)';
        }
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });
</script>
@include('partials.lead-modal')
@stack('scripts')
</body>
</html>
