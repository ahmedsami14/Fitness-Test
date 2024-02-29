<?php

namespace App\Http\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRegisterRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required',
            'identifier' => 'required',
        ];
    }
}