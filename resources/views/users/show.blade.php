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
                            <i class="fas fa-arrow-left"></i> Back to Users
                        </a>
                    </div> --}}
                </div>
            </div>

            <!-- Past Visits Card -->
            <div class="card shadow-sm border-light rounded">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Past Visits</h5>
                </div>
                <div class="card-body">
                    @if($reservations && !is_null($reservations))
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th>{{__('messages.number')}}</th>
                                <th>{{__('messages.date')}}</th>
                                <th>{{__('messages.price')}}</th>
                                {{-- <th>Notes</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $key => $reservation)
                            <tr>
                                <td> <a href="{{ route('reservations.show', $reservation->id) }}" style="text-decoration: none; color: black;">
                                    {{ $key + 1 }}
                                </a></td>
                                <td>{{ \Carbon\Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                                <td>{{ $reservation->total_price }}</td>
                                {{-- <td>{{ $reservation->notes }}</td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">No past visits available for this user.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
