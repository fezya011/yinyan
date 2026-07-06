// resources/js/admin/leads.js

// ===== СТАТУСЫ В ТАБЛИЦЕ =====
document.addEventListener('DOMContentLoaded', function() {
    // Автоматическое обновление статуса при клике на бейдж
    document.querySelectorAll('.status-badge[data-update-url]').forEach(badge => {
        badge.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.dataset.updateUrl;
            const currentStatus = this.dataset.status;

            // Показываем select для выбора статуса
            const select = document.createElement('select');
            select.className = 'form-control form-control-sm';
            select.style.width = 'auto';
            select.style.display = 'inline-block';

            // Заполняем опциями
            const statuses = JSON.parse(this.dataset.statuses);
            Object.entries(statuses).forEach(([key, label]) => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = label;
                if (key === currentStatus) option.selected = true;
                select.appendChild(option);
            });

            // Заменяем бейдж на select
            const parent = this.parentNode;
            parent.replaceChild(select, this);

            // При изменении отправляем запрос
            select.addEventListener('change', function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PUT';

                const status = document.createElement('input');
                status.type = 'hidden';
                status.name = 'status';
                status.value = this.value;

                form.appendChild(csrf);
                form.appendChild(method);
                form.appendChild(status);
                document.body.appendChild(form);
                form.submit();
            });

            // При потере фокуса возвращаем бейдж
            select.addEventListener('blur', function() {
                // Восстанавливаем бейдж (перезагрузка страницы)
                window.location.reload();
            });
        });
    });
});
