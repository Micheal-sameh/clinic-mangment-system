<?php

namespace App\Http\Requests;

use App\Rules\CheckDate;
use Illuminate\Foundation\Http\FormRequest;

class WorkingDayStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'working_days' => 'required|array|min:1',
            'working_days.*.date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'working_days.*.from' => 'required|date_format:H:i',
            'working_days.*.to' => ['required','date_format:H:i', new CheckDate($this->working_days)],
        ];
    }
}
