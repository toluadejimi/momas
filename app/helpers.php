<?php


use App\Models\User;
use App\Models\Meter;
use App\Models\Setting;
use App\Models\Terminal;
use App\Models\Dyaccount;
use App\Models\TidConfig;
use App\Models\Webaccount;
use App\Models\Transaction;
use App\Models\VirtualAccount;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use App\Models\OauthAccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;





if (!function_exists('error')) {

    function error($message, $code)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}

if (!function_exists('success')) {

    function success($message)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
        ], 200);
    }
}


if (!function_exists('user')) {

    function user()
    {
        $user = User::where('id', Auth::id())->first()->makeHidden(['created_at', 'updated_at']);
        return $user;
    }
}


if (!function_exists('validate_code')) {

    function validate_code($code, $email)
    {
        $get_code =  User::where('email', $email)->first()->code;
        if($get_code == $code){
            $vv = User::where('email', $email)->where('code', $code)->update(['status' => 1]);
            return 0;
        }else{
            return 3;
        }
    }
}


if (!function_exists('meter')) {

    function meter()
    {

        $ck_meter =  Meter::where('user_id', Auth::id())->first() ?? null;

        if($ck_meter == null){
            return [];
        }
    

        $meter = Meter::where('user_id', Auth::id())->first()->makeHidden(['created_at', 'updated_at']) ?? [];
        return $meter;
    }
}





if (!function_exists('flush_token')) {

    function flush_token()
    {
        $get_token = OauthAccessToken::where('user_id', Auth::id())->first()->user_id ?? null;
        if($get_token != null){
            OauthAccessToken::where('user_id', Auth::id())->delete();
        }

        return 0;

    }
}



if (!function_exists('send_email')) {

    function send_email($email, $sms_code)
    {
        $first_name = User::where('email', $email)->first()->first_name;
        $data = array(
            'fromsender' => 'noreply@momaspay.bplux.store', 'MOMASPAY',
            'subject' => "One Time Password",
            'toreceiver' => $email,
            'sms_code' => $sms_code,
            'user' => $first_name,

        );

        Mail::send('emails.email', ["data1" => $data], function ($message) use ($data) {
            $message->from($data['fromsender']);
            $message->to($data['toreceiver']);
            $message->subject($data['subject']);
        });

      
        return 0;

    }
}











if (!function_exists('send_notification')) {

    function send_notification($message)
    {

        $response = Http::post('https://api.telegram.org/bot6140179825:AAGfAmHK6JQTLegsdpnaklnhBZ4qA1m2c64/sendMessage?chat_id=1316552414', [
            'chat_id' => "1316552414",
            'text' => $message,

        ]);
        $responseData = $response->json();


    }
}
