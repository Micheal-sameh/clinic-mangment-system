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
            <div class="card">
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
