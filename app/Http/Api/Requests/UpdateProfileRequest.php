<?php

namespace App\Http\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       
        return [
            'name' => 'required',
            'fitness_goal' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'fitness_goal.required' => 'Fitness goal is required'
        ];
    }
}