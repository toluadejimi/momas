<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Bills\BillsController;
use App\Http\Controllers\Estate\EstateController;
use App\Http\Controllers\Feature\FeatureController;
use App\Http\Controllers\Meter\MeterController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;


Route::post('reset-password', [LoginController::class, 'reset_password']);
Route::post('delete-user', [LoginController::class, 'delete_user']);


Route::post('login', [LoginController::class, 'login']);
Route::post('check-email', [RegisterController::class, 'check_user']);
Route::post('validate-email', [RegisterController::class, 'validate_email']);
Route::post('register', [RegisterController::class, 'register']);

Route::post('validate', [MeterController::class, 'validate_meter']);



Route::get('support', [LoginController::class, 'support']);




Route::post('check-email', [RegisterController::class, 'check_user']);
Route::post('validate-email', [RegisterController::class, 'validate_email']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('validate', [MeterController::class, 'validate_meter']);
Route::get('cable-plan', [BillsController::class, 'get_cable_plan']);
Route::post('validate-cable', [BillsController::class, 'validate_cable']);




Route::group(['middleware' => ['auth:api', 'acess']], function () {

    Route::post('balance', [ProfileController::class, 'balance']);
    Route::get('features', [FeatureController::class, 'features']);
    Route::get('promotion', [FeatureController::class, 'promotion']);
    Route::get('getUser', [LoginController::class, 'get_user']);


    //Services
    Route::get('service-properties', [ServiceController::class, 'service_properties']);
    Route::post('service-search', [ServiceController::class, 'service_search']);
    Route::post('get-comment', [ServiceController::class, 'get_comment']);
    Route::post('save-comment', [ServiceController::class, 'save_comment']);









    //Fund Wallet
    Route::post('pay', [TransactionController::class, 'make_payment']);
    Route::get('get-transactions', [TransactionController::class, 'all_transactions']);




    //Bills
    Route::post('buy-airtime', [BillsController::class, 'buy_airtime']);
    Route::get('get-data', [BillsController::class, 'get_data']);
    Route::post('buy-data', [BillsController::class, 'buy_data']);
    Route::post('buy-cable', [BillsController::class, 'buy_cable']);


    //
    Route::post('buy-meter', [MeterController::class, 'buy_meter_token']);
    Route::post('buy-meter-others', [MeterController::class, 'pay_for_others_meter_token']);
    Route::post('reprint-token', [MeterController::class, 'reprint_meter_token']);
    Route::post('get-token', [MeterController::class, 'get_token']);
    Route::get('vending-properties', [MeterController::class, 'vending_properties']);












    //Estate
    Route::get('get-estate', [EstateController::class, 'get_estate']);
    Route::post('generate-token', [EstateController::class, 'estate_token']);
    Route::post('approve-token', [EstateController::class, 'approve_token']);
    Route::post('disapprove-token', [EstateController::class, 'disapprove_token']);
    Route::post('delete-token', [EstateController::class, 'delete_token']);
    Route::post('set-default', [EstateController::class, 'set_default_estate']);
    Route::post('token-list', [EstateController::class, 'token_list']);





    //Services
    Route::get('get-service', [ServiceController::class, 'get_estate']);
















});





