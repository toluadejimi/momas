<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarrifState extends Model
{
    use HasFactory;

    protected $casts = [
        'amount' => 'double',
        'vat' => 'double',

    ];
}
