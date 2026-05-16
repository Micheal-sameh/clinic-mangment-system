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

            <!-- Header Section -->
            <div class="text-center mb-5">
                <h1 class="display-6 fw-bold text-gradient mb-2">{{ __('messages.working_days') }}</h1>
            </div>

            <!-- Flash Messages -->
            @if ($errors->any())
                <div class="alert alert-danger glass-effect border-0 alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="error-icon rounded-circle p-2 me-3">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ __('messages.validation_errors') ?? 'Please fix the following errors:' }}
                            </h6>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success glass-effect border-0 alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="success-icon rounded-circle p-2 me-3">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ __('messages.success') ?? 'Success!' }}</h6>
                            <p class="mb-0">{{ session('message') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content Card -->
            <div class="card glass-effect border-0 rounded-4 shadow-xxl overflow-hidden">
            <!-- Premium Header -->
            <div class="card-header premium-header position-relative overflow-hidden">
                <div class="header-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                </div>
                <div class="position-relative z-3 text-center text-white py-4">
                    <div class="header-icon bg-white text-primary rounded-3 p-3 d-inline-flex mb-3">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h2 class="h3 fw-bold mb-2">{{ __('messages.working_hours') ?? 'Working Hours' }}</h2>
                    @if(isset($doctor))
                        <p class="mb-2 opacity-90">
                            {{ __('messages.for_doctor') ?? 'For Doctor' }}: {{ $doctor->localized_name }}
                        </p>
                    @endif
                    {{-- <p class="mb-0 opacity-90">
                        {{ __('messages.configure_daily_schedule') ?? 'Configure daily working hours for your clinic' }}
                    </p> --}}

                    <!-- Quick Stats -->
                    <div class="row justify-content-center mt-3">
                        <div class="col-auto">
                            <div class="stat-badge glass-inner rounded-pill px-3 py-1">
                                <i class="fas fa-calendar-check me-1 text-success"></i>
                                <small>{{ $workingDays->where('status', App\Enums\WorkingDayStatus::ACTIVE)->count() }}/7
                                    {{ __('messages.active') ?? 'Active' }}</small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-badge glass-inner rounded-pill px-3 py-1">
                                <i class="fas fa-users me-1 text-info"></i>
                                <small>{{ $workingDays->count() }} {{ __('messages.days') ?? 'Days' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- Doctor Filter -->
                    <div class="p-4 border-bottom">
                        <form method="GET" action="{{ route('working-days.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="doctor_id" class="form-label fw-semibold">{{ __('messages.select_doctor') ?? 'Select Doctor' }}</label>
                                <select name="doctor_id" id="doctor_id" class="form-select rounded-pill" data-live-search="true">
                                    <option value="">{{ __('messages.all_doctors') ?? 'All Doctors' }}</option>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>
                                            {{ $doc->localized_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-filter me-2"></i>
                                    {{ __('messages.filter') ?? 'Filter' }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <form id="working-days-form" method="POST" action="{{ route('working-days.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Include doctor_id in the form if filtering -->
                        @if(request('doctor_id'))
                            <input type="hidden" name="doctor_id" value="{{ request('doctor_id') }}">
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        {{-- <th class="ps-4" style="width: 80px;">
                                            <i class="fas fa-hashtag text-muted me-1"></i>
                                            {{ __('messages.number') }}
                                        </th> --}}
                                        <th>
                                            <i class="fas fa-calendar-day text-muted me-1"></i>
                                            {{ __('messages.day') }}
                                        </th>
                                        @if($workingDays->first()->doctor && is_null($doctor))
                                        <th style="width: 250px;">
                                            <i class="fas fa-clock text-muted me-1"></i>
                                            {{ __('messages.doctor') ?? 'Doctor' }}
                                        </th>
                                        @endif
                                        <th style="width: 250px;">
                                            <i class="fas fa-clock text-muted me-1"></i>
                                            {{ __('messages.working_hours') ?? 'Working Hours' }}
                                        </th>
                                        <th style="width: 120px;">
                                            <i class="fas fa-business-time text-muted me-1"></i>
                                            {{ __('messages.duration') ?? 'Duration' }}
                                        </th>
                                        @if (auth()->user()->hasRole('admin'))
                                            <th class="text-center" style="width: 120px;">
                                                <i class="fas fa-toggle-on text-muted me-1"></i>
                                                {{ __('messages.status') }}
                                            </th>
                                            <th class="text-center" style="width: 100px;">
                                                <i class="fas fa-cogs text-muted me-1"></i>
                                                {{ __('messages.actions') }}
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workingDays as $key => $workingDay)
                                        @php
                                            $fromTime = \Carbon\Carbon::parse($workingDay->from);
                                            $toTime = \Carbon\Carbon::parse($workingDay->to);
                                            $duration = $fromTime->diff($toTime);
                                            $isActive = $workingDay->status === App\Enums\WorkingDayStatus::ACTIVE;
                                            $dayColors = [
                                                'Monday' => 'primary',
                                                'Tuesday' => 'success',
                                                'Wednesday' => 'warning',
                                                'Thursday' => 'info',
                                                'Friday' => 'danger',
                                                'Saturday' => 'secondary',
                                                'Sunday' => 'dark',
                                            ];
                                            $dayColor = $dayColors[$workingDay->name['en']] ?? 'primary';
                                        @endphp

                                        <tr class="working-day-row align-middle {{ !$isActive ? 'table-inactive' : '' }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 fw-semibold text-{{ $dayColor }}">
                                                            {{ $workingDay->localized_name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            @if(!isset($doctor))
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-1 fw-semibold text-{{ $dayColor }}">
                                                            {{ $workingDay->doctor->localized_name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            @endif

                                            @if (auth()->user()->hasRole('admin'))
                                                <td>
                                                    <div class="time-inputs">
                                                        <div class="input-group input-group-sm premium-input">
                                                            {{-- <span class="input-group-text bg-light border-end-0">
                                                                <i class="fas fa-sun text-warning"></i>
                                                            </span> --}}
                                                            <input type="time"
                                                                name="working_days[{{ $workingDay->id }}][from]"
                                                                value="{{ $fromTime->format('H:i') }}"
                                                                data-original="{{ $fromTime->format('H:i') }}"
                                                                class="form-control border-start-0 time-from">
                                                        </div>
                                                        <div class="time-separator mx-2 text-muted fw-bold">→</div>
                                                        <div class="input-group input-group-sm premium-input">
                                                            <input type="time"
                                                                name="working_days[{{ $workingDay->id }}][to]"
                                                                value="{{ $toTime->format('H:i') }}"
                                                                data-original="{{ $toTime->format('H:i') }}"
                                                                class="form-control time-to border-end-0">
                                                            {{-- <span class="input-group-text bg-light border-start-0">
                                                                <i class="fas fa-moon text-primary"></i>
                                                            </span> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="time-display">
                                                        <span class="badge bg-light text-dark border glass-effect">
                                                            <i class="fas fa-clock me-1 text-{{ $dayColor }}"></i>
                                                            {{ $fromTime->format('h:i A') }} -
                                                            {{ $toTime->format('h:i A') }}
                                                        </span>
                                                    </div>
                                                </td>
                                            @endif

                                            <td>
                                                <span
                                                    class="badge bg-{{ $dayColor }} bg-opacity-10 text-{{ $dayColor }} glass-effect">
                                                    <i class="fas fa-hourglass-half me-1"></i>
                                                    {{ $duration->h }}h {{ $duration->i }}m
                                                </span>
                                            </td>

                                            @if (auth()->user()->hasRole('admin'))
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }} text-white glass-effect">
                                                        <i class="fas {{ $isActive ? 'fa-play' : 'fa-pause' }} me-1"></i>
                                                        {{ App\Enums\WorkingDayStatus::getStringValue($workingDay->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('working-days.active', $workingDay->id) }}"
                                                        class="btn btn-sm {{ $isActive ? 'btn-warning' : 'btn-success' }} status-toggle glass-effect"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $isActive ? __('messages.deactivate_day') : __('messages.activate_day') }}">
                                                        <i class="fas {{ $isActive ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if (auth()->user()->hasRole('admin'))
                            <div class="card-footer bg-transparent border-0 py-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="text-muted small mb-2 mb-md-0">
                                        <i class="fas fa-info-circle me-1"></i>
                                        {{ __('messages.working_days_count') ?? 'Total working days configured:' }}
                                        {{ $workingDays->count() }}
                                    </div>
                                    <div class="d-flex gap-3 flex-wrap">
                                        <button type="button"
                                            class="btn btn-outline-secondary rounded-pill px-4 btn-hover"
                                            onclick="resetForm()">
                                            <i class="fas fa-undo me-2"></i>
                                            {{ __('messages.reset') ?? 'Reset Changes' }}
                                        </button>
                                        <button id="submit-button" type="submit"
                                            class="btn btn-primary rounded-pill px-4 btn-glow" disabled>
                                            <i class="fas fa-save me-2"></i>
                                            {{ __('messages.update') ?? 'Update Schedule' }}
                                            <span class="spinner-border spinner-border-sm ms-2 d-none"
                                                role="status"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Quick Tips -->
            @if (auth()->user()->hasRole('admin'))
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card glass-effect border-0 rounded-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-center">
                                    <i class="fas fa-lightbulb text-warning me-2"></i>
                                    {{ __('messages.schedule_tips') ?? 'Schedule Management Tips' }}
                                </h6>
                                <div class="row text-center">
                                    <div class="col-md-3 mb-3">
                                        <div class="feature-item">
                                            <i class="fas fa-clock text-primary fa-2x mb-2"></i>
                                            <small
                                                class="d-block fw-medium">{{ __('messages.consistent_hours') ?? 'Consistent Hours' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="feature-item">
                                            <i class="fas fa-utensils text-success fa-2x mb-2"></i>
                                            <small
                                                class="d-block fw-medium">{{ __('messages.break_times') ?? 'Break Times' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="feature-item">
                                            <i class="fas fa-ambulance text-danger fa-2x mb-2"></i>
                                            <small
                                                class="d-block fw-medium">{{ __('messages.emergency_slots') ?? 'Emergency Slots' }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="feature-item">
                                            <i class="fas fa-chart-line text-info fa-2x mb-2"></i>
                                            <small
                                                class="d-block fw-medium">{{ __('messages.demand_patterns') ?? 'Demand Patterns' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

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
            animation: float 8s ease-in-out infinite;
        }

        .element-1 {
            width: 120px;
            height: 120px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .element-2 {
            width: 80px;
            height: 80px;
            top: 70%;
            right: 10%;
            animation-delay: 3s;
        }

        .element-3 {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 15%;
            animation-delay: 6s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-25px) rotate(180deg);
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
            width: 120px;
            height: 120px;
            top: -60px;
            left: -60px;
        }

        .shape-2 {
            width: 80px;
            height: 80px;
            bottom: -40px;
            right: -40px;
        }

        .shape-3 {
            width: 60px;
            height: 60px;
            top: 50%;
            left: 20%;
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

        .stat-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Form Elements */
        .premium-input .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .premium-input .form-control:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(13, 148, 136, 0.15);
            transform: translateY(-1px);
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

        .btn-glow:hover:not(:disabled) {
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

        .working-day-row:hover td {
            background: rgba(255, 255, 255, 0.8) !important;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        .table-inactive td {
            opacity: 0.6;
            background: rgba(108, 117, 125, 0.05);
        }

        /* Day Styling */
        .day-number {
            font-size: 0.9rem;
            min-width: 35px;
            text-align: center;
        }

        .day-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Time Inputs */
        .time-inputs {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .time-separator {
            font-size: 1.1rem;
        }

        .input-group-sm .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .input-group-text {
            background-color: rgba(248, 249, 250, 0.8);
            border-color: rgba(222, 226, 230, 0.5);
        }

        /* Status Toggle */
        .status-toggle {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .status-toggle:hover {
            transform: scale(1.1);
        }

        /* Icons */
        .success-icon {
            background: var(--primary-gradient);
        }

        .error-icon {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .header-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Feature Items */
        .feature-item {
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .display-6 {
                font-size: 2rem;
            }

            .time-inputs {
                flex-direction: column;
                gap: 0.5rem;
            }

            .time-separator {
                transform: rotate(90deg);
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .card-footer .d-flex {
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

        .rounded-4 {
            border-radius: 20px !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Select for searchable dropdown -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#doctor_id').selectpicker({
                liveSearch: true,
                liveSearchPlaceholder: '{{ __('messages.search_doctor') ?? 'Search for doctor...' }}',
                noneResultsText: '{{ __('messages.no_results') ?? 'No results found' }}'
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('working-days-form');
            const submitButton = document.getElementById('submit-button');
            const timeInputs = form.querySelectorAll('input[type="time"]');
            const spinner = submitButton.querySelector('.spinner-border');

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            function checkForChanges() {
                let hasChanges = false;
                timeInputs.forEach(input => {
                    if (input.value !== input.dataset.original) {
                        hasChanges = true;
                        input.parentElement.parentElement.style.background = 'rgba(255, 243, 205, 0.3)';
                    } else {
                        input.parentElement.parentElement.style.background = '';
                    }
                });
                submitButton.disabled = !hasChanges;
            }

            // Listen to any change in time inputs
            timeInputs.forEach(input => {
                input.addEventListener('input', checkForChanges);
                input.addEventListener('change', checkForChanges);
            });

            // Remove unchanged rows on submit and show loading
            form.addEventListener('submit', function(e) {
                const rows = form.querySelectorAll('tbody tr');
                let hasChanges = false;

                rows.forEach(row => {
                    const inputs = row.querySelectorAll('input[type="time"]');
                    let changed = false;

                    inputs.forEach(input => {
                        if (input.value !== input.dataset.original) {
                            changed = true;
                            hasChanges = true;
                        }
                    });

                    if (!changed) {
                        inputs.forEach(input => {
                            input.disabled = true;
                            input.name = '';
                        });
                    }
                });

                if (!hasChanges) {
                    e.preventDefault();
                    return;
                }

                // Show loading state
                submitButton.disabled = true;
                spinner.classList.remove('d-none');
            });

            // Reset form function
            window.resetForm = function() {
                timeInputs.forEach(input => {
                    input.value = input.dataset.original;
                    input.parentElement.parentElement.style.background = '';
                });
                checkForChanges();

                // Show reset feedback
                submitButton.innerHTML =
                    '<i class="fas fa-check me-2"></i> {{ __('messages.changes_reset') ?? 'Changes Reset' }}';
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-success');

                setTimeout(() => {
                    submitButton.innerHTML =
                        '<i class="fas fa-save me-2"></i> {{ __('messages.update_schedule') ?? 'Update Schedule' }}';
                    submitButton.classList.remove('btn-success');
                    submitButton.classList.add('btn-primary');
                    checkForChanges();
                }, 2000);
            };

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
@endsection
