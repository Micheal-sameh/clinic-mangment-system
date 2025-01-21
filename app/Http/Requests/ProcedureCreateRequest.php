<?php

namespace App\Http\Requests;

use App\Models\Procedure;
use Illuminate\Foundation\Http\FormRequest;

class ProcedureCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_en' => ['required','string', function ($attribute, $value, $fail) {
                $exists = Procedure::whereJsonContains('name->en', $value)->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'name_ar' => ['required','string', function ($attribute, $value, $fail) {
                $exists = Procedure::whereJsonContains('name->ar', $value)->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'description_en' => 'string',
            'description_ar' => 'string',
            'price' => 'required|numeric|gt:0',
        ];
    }
}
