// ===== ИНИЦИАЛИЗАЦИЯ AOS =====
AOS.init({
    duration: 600,
    once: true,
    offset: 30,
    easing: 'ease-out'
});

// ===== ГЛОБАЛЬНЫЕ ПЕРЕМЕННЫЕ ДЛЯ БЕГУЩЕЙ СТРОКИ =====
const marqueeChars = ['信', '誉', '第', '一', '品', '质', '为', '本', '诚', '信', '合', '作', '共', '赢', '未', '来', '中', '俄', '贸', '易', '直', '接', '进', '口'];

function updateMarqueeColors() {
    const track = document.getElementById('marqueeTrack');
    if (!track) return;

    let html = '';
    html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
    marqueeChars.forEach((char, i) => {
        if (i > 0 && i % 4 === 0) {
            html += `<span class="marquee-separator">|</span>`;
        }
        html += `<span class="marquee-char">${char}</span>`;
    });
    html += '</span>';

    html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
    marqueeChars.forEach((char, i) => {
        if (i > 0 && i % 4 === 0) {
            html += `<span class="marquee-separator">|</span>`;
        }
        html += `<span class="marquee-char">${char}</span>`;
    });
    html += '</span>';

    track.innerHTML = html;
}

updateMarqueeColors();

// ===== ОБРАТНАЯ БЕГУЩАЯ СТРОКА (СПРАВА НАЛЕВО) =====
function updateReverseMarqueeColors() {
    const track = document.getElementById('marqueeTrackReverse');
    if (!track) return;

    let html = '';
    html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
    marqueeChars.forEach((char, i) => {
        if (i > 0 && i % 4 === 0) {
            html += `<span class="marquee-separator">|</span>`;
        }
        html += `<span class="marquee-char">${char}</span>`;
    });
    html += '</span>';

    html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
    marqueeChars.forEach((char, i) => {
        if (i > 0 && i % 4 === 0) {
            html += `<span class="marquee-separator">|</span>`;
        }
        html += `<span class="marquee-char">${char}</span>`;
    });
    html += '</span>';

    track.innerHTML = html;
}

updateReverseMarqueeColors();

// ===== ВЕРТИКАЛЬНЫЕ БЕГУЩИЕ СТРОКИ =====
function updateVerticalMarqueeColors() {
    // Левая вертикальная строка
    const leftTrack = document.getElementById('marqueeVerticalLeft');
    if (leftTrack) {
        const chars = ['信', '誉', '品', '质', '诚', '信', '合', '作', '共', '赢', '中', '俄', '贸', '易'];
        let html = '';
        chars.forEach(char => {
            html += `<span class="marquee-vertical-char">${char}</span>`;
        });
        // Дублируем для бесконечности
        chars.forEach(char => {
            html += `<span class="marquee-vertical-char">${char}</span>`;
        });
        leftTrack.innerHTML = html;
    }

    // Правая вертикальная строка
    const rightTrack = document.getElementById('marqueeVerticalRight');
    if (rightTrack) {
        const chars = ['福', '祥', '安', '康', '乐', '喜', '寿', '财', '和', '顺', '吉', '庆', '瑞', '宁'];
        let html = '';
        chars.forEach(char => {
            html += `<span class="marquee-vertical-char">${char}</span>`;
        });
        // Дублируем для бесконечности
        chars.forEach(char => {
            html += `<span class="marquee-vertical-char">${char}</span>`;
        });
        rightTrack.innerHTML = html;
    }
}

updateVerticalMarqueeColors();

