{{-- partials/header/logo.blade.php --}}
<a href="/" class="flex items-center flex-shrink-0 group">
    <div class="relative w-10 h-10 lg:w-[56px] lg:h-[56px] transition-all duration-500 group-hover:scale-105">
        <div class="absolute inset-0 rounded-full overflow-hidden bg-black/5 border border-black/10 transition-all duration-500 group-hover:border-black/30 group-hover:shadow-lg">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Инь Ян"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                 onerror="this.style.display='none'">
        </div>
    </div>
</a>
