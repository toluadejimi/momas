<?php

namespace App\Http\Controllers\AccessToken;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessTokenConroller extends Controller
{
    public function index(request $request)
    {

        if(auth::user()->role == 0){

            $data['token'] = Token::latest()->paginate(20);
            $data['token_count'] = Token::count();
            $data['token_active'] = Token::where('status', 0)->count();
            $data['token_inactive'] = Token::where('status', 0)->count();


            return view('admin.estatetoken.token_view', $data);


        } elseif(auth::user()->role == 1){

        } elseif(auth::user()->role == 2){

        } elseif(auth::user()->role == 3){

            $data['token'] = Token::latest()->where('estate_id', auth::user()->estate_id)->paginate(20);
            $data['token_count'] = Token::where('estate_id', auth::user()->estate_id)->count();
            return view('admin.estatetoken.token_view', $data);


        } elseif(auth::user()->role == 4){

        } elseif(auth::user()->role == 5){

        }
    }


    public function delete_token(request $request)
    {
         Token::where('id', $request->id)->delete();

         return back()->with('message', 'token has been deleted successfully');

    }

    public function activate_token(request $request)
    {
        Token::where('id', $request->id)->update([
            'status' => 2,
        ]);

        return back()->with('message', 'token has been updated successfully');

    }

    public function deactivate_token(request $request)
    {
        Token::where('id', $request->id)->update([
            'status' => 0,
        ]);

        return back()->with('message', 'token has been updated successfully');

    }
}
