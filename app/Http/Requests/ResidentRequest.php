<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResidentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'flat_number' => 'required|string|max:255',
            'phone' => 'required',
            'email' => 'nullable|email|max:255',
            'another_phone' => 'nullable'
        ];
    }
}
