@extends('layouts.sideBar')

@section('title')
    {{__('messages.users')}}
@endsection

@section('content')
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
                <div class="row">
                    <div class="col-md-3 col-lg-2 mb-3">
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

                    <div class="col-md-3 col-lg-2 mb-3">
                        <!-- Filter by Name -->
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Search by Name" value="{{ request()->name }}" style="height: 40px; border-radius: 10px;" id="name-input">
                        </div>
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

    <!-- Users Table -->
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

                        <td>{{ $user->status }}</td>
                        <td>{{ $user->email }}</td>
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

    <!-- Count of Users Displayed -->
    <div class="text-center mt-4">
        <div class="alert alert-info" role="alert">
            <strong>{{__('messages.count')}} {{__('messages.users')}}: </strong>{{ $users->count() }}
        </div>
    </div>

    @push('styles')
        <style>
            /* Set a beautiful background gradient */
            body {
                background: linear-gradient(135deg, #72c6f5, #b9e4f3);
                font-family: 'Roboto', sans-serif;
            }

            /* Add a soft shadow to tables */
            table {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            /* Add hover effect to table rows */
            tr.table-row:hover {
                background-color: #f1f1f1;
                cursor: pointer;
            }

            /* Input fields and buttons styling */
            .form-control-sm {
                border-radius: 10px;
            }

            .btn {
                transition: all 0.3s ease;
            }

            .btn:hover {
                transform: scale(1.05);
            }

            /* Tooltip styling */
            .tooltip-inner {
                background-color: #333;
                color: rgb(181, 176, 176);
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
