<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utitlity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'duration',
        'estate_id'
    ];
}
