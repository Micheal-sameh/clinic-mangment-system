@extends('layouts.sideBar')
<title> {{__('messages.create')}} {{__('messages.reservation')}} </title>
@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center text-primary test-center"> {{__('messages.create')}} {{__('messages.reservation')}}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <div class="border p-4 rounded shadow-sm bg-light col-9">
            <!-- User Dropdown -->
            @can('reservations_add')
                <div class="form-group row mb-3 col-6">
                    <label for="user_id" class="col-md-3 col-3col-form-label text-info"> {{__('messages.select')}}  {{__('messages.patient')}}</label>
                    <div class="col-md-9 col-12">
                        <select name="user_id" id="user_id" class="form-control border-info rounded bg-white col-3">
                            <option value="">{{__('messages.select')}} {{__('messages.patient')}}</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->localized_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endcan
            <!-- Reservation Day (Date) -->
            <div class="form-group row mb-3 col-6">
                <label for="reservation_date" class="col-3 col-md-3 col-form-label text-info">{{__('messages.reservation_date')}}</label>
                <div class="col-md-9 col-12">
                    <input type="date" name="reservation_date" id="reservation_date" class="col-3 form-control border-info rounded bg-white" value="{{ old('reservation_date') }}">
                    @error('reservation_date')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Slate Number -->
            <div class="form-group row mb-3 col-6">
                <label for="slate_number" class="col-md-3 col-3 col-form-label text-info">{{__('messages.slate')}}</label>
                <div class="col-md-9 col-12">
                    <input type="text" name="slate_number" id="slate_number" class="form-control border-info rounded bg-white col-3" value="{{ old('slate_number') }}">
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

<!-- Additional custom styles -->
@section('styles')
    <style>
        .container {
            background-color: #f0f8ff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
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
            }

            .btn {
                font-size: 1rem;
                padding: 10px;
            }

            .container {
                padding: 15px;
            }
        }

        /* Full-width mobile form */
        @media (max-width: 576px) {
            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-control {
                width: 100%;
            }

            .btn-block {
                width: 100%;
            }
        }

        /* Border and shadow styles for the form container */
        .border {
            border: 1px solid #e0e0e0;
        }

        .rounded {
            border-radius: 8px;
        }

        .shadow-sm {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@endsection
