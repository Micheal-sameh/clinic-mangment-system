@extends('layouts.sideBar')
<title>{{ $reservation->user->localized_name }} - {{ __('messages.reservation_details') }}</title>
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6">

                <!-- Header Section -->
                <div class="text-center mb-5">
                    <div class="reservation-badge bg-primary text-white rounded-pill px-4 py-2 d-inline-block mb-3">
                        <i class="fas fa-calendar-check me-2"></i>
                        {{ __('messages.reservation_details') }}
                    </div>
                    <h1 class="h2 text-gray-800 mb-2">{{ $reservation->user->localized_name }}</h1>
                    <p class="text-muted">{{ __('messages.reservation_id') }}: #{{ $reservation->reservation_number }}</p>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Reservation Card -->
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <!-- Card Header -->
                    <div class="card-header bg-gradient-primary text-white py-4 rounded-top-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="h4 mb-1">Reservation #{{ $reservation->reservation_number }}</h3>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($reservation->updated_at)->diffForHumans() }}
                                </p>
                            </div>
                            <div class="status-badge">
                                @php
                                    $statusClass = [
                                        App\Enums\ReservationStatus::WAITING => 'bg-warning',
                                        App\Enums\ReservationStatus::TOPAY => 'bg-info',
                                        App\Enums\ReservationStatus::PAID => 'bg-success',
                                        App\Enums\ReservationStatus::CANCELLED => 'bg-danger',
                                    ][$reservation->status];
                                @endphp
                                <span class="badge {{ $statusClass }} text-white fs-6 py-2 px-3">
                                    {{ App\Enums\ReservationStatus::getStringValue($reservation->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Patient Information -->
                        <div class="patient-section mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="patient-avatar bg-primary text-white rounded-circle me-3">
                                    {{ strtoupper(substr($reservation->user->localized_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h5 class="mb-1">{{ $reservation->user->localized_name }}</h5>
                                    @if ($reservation->user->phone)
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-phone me-2"></i>
                                            {{ $reservation->user->phone }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Information -->
                        @if ($reservation->doctor)
                            <div class="doctor-section mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="doctor-avatar bg-success text-white rounded-circle me-3">
                                        {{ strtoupper(substr($reservation->doctor->localized_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $reservation->doctor->localized_name }}</h5>
                                        @if ($reservation->doctor->specialization)
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-user-md me-2"></i>
                                                {{ $reservation->doctor->specialization }}
                                            </p>
                                        @endif
                                        @if ($reservation->doctor->phone)
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-phone me-2"></i>
                                                {{ $reservation->doctor->phone }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reservation Details Grid -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="detail-card p-3 bg-light rounded-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-day text-primary me-2"></i>
                                        <h6 class="mb-0">{{ __('messages.date') }}</h6>
                                    </div>
                                    <p class="mb-0 fw-semibold fs-5">
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('l') }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-card p-3 bg-light rounded-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <h6 class="mb-0">{{ __('messages.time_slot') }}</h6>
                                    </div>
                                    <p class="mb-0 fw-semibold fs-5">
                                        {{ \Carbon\Carbon::parse($reservation->from)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($reservation->to)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Price Information -->
                        @if (
                            $reservation->status == App\Enums\ReservationStatus::TOPAY ||
                                $reservation->status == App\Enums\ReservationStatus::PAID)
                            <div class="price-section mb-4">
                                <div class="price-card bg-success bg-opacity-10 rounded-3 p-4 text-center">
                                    <h6 class="text-muted mb-2">{{ __('messages.total_price') }}</h6>
                                    <h2 class="text-success mb-0">${{ number_format($reservation->total_price, 2) }}</h2>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Procedures Section -->
                @if (
                    $reservation->status != App\Enums\ReservationStatus::WAITING &&
                        $reservation->status != App\Enums\ReservationStatus::CANCELLED &&
                        $procedures->count() > 0)
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-procedures text-primary me-2"></i>
                                {{ __('messages.procedures') }}
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($procedures as $procedure)
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="procedure-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                                <i class="fas fa-stethoscope"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $procedure->procedure->localized_name }}</h6>
                                                <small class="text-muted">{{ __('messages.procedure') }}</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span
                                                class="fw-bold text-success fs-5">${{ number_format($procedure->price, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Total Price -->
                                @if (
                                    $reservation->status == App\Enums\ReservationStatus::TOPAY ||
                                        $reservation->status == App\Enums\ReservationStatus::PAID)
                                    <div
                                        class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light">
                                        <h6 class="mb-0 text-dark">{{ __('messages.total') }}</h6>
                                        <h5 class="mb-0 text-success">${{ number_format($reservation->total_price, 2) }}
                                        </h5>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Notes Section -->
                @if ($reservation->reservationNotes && $reservation->reservationNotes->count() > 0)
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0">
                                <i class="fas fa-sticky-note text-warning me-2"></i>
                                {{ __('messages.notes') }}
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach ($reservation->reservationNotes as $key => $note)
                                    <div class="list-group-item py-3">
                                        <div class="d-flex align-items-start mb-2">
                                            <span class="note-badge bg-warning text-dark rounded-pill px-3 py-1 me-3">
                                                {{ __('messages.note') }} #{{ $key + 1 }}
                                            </span>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($note->created_at)->format('M j, Y \a\t h:i A') }}
                                            </small>
                                        </div>
                                        <p class="mb-0 text-dark">{{ $note->note }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center mt-5 flex-wrap">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                        <i class="fas fa-arrow-left me-2"></i>
                        {{ __('messages.back') }}
                    </a>

                    @if ($reservation->status == App\Enums\ReservationStatus::WAITING)
                        @if( \Carbon\Carbon::parse($reservation->date)->isToday() && auth()->user()->can('reservations_apply'))
                            <a href="{{ route('reservations.applyPage', $reservation->id) }}"
                               class="btn btn-primary px-4 py-2 rounded-3">
                                <i class="fas fa-play me-2"></i>
                                {{ __('messages.apply_treatment') }}
                            </a>
                        @endif

                        @can('reservations_delete')
                            <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-danger px-4 py-2 rounded-3"
                                    onclick="return confirm('{{ __('messages.confirm_cancel_reservation') }}')">
                                    <i class="fas fa-times me-2"></i>
                                    {{ __('messages.cancel') }}
                                </button>
                            </form>
                        @endcan
                    @endif

                    @if ($reservation->status == App\Enums\ReservationStatus::TOPAY)
                        @can('reservations_paid')
                            <form action="{{ route('reservations.paid', $reservation->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-success px-4 py-2 rounded-3"
                                    onclick="return confirm('{{ __('messages.confirm_payment') }}')">
                                    <i class="fas fa-credit-card me-2"></i>
                                    {{ __('messages.mark_paid') }}
                                </button>
                            </form>
                        @endcan
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            border: none;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .reservation-badge {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .patient-avatar {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .doctor-avatar {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .detail-card {
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .price-card {
            border: 2px dashed #198754;
        }

        .procedure-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .note-badge {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge .badge {
            font-size: 0.9rem;
        }

        .list-group-item {
            border-color: rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .rounded-4 {
            border-radius: 16px !important;
        }

        .rounded-top-4 {
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }

        .btn {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .d-flex.justify-content-center {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }

            .patient-avatar {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide success message after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(successAlert);
                    bsAlert.close();
                }, 5000);
            }

            // Add loading state to action buttons
            const actionForms = document.querySelectorAll('form');
            actionForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    if (button) {
                        button.disabled = true;
                        button.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
                    }
                });
            });
        });
    </script>
@endsection
