{{-- admin/auth/login.blade.php --}}
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель — Инь Ян</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/pages/admin/login.css'])
</head>
<body>

{{-- Иероглифы --}}
@include('admin.auth.partials.hanzi-decor')

{{-- Карточка входа --}}
<div class="login-card">
    {{-- Логотип --}}
    @include('admin.auth.partials.logo')

    <div class="login-subtitle">Административная панель</div>

    {{-- Алерты --}}
    @include('admin.auth.partials.alerts')

    {{-- Форма --}}
    @include('admin.auth.partials.form')
</div>

</body>
</html>
