<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transformer;
use Illuminate\Http\Request;

class TransformerController extends Controller
{
    public function list_transformer()
    {

        $data['transformer_list'] = Transformer::latest()->where('status', 2)->paginate(20);
        $data['transformer'] = Transformer::latest()->where('status', 2)->count();
        return view('admin/transformer/transformer-list', $data);


    }
}
