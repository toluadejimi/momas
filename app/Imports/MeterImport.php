<?php

namespace App\Imports;

use App\Models\Meter;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MeterImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Meter([

            'meterNo'   => $row['meterno'],
            'meterModel'    => $row['metermodel'],
            'AccountNo'        => $row['accountno'],
            'estate_id'    => auth::user()->estate_id,
            'TransformerID' =>  $row['transformerid'],
            'isDualTariff' => $row['isdualtariff'],
            'NewSGC'      => $row['newsgc'],
            'OldSGC'         => $row['oldsgc'],
            'NewSGCDual'      => $row['newsgcdual'],
            'OldSGCDual'      => $row['oldsgcdual'],
            'NewTariffDual'          => $row['newtariffdual'],
            'OldTariffDual'          => $row['oldtariffdual'],
            'KRN1'         => $row['krn1'],
            'KRN2'     => $row['krn2'],
            'NeedKCT'  => $row['needkct'],
            'CreditTypeID'  => $row['credittypeid'],
        ]);
    }
}
