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
            0%, 100% {
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

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Doctor Avatar */
        .doctor-avatar-large {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 3rem;
        }

        /* Contact Items */
        .contact-item {
            background: rgba(255, 255, 255, 0.8);
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .contact-item i {
            font-size: 1.2rem;
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

        /* Empty State */
        .empty-state-icon {
            opacity: 0.5;
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

            .doctor-avatar-large {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }
        }

        .rounded-4 {
            border-radius: 20px !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
