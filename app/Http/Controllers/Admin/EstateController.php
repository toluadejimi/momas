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





}
