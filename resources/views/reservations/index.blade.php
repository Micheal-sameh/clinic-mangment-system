@extends('layouts.sideBar')

<title> {{__('messages.reservations')}}</title>

@section('content')
<div class="container">
    <h1 class='text-center'>{{__('messages.reservations')}}</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="text-right mb-4 me-3">
        @can('reservations_create')
            <a class="btn btn-success btn-lg" href="{{ route('reservations.create') }}">
                <i class="fas fa-plus"></i>
            </a>
        @endcan
    </div>
    <!-- Reservations Table -->
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>{{__('messages.number')}}</th>
                <th>{{__('messages.patient')}}</th>
                <th>{{__('messages.slate')}}</th>
                <th>{{__('messages.date')}}</th>
                <th>{{__('messages.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;
            @endphp
            @foreach($reservations as $key => $reservation)
                <tr>
                    <td><a href="{{ route('reservations.apply', $reservation->id) }}" class="text-dark text-decoration-none">
                        {{ $key + 1 }}</a>
                    </td>
                    <td>
                        <a href="{{ route('users.show', $reservation->user->id) }}" class="text-dark text-decoration-none">
                            {{ $reservation->user->localized_name }}
                        </a>
                    </td>
                    <td>{{ $reservation->reservation_number }}</td>
                    <td>{{ Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                    <td>
                        <!-- Edit and Delete buttons can be added here -->
                         <a href="{{route('reservations.show', $reservation->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                         <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