// ===== ИНИЦИАЛИЗАЦИЯ КАРТЫ =====
const mapContainer = document.getElementById('map');
if (mapContainer) {
    const mapObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                am5.ready(function() {
                    var root = am5.Root.new("ammapContainer");

                    root.setThemes([
                        am5themes_Animated.new(root)
                    ]);

                    var chart = root.container.children.push(
                        am5map.MapChart.new(root, {
                            panX: "none",
                            panY: "none",
                            projection: am5map.geoMercator(),
                            minZoomLevel: 2,
                            maxZoomLevel: 2,
                            wheelable: false,
                            pinchZoom: false
                        })
                    );

                    // Создаем серию полигонов (страны)
                    var polygonSeries = chart.series.push(
                        am5map.MapPolygonSeries.new(root, {
                            geoJSON: am5geodata_worldLow,
                            exclude: ["AQ"]
                        })
                    );

                    polygonSeries.mapPolygons.template.setAll({
                        fill: am5.color(0xf5f5f5),
                        stroke: am5.color(0xffffff),
                        strokeWidth: 0.5,
                        tooltipText: "{name}"
                    });

                    // Подсветка России и Китая
                    polygonSeries.mapPolygons.template.adapters.add("fill", function(fill, target) {
                        if (target.dataItem.get("id") === "RU") {
                            return am5.color(0xeeeeee);
                        }
                        if (target.dataItem.get("id") === "CN") {
                            return am5.color(0xe8e8e8);
                        }
                        return fill;
                    });

                    // Добавляем точки (города)
                    var pointSeries = chart.series.push(
                        am5map.MapPointSeries.new(root, {})
                    );

                    // Города Китая
                    var beijing = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [116.4074, 39.9042] },
                        name: "Пекин",
                        type: "china"
                    });

                    var shanghai = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [121.4737, 31.2304] },
                        name: "Шанхай",
                        type: "china"
                    });

                    var guangzhou = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [113.2644, 23.1291] },
                        name: "Гуанчжоу",
                        type: "china"
                    });

                    // Хаб во Владивостоке
                    var vladivostok = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [131.8856, 43.1056] },
                        name: "Владивосток (Артём)",
                        type: "hub"
                    });

                    // Города России
                    var moscow = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [37.6173, 55.7558] },
                        name: "Москва",
                        type: "russia"
                    });

                    var spb = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [30.3141, 59.9386] },
                        name: "Санкт-Петербург",
                        type: "russia"
                    });

                    var novosibirsk = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [82.9346, 55.0084] },
                        name: "Новосибирск",
                        type: "russia"
                    });

                    var ekaterinburg = pointSeries.pushDataItem({
                        geometry: { type: "Point", coordinates: [60.6122, 56.8389] },
                        name: "Екатеринбург",
                        type: "russia"
                    });

                    // Стили для точек с подписями
                    pointSeries.bullets.push(function(root, series, dataItem) {
                        if (!dataItem || !dataItem.dataContext) {
                            return am5.Bullet.new(root, {
                                sprite: am5.Circle.new(root, {
                                    radius: 5,
                                    fill: am5.color(0x1A1A1A),
                                    stroke: am5.color(0xffffff),
                                    strokeWidth: 2
                                })
                            });
                        }

                        var type = dataItem.dataContext.type;
                        var radius = (type === "hub") ? 8 : 5;
                        var strokeWidth = (type === "hub") ? 3 : 2;

                        var container = am5.Container.new(root, {});

                        var circle = am5.Circle.new(root, {
                            radius: radius,
                            fill: am5.color(0x1A1A1A),
                            stroke: am5.color(0xffffff),
                            strokeWidth: strokeWidth,
                            tooltipText: "{name}"
                        });

                        var label = am5.Label.new(root, {
                            text: "{name}",
                            fontSize: 12,
                            fontWeight: "bold",
                            fill: am5.color(0x000000),
                            centerX: am5.p100,
                            centerY: am5.p0,
                            dx: 12,
                            dy: -8,
                            visible: true,
                            forceHidden: false
                        });

                        container.children.push(circle);
                        container.children.push(label);

                        return am5.Bullet.new(root, {
                            sprite: container
                        });
                    });

                    // Добавляем линии маршрутов
                    var lineSeries = chart.series.push(
                        am5map.MapLineSeries.new(root, {})
                    );

                    // Линии из Китая во Владивосток (импорт)
                    var chinaCities = [beijing, shanghai, guangzhou];

                    chinaCities.forEach(function(city) {
                        lineSeries.pushDataItem({
                            pointsToConnect: [city, vladivostok],
                            stroke: am5.color(0x1A1A1A),
                            strokeWidth: 1.5,
                            strokeDasharray: [8, 4],
                            strokeOpacity: 0.4
                        });
                    });

                    // Линии из Владивостока в города России (доставка)
                    var russiaCities = [moscow, spb, novosibirsk, ekaterinburg];

                    russiaCities.forEach(function(city) {
                        lineSeries.pushDataItem({
                            pointsToConnect: [vladivostok, city],
                            stroke: am5.color(0x1A1A1A),
                            strokeWidth: 1,
                            strokeDasharray: [4, 4],
                            strokeOpacity: 0.2
                        });
                    });

                    // Анимация появления линий
                    lineSeries.mapLines.template.setAll({
                        animationDuration: 2000,
                        animationEasing: am5.ease.out(am5.ease.cubic)
                    });

                    // ВАЖНО: Устанавливаем зум ПОСЛЕ создания всех слоёв
                    setTimeout(function() {
                        chart.zoomToGeoPoint(
                            { longitude: 90, latitude: 55 },
                            3.5,
                            false,
                            0
                        );
                    }, 300);

                });
                mapObserver.disconnect();
            }
        });
    });
    mapObserver.observe(mapContainer);
}

