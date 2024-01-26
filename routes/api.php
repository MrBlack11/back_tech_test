<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;

Route::get('/healthz', HealthCheckController::class);
Route::apiResource("/users", UserController::class);
Route::apiResource("/cars", CarController::class);
Route::get("users/{id}/cars", [UserController::class, 'listCars']);
Route::post("users/{id}/cars", [UserController::class, 'addCar']);
Route::delete("users/{id}/cars/{carId}", [UserController::class, 'removeCar']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
