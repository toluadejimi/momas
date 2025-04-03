<?php

namespace App\Imports;

use App\Models\Meter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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



        if (Auth::user()->role == 3) {

            return new Meter([
                'meterNo'   => $row['meterno'],
                'MeterSIMNo'   => $row['metersimno'],
                'transid'   => $row['transid'],
                'accountno'   => $row['accountno'],
                'meterModel'    => $row['metermodel'],
                'AccountNo'        => $row['accountno'],
                'isDualTariff' => $row['isdualtariff'],
                'NewSGC'      => $row['sgc'],
                'OldSGC'         => $row['oldsgc'] ?? null,
                'NewSGCDual'      => $row['newsgcdual'] ?? null,
                'OldSGCDual'      => $row['oldsgcdual'] ?? null,
                'KRN1'         => $row['krn1'],
                'KRN2'     => $row['krn2'],
                'NeedKCT'  => $row['needkct'],
                'CreditTypeID'  => $row['credittypeid'],
                'NewTariffID'      => $row['newtariffindex'] ?? null,
                'OldTariffID'      => $row['oldtariffindex'] ?? null,
                'NewTariffDualID'          => $row['newtariffindexdual'] ?? null,
                'OldTariffDualID'          => $row['oldtariffindexdual'] ?? null,
                'estate_id'    =>  Auth::user()->estate_id,
            ]);


        }else{



            return new Meter([

                'meterNo'   => $row['meterno'],
                'MeterSIMNo'   => $row['metersimno'],
                'TransformerID'   => $row['transid'],
                'accountno'   => $row['accountno'],
                'meterModel'    => $row['metermodel'],
                'AccountNo'        => $row['accountno'],
                'isDualTariff' => $row['isdualtariff'],
                'NewSGC'      => $row['sgc'],
                'OldSGC'         => $row['oldsgc'] ?? null,
                'NewSGCDual'      => $row['newsgcdual'] ?? null,
                'OldSGCDual'      => $row['oldsgcdual'] ?? null,
                'KRN1'         => $row['krn1'],
                'KRN2'     => $row['krn2'],
                'NeedKCT'  => $row['needkct'],
                'CreditTypeID'  => $row['credittypeid'],
                'NewTariffID'      => $row['newtariffindex'] ?? null,
                'OldTariffID'      => $row['oldtariffindex'] ?? null,
                'NewTariffDualID'          => $row['newtariffindexdual'] ?? null,
                'OldTariffDualID'          => $row['oldtariffindexdual'] ?? null,
                'estate_id'   =>  $this->id,

            ]);

        }




    }
}
