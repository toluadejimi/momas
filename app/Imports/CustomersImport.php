<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class CustomersImport implements ToModel, WithHeadingRow

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (auth::user()->role == 3) {


            return new User([
                'first_name'   => $row['firstname'],
                'last_name'    => $row['lastname'],
                'email'        => $row['email'],
                'meterNo'      => $row['meterno'],
                'meterType'    => $row['metertype'],
                'address'      => $row['address'],
                'city'         => $row['city'],
                'lga'          => $row['lga'],
                'state'        => $row['state'],
                'phone'        => $row['phone'],
                'role'         => 2,
                'password'     => bcrypt('123456'),
                'estate_name'  => auth::user()->estate_name,
                'estate_id'    => auth::user()->estate_id,
                'status' => 2
            ]);

        } else {
            return new User([


                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'meterNo' => $row['meterNo'],
                'meterType' => $row['meterType'],
                'address' => $row['address'],
                'city' => $row['city'],
                'lga' => $row['lga'],
                'state' => $row['state'],
                'estate_name' => $row['estate_name'],
                'estate_id' => $row['estate_id'],
                'phone' => $row['phone'],
                'role' => 3,
                "paswword" => bcrypt('123456')

            ]);
        }


    }
}
