<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelFileExportCosRequest implements FromCollection, WithHeadings
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($start_date, $end_date, $employee_id)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->employee_id = $employee_id;

    }
    public function collection()
    {

        if ($this->start_date == 'all' && $this->end_date == 'all' && $this->employee_id == 'all') {

            $cos_requesrt_rs = DB::Table('cos_apply_emp')
            //->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id')
                ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
            // ->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
            // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

            // ->where('cos_apply_emp.status', '=', 'Request')

                ->orderBy('cos_apply_emp.id', 'desc')

                ->get();
        }
        if ($this->start_date == 'all' && $this->end_date == 'all' && $this->employee_id != 'all') {
            $cos_requesrt_rs =
            DB::Table('cos_apply_emp')
            //->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id')
                ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
            //->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
            // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

            // ->where('tareq_app.ref_id', '=', $this->employee_id)
                ->where('cos_apply.employee_id', '=', $this->employee_id)
            //->where('cos_apply_emp.status', '=', 'Request')
                ->orderBy('cos_apply_emp.id', 'desc')

                ->get();

        }

        if ($this->start_date != 'all' && $this->end_date != 'all' && $this->employee_id == 'all') {

            $cos_requesrt_rs = DB::Table('cos_apply_emp')
            //->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id')
                ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
            //->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
            // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

                ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
            //->where('cos_apply_emp.status', '=', 'Request')
                ->orderBy('cos_apply_emp.id', 'desc')

                ->get();
        }

        if ($this->start_date != 'all' && $this->end_date != 'all' && $this->employee_id != 'all') {

            $cos_requesrt_rs = DB::Table('cos_apply_emp')
            // ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id', 'employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname')
                ->select('cos_apply_emp.*', 'cos_apply.id as cosid', 'cos_apply.employee_id')
                ->join('cos_apply', 'cos_apply.id', '=', 'cos_apply_emp.com_cos_apply_id', 'inner')
            //->join('employee', 'employee.id', '=', 'cos_apply_emp.com_employee_id', 'left')
            // ->join('tareq_app', 'cos_apply.emid', '=', 'tareq_app.emid')

                ->whereBetween('cos_apply_emp.update_new_ct', [$this->start_date, $this->end_date])
            //->where('cos_apply_emp.status', '=', 'Request')
            //->where('tareq_app.ref_id', '=', $this->employee_id)
                ->where('cos_apply.employee_id', '=', $this->employee_id)
                ->orderBy('cos_apply_emp.id', 'desc')
                ->get();
        }

        $f = 1;
        foreach ($cos_requesrt_rs as $company) {
            $pass = DB::Table('registration')

                ->where('reg', '=', $company->emid)

                ->first();
            $passname = DB::Table('users_admin_emp')

                ->where('employee_id', '=', $company->employee_id)

                ->first();

            if (!empty($company->applied_cos_date) && $company->applied_cos_date != '0000-00-00') {

                $applied_cos_date = date('d/m/Y', strtotime($company->applied_cos_date));

            } else {

                $applied_cos_date = '';

            }

            if (!empty($company->additional_info_request_date) && $company->additional_info_request_date != '0000-00-00') {

                $additional_info_request_date = date('d/m/Y', strtotime($company->additional_info_request_date));

            } else {

                $additional_info_request_date = '';

            }

            if (!empty($company->additional_info_sent_date) && $company->additional_info_sent_date != '0000-00-00') {

                $additional_info_sent_date = date('d/m/Y', strtotime($company->additional_info_sent_date));

            } else {

                $additional_info_sent_date = '';

            }

            if (!empty($company->cos_assigned_date) && $company->cos_assigned_date != '0000-00-00') {

                $cos_assigned_date = date('d/m/Y', strtotime($company->cos_assigned_date));

            } else {

                $cos_assigned_date = '';

            }

            $customer_array[] = array(
                'Sl No' => $f,
                'Organisation Name' => $pass->com_name,
                'Organisation Employee Name' => $company->employee_name,
                'WPC Employee' => $passname->name,
                'Applied for Cos-Date' => $applied_cos_date,
                'Reply from HO-date' => $additional_info_request_date,
                'Additional information sent - date' => $additional_info_sent_date,
                'Status' => ($company->status == '') ? 'Pending' : $company->status,
                'CoS assigned date' => $cos_assigned_date,
                'Remarks' => $company->remarks_cos,
            );

            $f++;
        }
        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No', 'Organisation Name', 'Organisation Employee Name', 'WPC Employee', 'Applied for Cos-Date', 'Reply from HO-date', 'Additional information sent - date', 'Status', 'CoS assigned date', 'Remarks',
        ];
    }
}$f = 1;
