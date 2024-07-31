<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bills\BillsController;
use App\Http\Controllers\Estate\EstateController;
use App\Http\Controllers\Feature\FeatureController;
use App\Http\Controllers\Meter\MeterController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Service\ServiceController;
use Illuminate\Support\Facades\Route;


Route::post('login', [LoginController::class, 'login']);
Route::post('check-email', [RegisterController::class, 'check_user']);
Route::post('validate-email', [RegisterController::class, 'validate_email']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('validate', [MeterController::class, 'validate_meter']);


Route::group(['middleware' => ['auth:api', 'acess']], function () {

    Route::post('balance', [ProfileController::class, 'balance']);
    Route::get('features', [FeatureController::class, 'features']);
    Route::get('promotion', [FeatureController::class, 'promotion']);
    Route::get('get-user', [LoginController::class, 'get_user']);

    //Bills
    Route::post('buy-airtime', [BillsController::class, 'buy_airtime']);
    Route::get('get-data', [BillsController::class, 'get_data']);
    Route::post('buy-data', [BillsController::class, 'buy_data']);


    //Estate
    Route::get('get-estate', [EstateController::class, 'get_estate']);
    Route::post('generate-token', [EstateController::class, 'estate_token']);
    Route::post('approve-token', [EstateController::class, 'approve_token']);
    Route::post('disapprove-token', [EstateController::class, 'disapprove_token']);
    Route::post('delete-token', [EstateController::class, 'delete_token']);
    Route::post('set-default', [EstateController::class, 'set_default_estate']);


    //Services
    Route::get('get-service', [ServiceController::class, 'get_estate']);















});





