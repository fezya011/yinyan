{{-- partials/header/desktop-nav.blade.php --}}
<nav class="hidden lg:flex items-center justify-center gap-1 flex-1 mx-8" aria-label="Основная навигация">
    <a href="#why" class="nav-link px-5 py-2.5 text-sm font-medium text-black/40 hover:text-black transition-all duration-300 hover:bg-black/5">О нас</a>
    <a href="{{ route('catalog') }}" class="nav-link px-5 py-2.5 text-sm font-medium text-black/40 hover:text-black transition-all duration-300 hover:bg-black/5">
        Каталог
    </a>
    <a href="#contacts" class="nav-link px-5 py-2.5 text-sm font-medium text-black/40 hover:text-black transition-all duration-300 hover:bg-black/5">Контакты</a>
</nav>
