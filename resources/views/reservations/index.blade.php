@extends('layouts.sideBar')

<title>{{__('messages.reservations')}}</title>

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-3 mb-md-0">
                    @if(request('history'))
                        <h1 class="h2 mb-2 text-gray-800">{{__('messages.history')}}</h1>
                        <p class="text-muted mb-0">{{__('messages.view_past_reservations') ?? 'View completed and past reservations' }}</p>
                    @else
                        <h1 class="h2 mb-2 text-gray-800">{{__('messages.reservations')}}</h1>
                        <p class="text-muted mb-0">{{__('messages.manage_current_reservations') ?? 'Manage upcoming and current reservations' }}</p>
                    @endif
                </div>
                @can('reservations_create')
                <a class="btn btn-primary btn-lg shadow-sm" href="{{ route('reservations.create') }}">
                    <i class="fas fa-plus-circle me-2"></i>
                    {{ __('messages.create_reservation') }}
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats and Filters Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Statistics -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary text-white rounded-3 p-3 me-3">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-primary">{{ $reservations->total() }}</h4>
                            <p class="text-muted mb-0">{{__('messages.total_reservations') ?? 'Total Reservations'}}</p>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="col-md-8">
                    <form id="filterForm" action="{{ route('reservations.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="today" id="today_filter"
                                           {{ request('today') ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label class="form-check-label fw-medium" for="today_filter">
                                        <i class="fas fa-calendar-day me-2 text-warning"></i>
                                        {{ __('messages.today') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="history" id="history_filter"
                                           {{ request('history') ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label class="form-check-label fw-medium" for="history_filter">
                                        <i class="fas fa-history me-2 text-info"></i>
                                        {{ __('messages.history') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                @if(request('today') || request('history'))
                                    <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times me-1"></i>
                                        {{ __('messages.clear_filters') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @php
        use Carbon\Carbon;
        use App\Enums\ReservationStatus;
    @endphp

    <!-- Desktop Table View -->
    <div class="d-none d-lg-block">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 80px;">{{__('messages.number')}}</th>
                                <th>{{__('messages.patient')}}</th>
                                <th style="width: 140px;">{{__('messages.time')}}</th>
                                <th style="width: 120px;">{{__('messages.date')}}</th>
                                <th class="text-end" style="width: 120px;">{{__('messages.price')}}</th>
                                <th style="width: 130px;">{{__('messages.status')}}</th>
                                @can(['reservations_paid', 'reservations_edit', 'reservations_show', 'reservations_delete'])
                                    <th class="text-center" style="width: 160px;">{{__('messages.actions')}}</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $key => $reservation)
                                <tr class="reservation-row {{ $reservation->status === ReservationStatus::WAITING && Carbon::parse($reservation->date)->isToday() ? 'today-reservation' : '' }}">
                                    <td class="ps-4 fw-semibold">
                                        @if($reservation->status === ReservationStatus::WAITING && Carbon::parse($reservation->date)->isToday() && auth()->user()->can('reservations_apply'))
                                            <a href="{{ route('reservations.applyPage', $reservation->id) }}"
                                               class="text-decoration-none text-primary"
                                               data-bs-toggle="tooltip" title="{{__('messages.apply_treatment')}}">
                                                {{ $key + 1 + ($reservations->currentPage() - 1) * $reservations->perPage() }}
                                            </a>
                                        @else
                                            {{ $key + 1 + ($reservations->currentPage() - 1) * $reservations->perPage() }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $reservation->user->id) }}"
                                           class="text-decoration-none text-dark fw-medium">
                                            <div class="d-flex align-items-center">
                                                <div class="patient-avatar bg-primary text-white rounded-circle me-3">
                                                    {{ strtoupper(substr($reservation->user->localized_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    {{ $reservation->user->localized_name }}
                                                    @if($reservation->user->phone)
                                                        <small class="d-block text-muted">{{ $reservation->user->phone }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ Carbon::parse($reservation->from)->format('h:i A') }} - {{ Carbon::parse($reservation->to)->format('h:i A') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ Carbon::parse($reservation->date)->format('M d, Y') }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="badge bg-success bg-opacity-10 text-success fs-6 py-2 px-3">
                                            ${{ number_format($reservation->total_price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                ReservationStatus::WAITING => 'bg-warning',
                                                ReservationStatus::TOPAY => 'bg-info',
                                                ReservationStatus::PAID => 'bg-success',
                                                ReservationStatus::CANCELLED => 'bg-danger',
                                            ][$reservation->status];
                                        @endphp
                                        <span class="badge {{ $statusClass }} text-white">
                                            {{ ReservationStatus::getStringValue($reservation->status) }}
                                        </span>
                                    </td>
                                    @can(['reservations_paid', 'reservations_edit', 'reservations_show', 'reservations_delete'])
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @can('reservations_show')
                                            <a href="{{ route('reservations.show', $reservation->id) }}"
                                               class="btn btn-outline-primary rounded-start"
                                               data-bs-toggle="tooltip" title="{{__('messages.view_details')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan

                                            @if($reservation->status === ReservationStatus::WAITING)
                                                @can('reservations_edit')
                                                <a href="#"
                                                   class="btn btn-outline-warning"
                                                   data-bs-toggle="tooltip" title="{{__('messages.edit_reservation')}}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('reservations_delete')
                                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger rounded-end"
                                                            onclick="return confirm('{{__('messages.confirm_cancel_reservation') ?? 'Are you sure you want to cancel this reservation?'}}')"
                                                            data-bs-toggle="tooltip" title="{{__('messages.cancel_reservation')}}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            @endif

                                            @if($reservation->status === ReservationStatus::TOPAY)
                                                @can('reservations_paid')
                                                <form action="{{ route('reservations.paid', $reservation->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit"
                                                            class="btn btn-outline-success rounded-end"
                                                            onclick="return confirm('{{__('messages.confirm_payment') ?? 'Mark this reservation as paid?'}}')"
                                                            data-bs-toggle="tooltip" title="{{__('messages.mark_paid')}}">
                                                        <i class="fas fa-credit-card"></i>
                                                    </button>
                                                </form>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->can('reservations_paid') || auth()->user()->can('reservations_edit') || auth()->user()->can('reservations_show') || auth()->user()->can('reservations_delete') ? 7 : 6 }}" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                                            <h5 class="text-muted">{{__('messages.no_reservations_found') ?? 'No reservations found'}}</h5>
                                            <p class="text-muted mb-4">
                                                {{ request('today') ? __('messages.no_reservations_today') ?? 'No reservations scheduled for today' :
                                                   (request('history') ? __('messages.no_reservations_history') ?? 'No past reservations found' :
                                                   __('messages.no_reservations_description') ?? 'No reservations match your criteria') }}
                                            </p>
                                            @can('reservations_create')
                                            <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>
                                                {{ __('messages.create_reservation') }}
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Cards View -->
    <div class="d-block d-lg-none">
        <div class="row g-3">
            @forelse($reservations as $key => $reservation)
                <div class="col-12">
                    <div class="card reservation-card shadow-sm border-0 h-100
                        {{ $reservation->status === ReservationStatus::WAITING && Carbon::parse($reservation->date)->isToday() ? 'border-warning border-2' : '' }}">
                        <div class="card-body">
                            <!-- Card Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="reservation-badge bg-primary text-white rounded-3 px-3 py-2">
                                    <small class="fw-bold">#{{ $key + 1 + ($reservations->currentPage() - 1) * $reservations->perPage() }}</small>
                                </div>
                                <span class="badge {{ [
                                    ReservationStatus::WAITING => 'bg-warning',
                                    ReservationStatus::TOPAY => 'bg-info',
                                    ReservationStatus::PAID => 'bg-success',
                                    ReservationStatus::CANCELLED => 'bg-danger',
                                ][$reservation->status] }} text-white">
                                    {{ ReservationStatus::getStringValue($reservation->status) }}
                                </span>
                            </div>

                            <!-- Patient Info -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="patient-avatar-sm bg-primary text-white rounded-circle me-3">
                                    {{ strtoupper(substr($reservation->user->localized_name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $reservation->user->localized_name }}</h6>
                                    @if($reservation->user->phone)
                                        <small class="text-muted">{{ $reservation->user->phone }}</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Reservation Details -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">{{__('messages.date')}}</small>
                                        <strong>{{ Carbon::parse($reservation->date)->format('M d') }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <small class="text-muted d-block">{{__('messages.time')}}</small>
                                        <strong>{{ Carbon::parse($reservation->from)->format('h:i A') }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Price and Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <div class="price-display">
                                    <span class="fw-bold text-success">${{ number_format($reservation->total_price, 2) }}</span>
                                </div>
                                <div class="action-buttons">
                                    @can('reservations_show')
                                    <a href="{{ route('reservations.show', $reservation->id) }}"
                                       class="btn btn-outline-primary btn-sm me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan

                                    @if($reservation->status === ReservationStatus::WAITING && Carbon::parse($reservation->date)->isToday() && auth()->user()->can('reservations_apply'))
                                    <a href="{{ route('reservations.applyPage', $reservation->id) }}"
                                       class="btn btn-warning btn-sm me-1">
                                        <i class="fas fa-play"></i>
                                    </a>
                                    @endif

                                    @if($reservation->status === ReservationStatus::TOPAY)
                                        @can('reservations_paid')
                                        <form action="{{ route('reservations.paid', $reservation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('put')
                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('{{__('messages.confirm_payment') ?? 'Mark this reservation as paid?'}}')">
                                                <i class="fas fa-credit-card"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">{{__('messages.no_reservations_found') ?? 'No reservations found'}}</h5>
                                <p class="text-muted mb-4">
                                    {{ request('today') ? __('messages.no_reservations_today') ?? 'No reservations scheduled for today' :
                                       (request('history') ? __('messages.no_reservations_history') ?? 'No past reservations found' :
                                       __('messages.no_reservations_description') ?? 'No reservations match your criteria') }}
                                </p>
                                @can('reservations_create')
                                <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    {{ __('messages.create_reservation') }}
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination and Count -->
    @if($reservations->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="text-muted small mb-2 mb-md-0">
                            {{__('messages.showing') ?? 'Showing'}}
                            {{ $reservations->firstItem() }} - {{ $reservations->lastItem() }}
                            {{__('messages.of') ?? 'of'}} {{ $reservations->total() }}
                        </div>
                        <nav>
                            {{ $reservations->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
    .card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .reservation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .today-reservation {
        background-color: rgba(255, 193, 7, 0.05) !important;
        border-left: 4px solid #ffc107 !important;
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .patient-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }

    .patient-avatar-sm {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .reservation-badge {
        font-size: 0.875rem;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
    }

    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 6px;
        border-bottom-right-radius: 6px;
    }

    .empty-state {
        padding: 2rem 0;
    }

    .alert {
        border: none;
        border-radius: 10px;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    @media (max-width: 768px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 1rem;
        }

        .reservation-card .btn {
            font-size: 0.875rem;
            padding: 0.4rem 0.6rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.25rem;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Add loading state to action buttons
        const actionForms = document.querySelectorAll('form');
        actionForms.forEach(form => {
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