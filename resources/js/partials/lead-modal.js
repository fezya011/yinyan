// resources/js/partials/lead-modal.js
(function() {
    'use strict';

    const modal = document.getElementById('leadModal');
    if (!modal) return;

    // ✅ Получаем URL из data-атрибута
    const storeUrl = modal.dataset.storeUrl || '/lead';

    const form       = document.getElementById('leadForm');
    const formWrap   = document.getElementById('leadFormWrap');
    const successBox = document.getElementById('leadSuccess');
    const errorBox   = document.getElementById('leadFormError');
    const submitBtn  = document.getElementById('leadSubmitBtn');
    const productId  = document.getElementById('leadProductId');

    // ===== АВТОДОПОЛНЕНИЕ ГОРОДОВ (через /cities) =====
    const cityInput = document.getElementById('deliveryCityInput');
    const suggestionsContainer = document.getElementById('citySuggestions');

    let selectedIndex = -1;
    let debounceTimer = null;

    function showSuggestions(query) {
        if (!query.trim()) {
            suggestionsContainer.classList.remove('active');
            return;
        }

        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetch(`/cities?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(cities => {
                    if (cities.length === 0) {
                        suggestionsContainer.classList.remove('active');
                        return;
                    }
                    suggestionsContainer.innerHTML = cities.map((city, index) =>
                        `<div class="lead-field__city-suggestion" data-index="${index}" data-city="${city}">${city}</div>`
                    ).join('');
                    suggestionsContainer.classList.add('active');
                    selectedIndex = -1;
                    highlightSuggestion(-1);
                })
                .catch(() => {
                    suggestionsContainer.classList.remove('active');
                });
        }, 300);
    }

    function highlightSuggestion(index) {
        const items = suggestionsContainer.querySelectorAll('.lead-field__city-suggestion');
        items.forEach((el, i) => {
            el.classList.toggle('highlighted', i === index);
        });
    }

    function selectCity(city) {
        cityInput.value = city;
        suggestionsContainer.classList.remove('active');
        cityInput.dispatchEvent(new Event('input'));
    }

    // Обработчик ввода
    cityInput.addEventListener('input', function() {
        showSuggestions(this.value);
    });

    // Клик по подсказке
    suggestionsContainer.addEventListener('click', function(e) {
        const target = e.target.closest('.lead-field__city-suggestion');
        if (target) {
            selectCity(target.dataset.city);
        }
    });

    // Клавиатура
    cityInput.addEventListener('keydown', function(e) {
        const items = suggestionsContainer.querySelectorAll('.lead-field__city-suggestion');
        if (!items.length) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = (selectedIndex + 1) % items.length;
            highlightSuggestion(selectedIndex);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = (selectedIndex - 1 + items.length) % items.length;
            highlightSuggestion(selectedIndex);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedIndex >= 0 && selectedIndex < items.length) {
                selectCity(items[selectedIndex].dataset.city);
            }
        } else if (e.key === 'Escape') {
            suggestionsContainer.classList.remove('active');
        }
    });

    // Закрытие при клике вне
    document.addEventListener('click', function(e) {
        if (!modal.contains(e.target)) return;
        const wrapper = cityInput.closest('.lead-field__city-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            suggestionsContainer.classList.remove('active');
        }
    });

    // ===== Открытие =====
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-lead-modal]');
        if (!trigger) return;
        e.preventDefault();

        const pid = trigger.dataset.leadProduct || trigger.closest('[data-product-id]')?.dataset.productId;
        if (pid && productId) productId.value = pid;

        openModal();
    });

    function openModal() {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('lead-modal-open');
        setTimeout(() => {
            const first = modal.querySelector('input:not([type=hidden])');
            if (first) first.focus();
        }, 100);
    }

    // ===== Закрытие =====
    function closeModal() {
        // ✅ Снимаем фокус с кнопки перед закрытием
        if (document.activeElement) {
            document.activeElement.blur();
        }

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('lead-modal-open');

        // ✅ Возвращаем фокус на элемент, который открыл модалку
        const trigger = document.querySelector('[data-lead-modal]');
        if (trigger) {
            setTimeout(() => trigger.focus(), 100);
        }

        setTimeout(resetForm, 350);
    }

    modal.querySelectorAll('[data-lead-close]').forEach(el => {
        el.addEventListener('click', closeModal);
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // ===== Сброс =====
    function resetForm() {
        form.reset();
        form.querySelectorAll('.lead-field.is-invalid').forEach(f => f.classList.remove('is-invalid'));
        form.querySelectorAll('.lead-field__error').forEach(e => e.textContent = '');
        errorBox.hidden = true;
        errorBox.textContent = '';
        formWrap.hidden = false;
        successBox.hidden = true;
        submitBtn.disabled = false;
        submitBtn.querySelector('.lead-modal__submit-text').hidden = false;
        submitBtn.querySelector('.lead-modal__submit-loader').hidden = true;
        suggestionsContainer.classList.remove('active');
    }

    // ===== Отправка =====
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (submitBtn.disabled) return;

        form.querySelectorAll('.lead-field.is-invalid').forEach(f => f.classList.remove('is-invalid'));
        form.querySelectorAll('.lead-field__error').forEach(e => e.textContent = '');
        errorBox.hidden = true;

        submitBtn.disabled = true;
        submitBtn.querySelector('.lead-modal__submit-text').hidden = true;
        submitBtn.querySelector('.lead-modal__submit-loader').hidden = false;

        const formData = new FormData(form);

        try {
            // ✅ Используем URL из data-атрибута
            const response = await fetch(storeUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                formWrap.hidden = true;
                successBox.hidden = false;
            } else {
                handleErrors(data.errors || { base: [data.message || 'Ошибка отправки'] });
            }
        } catch (err) {
            errorBox.textContent = 'Ошибка соединения. Проверьте интернет и попробуйте снова.';
            errorBox.hidden = false;
        } finally {
            submitBtn.disabled = false;
            submitBtn.querySelector('.lead-modal__submit-text').hidden = false;
            submitBtn.querySelector('.lead-modal__submit-loader').hidden = true;
        }
    });

    function handleErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const errorEl = form.querySelector(`[data-error="${field}"]`);
            if (errorEl) {
                errorEl.textContent = messages[0] || '';
                const fieldWrap = errorEl.closest('.lead-field');
                if (fieldWrap) fieldWrap.classList.add('is-invalid');
            } else if (field === 'base' || (field === 'message' && !errorEl)) {
                errorBox.textContent = messages[0];
                errorBox.hidden = false;
            }
        });
    }

    // ===== Маска телефона =====
    const phoneInput = form.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, '');
            if (v.startsWith('8')) v = '7' + v.slice(1);
            if (!v.startsWith('7') && v.length) v = '7' + v;

            let formatted = '+7';
            if (v.length > 1)  formatted += ' (' + v.slice(1, 4);
            if (v.length >= 5) formatted += ') ' + v.slice(4, 7);
            if (v.length >= 8) formatted += '-' + v.slice(7, 9);
            if (v.length >= 10) formatted += '-' + v.slice(9, 11);

            e.target.value = formatted;
        });
    }
})();
