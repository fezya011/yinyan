{{-- pages/about/partials/history.blade.php --}}
<section class="section-padding px-6 md:px-12 lg:px-16 section-with-hanzi">
    <span class="section-label" data-aos="fade-up">История</span>
    <h2 class="section-title max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
        Как мы росли
    </h2>

    <div class="history-timeline">
        @php
            $history = [
                ['year' => '2014', 'title' => 'Основание компании', 'desc' => 'Инь Ян начинает свою деятельность как небольшой импортёр продуктов питания из Китая.'],
                ['year' => '2016', 'title' => 'Расширение ассортимента', 'desc' => 'Первые прямые контракты с крупными фабриками. Запуск поставок лапши и вонтонов.'],
                ['year' => '2018', 'title' => 'Собственный склад', 'desc' => 'Открытие склада в Артёме. Поставки по Дальнему Востоку и в центральную Россию.'],
                ['year' => '2020', 'title' => 'Сертификация', 'desc' => 'Получение всех необходимых сертификатов ЕАС, внедрение системы Честный знак.'],
                ['year' => '2023', 'title' => 'Новые горизонты', 'desc' => 'Запуск собственной линии продуктов. Рост клиентской базы до 100+ постоянных партнёров.'],
            ];
        @endphp

        @foreach($history as $index => $item)
            <div class="history-item" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 50 }}">
                <div class="history-year">{{ $item['year'] }}</div>
                <div class="history-content">
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <span class="hanzi-decor lg rotate-n10" style="top: 0; right: 3%; opacity: 0.025;">史</span>
    <span class="hanzi-decor md rotate-8" style="bottom: 5%; left: 3%; opacity: 0.02;">历</span>
</section>
