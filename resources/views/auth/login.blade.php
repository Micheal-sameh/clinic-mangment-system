<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management System</title>

    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1f2937, #111827);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #333;
        }

        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            color: #fff;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .login-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #fff;
            padding: 10px;
            margin-bottom: 10px;
        }

        .text-primary {
            color: #2563eb !important;
        }

        a.text-primary:hover {
            text-decoration: underline;
        }

        #error-messages {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-center py-4">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="login-logo">
                        <h3 class="fw-bold mb-0">{{ __('messages.login') }}</h3>
                    </div>

                    <div class="card-body p-5 bg-white">
                        <!-- Error messages -->
                        <div id="error-messages" class="alert alert-danger d-none">
                            <ul id="error-list" class="mb-0"></ul>
                        </div>

                        <!-- Login form -->
                        <form id="login-form" method="POST" action="{{ route('loginPage') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">{{ __('messages.email') }}</label>
                                <input type="email" id="email" class="form-control" name="email" required
                                    autofocus placeholder="{{ __('messages.enter') }} {{ __('messages.email') }}">
                            </div>

                            <div class="mb-4">
                                <label for="password"
                                    class="form-label fw-semibold">{{ __('messages.password') }}</label>
                                <input type="password" id="password" class="form-control" name="password" required
                                    placeholder="{{ __('messages.enter') }} {{ __('messages.password') }}">
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    {{ __('messages.remember_me') }}
                                </label>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100 py-2">
                                    {{ __('messages.login') }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}" class="text-decoration-none text-primary">
                                {{ __('messages.register') }}
                            </a>
                        </div>

                        <div class="text-center mt-3 text-muted">
                            {{ __('messages.forget') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const form = document.getElementById('login-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const errors = [];
            if (!document.getElementById('email').value.trim()) {
                errors.push('{{ __('Email is required.') }}');
            }
            if (!document.getElementById('password').value.trim()) {
                errors.push('{{ __('Password is required.') }}');
            }

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
            } else {
                errorMessagesDiv.classList.add('d-none');
                form.submit();
            }
        });
    </script>
</body>

</html>
