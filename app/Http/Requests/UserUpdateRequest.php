<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name_ar' => ['required', 'string', function ($attribute, $value, $fail) use ($userId) {
                $exists = User::whereJsonContains('name->ar', $value)->where('id', '!=', $userId)->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'name_en' => ['required', 'string', function ($attribute, $value, $fail) use ($userId) {
                $exists = User::whereJsonContains('name->en', $value)->where('id', '!=', $userId)->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'phone' => 'required|string|digits:11|unique:users,phone,'.$userId,
            'age' => 'required|integer|min:0|max:90',
            'email' => 'required|email|unique:users,email,'.$userId,
            'role' => 'required|exists:roles,name',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string|max:2000',
            'chronic_conditions' => 'nullable|string|max:2000',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ];
    }
}
