<?php

namespace App\Http\Requests;

use App\Rules\CanReserveToday;
use App\Rules\CheckActiveDayRule;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['exists:users,id', new CanReserveToday($this->reservation_date)],
            'reservation_date' => ['required','date','after_or_equal:today', new CheckActiveDayRule],
            'slate_number' => 'required|integer',
        ];
    }

    public function message()
    {
        return __('validation.custom.can_reserve_today');
    }

}
