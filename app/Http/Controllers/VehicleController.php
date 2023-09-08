<?php

namespace App\Http\Controllers;

use App\Models\vehicle;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; 

class VehicleController extends Controller
{
    public function show()
    {
        $vehicles = Vehicle::all();

        if ($vehicles->isEmpty()) {
            return response()->json(['message' => 'No vehicles found'], 404);
        }

        return response()->json(['data' => $vehicles], 200);
    }

    
    public function single($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            return response()->json(['data' => $vehicle], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }
    }

   
    public function store(VehicleRequest $request)
    {
        // Validate the incoming request
        $validatedData = $request->validated();

        // Generate a unique registration number of 11 characters
        $registrationNumber = Str::random(11); // You can customize the length as needed

        // Get the authenticated user's ID
        $createdByUserId = auth()->user()->id;

        // Include the 'created_by' field and 'registration_number' in the $validatedData array
        $validatedData['created_by'] = $createdByUserId;
        $validatedData['registration_number'] = $registrationNumber;
        $validatedData['user_id'] = $createdByUserId;

        // Create a new Vehicle record with the 'created_by' and 'registration_number' fields
        $vehicle = Vehicle::create($validatedData);

        return response()->json(['message' => 'Vehicle Created Successfully!!'], 201);
    }










    public function update($id, VehicleRequest $request)
    {
        $validatedData = $request->validated();

        $vehicle = vehicle::findOrFail($id);
        $vehicle->update($validatedData);

        return response()->json(['message' => 'Vehicle Updated Successfully!!'], 200);
    }

    public function delete($id)
    {
        $vehicle = vehicle::findOrFail($id);
        $vehicle->delete();

        return response()->json(['message' => 'Vehicle Deleted Successfully!!'], 200);
    }

}
