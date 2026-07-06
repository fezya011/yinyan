{{-- pages/contacts/partials/map.blade.php --}}
<section class="map-section" data-aos="fade-up">
    <div class="container mx-auto px-4 md:px-8 lg:px-12">
        <div class="map-header">
            <div class="flex items-center gap-3 mb-4">
                <span class="w-2 h-2 rounded-full bg-[rgb(var(--carousel-accent-r),var(--carousel-accent-g),var(--carousel-accent-b))]"></span>
                <span class="text-[10px] tracking-[3px] uppercase font-medium text-gray-400">География</span>
            </div>
            <h2 class="font-black text-[clamp(26px,3vw,40px)] uppercase tracking-[-1px] leading-tight text-[#1A1A1A]">
                Наш офис и склад
            </h2>
            <p class="text-[14px] text-[#1A1A1A]/40 mt-2 font-light max-w-[480px]">
                Приморский край, г. Артём — основной хаб поставок из Китая
            </p>
        </div>

        <div class="map-wrapper">
            <div class="map-container" id="mapContainer">
                <!-- Карта будет вставлена сюда через JS -->
                <div id="map" class="w-full h-full"></div>
            </div>

        </div>
    </div>
</section>

