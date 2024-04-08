<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RecordController;


use App\Http\Controllers\PaymentsC;

// Route::post('/v1/stk_push', [PaymentsController::class, 'STKPush']);
// Route::post('/v1/confirm', [PaymentsController::class, 'STKConfirm']);

Route::group(['prefix' => 'v1'], function(){

    // Public Routes/End Points
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Private/Protected Routes
    Route::group(['middleware' => ['auth:sanctum']], function(){
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::post('/update_role', [RoleController::class, 'update']);
        Route::post('/delete_role', [RoleController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::post('/update_user', [UserController::class, 'update']);
        Route::post('/delete_user', [UserController::class, 'destroy']);

        Route::post('/stkpush', [PaymentsController::class, 'STKPush']);
        Route::post('/confirm', [PaymentsController::class, 'STKConfirm']);

        Route::get('/payments', [RecordController::class, 'index']);
   

   
        
        Route::post('/paym', [PaymentsC::class, 'initiatePayment']);
    });
});

