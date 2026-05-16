<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
@php
    $logo = app()->make('App\Repositories\SettingRepository')->getLogo() ?: asset('images/logo.jpg');
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} — {{ env('APP_NAME') }}</title>

    <link rel="icon" href="{{ $logo }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0d9488;
            --primary-dark: #0f766e;
            --primary-darker: #134e4a;
            --primary-light: #5eead4;
            --primary-gradient: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #0891b2 100%);
            --glass-bg: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.25);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #0891b2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        /* Animated Background */
        .background-animation {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .floating-shapes { position: absolute; width: 100%; height: 100%; }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            animation: float 8s ease-in-out infinite;
        }

        .shape-1 { width: 280px; height: 280px; top: 5%; left: 2%; animation-delay: 0s; }
        .shape-2 { width: 180px; height: 180px; top: 55%; right: 5%; animation-delay: 2s; }
        .shape-3 { width: 120px; height: 120px; bottom: 15%; left: 15%; animation-delay: 4s; }
        .shape-4 { width: 150px; height: 150px; top: 25%; right: 15%; animation-delay: 1s; }
        .shape-5 { width: 80px; height: 80px; top: 75%; left: 40%; animation-delay: 3s; }

        /* Medical cross decorations */
        .med-cross {
            position: absolute;
            color: rgba(255, 255, 255, 0.06);
            font-size: 5rem;
            animation: float 10s ease-in-out infinite;
        }
        .med-cross-1 { top: 15%; right: 8%; animation-delay: 0.5s; }
        .med-cross-2 { bottom: 20%; left: 5%; animation-delay: 2.5s; font-size: 3.5rem; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(10deg); }
        }

        /* Main Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Glass Card */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            box-shadow: var(--shadow-xl), inset 0 1px 0 rgba(255,255,255,0.15);
            overflow: hidden;
            width: 100%;
            max-width: 460px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255,255,255,0.15);
        }

        /* Card Header */
        .card-header {
            background: rgba(255, 255, 255, 0.08);
            border-bottom: 1px solid var(--glass-border);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-pattern {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            opacity: 0.15;
            background: radial-gradient(circle at 20% 30%, #5eead4, transparent 55%),
                        radial-gradient(circle at 80% 70%, #0891b2, transparent 50%);
        }

        .login-logo {
            width: 84px; height: 84px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px;
            margin-bottom: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease;
            position: relative; z-index: 1;
        }

        .login-logo:hover { transform: scale(1.08) rotate(-3deg); }

        .card-header h3 {
            font-weight: 700;
            color: white;
            margin-bottom: 0.4rem;
            font-size: 1.8rem;
            position: relative; z-index: 1;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.78);
            font-size: 0.95rem;
            position: relative; z-index: 1;
        }

        /* Card Body */
        .card-body {
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.96);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .form-label i { color: var(--primary); width: 16px; }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
            color: #1e293b;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12);
            transform: translateY(-1px);
            outline: none;
        }

        .form-control::placeholder { color: #94a3b8; }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            z-index: 10;
            transition: color 0.2s;
        }
        .password-toggle:hover { color: var(--primary); }

        [dir="rtl"] .password-toggle { right: auto; left: 12px; }

        /* Checkbox */
        .form-check { margin-bottom: 1.5rem; }
        .form-check-input { width: 1.1em; height: 1.1em; margin-top: 0.15em; border: 2px solid #cbd5e1; }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
        .form-check-label { color: #475569; font-weight: 500; font-size: 0.9rem; }

        /* Submit Button */
        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.5s;
        }
        .btn-login:hover::before { left: 100%; }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.4);
        }
        .btn-login:active { transform: translateY(0); }

        /* Links */
        .auth-links {
            text-align: center;
            margin-top: 1rem;
        }
        .auth-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .auth-link:hover { color: var(--primary-dark); }
        [dir="ltr"] .auth-link:hover { transform: translateX(4px); }
        [dir="rtl"] .auth-link:hover { transform: translateX(-4px); }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 1.5rem 0;
        }

        /* Error Messages */
        .error-messages {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border: 1px solid #fca5a5;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }
        .error-messages ul { margin-bottom: 0; padding-left: 1.2rem; }
        .error-messages li { color: #dc2626; font-weight: 500; font-size: 0.9rem; }

        /* Responsive */
        @media (max-width: 480px) {
            .card-body { padding: 2rem 1.5rem; }
            .card-header { padding: 2rem 1.5rem; }
            .login-logo { width: 70px; height: 70px; }
        }

        /* Slide-in animation */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .glass-card { animation: slideInUp 0.6s ease-out; }
        .form-group { animation: slideInUp 0.6s ease-out; animation-fill-mode: both; }
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="background-animation">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
        </div>
        <i class="fas fa-plus med-cross med-cross-1"></i>
        <i class="fas fa-plus med-cross med-cross-2"></i>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="glass-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="header-pattern"></div>
                <img src="{{ $logo }}" alt="Logo" class="login-logo">
                <h3>{{ __('messages.login') }}</h3>
                <p>{{ __('messages.welcome_back') ?? 'Welcome back! Please sign in to your account' }}</p>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <!-- Error Messages -->
                <div id="error-messages" class="error-messages d-none">
                    <ul id="error-list" class="mb-0"></ul>
                </div>

                <!-- Login Form -->
                <form id="login-form" method="POST" action="{{ route('loginPage') }}">
                    @csrf

                    <!-- Email or Phone Field -->
                    <div class="form-group">
                        <label for="email_or_phone" class="form-label">
                            <i class="fas fa-envelope"></i>
                            {{ __('messages.email_or_phone') }}
                        </label>
                        <input type="text" id="email_or_phone" class="form-control" name="email_or_phone" required autofocus
                            placeholder="{{ __('messages.email_or_phone') }}"
                            autocomplete="username">
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            {{ __('messages.password') }}
                        </label>
                        <div class="position-relative">
                            <input type="password" id="password" class="form-control" name="password" required
                                placeholder="{{ __('messages.enter_password') ?? 'Enter your password' }}"
                                autocomplete="current-password">
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            {{ __('messages.remember_me') }}
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-login" id="loginButton">
                        <span class="button-text">{{ __('messages.login') }}</span>
                        <span class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider"></div>

                <!-- Additional Links -->
                <div class="auth-links">
                    <a href="{{ route('register') }}" class="auth-link">
                        {{ __('messages.create_account') ?? 'Create an account' }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="auth-links">
                    <a href="#" class="auth-link">
                        {{ __('messages.forgot_password') ?? 'Forgot your password?' }}
                        <i class="fas fa-question-circle"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('login-form');
            const loginButton = document.getElementById('loginButton');
            const buttonText = loginButton.querySelector('.button-text');
            const spinner = loginButton.querySelector('.spinner-border');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            // Password visibility toggle
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-eye-slash"></i>';
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const errors = [];
                const emailOrPhone = document.getElementById('email_or_phone').value.trim();
                const password = document.getElementById('password').value.trim();

                // Validation
                if (!emailOrPhone) {
                    errors.push('{{ __('Email or phone number is required') }}');
                } else if (!isValidEmail(emailOrPhone) && !isValidPhone(emailOrPhone)) {
                    errors.push('{{ __('Please enter a valid email address or phone number') }}');
                }

                if (!password) {
                    errors.push('{{ __('Password is required') }}');
                } else if (password.length < 6) {
                    errors.push('{{ __('Password must be at least 6 characters') }}');
                }

                // Display errors or submit
                const errorMessagesDiv = document.getElementById('error-messages');
                const errorList = document.getElementById('error-list');
                errorList.innerHTML = '';

                if (errors.length > 0) {
                    errors.forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });
                    errorMessagesDiv.classList.remove('d-none');

                    // Shake animation for errors
                    errorMessagesDiv.style.animation = 'none';
                    setTimeout(() => {
                        errorMessagesDiv.style.animation = 'shake 0.5s ease-in-out';
                    }, 10);
                } else {
                    errorMessagesDiv.classList.add('d-none');

                    // Show loading state
                    loginButton.classList.add('btn-loading');
                    buttonText.textContent = '{{ __('Signing in...') }}';
                    spinner.classList.remove('d-none');
                    loginButton.disabled = true;

                    // Submit the form
                    form.submit();
                }
            });

            // Email validation function
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Phone validation function
            function isValidPhone(phone) {
                const phoneRegex = /^\+?\d{10,15}$/;
                return phoneRegex.test(phone.replace(/\s+/g, ''));
            }

            // Add shake animation for errors
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-5px); }
                    75% { transform: translateX(5px); }
                }
            `;
            document.head.appendChild(style);

            // Auto-focus email or phone field
            document.getElementById('email_or_phone').focus();
        });
    </script>
</body>

</html>
