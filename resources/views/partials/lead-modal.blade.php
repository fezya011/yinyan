{{-- ===== МОДАЛЬНОЕ ОКНО ЗАЯВКИ С АВТОДОПОЛНЕНИЕМ ГОРОДОВ (через /cities) ===== --}}
<div id="leadModal" class="lead-modal" aria-hidden="true" role="dialog" aria-modal="true">
    {{-- Overlay --}}
    <div class="lead-modal__overlay" data-lead-close></div>

    {{-- Контейнер --}}
    <div class="lead-modal__container">

        {{-- ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ НА ФОНЕ ===== --}}
        <span class="lead-modal__bg-hanzi" style="top: 3%; right: 5%; font-size: 140px; transform: rotate(12deg);">品</span>
        <span class="lead-modal__bg-hanzi" style="bottom: 5%; left: 3%; font-size: 110px; transform: rotate(-10deg);">和</span>
        <span class="lead-modal__bg-hanzi" style="top: 30%; left: 8%; font-size: 70px; transform: rotate(18deg);">赢</span>
        <span class="lead-modal__bg-hanzi" style="bottom: 20%; right: 8%; font-size: 90px; transform: rotate(-6deg);">合</span>
        <span class="lead-modal__bg-hanzi" style="top: 60%; right: 20%; font-size: 50px; transform: rotate(8deg);">选</span>

        {{-- Кнопка закрытия --}}
        <button class="lead-modal__close" type="button" aria-label="Закрыть" data-lead-close>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>

        {{-- Состояние: форма --}}
        <div class="lead-modal__body" id="leadFormWrap">
            <div class="lead-modal__head">
                <h2 class="lead-modal__title">Оставить заявку</h2>
                <p class="lead-modal__desc">
                    Заполните форму — менеджер свяжется с вами, уточнит детали и подготовит персональное предложение.
                </p>
            </div>

            <form id="leadForm" class="lead-modal__form" novalidate>
                @csrf
                <input type="hidden" name="product_id" id="leadProductId" value="">

                <div class="lead-modal__grid">
                    {{-- Имя --}}
                    <label class="lead-field">
                        <span class="lead-field__label">Имя <span class="req">*</span></span>
                        <input type="text" name="name" class="lead-field__input" placeholder="Иван Иванов" required autocomplete="name">
                        <span class="lead-field__error" data-error="name"></span>
                    </label>

                    {{-- Телефон --}}
                    <label class="lead-field">
                        <span class="lead-field__label">Телефон <span class="req">*</span></span>
                        <input type="tel" name="phone" class="lead-field__input" placeholder="+7 (___) ___-__-__" required autocomplete="tel">
                        <span class="lead-field__error" data-error="phone"></span>
                    </label>

                    {{-- Email --}}
                    <label class="lead-field">
                        <span class="lead-field__label">Email</span>
                        <input type="email" name="email" class="lead-field__input" placeholder="you@company.com" autocomplete="email">
                        <span class="lead-field__error" data-error="email"></span>
                    </label>

                    {{-- Город с автодополнением --}}
                    <label class="lead-field lead-field--city">
                        <span class="lead-field__label">Город доставки</span>
                        <div class="lead-field__city-wrapper">
                            <input type="text" name="delivery_city" id="deliveryCityInput"
                                   class="lead-field__input" placeholder="Москва" autocomplete="off">
                            <div id="citySuggestions" class="lead-field__city-suggestions"></div>
                        </div>
                        <span class="lead-field__error" data-error="delivery_city"></span>
                    </label>

                    {{-- Бюджет --}}
                    <label class="lead-field lead-field--full">
                        <span class="lead-field__label">Примерный бюджет</span>
                        <select name="estimated_budget" class="lead-field__select">
                            <option value="">Не указано</option>
                            <option value="100000-300000">100 000 — 300 000 ₽</option>
                            <option value="300000-500000">300 000 — 500 000 ₽</option>
                            <option value="500000-1000000">500 000 — 1 000 000 ₽</option>
                            <option value="1000000+">Более 1 000 000 ₽</option>
                        </select>
                    </label>

                    {{-- Сообщение --}}
                    <label class="lead-field lead-field--full">
                        <span class="lead-field__label">Комментарий</span>
                        <textarea name="message" class="lead-field__textarea" rows="3" placeholder="Какие товары вас интересуют? Какой объём?"></textarea>
                        <span class="lead-field__error" data-error="message"></span>
                    </label>
                </div>

                {{-- Согласие --}}
                <label class="lead-consent">
                    <input type="checkbox" name="agree" required checked class="lead-consent__checkbox">
                    <span>Я согласен с <a href="{{ route('privacy') }}" target="_blank">политикой обработки персональных данных</a></span>
                </label>

                {{-- Общий error --}}
                <div class="lead-modal__error" id="leadFormError" hidden></div>

                <button type="submit" class="lead-modal__submit" id="leadSubmitBtn">
                    <span class="lead-modal__submit-text">Отправить заявку</span>
                    <span class="lead-modal__submit-loader" hidden>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" opacity="0.25"/>
                            <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
                            </path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        {{-- Состояние: успех --}}
        <div class="lead-modal__success" id="leadSuccess" hidden>
            <div class="lead-modal__success-icon">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
            </div>
            <h3 class="lead-modal__success-title">Заявка отправлена</h3>
            <p class="lead-modal__success-desc">
                Спасибо! Мы получили вашу заявку и свяжемся с вами в ближайшее время.
            </p>
            <button type="button" class="lead-modal__submit" data-lead-close>Закрыть</button>
        </div>
    </div>
