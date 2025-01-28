@extends('layouts.sideBar')

<title> {{__('messages.register')}} </title>

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header text-center bg-primary text-white">
                        {{ __('messages.register') }}
                    </div>
                    <div class="card-body">
                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Arabic Name Field -->
                            <div class="form-group row">
                                <label for="name_ar" class="col-md-4 col-form-label text-md-right">{{ __('messages.name_ar') }}</label>
                                <div class="col-md-6">
                                    <input id="name_ar" type="text" class="form-control" name="name_ar" value="{{ old('name_ar') }}" required autocomplete="name_ar" autofocus>
                                    @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- English Name Field -->
                            <div class="form-group row">
                                <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ __('messages.name_en') }}</label>
                                <div class="col-md-6">
                                    <input id="name_en" type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" required autocomplete="name_en">
                                    @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Field -->
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('messages.phone') }}</label>
                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Age Field -->
                            <div class="form-group row">
                                <label for="age" class="col-md-4 col-form-label text-md-right">{{ __('messages.age') }}</label>
                                <div class="col-md-6">
                                    <input id="age" type="number" class="form-control" name="age" value="{{ old('age') }}" required>
                                    @error('age')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('messages.email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('messages.password') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group row">
                                <label for="confirm_password" class="col-md-4 col-form-label text-md-right">{{ __('messages.confirm_password') }}</label>
                                <div class="col-md-6">
                                    <input id="confirm_password" type="password" class="form-control" name="confirm_password" required autocomplete="new-password">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group row mb-0 text-center">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('messages.register') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Login Link -->
                        <div class="form-group mt-4 text-center">
                            <p>{{ __('messages.have_an_account') }} <a href="{{ route('login') }}" class="text-primary">{{ __('messages.login') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
