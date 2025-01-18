<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name_ar' => ['required', 'string', function ($attribute, $value, $fail) {
                $exists = User::whereJsonContains('name->ar', $value)->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'name_en' => ['required', 'string', function ($attribute, $value, $fail) {
                $exists = User::whereJsonContains('name->en', $value)->exists();
                if ($exists) {
                    $fail(__('messages.nameTaken'));
                }
            }],
            'phone'             => 'required|string|digits:11|unique:users,phone',
            'age'               => 'required|integer|min:0|max:90',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:8',
            'confirm_password'  => 'required|string|min:8|same:password',
        ];
    }
}