</div>

{{-- ===== СТИЛИ ===== --}}
<style>
    /* ===== МОДАЛЬНОЕ ОКНО ===== */
    .lead-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: opacity .35s ease, visibility .35s ease;
        font-family: 'Inter', sans-serif;
    }
    .lead-modal.is-open {
        display: flex;
        opacity: 1;
        visibility: visible;
    }
    .lead-modal__overlay {
        position: absolute;
        inset: 0;
        background: rgba(10, 10, 10, 0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }
    .lead-modal__container {
        position: relative;
        background: #FFFFFF;
        width: 100%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 40px 40px 32px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.25);
        transform: translateY(20px) scale(0.98);
        transition: transform .4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .lead-modal.is-open .lead-modal__container {
        transform: translateY(0) scale(1);
    }

    /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ НА ФОНЕ ===== */
    .lead-modal__bg-hanzi {
        position: absolute;
        pointer-events: none;
        user-select: none;
        font-family: 'Noto Serif SC', 'SimSun', serif;
        font-weight: 900;
        color: #1A1A1A;
        opacity: 0.035;
        z-index: 0;
        line-height: 1;
        animation: hanziDrift 20s ease-in-out infinite alternate;
    }
    @keyframes hanziDrift {
        0%   { transform: translateY(0) rotate(var(--rot, 0deg)); }
        100% { transform: translateY(-10px) rotate(calc(var(--rot, 0deg) + 2deg)); }
    }
    .lead-modal__bg-hanzi:nth-child(1) { animation-delay: 0s; }
    .lead-modal__bg-hanzi:nth-child(2) { animation-delay: 3s; }
    .lead-modal__bg-hanzi:nth-child(3) { animation-delay: 6s; }
    .lead-modal__bg-hanzi:nth-child(4) { animation-delay: 9s; }
    .lead-modal__bg-hanzi:nth-child(5) { animation-delay: 12s; }

    .lead-modal__body,
    .lead-modal__success {
        position: relative;
        z-index: 1;
    }

    /* ===== ЗАКРЫТИЕ ===== */
    .lead-modal__close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        color: rgba(26, 26, 26, 0.4);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color .25s ease, transform .25s ease;
        z-index: 2;
    }
    .lead-modal__close:hover {
        color: #1A1A1A;
        transform: rotate(90deg);
    }

    /* ===== ЗАГОЛОВОК ===== */
    .lead-modal__head {
        margin-bottom: 24px;
    }
    .lead-modal__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 9px;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: rgba(26, 26, 26, 0.4);
        font-weight: 500;
        margin-bottom: 14px;
    }
    .lead-modal__badge-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #10B981;
        animation: pulse-dot 2s infinite;
    }
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.3; transform: scale(1.8); }
    }
    .lead-modal__title {
        font-size: clamp(24px, 3vw, 30px);
        font-weight: 900;
        letter-spacing: -1px;
        text-transform: uppercase;
        color: #1A1A1A;
        line-height: 1;
        margin-bottom: 10px;
    }
    .lead-modal__desc {
        font-size: 13px;
        color: rgba(26, 26, 26, 0.5);
        line-height: 1.6;
        max-width: 440px;
    }

    /* ===== ФОРМА ===== */
    .lead-modal__grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 14px;
    }
    @media (max-width: 520px) {
        .lead-modal__container { padding: 28px 20px 24px; }
        .lead-modal__grid { grid-template-columns: 1fr; }
    }

    .lead-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .lead-field--full { grid-column: 1 / -1; }
    .lead-field__label {
        font-size: 9px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(26, 26, 26, 0.45);
        font-weight: 600;
    }
    .lead-field__label .req { color: #FF6B00; }
    .lead-field__input,
    .lead-field__select,
    .lead-field__textarea {
        width: 100%;
        padding: 12px 14px;
        background: #FAFAFA;
        border: 1px solid rgba(26, 26, 26, 0.08);
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #1A1A1A;
        transition: border-color .25s ease, background .25s ease;
        outline: none;
        -webkit-appearance: none;
        appearance: none;
    }
    .lead-field__select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%231A1A1A' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 36px;
    }
    .lead-field__textarea {
        resize: vertical;
        min-height: 80px;
        font-family: inherit;
    }
    .lead-field__input:focus,
    .lead-field__select:focus,
    .lead-field__textarea:focus {
        border-color: #1A1A1A;
        background: #FFFFFF;
    }
    .lead-field.is-invalid .lead-field__input,
    .lead-field.is-invalid .lead-field__textarea {
        border-color: #EF4444;
        background: #FEF2F2;
    }
    .lead-field__error {
        font-size: 11px;
        color: #EF4444;
        min-height: 14px;
        display: block;
    }

    /* ===== АВТОДОПОЛНЕНИЕ ГОРОДА ===== */
    .lead-field--city {
        position: relative;
    }
    .lead-field__city-wrapper {
        position: relative;
    }
    .lead-field__city-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #FFFFFF;
        border: 1px solid rgba(26, 26, 26, 0.08);
        border-top: none;
        max-height: 200px;
        overflow-y: auto;
        z-index: 10;
        display: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .lead-field__city-suggestions.active {
        display: block;
    }
    .lead-field__city-suggestion {
        padding: 10px 14px;
        font-size: 13px;
        color: #1A1A1A;
        cursor: pointer;
        transition: background 0.15s;
    }
    .lead-field__city-suggestion:hover {
        background: rgba(26, 26, 26, 0.04);
    }
    .lead-field__city-suggestion.highlighted {
        background: rgba(26, 26, 26, 0.06);
    }
    .lead-field__city-suggestions::-webkit-scrollbar {
        width: 4px;
    }
    .lead-field__city-suggestions::-webkit-scrollbar-track {
        background: #FFFFFF;
    }
    .lead-field__city-suggestions::-webkit-scrollbar-thumb {
        background: rgba(26, 26, 26, 0.12);
        border-radius: 2px;
    }

    /* Согласие */
    .lead-consent {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 11px;
        color: rgba(26, 26, 26, 0.5);
        line-height: 1.5;
        margin-bottom: 18px;
        cursor: pointer;
    }
    .lead-consent a {
        color: #1A1A1A;
        text-decoration: underline;
        text-underline-offset: 2px;
    }
    .lead-consent__checkbox {
        margin-top: 2px;
        accent-color: #1A1A1A;
    }

    /* Кнопка */
    .lead-modal__submit {
        width: 100%;
        padding: 16px 24px;
        background: #1A1A1A;
        color: #FFFFFF;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background .3s ease, transform .2s ease;
    }
    .lead-modal__submit:hover:not(:disabled) {
        background: #000000;
        transform: translateY(-1px);
    }
    .lead-modal__submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Ошибки */
    .lead-modal__error {
        padding: 10px 14px;
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #991B1B;
        font-size: 12px;
        margin-bottom: 14px;
        border-radius: 2px;
    }

    /* Успех */
    .lead-modal__success {
        text-align: center;
        padding: 20px 0;
    }
    .lead-modal__success-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #ECFDF5;
        color: #10B981;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .lead-modal__success-title {
        font-size: 22px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        color: #1A1A1A;
        margin-bottom: 8px;
    }
    .lead-modal__success-desc {
        font-size: 13px;
        color: rgba(26, 26, 26, 0.5);
        line-height: 1.6;
        margin-bottom: 24px;
        max-width: 360px;
        margin-left: auto;
        margin-right: auto;
    }

    body.lead-modal-open {
        overflow: hidden;
    }
</style>

{{-- ===== СКРИПТЫ ===== --}}
<script>
    (function() {
        'use strict';

        const modal = document.getElementById('leadModal');
        if (!modal) return;

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
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('lead-modal-open');
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
                const response = await fetch('{{ route("lead.store") }}', {
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
</script>
