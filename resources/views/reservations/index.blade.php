@extends('layouts.sideBar')

<title>{{__('messages.reservations')}}</title>

@section('content')
<div class="container">
    <h1 class='text-center'>{{__('messages.reservations')}}</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter by Today -->
    <div class="text-right mb-4 me-3">
        <form id="todayFilterForm" action="{{ route('reservations.index') }}" method="GET">
            <label for="today_filter" class="mr-2">{{ __('messages.today') }}</label>
            <input type="checkbox" name="today" id="today_filter" {{ request('today') ? 'checked' : '' }}>
            <button type="submit" class="btn btn-primary btn-sm" style="display:none;">
                {{ __('messages.apply_filter') }}
            </button>
        </form>
    </div>

    <!-- Create Button -->
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
                <th>{{__('messages.price')}}</th>
                <th>{{__('messages.status')}}</th>
                @can(['reservations_paid', 'reservations_edit', 'reservations_show', 'reservations_delete'])
                    <th>{{__('messages.actions')}}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @php
                use Carbon\Carbon;
            @endphp
            @foreach($reservations as $key => $reservation)
                <tr>
                    @if($reservation->status == App\Enums\ReservationStatus::WAITING &&  auth()->user()->can('reservations_apply'))
                        <td><a href="{{ route('reservations.applyPage', $reservation->id) }}" class="text-dark text-decoration-none">
                            {{ $key + 1 }}</a>
                        </td>
                    @else
                        <td>{{ $key + 1 }}</td>
                    @endif
                    <td>
                        <a href="{{ route('users.show', $reservation->user->id) }}" class="text-dark text-decoration-none">
                            {{ $reservation->user->localized_name }}
                        </a>
                    </td>
                    <td>{{ $reservation->reservation_number }}</td>
                    <td>{{ Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                    <td>{{ $reservation->total_price }}</td>
                    <td>{{ App\Enums\ReservationStatus::getStringValue($reservation->status) }}</td>
                    <td>
                        <!-- Edit and Delete buttons can be added here -->
                        @can('reservations_show')
                            <a href="{{route('reservations.show', $reservation->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                        @endcan
                        @if($reservation->status == App\Enums\ReservationStatus::WAITING)
                            @can('reservations_edit')
                            <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('reservations_delete')
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                         @endif
                        @if($reservation->status == App\Enums\ReservationStatus::TOPAY)
                        @can('reservations_paid')
                        <form action="{{route('reservations.paid', $reservation->id)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-credit-card"></i> </button>
                        </form>
                        @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
    // JavaScript to automatically trigger form submission when the checkbox is toggled
    document.getElementById('today_filter').addEventListener('change', function() {
        document.getElementById('todayFilterForm').submit();
    });
</script>
@endpush
