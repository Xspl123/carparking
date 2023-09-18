<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleInsController;
use App\Http\Controllers\VehicleOutController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ManageVehicaleController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\VisitorController;

//User controller
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/generate-qr-code', 'QrCodeController@generateQRCode');

//CategoryController
Route::post('/createCategory', [CategoryController::class, 'store']);

Route::middleware(['auth:sanctum', 'logApiRequests'])->group(function () {

    //User controller
    Route::get('/users-list', [UserController::class,'index']);
    Route::get('/single-user/{id}', [UserController::class,'singleUser']);

    //VehicleController
    Route::get('/showVehicales', [VehicleController::class,'show']);
    Route::get('/singleVehicale/{id}', [VehicleController::class,'single']);
    Route::post('/vehicles', [VehicleController::class,'store']);
    Route::put('/vehicles/{id}', [VehicleController::class,'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class,'delete']);
    //VehicleInsController
    Route::post('/vehicles-in', [VehicleInsController::class, 'store']);
    Route::put('/vehicles/{id}', [VehicleInsController::class,'update']);
    Route::get('/vehicles_in', [VehicleInsController::class, 'show']);

    //ManageVehicaleController
    Route::post('/manage-vehicles_in', [ManageVehicaleController::class, 'vehicleIn']);
    Route::get('/manage-vehicle-details', [ManageVehicaleController::class, 'showVehiclesStatus']);
    Route::get('/manage-singleVehicaleStatus/{id}', [ManageVehicaleController::class,'singleVehiclesStatus']);
    //VehicleInsController
    Route::post('/vehicles-out', [VehicleOutController::class, 'store']);
    //ResidentController
    Route::post('/add-resident', [ResidentController::class, 'store']);
    Route::get('/resident-with-vehicles', [ResidentController::class,'index']);
    Route::get('/singleResident/{id}', [ResidentController::class,'singleResident']);

   //QrCodeController
   Route::get('/getqrdetails', [QrCodeController::class,'show']);
   Route::get('/checkVehicaldata/{uuid}', [QrCodeController::class,'getVehicleData']);

   //VisitorController
   Route::post('/check-in-visitor', [VisitorController::class, 'store']);
   Route::get('/show-visitor', [VisitorController::class,'showVisitor']);
   Route::get('/check-out-visitor/{token_no}', [VisitorController::class,'checkOutVisitor']);

});
