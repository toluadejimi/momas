<?php

namespace App\Http\Controllers\Meter;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\SpreadPayment;
use App\Models\Tariff;
use App\Models\TarrifState;
use App\Models\Transformer;
use App\Models\User;
use App\Models\UtilitiesPayment;
use App\Models\Utitlity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeterController extends Controller
{


    public function searchMeters(request $request)
    {
        $query = $request->get('q');
        $meters = Meter::where('meterNo', 'LIKE', '%' . $query . '%')->where('user_id', null)->get();
        return response()->json($meters);
    }

    public function validate_meter(request $request)
    {

        $user = User::where('meterNo', $request->meterNo)->where('estate_id', $request->estate_id)->first() ?? null;

        if ($user == null) {
            $message = "Validation Failed, please check meter number or estate selected";
            $code = 422;
            error($message, $code);
        }



//        $meter_type = Meter::where('meterNo', $request->meterNo)->first()->payType;

        $data['customer_name'] = $user->first_name . " " . $user->last_name;
        $data['address'] = $user->address . ", " . $user->city . ", " . $user->state;
        // $data['meter_type'] = $meter_type;

        $es_id = User::where('meterNo', $request->meterNo)->first()->estate_id ?? null;
        $duration = Utitlity::where('estate_id', $es_id)->first()->duration ?? null;
        $estate_id = $es_id;




        if ($duration == null || $estate_id == null) {
            $minvend = "Not set";
        } else {

            $sp = SpreadPayment::where('user_id', $user->id)->where('estate_id', $es_id)->first()->percentage ?? null;
            if ($sp != null) {
                $percentage = $sp / 100;
                $vend = vend($duration, $estate_id);
                $get_vend = $percentage * $vend;
                $minvend = $get_vend;

            } else {

                $get_vend = vend($duration, $estate_id);
                if ($get_vend == null) {
                    $minvend = "Not set";
                } else {
                    $minvend = $get_vend;
                }

            }

        }

        $min_pur = Estate::where('id', $es_id)->first()->min_pur ?? null;
        $max_pur = Estate::where('id', $es_id)->first()->max_pur ?? null;
        $data['min_purchase'] = (int)$min_pur;
        $tariffs = Tariff::select('id', 'type', 'estate_id', 'title')
            ->where('user_id', $user->id)
            ->get();
        foreach ($tariffs as $tariff) {
            $tariffState = TarrifState::where('tariff_id', $tariff->id)->first();
            $tariff->amount = $tariffState ? $tariffState->amount : null;
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
        $meterNo = Auth::user()->meterNo;
        $meterType = $request->meterType;
        $trx = $request->trxref;
        $date = date('ymd');
        $dater = date('d-m-y');
        $date_time = date('ydis');


        $duration = Utitlity::where('estate_id', Auth::user()->estate_id)->first()->duration;

        $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
        $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
        $data['service'] = "MOMAS";
        $data['order_id'] = $trx;
        $data['token'] = "123456944885756";
        $data['amount'] = $amount;
        $data['date'] = $dater;


        $ved = new MeterToken();
        $ved->user_id = Auth::id();
        $ved->order_id = $trx;
        $ved->meterNo = $meterNo;
        $ved->token = "123456944885756";
        $ved->estate_id = Auth::user()->estate_id;
        $ved->amount = $amount;
        $ved->unit = "0099847";
        $ved->vat = "1234";
        $ved->estate_name = Estate::where('id', Auth::user()->estate_id)->first()->title;
        $ved->status = 2;
        $ved->save();


        $email = Auth::user()->email;
        $token = "123456944885756";
        $unit = "0099847";

        send_email_token($email, $token, $amount, $unit);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);








//        if ($request->min_vend_amount > 0) {
//            $utl = new UtilitiesPayment();
//            $utl->user_id = Auth::id();
//            $utl->estate_id = Auth::user()->estate_id;
//            $utl->amount = $request->min_vend_amount;
//            $utl->duration = $duration;
//            $utl->status = 2;
//            $utl->save();
//        }
//
//
//        $meter = Meter::where('MeterNo', Auth::user()->meterNo)->first() ?? null;
//        if ($meter != null && $meter->NeedKCT == "on") {
//
//            $percentage = 2.5 / 100;
//            $final_amount = $percentage * $amount;
//
//            $databody = array([
//                'meterType' => $meter->KRN1,
//                'meterNo' => Auth::user()->meterNo,
//                'sgc' => $meter->OldSGC,
//                'ti' => 1,
//                'amount' => 10,
//            ]);
//
//            $url = "http://safedc.memmserve.com:19071/tokenGen";
//
//            $body = json_encode($databody);
//            $curl = curl_init();
//
//            curl_setopt_array($curl, array(
//                CURLOPT_URL => $url,
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => '',
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 0,
//                CURLOPT_FOLLOWLOCATION => true,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => 'POST',
//                CURLOPT_POSTFIELDS => $body,
//                CURLOPT_HTTPHEADER => array(
//                    'Accept: application/json',
//                    'Content-Type: application/json'
//                ),
//            ));
//
//            $var2 = curl_exec($curl);
//            curl_close($curl);
//            $var = json_decode($var2);
//
//
//            dd($var2, $body);
//
//
//            $response = $var->responsecode ?? null;
//
//            if ($response == "00") {
//                $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
//                $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
//                $data['service'] = "MOMAS";
//                $data['order_id'] = $trx;
//                $data['token'] = $var->recieptNumber;
//                $data['amount'] = $amount;
//                $data['date'] = $dater;
//
//
//                $ved = new MeterToken();
//                $ved->user_id = Auth::id();
//                $ved->order_id = $trx;
//                $ved->token = $var->recieptNumber;
//                $ved->amount = $amount;
//                $ved->estate_id = Auth::user()->estate_id;
//                $ved->meterNo = $meterNo;
//                $ved->estate_name = Estate::where('id', Auth::user()->estate_id)->first()->title;
//                $ved->unit = $var->unit;
//                $ved->vat = $var->vat;
//                $ved->status = 2;
//                $ved->save();
//
//
//                $email = Auth::user()->email;
//                $token = $var->recieptNumber;
//                $unit = $var->unit;
//
//                send_email_token($email, $token, $amount, $unit);
//
//
//            } else {
//
//                User::where('id', Auth::id())->increment('main_wallet', $amount);
//                return response()->json([
//                    'status' => false,
//                    'message' => "Meter vending failed, Retry again using your wallet"
//                ], 200);
//
//
//            }
//
//
//            return response()->json([
//                'status' => true,
//                'data' => $data
//            ], 200);
//
//
//        } else {
//
//
//            $percentage = 2.5 / 100;
//            $final_amount = $percentage * $amount;
//
//            $databody = array([
//                'meterType' => $meter->KRN1,
//                'tometerType' => $meter->KRN2,
//                'meterNo' => Auth::user()->meterNo,
//                'sgc' => $meter->OldSGC,
//                'tosgc' => $meter->NewSGC,
//                'ti' => 1,
//                'toti' => 1,
//                'allow' => false,
//                'allowkrn' => true,
//            ]);
//
//            $url = "http://safedc.memmserve.com:19071/tokenGen";
//
//            $body = json_encode($databody);
//            $curl = curl_init();
//
//            curl_setopt_array($curl, array(
//                CURLOPT_URL => $url,
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => '',
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 0,
//                CURLOPT_FOLLOWLOCATION => true,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => 'POST',
//                CURLOPT_POSTFIELDS => $body,
//                CURLOPT_HTTPHEADER => array(
//                    'Accept: application/json',
//                    'Content-Type: application/json'
//                ),
//            ));
//
//            $var2 = curl_exec($curl);
//            curl_close($curl);
//            $var = json_decode($var2);
//
//
//            dd($var);
//
//
//            $response = $var->responsecode ?? null;
//
//            if ($response == "00") {
//                $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
//                $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
//                $data['service'] = "MOMAS";
//                $data['order_id'] = $trx;
//                $data['token'] = $var->recieptNumber;
//                $data['amount'] = $amount;
//                $data['date'] = $dater;
//
//
//                $ved = new MeterToken();
//                $ved->user_id = Auth::id();
//                $ved->order_id = $trx;
//                $ved->token = $var->recieptNumber;
//                $ved->amount = $amount;
//                $ved->estate_id = Auth::user()->estate_id;
//                $ved->meterNo = $meterNo;
//                $ved->estate_name = Estate::where('id', Auth::user()->estate_id)->first()->title;
//                $ved->unit = $var->unit;
//                $ved->vat = $var->vat;
//                $ved->status = 2;
//                $ved->save();
//
//
//                $email = Auth::user()->email;
//                $token = $var->recieptNumber;
//                $unit = $var->unit;
//
//                send_email_token($email, $token, $amount, $unit);
//
//
//            } else {
//
//                User::where('id', Auth::id())->increment('main_wallet', $amount);
//                return response()->json([
//                    'status' => false,
//                    'message' => "Meter vending failed, Retry again using your wallet"
//                ], 200);
//
//
//            }
//
//
//            return response()->json([
//                'status' => true,
//                'data' => $data
//            ], 200);
//
//
//        }

    }


    public
    function pay_for_others_meter_token(request $request)
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

        $user = User::where('meterNo', $request->meterNo)->first() ?? null;
        $duration = Utitlity::where('estate_id', $request->estate_id)->first()->duration;

        $utl = new UtilitiesPayment();
        $utl->user_id = $user->id ?? null;
        $utl->estate_id = $request->estate_id;
        $utl->amount = $request->min_vend_amount;
        $utl->duration = $duration;
        $utl->status = 2;
        $utl->save();

//////////////////////////////////////////////////////////////////////////test

        $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
        $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
        $data['service'] = "MOMAS";
        $data['order_id'] = $trx;
        $data['token'] = "123456944885756";
        $data['amount'] = $amount;
        $data['date'] = $dater;


        $ved = new MeterToken();
        $ved->user_id = Auth::id();
        $ved->order_id = $trx;
        $ved->meterNo = $meterNo;
        $ved->token = "123456944885756";
        $ved->estate_id = $estate_id;
        $ved->amount = $amount;
        $ved->unit = "0099847";
        $ved->vat = "1234";
        $ved->estate_name = Estate::where('id', $estate_id)->first()->title;
        $ved->status = 2;
        $ved->save();


        $email = Auth::user()->email;
        $token = "123456944885756";
        $unit = "0099847";

        send_email_token($email, $token, $amount, $unit);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);


