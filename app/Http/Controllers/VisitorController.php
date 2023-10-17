<?php

namespace App\Http\Controllers;
use App\Http\Requests\VisitorRequest;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Resources\VisitorResource;
use Carbon\Carbon;


class VisitorController extends Controller
{
    public function store(VisitorRequest $request)
    {  
        $validatedData = $request->validated();
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('uploads', 'public');  
            $validatedData['photo_path'] = $imagePath;
        }
        $visitor = new Visitor($validatedData);

            $visitor->resident_id = $validatedData['resident_id'];
            $visitor->token_no = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);

            $visitor->save();

        return response()->json(['message' => 'Visitor added successfully','token' => $visitor->token_no], 201);
    }

    public function showVisitor(){
        $perPage = 10; // Number of residents per page
        $visitors = Visitor::latest()->with('resident')->limit(50) // Limit the total number of residents to 50
        ->paginate($perPage);
        return VisitorResource::collection($visitors);
    }

    public function checkOutVisitor($token_no)
    {
        $visitors = Visitor::where('token_no', $token_no)->get();

        $checkoutTime = Carbon::now('Asia/Kolkata');

        foreach ($visitors as $visitor) {
            $visitor->update([
            'status' => 'out',
            'check_out_time' => $checkoutTime,
        ]);
        }

        return response()->json(['message' => 'Visitors checked out successfully'], 200);
    }

}
