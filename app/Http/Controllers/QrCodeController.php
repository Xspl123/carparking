<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;
use App\Models\vehicle;

class QrCodeController extends Controller
{
   
    public function index()
    {
      return view('qrcode');
    }

   
    public function generateQRCode(Request $request)
    {
        // Generate the QR code
        $qrCodeData = QrCode::size(300)->generate('RemoteStack');

        // Save the QR code to the database
        $qrCode = new QrCode();
        $qrCode->code_data = $qrCodeData;
        $qrCode->save();

        // Return a response indicating success
        return response()->json(['message' => 'QR Code saved successfully']);
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show()
    {
         $latestQrCode =  QrCode::latest()->with('resident')->get();

         return response()->json([
             'latestQrCode' => $latestQrCode,
         ], 200);
 
    }

    
    // public function getVehicleData($uuid)
    // {
    //     $qrcode = QrCode::where('uuid', $uuid)->first();

    //     if (!$qrcode) {
    //         return response()->json([
    //             'status' => 'error','message' => 'QR code data not verified', 'data' => null], 404);
    //     }
    //     $registrationNumber = $qrcode->uuid;
    //     $residentName = $qrcode->name;
    //     $vehicle = Vehicle::where('registration_number', $registrationNumber)->first();

    //     if (!$vehicle) {
    //         return response()->json(['status' => 'error', 'message' => 'Vehicle not verified','data' => null ], 404); 
    //     }

    //     $vehicleData = $vehicle->toArray();

    //     return response()->json([
    //         'status' => 'success','message' => 'Vehicle verified','data' => ['vehicle' => $vehicleData, 'resident_name' => $residentName]
    //     ]);
    // }

    public function getVehicleData($uuid)
    {
        // Find the QR code record by UUID
        $qrcode = QrCode::where('uuid', $uuid)->first();

        if (!$qrcode) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR code data not verified',
                'data' => null
            ], 404);
        }

        // Use the UUID to find the related vehicle and resident data
        $vehicleData = Vehicle::where('registration_number', $qrcode->uuid)
            ->with('resident') // Assuming 'resident' is the relationship between Vehicle and Resident models
            ->first();

        if (!$vehicleData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle not verified',
                'data' => null
            ], 404);
        }

        // Return the combined data in the response
        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle verified',
            'data' => $vehicleData
        ]);
    }



    
    public function update(Request $request, QrCode $qrCode)
    {
        //
    }

    
    public function destroy(QrCode $qrCode)
    {
        //
    }
}
