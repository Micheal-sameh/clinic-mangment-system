@extends('layouts.sideBar')

@section('title', $reservation->user->localized_name . ' — ' . __('messages.reservation_details'))

@section('content')
<div class="container-fluid py-2">

    {{-- Page Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('reservations.index') }}" class="btn btn-light btn-sm border">
            <i class="fas fa-arrow-left me-1"></i>{{ __('messages.back') ?? 'Back' }}
        </a>
        <div>
            <h1 class="h4 mb-0 fw-bold">{{ __('messages.reservation_details') }}</h1>
            <small class="text-muted">{{ __('messages.slate') ?? 'Slot' }} #{{ $reservation->reservation_number }}</small>
        </div>
        <div class="ms-auto">
            <span class="badge rounded-pill px-3 py-2
                @if($reservation->status == \App\Enums\ReservationStatus::DONE) bg-success
                @elseif($reservation->status == \App\Enums\ReservationStatus::CANCELLED) bg-danger
                @else bg-warning text-dark @endif">
                {{ \App\Enums\ReservationStatus::getStringValue($reservation->status) ?? $reservation->status }}
            </span>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- LEFT: Patient & Reservation Info --}}
        <div class="col-lg-4">

            {{-- Patient Card --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary fw-bold flex-shrink-0"
                             style="width:56px;height:56px;font-size:1.4rem;">
                            {{ strtoupper(substr($reservation->user->localized_name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $reservation->user->localized_name }}</h5>
                            <small class="text-muted">{{ $reservation->user->email }}</small>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="p-2 rounded-3" style="background:#f8fafc;">
                                <div class="text-muted" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">{{ __('messages.date') ?? 'Date' }}</div>
                                <div class="fw-semibold" style="font-size:.9rem;">{{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 rounded-3" style="background:#f8fafc;">
                                <div class="text-muted" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;">{{ __('messages.time') ?? 'Time' }}</div>
                                <div class="fw-semibold" style="font-size:.9rem;">{{ $reservation->from ?? '—' }}</div>
                            </div>
                        </div>
                        @if($reservation->doctor)
                        <div class="col-12">
                            <div class="p-2 rounded-3 d-flex align-items-center gap-2" style="background:#f8fafc;">
                                <i class="fas fa-user-md text-primary" style="opacity:.7;"></i>
                                <div>
                                    <div class="text-muted" style="font-size:.72rem;">{{ __('messages.doctor') ?? 'Doctor' }}</div>
                                    <div class="fw-semibold" style="font-size:.9rem;">{{ $reservation->doctor->user->localized_name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Price Summary Card --}}
            <div class="card border-0 text-white" style="background: linear-gradient(135deg, var(--primary) 0%, #0891b2 100%);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-size:.72rem;opacity:.8;text-transform:uppercase;letter-spacing:.06em;">{{ __('messages.total_price') ?? 'Total' }}</div>
                            <div class="fw-bold" style="font-size:1.6rem;">{{ $reservation->total_price ?? '0.00' }}</div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2" style="background:rgba(255,255,255,0.20);font-size:.8rem;">
                            {{ $reservation->paid ? (__('messages.paid') ?? 'Paid') : (__('messages.unpaid') ?? 'Unpaid') }}
                        </span>
                    </div>
                    <div class="mt-2" style="font-size:.8rem;opacity:.75;">
                        {{ __('messages.updated_at') ?? 'Updated' }}: {{ \Carbon\Carbon::parse($reservation->updated_at)->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Procedures + Notes --}}
        <div class="col-lg-8">

            {{-- Procedures Card --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-primary bg-opacity-10">
                            <i class="fas fa-stethoscope text-primary"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.procedures') ?? 'Procedures' }}</h5>
                    </div>

                    <form action="{{ route('reservations_pro.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                        @if($procedures->isEmpty())
                            <p class="text-muted text-center py-3">{{ __('messages.no_procedures') ?? 'No procedures available.' }}</p>
                        @else
                        <div class="row g-2 mb-3">
                            @foreach($procedures as $procedure)
                                @php $checked = in_array($procedure->id, $reservation->reservationProcedures->pluck('procedure_id')->toArray()); @endphp
                                <div class="col-sm-6 col-md-4">
                                    <label class="d-flex align-items-center gap-2 p-3 rounded-3 border procedure-item {{ $checked ? 'checked' : '' }}"
                                           style="cursor:pointer;">
                                        <input class="form-check-input mt-0 procedure-check flex-shrink-0"
                                               type="checkbox" value="{{ $procedure->id }}"
                                               name="procedures[]" {{ $checked ? 'checked' : '' }}>
                                        <div class="overflow-hidden">
                                            <div class="fw-semibold text-truncate" style="font-size:.875rem;">{{ $procedure->localized_name }}</div>
                                            <div class="text-muted" style="font-size:.78rem;">{{ $procedure->price }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>{{ __('messages.save') ?? 'Save' }} {{ __('messages.procedures') ?? 'Procedures' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Existing Notes --}}
            @if($reservation->reservationNotes && $reservation->reservationNotes->count())
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-warning bg-opacity-10">
                            <i class="fas fa-notes-medical text-warning"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.notes') ?? 'Visit Notes' }}</h5>
                        <span class="badge bg-secondary ms-auto">{{ $reservation->reservationNotes->count() }}</span>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @foreach($reservation->reservationNotes as $note)
                        <div class="p-3 rounded-3 border" style="background:#fafafa;">
                            <p class="mb-1" style="font-size:.9rem;line-height:1.6;">{{ $note->note }}</p>
                            <div class="text-muted" style="font-size:.75rem;">
                                {{ \Carbon\Carbon::parse($note->created_at)->format('d M Y, H:i') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Add Notes Card --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-success bg-opacity-10">
                            <i class="fas fa-plus-circle text-success"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.add_notes') ?? 'Add Notes' }}</h5>
                    </div>

                    <form action="{{ route('reservationNotes.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                        <div id="notes-section" class="d-flex flex-column gap-3">
                            <div class="note-row">
                                <textarea name="notes[]" class="form-control" rows="3"
                                    placeholder="{{ __('messages.enter_note') ?? 'Write a note...' }}"></textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-light border" id="add-note-button">
                                <i class="fas fa-plus me-1"></i>{{ __('messages.add_another_note') ?? 'Add Note' }}
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>{{ __('messages.save_notes') ?? 'Save Notes' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Diagnoses Section --}}
            @if($reservation->diagnoses && $reservation->diagnoses->count())
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-danger bg-opacity-10">
                            <i class="fas fa-diagnoses text-danger"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.diagnoses') ?? 'Diagnoses' }}</h5>
                        <span class="badge bg-secondary ms-auto">{{ $reservation->diagnoses->count() }}</span>
                    </div>
                    @foreach($reservation->diagnoses as $dx)
                    <div class="p-3 rounded-3 border mb-2" style="background:#fafafa;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1 fw-semibold">{{ $dx->diagnosis }}</p>
                                @if($dx->icd_code)
                                    <span class="badge bg-light text-dark border me-1">ICD: {{ $dx->icd_code }}</span>
                                @endif
                                @if($dx->notes)
                                    <p class="text-muted mt-1 mb-0" style="font-size:.85rem;">{{ $dx->notes }}</p>
                                @endif
                                <div class="text-muted mt-1" style="font-size:.75rem;">{{ $dx->created_at->format('d M Y, H:i') }}</div>
                            </div>
                            <form action="{{ route('diagnoses.destroy', $dx->id) }}" method="POST" class="ms-2">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-light border text-danger" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Add Diagnosis --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-danger bg-opacity-10">
                            <i class="fas fa-file-medical text-danger"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.add_diagnosis') ?? 'Add Diagnosis' }}</h5>
                    </div>
                    <form action="{{ route('diagnoses.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">{{ __('messages.diagnosis') ?? 'Diagnosis' }} <span class="text-danger">*</span></label>
                                <textarea name="diagnosis" class="form-control" rows="3" required
                                    placeholder="{{ __('messages.diagnosis_placeholder') ?? 'Describe the diagnosis...' }}"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.icd_code') ?? 'ICD Code' }}</label>
                                <input type="text" name="icd_code" class="form-control" placeholder="e.g. J06.9" maxlength="20">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('messages.notes') ?? 'Notes' }}</label>
                                <textarea name="notes" class="form-control" rows="2"
                                    placeholder="{{ __('messages.optional_notes') ?? 'Optional additional notes...' }}"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">
                            <i class="fas fa-save me-2"></i>{{ __('messages.save_diagnosis') ?? 'Save Diagnosis' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- Prescriptions Section --}}
            @if($reservation->prescriptions && $reservation->prescriptions->count())
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-info bg-opacity-10">
                            <i class="fas fa-prescription-bottle-alt text-info"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.prescriptions') ?? 'Prescriptions' }}</h5>
                        <span class="badge bg-secondary ms-auto">{{ $reservation->prescriptions->count() }}</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.medicine') ?? 'Medicine' }}</th>
                                    <th>{{ __('messages.dosage') ?? 'Dosage' }}</th>
                                    <th>{{ __('messages.frequency') ?? 'Frequency' }}</th>
                                    <th>{{ __('messages.duration') ?? 'Duration' }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservation->prescriptions as $rx)
                                <tr>
                                    <td class="fw-semibold">{{ $rx->medicine_name }}</td>
                                    <td>{{ $rx->dosage ?? '—' }}</td>
                                    <td>{{ $rx->frequency ?? '—' }}</td>
                                    <td>{{ $rx->duration ?? '—' }}</td>
                                    <td>
                                        <form action="{{ route('prescriptions.destroy', $rx->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-light border text-danger"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @if($rx->notes)
                                <tr class="table-light">
                                    <td colspan="5" class="text-muted" style="font-size:.82rem;padding-top:.25rem;">
                                        <i class="fas fa-comment-dots me-1"></i>{{ $rx->notes }}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Add Prescription --}}
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="section-icon bg-info bg-opacity-10">
                            <i class="fas fa-pills text-info"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">{{ __('messages.add_prescription') ?? 'Add Prescription' }}</h5>
                    </div>
                    <form action="{{ route('prescriptions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.medicine_name') ?? 'Medicine Name' }} <span class="text-danger">*</span></label>
                                <input type="text" name="medicine_name" class="form-control" required
                                    placeholder="{{ __('messages.medicine_placeholder') ?? 'e.g. Amoxicillin 500mg' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ __('messages.dosage') ?? 'Dosage' }}</label>
                                <input type="text" name="dosage" class="form-control" placeholder="e.g. 500mg">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.frequency') ?? 'Frequency' }}</label>
                                <input type="text" name="frequency" class="form-control" placeholder="e.g. 3x daily">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.duration') ?? 'Duration' }}</label>
                                <input type="text" name="duration" class="form-control" placeholder="e.g. 7 days">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.notes') ?? 'Notes' }}</label>
                                <input type="text" name="notes" class="form-control" placeholder="{{ __('messages.optional_notes') ?? 'Optional...' }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info text-white mt-3">
                            <i class="fas fa-save me-2"></i>{{ __('messages.save_prescription') ?? 'Save Prescription' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .procedure-item {
        transition: border-color 0.15s, background 0.15s;
        user-select: none;
    }
    .procedure-item.checked,
    .procedure-item:has(.procedure-check:checked) {
        border-color: var(--primary) !important;
        background: rgba(13,148,136,0.05) !important;
    }
</style>
<script>
    document.getElementById('add-note-button').addEventListener('click', function () {
        const section = document.getElementById('notes-section');
        const div = document.createElement('div');
        div.className = 'note-row d-flex gap-2';
        div.innerHTML = `
            <textarea name="notes[]" class="form-control" rows="3"
                placeholder="{{ __('messages.enter_note') ?? 'Write a note...' }}"></textarea>
            <button type="button" class="btn btn-light border align-self-start remove-note-btn" style="flex-shrink:0;">
                <i class="fas fa-times text-danger"></i>
            </button>
        `;
        div.querySelector('.remove-note-btn').addEventListener('click', () => div.remove());
        section.appendChild(div);
    });
    // Highlight procedure labels on check
    document.querySelectorAll('.procedure-check').forEach(function(cb) {
        cb.addEventListener('change', function () {
            this.closest('.procedure-item').classList.toggle('checked', this.checked);
        });
    });
</script>
@endsection
