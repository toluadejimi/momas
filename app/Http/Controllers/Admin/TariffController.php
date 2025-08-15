<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auditlog;
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


        if(Auth::user()->role == 0){

            $data['tariff_list'] = Tariff::latest()->paginate(20);
            $data['tariffis'] = Tariff::all();
            $data['tarifftariffis'] = Tariff::count();
            $data['estate'] = Estate::all();



            return view('admin/tariff/index', $data);



        } elseif(Auth::user()->role == 1){

        } elseif(Auth::user()->role == 2){

        } elseif(Auth::user()->role == 3){

            $data['tariff_list'] = Tariff::latest()->where('estate_id', Auth::user()->estate_id)->get();
            $data['tariffis'] = Tariff::latest()->latest()->where('estate_id', Auth::user()->estate_id)->get();
            $data['tarifftariffis'] = Tariff::where('estate_id', Auth::user()->estate_id)->count();
            $data['estate']  = Estate::all();

            return view('admin/tariff/index', $data);


        } elseif(Auth::user()->role == 4){

        } elseif(Auth::user()->role == 5){

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

        $chk_active = TarrifState::where('tariff_id', $request->id)->where('status', 2)->count();
        if($chk_active > 1){
            TarrifState::where('tariff_id',$request->id)->update(['status' => 0]);
            TarrifState::where('tariff_id',$request->id)->first()->update(['status' => 2]);

        }


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
            $tr->t_index = $request->t_index;
            $tr->estate_id = $request->estate_id;
            $tr->vat = $request->vat;
            $tr->tariff_id = $request->tariff_id;
            $tr->save();



            $ck_count = TarrifState::where('tariff_id', $request->tariff_id)->count();
            if($ck_count == 1){
                TarrifState::latest()->where('status', 0)->where('tariff_id', $request->tariff_id)->update(['status' => 2]);
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
        $tr->t_index = $request->t_index;
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
            ]);


        }else{

            Tariff::where('id', $request->id)->update([
                'title' => $request->title,
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


        $ttf = TarrifState::find($request->id);
        if ($ttf) {
            $ttf->status = $request->status;
            $ttf->amount = $request->amount;
            $ttf->estate_id = $ttf->estate_id;
            $ttf->t_index = $request->t_index;
            $ttf->save();
        }


        return back()->with('message', "Tariff state updated successful");




    }






















}
