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
        .floating-element {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(8, 145, 178, 0.06)) !important;
        }
        .btn-glow:hover {
            box-shadow: 0 10px 30px rgba(13, 148, 136, 0.4) !important;
        }
        .doctor-row:hover td {
            background: rgba(240, 253, 250, 0.9) !important;
        }
    </style>

    
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
