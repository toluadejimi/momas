<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'flutterwave_secret',
        'flutterwave_public',
        'paystack_secret',
        'paystack_public',
        'payment_support',
        'meter_support',
        'general_support',

    ];

    protected $casts = [
        'transfer_charge' => 'string',
        'hour' => 'integer',
    ];
}
