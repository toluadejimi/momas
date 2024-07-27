<?php

namespace App\Http\Controllers\Meter;

use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\User;
use Illuminate\Http\Request;

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
}
