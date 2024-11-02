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

            $purr = Tariff::where('estate_id', Auth::user()->estate_id)->first() ?? null;
            $duration = Utitlity::where('estate_id', Auth::user()->estate_id)->first()->duration ?? null;
            $estate_id = Auth::user()->estate_id ?? null;


            if($duration == null || $estate_id == null){
                $minvend = 0;
            }else{
                $get_vend =   vend($duration, $estate_id);
                if($get_vend == null){
                    $minvend = 0;
                }else{
                    $minvend = $get_vend;
                }
            }


            if($purr == null){
                $pur = [];
            }else{
                $pur['min_purchase'] = $purr->min_pur;
                $pur['max_purchase'] = $purr->max_pur;
                $pur['min_vending'] = $minvend;

            }


            $tariffs = Tariff::select('id', 'type', 'estate_id', 'title')
                ->where('user_id', Auth::id())
                ->get();


            foreach ($tariffs as $tariff) {
                $tariffState = TarrifState::where('tariff_id', $tariff->id)->first();
                $tariff->amount = $tariffState ? $tariffState->amount : null; // Appending 'amount' if it exists
            }


            $token = auth()->user()->createToken('API Token')->accessToken;
            $meter = meter();
            $user = user();
            $user['token'] = $token;
            $user['meter'] = $meter;
            $user['purchase'] = $pur;
            $user['tariff'] = $tariffs;





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
