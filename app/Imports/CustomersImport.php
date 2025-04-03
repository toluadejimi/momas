<?php

namespace App\Imports;

use App\Models\Estate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Http\Request;


class CustomersImport implements ToModel, WithHeadingRow

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
                return new User([
                    'first_name'   => $row['firstname'],
                    'last_name'    => $row['lastname'],
                    'email'        => $row['email'],
                    'address'      => $row['address'],
                    'state'        => $row['state'],
                    'phone'        => "+234".$row['phone'],
                    'account_no'   => $row['accountno'],
                    'role'         => 2,
                    'password'     => bcrypt('123456'),
                    'meterNo'     => $row['meterno'],
                    'estate_name'  => Auth::user()->estate_name,
                    'estate_id'    => Auth::user()->estate_id,
                    'status' => 2
                ]);



            } else {


                $estate_name = Estate::where('id', $this->id)->first()->title;
                return new User([

                    'first_name'   => $row['firstname'],
                    'last_name'    => $row['lastname'],
                    'email'        => $row['email'],
                    'address'      => $row['address'],
                    'state'        => $row['state'],
                    'phone'        => "+234".$row['phone'],
                    'account_no'   => $row['accountno'],
                    'role'         => 2,
                    'password'     => bcrypt('123456'),
                    'meterNo'     =>  $row['meterno'],
                    'estate_name'  => $estate_name,
                    'estate_id'    => $this->id,
                    'status' => 2


                ]);

            }



    }
}
