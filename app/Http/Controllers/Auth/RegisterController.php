<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{


    public
    function reset_password(request $request)
    {
        User::where('email', $request->email)->update([
            'password' => bcrypt($request->password)
        ]);


        $email = $request->email;
        send_reset_email_notification($email);

        $message = "Password Reset Successfully";
        return success($message);


    }


    public function check_user(request $request)
    {

        if ($request->action == "reset") {

            $usr = User::where('email', $request->email)->first() ?? null;
            if ($usr == null) {
                $code = 422;
                $message = "User not found";
                return error($code, $message);
            }


            $sms_code = random_int(0000, 9999);
            $email = $request->email;

            User::where('email', $request->email)->update(['code' => $sms_code]);
            $user = send_email_reset($email, $sms_code);

            if ($user == 0) {
                $message = "OTP Code has been sent successfully to $email";
                return success($message);
            }


        }


        if ($request->action == "register") {

            $usr = User::where('email', $request->email)->first() ?? null;
            $status = User::where('email', $request->email)->first()->status ?? null;


            if ($usr == null) {
                $sms_code = random_int(0000, 9999);
                $email = $request->email;

                $usrr = new User();
                $usrr->email = $email;
                $usrr->save();

                User::where('email', $request->email)->update(['code' => $sms_code]);
                $user = send_email($email, $sms_code);

                if ($user == 0) {
                    $message = "OTP Code has been sent successfully to $email";
                    return success($message);
                }

            }


            if ($status == 0) {
                $sms_code = random_int(0000, 9999);
                $email = $request->email;
                User::where('email', $request->email)->update(['code' => $sms_code]);
                $user = send_email($email, $sms_code);

                if ($user == 0) {
                    $message = "OTP Code has been sent successfully to $email";
                    return success($message);
                }


            }

            if ($status == 2) {

                $code = 422;
                $message = "User Already exist with email, Please login";
                return error($code, $message);

            }

        }


        if ($request->action == "forget") {

            $usr = User::where('email', $request->email)->first() ?? null;

            if ($usr != null) {

                $sms_code = random_int(0000, 9999);
                $email = $request->email;

                User::where('email', $request->email)->update(['code' => $sms_code]);
                $user = send_email_reset($email, $sms_code);

                if ($user == 0) {
                    $message = "OTP Code has been sent successfully to $email";
                    return success($message);
                }

            } else {

                return response()->json([
                    'status' => false,
                    'message' => "Email does not exist",
                ], 422);
            }


        }


        $usr = User::where('email', $request->email)->first() ?? null;
        $status = User::where('email', $request->email)->first()->status ?? null;

        if($status != 2){
            User::where('email', $request->email)->delete();
        }

        if ($usr == null && $status != 2) {
            $sms_code = random_int(0000, 9999);
            $email = $request->email;


            $usrr = new User();
            $usrr->email = $email;
            $usrr->save();

            User::where('email', $request->email)->update(['code' => $sms_code]);
            $user = send_email($email, $sms_code);

            if ($user == 0) {
                $message = "OTP Code has been sent successfully to $email";
                return success($message);
            }
        } elseif ($status == 2) {
            $code = 422;
            $message = "User already exist, login your account";
            return error($message, $code);
        }


    }

    public function validate_email(request $request)
    {

        $code = $request->code;
        $email = $request->email;

        $validate = validate_code($code, $email);
        if ($validate == 0) {
            $message = "OTP code verified successfully";
            return success($message);
        } else {
            $code = 422;
            $message = "Invalid Code";
            return error($message, $code);
        }

    }


    public function register(request $request)
    {


        $usr = User::where('email', $request->email)->first() ?? null;
        if ($usr == null) {

            $code = 422;
            $message = "Please Verify your email";
            return error($message, $code);
        }


        $gm = Meter::where('meterNo', $request->meterNo)->first() ?? null;
        $muser_id = Meter::where('meterNo', $request->meterNo)->first()->user_id ?? null;
        if ($gm == null) {
            $code = 422;
            $message = "Meter has not been profiled";
            return error($message, $code);

        }

        if($muser_id != null){
            $code = 422;
            $message = "Meter is already attached to a customer";
            return error($message, $code);
        }


        $ptype = Meter::where('meterNo', $request->meterNo)->first()->ptype ?? null;
        if($ptype == 2){
            $code = 422;
            $message = "You can not register at the moment. Kindly visit your estate manager for further instruction";
            return error($message, $code);
        }



        $estate_name = Estate::where('id', $gm->estate_id)->first()->first()->title ?? null;

        if ($usr->status == 1) {

            User::where('email', $request->email)->update([

                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'phone' => $request->phone,
                'meterNo' => $request->meterNo,
                'estate_id' => $gm->estate_id ?? null,
                'estate_name' => $gm->estate_name ?? null,
                'status' => 2,
                'password' => bcrypt($request->password),

            ]);

            $user_id = User::where('email', $request->email)->first()->id;
            Meter::where('meterNo', $request->meterNo)->update(['user_id' => $user_id]);


            $message = "Account Registered Successfully";
            return success($message);

        }

        if ($usr->status == 0) {
            $code = 422;
            $message = "Please Verify your email";
            return error($message, $code);

        }

        if ($usr->status == 2) {
            $code = 422;
            $message = "User Already Exist";
            return error($message, $code);

        }


        $code = 422;
        $message = "We can not register this moment!!";
        return error($code, $message);


    }
}
