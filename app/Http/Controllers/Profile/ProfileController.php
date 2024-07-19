<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    

    public function balance(request $request){

        $user = user();
        $unit = 944663746655;


        return response()->json([

            'status' => true,
            'main_wallet' => $user->main_wallet,
            'unit' => $unit

        ], 200);


    }

}
