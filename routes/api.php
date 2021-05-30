<?php

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

Route::post("/enter-vehicle", [ParkingController::class, "store"]);
Route::post("/exit-vehicle", [ParkingController::class, "exit"]);

Route::get("/admin/parking", [ParkingController::class, "index"]);
Route::get("/admin/parking/export", [ParkingController::class, "export"]);
Route::post("/admin/parking/filter-by-date", [ParkingController::class, "showByDateRange"]);
Route::post("/admin/parking/filter-by-date/export", [ParkingController::class, "exportByDateRange"]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
