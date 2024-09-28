<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class CircumstancesExport implements FromView
{
    protected $employee;
    protected $changeHistory;

    public function __construct($employee, $changeHistory)
    {
        $this->employee = $employee;
        $this->changeHistory = $changeHistory;
    }

    public function view(): View
    {
        return view('employeer.sopnsor-compliance.exports-change-circumstances', [
            'employee' => $this->employee,
            'changeHistory' => $this->changeHistory
        ]);
    }
}
