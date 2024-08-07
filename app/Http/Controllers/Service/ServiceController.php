<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Job;
use App\Models\Service;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ServiceController extends Controller
{
    public function service_properties(request $request)
    {

        $data['estate'] = Estate::where('status', 1)->get()->makeHidden(['created_at', 'updated_at']);
        $data['service'] = Service::where('status', 1)->get()->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'status' => true,
            'data' => $data

        ], 200);


    }

    public function service_search(request $request)
    {
      $jobs =   Job::where('estate_id', $request->estate_id)->where('service_id', $request->service_id)->get()->makeHidden(['created_at', 'updated_at']) ?? null;
      if($jobs == null){
          $code = 401;
          $message = "Service Nor Available";
          return error($message, $code);
      }

      if(isEmpty($jobs)){

          $code = 422;
          $message = "Service not available in your estate";
          return error($message, $code);
      }


        return response()->json([
            'status' => true,
            'data' => $jobs

        ], 200);


    }
}
