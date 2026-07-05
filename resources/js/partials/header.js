// resources/js/partials/header.js

/**
 * Инициализация хедера
 */
export function initHeader() {
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

    // Наблюдаем за изменением переменных
    const observer = new MutationObserver(() => {
        updateMenuColors();
    });

    observer.observe(root, {
        attributes: true,
        attributeFilter: ['style']
    });

    updateMenuColors();

    // Клик по бургеру
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMenuOpen) closeMenu();
    });

    // Закрытие по клику на ссылку
    document.querySelectorAll('.mobile-menu-link').forEach(link => {
        link.addEventListener('click', function() {
            setTimeout(closeMenu, 200);
        });
    });

    // Закрытие по клику вне меню
    document.addEventListener('click', function(e) {
        if (isMenuOpen && !header.contains(e.target)) {
            closeMenu();
        }
    });

    // Скролл
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

    // Обновление высоты меню при ресайзе
    window.addEventListener('resize', () => {
        if (isMenuOpen && mobileMenuInner) {
            mobileMenu.style.maxHeight = mobileMenuInner.scrollHeight + 'px';
        }
    });

    // Экспортируем для отладки
    window.closeMobileMenu = closeMenu;
}

// Автоматическая инициализация при загрузке
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initHeader);
} else {
    initHeader();
}
