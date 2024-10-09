<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Feature;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\Organization;
use App\Models\Setting;
use App\Models\Token;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UtilitiesPayment;
use App\Models\Utitlity;
use App\Models\Vending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardContoller extends Controller
{

    public function index()
    {
        if(auth::user()->role == 0){

            $data['users'] = User::where('status', 2)->count();
            $data['meter'] = Meter::count();
            $data['total_in'] = Transaction::where('status', 2)->sum('amount');
            $data['estate'] = Estate::where('status', 1)->count();
            $data['token'] = Token::count();
            $data['meter_token'] = MeterToken::where('status', 2)->count();
            $data['transaction'] = Transaction::paginate('20');
            return view('admin.dashboard', $data);

        } elseif(auth::user()->role == 1){

        } elseif(auth::user()->role == 2){

        } elseif(auth::user()->role == 3){

            $data['users'] = User::where('status', 2)->where('estate_id', auth::user()->estate_id)->count();
            $data['customers'] = User::where([
                'status' => 2,
                'estate_id' => auth::user()->estate_id,
                'role' => 2,
            ])->count();

            $data['meter'] = Meter::where('estate_id', auth::user()->estate_id)->count();
            $data['token'] = Token::where('estate_id', auth::user()->estate_id)->count();

            return view('admin.dashboard', $data);

        } elseif(auth::user()->role == 4){

        } elseif(auth::user()->role == 5){

        } else{

        }








    }


    public function list_users()
    {


        $data['users'] = User::where('status', 2)->count();
        $data['users_lists'] = User::paginate('20');

        return view('admin/user/user-list', $data);

    }


    public function list_customers()
    {


        $data['users'] = User::where('status', 2)->where('role', 2)->count();
        $data['users_lists'] = User::where('role', 2)->paginate('20');

        return view('admin/user/customer-list', $data);

    }






    public function new_user()
    {



        if(auth::user()->role == 0){

            $data['estate'] = Estate::all();
            $data['meters'] = Meter::all();
            return view('admin/user/new-user', $data);


        } elseif(auth::user()->role == 1){


        } elseif(auth::user()->role == 2){

        } elseif(auth::user()->role == 3){

            $data['estate'] = Estate::where('id', auth::user()->estate_id)->first();
            $data['meters'] = Meter::all();

            return view('admin/user/new-user', $data);


        } elseif(auth::user()->role == 4){

        } elseif(auth::user()->role == 5){

        } else{

        }



    }


    public function add_new_user(request $request)
    {


        $usr_email = User::where('email', $request->email)->first()->email ?? null;
        $usr_phone = User::where('email', $request->email)->first()->phone ?? null;

        if($usr_email == null && $usr_phone == null){



            $estate_name = Estate::where('id', $request->estate_id)->first()->title;
            $usr = new User();
            $usr->first_name = $request->first_name;
            $usr->last_name = $request->last_name;
            $usr->phone = $request->phone;
            $usr->email = $request->email;
            $usr->role = $request->role;
            $usr->estate_id = $request->estate_id;
            $usr->estate_name = $estate_name;
            $usr->meterNo = $request->meterNo;
            $usr->meterType = $request->meterType;
            $usr->lga = $request->lga;
            $usr->state = $request->state;
            $usr->hno = $request->hno;
            $usr->address = $request->address;
            $usr->city = $request->city;
            $usr->status = 2;
            $usr->password = bcrypt($request->password);
            $usr->save();


            $m_no = Meter::where('id', $request->meterid)->first()->meterNo;
            User::where('id', $usr->id)->update(['meterNo' => $m_no, 'meterid' => $request->meterid]);

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
        return redirect('admin/settings')->with('message', "Support data updated successfully");

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



    public function organization_index(request $request)
    {
        $data['organization_list'] = Organization::paginate(20);
        $data['organization'] = Organization::where('status', 2)->count();


        return view('admin/organization/index', $data)->with('message', "Features updated successfully");

    }


    public function organization_new(request $request)
    {
        return view('admin/organization/create');
    }


    public function organization_store(request $request)
    {

       $org = new Organization();
       $org->title = $request->title;
       $org->status = 2;
       $org->save();

        return redirect('admin/organization')->with('Organization created successfully');
    }


    public function organization_view(request $request)
    {

        $data['org'] = Organization::where('id', $request->id)->first();
        return view('admin/organization/view', $data);
    }

    public function organization_update(request $request)
    {
         Organization::where('id', $request->id)->update(['title' => $request->title]);
        return redirect('admin/organization')->with('Organization updated successfully');
    }

    public function organization_delete(request $request)
    {
        Organization::where('id', $request->id)->delete();
        return redirect('admin/organization')->with('Organization deleted successfully');
    }




    public function view_user(request $request)
    {
        $data['user'] = User::where('id', $request->id)->first();
        $data['estate'] = Estate::where('status', 2)->get();
        $data['estate_name'] = Estate::where('id', $data['user']->estate_id)->first()->title ?? null;
        $data['upayment'] = UtilitiesPayment::where('user_id', $request->id)->paginate(10);
        $data['vending'] = MeterToken::where('user_id', $request->id)->paginate(10);
        $data['meters'] = Meter::all();




        return view('admin/user/view', $data);
    }


    public function send_token_email(request $request)
    {
        $email = $request->email;
        $token = $request->token;
        $amount = $request->amount;
        $unit = $request->unit;
        send_email_token($email, $token, $amount, $unit);

        return back()->with('message', 'Email sent successfully');
    }







    public function update_user(request $request)
    {

            User::where('email', $request->email)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->addreess,
                'city' => $request->city,
                'lga' => $request->lga,
            ]);


            return back()->with('message', "User updated successfully");

        }
















}
