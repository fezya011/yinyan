{{-- layouts/partials/core-styles.blade.php --}}
<style>
    /* === ГЛОБАЛЬНЫЕ СТИЛИ === */

    /* Backdrop blur */
    .backdrop-blur-sm {
        backdrop-filter: blur(8px);
    }

    @media (max-width: 768px) {
        .backdrop-blur-sm {
            backdrop-filter: blur(5px);
        }
    }

    /* Alpine.js */
    [x-cloak] {
        display: none !important;
    }

    /* Базовые сбросы */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background: #FFFFFF;
        color: #1A1A1A;
    }

    /* Утилиты */
    .container {
        max-width: 1280px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    @media (min-width: 640px) {
        .container {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .container {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }

    /* Анимации */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Скроллбар */
    ::-webkit-scrollbar {
        width: 4px;
    }
    ::-webkit-scrollbar-track {
        background: #FFFFFF;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(26, 26, 26, 0.12);
        border-radius: 2px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(26, 26, 26, 0.2);
    }

    /* Selection */
    ::selection {
        background: rgba(26, 26, 26, 0.08);
        color: #1A1A1A;
    }

    /* Focus states */
    :focus-visible {
        outline: 2px solid #1A1A1A;
        outline-offset: 2px;
    }

    /* Для мобильных устройств */
    @media (max-width: 640px) {
        :focus-visible {
            outline: none;
        }
    }

    /* Print styles */
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background: white;
            color: black;
        }
    }
</style>
