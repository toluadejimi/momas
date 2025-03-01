<?php

namespace App\Http\Controllers\Auth;

use App\Models\Setting;
use App\Models\Tariff;
use App\Models\TariffState;
use App\Models\TarrifState;
use App\Models\UtilitiesPayment;
use App\Models\Utitlity;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Meter;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Models\OauthAccessToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(request $request)
    {

        if($request->email == null) {
            $credentials = request(['meterNo', 'password']);
            $usr = User::where('meterNo', $request->meterNo)->first() ?? null;
            $status = User::where('meterNo', $request->meterNo)->first()->status ?? null;

            if($status == 9){
                $message = "User does not exist";
                $code = 401;
                return error($message, $code);
            }

            if ($usr == null) {
                $message = "User does not exist";
                $code = 404;
                return error($message, $code);
            }

            Passport::tokensExpireIn(Carbon::now()->addMinutes(20));
            Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(20));

            if (!auth()->attempt($credentials)) {
                $message = "Meter No or Password Incorrect";
                $code = 422;
                return error($message, $code);
            }

            flush_token();


            $tariffs = Tariff::select('id', 'type', 'estate_id', 'title')
                ->where('user_id', Auth::id())
                ->get();
            foreach ($tariffs as $tariff) {
                $tariffState = TarrifState::where('tariff_id', $tariff->id)->first();
                $tariff->amount = $tariffState ? $tariffState->amount : null;
            }


            $admin_fee_get = UtilitiesPayment::where('user_id', Auth::id())
                ->where('type', 'admin_fee')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->latest('created_at')
                ->first();

            if($admin_fee_get){
                $admin_fee =  "1";
            }else{
                $admin_fee = "0";
            }




            $token = auth()->user()->createToken('API token')->accessToken;
            $meter = meter();
            $user = user();
            $user['token'] = $token;
            $user['meter'] = $meter;
            $user['tariff'] = $tariffs;
            $user['monthly_admin_fee'] = $admin_fee;






            return response()->json([
                'status' => true,
                'user' => $user
            ]);


        }


        if($request->meterNo == null) {
            $credentials = request(['email', 'password']);

            $usr = User::where('email', $request->email)->first() ?? null;
            $status = User::where('email', $request->email)->first()->status ?? null;
            if($status == 9){
                $message = "User does not exist";
                $code = 401;
                return error($message, $code);
            }

            if ($usr == null) {
                $message = "User does not exist";
                $code = 404;
                return error($message, $code);
            }

            Passport::tokensExpireIn(Carbon::now()->addMinutes(20));
            Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(20));

            if (!auth()->attempt($credentials)) {
                $message = "Email No or Password Incorrect";
                $code = 422;
                return error($message, $code);
            }

            flush_token();


            $tariffs = Tariff::select('id', 'type', 'estate_id', 'title')
                ->where('user_id', Auth::id())
                ->get();
            foreach ($tariffs as $tariff) {
                $tariffState = TarrifState::where('tariff_id', $tariff->id)->first();
                $tariff->amount = $tariffState ? $tariffState->amount : null;
            }



            $admin_fee_get = UtilitiesPayment::where('user_id', Auth::id())
                ->where('type', 'admin_fee')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->latest('created_at')
                ->first();

            if($admin_fee_get){
                $admin_fee =  "0";
            }else{
                $admin_fee = "1";
            }



            $token = auth()->user()->createToken('API token')->accessToken;
            $meter = meter();
            $user = user();
            $user['token'] = $token;
            $user['meter'] = $meter;
            $user['tariff'] = $tariffs;
            $user['monthly_admin_fee'] = $admin_fee;


            return response()->json([
                'status' => true,
                'user' => $user
            ]);

        }


    }



    public function delete_user(request $request)
    {
        User::where('email', $request->email)->update(['status' => 9]);

        return response()->json([
            'status' => true,
            'message' => "User Deleted successfully"
        ], 200);


    }
    public function reset_password(request $request)
    {
        $email = $request->email;

        if($request->password != $request->confirm_password){
            $code = 422;
            $message = "Password does not match";
            return error($message, $code);
        }
        User::where('email', $email)->update(['password' => bcrypt($request->password)]);

        return response()->json([
            'status' => true,
            'message' => "Password successfully updated"
        ], 200);

    }

    public function get_user(request $request)
    {

        $fl = Setting::where('id', 1)->first();
        $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
        $flkey['flutterwave_public'] = $fl->flutterwave_public;
        $pkkey['paystack_secret'] = $fl->paystack_secret;
        $pkkey['paystack_public'] = $fl->paystack_public;

        $admin_fee_get = UtilitiesPayment::where('user_id', Auth::id())
            ->where('type', 'admin_fee')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->latest('created_at')
            ->first();

        if($admin_fee_get){
            $admin_fee =  "1";
        }else{
            $admin_fee = "0";
        }



        $token = auth()->user()->createToken('API token')->accessToken;
        $meter = meter();
        $user = user();
        $user['token'] = $token;
        $user['meter'] = $meter;
        $user['flutterwave_keys'] =  $flkey;
        $user['paystack_keys'] =  $pkkey;
        $user['monthly_admin_fee'] = $admin_fee;







        return response()->json([
            'status' => true,
            'user' => $user
        ]);



    }


    public function support(request $request)
    {


        $set = Setting::where('id', 1)->first();

        $user['payment_support'] = $set->payment_support;
        $user['meter_support'] = $set->meter_support;
        $user['general_support'] = $set->general_support;


        return response()->json([
            'status' => true,
            'data' => $user
        ]);



    }


}
