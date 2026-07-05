{{-- pages/home/partials/map.blade.php --}}
<section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] bg-white section-with-hanzi"
         id="map"
         style="border-top: 1px solid rgba(26,26,26,0.04); position: relative;">



    <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">География</p>
    <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight max-w-[540px] mb-[48px] text-[#1A1A1A]"
        data-aos="fade-up" data-aos-delay="100">
        Маршруты поставок
    </h2>

    <div class="relative" data-aos="fade-up" data-aos-delay="200">
        <div class="relative w-full border border-[#1A1A1A]/8 overflow-hidden bg-[#FAFAFA]">
            <span class="hanzi-decor lg rotate-5" style="top: 15%; right: 15%; opacity: 0.02;">通</span>
            <span class="hanzi-decor md rotate-n12" style="bottom: 25%; left: 15%; opacity: 0.02;">达</span>
            <div id="ammapContainer"></div>

            <div class="absolute bottom-4 left-4 right-4 z-10 flex flex-wrap gap-3">
                <div class="bg-white/90 backdrop-blur-sm border border-[#1A1A1A]/8 px-4 py-3 shadow-sm flex-1 min-w-[140px]">
                    <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/35 mb-1 font-medium">Прямые поставки</div>
                    <div class="font-bold text-xs text-[#1A1A1A]">Пекин, Шанхай, Гуанчжоу</div>
                </div>
                <div class="bg-white/90 backdrop-blur-sm border border-[#1A1A1A]/8 px-4 py-3 shadow-sm flex-1 min-w-[140px]">
                    <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/35 mb-1 font-medium">Основной хаб</div>
                    <div class="font-bold text-xs text-[#1A1A1A]">Владивосток (г. Артём)</div>
                </div>
                <div class="bg-white/90 backdrop-blur-sm border border-[#1A1A1A]/8 px-4 py-3 shadow-sm flex-1 min-w-[140px]">
                    <div class="text-[7px] tracking-[2px] uppercase text-[#1A1A1A]/35 mb-1 font-medium">География</div>
                    <div class="font-bold text-xs text-[#1A1A1A]">Вся Россия</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-8 mt-8 text-center">
            <div>
                <div class="font-black text-2xl text-[#1A1A1A]">3</div>
                <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-1">Города в Китае</div>
            </div>
            <div>
                <div class="font-black text-2xl text-[#1A1A1A]">14-21</div>
                <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-1">Дней доставки</div>
            </div>
            <div>
                <div class="font-black text-2xl text-[#1A1A1A]">50+</div>
                <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-1">Городов в РФ</div>
            </div>
        </div>
    </div>
</section>
