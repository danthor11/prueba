<?php

use App\Http\Controllers\MultiBatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get("/table1", [MultiBatchController::class, "getEmployees"]);
Route::post("/table1", [MultiBatchController::class, "store"]);

Route::get("/table2", [MultiBatchController::class, "getEmployeesBackup"]);
Route::resource("/transferir-datos", MultiBatchController::class)->except(["create", "edit", "update", "destroy", "store"]);
Route::get("/transferir-datos/check-queue-status", [MultiBatchController::class, "checkQueueStatus"]);
