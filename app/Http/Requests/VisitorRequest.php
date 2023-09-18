<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can customize authorization logic here if needed.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'resident_id' =>'required',
            'contact_phone' => 'required|string',
            'contact_email' => 'nullable|string|email',
            'vehicle_registration' => 'nullable|string',
            'purpose' => 'required|string',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:in,out',
            'photo_path' => 'nullable|string',
            'identification' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'approved_by' => 'nullable|exists:users,id',
            'appointment_datetime' => 'nullable|date_format:Y-m-d H:i:s',
            'access_pass' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            'company_organization' => 'nullable|string',
            'duration_of_visit' => 'nullable|string',
            'badge_pass_number' => 'nullable|string',
            'host_id' => 'nullable',
            'visitor_type' => 'required|in:guest,vendor,contractor',
            'sign_in_method' => 'nullable|string',
            'sign_out_method' => 'nullable|string',
            'vehicle_number'=> 'required|string',
        ];
    }
}
