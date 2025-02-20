<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditlogController extends Controller
{

    public function tariff_audit(request $request)
    {

        $tariff_logs = Audit::latest()->where('auditable_type', 'App\Models\TarrifState')->paginate(100);
        $total = Audit::latest()->where('auditable_type', 'App\Models\TarrifState')->count();
        return view('admin.audit.tariffaudit', compact('tariff_logs', 'total'));

    }
}
