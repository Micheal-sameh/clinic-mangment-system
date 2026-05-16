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
                    {{ __('messages.doctor_details') ?? 'Doctor Details' }}
                </h1>
                <p class="text-muted fs-5">
                    {{ __('messages.view_doctor_information') ?? 'View detailed information about the doctor' }}
                </p>
            </div>

            <!-- Doctor Profile Card -->
            <div class="card glass-effect border-0 rounded-4 shadow-xxl mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-4 mb-md-0">
                            <div class="doctor-avatar-large bg-primary text-white rounded-circle mx-auto mb-3">
                                {{ strtoupper(substr($doctor->localized_name, 0, 1)) }}
                            </div>
                            <h4 class="fw-bold text-primary">{{ $doctor->localized_name }}</h4>
                            <span class="badge bg-info bg-opacity-10 text-info fs-6">{{ $doctor->specialization }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="contact-item">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        <span class="fw-semibold">{{ __('messages.phone') ?? 'Phone' }}:</span>
                                        <span>{{ $doctor->phone }}</span>
                                    </div>
                                </div>
                                @if ($doctor->whatsapp)
                                    <div class="col-md-6">
                                        <div class="contact-item">
                                            <i class="fab fa-whatsapp text-success me-2"></i>
                                            <span class="fw-semibold">{{ __('messages.whatsapp') ?? 'WhatsApp' }}:</span>
                                            <span>{{ $doctor->whatsapp }}</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="contact-item">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        <span class="fw-semibold">{{ __('messages.created_at') ?? 'Created At' }}:</span>
                                        <span>{{ $doctor->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                    <i class="fas fa-arrow-left me-2"></i>
                    {{ __('messages.back') ?? 'Back to Doctors' }}
                </a>
                <div class="d-flex gap-2">
                    @can('workDays_list')
                        <a href="{{ route('working-days.doctor', $doctor->id) }}" class="btn btn-info rounded-pill px-4 py-2">
                            <i class="fas fa-clock me-2"></i>
                            {{ __('messages.working_days') ?? 'Working Days' }}
                        </a>
                    @endcan
                    @can('users_edit')
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-primary rounded-pill px-4 py-2">
                            <i class="fas fa-edit me-2"></i>
                            {{ __('messages.edit_doctor') ?? 'Edit Doctor' }}
                        </a>
                    @endcan
                    @can('users_delete')
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger rounded-pill px-4 py-2" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                <i class="fas fa-trash me-2"></i>
                                {{ __('messages.delete_doctor') ?? 'Delete Doctor' }}
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

            <!-- Reservations Section -->
            <div class="card glass-effect border-0 rounded-4 shadow-xxl">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-calendar-check me-2"></i>
                        {{ __('messages.reservations') ?? 'Reservations' }}
                        <span class="badge bg-primary ms-2">{{ $doctor->reservations->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if ($doctor->reservations->isEmpty())
                        <div class="text-center py-5">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-calendar-times fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">{{ __('messages.no_reservations') ?? 'No Reservations Found' }}</h5>
                            <p class="text-muted">{{ __('messages.no_reservations_for_doctor') ?? 'This doctor has no reservations yet.' }}</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('messages.date') ?? 'Date' }}</th>
                                        <th>{{ __('messages.time') ?? 'Time' }}</th>
                                        <th>{{ __('messages.patient') ?? 'Patient' }}</th>
                                        <th>{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctor->reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->date }}</td>
                                            <td>{{ $reservation->from }} - {{ $reservation->to }}</td>
                                            <td>
                                                @if ($reservation->user)
                                                    {{ $reservation->user->localized_name }}
                                                @else
                                                    <span class="text-muted">{{ __('messages.unknown_patient') ?? 'Unknown Patient' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $reservation->status == App\Enums\ReservationStatus::PAID ? 'success' : ($reservation->status == App\Enums\ReservationStatus::WAITING ? 'warning' : 'secondary') }}">
                                                    {{ App\Enums\ReservationStatus::getStringValue($reservation->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @can('reservations_show')
                                                    <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .floating-element {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(8, 145, 178, 0.06)) !important;
        }
        .btn-glow:hover {
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.4) !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
