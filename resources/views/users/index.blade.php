@extends('layouts.sideBar')

@section('title')
    Users
@endsection

@section('content')
    <h2 class="text-center">Users</h2>

    <!-- Filter Dropdown Above Table -->
    <div class="text-center">
        <form action="{{ route('users.index') }}" method="GET" class="mb-3">
            <div class="form-row justify-content-center">
                <div class="col-auto">
                    <!-- Use form-control-sm and set width with inline style for smaller dropdown -->
                    <select name="role" class="form-control form-control-sm" style="width: 150px;" onchange="this.form.submit()">
                        <option value="">Select User Type</option>
                        <option value="admin" {{ request()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="owner" {{ request()->role == 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="user" {{ request()->role == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="pull-right">
        @can('user_create')
            <a class="btn btn-success" href="{{ route('users.create') }}"><i class="fas fa-plus"></i></a>
        @endcan
    </div>

    <div class="text-center pt-3">
        <table class="table border text-center">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
                    <th scope="col">phone</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            @foreach ($users as $user)
                <tbody>
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('users.show', $user['id']) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if (auth()->user()->hasRole('owner') || (auth()->user()->hasRole('admin') && !$user->hasRole('admin')))
                                @if (auth()->user()->can('user_edit'))
                                    <a class="btn btn-secondary" href="{{ route('users.edit', $user['id']) }}"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('users.resetPassword', $user['id']) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
@endsection
