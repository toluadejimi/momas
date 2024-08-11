<?php

namespace App\Http\Controllers\Auth;

use App\Models\Setting;
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


            $fl = Setting::where('id', 1)->first();
            $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
            $flkey['flutterwave_public'] = $fl->flutterwave_public;
            $pkkey['paystack_secret'] = $fl->paystack_secret;
            $pkkey['paystack_public'] = $fl->paystack_public;


            $token = auth()->user()->createToken('API Token')->accessToken;
            $meter = meter();
            $user = user();
            $user['token'] = $token;
            $user['meter'] = $meter;
            $user['flutterwave_keys'] = $flkey;
            $user['paystack_keys'] = $pkkey;


            return response()->json([
                'status' => true,
                'user' => $user
            ]);


        }


        if($request->meterNo == null) {
            $credentials = request(['email', 'password']);

            $usr = User::where('email', $request->email)->first() ?? null;

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


            $fl = Setting::where('id', 1)->first();
            $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
            $flkey['flutterwave_public'] = $fl->flutterwave_public;
            $pkkey['paystack_secret'] = $fl->paystack_secret;
            $pkkey['paystack_public'] = $fl->paystack_public;


            $token = auth()->user()->createToken('API Token')->accessToken;
            $meter = meter();
            $user = user();
            $user['token'] = $token;
            $user['meter'] = $meter;



            return response()->json([
                'status' => true,
                'user' => $user
            ]);


        }


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


        $token = auth()->user()->createToken('API Token')->accessToken;
        $meter = meter();
        $user = user();
        $user['token'] = $token;
        $user['meter'] = $meter;
        $user['flutterwave_keys'] =  $flkey;
        $user['paystack_keys'] =  $pkkey;



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
