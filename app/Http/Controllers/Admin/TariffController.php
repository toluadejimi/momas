<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\MeterToken;
use App\Models\Tariff;
use App\Models\Token;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TariffController extends Controller
{


    public function tariff_list(request $request)
    {


        if(auth::user()->role == 0){

            $data['tariff_list'] = Tariff::paginate(20);
            $data['tariffis'] = Tariff::all();
            $data['tarifftariffis'] = Tariff::count();

            return view('admin/tariff/index', $data);



        } elseif(auth::user()->role == 1){

        } elseif(auth::user()->role == 2){

        } elseif(auth::user()->role == 3){

            $data['tariff_list'] = Tariff::where('estate_id', auth::user()->estate_id)->get();
            $data['tariffis'] = Tariff::latest()->where('estate_id', auth::user()->estate_id)->get();
            $data['tarifftariffis'] = Tariff::where('estate_id', auth::user()->estate_id)->count();

            return view('admin/tariff/index', $data);


        } elseif(auth::user()->role == 4){

        } elseif(auth::user()->role == 5){

        } else{

        }




    }


    public function new_tariff(request $request)
    {

        return view('admin.tariff.new-tariff');

    }

    public function add_new_Tariff(request $request)
    {

        $ck = Tariff::where('title', $request->title)->first() ?? null;


        if($ck != null){
            return back()->with('error', 'Tariff already exist');
        }


        $tr = new Tariff();
        $tr->title = $request->title;
        $tr->estate_tariff_cost = $request->estate_tariff_cost;
        $tr->estate_id = $request->estate_id;
        $tr->status = 2;
        $tr->save();

        return redirect('admin/tariff-list')->with('message', 'Tariff created successfully');


    }

    public function delete_tariff(request $request)
    {

        Tariff::where('id', $request->id)->delete();
        return back()->with('messsage', 'Tariff deleted successfully');

    }













}
