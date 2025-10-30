<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management System</title>

    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        /* Animated Background */
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .shape-4 {
            width: 120px;
            height: 120px;
            top: 30%;
            right: 20%;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
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
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        /* Card Header */
        .card-header {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background: radial-gradient(circle at 30% 30%, #667eea, transparent 50%),
                radial-gradient(circle at 70% 70%, #764ba2, transparent 50%);
        }

        .login-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            padding: 12px;
            margin-bottom: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .login-logo:hover {
            transform: scale(1.05);
        }

        .card-header h3 {
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        /* Card Body */
        .card-body {
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.95);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: #667eea;
            width: 16px;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        /* Checkbox */
        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 1.1em;
            height: 1.1em;
            margin-top: 0.15em;
            border: 2px solid #cbd5e0;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: #4a5568;
            font-weight: 500;
        }

        /* Buttons */
        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Links */
        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-link:hover {
            color: #5a67d8;
            transform: translateX(5px);
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 1.5rem 0;
        }

        /* Error Messages */
        .error-messages {
            background: linear-gradient(135deg, #fed7d7, #feb2b2);
            border: 1px solid #fc8181;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .error-messages ul {
            margin-bottom: 0;
            padding-left: 1rem;
        }

        .error-messages li {
            color: #c53030;
            font-weight: 500;
        }

        /* Loading Animation */
        .btn-loading .spinner-border {
            width: 1rem;
            height: 1rem;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card-body {
                padding: 2rem 1.5rem;
            }

            .card-header {
                padding: 2rem 1.5rem;
            }

            .login-logo {
                width: 70px;
                height: 70px;
            }
        }

        /* RTL Support */
        [dir="rtl"] .auth-link:hover {
            transform: translateX(-5px);
        }

        [dir="rtl"] .password-toggle {
            right: auto;
            left: 12px;
        }

        [dir="rtl"] .form-label i {
            order: 1;
        }

        /* Animation for form elements */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            animation: slideInUp 0.6s ease-out;
        }

        .form-group {
            animation: slideInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(3) {
            animation-delay: 0.3s;
        }

        .btn-login {
            animation-delay: 0.4s;
        }

        .auth-links {
            animation-delay: 0.5s;
        }
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
        </div>
    </div>

    <!-- Login Container -->
    <div class="login-container">
        <div class="glass-card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="header-pattern"></div>
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="login-logo">
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
