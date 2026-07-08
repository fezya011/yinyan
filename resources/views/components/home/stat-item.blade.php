{{-- components/home/stat-item.blade.php --}}
<div class="px-6 py-8 lg:p-10 text-center border-r {{ $loop->last ? 'border-r-0' : '' }} {{ $loop->index === 1 ? 'max-lg:border-r-0' : '' }} transition-all duration-700 ease-out hover:bg-black/[0.02] stat-item group cursor-default relative"
     style="background: #FFFFFF !important; transition: all 0.7s cubic-bezier(0.23, 1, 0.32, 1);"
     data-aos="fade-up"
     data-aos-delay="{{ 100 + ($index ?? 0) * 100 }}"
     data-target="{{ preg_replace('/[^0-9]/', '', $number) }}">

    {{-- Число --}}
    <div class="font-black text-[32px] lg:text-[40px] text-[#1A1A1A] tracking-[-1px] leading-none stat-number"
         style="background: transparent; transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);">
        {{ $number }}
    </div>

    {{-- Метка --}}
    <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-2"
         style="background: transparent; transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);">
        {{ $label }}
    </div>

    {{-- Акцентная точка снизу --}}
    <div class="w-0 h-[2px] bg-[#1A1A1A]/20 mx-auto mt-4 rounded-full"
         style="background: rgba(26, 26, 26, 0.1); transition: all 0.7s cubic-bezier(0.23, 1, 0.32, 1);"></div>
</div>

<style>
    .stat-item:hover .stat-number {
        transform: scale(1.05);
    }
    .stat-item:hover .stat-label {
        color: rgba(26, 26, 26, 0.7);
        letter-spacing: 3px;
    }
    .stat-item:hover div:last-child {
        width: 40px;
        background-color: rgba(26, 26, 26, 0.3) !important;
    }
</style>
