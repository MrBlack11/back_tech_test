<?php

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

Route::get('/helthz', function (Request $request) {
    return response()->json(\Illuminate\Http\Response::HTTP_OK);
});

Route::apiResource("/users", \App\Http\Controllers\UserController::class);
Route::apiResource("/cars", \App\Http\Controllers\CarController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
