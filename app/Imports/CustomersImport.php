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


        try{



            if (auth::user()->role == 3) {
                return new User([
                    'first_name'   => $row['firstname'],
                    'last_name'    => $row['lastname'],
                    'email'        => $row['email'],
                    'address'      => $row['address'],
                    'state'        => $row['state'],
                    'phone'        => "+234".$row['phone'],
                    'account_no'   => $row['accountno'],
                    'tariffid'     => $row['tariffid'],
                    'role'         => 2,
                    'password'     => bcrypt('123456'),
                    'meterNo'     => $row['meterno'],
                    'estate_name'  => auth::user()->estate_name,
                    'estate_id'    => auth::user()->estate_id,
                    'status' => 2
                ]);



            } else {
                return new User([

                    'first_name' => $row['firstname'],
                    'last_name' => $row['lastname'],
                    'email' => $row['email'],
                    'meterNo' => $row['meterno'],
                    'meterType' => $row['metertype'],
                    'address' => $row['address'],
                    'city' => $row['city'],
                    'lga' => $row['lga'],
                    'state' => $row['state'],
                    'estate_name' => $row['estatename'],
                    'estate_id' => $row['estateid'],
                    'phone' => "+234".$row['phone'],
                    'role' => 3,
                    "paswword" => bcrypt('123456')



                ]);

            }

        }catch (\Exception $e) {
            $message = $e->getMessage();
            send_notification($message);
        }



    }
}
