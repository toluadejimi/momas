<?php

namespace App\Http\Controllers\Estate;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateController extends Controller
{

    public function get_estate(){

        $data = Estate::where('status', 1)->get()->makeHidden(['created_at','updated_at']);
        return response()->json([
            'status' => true,
            'data' => $data
        ]);


    }


    public function estate_token(request $request){


        $user_id = Auth::id();
        $visitor = $request->qty;
        $email = $request->email;
        $can_send = $request->can_send_mail;
        $estate_id = $request->estate_id;
        $currentTime = Carbon::now();
        $valid_date = $currentTime->addHours(24);





        $tok = generate_token($user_id, $visitor, $email, $valid_date);


        if($can_send == 1){

            $token_code = $tok['token'];
            $estate = Estate::where('id', $estate_id)->first()->title ?? null;


            $send = send_token_email($email, $token_code, $estate, $valid_date);

           if($send == 0 ){
               return response()->json([
                   'status' => true,
                   'message' => "Token Created Successfully, Token sent to visitor"
               ]);

           }
        }


        return response()->json([
            'status' => true,
            'message' => "Token Created Successfully"
        ]);


    }



    public function approve_token(request $request){

        Token::where('id', $request->token_id)->update(['status' => 1]);
        return response()->json([
            'status' => true,
            'message' => "Token Successfully Approved"
        ]);


    }



    public function disapprove_token(request $request){

        Token::where('id', $request->token_id)->update(['status' => 3]);
        return response()->json([
            'status' => true,
            'message' => "Token Successfully Disapproved"
        ]);


    }


    public function delete_token(request $request){

        Token::where('id', $request->token_id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Token Successfully Deleted"
        ]);


    }


    public function set_default_estate(request $request){


        $name = Estate::where('id', $request->estate_id)->first()->title;
        User::where('id', Auth::id())->update([
            'estate_id' => $request->estate_id,
            'address' => $request->address,
            'hno' => $request->hno,
            'estate_name' => $name,


        ]);

        return response()->json([
            'status' => true,
            'message' => "Default Address Set successfully"
        ]);


    }




}