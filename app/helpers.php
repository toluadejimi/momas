<?php


use App\Models\Dyaccount;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Terminal;
use App\Models\Webaccount;
use App\Models\TidConfig;
use App\Models\VirtualAccount;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;
use App\Models\OauthAccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


function getPaginate($paginate = 20)
{
    return $paginate;
}

function paginateLinks($data)
{
    return $data->appends(request()->all())->links();
}





if (!function_exists('error')) {

    function error($message)
    {

        return response()->json([
            'status' => false,
            'message' => $message,
        ], 500);
    }
}

if (!function_exists('user')) {

    function user()
    {
        $user = User::where('id', Auth::id())->first()->makeHidden(['created_at', 'updated_at']);;
        return $user;
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
        $data = array(
            'fromsender' => 'noreply@enkpay.com', 'MOMASPAY',
            'subject' => "One Time Password",
            'toreceiver' => $email,
            'sms_code' => $sms_code,
        );

        Mail::send('emails.otpcode', ["data1" => $data], function ($message) use ($data) {
            $message->from($data['fromsender']);
            $message->to($data['toreceiver']);
            $message->subject($data['subject']);
        });

        return response()->json([
            'status' => true,
            'message' => "OTP Code has been sent successfully to $email",
        ], 200);

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
