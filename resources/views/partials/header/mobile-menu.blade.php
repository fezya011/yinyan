{{-- partials/header/mobile-menu.blade.php --}}
<div id="mobileMenu" class="absolute left-0 right-0 bg-white border-t border-black/5 shadow-2xl"
     style="display: none; max-height: 0; overflow: hidden; transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease; opacity: 0;">
    <div class="relative" id="mobileMenuInner">

        {{-- Градиент сверху --}}
        <div class="absolute top-0 left-0 right-0 h-24 pointer-events-none transition-all duration-1000" id="menuTopGradient"
             style="background: linear-gradient(to bottom, rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.04) 0%, transparent 100%);">
        </div>

        <div class="px-6 py-8 relative">

            {{-- Декоративные иероглифы --}}
            @include('partials.header.mobile-hanzi')

            {{-- Навигация --}}
            <nav class="relative flex flex-col gap-1">
                <a href="#why" class="mobile-menu-link group relative flex items-center justify-between px-4 py-6 rounded-2xl hover:bg-black/[0.02] transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="text-[28px] sm:text-[36px] font-light text-black/40 group-hover:text-black transition-colors duration-300">О нас</span>
                        <span class="text-lg font-black opacity-10 group-hover:opacity-25 transition-all duration-300 menu-hanzi"
                              style="font-family: 'Noto Serif SC', serif;">人</span>
                    </div>
                    <span class="text-2xl text-black/0 group-hover:text-black/20 transition-all duration-300 transform group-hover:translate-x-2">→</span>
                </a>

                <div class="h-px bg-gradient-to-r from-transparent via-black/[0.04] to-transparent mx-4"></div>

                <a href="{{ route('catalog') }}" class="mobile-menu-link group relative flex items-center justify-between px-4 py-6 rounded-2xl hover:bg-black/[0.02] transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="text-[28px] sm:text-[36px] font-light text-black/40 group-hover:text-black transition-colors duration-300">Каталог</span>
                        <span class="text-lg font-black opacity-10 group-hover:opacity-25 transition-all duration-300 menu-hanzi"
                              style="font-family: 'Noto Serif SC', serif;">品</span>
                    </div>
                    <span class="text-2xl text-black/0 group-hover:text-black/20 transition-all duration-300 transform group-hover:translate-x-2">→</span>
                </a>

                <div class="h-px bg-gradient-to-r from-transparent via-black/[0.04] to-transparent mx-4"></div>

                <a href="#contacts" class="mobile-menu-link group relative flex items-center justify-between px-4 py-6 rounded-2xl hover:bg-black/[0.02] transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <span class="text-[28px] sm:text-[36px] font-light text-black/40 group-hover:text-black transition-colors duration-300">Контакты</span>
                        <span class="text-lg font-black opacity-10 group-hover:opacity-25 transition-all duration-300 menu-hanzi"
                              style="font-family: 'Noto Serif SC', serif;">信</span>
                    </div>
                    <span class="text-2xl text-black/0 group-hover:text-black/20 transition-all duration-300 transform group-hover:translate-x-2">→</span>
                </a>
            </nav>

            {{-- Кнопка и подпись --}}
            <div class="relative mt-6 pt-6 border-t border-black/[0.04]">
                <a href="#"
                   class="mobile-menu-link block w-full px-8 py-5 bg-black text-white text-sm font-bold tracking-[2px] uppercase hover:bg-black/90 transition-all duration-300 text-center hover:shadow-xl active:scale-[0.98]"
                   data-lead-modal>
                    Связаться с нами
                </a>
                <div class="mt-6 flex items-center justify-center gap-6">
                    <span class="text-[10px] font-black tracking-[6px] uppercase transition-all duration-1000 menu-hanzi"
                          style="font-family: 'Noto Serif SC', serif; opacity: 0.1;">道法自然</span>
                    <span class="text-[10px] font-black tracking-[6px] uppercase transition-all duration-1000 menu-hanzi"
                          style="font-family: 'Noto Serif SC', serif; opacity: 0.1;">阴阳</span>
                </div>
            </div>
        </div>
    </div>
</div>
