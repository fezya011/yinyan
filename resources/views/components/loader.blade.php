<div id="loadingScreen" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center overflow-hidden">
    <canvas id="matrixCanvas" class="absolute inset-0"></canvas>
    <div class="relative z-10 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full overflow-hidden bg-white/80 backdrop-blur-sm border border-black/[0.06] flex items-center justify-center shadow-sm">
            <img src="{{ asset('images/logo.png') }}" alt="Инь Ян" class="w-full h-full object-cover" onerror="this.style.display='none'">
        </div>
        <div class="font-light text-sm tracking-[3px] uppercase text-black/20 bg-white/80 inline-block px-4 py-1 rounded-full">
            Загрузка
        </div>
    </div>
</div>

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        #loadingScreen {
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #loadingScreen.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        @media (prefers-reduced-motion: reduce) {
            #loadingScreen { display: none !important; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function() {
            const canvas = document.getElementById('matrixCanvas');
            const loadingScreen = document.getElementById('loadingScreen');
            if (!canvas || !loadingScreen) return;

            const ctx = canvas.getContext('2d');
            const chars = '阴阳道和福龙宝祥安信誉品质为本诚信合作共赢未来中俄贸易直接进口天地人金木水火土山水风云雨雪日月星';

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }

            // Больше колонок — плотнее
            const fontSize = 14;
            let columns;
            let drops = [];

            const colors = [
                'rgba(255, 107, 0, 0.15)',
                'rgba(255, 107, 0, 0.18)',
                'rgba(255, 107, 0, 0.12)',
                'rgba(255, 107, 0, 0.2)',
                'rgba(0, 0, 0, 0.08)',
                'rgba(0, 0, 0, 0.1)',
                'rgba(0, 0, 0, 0.06)',
                'rgba(255, 140, 0, 0.14)',
                'rgba(255, 80, 0, 0.16)',
            ];

            function initDrops() {
                // Уменьшаем шаг — больше колонок
                const tightFontSize = 12;
                columns = Math.floor(canvas.width / tightFontSize) + 1;
                drops = [];
                for (let i = 0; i < columns; i++) {
                    drops[i] = {
                        y: Math.random() * canvas.height, // Начинают по всему экрану
                        speed: Math.random() * 3 + 2,
                        charIndex: Math.floor(Math.random() * chars.length),
                        fontSize: Math.random() * 24 + 14,
                        color: colors[Math.floor(Math.random() * colors.length)],
                        nextChange: Math.random() * 50,
                    };
                }
            }

            function draw() {
                // Не затираем полностью — иероглифы накладываются
                ctx.fillStyle = 'rgba(255, 255, 255, 0.03)';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                for (let i = 0; i < drops.length; i++) {
                    const drop = drops[i];
                    const char = chars[drop.charIndex];
                    const x = i * 12 + (Math.random() - 0.5) * 8;

                    // Основной иероглиф
                    ctx.font = `900 ${drop.fontSize}px "Noto Serif SC", serif`;
                    ctx.fillStyle = drop.color;
                    ctx.fillText(char, x, drop.y);

                    // Второй иероглиф рядом — почти всегда
                    if (Math.random() > 0.4) {
                        const extraChar = chars[Math.floor(Math.random() * chars.length)];
                        const offsetX = (Math.random() - 0.5) * 40;
                        const offsetY = (Math.random() - 0.5) * 35;
                        ctx.font = `900 ${drop.fontSize * (Math.random() * 0.5 + 0.6)}px "Noto Serif SC", serif`;
                        ctx.fillStyle = colors[Math.floor(Math.random() * colors.length)];
                        ctx.fillText(extraChar, x + offsetX, drop.y + offsetY);
                    }

                    // Третий — иногда
                    if (Math.random() > 0.7) {
                        const thirdChar = chars[Math.floor(Math.random() * chars.length)];
                        const offsetX3 = (Math.random() - 0.5) * 60;
                        const offsetY3 = (Math.random() - 0.5) * 50;
                        ctx.font = `900 ${drop.fontSize * 0.5}px "Noto Serif SC", serif`;
                        ctx.fillStyle = colors[Math.floor(Math.random() * colors.length)];
                        ctx.fillText(thirdChar, x + offsetX3, drop.y + offsetY3);
                    }

                    // Движение
                    drop.y += drop.speed;

                    // Меняем символ иногда
                    drop.nextChange--;
                    if (drop.nextChange <= 0) {
                        drop.charIndex = Math.floor(Math.random() * chars.length);
                        drop.nextChange = Math.random() * 30 + 10;
                    }

                    // Сброс когда упал
                    if (drop.y > canvas.height + 100) {
                        drop.y = Math.random() * -150 - 20;
                        drop.speed = Math.random() * 3 + 2;
                        drop.charIndex = Math.floor(Math.random() * chars.length);
                        drop.fontSize = Math.random() * 24 + 14;
                        drop.color = colors[Math.floor(Math.random() * colors.length)];
                    }
                }
            }

            let animationId;
            function animate() {
                draw();
                animationId = requestAnimationFrame(animate);
            }

            resizeCanvas();
            initDrops();
            animate();

            window.addEventListener('resize', () => {
                resizeCanvas();
                initDrops();
            });

            window.addEventListener('load', () => {
                setTimeout(() => {
                    loadingScreen.classList.add('hidden');
                    setTimeout(() => cancelAnimationFrame(animationId), 600);
                }, 600);
            });

            setTimeout(() => {
                if (!loadingScreen.classList.contains('hidden')) {
                    loadingScreen.classList.add('hidden');
                    setTimeout(() => cancelAnimationFrame(animationId), 600);
                }
            }, 3000);
        })();
    </script>
@endpush
