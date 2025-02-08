@extends('layouts.sideBar')
<title> {{__('messages.create')}} {{__('messages.reservation')}} </title>

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center text-primary"> {{__('messages.create')}} {{__('messages.reservation')}}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <div class="border p-3 rounded shadow-sm bg-light col-md-9">
            <!-- User Dropdown -->
            @can('reservations_add')
                <div class="form-group row mb-3 col-12">
                    <label for="user_id" class="col-md-5 col-form-label text-info">{{__('messages.select')}}  {{__('messages.patient')}}</label>
                    <div class="col-md-9 col-12">
                        <select name="user_id" id="user_id" class="form-control border-info rounded bg-white col-3">
                            <option value="">{{__('messages.select')}} {{__('messages.patient')}}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->localized_name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @else
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            @endcan

            <!-- Reservation Day (Date) -->
            <div class="form-group row mb-3 col-12">
                <label for="reservation_date" class="col-4 col-md-4 col-form-label text-info">{{__('messages.reservation_date')}}</label>
                <div class="col-md-9 col-12">
                    <input type="date" name="reservation_date" id="reservation_date" class="col-md-5 form-control border-info rounded bg-white" value="{{ old('reservation_date') }}">
                    @error('reservation_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Slate Number -->
            <div class="form-group row mb-3 col-12">
                <label for="slate_number" class="col-md-5 col-5 col-form-label text-info">{{__('messages.slate')}}</label>
                <div class="col-md-9 col-12">
                    <select name="slate_number" id="slate_number" class="form-control border-info rounded bg-white col-md-5">
                        <option value="">{{__('messages.select')}} {{__('messages.slate')}}</option>
                    </select>
                    @error('slate_number')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row">
                <div class="col-md-9 offset-md-3 col-12">
                    <button type="submit" class="btn btn-warning btn-lg btn-block text-white rounded shadow-lg">{{__('messages.reservation')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('styles')
    <style>
        .container {
            background-color: #f0f8ff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);

            /* Flexbox to center content */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Make sure it takes full screen height */
        }

        form {
            width: 100%;
            max-width: 800px;  /* Set a max width to ensure the form isn't too wide */
            margin: 0 auto;
        }

        h1 {
            color: #ff6347;
            font-size: 2rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #6fa3ef;
        }

        .form-group label {
            font-weight: 600;
            color: #20c997;
        }

        .btn {
            border-radius: 5px;
            font-size: 1.2rem;
            padding: 12px;
            transition: all 0.3s ease-in-out;
        }

        .btn-warning {
            background-color: #ffb84d;
            border-color: #f39c12;
        }

        .btn-warning:hover {
            background-color: #f39c12;
            border-color: #ffb84d;
        }

        .btn-block {
            width: 100%;
        }

        /* Custom mobile-friendly styles */
        @media (max-width: 768px) {
            .form-group label {
                font-size: 1rem;
            }

            h1 {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 1rem;
                width: 100%; /* Make inputs take full width on mobile */
            }

            .btn {
                font-size: 1rem;
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            /* Ensure full width for the select input on mobile */
            select.form-control {
                width: 100%;
            }
        }

        /* Full-width mobile form */
        @media (max-width: 576px) {
            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-control {
                width: 100%; /* Ensure all inputs are full width on smaller screens */
            }

            .btn-block {
                width: 100%;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const reservationDateInput = document.getElementById('reservation_date');  // Get the reservation date input
    const slateNumberSelect = document.getElementById('slate_number');  // Get the slate number dropdown

    reservationDateInput.addEventListener('change', function () {
        const date = this.value;  // Get the selected date value
        console.log('Selected date:', date);  // Log the selected date for debugging

        slateNumberSelect.innerHTML = '<option value="">{{__('messages.select')}} {{__('messages.slate')}}</option>'; // Clear existing slate options

        // If no date is selected, stop and do nothing
        if (!date) {
            console.log('No date selected, skipping request.');
            return;
        }

        // First, check if the date is active
        const checkActiveUrl = `/working-days/check-active-date?date=${encodeURIComponent(date)}`;  // URL to check if the date is active
        console.log('Checking active status:', checkActiveUrl);

        fetch(checkActiveUrl)
            .then(response => response.json())
            .then(data => {
                console.log('Active status response:', data);

                if (data.is_active) {
                    // If the date is active, fetch the slate numbers
                    const url = `/working-days/slatesNumber?date=${encodeURIComponent(date)}`;  // URL to fetch slates
                    console.log('Fetching URL for slates:', url);

                    fetch(url)
                        .then(response => response.json())  // Parse the JSON response
                        .then(slates => {
                            console.log('Slates data:', slates);
                            if (slates && slates.length > 0) {
                                // Loop through the available slates and add them as options
                                slates.forEach((slate, index) => {
                                    const option = document.createElement('option');
                                    option.value = index + 1;  // Store the index (1-based) in the option value
                                    option.textContent = slate;

                                    // Check if the slate is "Reserved" and hide it if true
                                    if (slate.status === "Reserved") {
                                        option.style.display = 'none';  // Hide the option
                                    }

                                    slateNumberSelect.appendChild(option);
                                });
                            } else {
                                const option = document.createElement('option');
                                option.value = '';
                                option.textContent = '{{__('messages.all_booked')}}';
                                slateNumberSelect.appendChild(option);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching slates:', error);
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = '{{__('messages.error_fetching_slates')}}';
                            slateNumberSelect.appendChild(option);
                        });
                } else {
                    // If the date is not active, show an error message
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = '{{__('messages.holiday')}}';  // You can define this error message in your translation files
                    // option.disabled = true;
                    slateNumberSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error checking active date:', error);
                const option = document.createElement('option');
                option.value = '';
                option.textContent = '{{__('messages.error_checking_date')}}';  // You can define this error message as well
                slateNumberSelect.appendChild(option);
            });
    });

    // Trigger the change event if there's an old value for the date
    const oldDate = "{{ old('reservation_date') }}";
    if (oldDate) {
        reservationDateInput.value = oldDate;  // Set the old value
        reservationDateInput.dispatchEvent(new Event('change'));  // Trigger the change event programmatically
    }
});


    </script>
@endpush
