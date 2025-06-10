@extends('layouts.sideBar')

@section('title')
    {{ __('messages.working_days') }}
@endsection

@section('content')
    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger w-75 mx-auto">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="display-6">{{ __('messages.working_days') }}</h2>
        </div>
    </div>

    @if (session('message'))
        <div class="alert alert-success fixed-top w-50 mx-auto" id="flashMessage"
            style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            {{ session('message') }}
        </div>
    @endif

    <!-- Working Days Table -->
    <div class="table-responsive">
        <form id="working-days-form" method="POST" action="{{ route('working-days.update') }}">
            @csrf
            @method('PUT')

            <table class="table table-striped table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">{{ __('messages.number') }}</th>
                        <th scope="col">{{ __('messages.day') }}</th>
                        <th scope="col">{{ __('messages.from') }}</th>
                        <th scope="col">{{ __('messages.to') }}</th>
                        @if (auth()->user()->hasRole('admin'))
                            <th scope="col">{{ __('messages.actions') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workingDays as $key => $workingDay)
                        @if (auth()->user()->hasRole('admin'))
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $workingDay->localized_name }}</td>
                                <td>
                                    <input type="time"
                                           name="working_days[{{ $workingDay->id }}][from]"
                                           value="{{ \Carbon\Carbon::parse($workingDay->from)->format('H:i') }}"
                                           data-original="{{ \Carbon\Carbon::parse($workingDay->from)->format('H:i') }}">
                                </td>
                                <td>
                                    <input type="time"
                                           name="working_days[{{ $workingDay->id }}][to]"
                                           value="{{ \Carbon\Carbon::parse($workingDay->to)->format('H:i') }}"
                                           data-original="{{ \Carbon\Carbon::parse($workingDay->to)->format('H:i') }}">
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('working-days.active', $workingDay->id) }}"
                                       class="btn btn-sm mx-1 {{ $workingDay->status === App\Enums\WorkingDayStatus::ACTIVE ? 'btn-warning' : 'btn-danger' }}">
                                        {{ App\Enums\WorkingDayStatus::getStringValue($workingDay->status) }}
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $workingDay->localized_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($workingDay->from)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($workingDay->to)->format('H:i') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            @if (auth()->user()->hasRole('admin'))
                <div class="text-center mt-3">
                    <button id="submit-button" type="submit" class="btn btn-primary btn-lg" disabled>
                        {{ __('messages.update') }}
                    </button>
                </div>
            @endif
        </form>
    </div>

    <!-- Count of Procedures Displayed -->
    <div class="text-center mt-4">
        <div class="alert alert-info" role="alert">
            <strong>{{ __('messages.count') }} {{ __('messages.working_days') }}: </strong>{{ $workingDays->count() }}
        </div>
    </div>

    <!-- JS to Submit Only Changed Rows and Enable Button on Change -->
    <script>
        const form = document.getElementById('working-days-form');
        const submitButton = document.getElementById('submit-button');
        const timeInputs = form.querySelectorAll('input[type="time"]');

        function checkForChanges() {
            let hasChanges = false;
            timeInputs.forEach(input => {
                if (input.value !== input.dataset.original) {
                    hasChanges = true;
                }
            });
            submitButton.disabled = !hasChanges;
        }

        // Listen to any change in time inputs
        timeInputs.forEach(input => {
            input.addEventListener('input', checkForChanges);
        });

        // Remove unchanged rows on submit
        form.addEventListener('submit', function () {
            const rows = form.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const inputs = row.querySelectorAll('input[type="time"]');
                let changed = false;

                inputs.forEach(input => {
                    if (input.value !== input.dataset.original) {
                        changed = true;
                    }
                });

                if (!changed) {
                    inputs.forEach(input => input.remove());
                }
            });
        });
    </script>
@endsection
