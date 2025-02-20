<?php

namespace App\Exports;

use App\Models\CreditToken;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MeterTransactionExport implements FromCollection, WithHeadings
{



    protected $meterNo;
    public function __construct($meterNo)
    {
        $this->meterNo = $meterNo;
    }


    public function collection()
    {
        return CreditToken::where('meterNo', $this->meterNo)->where('status', 2)
        ->get()
            ->map(function ($token) {
                return [
                    'trx_id' => $token->trx_id,
                    'meter_no' => $token->meterNo ?? 'N/A',
                    'customer' => $token->user->first_name." ".$token->user->last_name ?? 'N/A',
                    'estate' => $token->estate->title ?? 'N/A',
                    'amount' => $token->amount,
                    'status' => $token->status,
                    'date' => $token->created_at->toFormattedDateString(), // Format the date if needed
                ];
            });

    }

    /**
     * Return the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Transaction ID',
            'Meter No',
            'Customer',
            'Estate',
            'Amount',
            'Status',
            'Date',
        ];
    }
}
