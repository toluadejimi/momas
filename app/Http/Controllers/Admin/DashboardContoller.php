<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Feature;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\Setting;
use App\Models\Token;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardContoller extends Controller
{

    public function index()
    {
        $data['users'] = User::where('status', 2)->count();
        $data['meter'] = Meter::count();
        $data['total_in'] = Transaction::where('status', 2)->sum('amount');
        $data['estate'] = Estate::where('status', 1)->count();
        $data['token'] = Token::count();
        $data['meter_token'] = MeterToken::where('status', 2)->count();
        $data['transaction'] = Transaction::paginate('20');
        return view('admin.dashboard', $data);

    }


    public function list_users()
    {
        $data['users'] = User::where('status', 2)->count();
        $data['users_lists'] = User::paginate('20');

        return view('admin/user-list', $data);

    }

    public function new_user()
    {
        $data['estate'] = Estate::all();
        return view('admin/new-user', $data);

    }


    public function add_new_user(request $request)
    {

        $usr_email = User::where('email', $request->email)->first()->email ?? null;
        $usr_phone = User::where('email', $request->email)->first()->phone ?? null;

        if($usr_email == null && $usr_phone == null){
            User::create($request->all());
            return redirect('admin/users-list')->with('message', "User created successfully");
        }else{

            return redirect('admin/users-list')->with('error', "User already  exist");

        }


    }


    public function delete_user(request $request)
    {
        User::where('id',$request->id)->delete();
        Transaction::where('user_id',$request->id)->delete();

        return redirect('admin/users-list')->with('message', "User deleted successfully");

    }


    public function settings(request $request)
    {
        $data['fea'] = Feature::where('id', 1)->first();
        $data['set'] = Setting::where('id', 1)->first();

        return view('admin/settings', $data);

    }



    public function update_pay(request $request)
    {
        Setting::where('id', 1)->update([
            'flutterwave_secret' => $request->flutterwave_secret,
            'flutterwave_public' => $request->flutterwave_public,
            'paystack_secret' => $request->paystack_secret,
            'paystack_public' => $request->paystack_public,

        ]);
        return redirect('admin/settings')->with('message', "Payment Keys updated successfully");

    }

    public function support_set(request $request)
    {
        Setting::where('id', 1)->update([
            'payment_support' => $request->payment_support,
            'meter_support' => $request->meter_support,
            'general_support' => $request->general_support,

        ]);
        return redirect('admin/settings')->with('message', "Payment Keys updated successfully");

    }




    public function update_feat(request $request)
    {
        Feature::where('id', 1)->update([
            'momas_meter' => $request->momas_meter,
            'other_meter' => $request->other_meter,
            'print_token' => $request->print_token,
            'access_token' => $request->access_token,
            'services' => $request->services,
            'bill_payment' => $request->bill_payment,
            'support' => $request->support,
            'analysis' => $request->analysis,

        ]);
        return redirect('admin/settings')->with('message', "Features updated successfully");

    }

















}