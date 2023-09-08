<?php

namespace App\Http\Controllers;

use App\Models\VehicleOut;
use Illuminate\Http\Request;

class VehicleOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'vehicleIn_id' => 'required|exists:vehicle_ins,id', // Assuming 'vehicle_ins' is the name of your vehicle in table
        ]);

        // Get the authenticated user's ID (if you have authentication)
        $createdByUserId = auth()->id(); // Adjust this based on your authentication method

        // Record the vehicle out
        $vehicleOut = VehicleOut::create([
            'vehicleIn_id' => $validatedData['vehicleIn_id'],
            'created_by' => $createdByUserId,
            'created_at' => now(), // Current timestamp
        ]);

        // Optionally, update the status of the corresponding VehicleIn record
        // VehicleIn::where('id', $validatedData['vehicleIn_id'])->update(['status' => 1]);

        return response()->json([
            'message' => 'Vehicle Out Successfully',
            'data' => $vehicleOut,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleOut  $vehicleOut
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleOut $vehicleOut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VehicleOut  $vehicleOut
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleOut $vehicleOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VehicleOut  $vehicleOut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleOut $vehicleOut)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleOut  $vehicleOut
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleOut $vehicleOut)
    {
        //
    }
}
