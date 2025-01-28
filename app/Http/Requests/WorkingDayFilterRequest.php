<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingDayFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ];
    }
}
