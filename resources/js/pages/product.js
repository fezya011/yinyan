// resources/js/pages/product.js

(function() {
    'use strict';

    // ===== ИНИЦИАЛИЗАЦИЯ AOS =====
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 500,
            once: true,
            offset: 20,
            easing: 'ease-out'
        });
    } else {
        console.warn('AOS not loaded');
    }

    // ===== УСТАНОВКА АКЦЕНТНОГО ЦВЕТА =====
    function setAccentColor(hexColor) {
        if (!hexColor || hexColor === '#') hexColor = '#FF6B00';
        const hex = hexColor.replace('#', '');
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        // Для страницы товара
        document.documentElement.style.setProperty('--accent-r', r);
        document.documentElement.style.setProperty('--accent-g', g);
        document.documentElement.style.setProperty('--accent-b', b);

        // Для карусели и бегущей строки (главная)
        document.documentElement.style.setProperty('--carousel-accent-r', r);
        document.documentElement.style.setProperty('--carousel-accent-g', g);
        document.documentElement.style.setProperty('--carousel-accent-b', b);

        // Обновляем иероглифы на странице
        document.querySelectorAll('.hanzi-decor, .marquee-char, .marquee-separator, .menu-hanzi').forEach(el => {
            el.style.color = `rgb(${r}, ${g}, ${b})`;
        });

        // Обновляем градиенты
        const glow = document.getElementById('heroGlow');
        if (glow) {
            glow.style.background = `radial-gradient(circle, rgba(${r}, ${g}, ${b}, 0.3) 0%, transparent 70%)`;
        }
    }

    // ===== ПОЛУЧАЕМ ЦВЕТ ИЗ DATA-АТРИБУТА =====
    (function() {
        const wrapper = document.querySelector('.product-wrapper');
        const accentColor = wrapper?.dataset?.accentColor || '#FF6B00';
        setAccentColor(accentColor);
    })();

    // ===== КАРУСЕЛЬ =====
    (function() {
        const track = document.getElementById('productCarouselTrack');
        if (!track) return;

        const slides = track.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.gallery-section .carousel-dot');
        const thumbs = document.querySelectorAll('.gallery-thumb');
        const prevBtn = document.getElementById('productCarouselPrev');
        const nextBtn = document.getElementById('productCarouselNext');

        if (!slides.length) return;

        let currentIndex = 0;
        const totalSlides = slides.length;
        let isTransitioning = false;

        function goToSlide(index) {
            if (isTransitioning || totalSlides <= 1) return;
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;

            isTransitioning = true;
            currentIndex = index;

            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            slides.forEach((slide, i) => slide.classList.toggle('active-slide', i === currentIndex));
            dots.forEach((dot, i) => dot.classList.toggle('active', i === currentIndex));
            thumbs.forEach((thumb, i) => thumb.classList.toggle('active', i === currentIndex));

            setTimeout(() => { isTransitioning = false; }, 800);
        }

        prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));
        nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));

        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                const idx = parseInt(dot.dataset.index);
                if (idx !== currentIndex) goToSlide(idx);
            });
        });

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                const idx = parseInt(thumb.dataset.index);
                if (idx !== currentIndex) goToSlide(idx);
            });
        });

        // Touch events
        let touchStartX = 0;
        track.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        track.addEventListener('touchend', (e) => {
            const diffX = touchStartX - e.changedTouches[0].screenX;
            if (Math.abs(diffX) > 40) {
                diffX > 0 ? goToSlide(currentIndex + 1) : goToSlide(currentIndex - 1);
            }
        }, { passive: true });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') goToSlide(currentIndex - 1);
            if (e.key === 'ArrowRight') goToSlide(currentIndex + 1);
        });

        goToSlide(0);
    })();

    // ===== РАЗВОРОТ ОПИСАНИЯ =====
    window.toggleDescription = function() {
        const desc = document.getElementById('descriptionText');
        const btn = document.getElementById('readMoreBtn');
        const text = document.getElementById('readMoreText');
        const arrow = document.getElementById('readMoreArrow');

        if (!desc || !btn) return;

        if (desc.classList.contains('description-collapsed')) {
            desc.classList.remove('description-collapsed');
            desc.classList.add('description-expanded');
            if (text) text.textContent = 'Свернуть';
            if (arrow) arrow.textContent = '↑';
        } else {
            desc.classList.add('description-collapsed');
            desc.classList.remove('description-expanded');
            if (text) text.textContent = 'Читать полностью';
            if (arrow) arrow.textContent = '↓';
            desc.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };
})();
