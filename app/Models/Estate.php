<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use HasFactory;

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }


    public function transformer()
    {
        return $this->hasMany(Transformer::class);
    }
}
