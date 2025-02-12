<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\Tariff;
use App\Models\TarrifState;
use App\Models\Token;
use App\Models\Transaction;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TariffController extends Controller
{


    public function tariff_list(request $request)
    {


        if(auth::user()->role == 0){

            $data['tariff_list'] = Tariff::latest()->paginate(20);
            $data['tariffis'] = Tariff::all();
            $data['tarifftariffis'] = Tariff::count();
            $data['estate'] = Estate::all();



            return view('admin/tariff/index', $data);



        } elseif(auth::user()->role == 1){

        } elseif(auth::user()->role == 2){

        } elseif(auth::user()->role == 3){

            $data['tariff_list'] = Tariff::latest()->where('estate_id', auth::user()->estate_id)->get();
            $data['tariffis'] = Tariff::latest()->latest()->where('estate_id', auth::user()->estate_id)->get();
            $data['tarifftariffis'] = Tariff::where('estate_id', auth::user()->estate_id)->count();
            $data['estate']  = Estate::all();

            return view('admin/tariff/index', $data);


        } elseif(auth::user()->role == 4){

        } elseif(auth::user()->role == 5){

        } else{

        }




    }


    public function new_tariff(request $request)
    {


        $data['estate']  = Estate::all();
        return view('admin.tariff.new-tariff', $data);

    }



    public function add_new_Tariff(request $request)
    {

        $ck = Tariff::where('title', $request->title)->first() ?? null;

        if($ck != null){
            return back()->with('error', 'Tariff already exist');
        }

        $tr = new Tariff();
        $tr->title = $request->title;
        $tr->estate_id = $request->estate_id;
        $tr->status = 2;
        $tr->tariff_index = $request->tariff_index;
        $tr->type = $request->tariff_source;
        $tr->save();

        $tr = Tariff::where('id', $tr->id)->first();

        return redirect("/admin/view-tariff?id=$tr->id")->with('message', "Tariff created successfully");


    }








    public function delete_tariff(request $request)
    {

        Tariff::where('id', $request->id)->delete();
        return back()->with('messsage', 'Tariff deleted successfully');

    }


    public function view_tariff(request $request)
    {

        $tr = Tariff::where('id', $request->id)->first();
        $tstate = TarrifState::where('tariff_id', $request->id)->get();
        $effictive_date = TarrifState::where('tariff_id', $request->id)->where('status', 2)->first()->effective_from ?? null;
        $estate = Estate::all();


        return view('admin.tariff.view', compact('tr', 'tstate','estate', 'effictive_date'));

    }

    public function add_state_tariff(request $request)
    {

        $id = $request->id;


        if($request->date_to == null && $request->never_expire == "yes"){


            $tr = new TarrifState();
            $tr->amount = $request->amount;
            $tr->effective_from = $request->date_from;
            $tr->effective_to = null;
            $tr->tariff_id = $request->id;
            $tr->estate_id = $request->estate_id;
            $tr->vat = $request->vat;
            $tr->save();

            $ck_count = TarrifState::where('tariff_id', $request->id)->count();
            if($ck_count == 1){
                TarrifState::latest()->where('status', 0)->where('tariff_id', $request->id)->update(['status' => 2]);
            }

            return back()->with('message', 'Tariff Added Successfully');

        }


        if($request->date_to == null && $request->never_expire == "no"){
            return redirect("admin/view-tariff?id=$id")->with('error', 'Please choose effective date to');
        }

        if($request->date_to != null && $request->never_expire == "no"){
            return redirect("admin/view-tariff?id=$id")->with('error', 'Effective date has been set please choose NO on never expire option');
        }

        $ddfrom = new DateTime($request->date_from);
        $ddto = new DateTime($request->date_to);

        if( $ddfrom >= $ddto  ){
            return redirect("admin/view-tariff?id=$id")->with('error', 'End date can not be greater than start date');
        }

        $newdate = TarrifState::latest()->where('status', 2)->where('tariff_id', $request->id)->first()->effective_to ?? null;
        $nd = new DateTime($newdate) ?? null;

        if($ddto <= $nd ){
            return redirect("admin/view-tariff?id=$id")->with('error', 'you have a running tariff');
        }

        $tr = new TarrifState();
        $tr->amount = $request->amount;
        $tr->effective_from = $request->date_from;
        $tr->effective_to = $request->date_to;
        $tr->tariff_id = $request->id;
        $tr->estate_id = $request->estate_id;
        $tr->vat = $request->vat;
        $tr->save();

        $ck_count = TarrifState::where('tariff_id', $request->id)->count();

        if($ck_count == 1){
            TarrifState::latest()->where('status', 0)->where('tariff_id', $request->id)->update(['status' => 2]);
        }


        return back()->with('message', 'Tariff Added Successfully');


    }




    public function update_the_tariff(request $request)
    {

        if($request->isDualTariff ==  "on"){

            Tariff::where('id', $request->id)->update([
                'title' => $request->title,
                'estate_tariff_cost' => $request->estate_tariff_cost,
                'estate_id' => $request->estate_id,
                'OldTariffDual' => $request->OldTariffDual,
                'NewTariffDual' => $request->NewTariffDual,
                'isDualTariff' => $request->isDualTariff,
            ]);


        }else{

            Tariff::where('id', $request->id)->update([
                'title' => $request->title,
                'estate_tariff_cost' => $request->estate_tariff_cost,
                'estate_id' => $request->estate_id,
                'isDualTariff' => $request->isDualTariff,
            ]);

        }

        return redirect('admin/tariff-list')->with('message', 'Tariff updated successfully');

    }


    public function update_nepa(request $request)
    {
        $ck = Tariff::where('user_id', $request->user_id)->where('type', 'nepa')->first() ?? null;


        if($ck != null){
            Tariff::where('id', $request->id)->where('user_id', $request->user_id)->update([
                'user_id' => null,
                 'type' => 'nepa'
            ]);
        }


        Tariff::where('id', $request->id)->update([
            'user_id' => $request->user_id, 'type' => "nepa"
        ]);



        return back()->with('message', "User Tariff has been updated");

    }


    public function update_gen(request $request)
    {

        Tariff::where('id', $request->tariff)->update(['user_id' => $request->user_id, 'type' => "gen"]);
        return back()->with('message', "User Tariff has been updated");

    }


    public function detach_gen_tariff(request $request)
    {
        Tariff::where('id', $request->id)->update(['user_id' => null, 'type' => "gen"]);
        return back()->with('message', "Detach Tariff successful");

    }


    public function detach_nepa_tariff(request $request)
    {
        Tariff::where('id', $request->id)->update(['user_id' => null, 'type' => "nepa"]);
        return back()->with('message', "Detach Tariff successful");

    }



    public function update_tariffstate(request $request)
    {



        if($request->status == 2){

            $update1 =  TarrifState::where('estate_id', $request->estate_id)->where('status', 2)->update(['status' => 0]);

            if($update1 == 0){
               $update2 =  TarrifState::where('estate_id', $request->estate_id)->where('id', $request->id)->update(['status' => 2]);

               dd($update2, $update1, $request->estate_id, $request->id);

            }


            return back()->with('message', "Tariff state updated successful");

        }else{
            TarrifState::where('estate_id', $request->estate_id)->where('id', $request->id)->update(['status' => 2]);

            return back()->with('message', "Tariff state updated successful");

        }

    }






















}
