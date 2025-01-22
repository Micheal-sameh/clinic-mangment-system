@extends('layouts.sideBar')
<title> {{$reservation->user->localized_name}} </title>
@section('content')
<div class="container col-lg-6 col-md-8 col-sm-12 mt-5">
    <h1 class="text-center text-primary mb-5">{{ __('messages.reservation_details') }}</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Reservation Details -->
    <div class="card shadow-sm border-0 rounded" style="background-color: #f3f4f6;">
        <div class="card-header text-white" style="background-color: #3498db;">
            <h5 class="m-0">Reservation #{{ $reservation->reservation_number }}</h5>
        </div>
        <div class="card-body">
            <h5 class="card-title text-dark" style="font-size: 1.25rem;">{{ __('messages.patient') }}:
                <span class="text-success">{{ $reservation->user->localized_name }}</span>
            </h5>
            <p class="card-text">
                <strong class="text-info">{{ __('messages.date') }}:</strong>
                <span class="text-dark">{{ \Carbon\Carbon::parse($reservation->date)->format('d-m-Y') }}</span> <br>
                <strong class="text-info">{{ __('messages.slate') }}:</strong>
                <span class="text-dark">{{ $reservation->reservation_number }}</span> <br>
                <strong class="text-info">{{ __('messages.price') }}:</strong>
                <span class="text-dark">{{ $reservation->total_price }}</span> <br>
            </p>

            <!-- Procedures Section -->
            <div class="mt-4">
                <h5 class="text-dark">{{ __('messages.select')}} {{__('messages.procedures') }}:</h5>
                <form action="{{ route('reservations_pro.store') }}" method="POST">
                    @csrf
                    <div class="form-check">
                        <input class="form-check-input" type="hidden" value="{{$reservation->id}}" name="reservation_id" id="reservation_id">
                        @foreach($procedures as $procedure)
                            <input class="form-check-input" type="checkbox" value="{{ $procedure->id }}" id="procedure_{{ $procedure->id }}"
                            name="procedures[]"
                            {{ in_array($procedure->id, $reservation->reservationProcedures->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label" for="procedure_{{ $procedure->id }}">
                                {{ $procedure->localized_name }}
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">{{ __('messages.save')}} {{__('messages.procedures') }}</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-center" style="background-color: #ecf0f1;">
            <small class="text-muted">{{ __('messages.updated_at') }}:
                {{ \Carbon\Carbon::parse($reservation->updated_at)->diffForHumans() }}
            </small>
        </div>
    </div>
</div>
@endsection
