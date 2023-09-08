<?php

namespace App\Http\Controllers;

use App\Models\VehicleIns;
use App\Models\vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\StoreVehicleInRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str; 

class VehicleInsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $vehicles = VehicleIns::all();

        if ($vehicles->isEmpty()) {
            return response()->json(['message' => 'No vehicles found'], 404);
        }

        return response()->json(['data' => $vehicles], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request, VehicleRequest $vehicleRequest, StoreVehicleInRequest $storeVehicleInRequest)
    // {
    //     // Validate the incoming requests and get the validated data
    //     $vehicleData = $vehicleRequest->validated();
    //     $storeVehicleData = $storeVehicleInRequest->validated();

    //     // Get the authenticated user's ID
    //     $createdByUserId = auth()->user()->id;

    //     // Set the 'created_by' field directly in the $vehicleData array
    //     $vehicleData['created_by'] = $createdByUserId;

    //     // Merge the validated data from both requests
    //     $mergedData = array_merge($vehicleData, $storeVehicleData);

    //     // Create a new Vehicle record
    //     $vehicle = new Vehicle();
    //     $vehicle->fill($mergedData);
    //     $vehicle->save();

    //     // Create a new VehicleIns record
    //     $vehicleIns = new VehicleIns();
    //     $vehicleIns->vehicle_id = $vehicle->id; // Set the vehicle_id from the related Vehicle model
    //     $vehicleIns->parking_area = $mergedData['parking_area'];
    //     $vehicleIns->parking_number = $mergedData['parking_number'];
    //     $vehicleIns->created_by = $createdByUserId; // Set the created_by field to the user's ID
    //     $vehicleIns->save();

    //     // Return a success response
    //     return response()->json(['message' => 'Vehicle Add  and VehicleIns Enter successfully'], 201);
    // }

   
    public function store(Request $request, VehicleRequest $vehicleRequest, StoreVehicleInRequest $storeVehicleInRequest)
    {
        // Validate the incoming requests and get the validated data
        $vehicleData = $vehicleRequest->validated();
        // Generate a unique registration number of 11 characters
        $registrationNumber = Str::random(11); // You can customize the length as needed

        $storeVehicleData = $storeVehicleInRequest->validated();
    
        // Get the authenticated user's ID
        $createdByUserId = auth()->user()->id;
    
        // Merge the validated data from both requests
        $mergedData = array_merge($vehicleData, $storeVehicleData);
    
        try {
            // Start a database transaction
            DB::beginTransaction();
    
            // Find the vehicle by 'plat_number', if it exists, update it; otherwise, create a new one
            $vehicle = Vehicle::firstOrNew(['plat_number' => $mergedData['plat_number']]);
    
            // Set the attributes for the vehicle
            $vehicle->name = $mergedData['name'];
            $vehicle->registration_number = $registrationNumber;
            $vehicle->status = $mergedData['status'];
            $vehicle->duration = $mergedData['duration'];
            $vehicle->parking_charge = $mergedData['parking_charge'];
            $vehicle->parking_number = $mergedData['parking_number'];
            $vehicle->created_by = $createdByUserId;
            $vehicle['user_id'] = $createdByUserId;
    
            // Save the vehicle record
            $vehicle->save();
    
            // Create a new VehicleIns record
            $vehicleIns = new VehicleIns();
            $vehicleIns->vehicle_id = $vehicle->id;
            $vehicleIns->parking_area = $mergedData['parking_area'];
            $vehicleIns->parking_number = $mergedData['parking_number'];
            $vehicleIns->created_by = $createdByUserId;

            $vehicleIns->save();
    
            // Commit the transaction
            DB::commit();
    
            // Return a success response
            return response()->json(['message' => 'Vehicle Add and VehicleIns Enter successfully'], 201);
        } catch (\Exception $e) {
            // Handle any exceptions and rollback the transaction if an error occurs
            DB::rollback();
            return response()->json(['message' => 'Error occurred while processing the request'], 500);
        }
    }
    
  
    public function update(Request $request, VehicleRequest $vehicleRequest, StoreVehicleInRequest $storeVehicleInRequest, $id)
    {
        // Validate the incoming requests and get the validated data
        $vehicleData = $vehicleRequest->validated();
        $storeVehicleData = $storeVehicleInRequest->validated();

        // Get the authenticated user's ID
        $createdByUserId = auth()->user()->id;

        // Find the existing Vehicle record by its ID
        $vehicle = Vehicle::findOrFail($id);

        // Update the fields one by one in the Vehicle model
        if (isset($vehicleData['name'])) {
            $vehicle->name = $vehicleData['name'];
        }
        if (isset($vehicleData['plat_number'])) {
            $vehicle->plat_number = $vehicleData['plat_number'];
        }
        if (isset($vehicleData['registration_number'])) {
            $vehicle->registration_number = $vehicleData['registration_number'];
        }
        if (isset($vehicleData['status'])) {
            $vehicle->status = $vehicleData['status'];
        }
        if (isset($vehicleData['duration'])) {
            $vehicle->duration = $vehicleData['duration'];
        }
        if (isset($vehicleData['parking_charge'])) {
            $vehicle->parking_charge = $vehicleData['parking_charge'];
        }
        if (isset($vehicleData['parking_number'])) {
            $vehicle->parking_number = $vehicleData['parking_number'];
        }
       
        
        // Update the 'created_by' field directly
        $vehicle->created_by = $createdByUserId;

        // Save the changes to the Vehicle model
        $vehicle->save();

        // Find the existing VehicleIns record by the related vehicle_id
        $vehicleIns = VehicleIns::where('vehicle_id', $id)->first();

        if ($vehicleIns) {
            // Update the fields in VehicleIns one by one
            if (isset($storeVehicleData['parking_area'])) {
                $vehicleIns->parking_area = $storeVehicleData['parking_area'];
            }
            if (isset($storeVehicleData['parking_number'])) {
                $vehicleIns->parking_number = $storeVehicleData['parking_number'];
            }
           
            
            // Update the 'created_by' field directly
            $vehicleIns->created_by = $createdByUserId;

            // Save the changes to the VehicleIns model
            $vehicleIns->save();
        }

        // Return a success response
        return response()->json(['message' => 'Vehicle and VehicleIns updated successfully'], 200);
    }


    public function destroy(VehicleIns $vehicleIns)
    {
        //
    }
}
