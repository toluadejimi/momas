<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{



    public function flutter_payment(request $request)
    {

        $fl = Setting::where('id', 1)->first();
        $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
        $flkey['flutterwave_public'] = $fl->flutterwave_public;
        $pkkey['paystack_secret'] = $fl->paystack_secret;
        $pkkey['paystack_public'] = $fl->paystack_public;


        $data['amount'] = $request->amount;
        $data['trx_id'] = $request->trx_id;
        $data['email'] = $request->email;
        $data['key'] = $flkey['flutterwave_public'];


        return view('flutter-pay', $data);

    }


    public function make_payment(request $request)
    {

        if($request->pay_type == 'flutterwave'){

            $trx_id = "FUND".random_int(0000000, 9999999);
            $email = Auth::user()->email;
            $trx =  new Transaction();
            $trx->user_id = Auth::id();
            $trx->pay_type = "flutterwave";
            $trx->amount = $request->amount;
            $trx->trx_id = $trx_id;
            $trx->save();

            return response()->json([
                'status' => true,
                'url' => url('')."/pay-flutter?amount=$request->amount&trx_id=$trx_id&email=$email"
            ], 200);


        }


        if($request->pay_type == 'paystack'){


            $fl = Setting::where('id', 1)->first();
            $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
            $flkey['flutterwave_public'] = $fl->flutterwave_public;
            $paystackkey = $fl->paystack_secret;
            $pkkey['paystack_public'] = $fl->paystack_public;


            $trx_id = "FUND".random_int(0000000, 9999999);
            $email = Auth::user()->email;


            $databody = array(
                "amount" => $request->amount * 100,
                "email" => $email,
            );

            $body = json_encode($databody);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.paystack.co/transaction/initialize',
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
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $paystackkey,
                ),
            ));

            $var = curl_exec($curl);
            curl_close($curl);
            $var = json_decode($var);
            $status = $var->status;

            if($status == true){
                $trx =  new Transaction();
                $trx->user_id = Auth::id();
                $trx->pay_type = "paystack";
                $trx->amount = $request->amount;
                $trx->trx_id = $trx_id;
                $trx->save();

                return response()->json([
                    'status' => true,
                    'url' => $var->data->authorization_url
                ], 200);

            }



            $code = 422;
            $message="Payment not available at the moment, Kindly select other payment option";
            error($message, $code);




        }


        if($request->pay_type == 'remita'){
            $trx_id = "FUND".random_int(0000000, 9999999);
            $email = Auth::user()->email;
            $trx =  new Transaction();
            $trx->user_id = Auth::id();
            $trx->pay_type = "remita";
            $trx->amount = $request->amount;
            $trx->trx_id = $trx_id;
            $trx->save();

            return response()->json([
                'status' => true,
                'url' => url('')."/pay-remita?amount=$request->amount&trx_id=$trx_id&email=$email"
            ], 200);
        }


        if($request->pay_type == 'wallet'){
            $trx_id = "FUND".random_int(0000000, 9999999);
            $email = Auth::user()->email;


            if($request->amount < Auth::user()->wallet){
                $code = 422;
                $message = "Insufficient Funds";
                error($message, $code);
            }

            User::where('id', Auth::id())->decrement('main_wallet', $request->amount);

            $trx =  new Transaction();
            $trx->user_id = Auth::id();
            $trx->pay_type = "wallet";
            $trx->amount = $request->amount;
            $trx->trx_id = $trx_id;
            $trx->save();

            return response()->json([
                'status' => true,
                'message' => "Payment Approved"
            ], 200);
        }


    }
}