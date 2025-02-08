@extends('layouts.sideBar')
<title> {{__('messages.reports')}} </title>
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">{{__('messages.monthly_report')}}</h1>

    <div class="row">
        <!-- Today's Analytics Section -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"> {{__("messages.Today's Analytics")}} </h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{__("messages.New Customers Today")}}:</strong>
                            <span class="badge bg-info rounded-pill" data-bs-toggle="tooltip" title="New customers added today">{{ $newUsersToday }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{__('messages.Income Today')}}:</strong>
                            <span class="badge bg-warning rounded-pill" data-bs-toggle="tooltip" title="Income generated today">{{ number_format($incomeToday, 2) }} EGP</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{__('messages.reservations Today')}}:</strong>
                            <span class="badge bg-success rounded-pill" data-bs-toggle="tooltip" title="Total orders placed today">{{ $reservationsToday }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Customers Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Customers</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>This Month:</strong>
                            <span class="badge bg-primary rounded-pill" data-bs-toggle="tooltip" title="Total customers this month">{{ $usersThisMonth }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Last Month:</strong>
                            <span class="badge bg-secondary rounded-pill" data-bs-toggle="tooltip" title="Total customers last month">{{ $usersLastMonth }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>All Time:</strong>
                            <span class="badge bg-success rounded-pill" data-bs-toggle="tooltip" title="Total customers since inception">{{ $usersAllTime }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Income Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Income</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>This Month:</strong>
                            <span class="badge bg-primary rounded-pill" data-bs-toggle="tooltip" title="Income this month">{{ number_format($incomeThisMonth, 2) }} EGP</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Last Month:</strong>
                            <span class="badge bg-secondary rounded-pill" data-bs-toggle="tooltip" title="Income last month">{{ number_format($incomeLastMonth, 2) }} EGP</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>All Time:</strong>
                            <span class="badge bg-success rounded-pill" data-bs-toggle="tooltip" title="Total income over all time">{{ number_format($incomeAllTime, 2) }} EGP</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- New Customers Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">New Customers</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Today:</strong>
                            <span class="badge bg-info rounded-pill" data-bs-toggle="tooltip" title="New customers added today">{{ $newUsersToday }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics Table -->
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Detailed Statistics</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Last Month</th>
                                <th>This Month</th>
                                <th>All Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Customers</td>
                                <td>{{ $usersLastMonth }}</td>
                                <td>{{ $usersThisMonth }}</td>
                                <td>{{ $usersAllTime }}</td>
                            </tr>
                            <tr>
                                <td>Income</td>
                                <td>{{ number_format($incomeLastMonth, 2) }} EGP</td>
                                <td>{{ number_format($incomeThisMonth, 2) }} EGP</td>
                                <td>{{ number_format($incomeAllTime, 2) }} EGP</td>
                            </tr>
                            <tr>
                                <td>reservations</td>
                                <td>{{ $newUsersToday }}</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Graph Section -->
    <div class="row mt-5">
        <!-- Customers Growth Graph -->
        <div class="col-md-6">
            <h4>Customers Growth</h4>
            <canvas id="customersChart" height="150"></canvas>
        </div>

        <!-- Income Growth Graph -->
        <div class="col-md-6">
            <h4>Income Growth</h4>
            <canvas id="incomeChart" height="150"></canvas>
        </div>
    </div>

</div>

<script>
    // Customers Growth Chart
    const customersCtx = document.getElementById('customersChart').getContext('2d');
    const customersChart = new Chart(customersCtx, {
        type: 'line',
        data: {
            labels: ['Last Month', 'This Month', 'All Time'],
            datasets: [{
                label: 'Number of Customers',
                data: [{{ $usersLastMonth }}, {{ $usersThisMonth }}, {{ $usersAllTime }}],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw.toLocaleString();
                        }
                    }
                },
                legend: {
                    position: 'top',
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time Period'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Customers Count'
                    },
                    beginAtZero: true
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
                data: [{{ $incomeLastMonth }}, {{ $incomeThisMonth }}, {{ $incomeAllTime }}],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw.toLocaleString() + ' EGP';
                        }
                    }
                },
                legend: {
                    position: 'top',
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time Period'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Income in EGP'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
