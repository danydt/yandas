<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommonActionController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/callback/{reference}', [PaymentController::class, 'callback']);

Route::middleware('auth:api')->group(function () {
    Route::get('/my-address', [CommonActionController::class, 'myAddress']);
    Route::get('/my-orders', [OrderController::class, 'index']);
    Route::get('/my-orders/{id}', [OrderController::class, 'show']);
    Route::delete('/delete-order/{id}', [OrderController::class, 'destroy']);
    Route::post('/delete-order-detail', [OrderController::class, 'deleteDetail']);

    Route::post('/create-order', [OrderController::class, 'store']);
    Route::post('/create-order-detail', [OrderController::class, 'addDetail']);
    Route::post('/update-order-detail', [OrderController::class, 'updateDetail']);
    Route::post('/update-profile', [AuthController::class, 'updateAuth']);
    Route::post('/upload-profile', [AuthController::class, 'uploadProfile']);
    Route::post('/update-password', [AuthController::class, 'changePassword']);
});
