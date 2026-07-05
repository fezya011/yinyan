{{-- pages/home/partials/hero.blade.php --}}
<section class="hero-section">
    {{-- Левая колонка --}}
    <div class="hero-left">
        <div class="hero-badge" data-aos="fade-up" data-aos-duration="600">
            <span class="hero-badge-dot"></span>
            Прямой импортёр №1 в РФ
        </div>

        <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
            Экспорт<br>
            <span class="hero-title-outline">Импорт</span><br>
            Инь-Ян
        </h1>

        <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">
            Оптовые поставки продуктов питания из Китая.<br>
            Прямой импорт без посредников. Работаем с 2013 года.
        </p>

        <div class="hero-min-order" data-aos="fade-up" data-aos-delay="150">
            <span class="min-order-label">Минимальный заказ</span>
            <span class="min-order-amount">100 000 ₽</span>
        </div>

        <div class="hero-extra-info" data-aos="fade-up" data-aos-delay="200">
            <div class="hero-extra-item">
                <span class="label">Склад в РФ</span>
                <span class="value">г. Артём, Приморский край</span>
            </div>
            <div class="hero-extra-item">
                <span class="label">Доставка</span>
                <span class="value">По всей России</span>
            </div>
            <div class="hero-extra-item">
                <span class="label">Ассортимент</span>
                <span class="value">50+ позиций</span>
            </div>
            <div class="hero-extra-item">
                <span class="label">Гарантия</span>
                <span class="value">100% качество</span>
            </div>
        </div>

        <div class="hero-buttons" data-aos="fade-up" data-aos-delay="300">
            <a href="#contacts" class="btn-primary">Запросить прайс</a>
            <a href="#products" class="btn-ghost">Каталог</a>
        </div>

        {{-- Иероглифы --}}
        @include('components.home.hanzi-decor')
    </div>

    {{-- Правая колонка - карусель --}}
    <div class="hero-right" data-aos="fade-in" data-aos-delay="200" data-aos-duration="700">
        <div class="hero-right-glow visible" id="heroGlow"></div>
        @include('components.home.carousel', ['slides' => $slides])
    </div>

    <div id="heroGlow"></div>
</section>
