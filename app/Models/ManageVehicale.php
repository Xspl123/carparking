<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageVehicale extends Model
{
    use HasFactory;


    public function vehicle()
    {
        return $this->belongsTo(vehicle::class, 'vehicle_id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
