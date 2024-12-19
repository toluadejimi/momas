<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosLog extends Model
{
    use HasFactory;

    protected $casts = [
        'accountBalance' => 'string',
        'amount' => 'string',
        'log_status' => 'string',
        'status' => 'integer',
    ];

    protected $fillable = [

        'token',
        'vending_amount',
        'vat_amount',
        'vend_amount_kw_per_naira',
        'meter_no',
        'status',
        'address',
        'name',
        'merchant_id',

    ];



}
