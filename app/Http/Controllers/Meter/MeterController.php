<?php

namespace App\Http\Controllers\Meter;

use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeterController extends Controller
{
    public function validate_meter(request $request)
    {

        $user = User::where('meterNo', $request->meterNo)->first() ?? null;

        if($user == null){
            $message = "Validation Failed, please check meter number";
            $code = 422;
            error($message, $code);
        }

        $meter_type = Meter::where('meterNo', $request->meterNo)->first()->payType;

        $data['customer_name'] = $user->first_name. " ".$user->last_name;
        $data['address'] = $user->address. ", ".$user->city. ", ".$user->state;
        $data['meter_type'] = $meter_type;



        return response()->json([
           'status' => true,
           'data' => $data

        ]);


    }


    public function buy_meter_token(request $request)
    {

        $amount = $request->amount;
        $meterNo = Auth::user()->meterNo;
        $meterType = $request->meterType;
        $trx = $request->trxref;
        $date = date('ymd');
        $dater = date('d-m-y');
        $date_time=date('ydis');



        $percentage = 2.5 / 100;
        $final_amount = $percentage * $amount;

        $databody = array(

        );

        $url = "http://41.216.166.163:8080/MomasPayService/api/Payment/$meterNo/$meterType/999/$date_time$trx/$amount/999/$date/$final_amount/false";

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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

        $var2 = curl_exec($curl);
        curl_close($curl);
        $var = json_decode($var2);


        dd($var2, $var, $url, $_SERVER['SERVER_ADDR']);

        $data['full_name'] =  Auth::user()->first_name." ".Auth::user()->last_name;
        $data['address'] =  Auth::user()->address.",".Auth::user()->city.",".Auth::user()->state;
        $data['service'] =  "MOMAS";
        $data['order_id'] =  $trx;
        $data['token'] =  "3394848484884884848";
        $data['amount'] =  $amount;
        $data['date'] =  $dater;


        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200);





    }


    public function pay_for_others_meter_token(request $request)
    {

        $amount = $request->amount;
        $meterNo = $request->meterNo;
        $meterType = $request->meterType;
        $estate_id = $request->estate_id;
        $trx = $request->trxref;
        $date = date('ymd');
        $percentage = 2.5 / 100;
        $final_amount = $percentage * $amount;
        $dater = date('d-m-y');


        $databody = array(
        );

        $url = "http://41.216.166.163:8080/MomasPayService/api/Payment/$meterNo/$meterType/999/$trx/$amount/999/$date/$final_amount/true";

        $body = json_encode($databody);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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




        $data['full_name'] =  Auth::user()->first_name." ".Auth::user()->last_name;
        $data['address'] =  Auth::user()->address.",".Auth::user()->city.",".Auth::user()->state;
        $data['service'] =  "MOMAS";
        $data['order_id'] =  $trx;
        $data['token'] =  "3394848484884884848";
        $data['amount'] =  $amount;
        $data['date'] =  $dater;


        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200);







    }


    public function reprint_meter_token(request $request)
    {

      $token =  MeterToken::where('status', 2)->where('user_id', Auth::id())->get();
      return response()->json([
          'status'=> true,
          'data' => $token
      ], 200);



    }


    public function get_token(request $request)
    {



        $data['token'] =  MeterToken::where('id', $request->token_id)->get();
        $data['full_name'] =  Auth::user()->first_name." ".Auth::user()->last_name;
        $data['address'] =  Auth::user()->address.",".Auth::user()->city.",".Auth::user()->state;
        $data['service'] =  "Reprint";


        return response()->json([
            'status'=> true,
            'data' => $data
        ], 200);

    }

}
