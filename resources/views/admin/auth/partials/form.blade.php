{{-- admin/auth/partials/form.blade.php --}}
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
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="remember">Запомнить меня</label>
        </div>
        <a href="#" class="forgot-link">Забыли пароль?</a>
    </div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-sign-in-alt"></i>
        Войти
    </button>
</form>
