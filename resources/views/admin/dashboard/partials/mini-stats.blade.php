{{-- admin/dashboard/partials/mini-stats.blade.php --}}
<div class="mini-stat-grid" data-aos="fade-up" data-aos-delay="250">
    <div class="mini-stat">
        <div class="value">{{ $stats['active_leads'] }}</div>
        <div class="label">Активных заявок</div>
    </div>
    <div class="mini-stat">
        <div class="value">{{ $stats['won_leads'] }}</div>
        <div class="label">Выигранных</div>
    </div>
    <div class="mini-stat">
        <div class="value">{{ $stats['today_leads'] }}</div>
        <div class="label">За сегодня</div>
    </div>
    <div class="mini-stat">
        <div class="value">{{ $stats['this_month_leads'] }}</div>
        <div class="label">За месяц</div>
    </div>
</div>
