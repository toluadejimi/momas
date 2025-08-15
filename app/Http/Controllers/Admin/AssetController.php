<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Estate;
use App\Models\Organization;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function asset_index(request $request)
    {
        $data['asset_list'] = Asset::paginate(20);
        $data['asset_count'] = Asset::select('title', \DB::raw('count(*) as count'))
            ->groupBy('title')
            ->get();
        $data['asset'] = Asset::where('status', 2)->count();


        return view('admin/asset/index', $data)->with('message', "Features updated successfully");

    }


    public function asset_new(request $request)
    {
        $data['org'] = Organization::where('status', 2)->get();
        $data['estate'] = Estate::where('status', 2)->get();

        return view('admin/asset/create', $data);
    }


    public function asset_store(request $request)
    {

        $org = new asset();
        $org->title = $request->title;
        $org->organization_id = $request->organization_id;
        $org->estate_id = $request->estate_id;
        $org->status = 2;
        $org->save();

        return redirect('admin/asset')->with('message','Asset created successfully');
    }


    public function asset_view(request $request)
    {

        $data['asset'] = Asset::where('id', $request->id)->first();
        $data['org'] = Organization::where('id', $request->org_id)->first();
        $data['orgs'] = Organization::where('status', 2)->get();


        $data['estate'] = Estate::where('id', $request->est_id)->first();
        $data['estates'] = Estate::where('status', 2)->get();


        return view('admin/asset/view', $data);
    }

    public function asset_update(request $request)
    {
        Asset::where('id', $request->id)->update([
            'title' => $request->title

        ]);
        return redirect('admin/asset')->with('asset updated successfully');
    }

    public function asset_delete(request $request)
    {
        Asset::where('id', $request->id)->delete();
        return redirect('admin/asset')->with('asset deleted successfully');
    }
}
