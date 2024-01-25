<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/helthz', function (Request $request) {
    return response()->json(\Illuminate\Http\Response::HTTP_OK);
});

Route::apiResource("/users", \App\Http\Controllers\UserController::class);
Route::apiResource("/cars", \App\Http\Controllers\CarController::class);
Route::get("users/{id}/cars", [\App\Http\Controllers\UserController::class, 'listCars']);
Route::post("users/{id}/cars", [\App\Http\Controllers\UserController::class, 'addCar']);
Route::delete("users/{id}/cars/{carId}", [\App\Http\Controllers\UserController::class, 'removeCar']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
