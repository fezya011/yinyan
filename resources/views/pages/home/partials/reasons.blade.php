{{-- pages/home/partials/reasons.blade.php --}}
<section class="px-6 md:px-12 lg:px-16 py-[60px] lg:py-[80px] section-with-hanzi" id="why">
    <p class="text-[9px] tracking-[4px] uppercase text-[#1A1A1A]/40 mb-3" data-aos="fade-up">О нас</p>
    <div class="flex items-center gap-4 mb-[48px]" data-aos="fade-up" data-aos-delay="100">
        <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight text-[#1A1A1A]">
            Партнёры доверяют нам
        </h2>
        <span class="hidden md:block flex-1 h-[1px] bg-[#1A1A1A]/10"></span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $reasons = [
                [
                    'num' => '01',
                    'title' => 'Выгода',
                    'desc' => 'Прямой импорт без посредников. Никаких наценок в цепочке поставок.',
                ],
                [
                    'num' => '02',
                    'title' => 'Надёжность',
                    'desc' => 'Декларации, ЕАС, Честный знак — всё оформлено под ключ.',
                ],
                [
                    'num' => '03',
                    'title' => 'Оперативность',
                    'desc' => 'Собственный склад. Отгрузка на следующий день после оплаты.',
                ],
            ];
        @endphp

        @foreach($reasons as $index => $reason)
            <div class="group relative bg-white p-8 lg:p-10 border border-[#1A1A1A]/5 transition-all duration-300 hover:border-[#1A1A1A]/20 hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)] hover:-translate-y-1"
                 data-aos="fade-up" data-aos-delay="{{ 150 + $index * 100 }}">
                <div class="flex items-center justify-center w-14 h-14 rounded-full border border-[#1A1A1A]/10 text-[#1A1A1A] font-black text-2xl mb-6 transition-colors duration-300 group-hover:border-[#1A1A1A]/30 group-hover:bg-[#1A1A1A]/5">
                    {{ $reason['num'] }}
                </div>
                <div class="font-bold text-[11px] tracking-[3px] uppercase text-[#1A1A1A] mb-3">
                    {{ $reason['title'] }}
                </div>
                <p class="text-[15px] text-[#1A1A1A]/50 leading-relaxed font-light">
                    {{ $reason['desc'] }}
                </p>
            </div>
        @endforeach
    </div>
</section>
