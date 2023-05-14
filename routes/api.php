<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LetterController;
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

Route::post('upload', [LetterController::class, 'upload']);
Route::get('get', [LetterController::class, 'getAll']);

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::middleware(['auth:sanctum', 'admin.type'])->group(function () {
        Route::get('test', function () {
            return "A";
        });
    });
});

Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'subscriberLogin']);
    Route::middleware(['auth:sanctum', 'user.type'])->group(function () {
        Route::get('test', function () {
            return "B";
        });
    });
});

Route::prefix('delivery')->group(function () {
    Route::post('/login', [AuthController::class, 'subscriberLogin']);
    Route::middleware(['auth:sanctum', 'delivery.type'])->group(function () {
        Route::get('test', function () {
            return "B";
        });
    });
});
