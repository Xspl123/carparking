<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleInRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_id' => 'nullable',
            'parking_area' => 'nullable',
            'parking_number' => 'nullable',
            'created_by' => 'nullable',
            'user_id'=> 'nullable',
        ];
    }
}
