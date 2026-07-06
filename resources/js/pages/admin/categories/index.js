// resources/js/admin/categories/index.js
document.addEventListener('DOMContentLoaded', function() {
    // Обработка ошибок загрузки миниатюр
    document.querySelectorAll('.mini-thumb').forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('mini-thumb-placeholder')) {
                placeholder.style.display = 'flex';
            }
        });

        img.addEventListener('load', function() {
            this.style.display = 'block';
            const placeholder = this.nextElementSibling;
            if (placeholder && placeholder.classList.contains('mini-thumb-placeholder')) {
                placeholder.style.display = 'none';
            }
        });
    });

    // Добавляем клавиатурную навигацию
    document.querySelectorAll('.category-card').forEach(card => {
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
});
