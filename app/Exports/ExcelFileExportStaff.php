<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelFileExportStaff implements FromCollection, WithHeadings, WithEvents
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($reg)
    {

        $this->reg = $reg;
    }
    public function collection()
    {

        $leave_allocation_rs = DB::table('employee')
            ->join('users', 'employee.emp_code', '=', 'users.employee_id')
            ->where('employee.emid', '=', $this->reg)
            ->where('users.emid', '=', $this->reg)
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->get();

        $h = 1;
        foreach ($leave_allocation_rs as $employee) {
            $add = '';
            $add = $employee->emp_pr_street_no;
            if ($employee->emp_per_village) {

                $add .= ',' . $employee->emp_per_village;
            }
            if ($employee->emp_pr_state) {

                $add .= ',' . $employee->emp_pr_state;
            }
            if ($employee->emp_pr_city) {

                $add .= ',' . $employee->emp_pr_city;
            }
            if ($employee->emp_pr_pincode) {

                $add .= ',' . $employee->emp_pr_pincode;
            }
            if ($employee->emp_pr_country) {

                $add .= ',' . $employee->emp_pr_country;
            }

            $dob = '';
            if ($employee->emp_dob != '1970-01-01') {
                if ($employee->emp_dob != 'null') {
                    $dob = date('d/m/Y', strtotime($employee->emp_dob));
                }
            } else if ($employee->emp_dob == '1970-01-01') {
                $dob = '';
            } else if ($employee->emp_dob != 'null') {
                $dob = date('d/m/Y', strtotime($employee->emp_dob));
            } else if ($employee->emp_dob == 'null') {
                $dob = '';
            }
            $doj = '';
            if ($employee->emp_doj != '1970-01-01') {
                if ($employee->emp_doj != 'null') {
                    $doj = date('d/m/Y', strtotime($employee->emp_doj));
                }
            } else if ($employee->emp_doj == '1970-01-01') {
                $doj = '';
            } else if ($employee->emp_doj != 'null') {
                $doj = date('d/m/Y', strtotime($employee->emp_doj));
            } else if ($employee->emp_doj == 'null') {
                $doj = '';
            }

            $visa_exp = '';
            if ($employee->visa_exp_date != '1970-01-01') {
                if ($employee->visa_exp_date != 'null') {
                    $visa_exp = date('jS F Y', strtotime($employee->visa_exp_date));
                }
            } else {
                $visa_exp = 'NA';
            }
            $pass_no = '';
            if ($employee->pass_exp_date != '1970-01-01') {
                if ($employee->pass_exp_date != 'null') {
                    $pass_no = '  EXPIRE:' . date('jS F Y', strtotime($employee->pass_exp_date));
                }
            }

            $euss_exp = '';
            if ($employee->euss_exp_date != '1970-01-01') {
                if ($employee->euss_exp_date != 'null' && $employee->euss_exp_date != NULL) {
                    $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->euss_exp_date));
                }
            }
            $dbs_exp = '';
            if ($employee->dbs_exp_date != '1970-01-01') {
                if ($employee->dbs_exp_date != 'null' && $employee->dbs_exp_date != NULL) {
                    $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->dbs_exp_date));
                }
            }
            $nid_exp = '';
            if ($employee->nat_exp_date != '1970-01-01') {
                if ($employee->nat_exp_date != 'null') {
                    $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->nat_exp_date));
                }
            }

            $customer_array[] = array(
                'Sl No' => $h,
                'Staff Code' => $employee->emp_code,
                'Staff Name' => $employee->emp_fname . " " . $employee->emp_mname . " " . $employee->emp_lname,
                'Job  Title' => $employee->emp_designation,
                'Address' => $add,
                'DOB' => $dob,
                'Job Start Date' => $doj,
                'Telephone' => $employee->emp_ps_phone,
                'Nationality' => $employee->nationality,
                'NI Number' => $employee->ni_no,

                'Visa Expiry Date' => $visa_exp,
                'Passport No' => $employee->pass_doc_no . $pass_no,
                'EUSS Details' => $employee->euss_ref_no . $euss_exp,
                'DBS Details' => $employee->dbs_ref_no . $dbs_exp,
                'National Id Details' => $employee->nat_id_no . $nid_exp,
    
            );
            $h++;
        }
        return collect($customer_array);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:L1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFA500');
            },

        ];
    }    

    public function headings(): array
    {
        return [
            'Sl No',
            'Staff Code',
            'Staff Name',
            'Job  Title',
            'Address',
            'DOB',
            'Job Start Date',
            'Telephone',
            'Nationality',
            'NI Number',
            'Visa Expiry Date',
            'Passport No',
            'EUSS Details',
            'DBS Details',
            'National Id Details',
        ];
    }
}
