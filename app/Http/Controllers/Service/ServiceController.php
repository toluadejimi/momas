<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\EstateService;
use App\Models\Job;
use App\Models\Rating;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class ServiceController extends Controller
{
    public function service_properties(request $request)
    {

        $data['estate'] = Estate::where('status', 2)->get()->makeHidden(['created_at', 'updated_at']);
        $data['service'] = EstateService::where('status', 2)->where('estate_id', auth::user()->estate_id)->get()->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'status' => true,
            'data' => $data

        ], 200);


    }

    public function service_search(request $request)
    {
      $jobs =   EstateService::where('estate_id', $request->estate_id)->where('service_id', $request->service_id)->get()->makeHidden(['created_at', 'updated_at']) ?? null;

      if($jobs == null){
          $code = 401;
          $message = "Service Nor Available";
          return error($message, $code);
      }

        return response()->json([
            'status' => true,
            'data' => $jobs

        ], 200);


    }



    public function get_comment(request $request)
    {

//        $data['professional_name'] = Job::where('job_id', $request->job_id)->first()->proffessional_name ?? null;
//        $data['rating'] = Rating::where('job_id', $request->job_id)->max('count');
//        $data['service_title'] = Job::where('job_id', $request->job_id)->first()->service_title ?? null;
//        $data['professional_phone'] = Job::where('job_id', $request->job_id)->first()->professional_phone ?? null;
//        $data['comment'] = Rating::where('job_id', $request->job_id)->get();


        $data =  Rating::where('job_id', $request->job_id)->get();
        $rate =  Rating::where('job_id', $request->job_id)->max('count');
        Job::where('id', $request->job_id)->update(['rating' => $rate]) ?? null;


        return response()->json([
            'status' => true,
            'comment' => $data,
        ], 200);


    }



    public function save_comment(request $request)
    {
        $rate = new Rating();
        $rate->user_id = Auth::id();
        $rate->user_name = Auth::user()->first_name;
        $rate->count = $request->rate;
        $rate->comment = $request->comment;
        $rate->job_id = $request->job_id;
        $rate->save();

        return response()->json([
            'status' => true,
            'message' => "Comment successfully saved"
        ], 200);


    }
}
