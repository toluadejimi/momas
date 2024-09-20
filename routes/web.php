<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EstateController;
use App\Http\Controllers\Admin\TerminalController;
use App\Http\Controllers\Agents\TransferController;
use App\Http\Controllers\LoginSecurityController;
use App\Http\Controllers\Meter\MeterController;
use App\Http\Controllers\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::any('/', [AuthController::class, 'admin_login']);
Route::post('login-now', [AuthController::class, 'login_now']);
Route::any('logout', [AuthController::class, 'log_out']);
Route::post('verify-code', [AuthController::class, 'verify_code']);







Route::any('pay-flutter', [TransactionController::class, 'flutter_payment']);
Route::any('payment-check', [TransactionController::class, 'flutter_verify']);
Route::any('paystack-check', [TransactionController::class, 'paystack_verify']);








Route::any('set-2fa', [AuthController::class, 'set_2fa']);
Route::any('auth_login', [AuthController::class, 'login.blade.php']);
Route::any('resend_code', [AuthController::class, 'resend_code']);
Route::any('verify_code', [AuthController::class, 'verify_code']);
Route::get('code', [AuthController::class, 'code']);




Route::group(['prefix'=>'admin'], function(){

    Route::get('admin-dashboard', [DashboardContoller::class, 'index']);
    Route::get('users-list', [DashboardContoller::class, 'list_users']);
    Route::get('new-user', [DashboardContoller::class, 'new_user']);
    Route::post('add-new-user', [DashboardContoller::class, 'add_new_user']);
    Route::get('user-delete', [DashboardContoller::class, 'delete_user']);
    Route::get('view-user', [DashboardContoller::class, 'view_user']);
    Route::post('update-user', [DashboardContoller::class, 'update_user']);
    Route::post('update-meter-info', [DashboardContoller::class, 'update_meter_info']);

    Route::get('send-token-email', [DashboardContoller::class, 'send_token_email']);






    //Estates
    Route::get('estate', [EstateController::class, 'estate_index']);
    Route::get('new-estate', [EstateController::class, 'estate_new']);
    Route::post('estate-store', [EstateController::class, 'estate_store']);
    Route::post('estate-update-tariff', [EstateController::class, 'estate_update_tariff']);
    Route::get('view-estate', [EstateController::class, 'estate_view']);
    Route::post('estate-update-info', [EstateController::class, 'estate_update']);
    Route::post('estate-update-utilities', [EstateController::class, 'estate_update_utilities']);


    Route::get('estate-delete', [EstateController::class, 'estate_delete']);




    //Organization
    Route::get('organization', [DashboardContoller::class, 'organization_index']);
    Route::get('new-organization', [DashboardContoller::class, 'organization_new']);
    Route::post('organization-store', [DashboardContoller::class, 'organization_store']);
    Route::get('view-organization', [DashboardContoller::class, 'organization_view']);
    Route::post('organization-update', [DashboardContoller::class, 'organization_update']);
    Route::get('organization-delete', [DashboardContoller::class, 'organization_delete']);




    //Assets
    Route::get('asset', [AssetController::class, 'asset_index']);
    Route::get('new-asset', [AssetController::class, 'asset_new']);
    Route::post('asset-store', [AssetController::class, 'asset_store']);
    Route::get('view-asset', [AssetController::class, 'asset_view']);
    Route::post('asset-update', [AssetController::class, 'asset_update']);
    Route::get('asset-delete', [AssetController::class, 'asset_delete']);


    //utilities
    Route::get('utility', [DashboardContoller::class, 'utility_index']);
    Route::get('utility-store', [DashboardContoller::class, 'utility_store']);
    Route::get('utility-update', [DashboardContoller::class, 'utility_update']);
    Route::get('utility-delete', [DashboardContoller::class, 'utility_delete']);



    Route::get('meter-list', [MeterController::class, 'list_meter']);
    Route::get('new-meter', [MeterController::class, 'new_meter']);
    Route::post('add-new-meter', [MeterController::class, 'add_new_meter']);
    Route::get('meter-delete', [MeterController::class, 'delete_meter']);
    Route::get('edit-delete', [MeterController::class, 'delete_meter']);


    Route::get('settings', [DashboardContoller::class, 'settings']);
    Route::post('features', [DashboardContoller::class, 'update_feat']);
    Route::post('payment-keys', [DashboardContoller::class, 'update_pay']);
    Route::post('support-set', [DashboardContoller::class, 'support_set']);
















});


// test middleware
Route::get('/test_middleware', function () {
    return "2FA middleware work!";
})->middleware(['auth', '2fa']);




