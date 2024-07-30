<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelFileExportCircumstances implements FromCollection, WithHeadings
{
    private $sd;
    private $ed;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($reg, $new_emp, $employee_type)
    {
        $this->employee_type = $employee_type;
        $this->new_emp = $new_emp;
        $this->reg = $reg;
    }
    public function collection()
    {

        $h = 1;
        $nn = '';
        $doj = '';
        $anual_date = '';
        $employeet = DB::table('employee')->where('emp_code', '=', $this->new_emp)
            ->where('emid', '=', $this->reg)->first();
        $date1 = date('Y', strtotime($employeet->emp_doj)) . date('m-d');
        $date2 = date('Y-m-d');

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365 * 60 * 60 * 24));
        date('Y', strtotime($date1));
        $endtyear = date('Y', strtotime($date1)) + ($years);

        for ($m = date('Y', strtotime($employeet->emp_doj)); $m <= $endtyear; $m++) {

            $strartye = date($m . '-01-01');
            $endtye = date($m . '-12-31');

            $leave_allocation_rsdg = DB::table('change_circumstances')
                ->join('employee', 'change_circumstances.emp_code', '=', 'employee.emp_code')
                ->where('change_circumstances.emp_code', '=', $employeet->emp_code)
                ->where('change_circumstances.emid', '=', $employeet->emid)
                ->where('employee.emp_code', '=', $employeet->emp_code)
                ->where('employee.emid', '=', $employeet->emid)
                ->where('employee.emp_status', '=', $employeet->emp_status)
                ->whereBetween('date_change', [$strartye, $endtye])
                ->select('change_circumstances.*')
                ->get();
            $dataeotherdoc = '';
            if (count($leave_allocation_rsdg) != 0) {

                foreach ($leave_allocation_rsdg as $employee) {

                    $employeet = DB::table('employee')->where('emp_code', '=', $employee->emp_code)->where('emid', '=', $this->reg)->first();
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
                    $euss_exp = $employee->euss_ref_no . $euss_exp;

                    $dbs_exp = '';
                    if ($employee->dbs_exp_date != '1970-01-01') {
                        if ($employee->dbs_exp_date != 'null' && $employee->dbs_exp_date != NULL) {
                            $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->dbs_exp_date));
                        }
                    }
                    $dbs_exp = $employee->dbs_ref_no . $dbs_exp;

                    $nid_exp = '';
                    if ($employee->nat_exp_date != '1970-01-01') {
                        if ($employee->nat_exp_date != 'null' && $employee->nat_exp_date != NULL) {
                            $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employee->nat_exp_date));
                        }
                    }
                    $nid_exp = $employee->nat_id_no . $nid_exp;
                

                    $dojg = date('m-d', strtotime($employeet->emp_doj));

                    $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));

                    $employeetemployeeother = DB::table('circumemployee_other_doc')->where('emp_code', '=', $employee->emp_code)->where('emid', '=', $employeet->emid)
                        ->where('cir_id', '=', $employee->id)->orderBy('id', 'DESC')->get();

                    $dataeotherdoc = '';

                    if (count($employeetemployeeother) != 0) {

                        foreach ($employeetemployeeother as $valother) {
                            if ($valother->doc_exp_date != '1970-01-01') {if ($valother->doc_exp_date != '') {
                                $other_exp_date = date('d/m/Y', strtotime($valother->doc_exp_date));
                            } else {
                                $other_exp_date = '';
                            }} else {
                                $other_exp_date = '';
                            }
                            $dataeotherdoc .= $valother->doc_name . '( ' . $other_exp_date . ')';
                        }

                    }

                    $customer_array[] = array(
                        'Sl No' => $h,
                        'Updated Date' => date('d/m/Y', strtotime($employee->date_change)),
                        'Employment Type' => $this->employee_type,
                        'Employment Code' => $employee->emp_code,
                        'Employment Name' => $employeet->emp_fname . " " . $employeet->emp_mname . " " . $employeet->emp_lname,

                        'Job  Title' => $employee->emp_designation,
                        'Address' => $add,

                        'Telephone' => $employee->emp_ps_phone,

                        'BRP  Number' => $employee->visa_doc_no,

                        'Visa Expiry' => $visa_exp,
                        'Remarks/Restriction to work' => $employee->res_remark,
                        'Passport No' => $employee->pass_doc_no . $pass_no,
                        'EUSS Details'=>$euss_exp,
                        'DBS Details'=>$dbs_exp,
                        'National Id Details'=>$nid_exp,
                        'Other Documents' => $dataeotherdoc,
                        'Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details? ' => $employee->hr,
                        'Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?' => $employee->home,
                        'Annual  Reminder Date' => date('d/m/Y', strtotime($anual_date)),
                    );
                    $h++;}
            } else {

                $dojg = date('m-d', strtotime($employeet->emp_doj));
                $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));

                $no = '';
                if ($endtyear != $m) {
                    $no = 'no change ';
                } else {
                    $no = '';
                }
                $customer_array[] =
                array(
                    'Sl No' => $h,
                    'Updated Date' => '',
                    'Employment Type' => '',
                    'Employment Code' => '',
                    'Employment Name' => '',

                    'Job  Title' => '',
                    'Address' => '',

                    'Telephone' => '',

                    'BRP  Number' => '',

                    'Visa Expiry' => '',
                    'Remarks/Restriction to work' => $no,
                    'Passport No' => '',
                    'EUSS Details'=>'',
                    'DBS Details'=>'',
                    'National Id Details'=>'',
                    'Other Documents' => $dataeotherdoc,
                    'Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details? ' => '',
                    'Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?' => '',
                    'Annual  Reminder Date' => date('d/m/Y', strtotime($anual_date)),
                );

                $h++;}
        }

        for ($o = ($endtyear + 1); $o <= ($endtyear + 4); $o++) {
            $dojg = date('m-d', strtotime($employeet->emp_doj));
            $anual_date = date('Y-m-d', strtotime($o . '-' . $dojg . '  + 1 year'));

            $customer_array[] =
            array(
                'Sl No' => $h,
                'Updated Date' => '',
                'Employment Type' => '',
                'Employment Code' => '',
                'Employment Name' => '',

                'Job  Title' => '',
                'Address' => '',

                'Telephone' => '',

                'BRP  Number' => '',

                'Visa Expiry' => '',
                'Remarks/Restriction to work' => ' ',
                'Passport No' => '',
                'EUSS Details'=>'',
                'DBS Details'=>'',
                'National Id Details'=>'',
                'Other Documents' => '',
                'Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details? ' => '',
                'Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?' => '',
                'Annual  Reminder Date' => date('d/m/Y', strtotime($anual_date)),
            );

            $h++;

        }

        return collect($customer_array);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Updated Date',
            'Employment Type',
            'Employment Code',
            'Employment Name',

            'Job  Title',
            'Address',

            'Telephone',

            'BRP  Number',

            'Visa Expiry',
            'Remarks/Restriction to work',
            'Passport No',
            'EUSS Details',
            'DBS Details',
            'National Id Details',
            'Other Documents',
            'Are Sponsored migrants aware that they must inform [HR/line manager] promptly of changes in contact Details? ',
            'Are Sponsored migrants  aware that they need to cooperate Home Office interview by presenting original passports during the Interview (In applicable cases)?',
            'Annual  Reminder Date',
        ];
    }
}
