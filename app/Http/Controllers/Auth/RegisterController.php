<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function check_user (request $request)
    {
        $usr = User::where('email', $request->email)->first() ?? null;
        if($usr == null){



        }



    }
    public function register (request $request)
    {



        $usr = User::where('meterNo', $request->meterNo)->first() ?? null;
        if($usr == null){


        }




    }
}
