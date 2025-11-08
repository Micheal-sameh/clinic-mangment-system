@extends('layouts.sideBar')

@section('title', __('messages.doctors'))

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
                    {{ __('messages.doctors') ?? 'Doctors' }}
                </h1>
                <p class="text-muted fs-5">
                    {{ __('messages.manage_doctors') ?? 'Manage clinic doctors and their information' }}
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

            <!-- Stats Card -->
            <div class="card glass-effect border-0 rounded-4 shadow-xxl mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary text-white rounded-3 p-3 me-3">
                                    <i class="fas fa-user-md fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 text-primary">{{ $doctors->total() }}</h4>
                                    <p class="text-muted mb-0">{{ __('messages.total_doctors') ?? 'Total Doctors' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 text-end">
                            @can('users_create')
                                <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-glow rounded-pill px-4 py-2">
                                    <i class="fas fa-user-plus me-2"></i>
                                    {{ __('messages.add_doctor') ?? 'Add Doctor' }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="d-none d-lg-block">
                <div class="card glass-effect border-0 rounded-4 shadow-xxl">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 80px;">#</th>
                                        <th>{{ __('messages.doctor') ?? 'Doctor' }}</th>
                                        <th>{{ __('messages.specialization') ?? 'Specialization' }}</th>
                                        <th>{{ __('messages.contact') ?? 'Contact' }}</th>
                                        <th class="text-center" style="width: 150px;">{{ __('messages.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctors as $key => $doctor)
                                        <tr class="doctor-row">
                                            <td class="ps-4 fw-semibold text-muted">
                                                <div class="doctor-number bg-primary bg-opacity-10 text-primary rounded-2 px-2 py-1 d-inline-block">
                                                    {{ $key + 1 + ($doctors->currentPage() - 1) * $doctors->perPage() }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="doctor-avatar bg-primary text-white rounded-circle me-3">
                                                        {{ strtoupper(substr($doctor->localized_name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        @can('users_show')
                                                            <a href="{{ route('doctors.show', $doctor['id']) }}" class="text-decoration-none text-dark fw-semibold doctor-name">
                                                                {{ $doctor->localized_name }}
                                                            </a>
                                                        @else
                                                            <span class="fw-semibold text-dark">{{ $doctor->localized_name }}</span>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info bg-opacity-10 text-info">
                                                    {{ $doctor->specialization }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="contact-info">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="fas fa-phone text-muted me-2" style="width: 16px;"></i>
                                                        <small class="text-muted">{{ $doctor->phone }}</small>
                                                    </div>
                                                    @if ($doctor->whatsapp)
                                                        <div class="d-flex align-items-center">
                                                            <i class="fab fa-whatsapp text-success me-2" style="width: 16px;"></i>
                                                            <small class="text-muted">{{ $doctor->whatsapp }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @can('users_show')
                                                        <a href="{{ route('doctors.show', $doctor['id']) }}" class="btn btn-outline-primary rounded-start" data-bs-toggle="tooltip" title="{{ __('messages.view_details') }}">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('users_edit')
                                                        <a href="{{ route('doctors.edit', $doctor['id']) }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="{{ __('messages.edit_doctor') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('users_delete')
                                                        <form action="{{ route('doctors.destroy', $doctor['id']) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-outline-danger rounded-end" data-bs-toggle="tooltip" title="{{ __('messages.delete_doctor') }}" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Card View -->
            <div class="d-block d-lg-none">
                <div class="row g-3">
                    @foreach ($doctors as $doctor)
                        <div class="col-12">
                            <div class="card doctor-card glass-effect border-0 rounded-4 shadow-sm">
                                <div class="card-body">
                                    <!-- Doctor Header -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="doctor-avatar-sm bg-primary text-white rounded-circle me-3">
                                            {{ strtoupper(substr($doctor->localized_name, 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $doctor->localized_name }}</h6>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $doctor->specialization }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Contact Info -->
                                    <div class="contact-info mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-phone text-muted me-2" style="width: 16px;"></i>
                                            <small class="text-muted">{{ $doctor->phone }}</small>
                                        </div>
                                        @if ($doctor->whatsapp)
                                            <div class="d-flex align-items-center">
                                                <i class="fab fa-whatsapp text-success me-2" style="width: 16px;"></i>
                                                <small class="text-muted">{{ $doctor->whatsapp }}</small>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        @can('users_show')
                                            <a href="{{ route('doctors.show', $doctor['id']) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ __('messages.view') }}
                                            </a>
                                        @endcan
                                        <div class="d-flex gap-2">
                                            @can('users_edit')
                                                <a href="{{ route('doctors.edit', $doctor['id']) }}" class="btn btn-outline-secondary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('users_delete')
                                                <form action="{{ route('doctors.destroy', $doctor['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            @if ($doctors->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card glass-effect border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                    <div class="text-muted small mb-2 mb-md-0">
                                        {{ __('messages.showing') ?? 'Showing' }}
                                        {{ $doctors->firstItem() }} - {{ $doctors->lastItem() }}
                                        {{ __('messages.of') ?? 'of' }} {{ $doctors->total() }}
                                    </div>
                                    <nav>
                                        {{ $doctors->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Empty State -->
            @if ($doctors->isEmpty())
                <div class="text-center mt-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-user-md fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted">{{ __('messages.no_doctors_found') ?? 'No Doctors Found' }}</h4>
                    <p class="text-muted">{{ __('messages.add_first_doctor') ?? 'Add your first doctor to get started.' }}</p>
                    @can('users_create')
                        <a href="{{ route('doctors.create') }}" class="btn btn-primary btn-glow rounded-pill px-4 py-2">
                            <i class="fas fa-plus me-2"></i>
                            {{ __('messages.add_doctor') ?? 'Add Doctor' }}
                        </a>
                    @endcan
                </div>
            @endif
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

        /* Doctor Avatars */
        .doctor-avatar {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .doctor-avatar-sm {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }

        .doctor-number {
            font-size: 0.9rem;
            min-width: 35px;
            text-align: center;
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

        .doctor-row:hover td {
            background: rgba(255, 255, 255, 0.8) !important;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Cards */
        .doctor-card {
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Statistics */
        .stat-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Success Icon */
        .success-icon {
            background: var(--primary-gradient);
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
