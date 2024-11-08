<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterToken extends Model
{
    use HasFactory;

    protected $casts = [
        'amount' => 'integer',
        'status' => 'integer'
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

}
