<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_name', 'plat_number' ,'parking_number','registration_number',
    'status', 'duration', 'parking_charge', 'customer_id', 'category_id', 'created_by','user_id'];


    public function manageVehicle()
    {
        return $this->hasMany(ManageVehicale::class, 'vehicle_id');
    }

    public function vehicleIns()
    {
        return $this->hasMany(VehicleIns::class, 'vehicle_id');
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class, 'vehicle_id');
    }

}
