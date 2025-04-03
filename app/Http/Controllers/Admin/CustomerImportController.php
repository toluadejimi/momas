<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class CustomerImportController extends Controller
{
    public function import(Request $request)
    {


        if($request->estate_id == null){
            $id = Auth::user()->estate_id;
        }else{
            $id = $request->estate_id;
        }



        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls'
        ]);



        try {
            Excel::import(new CustomersImport($id), $request->file('file'));

            return back()->with('message', 'Users imported successfully!');

        } catch (\Exception$th) {

            $errorMessage = $th->getMessage();
            return back()->with('error', $th->getMessage());


        }

    }
}
