<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Imports\MeterImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MeterImportController extends Controller
{


    public function import(Request $request)
    {


        if ($request->estate_id == null) {
            $id = Auth::user()->estate_id;
        } else {
            $id = $request->estate_id;
        }




        try {



             Excel::import(new MeterImport($id), $request->file('file'));

            return redirect()->back()->with('message', 'Meter imported successfully!');


        } catch (\Exception$th) {

            $errorMessage = $th->getMessage();


            return back()->with('error', $th->getMessage());

        }


    }


}
