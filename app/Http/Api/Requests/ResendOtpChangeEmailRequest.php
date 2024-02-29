<?php

namespace App\Http\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendOtpChangeEmailRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
        ];
    }
}