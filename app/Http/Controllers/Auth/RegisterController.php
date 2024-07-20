<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function check_user (request $request)
    {
        $usr = User::where('email', $request->email)->first() ?? null;

        if($usr == null){

            $sms_code = random_int(0000, 9999);
            $email = $request->email;
            $usrr = new User();
            $usrr-> email = $email;
            $usrr-> save();
            User::where('email', $request->email)->update(['code' => $sms_code]);
            $user = send_email($email, $sms_code);

            if($user == 0){
                $message = "OTP Code has been sent successfully to $email";
                return  success($message);
            }
            
        }


        if($usr->status == 0){


            $sms_code = random_int(0000, 9999);
            $email = $request->email;
            User::where('email', $request->email)->update(['code' => $sms_code]);
            $user = send_email($email, $sms_code);

            if($user == 0){
                $message = "OTP Code has been sent successfully to $email";
                return success($message);
            }
            

        }

        if($usr->status == 2){

            $code = 422;
            $message = "User Already exust with email, Please login";
            return  error($code, $message);

        }


    }

    public function validate_email(request $request){

        $code = $request->code;
        $email = $request->email;

        $validate = validate_code($code, $email);
        if($validate == 0){
            $message = "OTP code verified successfully";
            return success($message);
        }else{
            $code = 422;
            $message = "Invalid Code";
            return error($message, $code);
        }

    }





    public function register(request $request)
    {


        $usr = User::where('email', $request->email)->first() ?? null;
        if($usr == null){

            $code = 422;
            $message = "Please Verify your email";
            return error($message, $code);
        }


        if($usr->status == 1){

            User::where('email', $request->email)->update([

                'first_name' =>  $request->first_name,
                'last_name' =>  $request->last_name,
                'phone' =>  $request->phone,
                'meterNo' =>  $request->meterNo,
                'status' =>  2,
                'password' => bcrypt($request->password),

            ]);


            $message = "Account Registred Successffuly";
            return success($message);

        }

        if($usr->status == 0){
            $code = 422;
            $message = "Please Verify your email";
            return error($message, $code);

        }

        if($usr->status == 2){
            $code = 422;
            $message = "User Already Exist";
            return error($message, $code);

        }



        $code = 422;
        $message = "We can not register this moment!!";
        return error($code, $message);







    }
}
