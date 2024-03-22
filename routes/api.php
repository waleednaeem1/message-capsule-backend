<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MessageCapsuleController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;

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

// User registration and login routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/allUnopenedCapsules', [MessageCapsuleController::class, 'getUnopenedMessageCapsules']);
    Route::post('/message-capsules', [MessageCapsuleController::class, 'store']);
    Route::get('/message-capsules/{id}', [MessageCapsuleController::class, 'show']);
    Route::put('/message-capsules/{id}', [MessageCapsuleController::class, 'update']);
    Route::delete('/message-capsules/{id}', [MessageCapsuleController::class, 'destroy']);
    Route::get('/logout', [LoginController::class, 'logout']);
});

Route::middleware('auth:sanctum')->post('/message-capsules', [MessageCapsuleController::class, 'store']);


