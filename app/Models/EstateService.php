<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateService extends Model
{
    use HasFactory;


    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    protected $casts = [
        'status' => 'integer'
    ];


}
