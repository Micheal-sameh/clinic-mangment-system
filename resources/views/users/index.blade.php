@extends('layouts.sideBar')

@section('title', __('messages.users'))

@section('content')
    <div class="container-fluid px-3 px-md-5 py-4">

        <!-- Page Title -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">{{ __('messages.users') }}</h2>
            <div class="divider mx-auto my-3"></div>
        </div>

        <!-- Flash Message -->
        @if (session('message'))
            <div class="alert alert-success fade show shadow-sm text-center w-75 mx-auto" id="flashMessage"
                style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="card shadow-sm mb-4 border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('users.index') }}" method="GET" id="filter-form"
                    class="row g-3 align-items-center justify-content-center">
                    <div class="col-md-4 col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-user-tag"></i></span>
                            <select name="role" class="form-select" onchange="submitForm()">
                                <option value="">{{ __('messages.select_role') ?? 'Select User Type' }}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ request()->role == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-search"></i></span>
                            <input type="text" name="name" id="name-input" class="form-control"
                                placeholder="{{ __('messages.search_by_name') ?? 'Search by Name' }}"
                                value="{{ request()->name }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Create Button -->
        @can('user_create')
            <div class="text-end mb-4">
                <a href="{{ route('users.create') }}" class="btn btn-success btn-lg shadow-sm rounded-3">
                    <i class="fas fa-plus me-2"></i>{{ __('messages.add_user') ?? 'Add New User' }}
                </a>
            </div>
        @endcan

        <!-- Desktop Table View -->
        <div class="d-none d-md-block">
            <div class="table-responsive shadow-sm rounded-4">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.phone') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr class="bg-white">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @can('users_show')
                                        <a href="{{ route('users.show', $user['id']) }}"
                                            class="text-decoration-none fw-semibold text-dark">
                                            {{ $user->localized_name }}
                                        </a>
                                    @else
                                        {{ $user->localized_name }}
                                    @endcan
                                </td>
                                <td>
                                    <form action="{{ route('users.changeStatus', $user->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        @if ($user->status == App\Enums\UserStatus::ACTIVE)
                                            <button class="btn btn-outline-success btn-sm px-3">
                                                <i class="fa fa-thumbs-up me-1"></i>
                                                {{ App\Enums\UserStatus::getStringValue($user->status) }}
                                            </button>
                                        @else
                                            <button class="btn btn-outline-danger btn-sm px-3">
                                                <i class="fa fa-thumbs-down me-1"></i>
                                                {{ App\Enums\UserStatus::getStringValue($user->status) }}
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <div class="d-flex justify-content-center flex-wrap gap-2">
                                        @if (auth()->user()->hasRole('owner') ||
                                                (auth()->user()->hasRole('admin') && !$user->hasRole('admin') && !$user->hasRole('owner')))
                                            @can('users_edit')
                                                <a href="{{ route('users.edit', $user['id']) }}"
                                                    class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('users_reset_pass')
                                                <form action="{{ route('users.resetPassword', $user['id']) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-warning btn-sm" title="Reset Password">
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

        <!-- Mobile Card View -->
        <div class="d-md-none">
            @foreach ($users as $user)
                <div class="card shadow-sm border-0 mb-3 rounded-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $user->localized_name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>{{ __('messages.status') }}:</strong>
                            {{ App\Enums\UserStatus::getStringValue($user->status) }}</p>
                        <p class="mb-2"><strong>{{ __('messages.email') }}:</strong> {{ $user->email }}</p>
                        <p><strong>{{ __('messages.phone') }}:</strong> {{ $user->phone }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        @can('users_show')
                            <a href="{{ route('users.show', $user['id']) }}" class="btn btn-primary btn-sm"><i
                                    class="fas fa-eye"></i></a>
                        @endcan
                        @if (auth()->user()->hasRole('owner') ||
                                (auth()->user()->hasRole('admin') && !$user->hasRole('admin') && !$user->hasRole('owner')))
                            <div class="d-flex gap-2">
                                @can('users_edit')
                                    <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-secondary btn-sm"><i
                                            class="fas fa-edit"></i></a>
                                @endcan
                                @can('users_reset_pass')
                                    <form action="{{ route('users.resetPassword', $user['id']) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-warning btn-sm"><i class="fas fa-key"></i></button>
                                    </form>
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="d-flex justify-content-center my-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif

        <!-- Count -->
        <div class="text-center mt-4">
            <div class="alert alert-info shadow-sm w-50 mx-auto rounded-4">
                <strong>{{ __('messages.count') }} {{ __('messages.users') }}:</strong> {{ $users->total() }}
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .divider {
                width: 60px;
                height: 4px;
                background: #0d6efd;
                border-radius: 2px;
            }

            .table thead th {
                vertical-align: middle;
                font-weight: 600;
                letter-spacing: .5px;
            }

            .table tbody tr:hover {
                background-color: #f8f9fa;
            }

            /* Form Controls */
            .input-group .form-control,
            .input-group .form-select {
                border-radius: 0 8px 8px 0;
            }

            [dir="rtl"] .input-group .form-control,
            [dir="rtl"] .input-group .form-select {
                border-radius: 8px 0 0 8px;
            }

            .input-group-text {
                border-radius: 8px 0 0 8px;
            }

            [dir="rtl"] .input-group-text {
                border-radius: 0 8px 8px 0;
            }

            .alert {
                font-size: 0.95rem;
            }

            /* Mobile */
            @media (max-width: 768px) {
                .alert-info {
                    width: 90% !important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
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

            document.addEventListener('DOMContentLoaded', () => {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
            });
        </script>
    @endpush
@endsection
