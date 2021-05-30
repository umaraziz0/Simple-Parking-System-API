<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post("/enter-vehicle", [ParkingController::class, "store"]);
Route::post("/exit-vehicle", [ParkingController::class, "exit"]);

Route::post("/admin/register", [AuthController::class, "registerAdmin"]);
Route::post("/admin/login", [AuthController::class, "loginAdmin"]);

// Protected routes
Route::middleware("auth:sanctum")->group(function () {
    Route::get("/admin", [ParkingController::class, "index"]);
    Route::get("/admin/export", [ParkingController::class, "export"]);
    Route::post("/admin/filter-by-date", [ParkingController::class, "showByDateRange"]);
    Route::post("/admin/filter-by-date/export", [ParkingController::class, "exportByDateRange"]);

    Route::post("/admin/logout", [AuthController::class, "logoutAdmin"]);
});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
