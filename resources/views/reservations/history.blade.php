@extends('layouts.sideBar')

<title> {{__('messages.reservations')}}</title>

@section('content')
<div class="container">
    <h1 class='text-center'>{{__('messages.history')}}</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Reservations Table -->
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>{{__('messages.number')}}</th>
                <th>{{__('messages.patient')}}</th>
                <th>{{__('messages.date')}}</th>
                <th>{{__('messages.price')}}</th>
                <th>{{__('messages.status')}}</th>
                <th>{{__('messages.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;
            @endphp
            @foreach($reservations as $key => $reservation)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <a href="{{ route('users.show', $reservation->user->id) }}" class="text-dark text-decoration-none">
                            {{ $reservation->user->localized_name }}
                        </a>
                    </td>
                    <td>{{ Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                    <td>{{ $reservation->total_price }}</td>
                    <td>{{ App\Enums\ReservationStatus::getStringValue($reservation->status) }}</td>
                    <td>
                        <!-- Edit and Delete buttons can be added here -->
                         <a href="{{route('reservations.show', $reservation->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
