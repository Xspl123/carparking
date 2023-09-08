<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_name' => 'required',
            'plat_number' => 'required',
            'registration_number' => 'nullable',
            'status' => 'required', 
            'duration' => 'nullable',
            'parking_charge' => 'nullable',
            'parking_number' => 'required',
            'customer_id' => 'nullable', 
            'category_id' => 'nullable', 
            'created_by' => 'nullable', 
            'user_id' => 'nullable'
        ];
    }
}
