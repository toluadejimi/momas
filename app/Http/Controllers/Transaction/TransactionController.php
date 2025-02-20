<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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
            $trx->estate_id = Auth::user()->estate_id;
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
                'callback_url' => url('') . "/paystack-check",
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

        $trx = Transaction::where('user_id', Auth::id())->take(1000)->get()->makeHidden('note');
        return response()->json([
            'status' => true,
            'data' => $trx,
        ], 200);

    }


    public function estate_transactions(request $request)
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


    public function transaction_reports(request $request)
    {


        if (Auth::user()->role == 0) {

            $data['transactions'] = Transaction::latest()->paginate('20');
            $data['total'] = Transaction::where('status', 2)->sum('amount');
            $data['estate'] = Estate::all();

            return view('admin.report.transactionreport', $data);


        } elseif (Auth::user()->role == 1) {

        } elseif
        (Auth::user()->role == 2) {

        } elseif
        (Auth::user()->role == 3) {

            $data['transactions'] = Transaction::latest()->where('estate_id', Auth::user()->estate_id)->paginate('20');
            $data['total'] = Transaction::where('status', 2)->where('estate_id', Auth::user()->estate_id)->sum('amount');

            return view('admin.report.transactionreport', $data);

        } elseif
        (Auth::user()->role == 4) {

        } elseif
        (Auth::user()->role == 5) {

        }


    }


    public function search_trx(request $request)
    {

        if (Auth::user()->role == 0) {


            $rrn = $request->rrn;
            $startofday = $request->from;
            $endofday = $request->to;
            $transaction_type = $request->transaction_type;
            $status = $request->status;
            $estate_id = $request->estate_id;
            $data['estate'] = Estate::all();




            if($startofday != null && $endofday != null &&  $rrn == null && $transaction_type == null && $status == null){

                $data['transactions'] =Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->latest()
                    ->where('status', 2)
                    ->take(50000)
                    ->paginate(50);

                $data['total'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->where('status', 2)
                    ->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);

            }

            if($rrn != null){

                $data['transactions'] =Transaction::where('trx_id', $rrn)->paginate(50);
                $data['total'] = Transaction::where('trx_id', $rrn)->sum('amount') ?? 0;

                return view('admin.report.transactionreport', $data);


            }


            if($estate_id != null){

                if($estate_id == "all"){

                    $data['transactions'] =Transaction::
                        latest()
                        ->where('status', 2)
                        ->take(50000)
                        ->paginate(50);

                    $data['total'] = Transaction::where('status', 2)->sum('amount') ?? 0;


                    return view('admin.report.transactionreport', $data);
                }

                $data['transactions'] =Transaction::where('estate_id', $estate_id)
                    ->latest()
                    ->where('status', 2)
                    ->take(50000)
                    ->paginate(50);

                $data['total'] = Transaction::where('estate_id', $estate_id)->where('status', 2)
                    ->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);

            }


            if($estate_id != null){

                if($estate_id == "all"){

                    $data['transactions'] =Transaction::
                     latest()
                        ->where('status', 2)
                        ->take(50000)
                        ->paginate(50);

                    $data['total'] = Transaction::where('status', 2)->sum('amount') ?? 0;


                    return view('admin.report.transactionreport', $data);
                }

                $data['transactions'] =Transaction::where('estate_id', $estate_id)
                    ->latest()
                    ->where('status', 2)
                    ->take(50000)
                    ->paginate(50);

                $data['total'] = Transaction::where('estate_id', $estate_id)
                   ->where('status', 2)
                    ->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);

            }


            if($startofday != null && $endofday != null &&  $rrn == null && $transaction_type != null && $status == null){


                $data['transactions'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->latest()
                    ->where('status', 2)
                    ->take(50000)
                    ->where('service_type', $transaction_type)
                    ->paginate(50);

                $data['total'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->where('service_type', $transaction_type)
                    ->where('status', 2)
                    ->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);


            }



            if($startofday != null && $endofday != null &&  $rrn == null && $transaction_type != null && $status != null){
                $data['transactions'] = Transaction::latest()->take(50000)->whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])->
                where([
                    'status' => $status,
                    'service_type' => $transaction_type,
                ])->paginate('50') ?? null;


                $data['total'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])->
                where([
                    'status' => $status,
                    'service_type' => $transaction_type,
                ])->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);

            }



            return back()->with('error', 'Select a field');



        }


        if (Auth::user()->role == 3) {


            $rrn = $request->rrn;
            $startofday = $request->from;
            $endofday = $request->to;
            $transaction_type = $request->transaction_type;
            $status = $request->status;



            if($startofday != null && $endofday != null &&  $rrn == null && $transaction_type == null && $status == null){

                $data['transactions'] =Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->latest()
                    ->where('estate_id', Auth::user()->estate_id)
                    ->take(50000)
                    ->paginate(50);

                $data['total'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->where('estate_id', Auth::user()->estate_id)
                    ->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);

            }


            if($startofday != null && $endofday != null &&  $rrn == null && $transaction_type != null && $status == null){


                $data['transactions'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->where([
                        'status' => $status,
                        'service_type' => $transaction_type,
                        'estate_id' => Auth::user()->estate_id
                    ])->paginate('50') ?? null;

                $data['total'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])
                    ->where([
                        'status' => $status,
                        'service_type' => $transaction_type,
                        'estate_id' => Auth::user()->estate_id
                    ])->paginate('50')
                    ->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);


            }



            if($startofday != null && $endofday != null &&  $rrn == null && $transaction_type != null && $status != null){
                $data['transactions'] = Transaction::latest()->take(50000)->whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])->
                where([
                    'status' => $status,
                    'service_type' => $transaction_type,
                    'estate_id' => Auth::user()->estate_id
                ])->paginate('50') ?? null;


                $data['total'] = Transaction::whereBetween('created_at', [$startofday . ' 00:00:00', $endofday . ' 23:59:59'])->
                where([
                    'status' => $status,
                    'service_type' => $transaction_type,
                    'estate_id' => Auth::user()->estate_id

                ])->sum('amount') ?? 0;


                return view('admin.report.transactionreport', $data);

            }



            return back()->with('error', 'Select a field');



        }



    }



}