// ===== АНИМАЦИЯ СТАТИСТИКИ =====
(function() {
    const statItems = document.querySelectorAll('.stat-item');
    let animated = false;

    function animateStats() {
        if (animated) return;
        animated = true;

        statItems.forEach(item => {
            const target = parseInt(item.dataset.target);
            if (!target) return;
            const numberEl = item.querySelector('.stat-number');
            let current = 0;
            const step = Math.ceil(target / 50);

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    clearInterval(timer);
                    current = target;
                    numberEl.textContent = current.toLocaleString() + '+';
                } else {
                    numberEl.textContent = current.toLocaleString() + '+';
                }
            }, 20);
        });
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateStats();
                observer.disconnect();
            }
        });
    }, { threshold: 0.3 });

    if (statItems.length) observer.observe(statItems[0]);
})();

// ===== КАРУСЕЛЬ НА HERO С ПЛАВНЫМИ ПЕРЕХОДАМИ =====
(function() {
    const track = document.getElementById('carouselTrack');
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    const glow = document.getElementById('heroGlow');
    const counter = document.getElementById('carouselCounter');
    const root = document.documentElement;

    if (!track || !slides.length) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    let autoPlayInterval;
    let isInteracting = false;
    let isTransitioning = false;

    function updateAccentColor(index) {
        const slide = slides[index];
        if (!slide) return;

        const accent = slide.dataset.accent || '#FF6B00';
        const hex = accent.replace('#', '');
        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        root.style.setProperty('--carousel-accent-r', r);
        root.style.setProperty('--carousel-accent-g', g);
        root.style.setProperty('--carousel-accent-b', b);

        if (glow) {
            glow.style.opacity = '0';
            setTimeout(() => {
                glow.style.background = `radial-gradient(circle, rgba(${r}, ${g}, ${b}, 0.3) 0%, transparent 70%)`;
                glow.style.opacity = '0.3';
            }, 50);
        }

        // Обновляем цвета для всех бегущих строк
        document.querySelectorAll('.hanzi-decor, .marquee-char, .marquee-separator, .marquee-vertical-char').forEach(el => {
            el.style.color = `rgb(${r}, ${g}, ${b})`;
        });
    }

    function updateCounter(index) {
        if (!counter) return;
        const num = String(index + 1).padStart(2, '0');
        const total = String(totalSlides).padStart(2, '0');
        counter.textContent = `${num} / ${total}`;
    }

    function goToSlide(index) {
        if (isTransitioning) return;
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;

        isTransitioning = true;
        currentIndex = index;

        requestAnimationFrame(() => {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
        });

        slides.forEach((slide, i) => {
            slide.classList.toggle('active-slide', i === currentIndex);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });

        updateAccentColor(currentIndex);
        updateCounter(currentIndex);

        setTimeout(() => {
            isTransitioning = false;
        }, 800);
    }

    function nextSlide() {
        if (!isTransitioning) goToSlide(currentIndex + 1);
    }

    function prevSlide() {
        if (!isTransitioning) goToSlide(currentIndex - 1);
    }

    function startAutoPlay() {
        stopAutoPlay();
        autoPlayInterval = setInterval(() => {
            if (!isInteracting && !isTransitioning) nextSlide();
        }, 6000);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    prevBtn?.addEventListener('click', () => { prevSlide(); stopAutoPlay(); startAutoPlay(); });
    nextBtn?.addEventListener('click', () => { nextSlide(); stopAutoPlay(); startAutoPlay(); });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index);
            if (index !== currentIndex && !isTransitioning) {
                goToSlide(index);
                stopAutoPlay();
                startAutoPlay();
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') { prevSlide(); stopAutoPlay(); startAutoPlay(); }
        if (e.key === 'ArrowRight') { nextSlide(); stopAutoPlay(); startAutoPlay(); }
    });

    const container = track.closest('.carousel-container');
    container?.addEventListener('mouseenter', () => { isInteracting = true; });
    container?.addEventListener('mouseleave', () => { isInteracting = false; });

    let touchStartX = 0;
    let touchStartY = 0;

    track.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
        isInteracting = true;
    }, { passive: true });

    track.addEventListener('touchend', (e) => {
        const diffX = touchStartX - e.changedTouches[0].screenX;
        const diffY = Math.abs(touchStartY - e.changedTouches[0].screenY);
        isInteracting = false;

        if (Math.abs(diffX) > 40 && Math.abs(diffX) > diffY * 1.5) {
            diffX > 0 ? nextSlide() : prevSlide();
            stopAutoPlay();
            startAutoPlay();
        }
    }, { passive: true });

    goToSlide(0);
    startAutoPlay();

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) stopAutoPlay();
        else startAutoPlay();
    });
})();

// ===== ПЛАВНЫЙ СКРОЛЛ =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href');

        if (!targetId || targetId === '#') {
            e.preventDefault();
            return;
        }

        e.preventDefault();
        const target = document.querySelector(targetId);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

console.log('✅ Home page initialized');
