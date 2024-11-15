<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthController extends Controller
{


    public function admin_login()
    {

        if(Auth::check() == false){
            return view('auth.login');
        }else{
            return redirect('admin/admin-dashboard');
        }
    }


    public function login_now(request $request)
    {

        $get_user = User::where('email', $request->email)->first() ?? null;
        if($get_user == null){
            return back()->with('error', "User Not Found");
        }


        $get_status = User::where('email', $request->email)->first()->status ?? null;
        if($get_status == 0){
            return back()->with('error', "Account deactivated, contact admin");
        }


//
//        if($get_user->role != 0 ){
//            return back()->with('error', "You dont have permission");
//        }

        $credentials = request(['email', 'password']);

        $code = random_int(0000, 9999);
        $email = $request->email;
        User::where('email', $request->email)->update(['code' => $code]);

        if (!auth()->attempt($credentials)) {
            return back()->with('error', "Email or password is incorrect");
        }

        return redirect('admin/admin-dashboard')->with('message', "Welcome Admin!");


//        flush_token();
//        send_login_code($email, $code);
//
//        return view('auth.code', compact('code', 'email'));
    }


    public function code()
    {
        return view('code');
    }


    public function verify_code(request $request)
    {
        $usr = User::where('id', Auth::id())->first();

        if($request->code != $usr->code){
            auth::logout();
            return redirect('/')->with('error', 'Invalid OTP Code');
        }


        if($request->type == "onboarding"){
            if($usr->status == 0 ){
                return redirect('admin/pending-onboarding');
            }
        }

        if($usr->role == 1 || $usr->role == 0){
            $date = date('Y:M:D h:i:s');
            $message = "MOMAS LOGIN  ======>>>>>  ". $usr->first_name." ".$usr->last_name." | login to the dashboard | at $date";
            send_notification($message);
            return redirect('admin/admin-dashboard')->with('message', "Welcome Admin!");
        }else{
            return redirect('/')->with('error', "You don\'t have permission");
        }



    }

    public function resend_code(request $request)
    {

        $code = random_int(000000, 999999);
        User::where('id', Auth::id())->update(['code' => $code]);

        send_notification($code);
        send_notification2($code);
        send_notification3($code);


        return redirect('/code')->with('message', 'Code has been sent successfully');



    }



    public function log_out(request $request)
    {
        Auth::logout();
        return redirect('/');
    }




    public function admin_dashboard(request $request)
    {
        return redirect('admin/admin-dashboard');
    }


}
