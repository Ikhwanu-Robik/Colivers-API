<?php

namespace App\Http\Requests\Auth;

use App\Rules\IndonesianPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                new IndonesianPhoneNumber
            ],
            'password' => 'required',
        ];
    }
}
