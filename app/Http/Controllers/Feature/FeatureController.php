<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    

    public function features(){

        $feature =  Feature::where('id', 1)->first()->makeHidden(['created_at', 'updated_at']);

        return response()->json([

            'status' => true,
            'feature' => $feature

        ]);

    }
}
