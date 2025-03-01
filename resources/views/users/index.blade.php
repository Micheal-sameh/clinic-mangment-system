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
        <div class="alert alert-success fixed-top w-50 mx-auto" id="flashMessage" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
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
                        <select name="role" class="form-control form-control-sm" style="height: 35px;" onchange="submitForm()">
                            <option value="">Select User Type</option>
                            <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="owner" {{ request()->role == 'owner' ? 'selected' : '' }}>Owner</option>
                            <option value="patient" {{ request()->role == 'patient' ? 'selected' : '' }}>patient</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-lg-2 mb-3">
                        <!-- Filter by Name -->
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Search by Name" value="{{ request()->name }}" style="height: 35px;" id="name-input">
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
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        {{-- <td>{{ $user->name }}</td> --}}
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
                            {{-- <a class="btn btn-info btn-sm mx-1" href="{{ route('users.show', $user['id']) }}">
                                <i class="fas fa-eye"></i>
                            </a> --}}
                            @if (auth()->user()->hasRole('owner') || (auth()->user()->hasRole('admin') && !$user->hasRole('admin') && !$user->hasRole('owner')))
                                @if (auth()->user()->can('users_edit'))
                                    <a class="btn btn-secondary btn-sm mx-1" href="{{ route('users.edit', $user['id']) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.resetPassword', $user['id']) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button class="btn btn-warning btn-sm mx-1">
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
    </script>
    @endpush
@endsection
