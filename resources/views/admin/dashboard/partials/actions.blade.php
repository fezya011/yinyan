{{-- admin/dashboard/partials/actions.blade.php --}}
<div class="actions-grid mb-8">
    <a href="{{ route('admin.products.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="0">
        <span class="action-index">+</span>
        <span class="action-title">Добавить товар</span>
        <span class="action-desc">Новая позиция в каталог</span>
    </a>

    <a href="{{ route('admin.categories.create') }}" class="action-card" data-aos="fade-up" data-aos-delay="50">
        <span class="action-index">+</span>
        <span class="action-title">Добавить категорию</span>
        <span class="action-desc">Структурировать каталог</span>
    </a>

    <a href="{{ route('admin.leads.index') }}" class="action-card" data-aos="fade-up" data-aos-delay="100">
        <span class="action-index">→</span>
        <span class="action-title">Все заявки</span>
        <span class="action-desc">Просмотр и обработка</span>
    </a>

    <a href="{{ route('admin.leads.export-page') }}" class="action-card" data-aos="fade-up" data-aos-delay="150">
        <span class="action-index">↓</span>
        <span class="action-title">Экспорт заявок</span>
        <span class="action-desc">Выгрузить в CSV</span>
    </a>
</div>
