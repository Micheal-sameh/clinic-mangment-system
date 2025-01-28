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
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong>{{__('messages.age')}}:</strong>
                                <p class="text-muted">{{ $user->age }}</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <strong>{{__('messages.reservations')}}:</strong>
                                <p class="text-muted">{{ $reservationsCount }}</p>
                            </div>
                        </div>
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
            @if(!auth()->user()->hasRole('admin') && $reservationsCount > 0)
            <div class="card shadow-sm border-light rounded mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">{{__('messages.upcoming_reservations')}}</h5>
                </div>
                <div class="card-body">
                    @if($reservations && !is_null($reservations))
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>{{ __('messages.number') }}</th>
                                <th>{{ __('messages.date') }}</th>
                                <th>{{ __('messages.slate') }}</th>
                                <th>{{ __('messages.price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $key => $reservation)
                            <tr>
                                <td> <a href="{{ route('reservations.show', $reservation->id) }}" style="text-decoration: none; color: black;">
                                    {{ $key + 1 }}
                                </a></td>
                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                                <td>{{ $reservation->reservation_number }}</td>
                                <td>{{ $reservation->total_price }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">{{ __('messages.no_upcoming_visits') }}</p>
                    @endif
                </div>
            </div>
            @endif

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
