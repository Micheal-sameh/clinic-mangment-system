@extends('layouts.sideBar')

<title>{{__('messages.create')}} {{__('messages.procedure')}} </title>

@section('content')
<div class="container mt-5" style="max-width: 95%; background: linear-gradient(to right, #f0f8ff, #e6e6fa); padding: 10px; border-radius: 7px;">
    <div class="card border-0 shadow-sm p-3">
        <!-- Smaller Colorful Header with Gradient -->
        <h3 class="text-center mb-4" style="font-family: 'Arial', sans-serif; color: FF6347; background: linear-gradient(to right, #ffffff, #ffffff); padding: 10px 20px; border-radius: 10px; font-size: 1.5rem;">
            {{__('messages.create')}} {{ __('messages.procedure')}}
        </h3>

        <form action="{{ route('procedures.store') }}" method="POST">
            @csrf

            <!-- Name Fields -->
            <div class="form-group">
                <label for="name_en" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.name_en')}}</label>
                <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" required placeholder="{{__('messages.enter')}} {{__('messages.name_en')}}" style="border-radius: 25px; border: 2px solid #FF6347;">
                @error('name_en')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name_ar" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.name_ar')}}</label>
                <input type="text" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" required placeholder="{{__('messages.enter')}} {{__('messages.name_ar')}}" style="border-radius: 25px; border: 2px solid #FF6347;">
                @error('name_ar')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Fields -->
            <div class="form-group">
                <label for="description_en" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.description_en')}}</label>
                <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en" name="description_en" rows="4" required placeholder="{{__('messages.enter')}} {{__('messages.description_en')}}" style="border-radius: 25px; border: 2px solid #FF6347;"></textarea>
                @error('description_en')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description_ar" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.description_ar')}}</label>
                <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar" rows="4" required placeholder="{{__('messages.enter')}} {{__('messages.description_ar')}}" style="border-radius: 25px; border: 2px solid #FF6347;"></textarea>
                @error('description_ar')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price Field -->
            <div class="form-group">
                <label for="price" class="font-weight-bold" style="font-size: 1.1rem;"> {{__('messages.price')}} </label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required step="0.01" placeholder="{{__('messages.enter')}} {{__('messages.price')}}" style="border-radius: 25px; border: 2px solid #FF6347;">
                @error('price')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg" style="width: 55%; border-radius: 25px; background-color: #FF6347; border: 2px solid #FF6347; color: white;">
                   {{__('messages.create')}} {{ __('messages.procedure')}}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
