<?php

namespace App\Http\Controllers\Transformer;

use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\Meter;
use App\Models\Tariff;
use App\Models\Transformer;
use App\Models\User;
use Illuminate\Http\Request;

class TransformerController extends Controller
{
    public function list_transformer()
    {

        $data['transformer_list'] = Transformer::latest()->where('status', 2)->paginate(20);
        $data['transformer'] = Transformer::latest()->where('status', 2)->count();
        return view('admin/transformer/transformer-list', $data);


    }


    public function new_transformer()
    {
        $data['estate'] = Estate::where('status', 2)->get();

        return view('admin/transformer/new-transformer', $data);
    }


    public function add_new_transformer(request $request)
    {

        $trs = Transformer::create($request->all());
        $est = Estate::where('id', $request->Estate_id)->first()->title;
        Transformer::where('id', $trs->id)->update(['estate'=>$est]);
        return redirect('admin/transformer-list')->with('message', "Transformer added successfully");

    }

    public function update_transformer(request $request)
    {

        $trs = Transformer::find($request->id);
        $est = Estate::where('id', $request->Estate_id)->first()->title;
        Transformer::where('id', $trs->id)->update(['estate'=>$est]);
        if($request->Multiplier != "on"){
            Transformer::where('id', $trs->id)->update(['Multiplier'=>"off"]);
        }
        $trs->update($request->all());



        return redirect('admin/transformer-list')->with('message', "Transformer updated successfully");

    }

    public function delete_transformer(request $request)
    {


        Transformer::where('id', $request->id)->delete();

        return redirect('admin/transformer-list')->with('message', "Transformer deleted successfully");

    }







    public function view_transformer(request $request)
    {
        $data['trans'] = Transformer::where('id', $request->id)->first();
        $data['estate'] = Estate::where('status', 2)->get();

        return view('admin/transformer/transformer-view', $data);

    }
}