<?php

namespace App\Imports;

use App\Models\Meter;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MeterImport implements ToModel, WithHeadingRow
{

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }



    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (auth::user()->role == 3) {

            return new Meter([
                'meterNo'   => $row['meterno'],
                'MeterSIMNo'   => $row['metersimno'],
                'transid'   => $row['transid'],
                'accountno'   => $row['accountno'],
                'isamr'   => $row['isamr'],
                'meterModel'    => $row['model'],
                'AccountNo'        => $row['accountno'],
                'estate_id'    =>  Auth::user()->estate_id,
                'isDualTariff' => $row['isdualtariff'],
                'NewSGC'      => $row['sgc'],
                'OldSGC'         => $row['oldsgc'] ?? null,
                'NewSGCDual'      => $row['newsgcdual'] ?? null,
                'OldSGCDual'      => $row['oldsgcdual'] ?? null,
                'NewTariffDual'          => $row['newtariffdual'] ?? null,
                'OldTariffDual'          => $row['oldtariffdual'] ?? null,
                'KRN1'         => $row['krn1'],
                'KRN2'     => $row['krn2'],
                'NeedKCT'  => $row['needkct'],
                'CreditTypeID'  => $row['credittypeid'],
            ]);


        }else{


            return new Meter([

                'meterNo'   => $row['meterno'],
                'MeterSIMNo'   => $row['metersimno'],
                'transid'   => $row['transid'],
                'accountno'   => $row['accountno'],
                'isamr'   => $row['isamr'],
                'meterModel'    => $row['model'],
                'AccountNo'        => $row['accountno'],
                'estate_id'    =>  $this->id,
                'isDualTariff' => $row['isdualtariff'],
                'NewSGC'      => $row['sgc'],
                'OldSGC'         => $row['oldsgc'] ?? null,
                'NewSGCDual'      => $row['newsgcdual'] ?? null,
                'OldSGCDual'      => $row['oldsgcdual'] ?? null,
                'NewTariffDual'          => $row['newtariffdual'] ?? null,
                'OldTariffDual'          => $row['oldtariffdual'] ?? null,
                'KRN1'         => $row['krn1'],
                'KRN2'     => $row['krn2'],
                'NeedKCT'  => $row['needkct'],
                'CreditTypeID'  => $row['credittypeid'],
            ]);

        }


    }
}
