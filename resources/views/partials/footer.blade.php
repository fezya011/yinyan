<!-- ===== FOOTER ===== -->
<footer class="border-t border-black/5 px-6 md:px-12 lg:px-16 py-6 flex flex-col md:flex-row justify-between items-center gap-3 bg-white">
    <div class="flex items-center gap-3">
        <img
            src="{{ asset('images/logo.png') }}"
            alt="Инь Ян"
            class="w-6 h-6 rounded-full opacity-40"
            onerror="this.style.background='#F3F4F6'"
        >
        <span class="font-bold text-[10px] tracking-[3px] uppercase text-black/30">Инь Ян</span>
    </div>
    <div class="text-[11px] text-black/20">© {{ date('Y') }} ООО «Экспорт-Импорт Инь-Ян»</div>
</footer>
