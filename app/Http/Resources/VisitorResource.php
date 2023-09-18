<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ResidentResource;

use Carbon\Carbon;

class VisitorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'resident_id' => $this->resident_id,
            'contact_phone' => $this->contact_phone,
            'purpose' => $this->purpose,
            'status' => $this->status,
            'visitor_type' => $this->visitor_type,
            'token_no' => $this->token_no,
            'vehicle_number' => $this->vehicle_number,
            'check_in_time' => Carbon::parse($this->check_in_time)->format('d-M-Y H:i'), // Parse and format 
            'check_out_time' => Carbon::parse($this->check_out_time)->format('d-M-Y H:i'),
            'resident' => new ResidentResource($this->whenLoaded('resident')), // Include resident data

        ];
    }
}

