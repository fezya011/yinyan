{{-- partials/lead-modal/index.blade.php --}}
<div id="leadModal" class="lead-modal"
     aria-hidden="true"
     role="dialog"
     aria-modal="true"
     data-store-url="{{ route('lead.store') }}">
    <div class="lead-modal__overlay" data-lead-close></div>

    <div class="lead-modal__container">
        {{-- Иероглифы --}}
        @include('partials.lead-modal.partials.hanzi-decor')

        {{-- Кнопка закрытия --}}
        <button class="lead-modal__close" type="button" aria-label="Закрыть" data-lead-close>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>

        {{-- Форма --}}
        @include('partials.lead-modal.partials.form')

        {{-- Успех --}}
        @include('partials.lead-modal.partials.success')
    </div>
</div>
