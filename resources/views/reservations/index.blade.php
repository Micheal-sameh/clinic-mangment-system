@extends('layouts.sideBar')

<title>{{__('messages.reservations')}}</title>

@section('content')
<div class="container">
    @if(request('history'))
        <h1 class='text-center'>{{__('messages.history')}}</h1>
    @else
        <h1 class='text-center'>{{__('messages.reservations')}}</h1>
    @endif
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter by Today -->
    <div class="text-right mb-4 me-3">
        <form id="todayFilterForm" action="{{ route('reservations.index') }}" method="GET">
            <div class="d-flex align-items-center mb-3">
                <label for="today_filter" class="mr-2">{{ __('messages.today') }}</label>
                <input type="checkbox" name="today" id="today_filter" {{ request('today') ? 'checked' : '' }}>
            </div>

            <div class="d-flex align-items-center mb-3">
                <label for="history_filter" class="mr-2">{{ __('messages.history') }}</label>
                <input type="checkbox" name="history" id="history_filter" {{ request('history') ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary btn-sm d-none">
                {{ __('messages.apply_filter') }}
            </button>
        </form>
    </div>
    <!-- Create Button -->
    <div class="text-right mb-4 me-3">
        @can('reservations_create')
            <a class="btn btn-success btn-lg" href="{{ route('reservations.create') }}">
                <i class="fas fa-plus"></i> {{ __('messages.create_reservation') }}
            </a>
        @endcan
    </div>


    <!-- Reservations Table for larger screens -->
    <div class="d-none d-md-block">
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>{{__('messages.number')}}</th>
                    <th>{{__('messages.patient')}}</th>
                    <th>{{__('messages.slote')}}</th>
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
                        {{-- @dd($reservation) --}}
                        @if($reservation->status == App\Enums\ReservationStatus::WAITING &&  auth()->user()->can('reservations_apply'))
                            <td><a href="{{ route('reservations.applyPage', $reservation->id) }}" class="text-decoration-none">
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
                                    <form action="{{route('reservations.cancel'), $reservation->id}}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('put')
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

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @foreach ($reservations as $key => $reservation)
            <div class="card mb-3 shadow-sm">
                <div class="card-header">
                    <h5 class="m-0">Reservation #{{ $key + 1 }}</h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $reservation->user->localized_name }}</h5>
                    <p class="card-text">
                        {{-- <strong>{{ __('messages.slate') }}:</strong> {{ $reservation->reservation_number }}<br> --}}
                        <strong>{{ __('messages.date') }}:</strong> {{ Carbon::parse($reservation->date)->format('d-m-Y') }}<br>
                        <strong>{{ __('messages.price') }}:</strong> {{ $reservation->total_price }}<br>
                        <strong>{{ __('messages.status') }}:</strong> {{ App\Enums\ReservationStatus::getStringValue($reservation->status) }}
                    </p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        @can('reservations_show')
                            <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i> </a>
                        @endcan
                    </div>
                    <div class="d-flex">
                        @can('reservations_edit')
                            <a href="#" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i> </a>
                        @endcan
                        @can('reservations_delete')
                            <form action="#" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1"> <i class="fa fa-trash"></i> </button>
                            </form>
                        @endcan
                        @if($reservation->status == App\Enums\ReservationStatus::TOPAY)
                        @can('reservations_paid')
                        <form action="{{ route('reservations.paid', $reservation->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success btn-sm mx-1"><i class="fa fa-credit-card"></i> Pay</button>
                        </form>
                        @endcan
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
<div class="text-center">
    @if($reservations->hasPages())
        <div class="pagination">
            @foreach ($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
            @endforeach
        </div>
    @endif
</div>

<div class="text-center mt-4">
    <div class="alert alert-info" role="alert">
        <strong>{{__('messages.count')}} {{__('messages.reservations')}}: </strong>{{ $reservations->total() }}
    </div>
</div>

@endsection

<style>
    <style>
    .text-right {
        text-align: right;
    }

    .d-flex {
        display: flex;
    }

    .align-items-center {
        align-items: center;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .me-3 {
        margin-right: 1rem;
    }

    .btn {
        padding: 0.5rem 1rem;
    }

    /* Optional: Style for better checkbox spacing */
    input[type="checkbox"] {
        margin-left: 5px;
        margin-right: 10px;
    }

    label {
        font-weight: 500;
    }
</style>

@push('scripts')
<script>
    // JavaScript to automatically trigger form submission when the checkbox is toggled
    document.getElementById('today_filter').addEventListener('change', function() {
        document.getElementById('todayFilterForm').submit();
    });
    document.getElementById('history_filter').addEventListener('change', function() {
        document.getElementById('todayFilterForm').submit();
    });
</script>
@endpush
