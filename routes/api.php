<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TwilioController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-notification',[NotificationController::class,'sendPushNotifications']);
Route::post('/send-otp',[TwilioController::class,'sendOtp']);
Route::post('/verify-otp',[TwilioController::class,'verifyOtp']);


// testing
Route::get('/data', function () {
    return response()->json(['message' => 'Hello from API']);
});
