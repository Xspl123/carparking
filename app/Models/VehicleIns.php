<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleIns extends Model
{
    use HasFactory;

    
    public function vehicle()
    {
        return $this->belongsTo(vehicle::class, 'vehicle_id');
    }

    protected $fillable = ['parking_area', 'parking_number', 'vehicle_id','created_by','user_id'];

    
}
