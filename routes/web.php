<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardContoller;
use App\Http\Controllers\Admin\DashboardController;
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
Route::any('log-out', [AuthController::class, 'log_out']);
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




