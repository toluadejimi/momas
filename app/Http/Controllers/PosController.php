<?php

namespace App\Http\Controllers;

use App\Models\CreditToken;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\Setting;
use App\Models\SpreadPayment;
use App\Models\Tariff;
use App\Models\TarrifState;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UtilitiesPayment;
use App\Models\Utitlity;
use App\Services\VatCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PosController extends Controller
{



    public function validate_meter(request $request)
    {
        $user = User::where('meterNo', $request->meterNo)->first() ?? null;

        $meter = Meter::where('meterNo', $request->meterNo)->where('estate_id', $request->estateId)->first() ?? null;
        if ($meter == null) {
            $message = "Validation Failed, please check meter number or estate selected";
            $code = 422;
            return error($message, $code);
        }


        $get_tar = Tariff::where('user_id', $user->id)->first() ?? null;
        if ($get_tar == null) {
            $message = "Tariff not properly configured";
            $code = 422;
            return error($message, $code);
        }


        $data['customer_name'] = $user->first_name . " " . $user->last_name;
        $data['address'] = $user->address . ", " . $user->city . ", " . $user->state;
        // $data['meter_type'] = $meter_type;

        $es_id = $request->estateId ?? null;
        $duration = Estate::where('id', $es_id)->first()->duration ?? null;
        $estate_id = $es_id;
        $user_id = $user->id;

        if ($duration == null || $estate_id == null) {
            $minvend = "Not set";
        } else {

            $sp = SpreadPayment::where('user_id', $user->id)->where('estate_id', $es_id)->first()->percentage ?? null;
            if ($sp != null) {
                $percentage = $sp / 100;
                $vend = vend($duration, $estate_id, $user_id);
                $get_vend = $percentage * $vend;
                $minvend = $get_vend;

            } else {


                $get_vend = vend($duration, $estate_id, $user_id);
                if ($get_vend == null) {
                    $minvend = "Not set";
                } else {
                    $minvend = $get_vend;
                }

            }

        }

        $min_pur = Estate::where('id', $request->estateId)->first()->min_pur ?? null;
        $max_pur = Estate::where('id', $request->estateId)->first()->max_pur ?? null;
        $data['min_purchase'] = (int)$min_pur;
        $tariffs = Tariff::select('id', 'type', 'estate_id', 'title')
            ->where('user_id', $user->id)
            ->get();
        foreach ($tariffs as $tariff) {
            $tariffState = TarrifState::where('tariff_id', $tariff->id)->first();
            $tariff->amount = $tariffState ? $tariffState->amount : null;
            $tariff->vat = $tariffState ? $tariffState->vat : null;

        }

        $data['tariffs'] = $tariffs;
        $pur['min_purchase'] = (int)$min_pur;
        $pur['max_purchase'] = (int)$max_pur;
        $pur['min_vending'] = (int)$minvend;
        $data['purchase'] = $pur;


        return response()->json([
            'status' => true,
            'data' => $data

        ]);


    }


    public function buy_meter_token(request $request)
    {

        $amount = $request->amount;
        $meterNo = $request->meterNo;
        $trx = $request->trxref;
        $utility_amount = $request->utility_amount;
        $total_paid = $request->total_paid_amount;
        $unit = $request->vend_amount_kw_per_naira;
        $vendong_amount = $request->vending_amount;
        $vat_amount = $request->vat_amount;


        $tariff_index = Tariff::where('id', $request->tariff_id)->first()->tariff_index ?? null;

        $duration = Utitlity::where('estate_id', Auth::user()->estate_id)->first()->duration;
        if ($request->min_vend_amount != 0) {
            $utl = new UtilitiesPayment();
            $utl->user_id = Auth::id();
            $utl->estate_id = Auth::user()->estate_id;
            $utl->amount = $utility_amount;
            $utl->duration = $duration;
            $utl->status = 2;
            $utl->save();
        }


        $meter = Meter::where('MeterNo', $meterNo)->first() ?? null;

        if ($meter != null && $meter->NeedKCT == "on") {
            $databody = [
                'meterType' => $meter->KRN1,
                'meterNo' => Auth::user()->meterNo,
                'sgc' => (int)$meter->OldSGC,
                'ti' => $tariff_index, //TRARRRIF INDEX
                'amount' => $unit,
            ];
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->post('http://169.239.189.91:19071/tokenGen', $databody);

            if ($response->successful()) {
                $gdata = $response->json();
                $data = json_decode($gdata, true);
                $status = $data['code'] ?? null;

                if ($status == "SUCCESS") {
                    $token = $data['tokens'][0];

                    $kctdatabody = [
                        'meterType' => $meter->KRN1,
                        'tometerType' => $meter->KRN1,
                        'meterNo' => Auth::user()->meterNo,
                        'sgc' => (int)$meter->OldSGC,
                        'tosgc' => (int)$meter->NewSGC,
                        'ti' => $tariff_index,
                        'toti' => 1,
                        'allow' => false,
                        'allowkrn' => true,
                    ];

                    $kct_response = Http::withOptions([
                        'verify' => false,
                        'timeout' => 10,
                    ])->post('http://169.239.189.91:19071/kcttokenGen', $kctdatabody);

                    if ($kct_response->successful()) {
                        $kct = $kct_response->json();
                        $kct_data = json_decode($kct, true);
                        $status = $kct_data['code'] ?? null;

                        if ($status == "SUCCESS") {


                            $order_id = "TRX".random_int(000000000, 9999999999);
                            $estate_id = Auth::user()->estate_id;
                            $cdt = new CreditToken();
                            $cdt->user_id = Auth::user()->id;
                            $cdt->order_id = $order_id;
                            $cdt->meterNo = $meterNo;
                            $cdt->amount =  $total_paid ?? 0;
                            $cdt->vat = $vat_amount ?? 0;
                            $cdt->estate_name = Estate::where('id', Auth::user()->estate_id)->first()->title ?? "NAME";
                            $cdt->estate_id = $estate_id;
                            $cdt->tariff_id = TarrifState::where('estate_id', $estate_id)->first()->tariff_id;
                            $cdt->vatAmount = $vat_amount;
                            $cdt->costOfUnit = $request->vending_amount;
                            $cdt->tariffPerKWatt = $request->vend_amount_kw_per_naira;
                            $cdt->save();


                            $met = new MeterToken();
                            $met->user_id = Auth::user()->id;
                            $met->order_id = $trx;
                            $met->meterNo = $meterNo;
                            $met->token = $token;
                            $met->amount = $total_paid ?? 0;
                            $met->unit = $unit;
                            $met->kct_tokens = $kct_data['tokens'][0] . "," . $kct_data['tokens'][1];
                            $met->vat = $vat_amount;
                            $met->estate_id = Auth::user()->estate_id;
                            $met->status = 2;
                            $met->save();

                            Transaction::where('trx_id', $trx)->update(['service' => "METER PURCHASE", 'service_type' => "meter", 'unit_amount' => $vendong_amount, 'vat' => $vat_amount, 'tariff_id' => $request->tariff_id,
                            ]);


                            $data2['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
                            $data2['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
                            $data2['service'] = "MOMAS METER";
                            $data2['order_id'] = $trx;
                            $data2['token'] = $token;
                            $data2['amount'] = $total_paid;
                            $data2['vending_amount'] = $vendong_amount;
                            $data2['vend_amount_kw_per_naira'] = $unit;
                            $data2['kct_token1'] = $kct_data['tokens'][0];
                            $data2['kct_token2'] = $kct_data['tokens'][1];
                            $data2['vat_amount'] = $vat_amount;


                            $email = Auth::user()->email;
                            $kct_token = $kct_data['tokens'];
                            $kct_token1 = $kct_token[0];
                            $kct_token2 = $kct_token[1];

                            send_kct_email_token($email, $token, $amount, $kct_token1, $kct_token2);

                            return response()->json([
                                'status' => true,
                                'data' => $data2
                            ], 200);


                        }
                    } else {

                        Transaction::where('trx_id', $trx)->update([
                            'service' => "METER PURCHASE",
                            'service_type' => "meter",
                            'status' => 3,
                            'tariff_id' => $request->tariff_id,
                            'unit_amount' => $vendong_amount,
                            'note' => $kct_response . "| " . json_encode($databody)

                        ]);


                        User::where('id', Auth::id())->increment('main_wallet', $request->amount);


                        return response()->json([

                            'status' => false,
                            'message' => "Vending server not connected, Retry again on transaction history",
                        ], 422);
                    }

                }


            } else {

                return response()->json([
                    'status' => false,
                    'message' => "Meter vending failed, Retry again using your wallet"
                ], 422);

            }

        }


        if ($meter != null && $meter->NeedKCT == null) {

            $databody = [
                'meterType' => $meter->KRN1,
                'meterNo' => Auth::user()->meterNo,
                'sgc' => (int)$meter->OldSGC,
                'ti' => 1,
                'amount' => $request->amount,
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
                    $vat = TarrifState::where('tariff_id', $request->tariff_id)->first()->amount ?? 0;
                    $met = new MeterToken ();
                    $met->user_id = Auth::user()->id;
                    $met->order_id = $trx;
                    $met->meterNo = $meterNo;
                    $met->token = $no_kct_token;
                    $met->amount = $vendong_amount;
                    $met->unit = $unit;
                    $met->vat = $vat;
                    $met->estate_id = Auth::user()->estate_id;
                    $met->status = 2;
                    $met->save();

                    Transaction::where('trx_id', $trx)->update(['service' => "METER PURCHASE", 'service_type' => "meter", 'unit_amount' => $vendong_amount]);

                    $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
                    $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
                    $data['service'] = "MOMAS METER";
                    $data['order_id'] = $trx;
                    $data['token'] = $no_kct_data['tokens'][0];
                    $data['amount'] = $total_paid;
                    $data['vending_amount'] = $vendong_amount;
                    $data['vat_amount'] = $vat_amount;
                    $data['vend_amount_kw_per_naira'] = $unit;
                    $email = Auth::user()->email;
                    $token = $no_kct_data['tokens'][0];
                    send_email_token($email, $token, $amount);

                    return response()->json([
                        'status' => true,
                        'data' => $data
                    ], 200);


                } else {


                    Transaction::where('trx_id', $trx)->update([
                        'service' => "METER PURCHASE",
                        'service_type' => "meter",
                        'status' => 3,
                        'tariff_id' => $request->tariff_id,
                        'unit_amount' => $vendong_amount,
                        'note' => $no_kct_response . "|" . json_encode($databody)


                    ]);

                    User::where('id', Auth::id())->increment('main_wallet', $request->amount);


                    return response()->json([
                        'status' => false,
                        'message' => "Vending server not connected, Retry again on transaction history",
                    ], 422);

                }


            }


        }

        return response()->json([

            'status' => false,
            'message' => "Something went wrong, Contact our support",
        ], 422);


    }

    public function retry_meter_token(request $request)
    {

        $amount = $request->amount;
        $meterNo = $request->meterNo;
        $trx_id = $request->trxref;


        $trx = Transaction::where('trx_id', $trx_id)->first() ?? null;
        if ($trx == null) {
            return response()->json([
                'status' => false,
                'message' => "Transaction not found, contact our support for more support",
            ], 422);
        }

        if ($trx->status == 2) {
            return response()->json([
                'status' => false,
                'message' => "Transaction already successful, contact our support for more support",
            ], 422);

        }

        $tariff_index = Tariff::where('id', $trx->tariff_id)->first()->tariff_index ?? null;
        $user = User::where('id', $trx->user_id)->first();
        $meter = Meter::where('user_id', $trx->user_id)->first();

        User::where('id', $user->id)->decrement('main_wallet', $trx->unit_amount);


        if ($meter != null && $meter->NeedKCT == "on") {
            $databody = [
                'meterType' => $meter->KRN1,
                'meterNo' => $meter->meterNo,
                'sgc' => (int)$meter->OldSGC,
                'ti' => $tariff_index, //TRARRRIF INDEX
                'amount' => $trx->unit_amount,
            ];
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10,
            ])->post('http://169.239.189.91:19071/tokenGen', $databody);

            if ($response->successful()) {
                $gdata = $response->json();
                $data = json_decode($gdata, true);
                $status = $data['code'] ?? null;

                if ($status == "SUCCESS") {

                    $token = $data['tokens'][0];

                    $kctdatabody = [
                        'meterType' => $meter->KRN1,
                        'tometerType' => $meter->KRN1,
                        'meterNo' => $meter->meterNo,
                        'sgc' => (int)$meter->OldSGC,
                        'tosgc' => (int)$meter->NewSGC,
                        'ti' => $tariff_index,
                        'toti' => 1,
                        'allow' => false,
                        'allowkrn' => true,
                    ];

                    $kct_response = Http::withOptions([
                        'verify' => false,
                        'timeout' => 10,
                    ])->post('http://169.239.189.91:19071/kcttokenGen', $kctdatabody);

                    if ($kct_response->successful()) {
                        $kct = $kct_response->json();
                        $kct_data = json_decode($kct, true);
                        $status = $kct_data['code'] ?? null;

                        if ($status == "SUCCESS") {

                            $met = new MeterToken ();
                            $met->user_id = $trx->user_id;
                            $met->order_id = $trx->trx_id;
                            $met->meterNo = $meter->meterNo;
                            $met->token = $token;
                            $met->amount = $trx->amount;
                            $met->unit = $trx->unit_amount;
                            $met->kct_tokens = $kct_data['tokens'][0] . "," . $kct_data['tokens'][1];
                            $met->vat = $trx->vat;
                            $met->estate_id = $user->estate_id;
                            $met->status = 2;
                            $met->save();

                            Transaction::where('trx_id', $trx_id)->update(['status' => 2, 'note' => "Tokens generated successfully"]);


                            $data2['full_name'] = $user->first_name . " " . $user->last_name;
                            $data2['address'] = $user->address . "," . $user->city . "," . $user->state;
                            $data2['service'] = "MOMAS METER";
                            $data2['order_id'] = $trx_id;
                            $data2['token'] = $token;
                            $data2['amount'] = "$trx->amount";
                            $data2['vending_amount'] = "$trx->vending_amount";
                            $data2['vend_amount_kw_per_naira'] = "$trx->unit_amount";
                            $data2['kct_token1'] = $kct_data['tokens'][0];
                            $data2['kct_token2'] = $kct_data['tokens'][1];
                            $data2['vat_amount'] = "$trx->vat";


                            $email = $user->email;
                            $kct_token = $kct_data['tokens'];
                            $kct_token1 = $kct_token[0];
                            $kct_token2 = $kct_token[1];

                            send_kct_email_token($email, $token, $amount, $kct_token1, $kct_token2);

                            return response()->json([
                                'status' => true,
                                'data' => $data2
                            ], 200);


                        }
                    } else {

                        Transaction::where('trx_id', $trx)->update([
                            'service_type' => "token Purchase",
                            'service' => "Meter",
                            'status' => 3,
                            'note' => json_encode($kct_response)


                        ]);

                        User::where('id', Auth::id())->increment('main_wallet', $trx->unit_amount);

                        return response()->json([
                            'status' => false,
                            'message' => "Vending server not connected, Retry again later using your wallet",
                        ], 422);
                    }

                }


            } else {

                return response()->json([
                    'status' => false,
                    'message' => "Meter vending failed, Retry again on transaction history"
                ], 422);

            }

        }


        if ($meter != null && $meter->NeedKCT == null) {

            $databody = [
                'meterType' => $meter->KRN1,
                'meterNo' => $meter->meterNo,
                'sgc' => (int)$meter->OldSGC,
                'ti' => 1,
                'amount' => $trx->unit_amount,
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
                    $met = new MeterToken ();
                    $met->user_id = $trx->user_id;
                    $met->order_id = $trx->trx_id;
                    $met->meterNo = $meter->meterNo;
                    $met->token = $no_kct_token;
                    $met->amount = $trx->amount;
                    $met->unit = $trx->unit_amount;
                    $met->vat = $trx->vat;
                    $met->estate_id = $user->estate_id;
                    $met->status = 2;
                    $met->save();

                    Transaction::where('trx_id', $trx_id)->update(['status' => 2, 'note' => "Tokens generated successfully"]);


                    $data['full_name'] = $user->first_name . " " . $user->last_name;
                    $data['address'] = $user->address . "," . $user->city . "," . $user->state;
                    $data['service'] = "MOMAS METER";
                    $data['order_id'] = $trx_id;
                    $data['token'] = $no_kct_token;
                    $data['amount'] = "$trx->amount";
                    $data['vending_amount'] = "$trx->vending_amount";
                    $data['vend_amount_kw_per_naira'] = "$trx->unit_amount";
                    $data['vat_amount'] = "$trx->vat";

                    $email = $user->email;

                    send_email_token($email, $no_kct_token, $amount);

                    return response()->json([
                        'status' => true,
                        'data' => $data
                    ], 200);


                } else {


                    Transaction::where('trx_id', $trx_id)->update([
                        'service_type' => "token Purchase",
                        'service' => "Meter",
                        'status' => 3,
                        'note' => json_encode($no_kct_response)
                    ]);

                    User::where('id', Auth::id())->increment('main_wallet', $trx->unit_amount);
                    return response()->json([
                        'status' => false,
                        'message' => "Meter vending failed, Retry again on transaction history"
                    ], 422);


                }


            }


        }

        return response()->json([

            'status' => false,
            'message' => "Something went wrong, Contact our support",
        ], 422);


    }


}
