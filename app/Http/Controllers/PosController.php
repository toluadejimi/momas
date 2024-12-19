<?php

namespace App\Http\Controllers;

use App\Models\CreditToken;
use App\Models\Estate;
use App\Models\Merchant;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\PosLog;
use App\Models\SpreadPayment;
use App\Models\Tariff;
use App\Models\TarrifState;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PosController extends Controller
{


    public function index(request $request)
    {

        if (auth::user()->role == 0) {


            $data['merchants'] = Merchant::all();
            $data['total_merchants'] = Merchant::count();
            return view('admin.pos.index', $data);


        } elseif (auth::user()->role == 1) {

        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }


    public function new_merchant(request $request)
    {

        if (auth::user()->role == 0) {

            return view('admin.pos.new-merchant');


        } elseif (auth::user()->role == 1) {

        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }

    public function add_merchant(request $request)
    {

        $terminal = Merchant::where('serial_no', $request->serial_no)->first() ?? null;
        if ($terminal == null) {
            $ter = new Merchant();
            $ter->first_name = $request->first_name;
            $ter->last_name = $request->last_name;
            $ter->phone_no = $request->phone_no;
            $ter->serial_no = $request->serial_no;
            $ter->tid = $request->tid;
            $ter->state = $request->state;
            $ter->city = $request->city;
            $ter->status = 2;
            $ter->save();

            try{


                $curl = curl_init();

                $databody = array(
                    'serial_no' => $request->serial_no,
                    'tid' => $request->tid,
                    );

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://enkpayapp.enkwave.com/api/register-pos',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $databody,
                ));

                $var = curl_exec($curl);
                curl_close($curl);
                $var = json_decode($var);




            } catch (\Exception $th) {
                return $th->getMessage();
            }



            return back()->with('message', 'Merchant has been created successfully');



        } else {
            return back()->with('error', 'Serial No already exist');
        }


    }

    public function delete_merchant(request $request)
    {

        Merchant::where('id', $request->id)->delete();

        return back()->with('message', 'Merchant has been deleted successfully');


    }




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
            'name' => $data['customer_name'],
            'address' => $data['address'],
            'maximumAmount' => $pur['max_purchase'],
            'minimumAmount' => $data['min_purchase']
        ], 200);


    }


    public function buy_meter_token(request $request)
    {

        $meterNo = $request->meterNo;
        $utility_amount = $request->utility_amount;
        $SerialNo = $request->header('serialnumber');
        $RRN = $request->RRN;
        $STAN = $request->STAN;
        $acquiringInstitutionIdCode = $request->acquiringInstitutionIdCode;
        $authCode = $request->authCode;
        $cardCardSequenceNum = $request->cardCardSequenceNum;
        $cardExpireData = $request->cardExpireData;
        $forwardingInstCode = $request->forwardingInstCode;
        $merchantNo = $request->institutionData['merchantNo'];
        $amount = $request->institutionData['amount'];
        $accountType = $request->institutionData['accountType'];
        $merchantName = $request->institutionData['merchantName'];
        $tid = $request->institutionData['tid'];
        $pan = $request->pan;
        $pinBlock = $request->pinBlock;
        $receiptNumber = $request->receiptNumber;
        $respCode = $request->respCode;
        $responseMessage = $request->responseMessage;
        $status = $request->status;
        $successResponse = $request->successResponse;
        $systemTraceAuditNo = $request->systemTraceAuditNo;
        $terminalId = $request->terminalId;
        $transactionDate = $request->transactionDate;
        $transactionDateTime = $request->transactionDateTime;
        $transactionTime = $request->transactionTime;
        $transactionType = $request->transactionType;
        $cardName = $request->cardName;
        $userID = $request->UserID;
        $estate_id = $request->meter_info['estate_id'];
        $vending_amount = $request->meter_info['vending_amount'];
        $vend_amount_kw_per_naira = $request->meter_info['vend_amount_kw_per_naira'];
        $vat_amount = $request->meter_info['vat_amount'];
        $total_paid = $request->meter_info['total_paid_amount'];








        $estate = Estate::where('id', $estate_id)->first();
        $tariff_id = TarrifState::where('estate_id', $estate_id)->first()->tariff_id ?? null;


        $meter = Meter::where('MeterNo', $meterNo)->first() ?? null;
        $user = User::where('meterNo', $meterNo)->first() ?? null;
        if ($user == null) {
            return response()->json([
                'status' => false,
                'message' => 'Meter Not attached to user',
            ], 422);
        }

//
//        $duration = Utitlity::where('estate_id', Auth::user()->estate_id)->first()->duration;
//        if ($request->min_vend_amount != 0) {
//            $utl = new UtilitiesPayment();
//            $utl->user_id = 1;
//            $utl->estate_id = $estate_id;
//            $utl->amount = $utility_amount;
//            $utl->duration = $duration;
//            $utl->status = 2;
//            $utl->save();
//        }



        $logs = new PosLog();
        $logs->rrn = $RRN;
        $logs->estate_id = $estate_id;
        $logs->cardName = $cardName;
        $logs->amount = $amount;
        $logs->STAN = $STAN;
        $logs->serialNO = $SerialNo;
        $logs->expireDate = $cardExpireData;
        $logs->responseMessage = $responseMessage;
        $logs->pan = $pan;
        $logs->responseCode = $respCode;







        if ($meter != null && $meter->NeedKCT == "on") {
            $databody = [
                'meterType' => $meter->KRN1,
                'meterNo' => $meterNo,
                'sgc' => (int)$meter->OldSGC,
                'ti' => $tariff_id, //TRARRRIF INDEX
                'amount' => $vend_amount_kw_per_naira,
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
                        'meterNo' => $meterNo,
                        'sgc' => (int)$meter->OldSGC,
                        'tosgc' => (int)$meter->NewSGC,
                        'ti' => $tariff_id,
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


                            $order_id = "POS" . random_int(000000000, 9999999999);
                            $cdt = new CreditToken();
                            $cdt->user_id = 1;
                            $cdt->order_id = $RRN;
                            $cdt->meterNo = $meterNo;
                            $cdt->amount = $total_paid ?? 0;
                            $cdt->vat = $vat_amount ?? 0;
                            $cdt->estate_name = Estate::where('id', Auth::user()->estate_id)->first()->title ?? "NAME";
                            $cdt->estate_id = $estate_id;
                            $cdt->tariff_id = $tariff_id;
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
                            $met->estate_id = $estate_id;
                            $met->status = 2;
                            $met->save();

                            Transaction::where('trx_id', $trx)->update(['service' => "METER PURCHASE", 'service_type' => "meter", 'unit_amount' => $vendong_amount, 'vat' => $vat_amount, 'tariff_id' => $tariff_index,
                            ]);


                            $trasnaction[''] =

                            $data2['full_name'] = $user->first_name . " " . $user->last_name;
                            $data2['address'] = $user->address . "," . $user->city . "," . $user->state;
                            $data2['service'] = "MOMAS METER";
                            $data2['order_id'] = $trx;
                            $data2['token'] = $token;
                            $data2['amount'] = $total_paid;
                            $data2['vending_amount'] = $vendong_amount;
                            $data2['vend_amount_kw_per_naira'] = $unit;
                            $data2['kct_token1'] = $kct_data['tokens'][0];
                            $data2['kct_token2'] = $kct_data['tokens'][1];
                            $data2['vat_amount'] = $vat_amount;


                            return response()->json([
                                'newTransaction' => [
                                    'success' => true,
                                    'transaction' => $trasnaction,
                                ],
                                'merchantName' => $mer->merchantName,
                                'mid' => $mer->mid,
                                'allTransaction' => null,
                                'message' => "Transaction initiated successfully",
                                'merchantDetails' => [
                                    'merchantName' => $mer->merchantName,
                                    'serialnumber' => $mer->serialNumber,
                                    'mid' => $mer->mid,
                                    'tid' => $mer->tid,
                                    'merchantaddress' => $mer->merchantaddress
                                ],
                                'meter' => $meter ?? null
                            ], 200);

                            $meter['wallet_balance'] = $var->wallet_balance;
                            $meter['ref'] = $var->ref;
                            $meter['amount'] = $var->amount;
                            $meter['units'] = $var->units;
                            $meter['meter_token'] = $var->meter_token;
                            $meter['address'] = $var->address;
                            $meter['message'] = "successful";


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


    public function buy_token(request $request)
    {

        $SerialNo = $request->header('serialnumber');
        $account_balance = user_balance($SerialNo);
        $RRN = $request->RRN;
        $STAN = $request->STAN;
        $accountBalance = $account_balance;
        $acquiringInstitutionIdCode = $request->acquiringInstitutionIdCode;
        $authCode = $request->authCode;
        $cardCardSequenceNum = $request->cardCardSequenceNum;
        $cardExpireData = $request->cardExpireData;
        $forwardingInstCode = $request->forwardingInstCode;
        $merchantNo = $request->institutionData['merchantNo'];
        $amount = $request->institutionData['amount'];
        $accountType = $request->institutionData['accountType'];
        $merchantName = $request->institutionData['merchantName'];
        $tid = $request->institutionData['tid'];
        $pan = $request->pan;
        $pinBlock = $request->pinBlock;
        $receiptNumber = $request->receiptNumber;
        $respCode = $request->respCode;
        $responseMessage = $request->responseMessage;
        $status = $request->status;
        $successResponse = $request->successResponse;
        $systemTraceAuditNo = $request->systemTraceAuditNo;
        $terminalId = $request->terminalId;
        $transactionDate = $request->transactionDate;
        $transactionDateTime = $request->transactionDateTime;
        $transactionTime = $request->transactionTime;
        $transactionType = $request->transactionType;
        $cardName = $request->cardName;
        $userID = $request->UserID;
        $action = $request->meter_info['action'];
        $access_token = $request->meter_info['access_token'];
        $disco_type = $request->meter_info['disco_type'];
        $phone = $request->meter_info['phone'];
        $email = $request->meter_info['email'];
        $meterNo = $request->meter_info['meter_no'];


        if ($action == "ibdc") {

            $url = env('IBDCURL');
            $pub_key = env('IBDCPUBKEY');
            $priv_key = env('IBDCPRIVKEY');
            $trx = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT); // Generate a 12-digit reference ID
            $vendor_code = env('IBDCVENDORCODE');
            $hash = generateHash($vendor_code, $meterNo, $trx, $disco_type, $amount, $access_token, $pub_key, $priv_key);

            $databody = array();

            $body = json_encode($databody);
            $curl = curl_init();
            curl_setopt_array($curl, array(

                CURLOPT_URL => $url . "vend_power.php?vendor_code=$vendor_code&reference_id=$trx&meter=$meterNo&access_token=$access_token&disco=$disco_type&phone=$phone&email=$email&response_format=json&hash=$hash&amount=$amount",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                ),
            ));

            $var = curl_exec($curl);
            curl_close($curl);
            $var = json_decode($var);
            $status = $var->status ?? null;
            $message = $var->message ?? null;


            if ($status == "00" && $message == "Successful") {

                $met = new MeterToken();
                $met->eletic_company = "ibdc";
                $met->disco_type = $disco_type;
                $met->meter_no = $meterNo;
                $met->ref = $trx;
                $met->amount = $amount;
                $met->units = $var->units;
                $met->meter_token = $var->meter_token;
                $met->address = $var->address;
                $met->status = 2;
                $met->note = "successful";
                $met->SerialNo = $SerialNo;
                $met->rrn = $RRN;

                $met->save();


                $meter['wallet_balance'] = $var->wallet_balance;
                $meter['ref'] = $var->ref;
                $meter['amount'] = $var->amount;
                $meter['units'] = $var->units;
                $meter['meter_token'] = $var->meter_token;
                $meter['address'] = $var->address;
                $meter['message'] = "successful";


            } else {

                $met = new MeterToken();
                $met->eletic_company = "ibdc";
                $met->disco_type = $disco_type;
                $met->meter_no = $meterNo;
                $met->ref = $trx;
                $met->amount = $amount;
                $met->units = $var->units ?? null;
                $met->meter_token = $var->meter_token ?? null;
                $met->address = $var->address ?? null;
                $met->status = 1;
                $met->note = $message;
                $met->SerialNo = $SerialNo;
                $met->rrn = $RRN;

                $met->save();


                $meter['wallet_balance'] = null;
                $meter['ref'] = null;
                $meter['amount'] = null;
                $meter['units'] = null;
                $meter['meter_token'] = null;
                $meter['message'] = $message;

            }


        }


        if ($SerialNo == null) {
            $message = "Serial Number can not be empty";
            return error_response($message);
        }

        $rrn = PosLog::where('RRN', $request->RRN)->first()->log_status ?? null;
        if ($rrn == 1) {
            return response()->json([
                'status' => true,
                'message' => 'Transaction already successful',
            ], 422);

        }


        $SerialNo = Terminal::where('serialNumber', $SerialNo)->first()->serialNumber ?? null;
        if ($SerialNo == null) {
            $message = "No user attached to the serial number | $SerialNo";
            return error_response($message);
        }


        $trx = PosLog::where('RRN', $request->RRN)->where('log_status', 0)->update([
            'log_status' => 1,
        ]) ?? null;

        $user_id = Terminal::where('serialNumber', $SerialNo)->first()->user_id ?? null;
        $bank_id = Terminal::where('serialNumber', $SerialNo)->first()->bank_id ?? null;


        // Get the current time
        $current_time = time();
        $one_hour_later = $current_time + 3600; // 3600 seconds = 1 hour
        $created_at = date('Y-m-d H:i:s', $one_hour_later);


        $mer = Terminal::where('serialNumber', $SerialNo)->first() ?? null;


        return response()->json([
            'newTransaction' => [
                'success' => true,
                'transaction' => $trasnaction,
            ],
            'merchantName' => $mer->merchantName,
            'mid' => $mer->mid,
            'allTransaction' => null,
            'message' => "Transaction initiated successfully",
            'merchantDetails' => [
                'merchantName' => $mer->merchantName,
                'serialnumber' => $mer->serialNumber,
                'mid' => $mer->mid,
                'tid' => $mer->tid,
                'merchantaddress' => $mer->merchantaddress
            ],
            'meter' => $meter ?? null
        ], 200);
    }


}
