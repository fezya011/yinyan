{{-- layouts/partials/header-script.blade.php --}}
<script>
    (function() {
        'use strict';

        let lastScrollTop = 0;
        const header = document.querySelector('header');
        const scrollThreshold = 100;
        let ticking = false;

        if (!header) return;

        function handleScroll() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                    if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
                        header.style.transform = 'translateY(-100%)';
                        header.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    } else {
                        header.style.transform = 'translateY(0)';
                    }

                    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
                    ticking = false;
                });
                ticking = true;
            }
        }

        // Оптимизированная обработка с passive
        window.addEventListener('scroll', handleScroll, { passive: true });

        // Сброс при изменении размера окна
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Если хедер скрыт, показываем при ресайзе
                if (header.style.transform === 'translateY(-100%)') {
                    header.style.transform = 'translateY(0)';
                }
            }, 200);
        });

        // Показываем хедер при наведении на верхнюю часть экрана
        let hoverTimeout;
        document.addEventListener('mousemove', function(e) {
            if (e.clientY < 50 && header.style.transform === 'translateY(-100%)') {
                clearTimeout(hoverTimeout);
                header.style.transform = 'translateY(0)';
                hoverTimeout = setTimeout(() => {
                    // Снова скрываем через 2 секунды, если не скроллим
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    if (scrollTop > scrollThreshold) {
                        header.style.transform = 'translateY(-100%)';
                    }
                }, 3000);
            }
        });
    })();
</script>
