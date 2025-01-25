@extends('layouts.sideBar')

@section('title')
    {{ __('messages.working_days') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="display-6">{{ __('messages.working_days') }}</h2>
        </div>
    </div>

    @if(session('message'))
        <div class="alert alert-success fixed-top w-50 mx-auto" id="flashMessage" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            {{ session('message') }}
        </div>
    @endif

    <!-- Action Button to Create a Procedure -->
    <div class="text-right mb-3">
        @can('procedures_create')
            <a class="btn btn-success btn-lg" href="{{ route('working-days.create') }}" title="{{ __('messages.add_new') }}">
                <i class="fas fa-plus"></i>
            </a>
        @endcan
    </div>

    <!-- Filter Form Above Table -->
    <form method="GET" action="{{ route('working-days.index') }}" class="mb-4">
        <div class="form-row d-flex align-items-center">
            <div class="col-md-3 col-3 mb-3 mr-3 me-2 ml-2">
                <label for="start_date">{{ __('messages.start_date') }}</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request()->get('start_date') }}">
            </div>

            <div class="col-md-3 col-3 mb-3 mr-3 ml-2 me-2">
                <label for="end_date">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request()->get('end_date') }}">
            </div>

            <div class="col-md-2 mb-3 me-2 ml-2">
                <button type="submit" class="btn btn-primary mt-4 me-2 ml-2">{{ __('messages.filter') }}</button>
            </div>
        </div>
    </form>

    <!-- Procedures Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">{{ __('messages.number') }}</th>
                    <th scope="col">{{ __('messages.date') }}</th>
                    <th scope="col">{{ __('messages.from') }}</th>
                    <th scope="col">{{ __('messages.to') }}</th>
                    @can(['procedures_edit', 'procedures_delete'])
                    <th scope="col">{{ __('messages.actions') }}</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($workingDays as $key => $workingDay)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ \Carbon\Carbon::parse($workingDay->date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($workingDay->from)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($workingDay->to)->format('H:i') }}</td>
                        @can('procedures_delete')
                            <td class="d-flex justify-content-center">
                                <form action="{{ route('procedures.delete', $workingDay['id']) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mx-1" title="{{ __('messages.delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Count of Procedures Displayed -->
    <div class="text-center mt-4">
        <div class="alert alert-info" role="alert">
            <strong>{{ __('messages.count') }} {{ __('messages.working_days') }}: </strong>{{ $workingDays->count() }}
        </div>
    </div>

    <!-- Pagination (if applicable) -->
    {{-- @if ($workingDays->hasPages())
        <div class="d-flex justify-content-center">
            {{ $workingDays->links() }}
        </div>
    @endif --}}

    @push('scripts')
    <script>
        let typingTimer; // Timer identifier
        const doneTypingInterval = 1000; // 1 second delay

        const nameInput = document.getElementById('name-input');

        // Event listener for the search input
        nameInput.addEventListener('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(submitForm, doneTypingInterval);
        });

        // Function to submit the form
        function submitForm() {
            document.getElementById('filter-form').submit();
        }
    </script>
    @endpush
@endsection
