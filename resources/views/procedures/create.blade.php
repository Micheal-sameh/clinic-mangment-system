@extends('layouts.sideBar')

<title>{{ __('messages.create') }} {{ __('messages.procedure') }}</title>

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <!-- Main Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <!-- Header Section -->
                    <div class="card-header bg-gradient-primary text-white py-4 px-5 border-0">
                        <div class="d-flex align-items-center">
                            <div class="header-icon bg-white text-primary rounded-3 p-3 me-3">
                                <i class="fas fa-procedures fa-2x"></i>
                            </div>
                            <div>
                                <h1 class="h3 mb-1 fw-bold">{{ __('messages.create') }} {{ __('messages.procedure') }}</h1>
                                <p class="mb-0 opacity-75">
                                    {{ __('messages.create_new_procedure_description') ?? 'Add a new medical procedure to the system' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="card-body p-5">
                        <form action="{{ route('procedures.store') }}" method="POST" id="procedureForm">
                            @csrf

                            <!-- Language Tabs Navigation -->
                            <div class="language-tabs mb-4">
                                <div class="nav nav-pills nav-fill bg-light rounded-3 p-2" role="tablist">
                                    <button class="nav-link active d-flex align-items-center justify-content-center"
                                        data-bs-toggle="pill" data-bs-target="#english-tab" type="button">
                                        <i class="fas fa-language me-2"></i>
                                        {{ __('messages.english') ?? 'English' }}
                                    </button>
                                    <button class="nav-link d-flex align-items-center justify-content-center"
                                        data-bs-toggle="pill" data-bs-target="#arabic-tab" type="button">
                                        <i class="fas fa-language me-2"></i>
                                        {{ __('messages.arabic') ?? 'Arabic' }}
                                    </button>
                                </div>
                            </div>

                            <div class="tab-content">
                                <!-- English Tab -->
                                <div class="tab-pane fade show active" id="english-tab">
                                    <div class="form-section mb-5">
                                        <h5 class="section-title mb-4">
                                            <i class="fas fa-text-width me-2 text-primary"></i>
                                            {{ __('messages.english_details') ?? 'English Information' }}
                                        </h5>

                                        <div class="form-floating mb-4">
                                            <input type="text"
                                                class="form-control @error('name_en') is-invalid @enderror" id="name_en"
                                                name="name_en" value="{{ old('name_en') }}"
                                                placeholder="{{ __('messages.name_en') }}" required>
                                            <label for="name_en" class="fw-medium">
                                                <i class="fas fa-tag me-2 text-muted"></i>
                                                {{ __('messages.name_en') }}
                                            </label>
                                            @error('name_en')
                                                <div class="invalid-feedback d-block mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en"
                                                placeholder="{{ __('messages.description_en') }}" style="height: 120px;" required>{{ old('description_en') }}</textarea>
                                            <label for="description_en" class="fw-medium">
                                                <i class="fas fa-align-left me-2 text-muted"></i>
                                                {{ __('messages.description_en') }}
                                            </label>
                                            @error('description_en')
                                                <div class="invalid-feedback d-block mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Arabic Tab -->
                                <div class="tab-pane fade" id="arabic-tab">
                                    <div class="form-section mb-5">
                                        <h5 class="section-title mb-4">
                                            <i class="fas fa-text-width me-2 text-primary"></i>
                                            {{ __('messages.arabic_details') ?? 'Arabic Information' }}
                                        </h5>

                                        <div class="form-floating mb-4">
                                            <input type="text"
                                                class="form-control @error('name_ar') is-invalid @enderror" id="name_ar"
                                                name="name_ar" value="{{ old('name_ar') }}"
                                                placeholder="{{ __('messages.name_ar') }}" style="direction: rtl;"
                                                required>
                                            <label for="name_ar" class="fw-medium">
                                                <i class="fas fa-tag me-2 text-muted"></i>
                                                {{ __('messages.name_ar') }}
                                            </label>
                                            @error('name_ar')
                                                <div class="invalid-feedback d-block mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-floating">
                                            <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar"
                                                placeholder="{{ __('messages.description_ar') }}" style="height: 120px; direction: rtl;" required>{{ old('description_ar') }}</textarea>
                                            <label for="description_ar" class="fw-medium">
                                                <i class="fas fa-align-left me-2 text-muted"></i>
                                                {{ __('messages.description_ar') }}
                                            </label>
                                            @error('description_ar')
                                                <div class="invalid-feedback d-block mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Section -->
                            <div class="form-section mb-5">
                                <h5 class="section-title mb-4">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>
                                    {{ __('messages.pricing') ?? 'Pricing Information' }}
                                </h5>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                id="price" name="price" value="{{ old('price') }}" step="0.01"
                                                min="0" placeholder="{{ __('messages.price') }}" required>
                                            <label for="price" class="fw-medium">
                                                <i class="fas fa-money-bill-wave me-2 text-muted"></i>
                                                {{ __('messages.price') }}
                                            </label>
                                            @error('price')
                                                <div class="invalid-feedback d-block mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="price-preview card border-0 bg-light h-100">
                                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                                <small
                                                    class="text-muted mb-1">{{ __('messages.price_preview') ?? 'Price Preview' }}</small>
                                                <div class="h5 mb-0 text-success fw-bold" id="pricePreview">$0.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 justify-content-end pt-4 border-top">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    {{ __('messages.back') ?? 'Back' }}
                                </a>
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 btn-submit">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    {{ __('messages.create') }} {{ __('messages.procedure') }}
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Tips Card -->
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-lightbulb text-warning me-2"></i>
                            {{ __('messages.creation_tips') ?? 'Quick Tips' }}
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <small
                                        class="text-muted">{{ __('messages.tip_clear_names') ?? 'Use clear and descriptive names for procedures' }}</small>
                                </div>
                                <div class="d-flex mb-2">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <small
                                        class="text-muted">{{ __('messages.tip_accurate_pricing') ?? 'Ensure pricing is accurate and up-to-date' }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex mb-2">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <small
                                        class="text-muted">{{ __('messages.tip_both_languages') ?? 'Provide information in both English and Arabic' }}</small>
                                </div>
                                <div class="d-flex">
                                    <i class="fas fa-check-circle text-success me-2 mt-1"></i>
                                    <small
                                        class="text-muted">{{ __('messages.tip_detailed_description') ?? 'Include detailed descriptions for clarity' }}</small>
                                </div>
                            </div>
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

        .form-section {
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid #0d9488;
        }

        .section-title {
            color: #2d3748;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .form-floating {
            position: relative;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.15);
        }

        .form-label {
            font-weight: 500;
            color: #4a5568;
        }

        .nav-pills .nav-link {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            color: #4a5568;
            font-weight: 500;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
            background: white;
            color: #0d9488;
            border-color: #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-pills .nav-link:not(.active):hover {
            background: rgba(13, 148, 136, 0.1);
            color: #0d9488;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
            border: none;
            font-weight: 600;
            padding: 0.75rem 2rem;
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

        .price-preview {
            transition: transform 0.2s ease;
        }

        .price-preview:hover {
            transform: scale(1.02);
        }

        .rounded-4 {
            border-radius: 16px !important;
        }

        .invalid-feedback {
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem !important;
            }

            .form-section {
                padding: 1rem;
            }

            .d-flex.justify-content-end {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price preview functionality
            const priceInput = document.getElementById('price');
            const pricePreview = document.getElementById('pricePreview');

            priceInput.addEventListener('input', function() {
                const value = parseFloat(this.value) || 0;
                pricePreview.textContent = `$${value.toFixed(2)}`;
            });

            // Form submission loading state
            const form = document.getElementById('procedureForm');
            const submitBtn = form.querySelector('.btn-submit');
            const spinner = submitBtn.querySelector('.spinner-border');

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');
            });

            // Auto-switch to Arabic tab if Arabic input is focused and there's an error
            @if ($errors->has('name_ar') || $errors->has('description_ar'))
                const arabicTab = new bootstrap.Tab(document.querySelector('[data-bs-target="#arabic-tab"]'));
                arabicTab.show();
            @endif

            // Character counters for textareas
            const textareas = ['description_en', 'description_ar'];
            textareas.forEach(id => {
                const textarea = document.getElementById(id);
                if (textarea) {
                    const counter = document.createElement('div');
                    counter.className = 'form-text text-end mt-1';
                    counter.innerHTML = `<span class="char-count">0</span> characters`;
                    textarea.parentNode.appendChild(counter);

                    textarea.addEventListener('input', function() {
                        const count = this.value.length;
                        counter.querySelector('.char-count').textContent = count;

                        if (count > 500) {
                            counter.classList.add('text-warning');
                        } else {
                            counter.classList.remove('text-warning');
                        }
                    });

                    // Trigger initial count
                    textarea.dispatchEvent(new Event('input'));
                }
            });
        });
    </script>
@endsection
