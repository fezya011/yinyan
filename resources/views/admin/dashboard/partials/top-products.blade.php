{{-- admin/dashboard/partials/top-products.blade.php --}}
<div class="table-container">
    <div class="table-header">
        <span class="title">Популярные товары</span>
        <div class="actions">
            <a href="{{ route('admin.products.index') }}">Все</a>
            <a href="{{ route('admin.products.create') }}">Добавить</a>
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>Название</th>
            <th>Категория</th>
            <th style="text-align: center;">Заказов</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @forelse($topProducts as $product)
            <tr>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}" style="color: #1A1A1A; text-decoration: none; font-weight: 600; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.6'" onmouseout="this.style.opacity='1'">
                        {{ Str::limit($product->name, 30) }}
                    </a>
                </td>
                <td class="text-muted">{{ $product->category?->name ?? '—' }}</td>
                <td style="text-align: center; font-weight: 700; color: #1A1A1A;">{{ $product->orders_count }}</td>
                <td>
                    <span class="status-badge {{ $product->status }}">
                        <span class="dot"></span>
                        {{ match($product->status) { 'active' => 'Активен', 'inactive' => 'Неактивен', 'out_of_stock' => 'Нет в наличии', default => $product->status } }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <div class="empty-state">
                        <div class="empty-icon">无</div>
                        <span class="empty-text">Нет товаров</span>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
