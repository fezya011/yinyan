// resources/js/pages/catalog.js

(function() {
    'use strict';

    // Получаем данные из глобальной переменной
    const initialFilters = window.catalogData?.filters || {};
    const catalogUrl = window.catalogData?.catalogUrl || '/catalog';

    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const catalogGrid = document.getElementById('catalogGrid');
    const paginationContainer = document.getElementById('paginationContainer');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const activeFiltersContainer = document.getElementById('activeFilters');
    const toggleAdvanced = document.getElementById('toggleAdvanced');
    const advancedFilters = document.getElementById('advancedFilters');

    let filters = { ...initialFilters };
    let searchTimeout;

    const updateURL = (p) => {
        const url = new URL(window.location);
        Object.keys(p).forEach(k => {
            if (p[k] && p[k] !== 'all' && p[k] !== 'all-pack' && p[k] !== 'all-cert' && p[k] !== 'default') {
                url.searchParams.set(k, p[k]);
            } else {
                url.searchParams.delete(k);
            }
        });
        window.history.pushState({}, '', url);
    };

    // resources/js/pages/catalog.js

    const loadProducts = () => {
        // ✅ Проверяем, что запрос не выполняется повторно
        if (loadingOverlay?.classList.contains('active')) {
            return; // Уже загружается
        }

        loadingOverlay?.classList.add('active');

        // ✅ Очищаем перед загрузкой
        // catalogGrid.innerHTML = '<div class="loading-placeholder">Загрузка...</div>';

        fetch(catalogUrl + '?' + new URLSearchParams(filters).toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(r => r.json())
            .then(d => {
                // ✅ Заменяем содержимое, а не добавляем
                if (catalogGrid) {
                    catalogGrid.innerHTML = d.html;
                }
                if (paginationContainer) {
                    paginationContainer.innerHTML = d.pagination;
                }
                updateActiveFilters();
                updateURL(filters);
            })
            .catch(e => console.error('Ошибка загрузки товаров:', e))
            .finally(() => loadingOverlay?.classList.remove('active'));
    };

    const updateActiveFilters = () => {
        if (!activeFiltersContainer) return;
        let h = '';
        const addTag = (key, label) => {
            h += `<span class="active-filter-tag" data-remove="${key}">${label} <span class="remove">×</span></span>`;
        };

        if (filters.category && filters.category !== 'all') {
            const btn = document.querySelector(`[data-filter="category"][data-value="${filters.category}"]`);
            addTag('category', btn ? btn.textContent : filters.category);
        }
        if (filters.pack && filters.pack !== 'all-pack') {
            const btn = document.querySelector(`[data-filter="pack"][data-value="${filters.pack}"]`);
            addTag('pack', btn ? btn.textContent : filters.pack);
        }
        if (filters.cert && filters.cert !== 'all-cert') {
            const btn = document.querySelector(`[data-filter="cert"][data-value="${filters.cert}"]`);
            addTag('cert', btn ? btn.textContent : filters.cert);
        }
        if (filters.price_from || filters.price_to) {
            addTag('price', `Цена ${filters.price_from ? 'от '+filters.price_from : ''} ${filters.price_to ? 'до '+filters.price_to : ''} ₽`);
        }
        if (filters.weight_from || filters.weight_to) {
            addTag('weight', `Вес ${filters.weight_from ? 'от '+filters.weight_from : ''} ${filters.weight_to ? 'до '+filters.weight_to : ''} г`);
        }
        if (filters.shelf_life) {
            addTag('shelf_life', `Срок: ${filters.shelf_life} дн.`);
        }
        if (filters.search) {
            addTag('search', `"${filters.search}"`);
        }
        if (h) {
            h += `<button class="reset-filters" id="resetAll">Сбросить все</button>`;
        }
        activeFiltersContainer.innerHTML = h;

        document.querySelectorAll('.active-filter-tag').forEach(tag => {
            tag.addEventListener('click', function() {
                const k = this.dataset.remove;
                if (k === 'price') {
                    filters.price_from = ''; filters.price_to = '';
                    const priceFrom = document.getElementById('priceFrom');
                    const priceTo = document.getElementById('priceTo');
                    if (priceFrom) priceFrom.value = '';
                    if (priceTo) priceTo.value = '';
                } else if (k === 'weight') {
                    filters.weight_from = ''; filters.weight_to = '';
                    const weightFrom = document.getElementById('weightFrom');
                    const weightTo = document.getElementById('weightTo');
                    if (weightFrom) weightFrom.value = '';
                    if (weightTo) weightTo.value = '';
                } else if (k === 'search') {
                    filters.search = '';
                    if (searchInput) {
                        searchInput.value = '';
                        if (clearSearch) clearSearch.style.display = 'none';
                    }
                } else if (k === 'shelf_life') {
                    filters.shelf_life = '';
                    const shelfLife = document.getElementById('shelfLife');
                    if (shelfLife) shelfLife.value = '';
                } else {
                    const allVal = k === 'category' ? 'all' : k === 'pack' ? 'all-pack' : 'all-cert';
                    filters[k] = allVal;
                    document.querySelectorAll(`[data-filter="${k}"]`).forEach(b => {
                        b.classList.remove('active');
                        if (b.dataset.value === allVal) b.classList.add('active');
                    });
                }
                loadProducts();
            });
        });

        const resetBtn = document.getElementById('resetAll');
        if (resetBtn) resetBtn.addEventListener('click', resetAllFilters);
    };

    const resetAllFilters = () => {
        filters = {
            category: 'all', pack: 'all-pack', cert: 'all-cert', sort: 'default',
            search: '', price_from: '', price_to: '', weight_from: '', weight_to: '', shelf_life: ''
        };
        if (searchInput) {
            searchInput.value = '';
            if (clearSearch) clearSearch.style.display = 'none';
        }
        const priceFrom = document.getElementById('priceFrom');
        const priceTo = document.getElementById('priceTo');
        const weightFrom = document.getElementById('weightFrom');
        const weightTo = document.getElementById('weightTo');
        const shelfLife = document.getElementById('shelfLife');
        const sortOrder = document.getElementById('sortOrder');

        if (priceFrom) priceFrom.value = '';
        if (priceTo) priceTo.value = '';
        if (weightFrom) weightFrom.value = '';
        if (weightTo) weightTo.value = '';
        if (shelfLife) shelfLife.value = '';
        if (sortOrder) sortOrder.value = 'default';

        document.querySelectorAll('.filter-btn.active').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('[data-value="all"], [data-value="all-pack"], [data-value="all-cert"]').forEach(b => b.classList.add('active'));
        loadProducts();
    };

    // Обработчики фильтров
    document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            const group = this.closest('.filter-group');
            if (group) {
                group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            }
            this.classList.add('active');
            filters[this.dataset.filter] = this.dataset.value;
            loadProducts();
        });
    });

    const sortOrder = document.getElementById('sortOrder');
    if (sortOrder) {
        sortOrder.addEventListener('change', function() {
            filters.sort = this.value;
            loadProducts();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const v = this.value.trim();
            if (clearSearch) clearSearch.style.display = v ? 'block' : 'none';
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filters.search = v;
                loadProducts();
            }, 400);
        });
    }

    if (clearSearch) {
        clearSearch.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            this.style.display = 'none';
            filters.search = '';
            loadProducts();
        });
    }

    if (toggleAdvanced && advancedFilters) {
        toggleAdvanced.addEventListener('click', function() {
            this.classList.toggle('expanded');
            advancedFilters.classList.toggle('visible');
        });
    }

    ['priceFrom', 'priceTo', 'weightFrom', 'weightTo'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        let timer;
        el.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const map = {
                    priceFrom: 'price_from',
                    priceTo: 'price_to',
                    weightFrom: 'weight_from',
                    weightTo: 'weight_to'
                };
                filters[map[id]] = this.value;
                loadProducts();
            }, 500);
        });
    });

    const shelfLife = document.getElementById('shelfLife');
    if (shelfLife) {
        shelfLife.addEventListener('change', function() {
            filters.shelf_life = this.value;
            loadProducts();
        });
    }

    // Пагинация
    document.addEventListener('click', function(e) {
        const link = e.target.closest('#paginationContainer a');
        if (link) {
            e.preventDefault();
            const url = new URL(link.href);
            const page = url.searchParams.get('page');
            if (page) {
                filters.page = page;
                loadProducts();
                const catalogApp = document.getElementById('catalogApp');
                if (catalogApp) {
                    window.scrollTo({ top: catalogApp.offsetTop - 100, behavior: 'smooth' });
                }
            }
        }
    });

    // Обновление при навигации назад/вперёд
    window.addEventListener('popstate', function() {
        const p = new URLSearchParams(window.location.search);
        filters.category = p.get('category') || 'all';
        filters.pack = p.get('pack') || 'all-pack';
        filters.cert = p.get('cert') || 'all-cert';
        filters.sort = p.get('sort') || 'default';
        filters.search = p.get('search') || '';
        filters.price_from = p.get('price_from') || '';
        filters.price_to = p.get('price_to') || '';
        filters.weight_from = p.get('weight_from') || '';
        filters.weight_to = p.get('weight_to') || '';
        filters.shelf_life = p.get('shelf_life') || '';
        if (searchInput) {
            searchInput.value = filters.search;
            if (clearSearch) clearSearch.style.display = filters.search ? 'block' : 'none';
        }
        loadProducts();
    });

    // Инициализация активных фильтров
    updateActiveFilters();
})();
