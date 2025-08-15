<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transformer extends Model
{
    use HasFactory;

    protected $fillable = [

        'Estate_id',
        'Capacity',
        'MDMeterSN',
        'CTRatio',
        'Multiplier',
        'Location',
        'Title',
        'City',
        'State',




    ];



    public function meter()
    {
        return $this->belongsTo(Meter::class);
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
