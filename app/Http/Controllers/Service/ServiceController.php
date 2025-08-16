<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Comment;
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

        $data['service'] = Service::latest()->where('status', 2)->get()->makeHidden(['created_at', 'updated_at']);

        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);


    }

    public function service_search(request $request)
    {
      $jobs =   EstateService::latest()->where('estate_id', $request->estate_id)->where('service_id', $request->service_id)->get()->makeHidden(['created_at', 'updated_at']) ?? null;

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

        $data =  Comment::latest()->where('job_id', $request->job_id)->get();
        $rate =  Rating::latest()->where('job_id', $request->job_id)->max('count');
        Job::where('id', $request->job_id)->update(['rating' => $rate]) ?? null;


        return response()->json([
            'status' => true,
            'comment' => $data,
        ], 200);


    }



    public function save_comment(request $request)
    {
        $rate = new Comment();
        $rate->user_id = Auth::id();
        $rate->user_name = Auth::user()->first_name;
        $rate->comment = $request->comment;
        $rate->job_id = $request->job_id;
        $rate->estate_service_id = $request->job_id;
        $rate->rate = $request->rate;
        $rate->save();


        return response()->json([
            'status' => true,
            'message' => "Comment successfully saved"
        ], 200);


    }
}
