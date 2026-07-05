{{-- pages/catalog/partials/search-bar.blade.php --}}
<div class="search-bar">
    <input
        type="text"
        id="searchInput"
        placeholder="Поиск по названию, описанию..."
        value="{{ request('search') }}"
    >
    <button class="clear-search" id="clearSearch" style="{{ request('search') ? 'display:block' : 'none' }}">×</button>
    <span class="search-icon">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <circle cx="7" cy="7" r="5.5" stroke="currentColor" stroke-width="1.5"/>
            <path d="M11 11l3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </span>
</div>
