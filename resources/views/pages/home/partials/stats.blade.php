{{-- pages/home/partials/stats.blade.php --}}
<div class="bg-white py-13">
    <div class="grid grid-cols-2 lg:grid-cols-4 stats-grid section-with-hanzi">
        @php
            $stats = [
                ['number' => '10 000+', 'label' => 'Тонн импортировано'],
                ['number' => '100+', 'label' => 'Активных клиентов'],
                ['number' => '98%', 'label' => 'Поставок вовремя'],
                ['number' => '10+', 'label' => 'Лет на рынке'],
            ];
        @endphp

        @foreach($stats as $index => $stat)
            @include('components.home.stat-item', [
                'number' => $stat['number'],
                'label' => $stat['label'],
                'index' => $index,
            ])
        @endforeach
    </div>
</div>
