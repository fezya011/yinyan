{{-- admin/dashboard/partials/stats.blade.php --}}
<div class="stat-grid mb-8">
    <a href="{{ route('admin.products.index') }}" class="stat-card" data-aos="fade-up" data-aos-delay="0">
        <span class="stat-index">01</span>
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-label">Всего товаров</div>
    </a>

    <a href="{{ route('admin.products.index', ['status' => 'active']) }}" class="stat-card" data-aos="fade-up" data-aos-delay="50">
        <span class="stat-index">02</span>
        <div class="stat-value">{{ $stats['active_products'] }}</div>
        <div class="stat-label">Активных товаров</div>
    </a>

    <a href="{{ route('admin.categories.index') }}" class="stat-card" data-aos="fade-up" data-aos-delay="100">
        <span class="stat-index">03</span>
        <div class="stat-value">{{ $stats['total_categories'] }}</div>
        <div class="stat-label">Категорий</div>
    </a>

    <a href="{{ route('admin.leads.index', ['status' => 'new']) }}" class="stat-card" data-aos="fade-up" data-aos-delay="150">
        <span class="stat-index">04</span>
        <div class="stat-value">{{ $stats['new_leads'] }}</div>
        <div class="stat-label">Новых заявок</div>
    </a>
</div>
