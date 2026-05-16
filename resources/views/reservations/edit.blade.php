@extends('layouts.sideBar')
<title>{{ __('messages.edit') }} {{ __('messages.reservation') }}</title>

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
                        <div class="alert alert-success glass-effect border-0 alert-dismissible fade show mb-4"
                            role="alert">
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
                                    <i class="fas fa-calendar-edit fa-2x"></i>
                                </div>
                                <h2 class="h3 fw-bold mb-2">
                                    {{ __('messages.edit_reservation_time') ?? 'Edit Reservation Time' }}</h2>
                                <p class="mb-0 opacity-90">
                                    {{ __('messages.select_new_time_slot') ?? 'Select a new time slot for your appointment' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 p-md-5">
                            <!-- Current Reservation Info -->
                            <div class="current-reservation-info glass-inner rounded-4 mb-4 p-3">
                                <h6 class="fw-bold mb-3 text-primary">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ __('messages.current_reservation') ?? 'Current Reservation' }}
                                </h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">{{ __('messages.date') }}</small>
                                        <strong>{{ \Carbon\Carbon::parse($reservation->date)->format('M d, Y') }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small
                                            class="text-muted d-block">{{ __('messages.current_time') ?? 'Current Time' }}</small>
                                        <strong>{{ \Carbon\Carbon::parse($reservation->from)->format('h:i A') }} -
                                            {{ \Carbon\Carbon::parse($reservation->to)->format('h:i A') }}</strong>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('reservations.update', $reservation->id) }}" method="POST"
                                id="editReservationForm">
                                @csrf
                                @method('PUT')

                                <!-- Time Slot Selection -->
                                <div class="form-section glass-inner rounded-4 mb-5">
                                    <div class="section-header d-flex align-items-center mb-4">
                                        <div class="section-icon bg-success text-white rounded-3 p-3 me-3">
                                            <i class="fas fa-clock fa-lg"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-1">
                                                {{ __('messages.select_new_time') ?? 'Select New Time' }}</h5>
                                            <p class="text-muted mb-0 small">
                                                {{ __('messages.choose_available_slot') ?? 'Choose from available time slots' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-floating premium-input">
                                        <select name="slate_number" id="slate_number"
                                            class="form-select border-0 shadow-sm pt-4" required>
                                            <option value="">
                                                {{ __('messages.select_time_slot') ?? 'Select Time Slot' }}</option>
                                            @foreach ($data['availableSlates'] as $number => $time)
                                                <option value="{{ $number }}"
                                                    {{ $number == $reservation->reservation_number ? 'selected' : '' }}>
                                                    🕒 {{ $time }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="slate_number" class="fw-medium text-muted">
                                            <i class="fas fa-clock me-2"></i>
                                            {{ __('messages.new_time_slot') ?? 'New Time Slot' }}
                                        </label>
                                        @error('slate_number')
                                            <div class="error-message mt-2">
                                                <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Availability Status -->
                                    <div id="availability-status" class="availability-status mt-4" style="display:none;">
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="text-center pt-4">
                                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                                        <button type="submit"
                                            class="btn btn-primary px-5 py-3 rounded-pill btn-glow btn-submit">
                                            <i class="fas fa-save me-2"></i>
                                            {{ __('messages.update_reservation') ?? 'Update Reservation' }}
                                            <span class="spinner-border spinner-border-sm ms-2 d-none"
                                                role="status"></span>
                                        </button>
                                        <a href="{{ route('reservations.index') }}"
                                            class="btn btn-outline-secondary px-4 py-3 rounded-pill btn-hover">
                                            <i class="fas fa-arrow-left me-2"></i>
                                            {{ __('messages.cancel') }}
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
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <small
                                        class="text-muted">{{ __('messages.flexible_booking') ?? 'Flexible booking system' }}</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="stat-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <small
                                        class="text-muted">{{ __('messages.easy_rescheduling') ?? 'Easy rescheduling' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        

        :root {
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
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
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(8, 145, 178, 0.05));
            
        }

        .element-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .element-2 {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .element-3 {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .element-4 {
            width: 120px;
            height: 120px;
            top: 30%;
            right: 20%;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
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

        .shape-1 {
            width: 100px;
            height: 100px;
            top: -50px;
            left: -50px;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            bottom: -75px;
            right: -75px;
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            top: 50%;
            left: 10%;
        }

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
            box-shadow: 0 8px 25px rgba(13, 148, 136, 0.15);
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
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.4);
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

        /* Current Reservation Info */
        .current-reservation-info {
            background: rgba(13, 148, 136, 0.1);
            border: 1px solid rgba(13, 148, 136, 0.2);
        }

        /* Section Icons */
        .section-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Error Messages */
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
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

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editReservationForm');
            const submitBtn = document.querySelector('.btn-submit');
            const spinner = submitBtn.querySelector('.spinner-border');
            const slateSelect = document.getElementById('slate_number');
            const statusDiv = document.getElementById('availability-status');

            function showStatus(message, type = 'info') {
                statusDiv.textContent = message;
                statusDiv.className = `availability-status ${type}`;
                statusDiv.style.display = 'block';
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

            slateSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                const currentValue = '{{ $reservation->reservation_number }}';

                if (selectedValue === currentValue) {
                    showStatus('{{ __('messages.same_time_slot') ?? 'This is your current time slot' }}',
                        'info');
                } else if (selectedValue) {
                    showStatus('{{ __('messages.time_slot_available') ?? '✅ Time slot is available' }}',
                        'available');
                } else {
                    statusDiv.style.display = 'none';
                }
            });

            form.addEventListener('submit', function(e) {
                const selectedValue = slateSelect.value;
                const currentValue = '{{ $reservation->reservation_number }}';

                if (selectedValue === currentValue) {
                    e.preventDefault();
                    showStatus(
                        '{{ __('messages.no_changes_made') ?? 'No changes made to the reservation' }}',
                        'info');
                    return;
                }

                setLoadingState(true);
            });

            // Initialize status if current value is selected
            if (slateSelect.value) {
                slateSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
