@extends('layouts.sideBar')

@section('content')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            :root {
                --primary-color: #0d9488;
                --primary-dark: #0f766e;
                --secondary-color: #f0fdfa;
                --success-color: #0891b2;
                --border-color: #e2e8f0;
                --text-primary: #1e293b;
                --text-secondary: #64748b;
            }

            body {
                background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
                font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
                min-height: 100vh;
            }

            .edit-user-container {
                max-width: 800px;
                margin: 2rem auto;
            }

            .user-card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                overflow: hidden;
                background: white;
            }

            .card-header {
                background: linear-gradient(135deg, var(--primary-color), var(--success-color));
                color: white;
                padding: 1.5rem 2rem;
                border-bottom: none;
                position: relative;
            }

            .card-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
                opacity: 0.3;
            }

            .card-header h3 {
                margin: 0;
                font-weight: 700;
                font-size: 1.75rem;
                position: relative;
            }

            .card-header .user-icon {
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 2.5rem;
            }

            .form-section {
                margin-bottom: 2.5rem;
                padding-bottom: 1.5rem;
                border-bottom: 1px solid var(--border-color);
            }

            .form-section:last-of-type {
                border-bottom: none;
                margin-bottom: 0;
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
            }

            .section-title i {
                margin-right: 0.75rem;
                color: var(--primary-color);
                background: rgba(13, 148, 136, 0.1);
                width: 36px;
                height: 36px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .form-floating {
                margin-bottom: 1.25rem;
            }

            .form-control {
                border-radius: 10px;
                border: 1.5px solid var(--border-color);
                padding: 0.75rem 1rem;
                font-size: 1rem;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.15);
            }

            .form-label {
                font-weight: 500;
                color: var(--text-primary);
                margin-bottom: 0.5rem;
            }

            .input-group-text {
                background: var(--secondary-color);
                border: 1.5px solid var(--border-color);
                border-right: none;
                border-radius: 10px 0 0 10px;
            }

            .input-group .form-control {
                border-left: none;
                border-radius: 0 10px 10px 0;
            }

            .language-tabs {
                display: flex;
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 1rem;
                background: var(--secondary-color);
                padding: 4px;
            }

            .language-tab {
                flex: 1;
                text-align: center;
                padding: 0.75rem;
                background: transparent;
                border: none;
                font-weight: 500;
                color: var(--text-secondary);
                transition: all 0.3s ease;
                border-radius: 8px;
            }

            .language-tab.active {
                background: white;
                color: var(--primary-color);
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .language-content {
                display: none;
            }

            .language-content.active {
                display: block;
            }

            .btn-submit {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
                border: none;
                border-radius: 12px;
                padding: 1rem 2rem;
                font-weight: 600;
                font-size: 1.1rem;
                color: white;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                width: 100%;
                margin-top: 1rem;
            }

            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
            }

            .btn-submit:active {
                transform: translateY(0);
            }

            .spinner-border {
                width: 1.25rem;
                height: 1.25rem;
            }

            .password-toggle {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: var(--text-secondary);
                cursor: pointer;
                z-index: 10;
            }

            .password-field {
                position: relative;
            }

            .form-text {
                font-size: 0.875rem;
                color: var(--text-secondary);
                margin-top: 0.5rem;
            }

            .alert {
                border-radius: 10px;
                border: none;
                padding: 1rem 1.5rem;
            }

            @media (max-width: 768px) {
                .edit-user-container {
                    margin: 1rem;
                }

                .card-body {
                    padding: 1.5rem;
                }

                .card-header {
                    padding: 1.25rem 1.5rem;
                }
            }
        </style>
    </head>

    <div class="container edit-user-container">
        <div class="user-card">
            <div class="card-header text-center">
                <div class="user-icon mx-auto">
                    <i class="fas fa-user-plus fa-lg"></i>
                </div>
                <h3>{{ $isPatientCreate ? __('messages.add_patient') : __('messages.add_user') }}</h3>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <strong>{{ __('Please fix the following errors:') }}</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ $isPatientCreate ? route('patients.store') : route('users.store') }}" id="createUserForm">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-user"></i>
                            {{ __('Personal Information') }}
                        </div>

                        <!-- Language Tabs for Name -->
                        <div class="language-tabs mb-4">
                            <button type="button" class="language-tab active" data-language="ar">العربية</button>
                            <button type="button" class="language-tab" data-language="en">English</button>
                        </div>

                        <!-- Arabic Name -->
                        <div class="language-content active" id="name-ar">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                    id="name_ar" name="name_ar" value="{{ old('name_ar') }}"
                                    placeholder="{{ __('Name in Arabic') }}" required>
                                <label for="name_ar">{{ __('Name in Arabic') }}</label>
                                @error('name_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- English Name -->
                        <div class="language-content" id="name-en">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                    id="name_en" name="name_en" value="{{ old('name_en') }}"
                                    placeholder="{{ __('Name in English') }}" required>
                                <label for="name_en">{{ __('Name in English') }}</label>
                                @error('name_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="{{ __('Phone Number') }}" required>
                                    <label for="phone">{{ __('Phone Number') }}</label>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control @error('age') is-invalid @enderror"
                                        id="age" name="age" value="{{ old('age') }}"
                                        placeholder="{{ __('Age') }}" min="1" max="120">
                                    <label for="age">{{ __('Age') }}</label>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information Section -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-envelope"></i>
                            {{ __('Account Information') }}
                        </div>

                        <div class="form-floating">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="{{ __('Email Address') }}"
                                required>
                            <label for="email">{{ __('Email Address') }}</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if(!$isPatientCreate)
                        <div class="form-floating">
                            <select class="form-control @error('role') is-invalid @enderror" id="role" name="role"
                                required>
                                <option value="">{{ __('messages.select_role') ?? 'Select Role' }}</option>
                                @foreach ($roles ?? [] as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="role">{{ __('messages.role') }}</label>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                            <input type="hidden" name="role" value="patient">
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit" id="submitBtn">
                        <i class="fas fa-user-plus me-2"></i>
                        <span>{{ $isPatientCreate ? __('messages.add_patient') : __('messages.add_user') }}</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Language tabs functionality
            $('.language-tab').on('click', function() {
                const language = $(this).data('language');

                // Update active tab
                $('.language-tab').removeClass('active');
                $(this).addClass('active');

                // Show corresponding content
                $('.language-content').removeClass('active');
                $(`#name-${language}`).addClass('active');
            });

            // Password visibility toggle
            $('.password-toggle').on('click', function() {
                const target = $(this).data('target');
                const input = $(`#${target}`);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Form submission with loading state
            $('#editUserForm').on('submit', function() {
                $('#submitBtn').addClass('loading');
                $('#submitBtn').prop('disabled', true);
            });

            // Real-time validation
            $('input[required]').on('blur', function() {
                if ($(this).val() === '') {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Email validation
            $('#email').on('blur', function() {
                const email = $(this).val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email && !emailRegex.test(email)) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Please enter a valid email address.');
                }
            });

            // Password confirmation validation
            $('#password_confirmation').on('blur', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();

                if (password && confirmPassword && password !== confirmPassword) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Passwords do not match.');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
