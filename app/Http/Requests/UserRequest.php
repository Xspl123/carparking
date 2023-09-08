<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
            'hn' => 'nullable',
            'vn' => 'nullable',
        ];
    }
}
