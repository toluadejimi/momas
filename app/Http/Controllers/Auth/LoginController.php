<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OauthAccessToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class LoginController extends Controller
{
    public function login(request $request)
    {

        $credentials = request(['meterNo', 'password']);

        $usr = User::where('meterNo', $request->meterNo)->first() ?? null;

        if($usr == null){
            $message = "User does not exist";
            return error($message);
        }

        Passport::tokensExpireIn(Carbon::now()->addMinutes(20));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(20));

        if (!auth()->attempt($credentials)) {
            $message = "Meter No or Password Incorrect";
            return error($message);
        }

        flush_token();

        $token = auth()->user()->createToken('API Token')->accessToken;

        $user = user();
        $user['token'] = $token;

        return response()->json([
            'status' => true,
            'user' => $user
        ]);











    }
}
