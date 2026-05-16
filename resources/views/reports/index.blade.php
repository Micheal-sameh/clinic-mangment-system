@extends('layouts.sideBar')
<title>{{ __('messages.reports') }}</title>
@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h2 mb-2 text-gray-800">{{ __('messages.monthly_report') }}</h1>
                        <p class="text-muted mb-0">
                            {{ __('messages.business_insights') ?? 'Comprehensive business analytics and performance metrics' }}
                        </p>
                    </div>
                    <div class="date-badge bg-primary text-white rounded-pill px-3 py-2">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{ now()->format('F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Analytics Cards -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-gradient-primary text-white py-3 rounded-top-4">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>
                            {{ __('messages.today_analytics') ?? "Today's Performance" }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div
                                    class="stat-card bg-info bg-opacity-10 border-start border-info border-4 rounded-end p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-info text-white rounded-3 p-3 me-3">
                                            <i class="fas fa-user-plus fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">
                                                {{ __('messages.new_customers_today') ?? 'New Customers' }}</h6>
                                            <h3 class="mb-0 text-info">{{ $newUsersToday }}</h3>
                                            <small class="text-muted">{{ __('messages.today') ?? 'Today' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="stat-card bg-warning bg-opacity-10 border-start border-warning border-4 rounded-end p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-warning text-white rounded-3 p-3 me-3">
                                            <i class="fas fa-money-bill-wave fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">
                                                {{ __('messages.income_today') ?? "Today's Income" }}</h6>
                                            <h3 class="mb-0 text-warning">{{ number_format($incomeToday, 2) }} EGP</h3>
                                            <small class="text-muted">{{ __('messages.today') ?? 'Today' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="stat-card bg-success bg-opacity-10 border-start border-success border-4 rounded-end p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon bg-success text-white rounded-3 p-3 me-3">
                                            <i class="fas fa-calendar-check fa-lg"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">
                                                {{ __('messages.reservations_today') ?? "Today's Reservations" }}</h6>
                                            <h3 class="mb-0 text-success">{{ $reservationsToday }}</h3>
                                            <small class="text-muted">{{ __('messages.today') ?? 'Today' }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Metrics Section -->
        <div class="row g-4 mb-4">
            <!-- Customers Card -->
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users text-primary me-2"></i>
                            {{ __('messages.customers') ?? 'Customers' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="metrics-list">
                            <div class="metric-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="metric-indicator bg-primary rounded-circle me-3"></div>
                                    <span class="fw-medium">{{ __('messages.this_month') ?? 'This Month' }}</span>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-6">{{ $usersThisMonth }}</span>
                            </div>
                            <div class="metric-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="metric-indicator bg-secondary rounded-circle me-3"></div>
                                    <span class="fw-medium">{{ __('messages.last_month') ?? 'Last Month' }}</span>
                                </div>
                                <span
                                    class="badge bg-secondary bg-opacity-10 text-secondary fs-6">{{ $usersLastMonth }}</span>
                            </div>
                            <div class="metric-item d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center">
                                    <div class="metric-indicator bg-success rounded-circle me-3"></div>
                                    <span class="fw-medium">{{ __('messages.all_time') ?? 'All Time' }}</span>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success fs-6">{{ $usersAllTime }}</span>
                            </div>
                        </div>

                        <!-- Growth Indicator -->
                        @php
                            $customerGrowth =
                                $usersLastMonth > 0 ? (($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100 : 0;
                        @endphp
                        <div class="growth-indicator mt-3 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-medium">{{ __('messages.monthly_growth') ?? 'Monthly Growth' }}</span>
                                <span class="badge {{ $customerGrowth >= 0 ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas fa-{{ $customerGrowth >= 0 ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                    {{ number_format(abs($customerGrowth), 1) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Income Card -->
            <div class="col-xl-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar text-success me-2"></i>
                            {{ __('messages.income') ?? 'Income' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="metrics-list">
                            <div class="metric-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="metric-indicator bg-primary rounded-circle me-3"></div>
                                    <span class="fw-medium">{{ __('messages.this_month') ?? 'This Month' }}</span>
                                </div>
                                <span
                                    class="badge bg-primary bg-opacity-10 text-primary fs-6">{{ number_format($incomeThisMonth, 2) }}
                                    EGP</span>
                            </div>
                            <div class="metric-item d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="metric-indicator bg-secondary rounded-circle me-3"></div>
                                    <span class="fw-medium">{{ __('messages.last_month') ?? 'Last Month' }}</span>
                                </div>
                                <span
                                    class="badge bg-secondary bg-opacity-10 text-secondary fs-6">{{ number_format($incomeLastMonth, 2) }}
                                    EGP</span>
                            </div>
                            <div class="metric-item d-flex justify-content-between align-items-center py-2">
                                <div class="d-flex align-items-center">
                                    <div class="metric-indicator bg-success rounded-circle me-3"></div>
                                    <span class="fw-medium">{{ __('messages.all_time') ?? 'All Time' }}</span>
                                </div>
                                <span
                                    class="badge bg-success bg-opacity-10 text-success fs-6">{{ number_format($incomeAllTime, 2) }}
                                    EGP</span>
                            </div>
                        </div>

                        <!-- Growth Indicator -->
                        @php
                            $incomeGrowth =
                                $incomeLastMonth > 0
                                    ? (($incomeThisMonth - $incomeLastMonth) / $incomeLastMonth) * 100
                                    : 0;
                        @endphp
                        <div class="growth-indicator mt-3 p-3 bg-light rounded-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-medium">{{ __('messages.monthly_growth') ?? 'Monthly Growth' }}</span>
                                <span class="badge {{ $incomeGrowth >= 0 ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas fa-{{ $incomeGrowth >= 0 ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                    {{ number_format(abs($incomeGrowth), 1) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Summary -->
            <div class="col-xl-4 col-md-12">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tachometer-alt text-warning me-2"></i>
                            {{ __('messages.performance_summary') ?? 'Performance Summary' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="performance-stats">
                            <div class="performance-item text-center p-3">
                                <div class="performance-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 mx-auto mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="fas fa-user-clock fa-2x"></i>
                                </div>
                                <h4 class="text-primary mb-1">{{ $newUsersToday }}</h4>
                                <p class="text-muted mb-0">
                                    {{ __('messages.new_customers_today') ?? 'New Customers Today' }}</p>
                            </div>

                            <div class="performance-breakdown mt-4">
                                <h6 class="fw-bold mb-3">{{ __('messages.quick_stats') ?? 'Quick Stats' }}</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="stat-box text-center p-2 bg-light rounded-3">
                                            <small
                                                class="text-muted d-block">{{ __('messages.avg_daily_income') ?? 'Avg. Daily Income' }}</small>
                                            <strong class="text-success">{{ number_format($incomeToday, 2) }} EGP</strong>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box text-center p-2 bg-light rounded-3">
                                            <small
                                                class="text-muted d-block">{{ __('messages.daily_reservations') ?? 'Daily Reservations' }}</small>
                                            <strong class="text-info">{{ $reservationsToday }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-trend text-primary me-2"></i>
                            {{ __('messages.customers_growth') ?? 'Customers Growth' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="customersChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-money-bill-trend text-success me-2"></i>
                            {{ __('messages.income_growth') ?? 'Income Growth' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="incomeChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-table text-info me-2"></i>
                            {{ __('messages.detailed_statistics') ?? 'Detailed Statistics' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('messages.metric') ?? 'Metric' }}</th>
                                        <th class="text-end">{{ __('messages.last_month') ?? 'Last Month' }}</th>
                                        <th class="text-end">{{ __('messages.this_month') ?? 'This Month' }}</th>
                                        <th class="text-end">{{ __('messages.all_time') ?? 'All Time' }}</th>
                                        <th class="text-center">{{ __('messages.growth') ?? 'Growth' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold">{{ __('messages.customers') ?? 'Customers' }}</td>
                                        <td class="text-end">{{ $usersLastMonth }}</td>
                                        <td class="text-end">{{ $usersThisMonth }}</td>
                                        <td class="text-end">{{ $usersAllTime }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $customerGrowth >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($customerGrowth, 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">{{ __('messages.income') ?? 'Income' }}</td>
                                        <td class="text-end">{{ number_format($incomeLastMonth, 2) }} EGP</td>
                                        <td class="text-end">{{ number_format($incomeThisMonth, 2) }} EGP</td>
                                        <td class="text-end">{{ number_format($incomeAllTime, 2) }} EGP</td>
                                        <td class="text-center">
                                            <span class="badge {{ $incomeGrowth >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ number_format($incomeGrowth, 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">
                                            {{ __('messages.daily_reservations') ?? 'Daily Reservations' }}</td>
                                        <td class="text-end">-</td>
                                        <td class="text-end">{{ $reservationsToday }}</td>
                                        <td class="text-end">-</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">-</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .metric-indicator {
            width: 12px;
            height: 12px;
        }

        .metrics-list .metric-item {
            transition: background-color 0.2s ease;
        }

        .metrics-list .metric-item:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .performance-icon {
            transition: transform 0.3s ease;
        }

        .performance-item:hover .performance-icon {
            transform: scale(1.1);
        }

        .stat-box {
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
            transform: translateY(-2px);
        }

        .date-badge {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .rounded-4 {
            border-radius: 16px !important;
        }

        .rounded-top-4 {
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .stat-icon {
                width: 50px;
                height: 50px;
            }

            .performance-icon {
                width: 60px !important;
                height: 60px !important;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Customers Growth Chart
            const customersCtx = document.getElementById('customersChart').getContext('2d');
            const customersChart = new Chart(customersCtx, {
                type: 'line',
                data: {
                    labels: ['Last Month', 'This Month', 'All Time'],
                    datasets: [{
                        label: 'Number of Customers',
                        data: [{{ $usersLastMonth }}, {{ $usersThisMonth }},
                            {{ $usersAllTime }}],
                        borderColor: 'rgba(13, 148, 136, 1)',
                        backgroundColor: 'rgba(13, 148, 136, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgba(13, 148, 136, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw.toLocaleString();
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Income Growth Chart
            const incomeCtx = document.getElementById('incomeChart').getContext('2d');
            const incomeChart = new Chart(incomeCtx, {
                type: 'bar',
                data: {
                    labels: ['Last Month', 'This Month', 'All Time'],
                    datasets: [{
                        label: 'Income in EGP',
                        data: [{{ $incomeLastMonth }}, {{ $incomeThisMonth }},
                            {{ $incomeAllTime }}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw.toLocaleString() +
                                        ' EGP';
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                },
                                callback: function(value) {
                                    return value.toLocaleString() + ' EGP';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
