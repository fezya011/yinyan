{{-- admin/leads/partials/filters.blade.php --}}
<form method="GET" action="{{ route('admin.leads.index') }}" class="leads-filters mb-6">
    <div class="filter-group">
        <input class="form-control" type="text" name="search"
               value="{{ request('search') }}"
               placeholder="Поиск по имени, телефону, email...">
    </div>
    <div class="filter-group">
        <input class="form-control" type="date" name="date_from"
               value="{{ request('date_from') }}" placeholder="С">
    </div>
    <div class="filter-group">
        <input class="form-control" type="date" name="date_to"
               value="{{ request('date_to') }}" placeholder="По">
    </div>
    <div class="filter-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
            Фильтр
        </button>
        <a href="{{ route('admin.leads.index') }}" class="btn btn-outline">
            <i class="fas fa-times"></i>
            Сброс
        </a>
    </div>
</form>
