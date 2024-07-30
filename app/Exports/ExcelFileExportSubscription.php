<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelFileExportSubscription implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct()
    {

    }
    public function collection()
    {

        $recordset=DB::Table('subscriptions')
            ->select('subscriptions.*','registration.com_name','plans.plan_name')
            ->join('registration', 'registration.reg', '=', 'subscriptions.emid', 'inner')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id', 'inner')
            ->get();

        $f = 1;
        foreach ($recordset as $record) {
            if (!empty($record->start_date) && $record->start_date != '0000-00-00') {
                $start_date = date('d/m/Y', strtotime($record->start_date));
            } else {
                $start_date = '';
            }

            if (!empty($record->expiry_date) && $record->expiry_date != '0000-00-00') {
                $expiry_date = date('d/m/Y', strtotime($record->expiry_date));
            } else {
                $expiry_date = '';
            }

            $collection_array[] = array(
                'Sl No' => $f,
                'Organisation Name' => $record->com_name,
                'Plan Name' => $record->plan_name, 
                'Start Date' => $start_date, 
                'Expiry Date' => $expiry_date, 
                'Status' => ucwords($record->status), 
                );

            $f++;
        }
        return collect($collection_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 
            'Organisation Name', 
            'Plan Name', 
            'Start Date', 
            'Expiry Date', 
            'Status', 
        ];
    }
}$f = 1;
