<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\LetterController;
use App\Http\Controllers\Admin\PostOfiiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\BagController;
use App\Http\Controllers\User\TypeController;
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

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::middleware(['auth:sanctum', 'admin.type'])->group(function () {
        Route::get('post-office', [PostOfiiceController::class, 'index']);
        Route::post('post-office', [PostOfiiceController::class, 'store']);
        Route::post('post-office-update/{id}', [PostOfiiceController::class, 'update']);
        Route::post('post-office-change-status/{id}', [PostOfiiceController::class, 'changeStatus']);
        Route::post('post-office-delete/{id}', [PostOfiiceController::class, 'delete']);

        Route::get('user', [UserController::class, 'index']);
        Route::post('user', [UserController::class, 'store']);
        Route::post('user/{id}', [UserController::class, 'update']);
        Route::post('user/{id}', [UserController::class, 'changeStatus']);
        Route::post('user/{id}', [UserController::class, 'delete']);
    });
});

Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'userLogin']);
    Route::middleware(['auth:sanctum', 'user.type'])->group(function () {
        Route::get('find', [LetterController::class, 'findOption']);
        Route::get('show/{id}', [LetterController::class, 'show']);
        Route::get('update/{id}', [LetterController::class, 'update']);

        Route::get('type', [TypeController::class, 'index']);
        Route::post('type', [TypeController::class, 'store']);
        Route::post('type/{id}', [TypeController::class, 'update']);
        Route::post('type/{id}', [TypeController::class, 'delete']);

        Route::get('bag', [BagController::class, 'index']);
        Route::post('bag', [BagController::class, 'makeStore']);
        Route::get('bag-update', [BagController::class, 'update']);
    });
});

Route::prefix('delivery')->group(function () {
    Route::post('/login', [AuthController::class, 'deliveryLogin']);
    Route::middleware(['auth:sanctum', 'delivery.type'])->group(function () {
        Route::get('delivery/{id}', [LetterController::class, 'delivery']);
    });
});
