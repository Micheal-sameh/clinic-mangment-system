@extends('layouts.sideBar')
<title>Management System</title>
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-center bg-primary text-white py-4">
                        <h3>{{ __('messages.login') }}</h3>
                    </div>

                    <div class="card-body p-5">
                        <!-- Error messages -->
                        <div id="error-messages" class="alert alert-danger d-none">
                            <ul id="error-list"></ul>
                        </div>

                        <!-- Login form -->
                        <form id="login-form" method="POST" action="{{ route('loginPage') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" id="email" class="form-control" name="email" required autofocus placeholder="{{ __('messages.enter')}} {{__('messages.email') }}">
                            </div>

                            <div class="form-group mb-4">
                                <label for="password" class="form-label">{{ __('messages.password') }}</label>
                                <input type="password" id="password" class="form-control" name="password" required placeholder="{{ __('messages.enter')}} {{__('messages.password') }}">
                            </div>

                            <div class="form-group form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    {{ __('messages.remember_me') }}
                                </label>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">
                                    {{ __('messages.login') }}
                                </button>
                            </div>
                        </form>

                        <div class="form-group mt-4 text-center">
                            <!-- Register link -->
                            <a href="{{ route('register') }}" class="text-decoration-none text-primary">
                                {{ __('messages.register') }}
                            </a>
                        </div>

                        <div class="form-group mt-4 text-center">
                            {{-- <a class="btn btn-link" href="{{ route('password.request') }}"> --}}
                                {{ __('messages.forget') }}
                            {{-- </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const form = document.getElementById('login-form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const errors = [];
            if (!document.getElementById('email').value) {
                errors.push('{{ __("Email is required.") }}');
            }
            if (!document.getElementById('password').value) {
                errors.push('{{ __("Password is required.") }}');
            }

            if (errors.length > 0) {
                const errorMessagesDiv = document.getElementById('error-messages');
                const errorList = document.getElementById('error-list');

                errorList.innerHTML = '';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });

                errorMessagesDiv.classList.remove('d-none');
            } else {
                form.submit();
            }
        });
    </script>
@endsection
