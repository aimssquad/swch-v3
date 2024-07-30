<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelFileExportBillSearch implements FromCollection, WithHeadings
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($start_date, $end_date, $amount, $status)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->amount = $amount;
        $this->status = $status;
    }

    public function collection()
    {

        if ($this->start_date != '' && $this->end_date != '' && $this->amount == '' && $this->status == '') {
            $start_date = date('Y-m-d', strtotime($this->start_date));
            $end_date = date('Y-m-d', strtotime($this->end_date));
            $leave_allocation_rs = DB::table('billing')

                ->whereBetween('date', [$start_date, $end_date])
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        } else if ($this->start_date != '' && $this->end_date != '' && $this->amount != '' && $this->status == '') {
            $start_date = date('Y-m-d', strtotime($this->start_date));
            $end_date = date('Y-m-d', strtotime($this->end_date));
            $leave_allocation_rs = DB::table('billing')
                ->whereBetween('date', [$start_date, $end_date])

                ->where('amount', '=', $this->amount)
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        } else if ($this->start_date != '' && $this->end_date != '' && $this->amount == '' && $this->status != '') {
            $start_date = date('Y-m-d', strtotime($this->start_date));
            $end_date = date('Y-m-d', strtotime($this->end_date));
            $leave_allocation_rs = DB::table('billing')
                ->whereBetween('date', [$start_date, $end_date])

                ->where('status', '=', $this->status)
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        } else if ($this->start_date == '' && $this->end_date == '' && $this->amount != '' && $this->status != '') {

            $leave_allocation_rs = DB::table('billing')

                ->where('amount', '=', $this->amount)
                ->where('status', '=', $this->status)
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        } else if ($this->start_date == '' && $this->end_date == '' && $this->amount == '' && $this->status != '') {

            $leave_allocation_rs = DB::table('billing')

                ->where('status', '=', $this->status)
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        } else if ($this->start_date == '' && $this->end_date == '' && $this->amount != '' && $this->status == '') {

            $leave_allocation_rs = DB::table('billing')

                ->where('amount', '=', $this->amount)
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        } else if ($this->start_date == '' && $this->end_date == '' && $this->amount == '' && $this->status == '') {

            $leave_allocation_rs = DB::table('billing')
                ->select('billing.*')

                ->orderBy('date', 'desc')
                ->get();

        }if ($this->start_date != '' && $this->end_date != '' && $this->amount != '' && $this->status != '') {
            $start_date = date('Y-m-d', strtotime($this->start_date));
            $end_date = date('Y-m-d', strtotime($this->end_date));
            $leave_allocation_rs = DB::table('billing')
                ->whereBetween('date', [$start_date, $end_date])
                ->where('amount', '=', $this->amount)
                ->where('status', '=', $this->status)
                ->select('billing.*')
                ->orderBy('date', 'desc')
                ->get();

        }
//dd($companies_rs);
        $f = 1;

        $totam = 0;
        $topayre = 0;
        $totdue = 0;
        foreach ($leave_allocation_rs as $leave_allocation) {

            $pass = DB::Table('payment')

                ->where('in_id', '=', $leave_allocation->in_id)
                ->select(DB::raw('sum(re_amount) as amount'))
                ->first();
            $passreg = DB::Table('registration')

                ->where('reg', '=', $leave_allocation->emid)

                ->first();
            if ($passreg->licence == 'yes') {
                $ffl = 'Granted';
            } else {
                $ffl = 'NOT Granted';
            }
            if (!empty($pass->amount)) {

                $due = $pass->amount;
            } else {
                $due = '0';
            }

            $totam = $totam + $leave_allocation->amount;
            $topayre = $topayre + $due;

            $totdue = $totdue + $leave_allocation->due;
            $pabillsts = DB::Table('hr_apply')

                ->where('licence', '=', 'Granted')
                ->where('emid', '=', $leave_allocation->emid)
                ->first();
            if (!empty($pabillsts)) {
                $ffd = 'Granted';
            } else {
                $ffd = 'Not Granted';
            }

            $customer_array[] = array(
                'Sl No' => $f,
                'Invoice Number' => $leave_allocation->in_id,
                'Bill  To' => $passreg->com_name,
                'Bill Amount' => $leave_allocation->amount,
                'Payment Received' => $due,
                'Due Amount' => $leave_allocation->due,
                'Status' => strtoupper($leave_allocation->status),
                'Bill Date' => date('d/m/Y', strtotime($leave_allocation->date)),
                'License Applied' => $ffd,

            );

            $f++;
        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Invoice Number',
            'Bill  To',
            'Bill Amount',
            'Payment Received',
            'Due Amount',
            'Status',
            'Bill Date',
            'License Applied',
        ];
    }
}$f = 1;
