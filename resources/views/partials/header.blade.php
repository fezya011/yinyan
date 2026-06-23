<!-- ============================================================
     НАВИГАЦИЯ
     ============================================================ -->
<header class="fixed top-0 left-0 right-0 z-[1000] transition-all duration-500" id="siteHeader">
    <div class="mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-16 lg:h-20">

            <!-- Логотип -->
            <a href="/" class="flex items-center gap-3 flex-shrink-0 group">
                <!-- Круг с лого -->
                <div class="relative w-9 h-9 lg:w-10 lg:h-10">
                    <div class="absolute inset-0 rounded-full overflow-hidden bg-black/[0.03] border border-black/[0.06] transition-all duration-300 group-hover:border-black/20 group-hover:shadow-lg group-hover:shadow-black/5">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Инь Ян"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'"
                        >
                    </div>
                </div>

                <!-- Название -->
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-[18px] lg:text-[20px] tracking-[-0.5px] text-black/80">
                        ИньЯнь
                    </span>
                    <span class="font-black text-[16px] lg:text-[18px] text-[#FF6B00] opacity-25"
                          style="font-family: 'Noto Serif SC', serif;">
                        阴阳
                    </span>
                </div>
            </a>

            <!-- Десктопное меню -->
            <nav class="hidden md:flex items-center gap-6 lg:gap-8" aria-label="Основная навигация">
                <a href="#why" class="text-sm font-medium text-black/50 hover:text-black transition-colors duration-300">
                    О нас
                </a>
                <a href="#products" class="text-sm font-medium text-black/50 hover:text-black transition-colors duration-300">
                    Каталог
                </a>
                <a href="#contacts" class="text-sm font-medium text-black/50 hover:text-black transition-colors duration-300">
                    Контакты
                </a>
            </nav>

            <!-- Правая часть -->
            <div class="flex items-center gap-3">
                <a href="#contacts"
                   class="hidden md:inline-flex items-center gap-2 px-5 py-2.5 text-xs font-semibold tracking-[1px] uppercase text-white bg-black rounded-full hover:bg-black/80 transition-all duration-300 hover:scale-[1.02]">
                    Связаться
                </a>

                <!-- Бургер -->
                <button
                    id="menuToggle"
                    class="md:hidden relative w-10 h-10 flex items-center justify-center"
                    aria-label="Открыть меню"
                    aria-expanded="false"
                >
                    <span class="block w-5 h-0.5 bg-black rounded-full transition-all duration-300 -translate-y-1.5" id="bar1"></span>
                    <span class="block w-5 h-0.5 bg-black rounded-full transition-all duration-300" id="bar2"></span>
                    <span class="block w-5 h-0.5 bg-black rounded-full transition-all duration-300 translate-y-1.5" id="bar3"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Мобильное меню -->
    <div
        id="mobileMenu"
        class="fixed inset-0 bg-white z-[999] flex items-center justify-center transition-all duration-400 opacity-0 pointer-events-none"
        role="dialog"
        aria-modal="true"
        aria-label="Мобильное меню"
    >
        <!-- Фоновый иероглиф -->
        <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[40vw] font-black text-[#FF6B00] pointer-events-none select-none"
              style="font-family: 'Noto Serif SC', serif; opacity: 0.04;">
            道
        </span>

        <button
            id="closeMenu"
            class="absolute top-6 right-6 w-10 h-10 flex items-center justify-center text-black/40 hover:text-black transition-colors duration-300 z-10"
            aria-label="Закрыть меню"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <nav class="flex flex-col items-center gap-8 px-6 text-center relative z-10">
            <a href="#why"
               class="text-2xl font-medium text-black/30 hover:text-black transition-colors duration-300"
               onclick="closeMobileMenu()">
                О нас
            </a>
            <a href="#products"
               class="text-2xl font-medium text-black/30 hover:text-black transition-colors duration-300"
               onclick="closeMobileMenu()">
                Каталог
            </a>
            <a href="#contacts"
               class="text-2xl font-medium text-black/30 hover:text-black transition-colors duration-300"
               onclick="closeMobileMenu()">
                Контакты
            </a>

            <div class="mt-8 pt-8 border-t border-black/5 w-48">
                <a href="#contacts"
                   class="inline-block px-8 py-3 bg-black text-white text-sm font-medium rounded-full hover:bg-black/80 transition-all duration-300"
                   onclick="closeMobileMenu()">
                    Связаться
                </a>
            </div>
        </nav>
    </div>
</header>

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@900&display=swap" rel="stylesheet">
    <style>
        #siteHeader {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid transparent;
        }

        #siteHeader.scrolled {
            background: rgba(255, 255, 255, 0.95);
            border-bottom-color: rgba(0, 0, 0, 0.06);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        #siteHeader.hidden-header {
            transform: translateY(-100%);
        }

        #menuToggle.active #bar1 {
            transform: rotate(45deg) translate(0, 0);
            width: 22px;
        }
        #menuToggle.active #bar2 {
            opacity: 0;
            transform: scaleX(0);
        }
        #menuToggle.active #bar3 {
            transform: rotate(-45deg) translate(0, 0);
            width: 22px;
        }

        #mobileMenu.open {
            opacity: 1;
            pointer-events: auto;
        }

        #mobileMenu.open nav > * {
            animation: fadeUp 0.4s ease forwards;
            opacity: 0;
        }
        #mobileMenu.open nav > *:nth-child(1) { animation-delay: 0.05s; }
        #mobileMenu.open nav > *:nth-child(2) { animation-delay: 0.10s; }
        #mobileMenu.open nav > *:nth-child(3) { animation-delay: 0.15s; }
        #mobileMenu.open nav > *:nth-child(4) { animation-delay: 0.20s; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (prefers-reduced-motion: reduce) {
            #siteHeader,
            #mobileMenu,
            #mobileMenu nav > *,
            #menuToggle span {
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            const header = document.getElementById('siteHeader');
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const closeBtn = document.getElementById('closeMenu');

            let lastScrollY = 0;
            let isMenuOpen = false;

            function openMenu() {
                isMenuOpen = true;
                mobileMenu.classList.add('open');
                menuToggle.classList.add('active');
                menuToggle.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                isMenuOpen = false;
                mobileMenu.classList.remove('open');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            menuToggle?.addEventListener('click', () => isMenuOpen ? closeMenu() : openMenu());
            closeBtn?.addEventListener('click', closeMenu);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isMenuOpen) closeMenu();
            });

            mobileMenu?.addEventListener('click', (e) => {
                if (e.target === mobileMenu) closeMenu();
            });

            let ticking = false;
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        const y = window.scrollY;
                        header.classList.toggle('scrolled', y > 10);

                        if (!isMenuOpen) {
                            header.classList.toggle('hidden-header', y > lastScrollY && y > 60);
                        }
                        lastScrollY = y;
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });

            window.closeMobileMenu = closeMenu;
        })();
    </script>
@endpush
