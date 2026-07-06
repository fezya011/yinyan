// resources/js/admin/products.js

// ===== ПРЕВЬЮ ИЗОБРАЖЕНИЯ =====
function previewMainImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImg = document.getElementById('previewImage');
            const previewEmoji = document.getElementById('previewEmoji');

            if (previewImg) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                previewImg.onerror = null;
            }
            if (previewEmoji) {
                previewEmoji.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}

// ===== ОБНОВЛЕНИЕ ПРЕВЬЮ =====
function updatePreview() {
    const name = document.getElementById('name')?.value || 'Название товара';
    const tag = document.getElementById('tag')?.value || 'Тег';
    const emoji = document.getElementById('emoji_icon')?.value || '🍜';
    const subtitle = document.getElementById('card_subtitle')?.value || document.getElementById('description')?.value?.substring(0, 80) || 'Описание товара';
    const priceDisplay = document.getElementById('price_display')?.value;
    const wholesalePrice = document.getElementById('wholesale_price')?.value;
    const status = document.getElementById('status')?.value || 'active';
    const isFeatured = document.getElementById('is_featured')?.checked;
    const accentColor = document.getElementById('accent_color')?.value || '#83BF32';

    const previewName = document.getElementById('previewName');
    const previewTag = document.getElementById('previewTag');
    const previewDesc = document.getElementById('previewDesc');
    const previewPrice = document.getElementById('previewPrice');
    const previewEmoji = document.getElementById('previewEmoji');
    const previewStatus = document.getElementById('previewStatus');
    const previewFeatured = document.getElementById('previewFeatured');
    const previewAccentBar = document.getElementById('previewAccentBar');

    if (previewName) previewName.textContent = name;
    if (previewTag) previewTag.textContent = tag;
    if (previewDesc) previewDesc.textContent = subtitle;
    if (previewAccentBar) previewAccentBar.style.backgroundColor = accentColor;

    const previewImg = document.getElementById('previewImage');
    if (previewEmoji && (!previewImg || previewImg.style.display === 'none')) {
        previewEmoji.textContent = emoji;
    }

    if (previewPrice) {
        if (priceDisplay) {
            previewPrice.textContent = priceDisplay;
        } else if (wholesalePrice) {
            previewPrice.textContent = 'от ' + new Intl.NumberFormat('ru-RU').format(wholesalePrice) + ' ₽ / шт';
        } else {
            previewPrice.textContent = 'от 0 ₽ / шт';
        }
    }

    if (previewStatus) {
        previewStatus.className = 'preview-card-status ' + status;
        const statusLabels = {
            'active': 'Активен',
            'inactive': 'Неактивен',
            'out_of_stock': 'Нет в наличии'
        };
        previewStatus.textContent = statusLabels[status] || status;
    }

    if (previewFeatured) {
        previewFeatured.style.display = isFeatured ? 'block' : 'none';
    }

    const weight = document.getElementById('weight_grams')?.value;
    const pieces = document.getElementById('pieces_per_box')?.value;
    const shelf = document.getElementById('shelf_life_days')?.value;
    const boxes = document.getElementById('boxes_per_pallet')?.value;

    const previewWeight = document.getElementById('previewWeight');
    const previewPieces = document.getElementById('previewPieces');
    const previewShelf = document.getElementById('previewShelf');
    const previewBoxes = document.getElementById('previewBoxes');

    if (previewWeight) previewWeight.textContent = weight ? weight + ' г' : '—';
    if (previewPieces) previewPieces.textContent = pieces ? pieces + ' шт' : '—';
    if (previewShelf) previewShelf.textContent = shelf ? shelf + ' дн' : '—';
    if (previewBoxes) previewBoxes.textContent = boxes || '—';
}

// ===== БЫСТРЫЙ ПРОСМОТР =====
function openQuickView(imageUrl, name, category, price, tag, description) {
    const modal = document.getElementById('quickViewModal');
    const img = document.getElementById('quickViewImage');
    const nameEl = document.getElementById('quickViewName');
    const categoryEl = document.getElementById('quickViewCategory');
    const priceEl = document.getElementById('quickViewPrice');
    const tagEl = document.getElementById('quickViewTag');
    const descEl = document.getElementById('quickViewDesc');

    if (img) {
        img.src = imageUrl;
        img.alt = name;
        img.onerror = function() {
            this.src = '';
            this.alt = 'Изображение недоступно';
        };
    }
    if (nameEl) nameEl.textContent = name;
    if (categoryEl) categoryEl.textContent = category;
    if (priceEl) priceEl.textContent = price;
    if (descEl) descEl.textContent = description || 'Описание отсутствует';

    if (tagEl) {
        if (tag) {
            tagEl.textContent = tag;
            tagEl.style.display = 'inline-block';
        } else {
            tagEl.style.display = 'none';
        }
    }

    if (modal) modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    if (modal) modal.classList.remove('active');
    document.body.style.overflow = '';
}

// ===== ИНИЦИАЛИЗАЦИЯ =====
document.addEventListener('DOMContentLoaded', function() {
    // Обновление превью
    updatePreview();

    // Закрытие быстрого просмотра по клику на фон
    document.getElementById('quickViewModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeQuickView();
        }
    });

    // Закрытие по Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeQuickView();
        }
    });

    // Обработка ошибок загрузки изображений
    document.querySelectorAll('.product-thumbnail').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('product-thumbnail-placeholder')) {
                placeholder.style.display = 'flex';
            }
        });

        img.addEventListener('load', function() {
            this.style.display = 'block';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('product-thumbnail-placeholder')) {
                placeholder.style.display = 'none';
            }
        });
    });
});

// Экспортируем для использования в HTML
window.previewMainImage = previewMainImage;
window.updatePreview = updatePreview;
window.openQuickView = openQuickView;
window.closeQuickView = closeQuickView;
