{{-- partials/header.blade.php --}}
<header class="fixed top-0 left-0 right-0 z-[1000] transition-all duration-500" id="siteHeader">
    <div class="mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-[72px] lg:h-[88px]">

            {{-- Логотип --}}
            @include('partials.header.logo')

            {{-- Десктопное меню --}}
            @include('partials.header.desktop-nav')

            {{-- Правая часть --}}
            <div class="flex items-center gap-3 lg:gap-4 flex-shrink-0">
                <span class="hidden lg:block text-sm font-black text-black/8 tracking-[4px] select-none cursor-default"
                      style="font-family: 'Noto Serif SC', serif;">道</span>

                <a href="#"
                   class="hidden lg:inline-flex items-center gap-2 px-6 py-2.5 text-xs font-bold tracking-[1.5px] uppercase text-white bg-black hover:bg-black/80 transition-all duration-300 hover:shadow-lg relative overflow-hidden group"
                   data-lead-modal>
                    <span class="relative z-10">Связаться</span>
                    <span class="relative z-10 pb-1 text-sm group-hover:translate-x-1 transition-transform duration-300">→</span>
                </a>

                {{-- Бургер --}}
                @include('partials.header.burger')
            </div>
        </div>
    </div>

    {{-- Мобильное меню --}}
    @include('partials.header.mobile-menu')
</header>

{{-- Подключаем шрифты --}}
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@700;900&display=swap" rel="stylesheet">
@endpush

{{-- Стили подключаем через Vite --}}
@push('styles')
    @vite(['resources/css/partials/header.css'])
@endpush

{{-- Скрипты подключаем через Vite --}}
@push('scripts')
    @vite(['resources/js/partials/header.js'])
@endpush
