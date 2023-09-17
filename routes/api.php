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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('events', App\Http\Controllers\EventController::class);
Route::get('events/{event}/subscribers', [App\Http\Controllers\EventController::class, 'subscribers']);

Route::apiResource('subscribers', App\Http\Controllers\SubscriberController::class)->only(['index', 'store']);
