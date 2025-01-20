@extends('layouts.sideBar')

@section('title')
    {{ $user->localized_name }}
@endsection

@section('content')

<div class="container pt-5 pt-md-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- User Details Card -->
            <div class="card shadow-sm border-light rounded mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $user->localized_name }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong>{{__('messages.email')}}:</strong>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong>{{__('messages.phone')}}:</strong>
                                <p class="text-muted">{{ $user->phone }}</p>
                            </div>
                        </div>
                    </div>

                    @if($user->age)
                    <div class="mb-3">
                        <strong>{{__('messages.age')}}:</strong>
                        <p class="text-muted">{{ $user->age }}</p>
                    </div>
                    @endif

                    {{-- <div class="mb-3">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_users') }}
                        </a>
                    </div> --}}
                </div>
            </div>

            <!-- Past Visits Card -->
            <div class="card shadow-sm border-light rounded mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"> {{__('messages.no_past_visits')}}</h5>
                </div>
                <div class="card-body">
                    @if($user->visits && $user->visits->isNotEmpty())
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.location') }}</th>
                                <th>{{ __('messages.notes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->visits as $visit)
                            <tr>
                                <td>{{ $visit->created_at->format('d M, Y') }}</td>
                                <td>{{ $visit->location }}</td>
                                <td>{{ $visit->notes }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">{{ __('messages.no_past_visits') }}</p>
                    @endif
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="card shadow-sm border-light rounded mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">{{ __('messages.change_password') }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.password.update', $user->id) }}">
                        @csrf
                        @method('PUT') <!-- Ensure PUT method for updating -->

                        <div class="form-group">
                            <label for="current_password">{{ __('messages.current_password') }}</label>
                            <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">{{ __('messages.new_password') }}</label>
                            <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">{{ __('messages.confirm_password') }}</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning mt-3">{{ __('messages.change_password') }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
