{{-- resources/views/pages/catalog/partials/scripts-data.blade.php --}}
@php
    $filters = [
        'category' => request('category', 'all'),
        'pack' => request('pack', 'all-pack'),
        'cert' => request('cert', 'all-cert'),
        'sort' => request('sort', 'default'),
        'search' => request('search', ''),
        'price_from' => request('price_from', ''),
        'price_to' => request('price_to', ''),
        'weight_from' => request('weight_from', ''),
        'weight_to' => request('weight_to', ''),
        'shelf_life' => request('shelf_life', '')
    ];
@endphp

<script>
    window.catalogData = {
        filters: @json($filters),
        catalogUrl: @json(route('catalog'))
    };
</script>
