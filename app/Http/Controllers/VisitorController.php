<?php

namespace App\Http\Controllers;
use App\Http\Requests\VisitorRequest;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function store(VisitorRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Handle image upload
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('uploads', 'public'); // Store the image in the 'public/uploads' directory

            // Save the image path in the 'photo_path' field of the Visitor model
            $validatedData['photo_path'] = $imagePath;
        }

        // Create a new visitor record
        $visitor = new Visitor($validatedData);
        $visitor->save();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Visitor added successfully'], 201);
    }
}