//        $databody = array();
//
//        $url = "http://41.216.166.163:8080/MomasPayService/api/Payment/$meterNo/$meterType/999/$trx/$amount/999/$date/$final_amount/false";
//
//        $body = json_encode($databody);
//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => $url,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => '',
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 0,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => 'POST',
//            CURLOPT_POSTFIELDS => $body,
//            CURLOPT_HTTPHEADER => array(
//                'Accept: application/json',
//                'Content-Type: application/json'
//            ),
//        ));
//
//        $var = curl_exec($curl);
//        curl_close($curl);
//        $var = json_decode($var);
//        $response = $var->responsecode ?? null;


//        if ($response == "00") {
//            $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
//            $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
//            $data['service'] = "MOMAS";
//            $data['order_id'] = $trx;
//            $data['token'] = $var->recieptNumber;
//            $data['amount'] = $amount;
//            $data['date'] = $dater;
//
//
//            $ved = new MeterToken();
//            $ved->user_id = Auth::id();
//            $ved->order_id = $trx;
//            $ved->meterNo = $meterNo;
//            $ved->token = $var->recieptNumber;
//            $ved->estate_id = $estate_id;
//            $ved->amount = $amount;
//            $ved->unit = $var->unit;
//            $ved->vat = $var->vat;
//            $ved->estate_name = Estate::where('id', $estate_id)->first()->title;
//            $ved->status = 2;
//            $ved->save();
//
//
//            $email = Auth::user()->email;
//            $token = $var->recieptNumber;
//            $unit = $var->unit;
//
//            send_email_token($email, $token, $amount, $unit);
//
//        } else {
//
//            User::where('id', Auth::id())->increment('main_wallet', $amount);
//            return response()->json([
//                'status' => false,
//                'message' => "Meter vending failed, Retry again using your wallet"
//            ], 200);
//
//
//        }


        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);


    }


    public
    function reprint_meter_token(request $request)
    {

        $token = MeterToken::where('status', 2)->where('user_id', Auth::id())->get();
//        $token['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
//        $token['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
        return response()->json([
            'status' => true,
            'data' => $token
        ], 200);


    }


    public
    function get_token(request $request)
    {


        $data['token'] = MeterToken::where('id', $request->token_id)->get();
        $data['full_name'] = Auth::user()->first_name . " " . Auth::user()->last_name;
        $data['address'] = Auth::user()->address . "," . Auth::user()->city . "," . Auth::user()->state;
        $data['service'] = "Reprint";


        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);

    }


    public
    function list_meter(request $request)
    {
        $data['meters'] = Meter::count();
        $data['meter_lists'] = Meter::orderBy('created_at', 'desc')->paginate('20');
        return view('admin/meter/meter-lists', $data);
    }


    public
    function new_meter()
    {


        if (auth::user()->role == 0) {

            $data['estate'] = Estate::where('status', 2)->get();
            $data['transformer'] = Transformer::latest()->where('status', 2)->get();
            $data['tariff'] = Tariff::latest()->where('status', 2)->get();
            $data['tariffdual'] = Tariff::latest()->where('isDualTariff', "on")->get();


            return view('admin/meter/new-meter', $data);

        } elseif (auth::user()->role == 1) {


        } elseif (auth::user()->role == 2) {

        } elseif (auth::user()->role == 3) {


            $data['estate'] = Estate::where('id', auth::user()->estate_id)->first();
            $data['transformer'] = Transformer::latest()->where('estate_id', auth::user()->estate_id)->get();
            $data['tariff'] = Tariff::latest()->where('status', 2)->where('estate_id', auth::user()->estate_id)->get();
            $data['tariffdual'] = Tariff::latest()->where('isDualTariff', "on")->get();


            return view('admin/meter/new-meter', $data);


        } elseif (auth::user()->role == 4) {

        } elseif (auth::user()->role == 5) {

        } else {

        }


    }


    public
    function add_new_meter(request $request)
    {

        $ck = Meter::where('meterNO', $request->meterNo)->first()->meterNo ?? null;
        if ($ck == $request->meterNo) {
            return back()->with('error', "Meter Already Exist");
        }

        Meter::create($request->all());
        return redirect('admin/meter-list')->with('message', "Meter added successfully");

    }

    public
    function view_meter(request $request)
    {
        $data['estate'] = Estate::where('status', 2)->get();
        $data['transformer'] = Transformer::latest()->where('status', 2)->get();
        $data['tariff'] = Tariff::latest()->where('status', 2)->get();
        $data['meter'] = Meter::where('id', $request->id)->first();
        $data['trans_title'] = Transformer::where('id', $data['meter']->TransformerID)->first()->Title ?? null;
        $data['NewTariffID'] = Tariff::where('id', $data['meter']->NewTariffID)->first()->title ?? null;
        $data['OldTariffID'] = Tariff::where('id', $data['meter']->OldTariffID)->first()->title ?? null;
        $data['tariffdual'] = Tariff::latest()->where('isDualTariff', "on")->get();

        return view('admin/meter/view-meter', $data);

    }

    public
    function delete_meter(request $request)
    {
        Meter::where('id', $request->id)->delete();
        return redirect('admin/meter-list')->with('message', "Meter deleted successfully");

    }

    public
    function update_meter_info(request $request)
    {

        $meter = Meter::find($request->id);
        $meter->update($request->all());

        return redirect('admin/meter-list')->with('message', "Meter updated successfully");


    }


    public
    function update_meter(request $request)
    {

        if ($request->meterNo !== null) {
            $m_id = Meter::where('meterNo', $request->meterNo)->first()->id ?? null;

            if ($m_id == null) {
                return back()->with('error', "Meter not found, contact admin");
            }

            Meter::where('meterNo', $request->old_value)->update(['user_id' => null]);

            User::where('id', $request->user_id)->update(['meterNo' => $request->meterNo, 'meterid' => $m_id]);

            Meter::where('meterNo', $request->meterNo)->update(['user_id' => $request->user_id]);

            return back()->with('message', "Meter Attached  successfully");

        }


    }


    public
    function meter_deactivate(request $request)
    {

        Meter::where('id', $request->id)->update(['status' => 0]);

        return back()->with('message', "Meter Deactivated successfully");


    }


    public
    function meter_activate(request $request)
    {

        Meter::where('id', $request->id)->update(['status' => 2]);

        return back()->with('message', "Meter Activated successfully");


    }

    public
    function vending_properties(request $request)
    {

        $duration = Utitlity::where('estate_id', Auth::user()->estate_id)->first()->duration ?? null;
        $estate_id = Auth::user()->estate_id ?? null;

        if ($duration == null || $estate_id == null) {
            $minvend = "Not set";
        } else {
            $get_vend = vend($duration, $estate_id);
            if ($get_vend == null) {
                $minvend = "Not set";
            } else {
                $minvend = $get_vend;
            }
        }

        $min_pur = Estate::where('id', Auth::user()->estate_id)->first()->min_pur ?? null;

        return response()->json([
            'status' => true,
            'min_purchase' => (int)$min_pur,
            'min_vend' => (int)$minvend
        ]);


    }


}
