{{-- pages/about/partials/certificates.blade.php --}}
<section class="section-padding px-6 md:px-12 lg:px-16 section-with-hanzi">
    <span class="section-label" data-aos="fade-up">Сертификаты</span>
    <h2 class="section-title max-w-[540px]" data-aos="fade-up" data-aos-delay="100">
        Работаем по закону
    </h2>

    <div class="cert-grid">
        @php
            $certs = [
                ['num' => '文', 'name' => 'Декларации ЕАС', 'desc' => 'Все продукты сертифицированы'],
                ['num' => '章', 'name' => 'Честный знак', 'desc' => 'Маркировка под ключ'],
                ['num' => '号', 'name' => 'ОГРН', 'desc' => '1232500004846'],
                ['num' => '证', 'name' => 'ИНН / КПП', 'desc' => '2502071087 / 250201001'],
            ];
        @endphp

        @foreach($certs as $index => $cert)
            <div class="cert-item" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 80 }}">
                <span class="cert-number">{{ $cert['num'] }}</span>
                <div class="name">{{ $cert['name'] }}</div>
                <div class="desc">{{ $cert['desc'] }}</div>
            </div>
        @endforeach
    </div>

    <span class="hanzi-decor md rotate-n10" style="top: 5%; right: 2%; opacity: 0.02;">证</span>
    <span class="hanzi-decor sm rotate-8" style="bottom: 5%; left: 2%; opacity: 0.02;">书</span>
</section>
