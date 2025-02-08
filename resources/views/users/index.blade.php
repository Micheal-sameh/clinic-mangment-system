@extends('layouts.sideBar')

@section('title')
    {{__('messages.users')}}
@endsection

@section('content')
    <div class="container-fluid px-0">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="display-6">{{__('messages.users')}}</h2>
            </div>
        </div>

        @if(session('message'))
            <div class="alert alert-success fixed-top w-50 mx-auto fade show" id="flashMessage" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
                {{ session('message') }}
            </div>
        @endif

        <!-- Filter Form Above Table -->
        <div class="text-center mb-4">
            <form action="{{ route('users.index') }}" method="GET" class="filter-dropdown" id="filter-form">
                <div class="form-row justify-content-center">
                    <div class="col-md-4 col-lg-3 col-xl-2 mb-3">
                        <!-- Filter by Role -->
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            </div>
                            <select name="role" class="form-control form-control-sm" style="height: 40px; border-radius: 10px;" onchange="submitForm()">
                                <option value="">Select User Type</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request()->role == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 col-xl-2 mb-3">
                        <!-- Filter by Name -->
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Search by Name" value="{{ request()->name }}" style="height: 40px; border-radius: 10px;" id="name-input">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Action Button to Create a User -->
        <div class="text-right mb-3">
            @can('user_create')
                <a class="btn btn-success btn-lg" href="{{ route('users.create') }}">
                    <i class="fas fa-plus"></i> Add New User
                </a>
            @endcan
        </div>

        <!-- Users List in Card View for Mobile -->
        <div class="d-none d-md-block">
            <!-- Table View for larger screens -->
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">{{__('messages.number')}}</th>
                            <th scope="col">{{__('messages.name')}}</th>
                            <th scope="col">{{__('messages.status')}}</th>
                            <th scope="col">{{__('messages.email')}}</th>
                            <th scope="col">{{__('messages.phone')}}</th>
                            <th scope="col">{{__('messages.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr class="table-row">
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>
                                    @can('users_show')
                                        <a class="nav-item" href="{{ route('users.show', $user['id']) }}" style="text-decoration: none;">
                                            {{$user->localized_name}}
                                    @else
                                        {{$user->localized_name}}
                                    @endcan
                                    </a>
                                </td>

                                <td>
                                    <form action="{{ route('users.changeStatus', $user->id) }}" method="post">
                                        @csrf
                                        @method('put')

                                            @if ($user->status == App\Enums\UserStatus::ACTIVE)
                                                <button class="btn btn-warning" type="submit">
                                                    <i class="fa fa-thumbs-up"></i> {{ App\Enums\UserStatus::getStringValue($user->status) }}
                                                </button>
                                            @else
                                                <button class="btn btn-danger" type="submit">
                                                    <i class="fa fa-thumbs-down"></i> {{ App\Enums\UserStatus::getStringValue($user->status) }}
                                                </button>
                                            @endif
                                    </form>
                                </td>                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td class="d-flex justify-content-center">
                                    @if (auth()->user()->hasRole('owner') || (auth()->user()->hasRole('admin') && !$user->hasRole('admin') && !$user->hasRole('owner')))
                                        @if (auth()->user()->can('users_edit'))
                                            <a class="btn btn-secondary btn-sm mx-1" href="{{ route('users.edit', $user['id']) }}" data-toggle="tooltip" data-placement="top" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('users.resetPassword', $user['id']) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-warning btn-sm mx-1" data-toggle="tooltip" data-placement="top" title="Reset Password">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="d-md-none">
            @foreach ($users as $key => $user)
                <div class="card mb-3 shadow-sm">
                    <div class="card-header">
                       <h5 class="card-title">{{ $user->localized_name }}</h5>
                    </div>
                    <div class="card-body">

                        <p class="card-text">
                            <strong>{{ __('messages.status') }}:</strong> {{  App\Enums\UserStatus::getStringValue($user->status) }}<br>
                            <strong>{{ __('messages.email') }}:</strong> {{ $user->email }}<br>
                            <strong>{{ __('messages.phone') }}:</strong> {{ $user->phone }}
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                            @can('users_show')
                                <a href="{{ route('users.show', $user['id']) }}" class="btn btn-primary btn-sm"> <i class="fas fa-eye"></i></a>
                            @endcan
                        </div>
                        <div class="d-flex">
                            @can('users_edit')
                                <a href="{{ route('users.edit', $user['id']) }}" class="btn btn-secondary btn-sm mx-1"> <i class="fas fa-edit"></i></a>
                            @endcan
                            @can('users_reset_pass')
                                <form action="{{ route('users.resetPassword', $user['id']) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button class="btn btn-warning btn-sm mx-1" type="submit">Reset Password</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center">
            @if($users->hasPages())
                <div class="pagination">
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Count of Users Displayed -->
        <div class="text-center mt-4">
            <div class="alert alert-info" role="alert">
                <strong>{{__('messages.count')}} {{__('messages.users')}}: </strong>{{ $users->total() }}
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Set a beautiful background gradient */
            body {
                background: linear-gradient(135deg, #72c6f5, #b9e4f3);
                font-family: 'Roboto', sans-serif;
                overflow-x: hidden; /* Disable horizontal scrolling */
            }

            /* Add a soft shadow to tables */
            table {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                width: 100%; /* Make sure table takes full width */
            }

            /* Add hover effect to table rows */
            tr.table-row:hover {
                background-color: #f1f1f1;
                cursor: pointer;
            }

            /* Mobile view styling */
            .card-body {
                padding: 15px;
            }

            .card-footer {
                padding: 10px 15px;
            }

            /* Ensure the filter form is responsive */
            @media (max-width: 768px) {
                .filter-dropdown .form-row {
                    flex-direction: column;
                }

                .filter-dropdown .form-row .col-md-4 {
                    width: 100%;
                }

                .table-responsive {
                    overflow-x: auto;
                }
            }

            /* Mobile Card View */
            .d-md-none {
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }

            .d-md-none .card {
                width: 10%; /* Ensure card takes full width */
                margin: 0; /* Remove any margin to make the card span the entire screen */
                border-radius: 0; /* Optional: remove any rounded corners for full-width effect */
            }
        </style>
    @endpush

    @push('scripts')
    <script>
        let typingTimer; // Timer identifier
        const doneTypingInterval = 1000; // 1 second delay

        const nameInput = document.getElementById('name-input');

        // Event listener for the search input
        nameInput.addEventListener('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(submitForm, doneTypingInterval);
        });

        // Function to submit the form
        function submitForm() {
            document.getElementById('filter-form').submit();
        }

        // Enable tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @endpush
@endsection
