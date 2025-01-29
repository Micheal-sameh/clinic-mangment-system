@extends('layouts.sideBar')

@section('title')
    {{__('messages.procedures')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="display-6">{{__('messages.procedures')}}</h2>
        </div>
    </div>

    @if(session('message'))
        <div class="alert alert-success fixed-top w-50 mx-auto" id="flashMessage" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            {{ session('message') }}
        </div>
    @endif

    <!-- Error Message Display -->
    @if ($errors->any())
        <div class="alert alert-danger fixed-top w-50 mx-auto" id="flashMessage" style="top: 20px; left: 50%; transform: translateX(-50%); z-index: 1050;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Action Button to Create a Procedure -->
    <div class="text-right mb-3">
        @can('procedures_create')
            <a class="btn btn-success btn-lg" href="{{ route('procedures.create') }}">
                <i class="fas fa-plus"></i> {{__('messages.Add new procedure')}}
            </a>
        @endcan
    </div>

    <!-- Filter Form Above Table -->
    <div class="text-center mb-4">
        <form action="{{ route('procedures.index') }}" method="GET" class="filter-dropdown" id="filter-form">
            <div class="form-row justify-content-center">
                <div class="row">
                    <div class="col-md-3 col-lg-2 mb-3">
                        <!-- Filter by Name -->
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Search by Name" value="{{ request()->name }}" style="height: 35px;" id="name-input">

                        <!-- Display error for 'name' input field -->
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Procedures Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">{{__('messages.number')}}</th>
                    <th scope="col">{{__('messages.name')}}</th>
                    <th scope="col">{{__('messages.price')}}</th>
                    @can(['procedures_edit', 'procedures_delete'])
                    <th scope="col">{{__('messages.actions')}}</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($procedures as $key => $procedure)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            @can('procedures_show')
                                <a class="nav-item" href="{{ route('procedures.show', $procedure['id']) }}" style="text-decoration: none;">
                                    {{$procedure->localized_name}}
                                </a>
                            @else
                                {{$procedure->localized_name}}
                            @endcan
                        </td>

                        <td>{{ $procedure->price }}</td>
                        <td class="d-flex justify-content-center">
                            @can('procedures_edit')
                                <a class="btn btn-secondary btn-sm mx-1" href="{{ route('procedures.edit', $procedure['id']) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('procedures_delete')
                                <form action="{{ route('procedures.delete', $procedure['id']) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mx-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        @if($procedures->hasPages())
            <div class="pagination">
                @foreach ($procedures->getUrlRange(1, $procedures->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Count of Procedures Displayed -->
    <div class="text-center mt-4">
        <div class="alert alert-info" role="alert">
            <strong>{{__('messages.count')}} {{__('messages.procedures')}}: </strong>{{ $procedures->total() }}
        </div>
    </div>

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
