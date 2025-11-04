@extends('layouts.sideBar')

@section('title', __('messages.settings'))

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
                <h1 class="display-6 fw-bold text-gradient mb-2">{{ __('messages.Application Settings') }}</h1>
                <p class="text-muted fs-5">
                    {{ __('messages.manage_application_settings') ?? 'Manage application settings and configurations' }}
                </p>
            </div>

            <!-- Flash Message -->
            @if (session('success'))
                <div class="alert alert-success glass-effect border-0 alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="success-icon rounded-circle p-2 me-3">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ __('messages.success') ?? 'Success!' }}</h6>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger glass-effect border-0 alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="danger-icon rounded-circle p-2 me-3">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ __('messages.error') ?? 'Error!' }}</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Settings Form -->
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    @foreach ($settings as $setting)
                        <div class="col-md-6 col-lg-4">
                            <div class="card setting-card glass-effect border-0 rounded-4 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-primary mb-3">{{ $setting->name }}</h5>
                                    <input type="hidden" name="settings[{{ $setting->id }}][id]" value="{{ $setting->id }}">
                                    <!-- Value Field -->
                                    <div class="mb-3">
                                        <label class="form-label small text-muted fw-semibold">{{ __('messages.value') ?? 'Value' }}:</label>
                                        @if ($setting->type === 'file')
                                            <input type="file" name="settings[{{ $setting->id }}][value]"
                                                class="form-control premium-input">
                                        @else
                                            <input type="text" name="settings[{{ $setting->id }}][value]"
                                                value="{{ $setting->value }}" class="form-control premium-input">
                                        @endif
                                    </div>

                                    <!-- Type Display -->
                                    <div class="mb-3">
                                        <label class="form-label small text-muted fw-semibold">{{ __('messages.type') ?? 'Type' }}:</label>
                                        <span class="badge bg-info bg-opacity-10 text-info">{{ ucfirst($setting->type) }}</span>
                                    </div>

                                    <!-- Hidden name -->
                                    <input type="hidden" name="settings[{{ $setting->id }}][name]"
                                        value="{{ $setting->name }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div></div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-glow rounded-pill px-4 py-2">
                            <i class="fas fa-save me-2"></i>
                            {{ __('messages.save') }}
                        </button>


                    </div>
                </div>
            </form>
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

        /* Form Elements */
        .premium-input {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .premium-input:focus {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15);
        }

        /* Cards */
        .setting-card {
            transition: all 0.3s ease;
        }

        .setting-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Icons */
        .success-icon {
            background: var(--primary-gradient);
        }

        .danger-icon {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
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
        }

        .rounded-4 {
            border-radius: 20px !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
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
        });
    </script>
@endsection
