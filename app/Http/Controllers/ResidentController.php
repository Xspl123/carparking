<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\vehicle;
use App\Models\QrCode as Qr;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\ResidentRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
   
    public function index()
    {
        // Find the resident and associated vehicle
        $resident = Resident::with('vehicle')->latest()->limit(50)->get();

        // Return a JSON response with the resident and vehicle data
        return response()->json([
            'resident' => $resident,
        ], 200);
    }


  
    public function singleResident($id)
    {
        try {
            $resident = Resident::with('vehicle')->findOrFail($id);
            return response()->json(['data' => $resident], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Resident not found'], 404);
        }
    }
   
    public function store(ResidentRequest $residentRequest, VehicleRequest $vehicleRequest)
    {
            // Validate and prepare data
            $residentData = $residentRequest->validated();
            $vehicleData = $vehicleRequest->validated();
            $registrationNumber = mt_rand(10000000000000, 99999999999999);
            $createdByUserId = auth()->user()->id;

            // Start a database transaction
            DB::transaction(function () use ($residentData, $vehicleData, $registrationNumber, $createdByUserId) {
                // Create a new resident record
                $resident = new Resident();
                $resident->name = $residentData['name'];
                $resident->flat_number = $residentData['flat_number'];
                $resident->phone = $residentData['phone'];
                $resident->email = $residentData['email'];
                $resident->created_by = $createdByUserId;
                $resident->user_id = $createdByUserId;
                $resident->save();

                // Generate a QR code
                $qrCode = QrCode::format('png')->size(200)->generate($registrationNumber);
                $qrCodePath = public_path("qr_codes/{$resident->flat_number}.png");
                file_put_contents($qrCodePath, $qrCode);

                // Generate the URL for the QR code
                $baseUrl = config('app.url'); // Get your application's base URL from the config
                $qrCodeUrl = "{$baseUrl}/public/qr_codes/{$resident->flat_number}.png";

                // Save the QR code to the qrcode table
                $qrcode = new Qr(); 
                $qrcode->uuid = $registrationNumber; 
                $qrcode->user_id = $createdByUserId;
                $qrcode->resident_id = $resident->id;
                $qrcode->name = $resident->name;
                $qrcode->url = $qrCodeUrl;
                $qrcode->save();

                // Create a new vehicle record associated with the resident
                $vehicle = new Vehicle();
                $vehicle->vehicle_name = $vehicleData['vehicle_name'];
                $vehicle->plat_number = $vehicleData['plat_number'];
                $vehicle->parking_number = $vehicleData['parking_number'];
                $vehicle->status = $vehicleData['status'];
                $vehicle->registration_number = $registrationNumber;
                $vehicle->user_id = $createdByUserId;
                $vehicle->resident_id = $resident->id;
                $vehicle->created_by = $createdByUserId;
                $vehicle->save();

            });

            return response()->json([
                'message' => 'Resident with Vehicle Added Successfully!',
                'resident' => $residentData,
                'vehicle' => $vehicleData
            ], 201);
    }

    public function show(Resident $resident)
    {
        //
    }

    
    public function edit(Resident $resident)
    {
        //
    }

    public function update(Request $request, Resident $resident)
    {
        //
    }

   
    public function destroy(Resident $resident)
    {
        //
    }
}
