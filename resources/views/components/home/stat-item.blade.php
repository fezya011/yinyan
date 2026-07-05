{{-- components/home/stat-item.blade.php --}}
<div class="px-6 py-8 lg:p-10 text-center border-r {{ $loop->last ? 'border-r-0' : '' }} {{ $loop->index === 1 ? 'max-lg:border-r-0' : '' }} transition-colors duration-300 hover:bg-black/5 stat-item"
     data-aos="fade-up"
     data-aos-delay="{{ 100 + ($index ?? 0) * 100 }}"
     data-target="{{ preg_replace('/[^0-9]/', '', $number) }}">
    <div class="font-black text-[32px] lg:text-[40px] text-[#1A1A1A] tracking-[-1px] leading-none stat-number">{{ $number }}</div>
    <div class="text-[9px] tracking-[2px] uppercase text-[#1A1A1A]/40 mt-2">{{ $label }}</div>
</div>
