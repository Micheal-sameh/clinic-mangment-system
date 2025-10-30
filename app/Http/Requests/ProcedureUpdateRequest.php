<?php

namespace App\Http\Requests;

use App\Models\Procedure;
use Illuminate\Foundation\Http\FormRequest;

class ProcedureUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $procedureId = $this->route('id');

        return [
            'name_en' => ['required', 'string', function ($attribute, $value, $fail) use ($procedureId) {
                $exists = Procedure::whereJsonContains('name->en', $value)
                    ->where('id', '!=', $procedureId)
                    ->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'name_ar' => ['required', 'string', function ($attribute, $value, $fail) use ($procedureId) {
                $exists = Procedure::whereJsonContains('name->ar', $value)
                    ->where('id', '!=', $procedureId)
                    ->exists();
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
