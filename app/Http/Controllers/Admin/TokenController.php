<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompensationToken;
use App\Models\CreditToken;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\Setting;
use App\Models\TarrifState;
use App\Models\Transaction;
use App\Models\User;
use App\Services\VatCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Lcobucci\JWT\Exception;


class TokenController extends Controller
{


    public function credit_token_index()
    {


        if (auth::user()->role == 0) {


            $data['estate'] = Estate::all();
            $data['preview'] = null;
            $data['credit_tokens'] = CreditToken::latest()->paginate('50');

            return view('admin.token.credit-token-view', $data);


        } elseif (auth::user()->role == 1) {

        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


            $data['estate_id'] = Auth::user()->estate_id;
            $data['title'] = Estate::where('id', Auth::user()->estate_id)->first()->title;
            $data['preview'] = null;
            $data['credit_tokens'] = CreditToken::latest()->where('estate_id', Auth::user()->estate_id)->paginate('50');

            return view('admin.token.credit-token-view', $data);


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }


    public function compensation_index()
    {


        if (auth::user()->role == 0) {


            $data['estate'] = Estate::all();
            $data['preview'] = null;
            $data['credit_tokens'] = CompensationToken::latest()->paginate('50');

            return view('admin.token.compensation-token-view', $data);


        } elseif (auth::user()->role == 1) {

        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


            $data['estate_id'] = Auth::user()->estate_id;
            $data['title'] = Estate::where('id', Auth::user()->estate_id)->first()->title;
            $data['preview'] = null;
            $data['credit_tokens'] = CompensationToken::latest()->where('estate_id', Auth::user()->estate_id)->paginate('50');

            return view('admin.token.compensation-token-view', $data);


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }


    public function validate_compensation_meter(request $request)
    {


        if (auth::user()->role == 0) {


            $estate_id = Estate::where('title', $request->estate_id)->first()->id;
            $meter = Meter::where('meterNo', $request->meterNo)->first() ?? null;
            $user = User::where('meterNo', $request->meterNo)->first() ?? null;

            if ($meter == null) {
                return back()->with('error', 'Meter not found on our system');
            }
            if ($meter->estate_id != $estate_id) {
                return back()->with('error', 'Meter not does not belong to estate selected');
            }
            if ($request->amount < 1000) {
                return back()->with('error', 'Amount can not be less than NGN 1,000');
            }

            if ($user == null) {
                return back()->with('error', 'Meter has not been attached to any customer');
            }


            $tariffAmount = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;
            $vat = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;


            $calculator = new VatCalculator();
            $params = [
                'amountText' => $request->amount,
                'tariffAmount' => $tariffAmount,
                'utilitiesAmount' => 0,
                'vat' => $vat,
            ];

            $vatAmount = $calculator->calculateVatAmount($params);
            $costOfUnit = $calculator->calculateCostOfUnit($params);
            $tariffPerKWatt = $calculator->calculateTariffAmountPerKWatt($params);

            $data['vatAmount'] = $vatAmount;
            $data['costOfUnit'] = $costOfUnit;
            $data['tariffPerKWatt'] = $tariffPerKWatt;
            $data['user'] = $user;
            $data['meter'] = $meter;
            $data['estate'] = Estate::where('id', $estate_id)->first();
            $data['preview'] = "on";
            $data['amount'] = $request->amount;
            $data['vat'] = $vat;
            $data['estate_id'] = $estate_id;
            $data['estate_name'] = $request->estate_id;
            $data['credit_tokens'] = CreditToken::latest()->paginate('50');


            return view('admin.token.compensation-token-view', $data);


        } elseif (auth::user()->role == 1) {

        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


            $estate_id = Estate::where('title', $request->estate_id)->first()->id;
            $meter = Meter::where('meterNo', $request->meterNo)->first() ?? null;
            $user = User::where('meterNo', $request->meterNo)->first() ?? null;

            if ($meter == null) {
                return back()->with('error', 'Meter not found on our system');
            }
            if ($meter->estate_id != $estate_id) {
                return back()->with('error', 'Meter not does not belong to estate selected');
            }
            if ($request->amount < 1000) {
                return back()->with('error', 'Amount can not be less than NGN 1,000');
            }

            if ($user == null) {
                return back()->with('error', 'Meter has not been attached to any customer');
            }


            $tariffAmount = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;
            $vat = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;


            $calculator = new VatCalculator();
            $params = [
                'amountText' => $request->amount,
                'tariffAmount' => $tariffAmount,
                'utilitiesAmount' => 0,
                'vat' => $vat,
            ];

            $vatAmount = $calculator->calculateVatAmount($params);
            $costOfUnit = $calculator->calculateCostOfUnit($params);
            $tariffPerKWatt = $calculator->calculateTariffAmountPerKWatt($params);

            $data['vatAmount'] = $vatAmount;
            $data['costOfUnit'] = $costOfUnit;
            $data['tariffPerKWatt'] = $tariffPerKWatt;
            $data['user'] = $user;
            $data['meter'] = $meter;
            $data['estate'] = Estate::where('id', $estate_id)->first();
            $data['amount'] = $request->amount;
            $data['vat'] = $vat;
            $data['estate_name'] = $request->estate_id;
            $data['credit_tokens'] = CreditToken::latest()->where('estate_id', Auth::user()->estate_id)->paginate('50');
            $data['estate_id'] = Auth::user()->estate_id;
            $data['title'] = Estate::where('id', Auth::user()->estate_id)->first()->title;
            $data['preview'] = "on";


            return view('admin.token.compensation-token-view', $data);


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }

    public function validate_meter(request $request)
    {


        if (auth::user()->role == 0) {


            $estate_id = Estate::where('title', $request->estate_id)->first()->id;
            $meter = Meter::where('meterNo', $request->meterNo)->first() ?? null;
            $user = User::where('meterNo', $request->meterNo)->first() ?? null;

            if ($meter == null) {
                return back()->with('error', 'Meter not found on our system');
            }
            if ($meter->estate_id != $estate_id) {
                return back()->with('error', 'Meter not does not belong to estate selected');
            }
            if ($request->amount < 1000) {
                return back()->with('error', 'Amount can not be less than NGN 1,000');
            }

            if ($user == null) {
                return back()->with('error', 'Meter has not been attached to any customer');
            }


            $tariffAmount = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;
            $vat = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;


            $calculator = new VatCalculator();
            $params = [
                'amountText' => $request->amount,
                'tariffAmount' => $tariffAmount,
                'utilitiesAmount' => 0,
                'vat' => $vat,
            ];

            $vatAmount = $calculator->calculateVatAmount($params);
            $costOfUnit = $calculator->calculateCostOfUnit($params);
            $tariffPerKWatt = $calculator->calculateTariffAmountPerKWatt($params);


            $est = Estate::where('id', $estate_id)->first();
            if ($est->charge_fee < 0) {

                $fee_in_percent = $est->charge_fee_percent;
                $fee = ($fee_in_percent / $request->amount) * 100;
            } else {
                $fee = $est->charge_fee;
            }


            $data['vatAmount'] = $vatAmount;
            $data['costOfUnit'] = $costOfUnit;
            $data['tariffPerKWatt'] = $tariffPerKWatt;
            $data['user'] = $user;
            $data['meter'] = $meter;
            $data['estate'] = Estate::where('id', $estate_id)->first();
            $data['preview'] = "on";
            $data['amount'] = $request->amount + $fee;
            $data['vat'] = $vat;
            $data['estate_id'] = $estate_id;
            $data['estate_name'] = $request->estate_id;
            $data['credit_tokens'] = CreditToken::latest()->paginate('50');


            return view('admin.token.credit-token-view', $data);


        } elseif (auth::user()->role == 1) {

        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


            $estate_id = Estate::where('title', $request->estate_id)->first()->id;
            $meter = Meter::where('meterNo', $request->meterNo)->first() ?? null;
            $user = User::where('meterNo', $request->meterNo)->first() ?? null;

            if ($meter == null) {
                return back()->with('error', 'Meter not found on our system');
            }
            if ($meter->estate_id != $estate_id) {
                return back()->with('error', 'Meter not does not belong to estate selected');
            }
            if ($request->amount < 1000) {
                return back()->with('error', 'Amount can not be less than NGN 1,000');
            }

            if ($user == null) {
                return back()->with('error', 'Meter has not been attached to any customer');
            }


            $tariffAmount = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;
            $vat = TarrifState::where('estate_id', $estate_id)->first()->amount ?? 0;


            $calculator = new VatCalculator();
            $params = [
                'amountText' => $request->amount,
                'tariffAmount' => $tariffAmount,
                'utilitiesAmount' => 0,
                'vat' => $vat,
            ];

            $vatAmount = $calculator->calculateVatAmount($params);
            $costOfUnit = $calculator->calculateCostOfUnit($params);
            $tariffPerKWatt = $calculator->calculateTariffAmountPerKWatt($params);

            $est = Estate::where('id', $estate_id)->first();
            if ($est->charge_fee < 0) {

                $fee_in_percent = $est->charge_fee_percent;
                $fee = ($fee_in_percent / $request->amount) * 100;
            } else {
                $fee = $est->charge_fee;
            }


            $data['vatAmount'] = $vatAmount;
            $data['costOfUnit'] = $costOfUnit;
            $data['tariffPerKWatt'] = $tariffPerKWatt;
            $data['user'] = $user;
            $data['meter'] = $meter;
            $data['estate'] = Estate::where('id', $estate_id)->first();
            $data['amount'] = $request->amount + $fee;
            $data['vat'] = $vat;
            $data['estate_name'] = $request->estate_id;
            $data['credit_tokens'] = CreditToken::latest()->where('estate_id', Auth::user()->estate_id)->paginate('50');
            $data['estate_id'] = Auth::user()->estate_id;
            $data['title'] = Estate::where('id', Auth::user()->estate_id)->first()->title;
            $data['preview'] = "on";


            return view('admin.token.credit-token-view', $data);


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }


    public function generate_credit_meter_token(request $request)
    {


        $order_id = "TRX" . random_int(000000000, 9999999999);
        $estate_id = Estate::where('title', $request->estate_name)->first()->id;
        $cdt = new CreditToken();
        $cdt->user_id = $request->user_id;
        $cdt->order_id = $order_id;
        $cdt->meterNo = $request->meterNo;
        $cdt->amount = $request->amount;
        $cdt->vat = $request->vat;
        $cdt->estate_name = $request->estate_name;
        $cdt->estate_id = $estate_id;
        $cdt->tariff_id = TarrifState::where('estate_id', $estate_id)->first()->tariff_id;
        $cdt->vatAmount = $request->vatAmount;
        $cdt->costOfUnit = $request->costOfUnit;
        $cdt->tariffPerKWatt = $request->tariffPerKWatt;
        $cdt->save();


        try {

            if ($request->pay_type == 'flutterwave') {


                $estate_id = $request->estate_id;
                $est = Estate::where('id', $estate_id)->first();
                if ($est->charge_fee < 0) {

                    $fee_in_percent = $est->charge_fee_percent;
                    $fee = ($fee_in_percent / $request->amount) * 100;
                } else {
                    $fee = $est->charge_fee;
                }


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
                    'redirect_url' => $url . "/admin/pay-flutter-web",
                    'customer' => [
                        'email' => $email,
                        'phonenumber' => $phone,
                        'name' => Auth::user()->first_name . " " . Auth::user()->last_name,
                    ],
                    'tx_ref' => $order_id,

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
                $trx->fee = $fee;
                $trx->trx_id = $order_id;
                $trx->save();

                if ($status == "success") {
                    return redirect()->away($var->data->link);

                }


            }


            if ($request->pay_type == 'paystack') {

                $estate_id = $request->estate_id ?? null;
                if ($estate_id === null) {
                    $estate_id = Auth::user()->estate_id;
                }
                $est = Estate::where('id', $estate_id)->first();
                if ($est->charge_fee < 0) {

                    $fee_in_percent = $est->charge_fee_percent;
                    $fee = ($fee_in_percent / $request->amount) * 100;
                } else {
                    $fee = $est->charge_fee;
                }


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
                    'callback_url' => url('') . "/admin/paystack-check-web",
                    'metadata' => ["ref" => $order_id],
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
                    $trx->user_id = $request->user_id;
                    $trx->pay_type = "paystack";
                    $trx->amount = $request->amount;
                    $trx->fee = $fee;
                    $trx->trx_id = $order_id;
                    $trx->payment_ref = $var->data->access_code ?? null;
                    $trx->service_type = "credit_token";
                    $trx->save();

                    return redirect()->away($var->data->authorization_url);

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


        } catch (Exception $e) {
            return back()->with('error', $e);
        }

    }


    public function generate_compensation_meter_token(request $request)
    {

        $order_id = "COMP" . random_int(000000, 999999);
        $estate_id = Estate::where('title', $request->estate_name)->first()->id;
        $cdt = new CompensationToken();
        $cdt->user_id = $request->user_id;
        $cdt->order_id = $order_id;
        $cdt->meterNo = $request->meterNo;
        $cdt->amount = $request->amount;
        $cdt->vat = $request->vat;
        $cdt->estate_name = $request->estate_name;
        $cdt->estate_id = $estate_id;
        $cdt->tariff_id = TarrifState::where('estate_id', $estate_id)->first()->tariff_id;
        $cdt->vatAmount = $request->vatAmount;
        $cdt->costOfUnit = $request->costOfUnit;
        $cdt->tariffPerKWatt = $request->tariffPerKWatt;
        $cdt->save();


        $meter = Meter::where('meterNo', $request->meterNo)->first() ?? null;
        if ($meter == null) {
            return back()->with('error', "meter not found");
        }

        $tariff_id = TarrifState::where('estate_id', $estate_id)->first()->tariff_id ?? null;
        if ($tariff_id == null) {
            return back()->with('error', "Tariff ID not set");
        }


        dd((int)$request->tariffPerKWatt);


        $databody = [
            'meterType' => $meter->KRN1 ?? "STS6",
            'meterNo' => $meter->meterNo,
            'sgc' => (int)$meter->OldSGC ?? 901102,
            'ti' => $tariff_id,
            'amount' => (int)$request->tariffPerKWatt,
        ];


        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 10,
        ])->post('http://169.239.189.91:19071/tokenGen', $databody);
        $error = $response->json() ?? null;


        if ($response->successful()) {
            $get_token = $response->json();
            $token_data = json_decode($get_token, true);
            $status = $token_data['code'] ?? null;


            if ($status == "SUCCESS") {

                $token = $token_data['tokens'][0];
                $user = User::where('id', $meter->user_id)->first();
                $email = $user->email;
                $amount = $request->amount;
                send_email_token($email, $token, $amount);


                $trx = new Transaction();
                $trx->trx_id = $order_id;
                $trx->user_id = $meter->user_id;
                $trx->estate_id = $estate_id;
                $trx->pay_type = null;
                $trx->service_type = "compensation_token";
                $trx->tariff_id = $tariff_id;
                $trx->payment_ref = "Meter Token";
                $trx->amount = $request->amount;
                $trx->unit_amount = $request->costOfUnit;
                $trx->save();

                return redirect("admin/recepit?trx_id=$trx->trx_id&type=compensation");


            } else {

                $trx = new Transaction();
                $trx->trx_id = "COMP" . random_int(000000, 999999);
                $trx->user_id = $meter->user_id;
                $trx->estate_id = $estate_id;
                $trx->pay_type = null;
                $trx->service_type = "compensation_token";
                $trx->tariff_id = $tariff_id;
                $trx->payment_ref = "Meter Token";
                $trx->amount = $request->amount;
                $trx->unit_amount = $request->costOfUnit;
                $trx->save();

                Transaction::where('trx_id', $trx)->update([
                    'service' => "METER PURCHASE",
                    'service_type' => "meter",
                    'status' => 3,
                    'tariff_id' => $request->tariff_id,
                    'note' => json_encode($get_token) . "|" . json_encode($databody)

                ]);

                User::where('id', Auth::id())->increment('main_wallet', $trx->amount);


                return redirect('admin/credit-token')->with('error', $error['errors'][0]['title'] ?? $get_token->json() . " | " . json_encode($databody));

            }


        }


        return redirect('admin/credit-token')->with('error', $error['errors'][0]['title'] ?? $get_token->json() . " | " . json_encode($databody));


    }


    public
    function paystack_verify_web(request $request)
    {

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
                $meterNo = CreditToken::where('order_id', $var->data->metadata->ref)->first()->meterNo;
                $meter = Meter::where('meterNo', $meterNo)->first();
                $trx = CreditToken::where('order_id', $var->data->metadata->ref)->first();
                $traff_id = CreditToken::where('order_id', $var->data->metadata->ref)->first();


                $databody = [
                    'meterType' => $meter->KRN1,
                    'meterNo' => $meter->meterNo,
                    'sgc' => (int)$meter->OldSGC,
                    'ti' => $trx->tariff_id,
                    'amount' => (int)$trx->tariffPerKWatt,
                ];


                $no_kct_response = Http::withOptions([
                    'verify' => false,
                    'timeout' => 10,
                ])->post('http://169.239.189.91:19071/tokenGen', $databody);
                $error = $no_kct_response->json() ?? null;


                if ($no_kct_response->successful()) {
                    $no_kct = $no_kct_response->json();
                    $no_kct_data = json_decode($no_kct, true);
                    $status = $no_kct_data['code'] ?? null;


                    if ($status == "SUCCESS") {

                        $no_kct_token = $no_kct_data['tokens'][0];
                        CreditToken::where('order_id', $var->data->metadata->ref)->update([

                            'token' => $no_kct_token,
                            'status' => 2

                        ]);

                        $trx_id = $var->data->metadata->ref;
                        $user = User::where('id', $trx->user_id)->first();
                        $email = $user->email;
                        $token = $no_kct_token;
                        $amount = $trx->amount;


                        send_email_token($email, $token, $amount);


                        Transaction::where('trx_id', $trx)->update([
                            'status' => 2,
                        ]);

                        return redirect("admin/recepit?trx_id=$trx_id");


                    } else {

                        Transaction::where('trx_id', $trx)->update([
                            'service' => "METER PURCHASE",
                            'service_type' => "meter",
                            'status' => 3,
                            'tariff_id' => $request->tariff_id,
                            'note' => json_encode($no_kct_data) . "|" . json_encode($databody)


                        ]);

                        User::where('id', Auth::id())->increment('main_wallet', $trx->amount);


                        return redirect('admin/credit-token')->with('error', $error['errors'][0]['title'] ?? $no_kct_response->json() . " | " . json_encode($databody));

                    }


                }


                return redirect('admin/credit-token')->with('error', $error['errors'][0]['title'] ?? $no_kct_response->json() . " | " . json_encode($databody));


            } else {
                $ref = Transaction::where('trx_id', $var->data->metadata->ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$ref&status=failure";
                return redirect($url);
            }

        }

        if ($ck_transaction == 0) {

            if ($status == 'success') {


                Transaction::where('trx_id', $var->data->metadata->ref)->update(['status' => 2]);
                $meterNo = CreditToken::where('order_id', $var->data->metadata->ref)->first()->meterNo;
                $meter = Meter::where('meterNo', $meterNo)->first();
                $trx = CreditToken::where('order_id', $var->data->metadata->ref)->first();
                $traff_id = CreditToken::where('order_id', $var->data->metadata->ref)->first();


                $databody = [
                    'meterType' => $meter->KRN1,
                    'meterNo' => $meter->meterNo,
                    'sgc' => (int)$meter->OldSGC,
                    'ti' => $trx->tariff_id,
                    'amount' => $trx->tariffPerKWatt,
                ];
                $no_kct_response = Http::withOptions([
                    'verify' => false,
                    'timeout' => 10,
                ])->post('http://169.239.189.91:19071/tokenGen', $databody);


                if ($no_kct_response->successful()) {
                    $no_kct = $no_kct_response->json();
                    $no_kct_data = json_decode($no_kct, true);
                    $status = $no_kct_data['code'] ?? null;

                    if ($status == "SUCCESS") {

                        $no_kct_token = $no_kct_data['tokens'][0];
                        CreditToken::where('order_id', $var->data->metadata->ref)->update([

                            'token' => $no_kct_token,
                            'status' => 2

                        ]);

                        $trx_id = $var->data->metadata->ref;
                        $user = User::where('id', $trx->user_id)->first();
                        $email = $user->email;
                        $token = $no_kct_token;
                        $amount = $trx->amount;


                        send_email_token($email, $token, $amount);


                        Transaction::where('trx_id', $trx)->update([
                            'status' => 2,
                        ]);

                        return redirect("admin/recepit?trx_id=$trx_id");

                    } else {

                        Transaction::where('trx_id', $trx)->update([
                            'service' => "METER PURCHASE",
                            'service_type' => "meter",
                            'status' => 3,
                            'tariff_id' => $request->tariff_id,
                            'note' => json_encode($no_kct_data) . "|" . json_encode($databody)


                        ]);

                        User::where('id', Auth::id())->increment('main_wallet', $trx->amount);
                        return redirect('admin/credit-token')->with('error', json_encode($no_kct_data) . " | " . json_encode($databody));

                    }


                }


            } else {
                $ref = Transaction::where('trx_id', $var->data->metadata->ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$ref&status=failure";
                return redirect($url);
            }

        }


    }


    public
    function flutter_verify_web(request $request)
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

        if ($status == null) {
            return redirect("admin/credit-token")->with('error', "something went wrong");
        }

        $ck_transaction = Transaction::where('trx_id', $var->data->tx_ref)->first()->status ?? null;

        if ($ck_transaction == null) {

            if ($status == 'success') {


                Transaction::where('trx_id', $ref)->update(['status' => 2]);
                $meterNo = CreditToken::where('order_id', $ref)->first()->meterNo;
                $meter = Meter::where('meterNo', $meterNo)->first();
                $trx = CreditToken::where('order_id', $ref)->first();
                $traff_id = CreditToken::where('order_id', $ref)->first();


                $databody = [
                    'meterType' => $meter->KRN1,
                    'meterNo' => $meter->meterNo,
                    'sgc' => (int)$meter->OldSGC,
                    'ti' => $trx->tariff_id,
                    'amount' => (int)$trx->tariffPerKWatt,
                ];


                $no_kct_response = Http::withOptions([
                    'verify' => false,
                    'timeout' => 10,
                ])->post('http://169.239.189.91:19071/tokenGen', $databody);
                $error = $no_kct_response->json() ?? null;


                if ($no_kct_response->successful()) {
                    $no_kct = $no_kct_response->json();
                    $no_kct_data = json_decode($no_kct, true);
                    $status = $no_kct_data['code'] ?? null;


                    if ($status == "SUCCESS") {

                        $no_kct_token = $no_kct_data['tokens'][0];
                        CreditToken::where('order_id', $ref)->update([

                            'token' => $no_kct_token,
                            'status' => 2

                        ]);

                        $trx_id = $ref;
                        $user = User::where('id', $trx->user_id)->first();
                        $email = $user->email;
                        $token = $no_kct_token;
                        $amount = $trx->amount;


                        send_email_token($email, $token, $amount);


                        Transaction::where('trx_id', $trx)->update([
                            'status' => 2,
                        ]);

                        return redirect("admin/recepit?trx_id=$trx_id");


                    } else {

                        Transaction::where('trx_id', $trx)->update([
                            'service' => "METER PURCHASE",
                            'service_type' => "meter",
                            'status' => 3,
                            'tariff_id' => $request->tariff_id,
                            'note' => json_encode($no_kct_data) . "|" . json_encode($databody)


                        ]);

                        User::where('id', Auth::id())->increment('main_wallet', $trx->amount);


                        return redirect('admin/credit-token')->with('error', $error['errors'][0]['title'] ?? $no_kct_response->json() . " | " . json_encode($databody));

                    }


                }


                return redirect('admin/credit-token')->with('error', $error['errors'][0]['title'] ?? $no_kct_response->json() . " | " . json_encode($databody));


            } else {
                $ref = Transaction::where('trx_id', $ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$ref&status=failure";
                return redirect($url);
            }

        }

        if ($ck_transaction == 0) {

            if ($status == 'success') {


                Transaction::where('trx_id', $var->data->metadata->ref)->update(['status' => 2]);
                $meterNo = CreditToken::where('order_id', $var->data->metadata->ref)->first()->meterNo;
                $meter = Meter::where('meterNo', $meterNo)->first();
                $trx = CreditToken::where('order_id', $var->data->metadata->ref)->first();
                $traff_id = CreditToken::where('order_id', $var->data->metadata->ref)->first();


                $databody = [
                    'meterType' => $meter->KRN1,
                    'meterNo' => $meter->meterNo,
                    'sgc' => (int)$meter->OldSGC,
                    'ti' => $trx->tariff_id,
                    'amount' => $trx->tariffPerKWatt,
                ];
                $no_kct_response = Http::withOptions([
                    'verify' => false,
                    'timeout' => 10,
                ])->post('http://169.239.189.91:19071/tokenGen', $databody);


                if ($no_kct_response->successful()) {
                    $no_kct = $no_kct_response->json();
                    $no_kct_data = json_decode($no_kct, true);
                    $status = $no_kct_data['code'] ?? null;

                    if ($status == "SUCCESS") {

                        $no_kct_token = $no_kct_data['tokens'][0];
                        CreditToken::where('order_id', $var->data->metadata->ref)->update([

                            'token' => $no_kct_token,
                            'status' => 2

                        ]);

                        $trx_id = $var->data->metadata->ref;
                        $user = User::where('id', $trx->user_id)->first();
                        $email = $user->email;
                        $token = $no_kct_token;
                        $amount = $trx->amount;


                        send_email_token($email, $token, $amount);


                        Transaction::where('trx_id', $trx)->update([
                            'status' => 2,
                        ]);

                        return redirect("admin/recepit?trx_id=$trx_id");

                    } else {

                        Transaction::where('trx_id', $trx)->update([
                            'service' => "METER PURCHASE",
                            'service_type' => "meter",
                            'status' => 3,
                            'tariff_id' => $request->tariff_id,
                            'note' => json_encode($no_kct_data) . "|" . json_encode($databody)


                        ]);

                        User::where('id', Auth::id())->increment('main_wallet', $trx->amount);
                        return redirect('admin/credit-token')->with('error', json_encode($no_kct_data) . " | " . json_encode($databody));

                    }


                }


            } else {
                $ref = Transaction::where('trx_id', $ref)->first()->trx_id;
                $url = url('') . "/payment?ref=$ref&status=failure";
                return redirect($url);
            }

        }


    }

    public
    function recepit(request $request)
    {


        if ($request->trx_id == null) {
            return back()->with('error', "Ref can not be empty");
        }


        if ($request->type == "compensation") {

            $trx_comp = CompensationToken::where('order_id', $request->trx_id)->first() ?? null;
            $user_comp = User::where('id', $trx_comp->user_id)->first() ?? null;


            if ($trx_comp != null) {

                $data['full_name'] = $user_comp->first_name . " " . $user_comp->last_name;
                $data['address'] = $user_comp->address . "," . $user_comp->city . "," . $user_comp->state;
                $data['phone'] = $user_comp->phone;
                $data['order_id'] = $trx_comp->order_id;
                $data['token'] = $trx_comp->token;
                $data['amount'] = $trx_comp->amount;
                $data['vat_amount'] = $trx_comp->vatAmount;
                $data['vend_amount_kw_per_naira'] = $trx_comp->tariffPerKWatt;
                $data['title'] = "Compensation Token";


                return view('admin.recepit', $data);


            }


        }


        $trx = CreditToken::where('order_id', $request->trx_id)->first() ?? null;
        $user = User::where('id', $trx->user_id)->first() ?? null;
        $data['full_name'] = $user->first_name . " " . $user->last_name;
        $data['address'] = $user->address . "," . $user->city . "," . $user->state;
        $data['phone'] = $user->phone;
        $data['order_id'] = $trx->order_id;
        $data['token'] = $trx->token;
        $data['amount'] = $trx->amount;
        $data['vat_amount'] = $trx->vatAmount;
        $data['vend_amount_kw_per_naira'] = $trx->tariffPerKWatt;
        $data['title'] = "Credit Token";


        return view('admin.recepit', $data);


    }


}
