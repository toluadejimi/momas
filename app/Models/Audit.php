<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Audit extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
