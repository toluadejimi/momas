<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }


}
