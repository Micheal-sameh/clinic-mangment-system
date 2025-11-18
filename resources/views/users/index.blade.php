@extends('layouts.sideBar')

@section('content')
    <div class="min-vh-100 bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-5">
        <div class="container">
            <!-- Animated Background Elements -->
            <div class="floating-elements">
                <div class="floating-element element-1"></div>
                <div class="floating-element element-2"></div>
                <div class="floating-element element-3"></div>
            </div>

            <!-- Premium Header -->
            <div class="text-center mb-5">

                <h1 class="display-6 fw-bold text-gradient mb-2">
                    @if($userType == 'staff')
                        {{ __('messages.users') }}
                    @else
                        {{ __('messages.patients') ?? 'Patients' }}
                    @endif
                </h1>
                <p class="text-muted fs-5">
                    @if($userType == 'staff')
                        {{ __('messages.manage_system_users') ?? 'Manage system users and their permissions' }}
                    @else
                        {{ __('messages.manage_patients') ?? 'Manage clinic patients' }}
                    @endif
                </p>
            </div>

            <!-- Flash Message -->
            @if (session('message'))
                <div class="alert alert-success glass-effect border-0 alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="success-icon rounded-circle p-2 me-3">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ __('messages.success') ?? 'Success!' }}</h6>
                            <p class="mb-0">{{ session('message') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Stats and Filters Card -->
            <div class="card glass-effect border-0 rounded-4 shadow-xxl mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <!-- Statistics -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary text-white rounded-3 p-3 me-3">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-primary">{{ $users->total() }}</h4>
                                    <p class="text-muted mb-0">{{ __('messages.total_users') ?? 'Total Users' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="col-md-8">
                            <form action="{{ $userType === 'staff' ? route('users.index') : route('patients.index') }}" method="GET" id="filter-form">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="input-group premium-input">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-user-tag text-primary"></i>
                                            </span>
                                            <select name="role" class="form-select border-start-0">
                                                <option value="">{{ __('messages.all_roles') ?? 'All Roles' }}
                                                </option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ request()->role == $role->name ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group premium-input">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-search text-primary"></i>
                                            </span>
                                            <input type="text" name="name" id="name-input"
                                                class="form-control border-start-0"
                                                placeholder="{{ __('messages.search_users') ?? 'Search users...' }}"
                                                value="{{ request()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-filter me-1"></i>
                                            {{ __('messages.filter') ?? 'Filter' }}
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        @if (request()->role || request()->name)
                                            <a href="{{ $userType === 'staff' ? route('users.index') : route('patients.index') }}" class="btn btn-outline-secondary w-100" title="{{ __('messages.clear_filters') ?? 'Clear Filters' }}">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @else
                                            <div></div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="filter-info">
                    @if (request()->role || request()->name)
                        <span class="badge bg-primary glass-effect">
                            <i class="fas fa-filter me-1"></i>
                            {{ __('messages.filtered_results') ?? 'Filtered' }}
                        </span>
                    @endif
                </div>
                @can('users_create')
                    <a href="{{ $userType === 'staff' ? route('users.create') : route('patients.create') }}" class="btn btn-primary btn-glow rounded-pill px-4 py-2">
                        <i class="fas fa-user-plus me-2"></i>
                        {{ $userType === 'staff' ? __('messages.add_user') : __('messages.add_patient') }}
                    </a>
                @endcan
            </div>

            <!-- Desktop Table View -->
            <div class="d-none d-lg-block">
                <div class="card glass-effect border-0 rounded-4 shadow-xxl">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 80px;">#</th>
                                        <th>{{ __('messages.user') ?? 'User' }}</th>
                                        <th>{{ __('messages.role') ?? 'Role' }}</th>
                                        <th style="width: 120px;">{{ __('messages.status') }}</th>
                                        <th>{{ __('messages.contact') ?? 'Contact' }}</th>
                                        <th class="text-center" style="width: 150px;">{{ __('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        @php
                                            $isActive = $user->status == App\Enums\UserStatus::ACTIVE;
                                            $userRoles = $user->roles->pluck('name')->toArray();
                                            $isAdminOrOwner =
                                                in_array('admin', $userRoles) || in_array('owner', $userRoles);
                                            $canEdit =
                                                auth()->user()->hasRole('owner') ||
                                                (auth()->user()->hasRole('admin') && !$isAdminOrOwner);
                                        @endphp
                                        <tr class="user-row">
                                            <td class="ps-4 fw-semibold text-muted">
                                                <div
                                                    class="user-number bg-primary bg-opacity-10 text-primary rounded-2 px-2 py-1 d-inline-block">
                                                    {{ $key + 1 + ($users->currentPage() - 1) * $users->perPage() }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        @can('users_show')
                                                            <a href="{{ route('users.show', $user['id']) }}"
                                                                class="text-decoration-none text-dark fw-semibold user-name">
                                                                {{ $user->localized_name }}
                                                            </a>
                                                        @else
                                                            <span
                                                                class="fw-semibold text-dark">{{ $user->localized_name }}</span>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        {{ ucfirst($role->name) }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                <form action="{{ route('users.changeStatus', $user->id) }}" method="post"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('put')
                                                    <button
                                                        class="btn btn-sm {{ $isActive ? 'btn-success' : 'btn-danger' }} status-toggle"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $isActive ? __('messages.deactivate_user') : __('messages.activate_user') }}">
                                                        <i
                                                            class="fas {{ $isActive ? 'fa-thumbs-up' : 'fa-thumbs-down' }} me-1"></i>
                                                        {{ App\Enums\UserStatus::getStringValue($user->status) }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="fas fa-envelope text-muted me-2" style="width: 16px;"></i>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                    @if ($user->phone)
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-phone text-muted me-2"
                                                                style="width: 16px;"></i>
                                                            <small class="text-muted">{{ $user->phone }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @can('users_show')
                                                        <a href="{{ route('users.show', $user['id']) }}"
                                                            class="btn btn-outline-primary rounded-start"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ __('messages.view_profile') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @if ($canEdit)
                                                        @can('users_edit')
                                                            <a href="{{ route('users.edit', $user['id']) }}"
                                                                class="btn btn-outline-secondary" data-bs-toggle="tooltip"
                                                                title="{{ __('messages.edit_user') }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('users_reset_pass')
                                                            <form action="{{ route('users.resetPassword', $user['id']) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button class="btn btn-outline-warning rounded-end"
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ __('messages.reset_password') }}"
                                                                    onclick="return confirm('{{ __('messages.confirm_password_reset') }}')">
                                                                    <i class="fas fa-key"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-block d-lg-none">
                <div class="row g-3">
                    @foreach ($users as $user)
                        @php
                            $isActive = $user->status == App\Enums\UserStatus::ACTIVE;
                            $userRoles = $user->roles->pluck('name')->toArray();
                            $isAdminOrOwner = in_array('admin', $userRoles) || in_array('owner', $userRoles);
                            $canEdit =
                                auth()->user()->hasRole('owner') ||
                                (auth()->user()->hasRole('admin') && !$isAdminOrOwner);
                        @endphp
                        <div class="col-12">
                            <div class="card user-card glass-effect border-0 rounded-4 shadow-sm">
                                <div class="card-body">
                                    <!-- User Header -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="user-avatar-sm bg-primary text-white rounded-circle me-3">
                                            {{ strtoupper(substr($user->localized_name, 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $user->localized_name }}</h6>
                                            <div class="user-roles">
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-primary bg-opacity-10 text-primary me-1">
                                                        {{ ucfirst($role->name) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <form action="{{ route('users.changeStatus', $user->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('put')
                                            <button
                                                class="btn btn-sm {{ $isActive ? 'btn-success' : 'btn-danger' }} status-toggle">
                                                <i class="fas {{ $isActive ? 'fa-thumbs-up' : 'fa-thumbs-down' }}"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Contact Info -->
                                    <div class="contact-info mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope text-muted me-2" style="width: 16px;"></i>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                        @if ($user->phone)
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-phone text-muted me-2" style="width: 16px;"></i>
                                                <small class="text-muted">{{ $user->phone }}</small>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        @can('users_show')
                                            <a href="{{ route('users.show', $user['id']) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ __('messages.view') }}
                                            </a>
                                        @endcan

                                        @if ($canEdit)
                                            <div class="d-flex gap-2">
                                                @can('users_edit')
                                                    <a href="{{ route('users.edit', $user['id']) }}"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('users_reset_pass')
                                                    <form action="{{ route('users.resetPassword', $user['id']) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-outline-warning btn-sm"
                                                            onclick="return confirm('{{ __('messages.confirm_password_reset') }}')">
                                                            <i class="fas fa-key"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if ($users->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card glass-effect border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <div class="text-muted small mb-2 mb-md-0">
                                        {{ __('messages.showing') ?? 'Showing' }}
                                        {{ $users->firstItem() }} - {{ $users->lastItem() }}
                                        {{ __('messages.of') ?? 'of' }} {{ $users->total() }}
                                    </div>
                                    <nav>
                                        {{ $users->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Statistics -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card glass-effect border-0 rounded-4">
                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-chart-pie text-primary me-2"></i>
                                {{ __('messages.user_statistics') ?? 'User Statistics' }}
                            </h6>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-primary mb-1">{{ $users->total() }}</h4>
                                        <small
                                            class="text-muted">{{ __('messages.total_users') ?? 'Total Users' }}</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-success mb-1">
                                            {{ $users->where('status', App\Enums\UserStatus::ACTIVE)->count() }}</h4>
                                        <small
                                            class="text-muted">{{ __('messages.active_users') ?? 'Active Users' }}</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-danger mb-1">
                                            {{ $users->where('status', App\Enums\UserStatus::INACTIVE)->count() }}</h4>
                                        <small
                                            class="text-muted">{{ __('messages.inactive_users') ?? 'Inactive Users' }}</small>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-xxl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .bg-gradient-to-br {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f7fa 50%, #faf5ff 100%);
            position: relative;
            overflow: hidden;
        }

        /* Floating Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.05));
            animation: float 8s ease-in-out infinite;
        }

        .element-1 {
            width: 100px;
            height: 100px;
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .element-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 5%;
            animation-delay: 3s;
        }

        .element-3 {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 6s;
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

        /* Glass Morphism */
        .glass-effect {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Premium Elements */
        .premium-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: 600;
        }

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* User Avatars */
        .user-avatar {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .user-avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }

        .user-number {
            font-size: 0.9rem;
            min-width: 35px;
            text-align: center;
        }

        /* Buttons */
        .btn-glow {
            background: var(--primary-gradient);
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        /* Status Toggle */
        .status-toggle {
            transition: all 0.3s ease;
        }

        .status-toggle:hover {
            transform: scale(1.05);
        }

        /* Table Styling */
        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            padding: 1.25rem 0.75rem;
            background: rgba(248, 249, 250, 0.8);
        }

        .table td {
            padding: 1.25rem 0.75rem;
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.5);
        }

        .user-row:hover td {
            background: rgba(255, 255, 255, 0.8) !important;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Form Elements */
        .premium-input .form-control,
        .premium-input .form-select {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .premium-input .form-control:focus,
        .premium-input .form-select:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
        }

        .input-group-text {
            background-color: rgba(248, 249, 250, 0.8);
            border-color: rgba(222, 226, 230, 0.5);
        }

        /* Cards */
        .user-card {
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Statistics */
        .stat-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-item {
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-3px);
        }

        /* Success Icon */
        .success-icon {
            background: var(--primary-gradient);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .display-6 {
                font-size: 2rem;
            }

            .floating-element {
                display: none;
            }

            .btn-group .btn {
                padding: 0.375rem 0.5rem;
            }
        }

        .rounded-4 {
            border-radius: 20px !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Search with delay
            let typingTimer;
            const doneTypingInterval = 800;
            const nameInput = document.getElementById('name-input');

            if (nameInput) {
                nameInput.addEventListener('keyup', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(submitForm, doneTypingInterval);
                });
            }

            function submitForm() {
                document.getElementById('filter-form').submit();
            }

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Add loading state to status toggle buttons
            const statusForms = document.querySelectorAll('form[action*="changeStatus"]');
            statusForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    }
                });
            });
        });
    </script>
@endsection
