<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель — Инь Ян</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #1e293b;
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-logo .logo-icon {
            display: inline-block;
            width: 56px;
            height: 56px;
            background: #3b82f6;
            border-radius: 14px;
            font-size: 28px;
            line-height: 56px;
            text-align: center;
            color: white;
            margin-bottom: 12px;
        }
        .login-logo h1 {
            color: #f1f5f9;
            font-size: 24px;
            font-weight: 700;
        }
        .login-logo p {
            color: #94a3b8;
            font-size: 14px;
            margin-top: 4px;
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            color: #cbd5e1;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #f1f5f9;
            font-size: 14px;
            transition: border-color 0.2s;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        .form-input:focus { border-color: #3b82f6; }
        .form-input::placeholder { color: #475569; }
        .form-input-icon {
            position: relative;
        }
        .form-input-icon .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
        }
        .form-input-icon .form-input {
            padding-left: 44px;
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #3b82f6;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-submit:hover { background: #2563eb; }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .alert-error {
            background: #7f1d1d;
            border: 1px solid #991b1b;
            color: #fca5a5;
        }
        .alert-success {
            background: #064e3b;
            border: 1px solid #065f46;
            color: #6ee7b7;
        }
        .checkbox-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        .checkbox-wrap input[type="checkbox"] {
            accent-color: #3b82f6;
            width: 18px;
            height: 18px;
        }
        .checkbox-wrap label {
            color: #94a3b8;
            font-size: 13px;
            cursor: pointer;
        }
        .forgot-link {
            color: #94a3b8;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: #f1f5f9; }
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-logo">
        <div class="logo-icon">☯</div>
        <h1>Инь Ян</h1>
        <p>Вход в админ-панель</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

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

        <div class="flex-between">
            <div class="checkbox-wrap">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Запомнить меня</label>
            </div>
            <a href="#" class="forgot-link">Забыли пароль?</a>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
            Войти
        </button>
    </form>
</div>
</body>
</html>
