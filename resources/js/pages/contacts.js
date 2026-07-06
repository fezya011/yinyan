document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            once: true,
            offset: 30,
            easing: 'ease-out'
        });
    }

    initMarquee();
    initYandexMap();
});

function initMarquee() {
    const track = document.getElementById('marqueeTrackContacts');
    if (!track) return;

    const chars = ['联', '系', '我', '们', '合', '作', '共', '赢', '信', '誉', '第', '一', '品', '质', '为', '本', '诚', '信', '合', '作', '共', '赢', '未', '来'];

    let html = '';
    html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
    chars.forEach((char, i) => {
        if (i > 0 && i % 4 === 0) {
            html += `<span class="marquee-separator-gray">|</span>`;
        }
        html += `<span class="marquee-char-gray">${char}</span>`;
    });
    html += '</span>';

    html += '<span style="display: inline-flex; align-items: center; gap: 48px; padding-right: 48px;">';
    chars.forEach((char, i) => {
        if (i > 0 && i % 4 === 0) {
            html += `<span class="marquee-separator-gray">|</span>`;
        }
        html += `<span class="marquee-char-gray">${char}</span>`;
    });
    html += '</span>';

    track.innerHTML = html;
}

const OFFICE_COORDS = {
    lat: 43.337069,
    lng: 132.129126
};

function initYandexMap() {
    const container = document.getElementById('map');
    if (!container) return;

    const apiKey = window.YANDEX_API_KEY || '822250a3-3af5-4813-a520-f28c6c81ceb8';

    if (typeof ymaps === 'undefined') {
        const script = document.createElement('script');
        script.src = `https://api-maps.yandex.ru/2.1/?apikey=${apiKey}&lang=ru_RU`;
        script.type = 'text/javascript';
        script.onload = function() {
            ymaps.ready(renderYandexMap);
        };
        script.onerror = function() {
            console.warn('⚠️ Yandex Maps loading failed, using OpenStreetMap fallback');
            initOSMFallback();
        };
        document.head.appendChild(script);
    } else {
        ymaps.ready(renderYandexMap);
    }
}

function renderYandexMap() {
    const container = document.getElementById('map');
    if (!container) return;

    try {
        const map = new ymaps.Map(container, {
            center: [OFFICE_COORDS.lat, OFFICE_COORDS.lng],
            zoom: 17,
            controls: ['zoomControl', 'fullscreenControl']
        });

        const placemark = new ymaps.Placemark(
            [OFFICE_COORDS.lat, OFFICE_COORDS.lng],
            {
                balloonContent: `
                    <div style="font-family: 'Inter', sans-serif; padding: 8px;">
                        <strong style="font-size: 16px; display: block; margin-bottom: 4px;">Инь Ян</strong>
                        <span style="color: #666; font-size: 13px; display: block;">г. Артём, ул. Постникова, д. 2а, каб. 21</span>
                        <span style="color: #666; font-size: 13px; display: block;">Приморский край</span>
                        <span style="color: #999; font-size: 11px; display: block; margin-top: 4px;">Склад и офис</span>
                    </div>
                `,
                hintContent: 'Инь Ян — офис и склад'
            },
            {
                preset: 'islands#darkBlueCircleDotIconWithCaption',
                iconColor: '#1A1A1A'
            }
        );

        map.geoObjects.add(placemark);
        map.behaviors.disable('scrollZoom');

        setTimeout(() => {
            map.container.fitToViewport();
        }, 300);

        window.addEventListener('resize', function() {
            map.container.fitToViewport();
        });

    } catch (error) {
        console.warn('⚠️ Yandex Maps error, using OpenStreetMap fallback');
        initOSMFallback();
    }
}

function initOSMFallback() {
    const container = document.getElementById('map');
    if (!container) return;

    if (typeof L === 'undefined') {
        const cssLink = document.createElement('link');
        cssLink.rel = 'stylesheet';
        cssLink.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        document.head.appendChild(cssLink);

        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.onload = function() {
            renderOSMMap(container);
        };
        document.head.appendChild(script);
    } else {
        renderOSMMap(container);
    }
}

function renderOSMMap(container) {
    const map = L.map(container, {
        zoomControl: true,
        scrollWheelZoom: false,
        attributionControl: false
    }).setView([OFFICE_COORDS.lat, OFFICE_COORDS.lng], 17);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const customIcon = L.divIcon({
        className: 'custom-marker',
        html: `<div style="
            width: 44px;
            height: 44px;
            background: #1A1A1A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-family: 'Noto Serif SC', serif;
            font-size: 20px;
            font-weight: 900;
            border: 2px solid #FFFFFF;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        ">位</div>`,
        iconSize: [44, 44],
        iconAnchor: [22, 44],
        popupAnchor: [0, -44]
    });

    L.marker([OFFICE_COORDS.lat, OFFICE_COORDS.lng], { icon: customIcon })
        .addTo(map)
        .bindPopup(`
            <div style="font-family: 'Inter', sans-serif; padding: 4px;">
                <strong>Инь Ян</strong><br>
                <span style="color: #666; font-size: 13px;">г. Артём, ул. Постникова, д. 2а, каб. 21</span><br>
                <span style="color: #666; font-size: 13px;">Приморский край</span>
            </div>
        `);

    setTimeout(() => map.invalidateSize(), 300);
    window.addEventListener('resize', () => map.invalidateSize());
}
