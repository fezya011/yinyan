{{-- partials/lead-modal/partials/form.blade.php --}}
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

            {{-- Город --}}
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
