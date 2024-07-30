<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class EmployeeBulkDataTableExport implements FromQuery, WithHeadings
{

    protected $selectedDepartments;
    protected $selectedGrades;
    protected $selectedDesignations;

    public function __construct($selectedDepartments, $selectedGrades, $selectedDesignations)
    {
        $this->selectedDepartments = $selectedDepartments;
        $this->selectedGrades = $selectedGrades;
        $this->selectedDesignations = $selectedDesignations;
    }

        public function setSelectedDepartments($selectedDepartments)
    {
        $this->selectedDepartments = $selectedDepartments;
    }

    public function setSelectedGrades($selectedGrades)
    {
        $this->selectedGrades = $selectedGrades;
    }

    public function setSelectedDesignations($selectedDesignations)
    {
        $this->selectedDesignations = $selectedDesignations;
    }



    public function query()
    {
        $query= DB::table('employee_bulk_data')
            ->select(
                'id', 'si_no', 'employee_id', 'employee_code', 'employee_name',
                'father_name', 'department', 'designation', 'dob', 'doj',
                'emp_status', 'status', 'address', 'city', 'state', 'country',
                'pincode', 'mobile_no', 'class', 'pf_no', 'uan_no', 'pan_no',
                'bank', 'ifsc_code', 'account_no'
            )
            ->orderBy('id');

            // Filter the query based on selected departments
        if (!empty($this->selectedDepartments)) {
            $query->whereIn('department', $this->selectedDepartments);
        }

        // Filter the query based on selected grades
        if (!empty($this->selectedGrades)) {
            $query->whereIn('class', $this->selectedGrades);
        }

        // Filter the query based on selected designations
        if (!empty($this->selectedDesignations)) {
            $query->whereIn('designation', $this->selectedDesignations);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID', 'SI No', 'Employee ID', 'Employee Code', 'Employee Name',
            'Father Name', 'Department', 'Designation', 'DOB', 'DOJ',
            'Employee Status', 'Status', 'Address', 'City', 'State', 'Country',
            'Pincode', 'Mobile No', 'Class', 'PF No', 'UAN No', 'PAN No',
            'Bank', 'IFSC Code', 'Account No'
        ];
    }
}
