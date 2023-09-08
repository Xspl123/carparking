<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'user_id'];

    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(vehicle::class, 'vehicle_id');
    }
    
}
