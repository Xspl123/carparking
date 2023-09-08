<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\QrCode as Qr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException; 
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use App\QrCodeEntry;

class UserController extends Controller
{
    public function index() {
        $users = User::take(10)->get(); // Limit to 10 records
        return response(['users' => $users]);
    }

    public function singleUser($id)
    {
        try {
            $singleUser = User::findOrFail($id);
            return response()->json(['data' => $singleUser], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    


    public function register(UserRequest $request)
    {
        $userData = $request->validated();

    // Attempt to create a new user
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            'password' => Hash::make($userData['password']),
        ]);

        // Check if user creation was successful
        if (!$user) {
            return response([
                'message' => 'Failed to create user',
                'status' => 'failed'
            ], 500);
        }

        $token = $user->createToken($userData['email'])->plainTextToken;

        return response([
            'token' => $token,
            'message' => 'Registration Success',
            'status' => 'success'
        ], 201);
    }

   

    // public function register(UserRequest $request)
    // {
    //     $userData = $request->validated();
    
    //     // Attempt to create a new user
    //     $user = User::create([
    //         'name' => $userData['name'],
    //         'email' => $userData['email'],
    //         'phone' => $userData['phone'],
    //         'password' => Hash::make($userData['password']),
    //         // 'hn' => $userData['hn'],
    //     ]);
    
    //     // Check if user creation was successful
    //     if (!$user) {
    //         return response([
    //             'message' => 'Failed to create user',
    //             'status' => 'failed'
    //         ], 500);
    //     }
    
    //     // Generate a QR code and save it as an image file
    //     $qrCode = QrCode::size(200)->generate($user->id);
    //     $qrCodePath = public_path("qr_codes/{$user->id}.png"); // Save the QR code in the public directory
    //     file_put_contents($qrCodePath, $qrCode);
    
    //     // Save the QR code to the qr_codes table using the QrCodeEntry model
    //     $qrCodeEntry = Qr::create([
    //         'uuid' => $qrCodePath,
    //         'user_id' => $user->id,
    //     ]);
    
    //     if (!$qrCodeEntry) {
    //         // Handle the case where QR code entry creation failed
    //         return response([
    //             'message' => 'Failed to create QR code entry',
    //             'status' => 'failed'
    //         ], 500);
    //     }
    
    //     $token = $user->createToken($userData['email'])->plainTextToken;
    
    //     return response([
    //         'token' => $token,
    //         'message' => 'Registration Success',
    //         'status' => 'success'
    //     ], 201);
    // }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication failed
            return response([
                'message' => 'Invalid credentials',
                'status' => 'failed'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response([
                'message' => 'User not found',
                'status' => 'failed'
            ], 404);
        }

        // Generate a new token
        $token = $user->createToken($request->email)->plainTextToken;

        return response([
            'token' => $token,
            'message' => 'Login successful',
            'status' => 'success'
        ], 200);
}

}
