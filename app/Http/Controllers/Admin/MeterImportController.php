<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Imports\MeterImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MeterImportController extends Controller
{
    public function import(Request $request)
    {

//        $request->validate([
//            'file' => 'required|mimes:csv,xlsx,xls',
//        ]);

        Excel::import(new MeterImport, $request->file('file'));

        return redirect()->back()->with('success', 'Meter imported successfully!');
    }
}
