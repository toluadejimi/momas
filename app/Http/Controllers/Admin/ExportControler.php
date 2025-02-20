<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MeterTransactionExport;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportControler extends Controller
{
    public function exportmetertransactions(request $request)
    {
        $meterNo = $request->meterNo;
        $excelFile = Excel::raw(new MeterTransactionExport($meterNo), \Maatwebsite\Excel\Excel::XLSX);

        return response($excelFile)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="metertransactions.xlsx"');

    }
}
