@extends('layouts.sideBar')

@section('content')
<div class="container-fluid py-2">

    {{-- Page Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-light btn-sm border">
            <i class="fas fa-arrow-left me-1"></i>{{ __('messages.back') ?? 'Back' }}
        </a>
        <h1 class="h4 mb-0 fw-bold">{{ __('messages.patient_profile') ?? 'Patient Profile' }}</h1>
        <div class="ms-auto d-flex gap-2">
            @can('users_edit')
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit me-1"></i>{{ __('messages.edit') ?? 'Edit' }}
                </a>
            @endcan
            <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>{{ __('messages.new_reservation') ?? 'New Reservation' }}
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT COLUMN: Patient identity card --}}
        <div class="col-lg-3">
            <div class="card text-center mb-3">
                <div class="card-body py-4">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary fw-bold mx-auto mb-3"
                         style="width:72px;height:72px;font-size:1.8rem;">
                        {{ strtoupper(substr($user->localized_name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->localized_name }}</h5>
                    <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                        <span class="badge bg-{{ $user->status == App\Enums\UserStatus::ACTIVE ? 'success' : 'secondary' }}">
                            {{ App\Enums\UserStatus::getStringValue($user->status) }}
                        </span>
                        @if($user->roles->first())
                            <span class="badge bg-info">{{ $user->roles->first()->name }}</span>
                        @endif
                    </div>
                    <div class="text-start small">
                        @if($user->email)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-envelope text-muted" style="width:16px;"></i>
                            <span class="text-truncate">{{ $user->email }}</span>
                        </div>
                        @endif
                        @if($user->phone)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-phone text-muted" style="width:16px;"></i>
                            <span>{{ $user->phone }}</span>
                        </div>
                        @endif
                        @if($user->age)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-birthday-cake text-muted" style="width:16px;"></i>
                            <span>{{ $user->age }} {{ __('messages.years') ?? 'yrs' }}</span>
                        </div>
                        @endif
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar-alt text-muted" style="width:16px;"></i>
                            <span class="text-muted">{{ __('messages.since') ?? 'Since' }} {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Medical Info Card --}}
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 text-muted text-uppercase" style="font-size:.72rem;letter-spacing:.08em;">
                        <i class="fas fa-heartbeat me-1"></i>{{ __('messages.medical_info') ?? 'Medical Info' }}
                    </h6>
                    <div class="d-flex flex-column gap-2 small">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">{{ __('messages.blood_type') ?? 'Blood Type' }}</span>
                            <span class="fw-semibold badge bg-danger bg-opacity-10 text-danger">{{ $user->blood_type ?? '—' }}</span>
                        </div>
                        <div>
                            <div class="text-muted mb-1">{{ __('messages.allergies') ?? 'Allergies' }}</div>
                            <div class="fw-medium">{{ $user->allergies ?: '—' }}</div>
                        </div>
                        <div>
                            <div class="text-muted mb-1">{{ __('messages.chronic_conditions') ?? 'Chronic Conditions' }}</div>
                            <div class="fw-medium">{{ $user->chronic_conditions ?: '—' }}</div>
                        </div>
                        @if($user->emergency_contact_name)
                        <div class="border-top pt-2 mt-1">
                            <div class="text-muted mb-1"><i class="fas fa-user-shield me-1"></i>{{ __('messages.emergency_contact') ?? 'Emergency Contact' }}</div>
                            <div class="fw-medium">{{ $user->emergency_contact_name }}</div>
                            @if($user->emergency_contact_phone)
                                <div class="text-muted">{{ $user->emergency_contact_phone }}</div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Stats + Tabs --}}
        <div class="col-lg-9">

            {{-- Stats Row --}}
            <div class="row g-3 mb-4">
                @php
                    $stats = [
                        ['label' => __('messages.total_reservations') ?? 'Total', 'value' => $totalReservations, 'color' => 'primary', 'icon' => 'calendar-check'],
                        ['label' => __('messages.completed') ?? 'Completed', 'value' => $completedReservations, 'color' => 'success', 'icon' => 'check-circle'],
                        ['label' => __('messages.upcoming') ?? 'Upcoming', 'value' => $upcomingReservations, 'color' => 'info', 'icon' => 'clock'],
                        ['label' => __('messages.cancelled') ?? 'Cancelled', 'value' => $cancelledReservations, 'color' => 'warning', 'icon' => 'times-circle'],
                        ['label' => __('messages.diagnoses') ?? 'Diagnoses', 'value' => $diagnoses->count(), 'color' => 'danger', 'icon' => 'diagnoses'],
                        ['label' => __('messages.prescriptions') ?? 'Prescriptions', 'value' => $prescriptions->count(), 'color' => 'secondary', 'icon' => 'prescription-bottle-alt'],
                    ];
                @endphp
                @foreach($stats as $s)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card text-center p-3">
                        <div class="fw-bold fs-4 text-{{ $s['color'] }}">{{ $s['value'] }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ $s['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Tabs --}}
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs border-0 px-3 pt-2" id="patientTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-visits" type="button">
                                <i class="fas fa-calendar-alt me-1"></i>{{ __('messages.reservations') ?? 'Visits' }}
                                <span class="badge bg-primary ms-1">{{ $reservations ? $reservations->total() : 0 }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-diagnoses" type="button">
                                <i class="fas fa-diagnoses me-1"></i>{{ __('messages.diagnoses') ?? 'Diagnoses' }}
                                <span class="badge bg-danger ms-1">{{ $diagnoses->count() }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-prescriptions" type="button">
                                <i class="fas fa-pills me-1"></i>{{ __('messages.prescriptions') ?? 'Prescriptions' }}
                                <span class="badge bg-info ms-1">{{ $prescriptions->count() }}</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">

                        {{-- Visits Tab --}}
                        <div class="tab-pane fade show active p-3" id="tab-visits">
                            @if($reservations && $reservations->count())
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('messages.date') ?? 'Date' }}</th>
                                            <th>{{ __('messages.time') ?? 'Time' }}</th>
                                            <th>{{ __('messages.doctor') ?? 'Doctor' }}</th>
                                            <th>{{ __('messages.status') ?? 'Status' }}</th>
                                            <th>{{ __('messages.total') ?? 'Total' }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reservations as $res)
                                        <tr>
                                            <td class="text-muted" style="font-size:.82rem;">{{ $res->reservation_number }}</td>
                                            <td>{{ \Carbon\Carbon::parse($res->date)->format('d M Y') }}</td>
                                            <td>{{ $res->from ?? '—' }}</td>
                                            <td>{{ $res->doctor->user->localized_name ?? '—' }}</td>
                                            <td>
                                                <span class="badge
                                                    @if($res->status == \App\Enums\ReservationStatus::PAID || $res->status == \App\Enums\ReservationStatus::DONE) bg-success
                                                    @elseif($res->status == \App\Enums\ReservationStatus::CANCELLED) bg-danger
                                                    @elseif($res->status == \App\Enums\ReservationStatus::WAITING) bg-warning text-dark
                                                    @else bg-secondary @endif">
                                                    {{ \App\Enums\ReservationStatus::getStringValue($res->status) ?? $res->status }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold">{{ $res->total_price ?? '—' }}</td>
                                            <td>
                                                <a href="{{ route('reservations.show', $res->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($reservations->hasPages())
                                <div class="px-3 pb-3">{{ $reservations->links() }}</div>
                            @endif
                            @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-times mb-3" style="font-size:2rem;opacity:.4;display:block;"></i>
                                {{ __('messages.no_reservations') ?? 'No reservations yet.' }}
                            </div>
                            @endif
                        </div>

                        {{-- Diagnoses Tab --}}
                        <div class="tab-pane fade p-3" id="tab-diagnoses">
                            @if($diagnoses->count())
                            <div class="d-flex flex-column gap-3">
                                @foreach($diagnoses as $dx)
                                <div class="p-3 rounded-3 border" style="background:#fafafa;">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold mb-1">{{ $dx->diagnosis }}</div>
                                            <div class="d-flex flex-wrap gap-2 mb-1">
                                                @if($dx->icd_code)
                                                    <span class="badge bg-light text-dark border">ICD: {{ $dx->icd_code }}</span>
                                                @endif
                                                @if($dx->reservation)
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($dx->reservation->date)->format('d M Y') }}
                                                    </span>
                                                @endif
                                                @if($dx->doctor)
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="fas fa-user-md me-1"></i>{{ $dx->doctor->user->localized_name ?? '' }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($dx->notes)
                                                <p class="text-muted mb-0" style="font-size:.85rem;">{{ $dx->notes }}</p>
                                            @endif
                                            <div class="text-muted mt-1" style="font-size:.75rem;">
                                                {{ $dx->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                        @if($dx->reservation)
                                        <a href="{{ route('reservations.show', $dx->reservation_id) }}" class="btn btn-sm btn-outline-primary flex-shrink-0">
                                            <i class="fas fa-link"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-file-medical mb-3" style="font-size:2rem;opacity:.4;display:block;"></i>
                                {{ __('messages.no_diagnoses') ?? 'No diagnoses recorded yet.' }}
                            </div>
                            @endif
                        </div>

                        {{-- Prescriptions Tab --}}
                        <div class="tab-pane fade p-3" id="tab-prescriptions">
                            @if($prescriptions->count())
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.medicine') ?? 'Medicine' }}</th>
                                            <th>{{ __('messages.dosage') ?? 'Dosage' }}</th>
                                            <th>{{ __('messages.frequency') ?? 'Frequency' }}</th>
                                            <th>{{ __('messages.duration') ?? 'Duration' }}</th>
                                            <th>{{ __('messages.visit_date') ?? 'Visit' }}</th>
                                            <th>{{ __('messages.doctor') ?? 'Doctor' }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($prescriptions as $rx)
                                        <tr>
                                            <td class="fw-semibold">{{ $rx->medicine_name }}</td>
                                            <td>{{ $rx->dosage ?? '—' }}</td>
                                            <td>{{ $rx->frequency ?? '—' }}</td>
                                            <td>{{ $rx->duration ?? '—' }}</td>
                                            <td>{{ $rx->reservation ? \Carbon\Carbon::parse($rx->reservation->date)->format('d M Y') : '—' }}</td>
                                            <td>{{ $rx->doctor->user->localized_name ?? '—' }}</td>
                                            <td>
                                                @if($rx->reservation)
                                                <a href="{{ route('reservations.show', $rx->reservation_id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($rx->notes)
                                        <tr class="table-light">
                                            <td colspan="7" class="text-muted" style="font-size:.82rem;padding-top:.2rem;">
                                                <i class="fas fa-comment-dots me-1"></i>{{ $rx->notes }}
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-prescription-bottle-alt mb-3" style="font-size:2rem;opacity:.4;display:block;"></i>
                                {{ __('messages.no_prescriptions') ?? 'No prescriptions yet.' }}
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
