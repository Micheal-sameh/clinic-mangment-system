@extends('layouts.sideBar')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-2 text-gray-800">{{ __('messages.procedures') }}</h1>
                        <p class="text-muted">
                            {{ __('messages.manage_medical_procedures') ?? 'Manage and organize medical procedures' }}</p>
                    </div>
                    @can('procedures_create')
                        <a class="btn btn-primary btn-lg shadow-sm" href="{{ route('procedures.create') }}">
                            <i class="fas fa-plus-circle me-2"></i>
                            {{ __('messages.Add new procedure') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>{{ __('messages.error_occurred') ?? 'Error occurred:' }}</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats and Filter Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Statistics -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon bg-primary text-white rounded-3 p-3 me-3">
                                <i class="fas fa-procedures fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 text-primary">{{ $procedures->total() }}</h4>
                                <p class="text-muted mb-0">{{ __('messages.total_procedures') ?? 'Total Procedures' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Search Filter -->
                    <div class="col-md-6">
                        <form action="{{ route('procedures.index') }}" method="GET" id="filter-form">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="name" class="form-control border-start-0"
                                    placeholder="{{ __('messages.search_by_name') ?? 'Search by name...' }}"
                                    value="{{ request()->name }}" id="name-input">
                                @if (request()->name)
                                    <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop Table View -->
        <div class="d-none d-lg-block">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 80px;">{{ __('messages.number') }}</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th class="text-end pe-4" style="width: 150px;">{{ __('messages.price') }}</th>
                                    @can(['procedures_edit', 'procedures_delete'])
                                        <th class="text-center" style="width: 120px;">{{ __('messages.actions') }}</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($procedures as $key => $procedure)
                                    <tr class="procedure-row">
                                        <td class="ps-4 fw-semibold text-muted">
                                            {{ $key + 1 + ($procedures->currentPage() - 1) * $procedures->perPage() }}</td>
                                        <td>
                                            @can('procedures_show')
                                                <a href="{{ route('procedures.show', $procedure['id']) }}"
                                                    class="text-decoration-none text-dark fw-medium procedure-name">
                                                    <i class="fas fa-file-medical me-2 text-primary"></i>
                                                    {{ $procedure->localized_name }}
                                                </a>
                                            @else
                                                <span class="text-dark fw-medium">
                                                    <i class="fas fa-file-medical me-2 text-primary"></i>
                                                    {{ $procedure->localized_name }}
                                                </span>
                                            @endcan
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="badge bg-success bg-opacity-10 text-success fs-6 py-2 px-3">
                                                ${{ number_format($procedure->price, 2) }}
                                            </span>
                                        </td>
                                        @can(['procedures_edit', 'procedures_delete'])
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @can('procedures_edit')
                                                        <a class="btn btn-outline-primary rounded-start"
                                                            href="{{ route('procedures.edit', $procedure->id) }}"
                                                            data-bs-toggle="tooltip" title="{{ __('messages.edit') }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endcan
                                                    @can('procedures_delete')
                                                        <form action="{{ route('procedures.delete', $procedure['id']) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger rounded-end"
                                                                onclick="return confirm('{{ __('messages.confirm_delete_procedure') ?? 'Are you sure you want to delete this procedure?' }}')"
                                                                data-bs-toggle="tooltip" title="{{ __('messages.delete') }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        @endcan
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ auth()->user()->can(['procedures_edit', 'procedures_delete']) ? 4 : 3 }}"
                                            class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-procedures text-muted mb-3" style="font-size: 3rem;"></i>
                                                <h5 class="text-muted">
                                                    {{ __('messages.no_procedures_found') ?? 'No procedures found' }}</h5>
                                                <p class="text-muted mb-4">
                                                    {{ __('messages.no_procedures_description') ?? 'No procedures match your search criteria' }}
                                                </p>
                                                @can('procedures_create')
                                                    <a href="{{ route('procedures.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>
                                                        {{ __('messages.Add new procedure') }}
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Cards View -->
        <div class="d-block d-lg-none">
            <div class="row g-3">
                @forelse ($procedures as $key => $procedure)
                    <div class="col-12">
                        <div class="card procedure-card shadow-sm border-0 h-100">
                            <div class="card-body">
                                <!-- Card Header -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="procedure-badge bg-primary text-white rounded-3 px-3 py-2">
                                        <small
                                            class="fw-bold">#{{ $key + 1 + ($procedures->currentPage() - 1) * $procedures->perPage() }}</small>
                                    </div>
                                    <span class="badge bg-success bg-opacity-10 text-success fs-6 py-2 px-3">
                                        ${{ number_format($procedure->price, 2) }}
                                    </span>
                                </div>

                                <!-- Procedure Name -->
                                <div class="mb-3">
                                    @can('procedures_show')
                                        <a href="{{ route('procedures.show', $procedure['id']) }}"
                                            class="text-decoration-none text-dark">
                                            <h5 class="card-title mb-2">
                                                <i class="fas fa-file-medical me-2 text-primary"></i>
                                                {{ $procedure->localized_name }}
                                            </h5>
                                        </a>
                                    @else
                                        <h5 class="card-title mb-2">
                                            <i class="fas fa-file-medical me-2 text-primary"></i>
                                            {{ $procedure->localized_name }}
                                        </h5>
                                    @endcan
                                </div>

                                <!-- Action Buttons -->
                                @can(['procedures_edit', 'procedures_delete'])
                                    <div class="d-flex gap-2 mt-3 pt-3 border-top">
                                        @can('procedures_edit')
                                            <a class="btn btn-outline-primary btn-sm flex-fill d-flex align-items-center justify-content-center"
                                                href="{{ route('procedures.edit', $procedure->id) }}">
                                                <i class="fas fa-edit me-2"></i>
                                                {{ __('messages.edit') }}
                                            </a>
                                        @endcan
                                        @can('procedures_delete')
                                            <form action="{{ route('procedures.delete', $procedure['id']) }}" method="POST"
                                                class="flex-fill">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center"
                                                    onclick="return confirm('{{ __('messages.confirm_delete_procedure') ?? 'Are you sure you want to delete this procedure?' }}')">
                                                    <i class="fas fa-trash me-2"></i>
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-procedures text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">
                                        {{ __('messages.no_procedures_found') ?? 'No procedures found' }}</h5>
                                    <p class="text-muted mb-4">
                                        {{ __('messages.no_procedures_description') ?? 'No procedures match your search criteria' }}
                                    </p>
                                    @can('procedures_create')
                                        <a href="{{ route('procedures.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>
                                            {{ __('messages.Add new procedure') }}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if ($procedures->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <div class="text-muted small mb-2 mb-md-0">
                                    {{ __('messages.showing') ?? 'Showing' }}
                                    {{ $procedures->firstItem() }} - {{ $procedures->lastItem() }}
                                    {{ __('messages.of') ?? 'of' }} {{ $procedures->total() }}
                                </div>
                                <nav>
                                    {{ $procedures->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .procedure-card {
            border-left: 4px solid #0d6efd !important;
        }

        .procedure-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .procedure-badge {
            font-size: 0.875rem;
        }

        .procedure-row:hover {
            background-color: rgba(0, 123, 255, 0.04);
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .procedure-name:hover {
            color: #0d6efd !important;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .empty-state {
            padding: 2rem 0;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 8px;
            margin: 0 3px;
            border: 1px solid #dee2e6;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }

            .card-body .row>div {
                margin-bottom: 1rem;
            }

            .procedure-card .btn {
                font-size: 0.875rem;
                padding: 0.5rem 0.75rem;
            }

            .procedure-card .card-body {
                padding: 1.25rem;
            }

            .procedure-badge {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem !important;
            }
        }

        @media (max-width: 576px) {
            .procedure-card .d-flex.gap-2 {
                flex-direction: column;
                gap: 0.5rem !important;
            }

            .procedure-card .btn {
                width: 100%;
            }
        }
    </style>

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips for desktop view
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

            // Search with delay
            let typingTimer;
            const doneTypingInterval = 800;
            const nameInput = document.getElementById('name-input');

            nameInput.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(submitForm, doneTypingInterval);
            });

            // Submit form function
            function submitForm() {
                document.getElementById('filter-form').submit();
            }

            // Clear search function
            function clearSearch() {
                nameInput.value = '';
                submitForm();
            }

            // Add loading state to delete buttons
            const deleteForms = document.querySelectorAll('form[action*="delete"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('button[type="submit"]');
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Deleting...';
                });
            });
        });
    </script>
@endsection
