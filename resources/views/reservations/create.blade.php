@extends('layouts.sideBar')
<title>{{ __('messages.create') }} {{ __('messages.reservation') }}</title>

@section('content')
<div class="min-vh-100 bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-5">
    <div class="container">
        <!-- Animated Background Elements -->
        <div class="floating-elements">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
            <div class="floating-element element-4"></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6">



                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success glass-effect border-0 alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <div class="success-icon rounded-circle p-2 me-3">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ __('messages.booking_confirmed') ?? 'Booking Confirmed!' }}</h6>
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Form Card -->
                <div class="card glass-effect border-0 rounded-4 shadow-xxl overflow-hidden">
                    <!-- Premium Card Header -->
                    <div class="card-header premium-header position-relative overflow-hidden">
                        <div class="header-shapes">
                            <div class="shape shape-1"></div>
                            <div class="shape shape-2"></div>
                            <div class="shape shape-3"></div>
                        </div>
                        <div class="position-relative z-3 text-center text-white py-4">
                            <div class="header-icon bg-white text-primary rounded-3 p-3 d-inline-flex mb-3">
                                <i class="fas fa-calendar-check fa-2x"></i>
                            </div>
                            <h2 class="h3 fw-bold mb-2">{{ __('messages.schedule_appointment') ?? 'Schedule Appointment' }}</h2>
                            {{-- <p class="mb-0 opacity-90">{{ __('messages.premium_experience') ?? 'Book your appointment with our premium healthcare services' }}</p> --}}
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm">
                            @csrf

                            <!-- Patient Selection -->
                            @can('reservations_add')
                                <div class="form-section glass-inner rounded-4 mb-5">
                                    <div class="section-header d-flex align-items-center mb-4">
                                        <div class="section-icon bg-primary text-white rounded-3 p-3 me-3">
                                            <i class="fas fa-user-injured fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1">{{ __('messages.patient_information') ?? 'Patient Information' }}</h5>
                                            <p class="text-muted mb-0 small">{{ __('messages.select_patient_profile') ?? 'Choose from existing patient profiles' }}</p>
                                        </div>
                                    </div>

                                    <div class="form-floating premium-input">
                                        <select name="user_id" id="user_id" class="form-select border-0 shadow-sm pt-4">
                                            <option value="">{{ __('messages.select_patient_placeholder') ?? 'Choose a patient...' }}</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                    👤 {{ $user->localized_name }}
                                                    @if($user->phone)
                                                        • 📞 {{ $user->phone }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="user_id" class="fw-medium text-muted">
                                            <i class="fas fa-user me-2"></i>
                                            {{ __('messages.select_patient') ?? 'Select Patient' }}
                                        </label>
                                        @error('user_id')
                                            <div class="error-message mt-2">
                                                <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <div class="alert alert-info glass-effect border-0 mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-circle fa-2x me-3 text-info"></i>
                                        <div>
                                            <h6 class="mb-1">{{ __('messages.self_booking') ?? 'Personal Booking' }}</h6>
                                            <p class="mb-0">{{ __('messages.self_booking_notice') ?? 'You are booking an appointment for yourself' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endcan

                            <!-- Doctor Selection -->
                            <div class="form-section glass-inner rounded-4 mb-5">
                                <div class="section-header d-flex align-items-center mb-4">
                                    <div class="section-icon bg-success text-white rounded-3 p-3 me-3">
                                        <i class="fas fa-user-md fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ __('messages.doctor_selection') ?? 'Doctor Selection' }}</h5>
                                        <p class="text-muted mb-0 small">{{ __('messages.select_doctor') ?? 'Choose your preferred doctor' }}</p>
                                    </div>
                                </div>

                                <div class="form-floating premium-input">
                                    <select name="doctor_id" id="doctor_id" class="form-select border-0 shadow-sm pt-4" required>
                                        <option value="">{{ __('messages.select_doctor_placeholder') ?? 'Choose a doctor...' }}</option>
                                        @foreach ($doctors ?? [] as $doctor)
                                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                👨‍⚕️ {{ $doctor->localized_name }}
                                                @if($doctor->specialization)
                                                    • 🏥 {{ $doctor->specialization }}
                                                @endif
                                                @if($doctor->phone)
                                                    • 📞 {{ $doctor->phone }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="doctor_id" class="fw-medium text-muted">
                                        <i class="fas fa-user-md me-2"></i>
                                        {{ __('messages.select_doctor') ?? 'Select Doctor' }}
                                    </label>
                                    @error('doctor_id')
                                        <div class="error-message mt-2">
                                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Appointment Details -->
                            <div class="form-section glass-inner rounded-4 mb-5">
                                <div class="section-header d-flex align-items-center mb-4">
                                    <div class="section-icon bg-success text-white rounded-3 p-3 me-3">
                                        <i class="fas fa-calendar-alt fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ __('messages.appointment_details') ?? 'Appointment Details' }}</h5>
                                        <p class="text-muted mb-0 small">{{ __('messages.choose_date_time') ?? 'Select your preferred date and time' }}</p>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <!-- Reservation Date -->
                                    <div class="col-md-6">
                                        <div class="form-floating premium-input">
                                            <input type="date" name="reservation_date" id="reservation_date"
                                                   class="form-control border-0 shadow-sm"
                                                   value="{{ old('reservation_date') }}"
                                                   min="{{ date('Y-m-d') }}">
                                            <label for="reservation_date" class="fw-medium text-muted">
                                                <i class="fas fa-calendar me-2"></i>
                                                {{ __('messages.appointment_date') ?? 'Appointment Date' }}
                                            </label>
                                            @error('reservation_date')
                                                <div class="error-message mt-2">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Time Slot -->
                                    <div class="col-md-6">
                                        <div class="form-floating premium-input pt-2">
                                            <select name="slate_number" id="slate_number" class="form-select border-0 shadow-sm">
                                                <option value="">{{ __('messages.select_time_slot') ?? 'Select Time Slot' }}</option>
                                            </select>
                                            <label for="slate_number" class="fw-medium text-muted pb-3">
                                                <i class="fas fa-clock me-2"></i>
                                                {{ __('messages.time_slot') ?? 'Time Slot' }}
                                            </label>
                                            @error('slate_number')
                                                <div class="error-message mt-2">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Availability Status -->
                                <div id="slate-status" class="availability-status mt-4" style="display:none;"></div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-center pt-4">
                                <div class="d-flex gap-3 justify-content-center flex-wrap">
                                    <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill btn-glow btn-submit">
                                        <i class="fas fa-calendar-check me-2"></i>
                                        {{ __('messages.create') }}
                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                    </button>
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 py-3 rounded-pill btn-hover">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        {{ __('messages.back') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="text-center mt-4">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="stat-item">
                                <i class="fas fa-users text-primary me-2"></i>
                                <small class="text-muted">{{ __('messages.trusted_by') ?? 'Trusted by' }} 10,000+ {{ __('messages.patients') ?? 'patients' }}</small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small class="text-muted">99% {{ __('messages.satisfaction_rate') ?? 'satisfaction rate' }}</small>
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
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f7fa 50%, #faf5ff 100%);
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
        animation: float 6s ease-in-out infinite;
    }

    .element-1 { width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s; }
    .element-2 { width: 150px; height: 150px; top: 60%; right: 10%; animation-delay: 2s; }
    .element-3 { width: 80px; height: 80px; bottom: 20%; left: 20%; animation-delay: 4s; }
    .element-4 { width: 120px; height: 120px; top: 30%; right: 20%; animation-delay: 1s; }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* Glass Morphism Effects */
    .glass-effect {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .glass-inner {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    /* Premium Header */
    .premium-header {
        background: var(--primary-gradient);
        position: relative;
        overflow: hidden;
    }

    .header-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.1;
    }

    .shape {
        position: absolute;
        border-radius: 50%;
        background: white;
    }

    .shape-1 { width: 100px; height: 100px; top: -50px; left: -50px; }
    .shape-2 { width: 150px; height: 150px; bottom: -75px; right: -75px; }
    .shape-3 { width: 80px; height: 80px; top: 50%; left: 10%; }

    /* Text Gradient */
    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Premium Badge */
    .premium-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 600;
    }

    /* Form Elements */
    .premium-input .form-control,
    .premium-input .form-select {
        background: rgba(255, 255, 255, 0.8);
        border: none;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .premium-input .form-control:focus,
    .premium-input .form-select:focus {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        transform: translateY(-2px);
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
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .btn-glow:hover::before {
        left: 100%;
    }

    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .btn-hover {
        transition: all 0.3s ease;
    }

    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Status Messages */
    .availability-status {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .availability-status.available {
        background: rgba(209, 250, 229, 0.8);
        color: #065f46;
        border: 1px solid rgba(167, 243, 208, 0.5);
    }

    .availability-status.unavailable {
        background: rgba(254, 226, 226, 0.8);
        color: #991b1b;
        border: 1px solid rgba(254, 202, 202, 0.5);
    }

    .availability-status.loading {
        background: rgba(219, 234, 254, 0.8);
        color: #1e40af;
        border: 1px solid rgba(147, 197, 253, 0.5);
    }

    /* Success Icon */
    .success-icon {
        background: var(--primary-gradient);
    }

    /* Feature Items */
    .feature-item {
        transition: transform 0.3s ease;
    }

    .feature-item:hover {
        transform: translateY(-5px);
    }

    /* Error Messages */
    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
    }

    /* Section Icons */
    .section-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 2rem;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .d-flex.justify-content-center {
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            width: 100%;
        }

        .floating-element {
            display: none;
        }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-gradient);
        border-radius: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('reservation_date');
        const slateSelect = document.getElementById('slate_number');
        const statusText = document.getElementById('slate-status');
        const submitBtn = document.querySelector('.btn-submit');
        const spinner = submitBtn.querySelector('.spinner-border');

        function showStatus(message, type = 'info') {
            statusText.textContent = message;
            statusText.className = `availability-status ${type}`;
            statusText.style.display = 'block';

            if (type === 'available') {
                setTimeout(() => {
                    statusText.style.display = 'none';
                }, 5000);
            }
        }

        function setLoadingState(loading) {
            if (loading) {
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');
            } else {
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        }

        dateInput.addEventListener('change', async function() {
            const date = this.value;
            slateSelect.innerHTML = '<option value="">{{ __('messages.select_time_slot') ?? "Select Time Slot" }}</option>';
            statusText.style.display = 'none';
            setLoadingState(true);

            if (!date) {
                setLoadingState(false);
                return;
            }

            showStatus('{{ __('messages.checking_availability') ?? "🔍 Checking availability..." }}', 'loading');

            try {
                const activeRes = await fetch(`/working-days/check-active-date?date=${encodeURIComponent(date)}`);
                const activeData = await activeRes.json();

                if (!activeData.is_active) {
                    showStatus('{{ __('messages.holiday') ?? "❌ This date is not available for bookings" }}', 'unavailable');
                    slateSelect.innerHTML = '<option value="" disabled>{{ __('messages.holiday') ?? "Not Available" }}</option>';
                    setLoadingState(false);
                    return;
                }

                const slateRes = await fetch(`/working-days/slatesNumber?date=${encodeURIComponent(date)}`);
                const slates = await slateRes.json();

                if (slates.length === 0) {
                    showStatus('{{ __('messages.all_booked') ?? "❌ All time slots are booked for this date" }}', 'unavailable');
                    setLoadingState(false);
                    return;
                }

                let availableSlots = 0;
                slates.forEach((slate, i) => {
                    if (slate !== "Reserved") {
                        const option = document.createElement('option');
                        option.value = i + 1;
                        option.textContent = `🕒 ${slate}`;
                        slateSelect.appendChild(option);
                        availableSlots++;
                    }
                });

                if (availableSlots > 0) {
                    showStatus(`🎉 {{ __('messages.slots_available') ?? "${availableSlots} time slots available" }}`.replace('${availableSlots}', availableSlots), 'available');
                } else {
                    showStatus('{{ __('messages.all_booked') ?? "❌ All time slots are booked" }}', 'unavailable');
                }

            } catch (error) {
                console.error('Error:', error);
                showStatus('{{ __('messages.error_fetching_slates') ?? "⚠️ Error loading time slots" }}', 'unavailable');
            } finally {
                setLoadingState(false);
            }
        });

        document.getElementById('reservationForm').addEventListener('submit', function() {
            setLoadingState(true);
        });

        // Restore old values
        const oldDate = "{{ old('reservation_date') }}";
        if (oldDate) {
            dateInput.value = oldDate;
            setTimeout(() => {
                dateInput.dispatchEvent(new Event('change'));
            }, 100);
        }

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        dateInput.min = today;
    });
</script>
@endsection