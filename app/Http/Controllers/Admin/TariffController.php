<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use Illuminate\Http\Request;

class TariffController extends Controller
{


    public function tariff_list(request $request)
    {

        $data['tariff_list'] = Tariff::paginate(20);
        $data['tariffis'] = Tariff::count();

        return view('admin/tariff/index', $data);


    }




}
