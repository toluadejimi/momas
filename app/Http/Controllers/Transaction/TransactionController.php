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

//        $fl = Setting::where('id', 1)->first();
//        $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
//        $flkey['flutterwave_public'] = $fl->flutterwave_public;
//        $pkkey['paystack_secret'] = $fl->paystack_secret;
//        $pkkey['paystack_public'] = $fl->paystack_public;
//
//        $data['amount'] = $request->amount;
//        $data['trx_id'] = $request->trx_id;
//        $data['email'] = $request->email;
//        $data['key'] = $flkey['flutterwave_public'];
//
//
//        return view('flutter-pay', $data);


        $message = "flutterwave = " . json_encode($request->all());
        send_notification($message);

        $fl = Setting::where('id', 1)->first();
        $secretKey = $fl->flutterwave_secret;
        $transactionId = $request->transaction_id;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$transactionId/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secretKey",
                "Cache-Control: no-cache",
            ),
        ));

        $var = curl_exec($curl);
        curl_close($curl);
        $var = json_decode($var);
        $status = $var->status ?? null;

            if ($status == 'success') {
                Transaction::where('trx_id', $request->tx_ref)->update(['status' => 2]);
                $ref = Transaction::where('trx_id', $request->tx_ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$request->tx_ref&status=success";
                return redirect($url);
            } else {
                $ref = Transaction::where('trx_id', $var->data->metadata->ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$request->tx_ref&status=failure";
                return redirect($url);
            }

    }


    public function make_payment(request $request)
    {

        if ($request->pay_type == 'flutterwave') {
            $trx_id = "TRX" . random_int(0000000, 9999999);
            $email = Auth::user()->email;
            $phone = Auth::user()->phone ?? "012345678";
            $fl = Setting::where('id', 1)->first();
            $secretKey = $fl->flutterwave_secret;
            $fpublic = $fl->flutterwave_public;
            $url = url('');

            $databody = array(
                'title' => 'Payment for services',
                'amount' => $request->amount,
                'currency' => 'NGN',
                'redirect_url' => $url . "/pay-flutter",
                'customer' => [
                    'email' => $email,
                    'phonenumber' => $phone,
                    'name' => Auth::user()->first_name . " " . Auth::user()->last_name,
                ],
                'tx_ref' => $trx_id,

            );

            $body = json_encode($databody);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
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
                    'Authorization: Bearer ' . $secretKey,
                ),
            ));

            $var = curl_exec($curl);
            curl_close($curl);
            $var = json_decode($var);
            $status = $var->status ?? null;


            $trx = new Transaction();
            $trx->user_id = Auth::id();
            $trx->pay_type = "flutterwave";
            $trx->service_type = $request->service;
            $trx->amount = $request->amount;
            $trx->trx_id = $trx_id;
            $trx->save();

            if ($status == "success") {
                return response()->json([
                    'status' => true,
                    'url' => $var->data->link
                ], 200);
            }


        }


        if ($request->pay_type == 'paystack') {
            $fl = Setting::where('id', 1)->first();
            $flkey['flutterwave_secret'] = $fl->flutterwave_secret;
            $flkey['flutterwave_public'] = $fl->flutterwave_public;
            $paystackkey = $fl->paystack_secret;
            $pkkey['paystack_public'] = $fl->paystack_public;


            $trx_id = "TRX" . random_int(0000000, 9999999);
            $email = Auth::user()->email;


            $databody = array(
                "amount" => $request->amount * 100,
                "email" => $email,
                "ref" => $trx_id,
                'metadata' => ["ref" => $trx_id],


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


            if ($status == true) {
                $trx = new Transaction();
                $trx->user_id = Auth::id();
                $trx->pay_type = "paystack";
                $trx->amount = $request->amount;
                $trx->trx_id = $trx_id;
                $trx->payment_ref = $var->data->access_code ?? null;
                $trx->service_type = $request->service;
                $trx->save();

                return response()->json([
                    'status' => true,
                    'url' => $var->data->authorization_url
                ], 200);

            }

            $code = 422;
            $message = "Payment not available at the moment, Kindly select other payment option";
            return error($message, $code);

        }


        if ($request->pay_type == 'remita') {
            $trx_id = "TRX" . random_int(0000000, 9999999);
            $email = Auth::user()->email;
            $trx = new Transaction();
            $trx->user_id = Auth::id();
            $trx->pay_type = "remita";
            $trx->service_type = "fund";
            $trx->amount = $request->amount;
            $trx->trx_id = $trx_id;
            $trx->save();

            return response()->json([
                'status' => true,
                'url' => url('') . "/pay-remita?amount=$request->amount&trx_id=$trx_id&email=$email"
            ], 200);
        }


        if ($request->pay_type == 'wallet') {
            $trx_id = "TRX" . random_int(0000000, 9999999);
            $email = Auth::user()->email;


            if (Auth::user()->main_wallet < $request->amount) {
                $code = 422;
                $message = "Insufficient Funds";
                return error($message, $code);
            }


            User::where('id', Auth::id())->decrement('main_wallet', $request->amount);

            $trx = new Transaction();
            $trx->user_id = Auth::id();
            $trx->pay_type = "wallet";
            $trx->amount = $request->amount;
            $trx->service_type = $request->service;
            $trx->trx_id = $trx_id;
            $trx->save();

            return response()->json([
                'status' => "success",
                'ref' => $trx_id,
            ], 200);

        }


    }


    public function all_transactions(request $request)
    {

        $trx = Transaction::where('user_id', Auth::id())->take(1000)->get();
        return response()->json([
            'status' => true,
            'data' => $trx,
        ], 200);

    }


    public function flutter_verify(request $request)
    {

        $fl = Setting::where('id', 1)->first();
        $flsecret = $fl->flutterwave_secret;
        $flkey['flutterwave_public'] = $fl->flutterwave_public;
        $transactionId = $request->transaction_id;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$transactionId/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $flsecret,
            ),
        ));

        $var = curl_exec($curl);
        curl_close($curl);
        $var = json_decode($var);

        $status = $var->status ?? null;
        $ref = $var->data->tx_ref ?? null;

        $ck_transaction = Transaction::where('trx_id', $var->data->tx_ref)->first()->status ?? null;
        if ($ck_transaction == null) {

            if ($status == 'success') {
                Transaction::where('trx_id', $var->data->tx_ref)->update(['status' => 4]);
                $ref = $var->data->tx_ref;
                $url = url('') . "/payment?ref=$ref&status=success";
                return redirect($url);
            }

        } else {
            $url = url('') . "/payment?ref=$ref&status=failure";
            return redirect($url);
        }


    }


    public function paystack_verify(request $request)
    {

        $message = "paystack=" . json_encode($request->all());
        send_notification($message);

        $fl = Setting::where('id', 1)->first();
        $pksecret = $fl->paystack_secret;
        $transactionId = $request->reference;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$transactionId",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $pksecret",
                "Cache-Control: no-cache",
            ),
        ));

        $var = curl_exec($curl);
        curl_close($curl);
        $var = json_decode($var);
        $status = $var->status ?? null;
        $ref = $var->data->reference ?? null;


        $ck_transaction = Transaction::where('trx_id', $var->data->reference)->first()->status ?? null;
        if ($ck_transaction == null) {

            if ($status == 'success') {
                Transaction::where('trx_id', $var->data->metadata->ref)->update(['status' => 2]);
                $ref = Transaction::where('trx_id', $var->data->metadata->ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$ref&status=success";
                return redirect($url);
            } else {
                $ref = Transaction::where('trx_id', $var->data->metadata->ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$ref&status=failure";
                return redirect($url);
            }

        }

    }
}

