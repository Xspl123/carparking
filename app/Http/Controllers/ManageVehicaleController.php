<?php

namespace App\Http\Controllers;

use App\Models\ManageVehicale;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ManageVehicaleController extends Controller
{
    public function vehicleIn(Request $request)
    {
        // Validate the request data, e.g., check if 'vehicle_id' and resident_id and'status' are provided
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'resident_id' => 'required|exists:residents,id',
            'status' => 'required|in:In,Out', // Allow 'In' and 'Out' (case insensitive)
        ]);
    
        // Retrieve vehicle_in from the 'vehicles' table based on 'vehicle_id'
         $vehicleInfo = DB::table('vehicles')->where('id', $request->input('vehicle_id'))->first();
        //$residentInfo = DB::table(' residents')->where('id', $request->input('resident_id'))->first();
    
        if (!$vehicleInfo) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
    
        $userId = auth()->user()->id;
    
        // Convert the input status to lowercase
        $status = strtolower($request->input('status'));
    
        // Create a new ManageVehicle instance and fill its attributes
        $vehicle = new ManageVehicale();
        $vehicle->vehicle_id = $request->input('vehicle_id');
        $vehicle->resident_id = $request->input('resident_id');
        $vehicle->status = $status;
        $vehicle->user_id = $userId;
        $vehicle->save();
    
        $message = $status === 'in' ? 'Vehicle In Entry Added Successfully' : 'Vehicle Out Entry Added Successfully';
    
        return response()->json(['message' => $message]);
    }

    public function showVehiclesStatus()
    {
        $vehicles = ManageVehicale::with('vehicle','resident')
            ->latest('created_at')
            ->get();

        return response()->json(['vehiclesInOut' => $vehicles], 200);
    }


    public function singleVehiclesStatus($id)
    {
        try {
            $vehicle = ManageVehicale::findOrFail($id);
            return response()->json(['data' => $vehicle], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }
    }

}
