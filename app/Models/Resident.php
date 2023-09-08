<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    use HasFactory;

    public function vehicle()
    {
        return $this->hasOne(vehicle::class);
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class, 'resident_id');
    }

}
