<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Feature;
use App\Models\Meter;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\User;
use App\Models\Utitlity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateController extends Controller
{
    public function estate_index(request $request)
    {
        $data['estate_list'] = Estate::paginate(20);
        $data['estate'] = Estate::count();

        return view('admin/estate/index', $data);

    }


    public function estate_new(request $request)
    {
        return view('admin/estate/create');
    }


    public function estate_store(request $request)
    {

        $org = new estate();
        $org->title = $request->title;
        $org->state = $request->state;
        $org->lga = $request->lga;
        $org->city = $request->city;
        $org->ptype = $request->ptype;
        $org->paystack_subaccount = $request->paystack_subaccount;
        $org->flutterwave_subaccount = $request->flutterwave_subaccount;
        $org->account_no = $request->account_no;
        $org->charge_fee = $request->charge_fee;
        $org->bank = $request->bank;
        $org->status = 2;
        $org->save();

        return redirect('admin/estate')->with('message','Estate created successfully');
    }


    public function estate_view(request $request)
    {



        if(auth::user()->role == 0){

            $data['org'] = Estate::where('id', $request->id)->first();
            $data['tar'] = Tariff::where('estate_id', $request->id)->first();
            $data['utl'] = Utitlity::where('estate_id', $request->id)->first() ?? null;
            $data['total_utility'] = Utitlity::where('estate_id', $request->id)->sum('amount');
            $data['utility'] = Utitlity::where('estate_id', $request->id)->get() ?? null;
            $data['total_meters'] = Meter::where('estate_id', $request->id)->count() ?? null;
            $data['customers'] = User::where('estate_id', $request->id)->count() ?? null;



        } elseif(auth::user()->role == 1){


        } elseif(auth::user()->role == 2){

        } elseif(auth::user()->role == 3){



            $data['org'] = Estate::where('id', auth::user()->estate_id)->first();
            $data['tar'] = Tariff::where('estate_id', auth::user()->estate_id)->first();
            $data['utl'] = Utitlity::where('estate_id', auth::user()->estate_id)->first() ?? null;
            $data['total_utility'] = Utitlity::where('estate_id', auth::user()->estate_id)->sum('amount');



            $data['utility'] = Utitlity::where('estate_id', auth::user()->estate_id)->get() ?? null;


        } elseif(auth::user()->role == 4){

        } elseif(auth::user()->role == 5){

        } else{

        }

        return view('admin/estate/view', $data);
    }












    public function estate_update(request $request)
    {

        Estate::where('id', $request->id)->update([
            'title' => $request->title,
            'status' => $request->status,
            'state' => $request->state,
            'city' => $request->city,
            'lga' => $request->lga,
            'ptype' => $request->ptype,
            'paystack_subaccount' =>  $request->paystack_subaccount,
            'flutterwave_subaccount' =>  $request->flutterwave_subaccount,
            'account_no' =>  $request->account_no,
            'bank' =>  $request->bank,
            'charge_fee' =>  $request->charge_fee,
            'charge_fee_percent' =>  $request->charge_fee_percent,
            'pos_tariff_id' =>  $request->pos_tariff_id,
            'serial_no' =>  $request->serial_no,

        ]);
        return redirect('admin/estate')->with('message','Estate updated successfully');
    }







    public function estate_delete(request $request)
    {
        Estate::where('id', $request->id)->delete();
        return redirect('admin/estate')->with('message','Estate deleted successfully');
    }

    public function estate_update_tariff(request $request)
    {
        Tariff::where('estate_id', $request->id)->update([
            'estate_tariff_cost' => $request->amount,
            'vat' => $request->vat,
            'min_pur' => $request->min_pur,
            'max_pur' => $request->max_pur,

        ]);


        return back()->with('message','Tariff updated successfully');
    }

    public function estate_update_utilities(request $request)
    {

        $utilitiesData = json_decode($request->input('utilities_data'), true);
        if (is_array($utilitiesData)) {
            foreach ($utilitiesData as $utility) {
                if (!empty($utility['title']) && !empty($utility['amount'])) {
                    Utitlity::create([
                        'title' => $utility['title'],
                        'amount' => $utility['amount'],
                        'duration' => $request->duration,
                        'estate_id' => auth::user()->estate_id,

                    ]);
                }
            }
        }


        return redirect()->back()->with('success', 'Utilities updated successfully');


    }


    public function update_duration(request $request)
    {


                    Estate::where('id', $request->id)->update([
                        'duration' => $request->duration,
                    ]);


        return redirect()->back()->with('success', 'Duration updated successfully');


    }




    public function estate_deactivate(request $request)
    {

        Estate::where('id', $request->id)->update(['status' => 0]);

        return back()->with('message', "Estate Deactivated successfully");


    }


    public function estate_activate(request $request)
    {

        Estate::where('id', $request->id)->update(['status' => 2]);

        return back()->with('message', "Estate Activated successfully");


    }





}
