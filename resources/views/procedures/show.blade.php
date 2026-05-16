@extends('layouts.sideBar')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <!-- Header Section -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-gradient-primary text-white py-4 px-5 border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="header-icon bg-white text-primary rounded-3 p-3 me-3">
                                    <i class="fas fa-file-medical fa-2x"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 fw-bold">{{ __('messages.procedure_details') ?? 'Procedure Details' }}</h1>
                                    <p class="mb-0 opacity-75">
                                        {{ __('messages.view_procedure_information') ?? 'View detailed information about this medical procedure' }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                @can('procedures_edit')
                                    <a href="{{ route('procedures.edit', $procedure->id) }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-edit me-2"></i>
                                        {{ __('messages.edit') }}
                                    </a>
                                @endcan
                                <a href="{{ route('procedures.index') }}" class="btn btn-outline-light btn-sm">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('messages.back_to_list') ?? 'Back to List' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Card -->
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <!-- Procedure Information -->
                        <div class="row">
                            <!-- English Information -->
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-language me-2 text-primary"></i>
                                        {{ __('messages.english_information') ?? 'English Information' }}
                                    </h5>
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-medium text-muted">{{ __('messages.name') }}</label>
                                        <p class="mb-0 fs-5">{{ $procedure->name['en'] }}</p>
                                    </div>
                                    <div class="info-item">
                                        <label class="form-label fw-medium text-muted">{{ __('messages.description') }}</label>
                                        <p class="mb-0">{{ $procedure->description['en'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Arabic Information -->
                            <div class="col-md-6 mb-4">
                                <div class="info-section">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-language me-2 text-primary"></i>
                                        {{ __('messages.arabic_information') ?? 'Arabic Information' }}
                                    </h5>
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-medium text-muted">{{ __('messages.name') }}</label>
                                        <p class="mb-0 fs-5" dir="rtl">{{ $procedure->name['ar'] }}</p>
                                    </div>
                                    <div class="info-item">
                                        <label class="form-label fw-medium text-muted">{{ __('messages.description') }}</label>
                                        <p class="mb-0" dir="rtl">{{ $procedure->description['ar'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="pricing-section">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-dollar-sign me-2 text-success"></i>
                                        {{ __('messages.pricing_information') ?? 'Pricing Information' }}
                                    </h5>
                                    <div class="price-display">
                                        <div class="price-card">
                                            <div class="price-amount">
                                                ${{ number_format($procedure->price, 2) }}
                                            </div>
                                            <div class="price-label">
                                                {{ __('messages.procedure_price') ?? 'Procedure Price' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="metadata-section">
                                    <h5 class="section-title mb-4">
                                        <i class="fas fa-info-circle me-2 text-info"></i>
                                        {{ __('messages.additional_information') ?? 'Additional Information' }}
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="form-label fw-medium text-muted">{{ __('messages.created_at') ?? 'Created At' }}</label>
                                                <p class="mb-0">{{ $procedure->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label class="form-label fw-medium text-muted">{{ __('messages.updated_at') ?? 'Updated At' }}</label>
                                                <p class="mb-0">{{ $procedure->updated_at->format('M d, Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end pt-4 mt-4 border-top">
                            @can('procedures_edit')
                                <a href="{{ route('procedures.edit', $procedure->id) }}" class="btn btn-primary px-4 py-2 rounded-3">
                                    <i class="fas fa-edit me-2"></i>
                                    {{ __('messages.edit') ?? 'Edit Procedure' }}
                                </a>
                            @endcan
                            <a href="{{ route('procedures.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('messages.back_to_list') ?? 'Back to List' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
        }

        .header-icon {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .info-section {
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid #0d9488;
            height: 100%;
        }

        .pricing-section {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            border-left: 4px solid #10b981;
        }

        .metadata-section {
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
        }

        .section-title {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .price-card {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .price-amount {
            font-size: 2.5rem;
            font-weight: 700;
            color: #10b981;
            margin-bottom: 0.5rem;
        }

        .price-label {
            color: #6b7280;
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);
        }

        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            border-color: #cbd5e0;
            background: #f7fafc;
        }

        .rounded-4 {
            border-radius: 16px !important;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .info-section, .pricing-section, .metadata-section {
                padding: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }

            .d-flex.justify-content-end {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }

            .price-amount {
                font-size: 2rem;
            }
        }
    </style>

    
@endsection
