@extends('layouts.sideBar')

@section('content')
<div class="container mt-5" style="max-width: 600px; background: linear-gradient(to right, #f0f8ff, #e6e6fa); padding: 30px; border-radius: 15px;">
    <div class="card border-0 shadow-sm p-4">
        <!-- Smaller Colorful Header with Gradient -->
        <h3 class="text-center mb-4" style="font-family: 'Arial', sans-serif; color: white; background: linear-gradient(to right, #FF7F50, #FF6347); padding: 10px 20px; border-radius: 10px; font-size: 1.5rem;">
            {{__('messages.create')}} {{ __('messages.procedure')}}
        </h3>

        <form action="{{ route('procedures.store') }}" method="POST">
            @csrf

            <!-- Name Fields -->
            <div class="form-group">
                <label for="name_en" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.name_en')}}</label>
                <input type="text" class="form-control" id="name_en" name="name_en" required placeholder="{{__('messages.enter')}} {{__('messages.name_en')}}" style="border-radius: 25px; border: 2px solid #FF6347;">
            </div>

            <div class="form-group">
                <label for="name_ar" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.name_ar')}}</label>
                <input type="text" class="form-control" id="name_ar" name="name_ar" required placeholder="{{__('messages.enter')}} {{__('messages.name_ar')}}" style="border-radius: 25px; border: 2px solid #FF6347;">
            </div>

            <!-- Description Fields -->
            <div class="form-group">
                <label for="description_en" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.description_en')}}</label>
                <textarea class="form-control" id="description_en" name="description_en" rows="4" required placeholder="{{__('messages.enter')}} {{__('messages.description_en')}}" style="border-radius: 25px; border: 2px solid #FF6347;"></textarea>
            </div>

            <div class="form-group">
                <label for="description_ar" class="font-weight-bold" style="font-size: 1.1rem;">{{__('messages.description_ar')}}</label>
                <textarea class="form-control" id="description_ar" name="description_ar" rows="4" required placeholder="{{__('messages.enter')}} {{__('messages.description_ar')}}" style="border-radius: 25px; border: 2px solid #FF6347;"></textarea>
            </div>

            <!-- Price Field -->
            <div class="form-group">
                <label for="price" class="font-weight-bold" style="font-size: 1.1rem;"> {{__('messages.price')}} </label>
                <input type="number" class="form-control" id="price" name="price" required step="0.01" placeholder="{{__('messages.enter')}} {{__('messages.price')}}" style="border-radius: 25px; border: 2px solid #FF6347;">
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg" style="width: 50%; border-radius: 25px; background-color: #FF6347; border: 2px solid #FF6347; color: white;">
                   {{__('messages.create')}} {{ __('messages.procedure')}}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
