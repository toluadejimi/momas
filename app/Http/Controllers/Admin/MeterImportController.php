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


//        $request->validate([
//            'file' => 'required|mimes:csv,xlsx,xls',
//        ]);

        try {
            \Log::info('Import process started.');

             Excel::import(new MeterImport($id), $request->file('file'));

            \Log::info('Import process finished.');

            return redirect()->back()->with('success', 'Meter imported successfully!');


        } catch (\Exception$th) {

            $errorMessage = $th->getMessage();

            if (str_contains($errorMessage, 'Duplicate entry')) {
                preg_match("/Duplicate entry '([^']+)'/", $errorMessage, $matches);
                return back()->with('error', 'Duplicate entry found');

            }
        }
    }


}
