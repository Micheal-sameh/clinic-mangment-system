@extends('layouts.sideBar')

@section('content')

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <!-- User Profile Header -->
                <div class="card shadow-lg rounded-4 mb-5 overflow-hidden">
                    <div class="card-header bg-gradient-primary p-4 text-white position-relative">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="h3 mb-1">{{ $user->localized_name }}</h1>
                                <p class="mb-0 opacity-75">{{ $user->email }}</p>
                            </div>
                            <div class="avatar-container">
                                <div
                                    class="avatar-circle bg-white text-primary d-flex align-items-center justify-content-center">
                                    <span class="h4 mb-0">{{ substr($user->localized_name, 0, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Details -->
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-card p-3 rounded-3 border">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <h6 class="mb-0">{{ __('messages.email') }}</h6>
                                    </div>
                                    <p class="mb-0 text-muted">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-card p-3 rounded-3 border">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <h6 class="mb-0">{{ __('messages.phone') }}</h6>
                                    </div>
                                    <p class="mb-0 text-muted">{{ $user->phone ?? __('messages.not_provided') }}</p>
                                </div>
                            </div>

                            @if ($user->age)
                                <div class="col-md-6">
                                    <div class="detail-card p-3 rounded-3 border">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-birthday-cake text-primary me-2"></i>
                                            <h6 class="mb-0">{{ __('messages.age') }}</h6>
                                        </div>
                                        <p class="mb-0 text-muted">{{ $user->age }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-card p-3 rounded-3 border">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-calendar-check text-primary me-2"></i>
                                            <h6 class="mb-0">{{ __('messages.reservations') }}</h6>
                                        </div>
                                        <p class="mb-0 text-muted">{{ $reservationsCount }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Content Tabs -->
                <div class="card shadow-sm rounded-4 mb-5">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                            @if (!auth()->user()->hasRole('admin') && $reservationsCount > 0)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="reservations-tab" data-bs-toggle="tab"
                                        data-bs-target="#reservations" type="button" role="tab"
                                        aria-controls="reservations" aria-selected="true">
                                        <i class="fas fa-calendar-alt me-2"></i>{{ __('messages.upcoming_reservations') }}
                                    </button>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if (auth()->user()->hasRole('admin') || $reservationsCount == 0) active @endif" id="password-tab"
                                    data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab"
                                    aria-controls="password" aria-selected="false">
                                    <i class="fas fa-key me-2"></i>{{ __('messages.change_password') }}
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content" id="profileTabsContent">
                            @if (!auth()->user()->hasRole('admin') && $reservationsCount > 0)
                                <div class="tab-pane fade show active" id="reservations" role="tabpanel"
                                    aria-labelledby="reservations-tab">
                                    @if ($reservations && !is_null($reservations))
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>{{ __('messages.number') }}</th>
                                                        <th>{{ __('messages.date') }}</th>
                                                        <th>{{ __('messages.slate') }}</th>
                                                        <th>{{ __('messages.price') }}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($reservations as $key => $reservation)
                                                        <tr class="reservation-row">
                                                            <td class="fw-medium">{{ $key + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d-m-Y') }}
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-primary">{{ $reservation->reservation_number }}</span>
                                                            </td>
                                                            <td class="fw-bold text-success">
                                                                {{ $reservation->total_price }}</td>
                                                            <td class="text-end">
                                                                <a href="{{ route('reservations.show', $reservation->id) }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye me-1"></i>
                                                                    {{ __('messages.view') }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="fas fa-calendar-times text-muted display-4 mb-3"></i>
                                            <h5 class="text-muted">{{ __('messages.no_upcoming_visits') }}</h5>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="tab-pane fade @if (auth()->user()->hasRole('admin') || $reservationsCount == 0) show active @endif" id="password"
                                role="tabpanel" aria-labelledby="password-tab">
                                <div class="row justify-content-center">
                                    <div class="col-md-10 col-lg-8">
                                        <form method="POST" action="{{ route('users.password.update', $user->id) }}"
                                            class="needs-validation" novalidate>
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-4">
                                                <label for="current_password"
                                                    class="form-label">{{ __('messages.current_password') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-lock text-muted"></i>
                                                    </span>
                                                    <input type="password" id="current_password" name="current_password"
                                                        class="form-control border-start-0 @error('current_password') is-invalid @enderror"
                                                        required>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="current_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('current_password')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="new_password"
                                                    class="form-label">{{ __('messages.new_password') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-key text-muted"></i>
                                                    </span>
                                                    <input type="password" id="new_password" name="new_password"
                                                        class="form-control border-start-0 @error('new_password') is-invalid @enderror"
                                                        required>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="new_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('new_password')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="new_password_confirmation"
                                                    class="form-label">{{ __('messages.confirm_password') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-key text-muted"></i>
                                                    </span>
                                                    <input type="password" id="new_password_confirmation"
                                                        name="new_password_confirmation"
                                                        class="form-control border-start-0" required>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary toggle-password"
                                                        data-target="new_password_confirmation">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-save me-2"></i> {{ __('messages.change_password') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .detail-card {
            transition: all 0.3s ease;
            height: 100%;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
        }

        .nav-tabs .nav-link.active {
            color: #4e73df;
            border-bottom: 3px solid #4e73df;
            background-color: transparent;
        }

        .reservation-row:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .toggle-password {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            border-color: #4e73df;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Form validation
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>

@endsection
