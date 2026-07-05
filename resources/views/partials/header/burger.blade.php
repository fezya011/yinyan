{{-- partials/header/burger.blade.php --}}
<button id="menuToggle"
        class="lg:hidden relative w-10 h-10 flex items-center justify-center z-[1002]"
        aria-label="Меню"
        aria-expanded="false">
    <div class="w-5 h-5 relative">
        <span class="block absolute w-full h-[2px] bg-black/70 rounded-full transition-all duration-300 top-0" id="bar1"></span>
        <span class="block absolute w-full h-[2px] bg-black/70 rounded-full transition-all duration-300 top-1/2 -translate-y-1/2" id="bar2"></span>
        <span class="block absolute w-full h-[2px] bg-black/70 rounded-full transition-all duration-300 bottom-0" id="bar3"></span>
    </div>
</button>
