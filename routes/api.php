<?php

use App\Http\Controllers\Admin\HeadPostOfficeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\LetterController;
use App\Http\Controllers\Admin\PostOfiiceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\User\BagController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\ZoneController;
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
        Route::get('zone', [ZoneController::class, 'index']);
        Route::post('zone', [ZoneController::class, 'store']);
        Route::get('zone/{id}', [ZoneController::class, 'show']);
        Route::post('zone-update/{id}', [ZoneController::class, 'update']);
        Route::post('zone-change-status/{id}', [ZoneController::class, 'changeStatus']);
        Route::post('zone-delete/{id}', [ZoneController::class, 'delete']);

        Route::get('post-office', [PostOfiiceController::class, 'index']);
        Route::post('post-office', [PostOfiiceController::class, 'store']);
        Route::get('post-office/{id}', [PostOfiiceController::class, 'show']);
        Route::post('post-office-update/{id}', [PostOfiiceController::class, 'update']);
        Route::post('post-office-change-status/{id}', [PostOfiiceController::class, 'changeStatus']);
        Route::post('post-office-delete/{id}', [PostOfiiceController::class, 'delete']);

        Route::get('head-post-office', [HeadPostOfficeController::class, 'index']);
        Route::post('head-post-office', [HeadPostOfficeController::class, 'store']);
        Route::get('head-post-office/{id}', [HeadPostOfficeController::class, 'show']);
        Route::post('head-post-office-update/{id}', [HeadPostOfficeController::class, 'update']);
        Route::post('head-post-office-change-status/{id}', [HeadPostOfficeController::class, 'changeStatus']);
        Route::post('head-post-office-delete/{id}', [HeadPostOfficeController::class, 'delete']);

        Route::get('user', [UserController::class, 'index']);
        Route::post('get-username', [UserController::class, 'getUserName']);
        Route::post('user', [UserController::class, 'store']);
        Route::get('user/{id}', [UserController::class, 'show']);
        Route::post('user-update/{id}', [UserController::class, 'update']);
        Route::post('user-change-status/{id}', [UserController::class, 'changeStatus']);
        Route::post('user-delete/{id}', [UserController::class, 'delete']);

        Route::get('type', [TypeController::class, 'index']);
        Route::post('type', [TypeController::class, 'store']);
        Route::get('type/{id}', [TypeController::class, 'show']);
        Route::post('type-update/{id}', [TypeController::class, 'update']);
        Route::post('type-change-status/{id}', [TypeController::class, 'changeStatus']);
        Route::post('type-delete/{id}', [TypeController::class, 'delete']);

        Route::get('option-zone', [OptionController::class, 'zone']);
        Route::get('option-head-post-office/{id}', [OptionController::class, 'headPostOffice']);
        Route::get('option-post-office/{id}', [OptionController::class, 'postOffice']);
    });
});

Route::prefix('user')->group(function () {
    Route::post('/login', [AuthController::class, 'userLogin']);
    Route::middleware(['auth:sanctum', 'user.type'])->group(function () {
        Route::post('change-password', [AuthController::class, 'updatePassword']);

        Route::get('find', [LetterController::class, 'findOption']);
        Route::get('show/{id}', [LetterController::class, 'show']);
        Route::post('update/{id}', [LetterController::class, 'update']);

        Route::get('letter', [LetterController::class, 'index']);
        Route::get('all-letter', [LetterController::class, 'allLetter']);
        Route::get('bag-letter/{id}', [LetterController::class, 'bagLetter']);

        Route::get('bag', [BagController::class, 'index']);
        Route::post('bag', [BagController::class, 'makeStore']);
        Route::get('bag-update', [BagController::class, 'update']);

        Route::get('option-type', [OptionController::class, 'type']);
    });
});

Route::prefix('delivery')->group(function () {
    Route::post('/login', [AuthController::class, 'deliveryLogin']);
    Route::middleware(['auth:sanctum', 'delivery.type'])->group(function () {
        Route::get('delivery/{id}', [LetterController::class, 'delivery']);
    });
});
