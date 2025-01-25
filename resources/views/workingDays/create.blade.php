@extends('layouts.sideBar')

@section('title')
    {{ __('messages.create') }} {{ __('messages.working_days') }}
@endsection

@section('content')
<div class="container">
    <h1 class="text-center mb-4"> {{__('messages.create')}} {{__('messages.working_days')}} </h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to Add Working Days -->
    <form action="{{ route('working-days.store') }}" method="POST">
        @csrf
        <div id="working-days-container">
            <div class="working-day-row">
                <div class="form-group col-3">
                    <label for="date" class="font-weight-bold">{{__('messages.date')}}</label>
                    <input type="date" name="working_days[0][date]" class="form-control custom-date-input" value="{{ old('working_days.0.date') }}" required>
                    <!-- Display error message for 'date' -->
                    @if($errors->has('working_days.0.date'))
                        <small class="text-danger">{{ $errors->first('working_days.0.date') }}</small>
                    @endif
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="from_time" class="font-weight-bold">{{__('messages.from')}}</label>
                        <input type="time" name="working_days[0][from]" class="form-control" value="{{ old('working_days.0.from') }}" required>
                        <!-- Display error message for 'from' -->
                        @if($errors->has('working_days.0.from'))
                            <small class="text-danger">{{ $errors->first('working_days.0.from') }}</small>
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="to_time" class="font-weight-bold">{{__('messages.to')}}</label>
                        <input type="time" name="working_days[0][to]" class="form-control" value="{{ old('working_days.0.to') }}" required>
                        <!-- Display error message for 'to' -->
                        @if($errors->has('working_days.0.to'))
                            <small class="text-danger">{{ $errors->first('working_days.0.to') }}</small>
                        @endif
                    </div>
                </div>
                <!-- Separator (Horizontal Line) -->
                <hr class="separator">
            </div>
        </div>

        <div class="form-group">
            <button type="button" id="add-day" class="btn btn-secondary btn-lg mt-3">{{__('messages.Add Another Working Day')}}</button>
            <button type="submit" class="btn btn-primary btn-lg mt-3">{{__('messages.create')}}</button>
        </div>
    </form>
</div>

@endsection

@push('styles')
<style>
    /* Custom style to reduce the size of the date input */
    .custom-date-input {
        width: 120px;
        font-size: 14px;
    }

    /* Styling for the working day row */
    .working-day-row {
        margin-bottom: 30px;
    }

    /* Style for the separator line */
    .separator {
        border-top: 2px solid #007bff; /* Blue separator line */
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .form-row {
        margin-top: 15px;
    }

    /* Styling for error message text */
    small.text-danger {
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let dayCount = 1; // Track the number of working day rows

        document.getElementById('add-day').addEventListener('click', function () {
            // Create a new row for an additional working day
            const newRow = document.createElement('div');
            newRow.classList.add('working-day-row');

            newRow.innerHTML = `
                <div class="form-group col-3">
                    <label for="date" class="font-weight-bold">{{__('messages.date')}}</label>
                    <input type="date" name="working_days[${dayCount}][date]" class="form-control custom-date-input" required>
                    <!-- Display error message for 'date' dynamically -->
                    <small class="text-danger" id="error-date-${dayCount}"></small>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="from_time" class="font-weight-bold">{{__('messages.from')}}</label>
                        <input type="time" name="working_days[${dayCount}][from]" class="form-control" required>
                        <!-- Display error message for 'from' dynamically -->
                        <small class="text-danger" id="error-from-${dayCount}"></small>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="to_time" class="font-weight-bold">{{__('messages.to')}}</label>
                        <input type="time" name="working_days[${dayCount}][to]" class="form-control" required>
                        <!-- Display error message for 'to' dynamically -->
                        <small class="text-danger" id="error-to-${dayCount}"></small>
                    </div>
                </div>
                <!-- Separator (Horizontal Line) -->
                <hr class="separator">
            `;

            // Append the new row to the container
            document.getElementById('working-days-container').appendChild(newRow);
            dayCount++;
        });
    });
</script>
@endpush
