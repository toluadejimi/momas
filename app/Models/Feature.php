<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'momas_meter',
        'other_meter',
        'print_token',
        'access_token',
        'services',
        'bill_payment',
        'support',
        'analysis',

    ];


    protected $casts = [

    "id" => 'integer',
    "pos" => 'integer',
    "soft_pos" => 'integer',
    "bank_transfer"=> 'integer',
    "bills"=> 'integer',
    "data"=> 'integer',
    "airtime"=> 'integer',
    "insurance"=> 'integer',
    "education"=> 'integer',
    "power"=> 'integer',
    "exchange"=> 'integer',
    "ticket"=> 'integer',
    "v_card"=> 'integer',
    "pos_transfer"=> 'integer',
    "api_service"=> 'integer',

    ];
}
