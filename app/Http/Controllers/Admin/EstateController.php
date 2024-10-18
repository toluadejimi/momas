<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Tariff;
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

        $data['org'] = Estate::where('id', $request->id)->first();
        $data['tar'] = Tariff::where('id', $request->id)->first();
        $data['utl'] = Utitlity::where('id', $request->id)->first();
        $data['total_utility'] = $data['utl']->water + $data['utl']->eletricity +  $data['utl']->security + $data['utl']->waste + $data['utl']->cleaners + $data['utl']->grardners + $data['utl']->service_charge;


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
