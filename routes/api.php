<?php

use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoredataController;
use App\Http\Controllers\Admin\TerminalController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Agents\AuthController;
use App\Http\Controllers\Agents\BillsController;
use App\Http\Controllers\Agents\PosTransactionController;
use App\Http\Controllers\Agents\TransferController;
use App\Http\Controllers\Agents\VirtualAccountController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


    Route::post('login', [LoginController::class, 'login']);

    Route::group(['middleware' => ['auth:api', 'acess']], function () {


    });





