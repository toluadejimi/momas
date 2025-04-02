<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilitiesPayment extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'amount', 'duration', 'next_due_date', 'estate_id', 'total_amount'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

}
