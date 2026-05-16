<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
@php
    $logo = app()->make('App\Repositories\SettingRepository')->getLogo() ?: asset('images/logo.jpg');
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.register') }} — {{ env('APP_NAME') }}</title>
    <link rel="icon" href="{{ $logo }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-gradient: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #0891b2 100%);
            --glass-bg: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #0891b2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .background-animation {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1; overflow: hidden;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            animation: float 10s ease-in-out infinite;
        }
        .shape-1 { width: 300px; height: 300px; top: -50px; right: -50px; }
        .shape-2 { width: 200px; height: 200px; bottom: 10%; left: -30px; animation-delay: 3s; }
        .shape-3 { width: 120px; height: 120px; top: 40%; right: 8%; animation-delay: 1.5s; }
        .med-cross {
            position: absolute; color: rgba(255,255,255,0.06);
            font-size: 4rem; animation: float 12s ease-in-out infinite;
        }
        .med-cross-1 { top: 20%; left: 5%; animation-delay: 1s; }
        .med-cross-2 { bottom: 15%; right: 6%; font-size: 2.5rem; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(8deg); }
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25), inset 0 1px 0 rgba(255,255,255,0.15);
            overflow: hidden;
            width: 100%;
            max-width: 560px;
            animation: slideInUp 0.6s ease-out;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            background: rgba(255,255,255,0.08);
            border-bottom: 1px solid var(--glass-border);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header-pattern {
            position: absolute; top: 0; left: 0;
            width: 100%; height: 100%;
            opacity: 0.15;
            background: radial-gradient(circle at 20% 30%, #5eead4, transparent 55%),
                        radial-gradient(circle at 80% 70%, #0891b2, transparent 50%);
        }
        .register-logo {
            width: 76px; height: 76px;
            border-radius: 22px;
            background: rgba(255,255,255,0.95);
            padding: 10px;
            margin-bottom: 1rem;
            border: 2px solid rgba(255,255,255,0.35);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            position: relative; z-index: 1;
        }
        .register-logo:hover { transform: scale(1.07) rotate(-3deg); }
        .card-header h3 {
            font-weight: 700; color: white;
            font-size: 1.7rem; margin-bottom: 0.3rem;
            position: relative; z-index: 1;
        }
        .card-header p {
            color: rgba(255,255,255,0.78);
            font-size: 0.9rem;
            position: relative; z-index: 1;
        }

        .card-body { padding: 2.5rem; background: rgba(255,255,255,0.97); }

        .form-row-group { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        @media (max-width: 480px) { .form-row-group { grid-template-columns: 1fr; } }

        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            font-weight: 600; color: #1e293b;
            font-size: 0.88rem; margin-bottom: 0.4rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .form-label i { color: var(--primary); width: 15px; font-size: 0.85rem; }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 11px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #fff; color: #1e293b;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,148,136,0.12);
            outline: none; transform: translateY(-1px);
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { color: #ef4444; font-size: 0.82rem; margin-top: 0.3rem; display: block; }

        .password-wrap { position: relative; }
        .password-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; color: #94a3b8;
            cursor: pointer; z-index: 10; transition: color 0.2s;
        }
        .password-toggle:hover { color: var(--primary); }
        [dir="rtl"] .password-toggle { right: auto; left: 12px; }

        .btn-register {
            background: var(--primary-gradient);
            border: none; border-radius: 12px;
            padding: 0.95rem 2rem;
            font-weight: 700; font-size: 1rem;
            color: white; width: 100%;
            transition: all 0.3s; position: relative; overflow: hidden;
            letter-spacing: 0.5px;
        }
        .btn-register::before {
            content: ''; position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.5s;
        }
        .btn-register:hover::before { left: 100%; }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13,148,136,0.4);
        }

        .divider { height: 1px; background: linear-gradient(90deg, transparent, #e2e8f0, transparent); margin: 1.5rem 0; }
        .auth-links { text-align: center; }
        .auth-link {
            color: var(--primary); text-decoration: none;
            font-weight: 600; font-size: 0.9rem;
            display: inline-flex; align-items: center; gap: 0.5rem;
            transition: all 0.3s;
        }
        .auth-link:hover { color: var(--primary-dark); }
        [dir="ltr"] .auth-link:hover { transform: translateX(4px); }
        [dir="rtl"] .auth-link:hover { transform: translateX(-4px); }

        .section-divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 1.5rem 0 1.25rem;
        }
        .section-divider span { font-size: 0.8rem; color: #94a3b8; font-weight: 600; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px; }
        .section-divider::before, .section-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="background-animation">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <i class="fas fa-plus med-cross med-cross-1"></i>
        <i class="fas fa-plus med-cross med-cross-2"></i>
    </div>

    <div class="register-container">
        <div class="glass-card">
            <!-- Header -->
            <div class="card-header">
                <div class="header-pattern"></div>
                <img src="{{ $logo }}" alt="Logo" class="register-logo">
                <h3>{{ __('messages.register') }}</h3>
                <p>{{ __('messages.create_new_account') ?? 'Create your account to get started' }}</p>
            </div>

            <!-- Body -->
            <div class="card-body">
                @if ($errors->any())
                    <div style="background:linear-gradient(135deg,#fef2f2,#fee2e2);border:1px solid #fca5a5;border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;">
                        <ul style="margin:0;padding-left:1.2rem;">
                            @foreach ($errors->all() as $error)
                                <li style="color:#dc2626;font-weight:500;font-size:0.9rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Names Row -->
                    <div class="section-divider"><span><i class="fas fa-user me-1"></i> {{ __('messages.personal_info') ?? 'Personal Info' }}</span></div>
                    <div class="form-row-group">
                        <div class="form-group">
                            <label for="name_ar" class="form-label">
                                <i class="fas fa-font"></i> {{ __('messages.name_ar') }}
                            </label>
                            <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                name="name_ar" value="{{ old('name_ar') }}" required autofocus
                                placeholder="الاسم بالعربي">
                            @error('name_ar')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name_en" class="form-label">
                                <i class="fas fa-font"></i> {{ __('messages.name_en') }}
                            </label>
                            <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror"
                                name="name_en" value="{{ old('name_en') }}" required
                                placeholder="Name in English">
                            @error('name_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Row -->
                    <div class="form-row-group">
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone"></i> {{ __('messages.phone') }}
                            </label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone') }}" required
                                placeholder="+966 5xxxxxxxx">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="age" class="form-label">
                                <i class="fas fa-birthday-cake"></i> {{ __('messages.age') }}
                            </label>
                            <input id="age" type="number" class="form-control @error('age') is-invalid @enderror"
                                name="age" value="{{ old('age') }}" required min="1" max="120"
                                placeholder="25">
                            @error('age')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="section-divider"><span><i class="fas fa-lock me-1"></i> {{ __('messages.account_details') ?? 'Account Details' }}</span></div>
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> {{ __('messages.email') }}
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="example@email.com">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Passwords Row -->
                    <div class="form-row-group">
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> {{ __('messages.password') }}
                            </label>
                            <div class="password-wrap">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password"
                                    placeholder="••••••••">
                                <button type="button" class="password-toggle" onclick="togglePwd('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="form-label">
                                <i class="fas fa-shield-alt"></i> {{ __('messages.confirm_password') }}
                            </label>
                            <div class="password-wrap">
                                <input id="confirm_password" type="password" class="form-control"
                                    name="confirm_password" required autocomplete="new-password"
                                    placeholder="••••••••">
                                <button type="button" class="password-toggle" onclick="togglePwd('confirm_password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-register mt-2">
                        <i class="fas fa-user-plus me-2"></i>{{ __('messages.register') }}
                    </button>
                </form>

                <div class="divider"></div>
                <div class="auth-links">
                    <a href="{{ route('loginPage') }}" class="auth-link">
                        <i class="fas fa-sign-in-alt"></i>
                        {{ __('messages.have_an_account') ?? 'Already have an account?' }}
                        {{ __('messages.login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePwd(id, btn) {
            const input = document.getElementById(id);
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            btn.innerHTML = isText ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        }
    </script>
</body>
</html>
