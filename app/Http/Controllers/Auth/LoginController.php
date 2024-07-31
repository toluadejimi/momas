<?php

namespace App\Http\Controllers\Auth;

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

        $credentials = request(['meterNo', 'password']);

        $usr = User::where('meterNo', $request->meterNo)->first() ?? null;

        if($usr == null){
            $message = "User does not exist";
            $code = 401;
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



    public function get_user(request $request)
    {

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
