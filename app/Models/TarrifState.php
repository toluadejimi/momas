<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class TarrifState extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status', 'estate_id'  // Ensure estate_id is fillable
    ];

    protected $casts = [
        'amount' => 'double',
        'vat' => 'double',
    ];

    // If needed, you can override toAudit method here to ensure estate_id is logged as part of the audit
    public function customAudit()
    {
        return $this->audit()->create([
            'estate_id' => $this->estate_id, // custom field
        ]);
    }
}
