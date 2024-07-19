<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Feature\FeatureController;
use App\Http\Controllers\Profile\ProfileController;
use App\Models\Feature;

    Route::post('login', [LoginController::class, 'login']);
    Route::post('check-email', [RegisterController::class, 'check_user']);
    Route::post('validate-email', [RegisterController::class, 'validate_email']);
    Route::post('register', [RegisterController::class, 'register']);

    

    

    

    Route::group(['middleware' => ['auth:api', 'acess']], function () {

        Route::post('balance', [ProfileController::class, 'balance']);
        Route::post('features', [FeatureController::class, 'features']);

        


    });





