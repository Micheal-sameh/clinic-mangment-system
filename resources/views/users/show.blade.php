@extends('layouts.sideBar')

@section('title')
    {{ $user->localized_name }}
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <!-- Back Navigation -->
                <div class="mb-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>
                        {{ __('messages.back_to_users') ?? 'Back to Users' }}
                    </a>
                </div>

                <!-- Main Profile Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center mb-5">
                            <div class="col-auto">
                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px; font-size: 2rem;">
                                    {{ strtoupper(substr($user->localized_name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="col">
                                <h1 class="h3 mb-1">{{ $user->localized_name }}</h1>
                                <div class="d-flex align-items-center gap-3 text-muted">
                                    <span
                                        class="badge bg-{{ $user->status == App\Enums\UserStatus::ACTIVE ? 'success' : 'secondary' }}">
                                        {{ App\Enums\UserStatus::getStringValue($user->status) }}
                                    </span>
                                    <span class="badge bg-info">{{ $user->roles->first()->name ?? 'No Role' }}</span>
                                    <span>Member since {{ $user->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Left Column - User Details -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="mb-3">Contact Information</h5>
                                    <div class="list-group list-group-flush">
                                        <div class="list-group-item px-0">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-envelope text-muted me-3" style="width: 20px;"></i>
                                                <div>
                                                    <small class="text-muted">Email</small>
                                                    <div class="fw-medium">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item px-0">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-phone text-muted me-3" style="width: 20px;"></i>
                                                <div>
                                                    <small class="text-muted">Phone</small>
                                                    <div class="fw-medium">{{ $user->phone ?? 'Not provided' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($user->age)
                                            <div class="list-group-item px-0">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-birthday-cake text-muted me-3"
                                                        style="width: 20px;"></i>
                                                    <div>
                                                        <small class="text-muted">Age</small>
                                                        <div class="fw-medium">{{ $user->age }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Statistics -->
                            <div class="col-md-6">
                                <h5 class="mb-3">{{ __('messages.statistics') ?? 'Statistics' }}</h5>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="border rounded p-3 text-center">
                                            <div class="h4 mb-1 text-primary">{{ $totalReservations }}</div>
                                            <small class="text-muted">{{ __('messages.total_reservations') ?? 'Total Reservations' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-3 text-center">
                                            <div class="h4 mb-1 text-success">{{ $completedReservations }}</div>
                                            <small class="text-muted">{{ __('messages.completed') ?? 'Completed' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-3 text-center">
                                            <div class="h4 mb-1 text-info">{{ $upcomingReservations }}</div>
                                            <small class="text-muted">{{ __('messages.upcoming') ?? 'Upcoming' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-3 text-center">
                                            <div class="h4 mb-1 text-warning">{{ $cancelledReservations }}</div>
                                            <small class="text-muted">{{ __('messages.cancelled') ?? 'Cancelled' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservations Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Reservations</h5>
                    </div>
                    <div class="card-body">
                        @if ($reservations && $reservations->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>{{ __('messages.total') }}</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $reservation)
                                            <tr>
                                                <td class="fw-medium">{{ __('messages.reservation_id') }}{{ $reservation->id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('h:i A') }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-dark">{{ $reservation->service_type ?? 'General' }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $reservation->status == 'confirmed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($reservation->status) }}
                                                    </span>
                                                </td>
                                                <td class="fw-medium">${{ number_format($reservation->total_price, 2) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('reservations.show', $reservation->id) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                                <h6 class="text-muted">No reservations found</h6>
                                <p class="text-muted small">This user hasn't made any reservations yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                @can('users_edit')
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center py-3 rounded-3 shadow-sm">
                                        <i class="fas fa-edit me-2"></i>
                                        {{ __('messages.edit_profile') }}
                                    </a>
                                @endcan
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('reservations.create') }}"
                                    class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center py-3 rounded-3 shadow-sm">
                                    <i class="fas fa-plus me-2"></i>
                                    {{ __('messages.new_reservation') }}
                                </a>

                            </div>
                            {{-- <div class="col-md-4">
                                <button
                                    class="btn btn-outline-info w-100 d-flex align-items-center justify-content-center py-3">
                                    <i class="fas fa-envelope me-2"></i>
                                    Send Message
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            font-weight: 600;
        }

        .card {
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 0;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.875rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-sm {
            border-radius: 4px;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .fw-medium {
            font-weight: 500;
        }
    </style>
@endsection
