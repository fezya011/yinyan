<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель — Инь Ян</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0D0D0D;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* ===== ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ ===== */
        .hanzi-decor {
            position: absolute;
            pointer-events: none;
            user-select: none;
            font-family: 'Noto Serif SC', 'SimSun', serif;
            font-weight: 900;
            color: #FFFFFF;
            line-height: 1;
            z-index: 0;
            opacity: 0.025;
        }

        .hanzi-decor.xl { font-size: 200px; }
        .hanzi-decor.lg { font-size: 120px; }
        .hanzi-decor.md { font-size: 80px; }
        .hanzi-decor.sm { font-size: 50px; }

        .hanzi-decor.rotate-5 { transform: rotate(5deg); }
        .hanzi-decor.rotate-10 { transform: rotate(10deg); }
        .hanzi-decor.rotate-n5 { transform: rotate(-5deg); }
        .hanzi-decor.rotate-n10 { transform: rotate(-10deg); }

        @media (max-width: 768px) {
            .hanzi-decor.xl { font-size: 120px; opacity: 0.02; }
            .hanzi-decor.lg { font-size: 80px; opacity: 0.015; }
            .hanzi-decor.md { font-size: 50px; opacity: 0.015; }
            .hanzi-decor.sm { font-size: 30px; opacity: 0.01; }
        }

        /* ===== КАРТОЧКА ВХОДА ===== */
        .login-card {
            background: #1A1A1A;
            border-radius: 0;
            padding: 52px 48px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-logo .logo-wrap {
            display: inline-block;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 20px;
            background: #FFFFFF;
            padding: 8px;
            box-shadow: 0 0 60px rgba(255, 255, 255, 0.03);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .login-logo .logo-wrap:hover {
            transform: scale(1.03);
            box-shadow: 0 0 80px rgba(255, 255, 255, 0.06);
        }

        .login-logo .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            border-radius: 50%;
        }

        .login-logo .logo-wrap .logo-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            border-radius: 50%;
            font-size: 44px;
            font-weight: 900;
            color: #1A1A1A;
            font-family: 'Noto Serif SC', 'SimSun', serif;
        }

        .login-logo h1 {
            color: #FFFFFF;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .login-logo p {
            color: rgba(255, 255, 255, 0.25);
            font-size: 12px;
            margin-top: 6px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .login-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.12);
            font-size: 9px;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            font-weight: 600;
        }

        /* ===== ФОРМА ===== */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.35);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: #0D0D0D;
            border: 1px solid rgba(255, 255, 255, 0.06);
            color: #FFFFFF;
            font-size: 14px;
            transition: all 0.25s ease;
            outline: none;
            font-family: 'Inter', sans-serif;
            border-radius: 0;
        }

        .form-input:focus {
            border-color: rgba(255, 255, 255, 0.2);
            background: #141414;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.12);
        }

        .form-input-icon {
            position: relative;
        }

        .form-input-icon .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.08);
            font-size: 14px;
        }

        .form-input-icon .form-input {
            padding-left: 44px;
        }

        /* ===== КНОПКА ===== */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: #FFFFFF;
            border: none;
            color: #1A1A1A;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            border-radius: 0;
            margin-top: 4px;
        }

        .btn-submit:hover {
            background: #E8E8E8;
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(255, 255, 255, 0.04);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-submit i {
            margin-right: 10px;
            font-size: 12px;
            opacity: 0.5;
        }

        /* ===== АЛЕРТЫ ===== */
        .alert {
            padding: 14px 18px;
            font-size: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 3px solid transparent;
        }

        .alert-error {
            background: rgba(200, 60, 60, 0.06);
            border-left-color: #CC5555;
            color: rgba(255, 200, 200, 0.7);
        }

        .alert-error i {
            color: #CC5555;
            opacity: 0.6;
        }

        .alert-success {
            background: rgba(60, 200, 100, 0.06);
            border-left-color: #55CC77;
            color: rgba(200, 255, 210, 0.7);
        }

        .alert-success i {
            color: #55CC77;
            opacity: 0.6;
        }

        /* ===== ЧЕКБОКС ===== */
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .checkbox-wrap input[type="checkbox"] {
            accent-color: #FFFFFF;
            width: 16px;
            height: 16px;
            cursor: pointer;
            opacity: 0.5;
        }

        .checkbox-wrap label {
            color: rgba(255, 255, 255, 0.2);
            font-size: 11px;
            cursor: pointer;
            letter-spacing: 0.5px;
        }

        .forgot-link {
            color: rgba(255, 255, 255, 0.12);
            font-size: 11px;
            text-decoration: none;
            transition: color 0.3s ease;
            letter-spacing: 0.5px;
        }

        .forgot-link:hover {
            color: rgba(255, 255, 255, 0.35);
        }

        /* ===== ФУТЕР ===== */
        .login-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.03);
            text-align: center;
            font-size: 9px;
            color: rgba(255, 255, 255, 0.08);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

{{-- ДЕКОРАТИВНЫЕ ИЕРОГЛИФЫ --}}
<span class="hanzi-decor xl rotate-10" style="top: 5%; right: 2%;">雅</span>
<span class="hanzi-decor lg rotate-n5" style="bottom: 5%; left: 3%;">韵</span>
<span class="hanzi-decor md rotate-5" style="top: 25%; left: 1%;">和</span>
<span class="hanzi-decor sm rotate-n10" style="bottom: 25%; right: 2%;">谐</span>
<span class="hanzi-decor lg rotate-10" style="top: 50%; left: 5%; transform: translateY(-50%);">道</span>
<span class="hanzi-decor md rotate-n5" style="top: 50%; right: 5%; transform: translateY(-50%);">德</span>

{{-- КАРТОЧКА ВХОДА --}}
<div class="login-card">
    <div class="login-logo">
        <div class="logo-wrap">
            <img src="{{ asset('images/logo.png') }}" alt="Инь Ян" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="logo-fallback" style="display: none;">☯</div>
        </div>
        <h1>Инь Янь</h1>
        <p>Экспорт и импорт из Китая</p>
    </div>

    <div class="login-subtitle">Административная панель</div>

    {{-- АЛЕРТЫ --}}
    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- ФОРМА --}}
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="form-input-icon">
                <span class="icon"><i class="fas fa-envelope"></i></span>
                <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Пароль</label>
            <div class="form-input-icon">
                <span class="icon"><i class="fas fa-lock"></i></span>
                <input class="form-input" id="password" type="password" name="password" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt"></i>
            Войти
        </button>
    </form>
</div>

</body>
</html>
