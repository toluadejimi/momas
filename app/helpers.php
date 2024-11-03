<?php


use App\Models\Token;
use App\Models\User;
use App\Models\Meter;
use App\Models\Setting;
use App\Models\Terminal;
use App\Models\Dyaccount;
use App\Models\TidConfig;
use App\Models\UtilitiesPayment;
use App\Models\Utitlity;
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


if (!function_exists('token')) {

    function token()
    {

        $email = env('ENKPAYEMAIL');
        $passsword = env('ENKPAYPASSWORD');


        $databody = array(
            "email" => $email,
            "password" => $passsword,

        );

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://web.enkpay.com/api/auth',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $var = curl_exec($curl);
        curl_close($curl);
        $var = json_decode($var);
        $status = $var->status ?? null;


        if ($status == true) {
            return $var->Authorization;
        } else {
            return false;
        }
    }



}



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


if (!function_exists('total_utility')) {

    function total_utility($estate_id)
    {

        $total_utility =  Utitlity::where('estate_id', $estate_id)->sum('amount');
        return $total_utility;

    }
}




if (!function_exists('vend')) {

    function vend($duration, $estate_id)
    {



        if($duration == "daily"){


            $total = total_utility($estate_id);
          $chk_pay =  UtilitiesPayment::where([
                'user_id' => Auth::id(),
                'estate_id' => $estate_id
          ])->whereDate('created_at', Carbon::today())->get() ?? null;

            if($chk_pay == null || $chk_pay->isEmpty()){
              return $total;
            }else{
                foreach ($chk_pay as $data) {
                    $totalck += $data->amount;
                }
                $ftotal = $total - $totalck;
                return $ftotal;
            }

        }

        if($duration == "weekly"){

            $total = total_utility($estate_id);
            $chk_pay =  UtilitiesPayment::where([
                'user_id' => Auth::id(),
                'estate_id' => $estate_id
            ])->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get() ?? null;

            if($chk_pay == null || $chk_pay->isEmpty()){
                return $total;
            }else{
                foreach ($chk_pay as $data) {
                    $totalck += $data->amount;
                }
                $ftotal = $total - $totalck;
                return $ftotal;
            }

        }

        if($duration == "monthly"){

            $total = total_utility($estate_id);
            $chk_pay =  UtilitiesPayment::where([
                'user_id' => Auth::id(),
                'estate_id' => $estate_id
            ])->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get() ?? null;

            if($chk_pay == null || $chk_pay->isEmpty()){
                return $total;
            }else{
                foreach ($chk_pay as $data) {
                    $totalck += $data->amount;
                }
                $ftotal = $total - $totalck;
                return $ftotal;
            }

        }


        if($duration == "yearly"){


            $total = total_utility($estate_id);
            $chk_pay =  UtilitiesPayment::where([
                'user_id' => Auth::id(),
                'estate_id' => $estate_id
            ])->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get() ?? null;

            if($chk_pay == null || $chk_pay->isEmpty()){
                return $total;
            }else{
                foreach ($chk_pay as $data) {
                    $totalck += $data->amount;
                }
                $ftotal = $total - $totalck;
                return $ftotal;
            }

        }


    }
}



if (!function_exists('send_login_code')) {

    function send_login_code($email, $code)
    {
        $first_name = User::where('email', $email)->first()->first_name;
        $data = array(
            'fromsender' => 'momas@tomitechltd.com', 'MOMASPAY',
            'subject' => "One Time Password",
            'toreceiver' => $email,
            'code' => $code,
            'user' => $first_name,
        );

        Mail::send('emails.loginotp', ["data1" => $data], function ($message) use ($data) {
            $message->from($data['fromsender']);
            $message->to($data['toreceiver']);
            $message->subject($data['subject']);
        });


        return 0;

    }
}




if (!function_exists('send_email')) {

    function send_email($email, $sms_code)
    {
        $first_name = User::where('email', $email)->first()->first_name;
        $data = array(
            'fromsender' => 'momas@tomitechltd.com', 'MOMASPAY',
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

if (!function_exists('send_email_token')) {

    function send_email_token($email, $token, $amount, $unit)
    {
        $first_name = User::where('email', $email)->first()->first_name;
        $data = array(
            'fromsender' => 'momas@tomitechltd.com', 'MOMASPAY',
            'subject' => "Token Purchase",
            'toreceiver' => $email,
            'token' => $token,
            'user' => $first_name,
            'unit' => $unit,
            'amount' => $amount
        );

        Mail::send('emails.vendtoken', ["data1" => $data], function ($message) use ($data) {
            $message->from($data['fromsender']);
            $message->to($data['toreceiver']);
            $message->subject($data['subject']);
        });


        return 0;

    }
}




if (!function_exists('send_token_email')) {

    function send_token_email($email, $token_code, $estate, $valid_date)
    {



        $data = array(
            'fromsender' => 'support@tomitechltd.com', 'MOMASPAY',
            'subject' => "Pass Token",
            'toreceiver' => $email,
            'token_code' => $token_code,
            'estate' => $estate,
            'valid_date' => $valid_date,


        );

        Mail::send('emails.token', ["data1" => $data], function ($message) use ($data) {
            $message->from($data['fromsender']);
            $message->to($data['toreceiver']);
            $message->subject($data['subject']);
        });

        return $token_code;

    }
}



if (!function_exists('generate_token')) {

    function generate_token($user_id, $visitor, $email, $valid_date)
    {

        $usr = User::where('id', Auth::id())->first();
        $get_token = random_int(000000, 999999);
        $tok = new Token();
        $tok->user_id = $user_id;
        $tok->token = $get_token;
        $tok->visitor = $visitor;
        $tok->email = $email;
        $tok->address = $usr->address." ".$usr->city." ".$usr->state;
        $tok->valid_date = $valid_date;

        $tok->save();

        return $get_token;

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
