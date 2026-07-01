<!-- ============================================================
     НАВИГАЦИЯ — ИНЬ ЯН
     ============================================================ -->
<header class="fixed top-0 left-0 right-0 z-[1000] transition-all duration-500" id="siteHeader">
    <div class="mx-auto px-6 lg:px-12">
        <div class="flex items-center justify-between h-[72px] lg:h-[88px]">

            <!-- ЛЕВАЯ ЧАСТЬ — ЛОГОТИП -->
            <a href="/" class="flex items-center flex-shrink-0 group">
                <div class="relative w-10 h-10 lg:w-[56px] lg:h-[56px] transition-all duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 rounded-full overflow-hidden bg-black/5 border border-black/10 transition-all duration-500 group-hover:border-black/30 group-hover:shadow-lg">
                        <img src="{{ asset('images/logo.png') }}" alt="Инь Ян" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" onerror="this.style.display='none'">
                    </div>
                </div>
            </a>

            <!-- ДЕСКТОПНОЕ МЕНЮ -->
            <nav class="hidden lg:flex items-center justify-center gap-1 flex-1 mx-8" aria-label="Основная навигация">
                <a href="#why" class="nav-link px-5 py-2.5 text-sm font-medium text-black/40 hover:text-black transition-all duration-300 hover:bg-black/5">О нас</a>
                <a href="{{ route('catalog') }}" class="nav-link px-5 py-2.5 text-sm font-medium text-black/40 hover:text-black transition-all duration-300 hover:bg-black/5">
                    Каталог
                </a>
                <a href="#contacts" class="nav-link px-5 py-2.5 text-sm font-medium text-black/40 hover:text-black transition-all duration-300 hover:bg-black/5">Контакты</a>
            </nav>

            <!-- ПРАВАЯ ЧАСТЬ -->
            <div class="flex items-center gap-3 lg:gap-4 flex-shrink-0">
                <span class="hidden lg:block text-sm font-black text-black/8 tracking-[4px] select-none cursor-default" style="font-family: 'Noto Serif SC', serif;">道</span>

                <a href="#contacts" class="hidden lg:inline-flex items-center gap-2 px-6 py-2.5 text-xs font-bold tracking-[1.5px] uppercase text-white bg-black hover:bg-black/80 transition-all duration-300 hover:shadow-lg relative overflow-hidden group">
                    <span class="relative z-10">Связаться</span>
                    <span class="relative z-10 pb-1 text-sm group-hover:translate-x-1 transition-transform duration-300">→</span>
                </a>

                <!-- Бургер -->
                <button id="menuToggle" class="lg:hidden relative w-10 h-10 flex items-center justify-center z-[1002]" aria-label="Меню" aria-expanded="false">
                    <div class="w-5 h-4 relative">
                        <span class="block absolute w-full h-[2px] bg-black/70 rounded-full transition-all duration-300 top-0" id="bar1"></span>
                        <span class="block absolute w-full h-[2px] bg-black/70 rounded-full transition-all duration-300 top-1/2 -translate-y-1/2" id="bar2"></span>
                        <span class="block absolute w-full h-[2px] bg-black/70 rounded-full transition-all duration-300 bottom-0" id="bar3"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- МОБИЛЬНОЕ МЕНЮ -->
    <div id="mobileMenu" class="absolute left-0 right-0 bg-white border-t border-black/5 shadow-2xl"
         style="display: none; max-height: 0; overflow: hidden; transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease; opacity: 0;">
        <div class="relative" id="mobileMenuInner">

            <!-- Плавный градиент-переход сверху -->
            <div class="absolute top-0 left-0 right-0 h-24 pointer-events-none transition-all duration-1000" id="menuTopGradient"
                 style="background: linear-gradient(to bottom, rgba(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b), 0.04) 0%, transparent 100%);"></div>

            <div class="px-6 py-8 relative">

                <!-- Декоративные иероглифы -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none select-none">
                    <span class="absolute top-8 right-6 text-[120px] font-black leading-none transition-all duration-1000 menu-hanzi"
                          style="font-family: 'Noto Serif SC', serif; opacity: 0.03;">道</span>
                    <span class="absolute bottom-8 left-6 text-[100px] font-black leading-none transition-all duration-1000 menu-hanzi"
                          style="font-family: 'Noto Serif SC', serif; opacity: 0.025;">气</span>
                    <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-[180px] font-black leading-none transition-all duration-1000 menu-hanzi"
                          style="font-family: 'Noto Serif SC', serif; opacity: 0.015;">阴</span>
                </div>

                <!-- Навигация -->
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

                <!-- Кнопка и подпись -->
                <div class="relative mt-6 pt-6 border-t border-black/[0.04]">
                    <a href="#contacts" class="mobile-menu-link block w-full px-8 py-5 bg-black text-white text-sm font-bold tracking-[2px] uppercase hover:bg-black/90 transition-all duration-300 text-center hover:shadow-xl active:scale-[0.98]">
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
</header>

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@700;900&display=swap" rel="stylesheet">
    <style>
        #siteHeader {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(1.5);
            -webkit-backdrop-filter: blur(20px) saturate(1.5);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1),
            background 0.5s ease,
            box-shadow 0.5s ease;
        }

        #siteHeader.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 1px 20px rgba(0, 0, 0, 0.03);
        }

        #siteHeader.hidden-header {
            transform: translateY(-100%);
        }

        #siteHeader.menu-open {
            transform: translateY(0) !important;
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06) !important;
        }

        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 1.5px;
            background: #000;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-link:hover::after {
            width: 40%;
        }

        /* Бургер анимация */
        #menuToggle.active #bar1 {
            top: 50%;
            transform: translateY(-50%) rotate(45deg);
            background: #000;
        }
        #menuToggle.active #bar2 {
            opacity: 0;
            transform: scaleX(0);
        }
        #menuToggle.active #bar3 {
            bottom: 50%;
            transform: translateY(50%) rotate(-45deg);
            background: #000;
        }

        body.menu-open {
            overflow: hidden;
        }

        /* Плавная анимация цветов для иероглифов */
        .menu-hanzi {
            color: rgb(var(--carousel-accent-r), var(--carousel-accent-g), var(--carousel-accent-b));
            transition: color 1.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        @media (max-width: 640px) {
            #mobileMenu .text-\[28px\] {
                font-size: 24px !important;
            }
        }

        @media (max-width: 480px) {
            #siteHeader .px-6 {
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #siteHeader,
            #mobileMenu,
            #menuToggle span,
            .menu-hanzi {
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('siteHeader');
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuInner = document.getElementById('mobileMenuInner');
            const root = document.documentElement;

            if (!menuToggle || !mobileMenu || !mobileMenuInner) {
                console.error('Menu elements not found!');
                return;
            }

            let isMenuOpen = false;
            let lastScrollY = window.scrollY;

            function getAccentRGB() {
                const r = getComputedStyle(root).getPropertyValue('--carousel-accent-r').trim() || '255';
                const g = getComputedStyle(root).getPropertyValue('--carousel-accent-g').trim() || '107';
                const b = getComputedStyle(root).getPropertyValue('--carousel-accent-b').trim() || '0';
                return { r, g, b };
            }

            function updateMenuColors() {
                const { r, g, b } = getAccentRGB();
                const accent = `rgb(${r}, ${g}, ${b})`;

                document.querySelectorAll('.menu-hanzi').forEach(el => {
                    el.style.color = accent;
                });

                const topGradient = document.getElementById('menuTopGradient');
                if (topGradient) {
                    topGradient.style.background = `linear-gradient(to bottom, rgba(${r}, ${g}, ${b}, 0.04) 0%, transparent 100%)`;
                }
            }

            function openMenu() {
                isMenuOpen = true;

                mobileMenu.style.display = 'block';
                mobileMenu.offsetHeight;

                const menuHeight = mobileMenuInner.scrollHeight;

                requestAnimationFrame(() => {
                    mobileMenu.style.maxHeight = menuHeight + 'px';
                    mobileMenu.style.opacity = '1';
                });

                updateMenuColors();
                menuToggle.classList.add('active');
                header.classList.add('menu-open');
                menuToggle.setAttribute('aria-expanded', 'true');
                document.body.classList.add('menu-open');
            }

            function closeMenu() {
                isMenuOpen = false;

                mobileMenu.style.maxHeight = '0';
                mobileMenu.style.opacity = '0';

                setTimeout(() => {
                    if (!isMenuOpen) {
                        mobileMenu.style.display = 'none';
                    }
                }, 500);

                menuToggle.classList.remove('active');
                header.classList.remove('menu-open');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('menu-open');
            }

            const observer = new MutationObserver(() => {
                updateMenuColors();
            });

            observer.observe(root, {
                attributes: true,
                attributeFilter: ['style']
            });

            updateMenuColors();

            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (isMenuOpen) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMenuOpen) closeMenu();
            });

            document.querySelectorAll('.mobile-menu-link').forEach(link => {
                link.addEventListener('click', function() {
                    setTimeout(closeMenu, 200);
                });
            });

            document.addEventListener('click', function(e) {
                if (isMenuOpen && !header.contains(e.target)) {
                    closeMenu();
                }
            });

            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        const currentScrollY = window.scrollY;

                        if (currentScrollY > 10) {
                            header.classList.add('scrolled');
                        } else {
                            header.classList.remove('scrolled');
                        }

                        if (!isMenuOpen) {
                            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                                header.classList.add('hidden-header');
                            } else if (currentScrollY < lastScrollY) {
                                header.classList.remove('hidden-header');
                            }
                        }

                        lastScrollY = currentScrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });

            window.addEventListener('resize', () => {
                if (isMenuOpen && mobileMenuInner) {
                    mobileMenu.style.maxHeight = mobileMenuInner.scrollHeight + 'px';
                }
            });

            window.closeMobileMenu = closeMenu;
        });
    </script>
@endpush
