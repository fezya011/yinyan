{{-- pages/about/partials/values.blade.php --}}
<section class="section-padding px-6 md:px-12 lg:px-16 section-with-hanzi">
    <span class="section-label" data-aos="fade-up">Ценности</span>
    <h2 class="section-title max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
        Наши принципы
    </h2>

    <div class="values-grid">
        @php
            $values = [
                ['num' => '一', 'title' => 'Честность', 'desc' => 'Прозрачные условия, без скрытых комиссий и наценок.'],
                ['num' => '二', 'title' => 'Скорость', 'desc' => 'Отгрузка на следующий день. Собственный склад.'],
                ['num' => '三', 'title' => 'Юридическая чистота', 'desc' => 'Все документы, сертификаты, ЕАС и Честный знак.'],
                ['num' => '四', 'title' => 'Качество', 'desc' => 'Только проверенные производители и контроль каждой партии.'],
            ];
        @endphp

        @foreach($values as $index => $value)
            <div class="value-card" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 80 }}">
                <span class="value-number">{{ $value['num'] }}</span>
                <div class="title">{{ $value['title'] }}</div>
                <div class="desc">{{ $value['desc'] }}</div>
            </div>
        @endforeach
    </div>

    <span class="hanzi-decor md rotate-10" style="top: 10%; left: 2%; opacity: 0.02;">义</span>
    <span class="hanzi-decor sm rotate-n8" style="bottom: 10%; right: 5%; opacity: 0.02;">礼</span>
</section>
