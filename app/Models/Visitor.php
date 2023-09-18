<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'contact_phone',
        'contact_email',
        'vehicle_registration',
        'purpose',
        'check_in_time',
        'check_out_time',
        'status',
        'photo', 
        'identification',
        'additional_notes',
        'approved_by',
        'appointment_datetime',
        'access_pass',
        'emergency_contact',
        'company_organization',
        'duration_of_visit',
        'badge_pass_number',
        'host_id',
        'visitor_type',
        'vehicle_number'
       
    ];
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
