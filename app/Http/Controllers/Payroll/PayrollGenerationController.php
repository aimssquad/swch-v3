<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Payroll\MonthlyEmployeeCooperative;
use App\Models\Payroll\Payroll_detail;
use App\Models\Employee;
use App\Models\Rate_master;
use App\Models\Attendance\Process_attendance;
use App\Models\LeaveApprover\Leave_apply;
use App\Models\RateDetail;
use App\Models\Employee\Employee_pay_structure;
use App\Models\Payroll\MonthlyEmployeeItax;
use App\Models\Payroll\MonthlyEmployeeAllowance;
use App\Models\Payroll\MonthlyEmployeeOvertime;
use App\Models\Loan\Loan;
use App\Models\Loan\LoanRecovery;
use App\Models\Masters\Interest;
use App\Models\Leave\Nps_details;
use App\Models\Leave\Gpf_details;
use App\Models\Payroll\PfOpeningBalance;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PfOpeningBalanceImport;
use App\Models\Payroll\PayrollDummy;
use App\Models\Payroll\YearlyEmployeeBonus;
use App\Models\Masters\BonusRate;
use Session;
use View;
use DB;

class PayrollGenerationController extends Controller
{
    public function payrollDashboard(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            return View('payroll/dashboard');
        } else {
            return redirect('/');
        }
    }
    public function getMonthlyCoopDeduction()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['monthlist'] = MonthlyEmployeeCooperative::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/monthly-coop', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewMonthlyCoopDeduction(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->all());

            $data['monthlist'] = MonthlyEmployeeCooperative::select('month_yr')->distinct('month_yr')->get();

            $data['req_month'] = $request->month;

            $employee_rs = MonthlyEmployeeCooperative::join('employee', 'employee.emp_code', '=', 'monthly_employee_cooperatives.emp_code')
                ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.designation', 'employee.old_emp_code', 'monthly_employee_cooperatives.*')
                ->where('monthly_employee_cooperatives.month_yr', '=', $request->month)
                // ->where('monthly_employee_cooperatives.status', '=', 'process')
                // ->where('monthly_employee_cooperatives.emp_code', '=', '7086')
                ->orderBy('employee.emp_fname', 'asc')
                ->get();

            // dd($employee_rs);
            //$data['result'] = array();
            // if (count($employee_rs) > 0) {
            //     $data['result'] = $employee_rs;
            // }
            if (count($employee_rs) == 0) {
                Session::flash('error', 'Cooperative for the month ' . $request->month . ' already processed.');
                return redirect('payroll/vw-montly-coop');
            }
            $result = '';
            foreach ($employee_rs as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
                            <td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
                            <td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
                            <td>' . $emcode->old_emp_code . '</td>
                            <td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"></td>
                            <td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->designation . '"></td>
                            <td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request->month . '"></td>
                            <td><input type="number" step="any" class="form-control sm_d_coop" name="d_coop' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->coop_amount . '" id="d_coop_' . $emcode->emp_code . '"></td><td><input type="number" step="any" class="form-control sm_d_insup" name="d_insup' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->insurance_prem . '" id="d_insup_' . $emcode->emp_code . '"></td><td><input type="number" step="any" class="form-control sm_d_misc" name="d_misc' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->misc_ded . '" id="d_misc_' . $emcode->emp_code . '"></td>';
            }

            $data['result'] = $result;

            return view('payroll/monthly-coop', $data);
        } else {
            return redirect('/');
        }
    }

    public function addMonthlyCoopDeductionAllemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['result'] = '';

            return view('payroll/add-monthly-coop-all', $data);
        } else {
            return redirect('/');
        }
    }

    public function listCoopAllemployee(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];

            $employee_rs = MonthlyEmployeeCooperative::join('employee', 'employee.emp_code', '=', 'monthly_employee_cooperatives.emp_code')
                ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.designation', 'employee.old_emp_code', 'monthly_employee_cooperatives.*')
                ->where('monthly_employee_cooperatives.month_yr', '=', $request['month_yr'])
                ->orderBy('employee.emp_fname', 'asc')
                ->get();

            //dd($employee_rs);
            //$data['result'] = array();
            // if (count($employee_rs) > 0) {
            //     $data['result'] = $employee_rs;
            // }
            
            // if (count($employee_rs) > 0) {
            //     Session::flash('error', 'Cooperative for the month ' . $request->month . ' already generated.');
            //     return redirect('payroll/vw-montly-coop');
            // }

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();

            $result = '';

            $emplist = Employee::where('status', 'active')
                        ->where('emp_status', '!=', 'TEMPORARY')
                        ->where('emp_status', '!=', 'EX-EMPLOYEE')
                        ->where('emp_status', '!=', 'EX-EMPLOYEE')
                        ->orderByRaw('CAST(old_emp_code AS UNSIGNED)')
                        ->get();
            foreach ($emplist as $mainkey => $emcode) {

                $process_payroll = $this->getEmpPayroll($emcode->emp_code, $payrolldate[0], $payrolldate[1]);
                $process_payroll = json_decode($process_payroll);

                //dd($process_payroll);

                $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $emcode->emp_code)
                    ->where('process_attendances.month_yr', '=', $origDate)
                    ->first();

                $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                    ->where('employee.emp_code', '=', $emcode->emp_code)
                    ->select('employee.*', 'employee_pay_structures.*')
                    ->first();

                // $leave_rs = Leave_apply::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applies.leave_type')
                //     ->where('leave_applies.employee_id', '=', $emcode->emp_code)
                //     ->where('leave_applies.status', '=', 'APPROVED')
                //     ->whereBetween('leave_applies.from_date', array($formatmonthyr, $tomonthyr))
                //     ->orwhereBetween('leave_applies.to_date', array($formatmonthyr, $tomonthyr))
                //     ->select('leave_applies.*', 'leave_types.leave_type_name')
                //     ->get();

                $previous_payroll = Payroll_detail::where('employee_id', '=', $emcode->emp_code)
                //->where('month_yr','<',$request['month_yr'])
                    ->orderBy('month_yr', 'desc')
                    ->first();

                $d_coop = 0;
                $d_coop_show = '';
                $d_insuprem = 0;
                $d_insuprem_show = '';

                $calculate_basic_salary = $employee_rs->basic_pay;

                for ($j = 0; $j < sizeof($process_payroll[3]); $j++) {

                    //co_op
                    // if ($process_payroll[3][$j]->rate_id == '24') {
                    //     if ($process_payroll[0]->co_op == '1') {
                    //         if ($process_payroll[3][$j]->inpercentage != '0') {
                    //             $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                    //             $d_coop = $valc;
                    //         } else {
                    //             if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                    //                 $d_coop = $process_payroll[3][$j]->inrupees;
                    //             }
                    //         }
                    //         $d_coop_show = "readonly";
                    //     } else if ($process_payroll[0]->co_op != null && $process_payroll[0]->co_op != '') {
                    //         $d_coop = $process_payroll[0]->co_op;
                    //         //                           $d_coop_show = "";
                    //     } else {
                    //         $valc = 0;
                    //         $d_coop = $valc;
                    //         $d_coop_show = "readonly";
                    //     }
                    // }

                    //insu_prem
                    if ($process_payroll[3][$j]->rate_id == '19') {
                        if ($process_payroll[0]->insu_prem == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_insuprem = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_insuprem = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_insuprem_show = "readonly";
                        } else if ($process_payroll[0]->insu_prem != null && $process_payroll[0]->insu_prem != '') {
                            $d_insuprem = $process_payroll[0]->insu_prem;
                            $d_insuprem_show = "readonly";
                        } else {
                            $valc = 0;
                            $d_insuprem = $valc;
                            $d_insuprem_show = "readonly";
                        }
                        
                    }

                }

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_code . '"></td>
                                <td>' . $employee_rs->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_fname . ' ' . $employee_rs->emp_mname . ' ' . $employee_rs->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->designation. '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>
								<td><input type="number" step="any" class="form-control sm_d_coop" name="d_coop' . $emcode->emp_code . '" style="width:100%;" value="' . $d_coop . '" id="d_coop_' . $emcode->emp_code . '" ' . $d_coop_show . '></td><td><input type="number" step="any" class="form-control sm_d_insup" name="d_insup' . $emcode->emp_code . '" style="width:100%;" value="'.$d_insuprem.'" id="d_insup_' . $emcode->emp_code . '"></td></td><td><input type="number" step="any" class="form-control sm_d_misc" name="d_misc' . $emcode->emp_code . '" style="width:100%;" value="0" id="d_misc_' . $emcode->emp_code . '"></td>';

                // print_r($result);
                // die();
            }
            // print_r($result);
            // die();
            $month_yr_new = $request['month_yr'];
            return view('payroll/add-monthly-coop-all', compact('result','month_yr_new'));
        } else {
            return redirect('/');
        }
    }

    public function SaveCoopAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->cboxes);
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);
                $sm_d_coop_ctrl = explode(',', $request->sm_d_coop_ctrl);
                $sm_d_insup_ctrl = explode(',', $request->sm_d_insup_ctrl);
                $sm_d_misc_ctrl = explode(',', $request->sm_d_misc_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];
                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['coop_amount'] = $sm_d_coop_ctrl[$index];
                    $data['insurance_prem'] = $sm_d_insup_ctrl[$index];
                    $data['misc_ded'] = $sm_d_misc_ctrl[$index];

                    $data['status'] = 'process';
                    $data['created_at'] = date('Y-m-d');

                    $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                        ->where('month_yr', '=', $data['month_yr'])
                        ->first();

                    // if (!empty($employee_pay_structure)) {
                    //     Session::flash('message', 'Payroll already generated for said period');
                    // } else {
                        $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                            ->where('employee.emp_code', '=', $value)
                            ->select('employee_pay_structures.*')
                            ->first();

                        $data['pay_structure_amount'] = $employee_rs->co_op;
                        if ($data['pay_structure_amount'] == null) {
                            $data['pay_structure_amount'] = 0;
                        }
                        $data['pay_structure_insu_prem'] = $employee_rs->insu_prem;
                        if ($data['pay_structure_insu_prem'] == null) {
                            $data['pay_structure_insu_prem'] = 0;
                        }
                        $data['pay_structure_misc_ded'] = $employee_rs->emp_misc_ded;
                        if ($data['pay_structure_misc_ded'] == null) {
                            $data['pay_structure_misc_ded'] = 0;
                        }
                        $ps_id = $employee_rs->id;

                        $monthlyEmployeeCooperative = MonthlyEmployeeCooperative::where('emp_code', '=', $value)
                            ->where('month_yr', '=', $sm_month_yr_ctrl[$index])
                            ->first();

                        //dd($monthlyEmployeeCooperative);

                        if (!empty($monthlyEmployeeCooperative)) {
                            MonthlyEmployeeCooperative::where('month_yr', $sm_month_yr_ctrl[$index])->where('emp_code', $value)->update($data);
                            Session::flash('message', 'Record Successfully Updated.');
                            //   Session::flash('message', 'Record Already provided for said period for employee - ' . $value);
                        } else {
                            MonthlyEmployeeCooperative::insert($data);
                            // $payupdate = array(
                            //     'co_op' => $data['coop_amount'],
                            //     'insu_prem' => $data['insurance_prem'],
                            //     'misc_ded' => $data['misc_ded'],
                            //     'updated_at' => date('Y-m-d h:i:s'),
                            // );
                            // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                            Session::flash('message', 'Record Successfully Saved.');
                        }

                    // }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-coop');
        } else {
            return redirect('/');
        }
    }
    public function UpdateCoopAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $request->status=$request->statusme;
             //dd($request->status);

            if (isset($request->deleteme) && $request->deleteme == 'yes') {

                $employee_payroll = Payroll_detail::where('month_yr', '=', $request->deletemy)->get();
                if (count($employee_payroll) > 0) {
                    Session::flash('error', 'Records cannot be deleted as payroll for the month already generated.');
                    return redirect('payroll/vw-montly-coop');
                }

                MonthlyEmployeeCooperative::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated records deleted successfully.');
                return redirect('payroll/vw-montly-coop');
            }

            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);
                $sm_d_coop_ctrl = explode(',', $request->sm_d_coop_ctrl);
                $sm_d_insup_ctrl = explode(',', $request->sm_d_insup_ctrl);
                $sm_d_misc_ctrl = explode(',', $request->sm_d_misc_ctrl);
                

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];
                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $employee_pay_structure = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                        ->select('employee.old_emp_code', 'payroll_details.*')
                        ->where('payroll_details.employee_id', '=', $value)
                        ->where('payroll_details.month_yr', '=', $data['month_yr'])
                        ->first();

                    // if (!empty($employee_pay_structure)) {
                    //     Session::flash('error', 'Payroll already generated for said period for Employee Code - '.$employee_pay_structure->old_emp_code);
                    // } else {

                        $data['coop_amount'] = $sm_d_coop_ctrl[$index];
                        $data['insurance_prem'] = $sm_d_insup_ctrl[$index];
                        $data['misc_ded'] = $sm_d_misc_ctrl[$index];
                        $data['status'] = $request->status==''?'process':$request->status;
                        $data['updated_at'] = date('Y-m-d');

                        // dd($data);
                        MonthlyEmployeeCooperative::where('month_yr', $sm_month_yr_ctrl[$index])->where('emp_code', $value)->update($data);

                        // $payupdate = array(
                        //     'co_op' => $data['coop_amount'],
                        //     'insu_prem' => $data['insurance_prem'],
                        //     'misc_ded' => $data['misc_ded'],
                        //     'updated_at' => date('Y-m-d h:i:s'),
                        // );
                        // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                        Session::flash('message', 'Record Successfully Updated.');

                    // }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-coop');
        } else {
            return redirect('/');
        }
    }
    public function getEmpPayroll($empid, $month, $year)
    {
        
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $mnth_yr = $month . '/' . $year;

            //$tomonthyr=date("Y-m-t");
            //$formatmonthyr=date("Y-m-01");
            $tomonthyr = $year . "-" . $month . "-31";
            $formatmonthyr = $year . "-" . $month . "-01";

            $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                ->where('employee.emp_code', '=', $empid)
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
                ->select('employee.*', 'employee_pay_structures.*')->first();

            $leave_rs = Leave_apply::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applies.leave_type')
                ->where('leave_applies.employee_id', '=', $empid)
                ->where('leave_applies.status', '=', 'APPROVED')
                ->where('leave_applies.from_date', '>=', $formatmonthyr)
                ->where('leave_applies.to_date', '<=', $tomonthyr)
                ->select('leave_applies.*', 'leave_types.leave_type_name')
                ->get();

            $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $empid)
                ->where('process_attendances.month_yr', '=', $mnth_yr)
                ->first();
            //->toSql();

            $rate_rs = RateDetail::leftJoin('rate_masters', 'rate_masters.id', '=', 'rate_details.rate_id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->where('rate_details.from_date', '>=', date($year.'-01-01'))
                ->where('rate_details.to_date', '<=', date($year.'-12-31'))

                ->get();

                //dd($rate_rs);

            return json_encode(array($employee_rs, $leave_rs, $process_attendance, $rate_rs));
        } else {
            return json_encode(array());
        }
    }
    public function getMonthlyItaxDeduction()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['monthlist'] = MonthlyEmployeeItax::select('month_yr')->distinct('month_yr')->get();

            $data['result'] = '';
            $payroll_details_rs = '';
            $data['Classname'] = 'monthly-incometax';

            return view('payroll/monthly-incometax', $data);
        } else {
            return redirect('/');
        }
    }
    public function addMonthlyItaxDeductionAllemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Classname'] = 'monthly-incometax';
            $data['result'] = '';

            return view('payroll/add-monthly-itax-all', $data);
        } else {
            return redirect('/');
        }
    }
    public function listItaxAllemployee(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $payrolldate = explode('/', $request['month_yr']);
            //$payroll_date = "0" . ($payrolldate[0] - 2);
            $payroll_date = $payrolldate[0];
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();

            $result = '';

            $emplist = Employee::where('status', 'active')
            ->where('emp_status', '!=', 'TEMPORARY')
            ->where('emp_status', '!=', 'EX-EMPLOYEE')
            ->where('emp_status', '!=', 'EX-EMPLOYEE')
            ->orderByRaw('CAST(old_emp_code AS UNSIGNED)')
            ->get();
        

                 

            foreach ($emplist as $mainkey => $emcode) {

                $process_payroll = $this->getEmpPayroll($emcode->emp_code, $payrolldate[0], $payrolldate[1]);
                $process_payroll = json_decode($process_payroll);

                //dd($process_payroll);

                $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $emcode->emp_code)
                    ->where('process_attendances.month_yr', '=', $origDate)
                    ->first();

                $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                    ->where('employee.emp_code', '=', $emcode->emp_code)
                    ->select('employee.*', 'employee_pay_structures.*')
                    ->first();

                // $leave_rs = Leave_apply::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applies.leave_type')
                //     ->where('leave_applies.employee_id', '=', $emcode->emp_code)
                //     ->where('leave_applies.status', '=', 'APPROVED')
                //     ->whereBetween('leave_applies.from_date', array($formatmonthyr, $tomonthyr))
                //     ->orwhereBetween('leave_applies.to_date', array($formatmonthyr, $tomonthyr))
                //     ->select('leave_applies.*', 'leave_types.leave_type_name')
                //     ->get();

                $previous_payroll = Payroll_detail::where('employee_id', '=', $emcode->emp_code)
                //->where('month_yr','<',$request['month_yr'])
                    ->orderBy('month_yr', 'desc')
                    ->first();

                $d_itax = 0;
                $d_itax_show = '';
                $calculate_basic_salary = $employee_rs->basic_pay;

                for ($j = 0; $j < sizeof($process_payroll[3]); $j++) {

                    //i_tax
                    if ($process_payroll[3][$j]->rate_id == '18') {
                        if ($process_payroll[0]->i_tax == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $d_itax = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_itax = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_itax_show = "readonly";
                        } else if ($process_payroll[0]->i_tax != null && $process_payroll[0]->i_tax != '') {
                            $d_itax = $process_payroll[0]->i_tax;
                            //                           $d_itax_show = "";
                        } else {
                            $valc = 0;
                            $d_itax = $valc;
                            $d_itax_show = "readonly";
                        }
                    }

                }

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_code . '"></td>
                                <td>' . $employee_rs->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_fname . ' ' . $employee_rs->emp_mname . ' ' . $employee_rs->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>
								<td><input type="number" step="any" class="form-control sm_d_itax" name="d_itax' . $emcode->emp_code . '" style="width:100%;" value="' . $d_itax . '" id="d_itax_' . $emcode->emp_code . '" ' . $d_itax_show . '></td>';

                // print_r($result);
                // die();
            }
            // print_r($result);
            // die();
            $month_yr_new = $request['month_yr'];
            return view('payroll/add-monthly-itax-all', compact('result','month_yr_new'));
        } else {
            return redirect('/');
        }
    }
    public function SaveItaxAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->cboxes);
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);
                $sm_d_itax_ctrl = explode(',', $request->sm_d_itax_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];

                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['itax_amount'] = $sm_d_itax_ctrl[$index];

                    $data['status'] = 'process';
                    $data['created_at'] = date('Y-m-d');

                    //dd($data);

                    $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                        ->where('month_yr', '=', $data['month_yr'])
                        ->first();

                    // dd($employee_pay_structure);

                    if (!empty($employee_pay_structure)) {
                        Session::flash('error', 'Payroll already generated for said period');
                    } else {
                        $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                            ->where('employee.emp_code', '=', $value)
                            ->select('employee_pay_structures.*')
                            ->first();

                        $data['pay_structure_amount'] = $employee_rs->i_tax;
                        if ($data['pay_structure_amount'] == null) {
                            $data['pay_structure_amount'] = 0;
                        }
                        $ps_id = $employee_rs->id;

                        $monthlyEmployeeItax = MonthlyEmployeeItax::where('emp_code', '=', $value)
                            ->where('month_yr', '=', $sm_month_yr_ctrl[$index])
                            ->first();

                        //dd($monthlyEmployeeItax);

                        if (!empty($monthlyEmployeeItax)) {
                            Session::flash('error', 'Record Already provided for said period for employee - ' . $value);
                        } else {
                            MonthlyEmployeeItax::insert($data);
                            // $payupdate = array(
                            //     'i_tax' => $data['itax_amount'],
                            //     'updated_at' => date('Y-m-d h:i:s'),
                            // );
                            // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                            Session::flash('message', 'Record Successfully Saved.');
                        }

                    }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-itax');
        } else {
            return redirect('/');
        }
    }
    public function viewMonthlyItaxDeduction(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->all());

            $data['monthlist'] = MonthlyEmployeeItax::select('month_yr')->distinct('month_yr')->get();

            $data['req_month'] = $request->month;

            $employee_rs = MonthlyEmployeeItax::join('employee', 'employee.emp_code', '=', 'monthly_employee_itaxes.emp_code')
                            ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.designation', 'employee.old_emp_code', 'monthly_employee_itaxes.*')
                            ->where('monthly_employee_itaxes.month_yr', $request->month)
                            // ->where('monthly_employee_itaxes.status', 'process')
                            ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) asc')
                            ->get();

            //dd($employee_rs);
            //$data['result'] = array();
            // if (count($employee_rs) > 0) {
            //     $data['result'] = $employee_rs;
            // }

            $result = '';

            // if (count($employee_rs) == 0) {
            //     Session::flash('error', 'Income Tax for the month ' . $request->month . ' already processed.');
            //     return redirect('payroll/vw-montly-itax');
            // }
            foreach ($employee_rs as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
                            <td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
                            <td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
                            <td>' . $emcode->old_emp_code . '</td>
                            <td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"></td>
                            <td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->designation . '"></td>
                            <td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request->month . '"></td>
                            <td><input type="number" step="any" class="form-control sm_d_itax" name="d_itax' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->itax_amount . '" id="d_itax_' . $emcode->emp_code . '"></td>';
            }

            $data['result'] = $result;

            return view('payroll/monthly-incometax', $data);
        } else {
            return redirect('/');
        }
    }
    public function UpdateItaxAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            // dd($request->cboxes);
            $request->status=$request->statusme;
            if (isset($request->deleteme) && $request->deleteme == 'yes') {

                $employee_payroll = Payroll_detail::where('month_yr', '=', $request->deletemy)->get();
                if (count($employee_payroll) > 0) {
                    Session::flash('error', 'Records cannot be deleted as payroll for the month already generated.');
                    return redirect('payroll/vw-montly-itax');
                }

                MonthlyEmployeeItax::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated records deleted successfully.');
                return redirect('payroll/vw-montly-itax');
            }

            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);
                $sm_d_itax_ctrl = explode(',', $request->sm_d_itax_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];
                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['itax_amount'] = $sm_d_itax_ctrl[$index];

                    $data['status'] = $request->status==''?'process':$request->status;
                    $data['updated_at'] = date('Y-m-d');

                    // dd($data);

                    // $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                    //     ->where('month_yr', '=', $data['month_yr'])
                    //     ->first();
                    $employee_pay_structure = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                        ->select('employee.old_emp_code', 'payroll_details.*')
                        ->where('payroll_details.employee_id', '=', $value)
                        ->where('payroll_details.month_yr', '=', $data['month_yr'])
                        ->first();

                    // if (!empty($employee_pay_structure)) {
                    //     Session::flash('error', 'Payroll already generated for said period against Employee Code - '.$employee_pay_structure->old_emp_code);
                    // } else {

                        MonthlyEmployeeItax::where('month_yr', $sm_month_yr_ctrl[$index])->where('emp_code', $value)->update($data);

                        // $payupdate = array(
                        //     'i_tax' => $data['itax_amount'],
                        //     'updated_at' => date('Y-m-d h:i:s'),
                        // );
                        // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                        Session::flash('message', 'Record Successfully Updated.');

                    // }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-itax');
        } else {
            return redirect('/');
        }
    }
    
    public function getMonthlyEarningAllowances()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['monthlist'] = MonthlyEmployeeAllowance::select('month_yr')->distinct('month_yr')->get();
            $data['Classname'] = 'vw-montly-allowances';
            $data['result'] = '';
            $payroll_details_rs = '';

            return view('payroll/monthly-allowance', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewMonthlyEarningAllowances(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->all());

            $data['monthlist'] = MonthlyEmployeeAllowance::select('month_yr')->distinct('month_yr')->get();

            $data['req_month'] = $request->month;

        //     $emplist = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
        //     ->select('employee.*', 'process_attendances.*')
        //     ->where('process_attendances.month_yr', '=', $request['month_yr'])
        //     ->where('process_attendances.status', '=', 'A')
        //     //->where('employee.emp_status', '!=', 'TEMPORARY')
        //     ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
        //     ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
        //     ->where('employee.status', '=', 'active')
        // // ->where('employee.emp_code', '=', '1831')
        //     ->orderBy('employee.emp_fname', 'asc')
        //     ->get();


        $employee_rs = MonthlyEmployeeAllowance::join('employee', 'employee.emp_code', '=', 'monthly_employee_allowances.emp_code')
                    ->join('process_attendances', 'employee.emp_code', '=', 'process_attendances.employee_code')
                    ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.designation', 'employee.old_emp_code', 'monthly_employee_allowances.*','process_attendances.no_of_working_days','process_attendances.no_of_days_absent','process_attendances.no_of_days_leave_taken','process_attendances.no_of_present','process_attendances.no_of_tour_leave','process_attendances.no_of_days_salary')
                    ->where('monthly_employee_allowances.month_yr', $request->month)
                    ->where('process_attendances.month_yr', '=', $request->month)
                    ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                    ->get();

           //dd($employee_rs);

            $result = '';
            // if (count($employee_rs) == 0) {
            //     Session::flash('error', 'Allowances for the month ' . $request->month . ' already processed.');
            //     return redirect('payroll/vw-montly-allowances');
            // }
            foreach ($employee_rs as $mainkey => $emcode) {
                $no_of_present=0;
                $no_of_days_leave_taken=0;
                $no_of_days_absent=0;

                if(isset($emcode->no_of_present) && $emcode->no_of_present!=''){
                    $no_of_present=$emcode->no_of_present;
                }
                if(isset($emcode->no_of_days_leave_taken) && $emcode->no_of_days_leave_taken!=''){
                    $no_of_days_leave_taken=$emcode->no_of_days_leave_taken;
                }
                if(isset($emcode->no_of_days_absent) && $emcode->no_of_days_absent!=''){
                    $no_of_days_absent=$emcode->no_of_days_absent;
                }

                $infoTitle="Absent Days:".$no_of_days_absent."  Leave Days:".$no_of_days_leave_taken;

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"><input type="hidden" readonly class="form-control sm_tot_wdays" name="tot_wdays' . $emcode->emp_code . '" style="width:100%;" id="tot_wdays_' . $emcode->emp_code . '" value="' . $emcode->total_days . '"></td>
                                <td>' . $emcode->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100px;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100px;" value="' . $emcode->month_yr . '"></td>
                                <td><input type="hidden" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100px;" value="' . $emcode->designation . '"><div class="row"><div class="col-md-6"><input type="text" readonly class="form-control sm_no_of_present" name="no_of_present' . $emcode->emp_code . '" style="width:70px;" value="' . $no_of_present . '"></div><div class="col-md-6"><a title="'.$infoTitle.'"><i class="fa fa-info" style="padding-top:7px;"></i></a></div></div></td>';

                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_tiff" id="no_d_tiff_' . $emcode->emp_code . '" name="no_d_tiff' . $emcode->emp_code . '" value="' . $emcode->no_days_tiffalw . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_et_tiffalw" id="et_tiffalw_' . $emcode->emp_code . '" name="et_tiffalw' . $emcode->emp_code . '" value="' . $emcode->pay_structure_tiff_alw . '" readonly></td>';

                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_tiffalw" id="e_tiffalw_' . $emcode->emp_code . '" name="e_tiffalw' . $emcode->emp_code . '" value="' . $emcode->tiffin_alw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_conv" id="no_d_conv_' . $emcode->emp_code . '" name="no_d_conv' . $emcode->emp_code . '" value="' . $emcode->no_days_convalw . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_et_convalw" id="et_convalw_' . $emcode->emp_code . '" name="et_convalw' . $emcode->emp_code . '" value="' . $emcode->pay_structure_conv_alw. '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_conv" name="e_conv' . $emcode->emp_code . '" value="' . $emcode->convence_alw . '" id="e_conv_' . $emcode->emp_code . '" readonly ></td>';

                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_misc" id="no_d_misc_' . $emcode->emp_code . '" name="no_d_misc' . $emcode->emp_code . '" value="' . $emcode->no_days_miscalw . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_et_miscalw" id="et_miscalw_' . $emcode->emp_code . '" name="et_miscalw' . $emcode->emp_code . '" value="' . $emcode->pay_structure_misc_alw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_miscalw" name="e_miscalw' . $emcode->emp_code . '" value="' . $emcode->misc_alw . '" id="e_miscalw_' . $emcode->emp_code . '" readonly ></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_extra_misc_alw" name="e_extra_misc_alw' . $emcode->emp_code . '" value="' . $emcode->extra_misc_alw . '" id="e_extra_misc_alw_' . $emcode->emp_code . '" ></td>';
                // other_allw
                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_other" id="no_d_other_' . $emcode->emp_code . '" name="no_d_other' . $emcode->emp_code . '" value="' . $emcode->no_days_otheralw . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_et_otheralw" id="et_otheralw_' . $emcode->emp_code . '" name="et_otheralw' . $emcode->emp_code . '" value="' . $emcode->pay_structure_other_alw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_otheralw" name="e_otheralw' . $emcode->emp_code . '" value="' . $emcode->other_alw . '" id="e_otheralw_' . $emcode->emp_code . '" readonly ></td>';

        
            }

            $data['result'] = $result;
            $data['month_yr_new'] = $request->month;
            return view('payroll/monthly-allowance', $data);
        } else {
            return redirect('/');
        }
    }
    public function addMonthlyAllowancesAllemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['result'] = '';

            return view('payroll/add-monthly-allowance-all', $data);
        } else {
            return redirect('/');
        }
    }
    public function listAllowancesAllemployee(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $payrolldate = explode('/', $request['month_yr']);
            //$payroll_date = "0" . ($payrolldate[0] - 2);
            $payroll_date = $payrolldate[0];
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();

            $result = '';

            // $emplist = Employee::where('status', '=', 'active')
            //     ->where('emp_status', '!=', 'TEMPORARY')
            //     ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
            //     ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            // // ->where('employee.emp_code', '=', '5571')
            //     ->orderBy('emp_fname', 'asc')
            //     ->get();

                $emplist = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
                            ->select('employee.*', 'process_attendances.*')
                            ->where('process_attendances.month_yr', $request['month_yr'])
                            ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                            ->where('employee.status', 'active')
                            ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) asc')
                            ->get();

                //dd($emplist);

            if (count($emplist) == 0) {
                Session::flash('error', 'Please process the attandance for the month before generating allowances.');
                return redirect('payroll/add-montly-allowances');
            }

            foreach ($emplist as $mainkey => $emcode) {

                $process_payroll = $this->getEmpPayroll($emcode->emp_code, $payrolldate[0], $payrolldate[1]);
                $process_payroll = json_decode($process_payroll);

                // dd($process_payroll);

                $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                    ->where('employee.emp_code', '=', $emcode->emp_code)
                    ->select('employee.*', 'employee_pay_structures.*')
                    ->first();

                // $previous_payroll = Payroll_detail::where('employee_id', '=', $emcode->emp_code)
                // //->where('month_yr','<',$request['month_yr'])
                //     ->orderBy('month_yr', 'desc')
                //     ->first();

                $e_tiffalw = 0;
                $e_tiffalw_show = '';
                $e_othalw = 0;
                $e_othalw_show = '';
                $e_conv = 0;
                $e_conv_show = '';
                $e_medical = 0;
                $e_medical_show = '';
                $e_miscalw = 0;
                $e_miscalw_show = '';
                $e_extra_misc_alw = 0;
                $e_extra_misc_alw_show = '';
                $e_other_allw = 0;
                $e_other_allw_show = '';
                

                $calculate_basic_salary = $employee_rs->basic_pay;

                for ($j = 0; $j < sizeof($process_payroll[3]); $j++) {

                    //tiff alw
                    if ($process_payroll[3][$j]->rate_id == '6') {
                        if ($process_payroll[0]->tiff_alw == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $e_tiffalw = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_tiffalw = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_tiffalw_show = "readonly";
                        } else if ($process_payroll[0]->tiff_alw != null && $process_payroll[0]->tiff_alw != '') {
                            $e_tiffalw = $process_payroll[0]->tiff_alw;
                            $e_tiffalw_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_tiffalw = $valc;
                            $e_tiffalw_show = "readonly";
                        }
                    }

                    //conv
                    if ($process_payroll[3][$j]->rate_id == '7') {
                        if ($process_payroll[0]->conv == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $e_conv = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_conv = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_conv_show = "readonly";
                        } else if ($process_payroll[0]->conv != null && $process_payroll[0]->conv != '') {
                            $e_conv = $process_payroll[0]->conv;
                             $e_conv_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_conv = $valc;
                            $e_conv_show = "readonly";
                        }
                    }

                    //misc_alw
                    if ($process_payroll[3][$j]->rate_id == '9') {
                        if ($process_payroll[0]->misc_alw == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $e_miscalw = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_miscalw = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_miscalw_show = "readonly";
                        } else if ($process_payroll[0]->misc_alw != null && $process_payroll[0]->misc_alw != '') {
                            $e_miscalw = $process_payroll[0]->misc_alw;
                             $e_miscalw_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_miscalw = $valc;
                            $e_miscalw_show = "readonly";
                        }
                    }

                    //over_time
                    // if ($process_payroll[3][$j]->rate_id == '10') {
                    //     if ($process_payroll[0]->over_time == '1') {
                    //         if ($process_payroll[3][$j]->inpercentage != '0') {
                    //             $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                    //             $e_overtime = $valc;
                    //         } else {
                    //             if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                    //                 $e_overtime = $process_payroll[3][$j]->inrupees;
                    //             }
                    //         }
                    //         $e_overtime_show = "readonly";
                    //     } else if ($process_payroll[0]->over_time != null && $process_payroll[0]->over_time != '') {
                    //         $e_overtime = $process_payroll[0]->over_time;
                    //         //$e_overtime_show = "";
                    //     } else {
                    //         $valc = 0;
                    //         $e_overtime = $valc;
                    //         $e_overtime_show = "readonly";
                    //     }
                    // }
                    
                    // other_allowence
                    
                    if ($process_payroll[3][$j]->rate_id == '5') {
                        if ($process_payroll[0]->others_alw == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = round($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $e_other_allw = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_other_allw = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_other_allw_show = "readonly";
                        } else if ($process_payroll[0]->others_alw != null && $process_payroll[0]->others_alw != '') {
                            $e_other_allw = $process_payroll[0]->others_alw;
                            $e_other_allw_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_other_allw = $valc;
                            $e_other_allw_show = "readonly";
                        }
                    }

                }

                $no_of_present=0;
                $no_of_days_leave_taken=0;
                $no_of_days_absent=0;

                if(isset($emcode->no_of_present) && $emcode->no_of_present!=''){
                    $no_of_present=$emcode->no_of_present;
                }
                if(isset($emcode->no_of_days_leave_taken) && $emcode->no_of_days_leave_taken!=''){
                    $no_of_days_leave_taken=$emcode->no_of_days_leave_taken;
                }
                if(isset($emcode->no_of_days_absent) && $emcode->no_of_days_absent!=''){
                    $no_of_days_absent=$emcode->no_of_days_absent;
                }

                $infoTitle="Absent Days:".$no_of_days_absent."  Leave Days:".$no_of_days_leave_taken;


                $cal_tiff_alw = $e_tiffalw;
                $tot_wdays = $no_of_present + $no_of_days_leave_taken + $no_of_days_absent;

                $perday_tiffalw = $e_tiffalw / $tot_wdays;
                $cal_tiff_alw = round(($perday_tiffalw * $no_of_present), 2);

                $cal_conv_alw = $e_conv;
                $perday_convalw = $e_conv / $tot_wdays;
                $cal_conv_alw = round(($perday_convalw * $no_of_present), 2);

                $cal_misc_alw = $e_miscalw;
                $perday_miscalw = $e_miscalw / $tot_wdays;
                $cal_misc_alw = round(($perday_miscalw * $no_of_present), 2);
                
                $cal_other_alw = $e_other_allw;
                $perday_otheralw = $e_other_allw / $tot_wdays;
                $cal_other_alw = round(($perday_otheralw * $no_of_present), 2);
                
                

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_code . '"><input type="hidden" readonly class="form-control sm_tot_wdays" name="tot_wdays' . $emcode->emp_code . '" style="width:100%;" id="tot_wdays_' . $emcode->emp_code . '" value="' . $tot_wdays . '"></td>
                                <td>' . $employee_rs->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100px;" value="' . $employee_rs->emp_fname . ' ' . $employee_rs->emp_mname . ' ' . $employee_rs->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100px;" value="' . $request['month_yr'] . '"></td>
                                <td><input type="hidden" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100px;" value="' . $employee_rs->designation . '"><div class="row"><div class="col-md-6"><input type="text" readonly class="form-control sm_no_of_present" name="no_of_present' . $emcode->emp_code . '" style="width:70px;" value="' . $no_of_present . '"></div><div class="col-md-6"><a title="'.$infoTitle.'"><i class="fa fa-info" style="padding-top:7px;"></i></a></div></div></td>';

                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_tiff" id="no_d_tiff_' . $emcode->emp_code . '" name="no_d_tiff' . $emcode->emp_code . '" value="' . $emcode->no_of_present . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="text" style="width:100%;" class="form-control sm_et_tiffalw" id="et_tiffalw_' . $emcode->emp_code . '" name="et_tiffalw' . $emcode->emp_code . '" value="' . $e_tiffalw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_tiffalw" id="e_tiffalw_' . $emcode->emp_code . '" name="e_tiffalw' . $emcode->emp_code . '" value="' . $cal_tiff_alw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_conv" id="no_d_conv_' . $emcode->emp_code . '" name="no_d_conv' . $emcode->emp_code . '" value="' . $emcode->no_of_present . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_et_convalw" id="et_convalw_' . $emcode->emp_code . '" name="et_convalw' . $emcode->emp_code . '" value="' . $e_conv . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_conv" name="e_conv' . $emcode->emp_code . '" value="' . $cal_conv_alw . '" id="e_conv_' . $emcode->emp_code . '" ' . $e_conv_show . '></td>';

                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_misc" id="no_d_misc_' . $emcode->emp_code . '" name="no_d_misc' . $emcode->emp_code . '" value="' . $emcode->no_of_present . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_et_miscalw" id="et_miscalw_' . $emcode->emp_code . '" name="et_miscalw' . $emcode->emp_code . '" value="' . $e_miscalw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_miscalw" name="e_miscalw' . $emcode->emp_code . '" value="' . $cal_misc_alw . '" id="e_miscalw_' . $emcode->emp_code . '" ' . $e_miscalw_show . '></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_extra_misc_alw" name="e_extra_misc_alw' . $emcode->emp_code . '" value="' . $e_extra_misc_alw . '" id="e_extra_misc_alw_' . $emcode->emp_code . '" ' . $e_extra_misc_alw_show . '></td>';
                
                $result .= '<td><input type="number" step="any" style="width:80px;" class="form-control sm_no_d_other" id="no_d_other_' . $emcode->emp_code . '" name="no_d_other' . $emcode->emp_code . '" value="' . $emcode->no_of_present . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="text" style="width:100%;" class="form-control sm_et_otheralw" id="et_otheralw_' . $emcode->emp_code . '" name="et_otheralw' . $emcode->emp_code . '" value="' . $e_other_allw . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_e_otheralw" id="e_otheralw_' . $emcode->emp_code . '" name="e_otheralw' . $emcode->emp_code . '" value="' . $cal_other_alw . '" readonly></td>';

                // print_r($result);
                // die();
            }
            // print_r($result);
            // die();
            $month_yr_new = $request['month_yr'];
            return view('payroll/add-monthly-allowance-all', compact('result','month_yr_new'));
        } else {
            return redirect('/');
        }
    }
    public function SaveAllowancesAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->cboxes);
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_tot_wdays_ctrl = explode(',', $request->sm_tot_wdays_ctrl);
                $sm_no_d_tiff_ctrl = explode(',', $request->sm_no_d_tiff_ctrl);
                $sm_no_d_conv_ctrl = explode(',', $request->sm_no_d_conv_ctrl);
                $sm_no_d_misc_ctrl = explode(',', $request->sm_no_d_misc_ctrl);
                $sm_no_d_other_ctrl = explode(',', $request->sm_no_d_other_ctrl);

                $sm_et_tiffalw_ctrl = explode(',', $request->sm_et_tiffalw_ctrl);
                $sm_e_tiffalw_ctrl = explode(',', $request->sm_e_tiffalw_ctrl);

                $sm_et_convalw_ctrl = explode(',', $request->sm_et_convalw_ctrl);
                $sm_e_conv_ctrl = explode(',', $request->sm_e_conv_ctrl);

                $sm_et_miscalw_ctrl = explode(',', $request->sm_et_miscalw_ctrl);
                $sm_e_miscalw_ctrl = explode(',', $request->sm_e_miscalw_ctrl);
                
                $sm_e_extra_misc_alw_ctrl = explode(',', $request->sm_e_extra_misc_alw_ctrl);
               
                $sm_et_otheralw_ctrl = explode(',', $request->sm_et_otheralw_ctrl);
                $sm_e_otheralw_ctrl = explode(',', $request->sm_e_otheralw_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];

                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['total_days'] = $sm_tot_wdays_ctrl[$index];
                    $data['no_days_tiffalw'] = $sm_no_d_tiff_ctrl[$index];
                    $data['no_days_convalw'] = $sm_no_d_conv_ctrl[$index];
                    $data['no_days_miscalw'] = $sm_no_d_misc_ctrl[$index];
                    $data['no_days_otheralw'] = $sm_no_d_other_ctrl[$index];

                    $data['pay_structure_tiff_alw'] = $sm_et_tiffalw_ctrl[$index];
                    $data['pay_structure_conv_alw'] = $sm_et_convalw_ctrl[$index];
                    $data['pay_structure_misc_alw'] = $sm_et_miscalw_ctrl[$index];
                    $data['pay_structure_other_alw'] = $sm_et_otheralw_ctrl[$index];

                    $data['tiffin_alw'] = $sm_e_tiffalw_ctrl[$index];
                    $data['convence_alw'] = $sm_e_conv_ctrl[$index];
                    $data['misc_alw'] = $sm_e_miscalw_ctrl[$index];
                   

                    $data['extra_misc_alw'] = $sm_e_extra_misc_alw_ctrl[$index];
                    $data['other_alw'] = $sm_e_otheralw_ctrl[$index];

                    $data['status'] = 'process';
                    $data['created_at'] = date('Y-m-d');

                    // if ($value == '7050') {

                    //     dd($data);
                    // }

                    $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                        ->where('month_yr', '=', $data['month_yr'])
                        ->first();

                    //dd($employee_pay_structure);

                    // if (!empty($employee_pay_structure)) {
                    //     Session::flash('error', 'Payroll already generated for said period');
                    // } else {

                        $monthlyEmployeeAllowance = MonthlyEmployeeAllowance::where('emp_code', '=', $value)
                            ->where('month_yr', '=', $data['month_yr'])
                            ->first();

                        //dd($monthlyEmployeeAllowance);

                        if (!empty($monthlyEmployeeAllowance)) {
                            
                            MonthlyEmployeeAllowance::where('month_yr',  $sm_month_yr_ctrl[$index])->where('emp_code',$value)->update($data);
                            Session::flash('message', 'Record Successfully updated.');
                            // Session::flash('error', 'Record Already provided for said period for employee - ' . $value);
                        } else {
                            MonthlyEmployeeAllowance::insert($data);
                            // $payupdate = array(
                            //     'i_tax' => $data['itax_amount'],
                            //     'updated_at' => date('Y-m-d h:i:s'),
                            // );
                            // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                            Session::flash('message', 'Record Successfully Saved.');
                        }

                    // }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-allowances');
        } else {
            return redirect('/');
        }
    }
    public function UpdateAllowancesAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            // dd($request->cboxes);
            $request->status=$request->statusme;

            if (isset($request->deleteme) && $request->deleteme == 'yes') {

                $employee_payroll = Payroll_detail::where('month_yr', '=', $request->deletemy)->get();
                if (count($employee_payroll) > 0) {
                    Session::flash('error', 'Records cannot be deleted as payroll for the month already generated.');
                    return redirect('payroll/vw-montly-allowances');
                }

                MonthlyEmployeeAllowance::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated records deleted successfully.');
                return redirect('payroll/vw-montly-allowances');
            }

            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_tot_wdays_ctrl = explode(',', $request->sm_tot_wdays_ctrl);
                $sm_no_d_tiff_ctrl = explode(',', $request->sm_no_d_tiff_ctrl);
                $sm_no_d_conv_ctrl = explode(',', $request->sm_no_d_conv_ctrl);
                $sm_no_d_misc_ctrl = explode(',', $request->sm_no_d_misc_ctrl);
                $sm_no_d_other_ctrl = explode(',', $request->sm_no_d_other_ctrl);

                $sm_et_tiffalw_ctrl = explode(',', $request->sm_et_tiffalw_ctrl);
                $sm_e_tiffalw_ctrl = explode(',', $request->sm_e_tiffalw_ctrl);

                $sm_et_convalw_ctrl = explode(',', $request->sm_et_convalw_ctrl);
                $sm_e_conv_ctrl = explode(',', $request->sm_e_conv_ctrl);

                $sm_et_miscalw_ctrl = explode(',', $request->sm_et_miscalw_ctrl);
                $sm_e_miscalw_ctrl = explode(',', $request->sm_e_miscalw_ctrl);

                $sm_e_extra_misc_alw_ctrl = explode(',', $request->sm_e_extra_misc_alw_ctrl);
                $sm_et_otheralw_ctrl = explode(',', $request->sm_et_otheralw_ctrl);
                $sm_e_otheralw_ctrl = explode(',', $request->sm_e_otheralw_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];
                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['total_days'] = $sm_tot_wdays_ctrl[$index];
                    $data['no_days_tiffalw'] = $sm_no_d_tiff_ctrl[$index];
                    $data['no_days_convalw'] = $sm_no_d_conv_ctrl[$index];
                    $data['no_days_miscalw'] = $sm_no_d_misc_ctrl[$index];
                    $data['no_days_otheralw'] = $sm_no_d_other_ctrl[$index];

                    $data['pay_structure_tiff_alw'] = $sm_et_tiffalw_ctrl[$index];
                    $data['pay_structure_conv_alw'] = $sm_et_convalw_ctrl[$index];
                    $data['pay_structure_misc_alw'] = $sm_et_miscalw_ctrl[$index];
                    $data['pay_structure_other_alw'] = $sm_et_otheralw_ctrl[$index];

                    $data['tiffin_alw'] = $sm_e_tiffalw_ctrl[$index];
                    $data['convence_alw'] = $sm_e_conv_ctrl[$index];
                    $data['misc_alw'] = $sm_e_miscalw_ctrl[$index];
                   

                    $data['extra_misc_alw'] = $sm_e_extra_misc_alw_ctrl[$index];
                    $data['other_alw'] = $sm_e_otheralw_ctrl[$index];
                    
                    $data['status'] = $request->status==''?'process':$request->status;
                    $data['updated_at'] = date('Y-m-d');

                    // dd($data);

                    // $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                    //     ->where('month_yr', '=', $data['month_yr'])
                    //     ->first();

                    $employee_pay_structure = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                        ->select('employee.old_emp_code', 'payroll_details.*')
                        ->where('payroll_details.employee_id', '=', $value)
                        ->where('payroll_details.month_yr', '=', $data['month_yr'])
                        ->first();

                    // if (!empty($employee_pay_structure)) {
                    //     Session::flash('error', 'Payroll already generated for said period against Employee Code - '.$employee_pay_structure->old_emp_code);
                    // } else {

                        MonthlyEmployeeAllowance::where('month_yr', $sm_month_yr_ctrl[$index])->where('emp_code', $value)->update($data);

                        // $payupdate = array(
                        //     'i_tax' => $data['itax_amount'],
                        //     'updated_at' => date('Y-m-d h:i:s'),
                        // );
                        // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                        Session::flash('message', 'Record Successfully Updated.');

                    // }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-allowances');
        } else {
            return redirect('/');
        }
    }
    public function getMonthlyOvertimes()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['monthlist'] = MonthlyEmployeeOvertime::select('month_yr')->distinct('month_yr')->get();

            $data['result'] = '';
            $payroll_details_rs = '';

            return view('payroll/monthly-overtime', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewMonthlyOvertimes(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->all());

            $payrolldate = explode('/', $request->month);
            //$payroll_date = "0" . ($payrolldate[0] - 2);
            $payroll_date = $payrolldate[0];
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            

            $prevYear=$payrolldate[1];
            $prevMonth=$payrolldate[0];
            if($prevMonth=='01'){
                $prevYear=$payrolldate[1]-1;
                $prevMonth='12';
            }else{
                $prevYear=$payrolldate[1];
                $prevMonth=$payrolldate[0]-1; 
                if($prevMonth<10){
                    $prevMonth=str_pad($prevMonth,2,"0",STR_PAD_LEFT );
                }               
            }
            $datestring_prev = $prevYear . '-' . $prevMonth . '-01';
            
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $datePrev = strtotime($datestring_prev);
            $previous_month_days = date("t", strtotime(date("Y-m-t", $datePrev)));

            //dd($current_month_days . '---'.$previous_month_days);

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";


            $data['monthlist'] = MonthlyEmployeeOvertime::select('month_yr')->distinct('month_yr')->get();

            $data['req_month'] = $request->month;
            $data['current_month_days'] = $current_month_days;
            $data['previous_month_days'] = $previous_month_days;

            $employee_rs = MonthlyEmployeeOvertime::join('employee', 'employee.emp_code', '=', 'monthly_employee_overtimes.emp_code')
                            ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.designation', 'employee.old_emp_code', 'monthly_employee_overtimes.*')
                            ->where('monthly_employee_overtimes.month_yr', $request->month)
                            ->where('monthly_employee_overtimes.status', 'process')
                            ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                            ->get();

            //dd($employee_rs);

            $result = '';
            if (count($employee_rs) == 0) {
                Session::flash('error', 'Overtime for the month ' . $request->month . ' already processed.');
                return redirect('payroll/vw-montly-overtime');
            }
            foreach ($employee_rs as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:50px;" value="' . $emcode->emp_code . '"><input type="hidden" readonly class="form-control sm_curr_mdays" name="curr_mdays' . $emcode->emp_code . '" style="width:100%;" id="curr_mdays_' . $emcode->emp_code . '" value="' . $current_month_days . '"><input type="hidden" readonly class="form-control sm_prev_mdays" name="prev_mdays' . $emcode->emp_code . '" style="width:100%;" id="prev_mdays_' . $emcode->emp_code . '" value="' . $previous_month_days . '"></td>
                                <td>' . $emcode->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100px;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100px;" value="' . $emcode->designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:60px;" value="' . $request->month . '"></td>';

                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_basic" id="basic_' . $emcode->emp_code . '" name="basic' . $emcode->emp_code . '" value="' . $emcode->pay_structure_basic . '"   readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_lm_ot_hrs" id="lm_ot_hrs_' . $emcode->emp_code . '" name="lm_ot_hrs' . $emcode->emp_code . '" value="' . $emcode->last_month_ot_hrs . '" onkeyup="calculate_ot(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_cm_ot_hrs" id="cm_ot_hrs_' . $emcode->emp_code . '" name="cm_ot_hrs' . $emcode->emp_code . '" value="' . $emcode->current_month_ot_hrs . '" onkeyup="calculate_ot(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_lm_ot" id="lm_ot_' . $emcode->emp_code . '" name="lm_ot' . $emcode->emp_code . '" value="' . $emcode->last_month_ot . '" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100px;" class="form-control sm_cm_ot" id="cm_ot_' . $emcode->emp_code . '" name="cm_ot' . $emcode->emp_code . '" value="' . $emcode->curr_month_ot . '" readonly></td>';

                $result .= '<td><input type="number" style="width:100px;" class="form-control sm_e_overtime" name="e_overtime' . $emcode->emp_code . '" step="any" value="' . $emcode->ot_alws . '" id="e_overtime_' . $emcode->emp_code . '" readonly></td>';

            }

            $data['result'] = $result;
            $data['month_yr_new'] = $request->month;
            return view('payroll/monthly-overtime', $data);
        } else {
            return redirect('/');
        }
    }
    public function addMonthlyOvertimesAllemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['result'] = '';

            return view('payroll/add-monthly-overtimes-all', $data);
        } else {
            return redirect('/');
        }
    }
    public function listOvertimesAllemployee(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $payrolldate = explode('/', $request['month_yr']);
            //$payroll_date = "0" . ($payrolldate[0] - 2);
            $payroll_date = $payrolldate[0];
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            

            $prevYear=$payrolldate[1];
            $prevMonth=$payrolldate[0];
            if($prevMonth=='01'){
                $prevYear=$payrolldate[1]-1;
                $prevMonth='12';
            }else{
                $prevYear=$payrolldate[1];
                $prevMonth=$payrolldate[0]-1; 
                if($prevMonth<10){
                    $prevMonth=str_pad($prevMonth,2,"0",STR_PAD_LEFT );
                }               
            }
            $datestring_prev = $prevYear . '-' . $prevMonth . '-01';
            
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $datePrev = strtotime($datestring_prev);
            $previous_month_days = date("t", strtotime(date("Y-m-t", $datePrev)));

            //dd($current_month_days . '---'.$previous_month_days);

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();

            $result = '';


            $emplist = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
                        ->select('employee.*', 'process_attendances.*')
                        ->where('process_attendances.month_yr', '=', $request['month_yr'])
                        ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                        ->where('employee.status', 'active')
                        ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                        ->get();

            if (count($emplist) == 0) {
                Session::flash('error', 'Please process the attandance for the month before generating overtimes.');
                return redirect('payroll/add-montly-overtimes');
            }

            foreach ($emplist as $mainkey => $emcode) {

                $process_payroll = $this->getEmpPayroll($emcode->emp_code, $payrolldate[0], $payrolldate[1]);
                $process_payroll = json_decode($process_payroll);

                //dd($process_payroll);

                $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                    ->where('employee.emp_code', '=', $emcode->emp_code)
                    ->select('employee.*', 'employee_pay_structures.*')
                    ->first();

                $e_overtime = 0;
                $e_overtime_show = '';

                $calculate_basic_salary = $employee_rs->basic_pay;

                



                // $cal_tiff_alw = $e_tiffalw;
                // $tot_wdays = $emcode->no_of_present + $emcode->no_of_days_leave_taken + $emcode->no_of_days_absent;

                // $perday_tiffalw = $e_tiffalw / $tot_wdays;
                // $cal_tiff_alw = round(($perday_tiffalw * $emcode->no_of_present), 2);

                // $cal_conv_alw = $e_conv;
                // $perday_convalw = $e_conv / $tot_wdays;
                // $cal_conv_alw = round(($perday_convalw * $emcode->no_of_present), 2);

                // $cal_misc_alw = $e_miscalw;
                // $perday_miscalw = $e_miscalw / $tot_wdays;
                // $cal_misc_alw = round(($perday_miscalw * $emcode->no_of_present), 2);

                //dd($current_month_days . '---'.$previous_month_days);


                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_code . '"><input type="hidden" readonly class="form-control sm_curr_mdays" name="curr_mdays' . $emcode->emp_code . '" style="width:100%;" id="curr_mdays_' . $emcode->emp_code . '" value="' . $current_month_days . '"><input type="hidden" readonly class="form-control sm_prev_mdays" name="prev_mdays' . $emcode->emp_code . '" style="width:100%;" id="prev_mdays_' . $emcode->emp_code . '" value="' . $previous_month_days . '"></td>
                                <td>' . $employee_rs->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->emp_fname . ' ' . $employee_rs->emp_mname . ' ' . $employee_rs->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $employee_rs->designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>';

                $result .= '<td><input type="text" style="width:100%;" class="form-control sm_basic" id="basic_' . $emcode->emp_code . '" name="basic' . $emcode->emp_code . '" value="' . $calculate_basic_salary . '"  onkeyup="calculate_days(' . $emcode->emp_code . ');" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100%;" class="form-control sm_lm_ot_hrs" id="lm_ot_hrs_' . $emcode->emp_code . '" name="lm_ot_hrs' . $emcode->emp_code . '" value="0" onkeyup="calculate_ot(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100%;" class="form-control sm_cm_ot_hrs" id="cm_ot_hrs_' . $emcode->emp_code . '" name="cm_ot_hrs' . $emcode->emp_code . '" value="0" onkeyup="calculate_ot(' . $emcode->emp_code . ');"></td>';

                $result .= '<td><input type="number" step="any" style="width:100%;" class="form-control sm_lm_ot" id="lm_ot_' . $emcode->emp_code . '" name="lm_ot' . $emcode->emp_code . '" value="0" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100%;" class="form-control sm_cm_ot" id="cm_ot_' . $emcode->emp_code . '" name="cm_ot' . $emcode->emp_code . '" value="0" readonly></td>';

                $result .= '<td><input type="number" step="any" style="width:100%;" class="form-control sm_e_overtime" name="e_overtime' . $emcode->emp_code . '" value="0" id="e_overtime_' . $emcode->emp_code . '" readonly></td>';

                
                
                // print_r($result);
                // die();
            }
            // print_r($result);
            // die();
            
            $month_yr_new = $request['month_yr'];
            return view('payroll/add-monthly-overtimes-all', compact('result', 'month_yr_new','current_month_days','previous_month_days'));
        } else {
            return redirect('/');
        }
    }
    public function SaveOvertimesAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->cboxes);
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_basic_ctrl = explode(',', $request->sm_basic_ctrl);
                $sm_lm_ot_hrs_ctrl = explode(',', $request->sm_lm_ot_hrs_ctrl);
                $sm_cm_ot_hrs_ctrl = explode(',', $request->sm_cm_ot_hrs_ctrl);
                $sm_lm_ot_ctrl = explode(',', $request->sm_lm_ot_ctrl);

                $sm_cm_ot_ctrl = explode(',', $request->sm_cm_ot_ctrl);
                $sm_e_overtime_ctrl = explode(',', $request->sm_e_overtime_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];

                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['pay_structure_basic'] = $sm_basic_ctrl[$index];
                    $data['last_month_ot_hrs'] = $sm_lm_ot_hrs_ctrl[$index];
                    $data['current_month_ot_hrs'] = $sm_cm_ot_hrs_ctrl[$index];
                    $data['last_month_ot'] = $sm_lm_ot_ctrl[$index];

                    $data['curr_month_ot'] = $sm_cm_ot_ctrl[$index];
                    $data['ot_alws'] = $sm_e_overtime_ctrl[$index];

                    $data['status'] = 'process';
                    $data['created_at'] = date('Y-m-d');

                    // if ($value == '7050') {

                    //     dd($data);
                    // }

                    $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                        ->where('month_yr', '=', $data['month_yr'])
                        ->first();

                    //dd($employee_pay_structure);

                    if (!empty($employee_pay_structure)) {
                        Session::flash('error', 'Payroll already generated for said period');
                    } else {

                        $monthlyEmployeeOvertime = MonthlyEmployeeOvertime::where('emp_code', '=', $value)
                            ->where('month_yr', '=', $data['month_yr'])
                            ->first();

                        //dd($monthlyEmployeeOvertime);

                        if (!empty($monthlyEmployeeOvertime)) {
                            MonthlyEmployeeOvertime::where('month_yr', $sm_month_yr_ctrl[$index])->where('emp_code', $value)->update($data);
                            Session::flash('message', 'Record Successfully Saved.');
                            // Session::flash('error', 'Record Already provided for said period for employee - ' . $value);
                        } else {
                            //dd($data);
                            MonthlyEmployeeOvertime::insert($data);
                            // $payupdate = array(
                            //     'i_tax' => $data['itax_amount'],
                            //     'updated_at' => date('Y-m-d h:i:s'),
                            // );
                            // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                            Session::flash('message', 'Record Successfully Saved.');
                        }

                    }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-overtime');
        } else {
            return redirect('/');
        }
    }
    public function UpdateOvertimesAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            // dd($request->cboxes);

            $request->status=$request->statusme;

            if (isset($request->deleteme) && $request->deleteme == 'yes') {

                $employee_payroll = Payroll_detail::where('month_yr', '=', $request->deletemy)->get();
                if (count($employee_payroll) > 0) {
                    Session::flash('error', 'Records cannot be deleted as payroll for the month already generated.');
                    return redirect('payroll/vw-montly-overtime');
                }

                MonthlyEmployeeOvertime::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated records deleted successfully.');
                return redirect('payroll/vw-montly-overtime');
            }

            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_basic_ctrl = explode(',', $request->sm_basic_ctrl);
                $sm_lm_ot_hrs_ctrl = explode(',', $request->sm_lm_ot_hrs_ctrl);
                $sm_cm_ot_hrs_ctrl = explode(',', $request->sm_cm_ot_hrs_ctrl);
                $sm_lm_ot_ctrl = explode(',', $request->sm_lm_ot_ctrl);

                $sm_cm_ot_ctrl = explode(',', $request->sm_cm_ot_ctrl);
                $sm_e_overtime_ctrl = explode(',', $request->sm_e_overtime_ctrl);


                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['emp_code'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    // $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];
                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    $data['pay_structure_basic'] = $sm_basic_ctrl[$index];
                    $data['last_month_ot_hrs'] = $sm_lm_ot_hrs_ctrl[$index];
                    $data['current_month_ot_hrs'] = $sm_cm_ot_hrs_ctrl[$index];
                    $data['last_month_ot'] = $sm_lm_ot_ctrl[$index];

                    $data['curr_month_ot'] = $sm_cm_ot_ctrl[$index];
                    $data['ot_alws'] = $sm_e_overtime_ctrl[$index];

                    $data['status'] = $request->status==''?'process':$request->status;
                    $data['updated_at'] = date('Y-m-d');

                    // dd($data);

                    // $employee_pay_structure = Payroll_detail::where('employee_id', '=', $value)
                    //     ->where('month_yr', '=', $data['month_yr'])
                    //     ->first();
                    $employee_pay_structure = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                        ->select('employee.old_emp_code', 'payroll_details.*')
                        ->where('payroll_details.employee_id', '=', $value)
                        ->where('payroll_details.month_yr', '=', $data['month_yr'])
                        ->first();

                    if (!empty($employee_pay_structure)) {
                        
                         Session::flash('error', 'Payroll already generated for said period against Employee Code - '.$employee_pay_structure->old_emp_code);
                    } else {

                        MonthlyEmployeeOvertime::where('month_yr', $sm_month_yr_ctrl[$index])->where('emp_code', $value)->update($data);

                        // $payupdate = array(
                        //     'i_tax' => $data['itax_amount'],
                        //     'updated_at' => date('Y-m-d h:i:s'),
                        // );
                        // Employee_pay_structure::where('employee_code', $value)->update($payupdate);
                        Session::flash('message', 'Record Successfully Updated.');

                    }

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('payroll/vw-montly-overtime');
        } else {
            return redirect('/');
        }
    }
    public function getPayroll()
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['rate_master'] = Rate_master::get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['result'] = '';
            return view('payroll/view-payroll-generation', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewPayroll()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();
            return view('payroll/single-payroll-generation', $data);
        } else {
            return redirect('/');
        }  
    }
    public function showPayroll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['payroll_rs'] = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                ->select('employee.old_emp_code', 'payroll_details.*')
                ->where('payroll_details.month_yr','=',$request->month)
                ->get();
            $data['rate_master'] = Rate_master::get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month']=$request->month;
            //dd($data['payroll_rs'][0]);
            return view('payroll/view-payroll-generation', $data);
        } else {
            return redirect('/');
        }
    }
    public function savePayrollDetails(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            if (empty($request->emp_gross_salary)) {
                Session::flash('message', 'Gross Salary Cannot be Blank.');
                return redirect('payroll/vw-payroll-generation');
            }

            if (empty($request->emp_total_deduction)) {

                Session::flash('message', 'Total Salary Cannot be Blank.');
                return redirect('payroll/vw-payroll-generation');
            }

            if (empty($request->emp_net_salary)) {

                Session::flash('message', 'Net Salary Cannot be Blank.');
                return redirect('payroll/vw-payroll-generation');
            }

            $monthyr = $request->month_yr;
            $mnt_yr = date('m/Y', strtotime("$monthyr"));
        
            $data['employee_id'] = $request->empname;
            $data['emp_name'] = $request->emp_name;
            $data['emp_designation'] = $request->emp_designation;
            $data['emp_basic_pay'] = $request->emp_basic_pay;
            $data['month_yr'] = $mnt_yr;
            $data['emp_present_days'] = $request->emp_present_days;
            $data['emp_cl'] = $request->emp_cl;
            $data['emp_el'] = $request->emp_el;
            $data['emp_hpl'] = $request->emp_hpl;
            $data['emp_absent_days'] = $request->emp_absent_days;
            $data['emp_rh'] = $request->emp_rh;
            $data['emp_cml'] = $request->emp_cml;
            $data['emp_eol'] = $request->emp_eol;
            $data['emp_lnd'] = $request->emp_lnd;
            $data['emp_maternity_leave'] = $request->emp_maternity_leave;
            $data['emp_paternity_leave'] = $request->emp_paternity_leave;
            $data['emp_ccl'] = $request->emp_ccl;
            $data['emp_el'] = $request->emp_el;
            $data['emp_da'] = $request->emp_da;
            $data['emp_vda'] = $request->emp_vda;
            $data['emp_hra'] = $request->emp_hra;
            $data['emp_prof_tax'] = $request->emp_prof_tax;
            $data['emp_others_alw'] = $request->emp_others_alw;
            $data['emp_tiff_alw'] = $request->emp_tiff_alw;
            $data['emp_conv'] = $request->emp_conv;
            $data['emp_medical'] = $request->emp_medical;
            $data['emp_misc_alw'] = $request->emp_misc_alw;
            $data['emp_over_time'] = $request->emp_over_time;
            $data['emp_bouns'] = $request->emp_bouns;
            $data['emp_pf'] = $request->emp_pf;
            $data['emp_pf_int'] = $request->emp_pf_int;
            $data['emp_co_op'] = $request->emp_co_op;
            $data['emp_apf'] = $request->emp_apf;
            $data['emp_i_tax'] = $request->emp_i_tax;
            $data['emp_insu_prem'] = $request->emp_insu_prem;
            $data['emp_pf_loan'] = $request->emp_pf_loan;
            $data['emp_esi'] = $request->emp_esi;
            $data['emp_adv'] = $request->emp_adv;
            $data['emp_absent_deduction'] = $request->emp_absent_deduction;
            $data['emp_gross_salary'] = $request->emp_gross_salary;
            $data['emp_hrd'] = $request->emp_hrd;
            $data['emp_gross_salary'] = $request->emp_gross_salary;
            $data['emp_total_deduction'] = $request->emp_total_deduction;
            $data['emp_net_salary'] = $request->emp_net_salary;
            $data['emp_furniture'] = $request->emp_furniture;
            $data['emp_pf_employer'] = $request->emp_pf_employer;
            $data['emp_misc_ded'] = $request->emp_misc_ded;
            $data['emp_leave_inc'] = $request->emp_leave_inc;
            $data['emp_hta'] = $request->emp_hta;
            $data['emp_income_tax'] = $request->emp_income_tax;
            $data['other_deduction'] = $request->other_deduction;
            $data['other_addition'] = $request->other_addition;
            $data['proces_status'] = 'process';
            $data['created_at'] = date('Y-m-d');
            $status['status_of_co_op']=$request->status_co;

            $employee_pay_structure = Payroll_detail::where('employee_id', '=', $request->empname)
                ->where('month_yr', '=', $mnt_yr)
                ->first();


            if($request->emp_present_days == '0'){
                Session::flash('error', 'salary not genereated due to insufficient attendance "' .$mnt_yr . '". ');
            }else{
                if (!empty($employee_pay_structure)) {
                    
                    Payroll_detail::where('month_yr', $mnt_yr)->where('employee_id', $request->empname)->update($data);
                    MonthlyEmployeeCooperative::where('month_yr', $mnt_yr)->where('emp_code', $request->empname)->update($status);

                    Session::flash('message', 'Record Successfully updated.');
    
                //   Session::flash('message', 'Payroll for this employee already generated for the month of "' . date('m-Y') . '". ');
                }
                
                else {
                    
    
                    Payroll_detail::insert($data);
                    MonthlyEmployeeCooperative::where('month_yr', $mnt_yr)->where('emp_code', $request->empname)->update($status);

                     $salary_adv_loan=$this->getLoanDeductionValue($request->empname,'SA',$mnt_yr);
                    $pf_loan=$this->getLoanDeductionValue($request->empname,'PF',$mnt_yr);
                     $pf_loan_balance=$this->getTotalLoanBalanceValue($request->empname,'PF',$mnt_yr);
                    
    
                    if(!empty($salary_adv_loan)){
                        foreach($salary_adv_loan as $rec){
                            $loanRecovery = new LoanRecovery;
                            $loanRecovery->loan_id = $rec['id'];
                            $loanRecovery->amount = $rec['installment_amount'];
                            $loanRecovery->payout_month = $mnt_yr;
                            $loanRecovery->save();
                        }
                    }
    
                    if(!empty($pf_loan)){
                        foreach($pf_loan as $rec){
                            $loanRecovery = new LoanRecovery;
                            $loanRecovery->loan_id = $rec['id'];
                            $loanRecovery->amount = $rec['installment_amount'];
                            $loanRecovery->payout_month = $mnt_yr;
                            $loanRecovery->save();
                        }
                    }
    
    
                    $check_gpf = $this->checkGpfEligibility($data['employee_id']);
    
                    if (isset($check_gpf->pf) && $check_gpf->pf == '1') {
                        //$this->npsMonthlyEnty($data);
                        $this->gpfMonthlyEnty($data);
                    }
    
                    Session::flash('message', 'Payroll Information Successfully Saved.');
                }
            }

            return redirect('payroll/vw-payroll-generation');
        } else {
            return redirect('/');
        }
    }
    public function getPayrollallemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['rate_master'] = Rate_master::get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();

            return view('payroll/payroll-generation-all-employee', $data);
        } else {
            return redirect('/');
        }
    }
    public function showPayrollallemployee(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            //$data['payroll_rs'] = Payroll_detail::get();
            $data['payroll_rs'] = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                                ->select('employee.old_emp_code', 'payroll_details.*')
                                ->where('payroll_details.month_yr', '=', $request->month)
                                ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                                ->get();

            $data['rate_master'] = Rate_master::get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['req_month']=$request->month;

            return view('payroll/payroll-generation-all-employee', $data);
        } else {
            return redirect('/');
        }
    }
    public function addPayrollallemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['result'] = '';

            return view('payroll/generate-payroll-all', $data);
        } else {
            return redirect('/');
        }
    }
    public function listPayrollallemployee(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $payrolldate = explode('/', $request['month_yr']);
            //$payroll_date = "0" . ($payrolldate[0] - 2);
            $payroll_date = $payrolldate[0];
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
                ->select('rate_details.*', 'rate_masters.head_name')
                ->get();

            //Already generated payrolls of the month
            $already_payroll_generated = Payroll_detail::where('month_yr','=',$request['month_yr'])
                ->pluck('employee_id');

            //dd($already_payroll_generated);

            //Get Salary Adjust Attandance emp
            $process_attendance_emp = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
                ->where('employee.emp_status', '!=', 'TEMPORARY')
                ->where('employee.status', '=', 'active')
                ->where('process_attendances.no_sal_adjust_days', '>', 0)
                ->where('process_attendances.month_yr', '=', $request['month_yr'])
                ->pluck('employee_code');
           

            //Get Monthly Attandance count
            $process_attendance_count = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
                ->where('employee.emp_status', '!=', 'TEMPORARY')
                ->where('employee.status', '=', 'active')
                ->where('process_attendances.month_yr', '=', $request['month_yr'])
                 ->whereNotIn('process_attendances.employee_code', $process_attendance_emp)
                // ->whereNotIn('process_attendances.employee_code', $already_payroll_generated)
                ->count();
               

            //Get Monthly Cooperative count
            $process_cooperative_count = MonthlyEmployeeCooperative::join('employee', 'employee.emp_code', '=', 'monthly_employee_cooperatives.emp_code')
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
                ->where('employee.emp_status', '!=', 'TEMPORARY')
                ->where('employee.status', '=', 'active')
                ->where('monthly_employee_cooperatives.month_yr', '=', $request['month_yr'])
                 ->whereNotIn('monthly_employee_cooperatives.emp_code', $process_attendance_emp)
                //  ->whereNotIn('monthly_employee_cooperatives.emp_code', $already_payroll_generated)
                ->count();
               
                

            //Get Monthly incometax count
            $process_incometax_count = MonthlyEmployeeItax::join('employee', 'employee.emp_code', '=', 'monthly_employee_itaxes.emp_code')
            ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
            ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            ->where('employee.emp_status', '!=', 'TEMPORARY')
            ->where('employee.status', '=', 'active')
            ->where('monthly_employee_itaxes.month_yr', '=', $request['month_yr'])
             ->whereNotIn('monthly_employee_itaxes.emp_code', $process_attendance_emp)
            // ->whereNotIn('monthly_employee_itaxes.emp_code', $already_payroll_generated)
            ->count();

            //Get Monthly allowances count
            $process_allowances_count = MonthlyEmployeeAllowance::join('employee', 'employee.emp_code', '=', 'monthly_employee_allowances.emp_code')
            ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
            ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            ->where('employee.emp_status', '!=', 'TEMPORARY')
            ->where('employee.status', '=', 'active')
            ->where('monthly_employee_allowances.month_yr', '=', $request['month_yr'])
            ->whereNotIn('monthly_employee_allowances.emp_code', $process_attendance_emp)
            // ->whereNotIn('monthly_employee_allowances.emp_code', $already_payroll_generated)
            ->count();

            //Get Monthly overtime count
            $process_overtimes_count = MonthlyEmployeeOvertime::join('employee', 'employee.emp_code', '=', 'monthly_employee_overtimes.emp_code')
            ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
            ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            ->where('employee.emp_status', '!=', 'TEMPORARY')
            ->where('employee.status', '=', 'active')
            ->where('monthly_employee_overtimes.month_yr', '=', $request['month_yr'])
            ->whereNotIn('monthly_employee_overtimes.emp_code', $process_attendance_emp)
            // ->whereNotIn('monthly_employee_overtimes.emp_code', $already_payroll_generated)
            ->count();

            $effective_pfloan_interest_rate = $this->getEffectivePFLoanInterestRate($request['month_yr']);
            
            if(isset($effective_pfloan_interest_rate) && $effective_pfloan_interest_rate==''){
                $effective_pfloan_interest_rate=9.1;
            }
           

            $result = '';

            $emplist = Employee::where('employee.status', '=', 'active')
                        ->where('employee.emp_status', '!=', 'TEMPORARY')
                        ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                        ->whereNotIn('employee.emp_code', $process_attendance_emp)
                        ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                        ->get();
            
            foreach ($emplist as $mainkey => $emcode) {

                $process_payroll = $this->getEmpPayroll($emcode->emp_code, $payrolldate[0], $payrolldate[1]);
                $process_payroll = json_decode($process_payroll);

                //dd($emcode);

                //Get Monthly Attandance values
                $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $emcode->emp_code)
                    ->where('process_attendances.month_yr', '=', $request['month_yr'])
                    ->first();

                //Get Monthly Cooperative values
                $process_cooperative = MonthlyEmployeeCooperative::where('monthly_employee_cooperatives.emp_code', '=', $emcode->emp_code)
                    ->where('monthly_employee_cooperatives.month_yr', '=', $request['month_yr'])
                    ->first();

                //Get Monthly incometax values
                 $process_incometax = MonthlyEmployeeItax::where('monthly_employee_itaxes.emp_code', '=', $emcode->emp_code)
                    ->where('monthly_employee_itaxes.month_yr', '=', $request['month_yr'])
                    ->first();
                // $emcode->setAttribute('process_incometax',$process_incometax);
                    // dd($process_incometax);

                //Get Monthly allowances values
                $process_allowances = MonthlyEmployeeAllowance::where('monthly_employee_allowances.emp_code', '=', $emcode->emp_code)
                    ->where('monthly_employee_allowances.month_yr', '=', $request['month_yr'])
                    ->first();

                //Get Monthly overtimes values
                $process_overtimes = MonthlyEmployeeOvertime::where('monthly_employee_overtimes.emp_code', '=', $emcode->emp_code)
                    ->where('monthly_employee_overtimes.month_yr', '=', $request['month_yr'])
                    ->first();

                $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                    ->where('employee.emp_code', '=', $emcode->emp_code)
                    ->select('employee.*', 'employee_pay_structures.*')
                    ->first();

                $leave_rs = Leave_apply::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applies.leave_type')
                    ->where('leave_applies.employee_id', '=', $emcode->emp_code)
                    ->where('leave_applies.status', '=', 'APPROVED')
                    ->whereBetween('leave_applies.from_date', array($formatmonthyr, $tomonthyr))
                    ->orwhereBetween('leave_applies.to_date', array($formatmonthyr, $tomonthyr))
                    ->select('leave_applies.*', 'leave_types.leave_type_name')
                    ->get();

                $previous_payroll = Payroll_detail::where('employee_id', '=', $emcode->emp_code)
                //->where('month_yr','<',$request['month_yr'])
                    ->orderBy('month_yr', 'desc')
                    ->first();

                                    

                $tot_cl = $tot_el = $tot_hpl = $tot_rh = $tot_cml = $tot_eol = $tot_ml = $tot_pl = $tot_ccl = $tot_tl = 0;
                foreach ($leave_rs as $ky => $val) {

                    if ($val->employee_id == $emcode->emp_code) {

                        if ($val->leave_type_name == 'CASUAL LEAVE') {

                            $frommonth = date("m", strtotime($val->from_date));
                            $tomonth = date("m", strtotime($val->to_date));
                            if ($frommonth == $tomonth) {
                                $tot_cl = $val->no_of_leave;
                            } else {

                                $to = \Carbon\Carbon::createFromFormat('Y-m-d', $tomonthyr);
                                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $val->to_date);
                                $diff_in_days = $to->diffInDays($val->from_date);
                                $tot_cl = ($diff_in_days) + 1;
                            }
                        }

                        if ($val->leave_type_name == 'EARNED LEAVE') {
                            $frommonth = date("m", strtotime($val->from_date));
                            $tomonth = date("m", strtotime($val->to_date));
                            if ($frommonth == $tomonth) {
                                $tot_el = $val->no_of_leave;
                            } else {
                                $to = \Carbon\Carbon::createFromFormat('Y-m-d', $tomonthyr);
                                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $val->to_date);
                                $diff_in_days = $to->diffInDays($val->from_date);
                                $tot_el = ($diff_in_days) + 1;
                            }
                        }

                        if ($val->leave_type_name == 'HALF PAY LEAVE') {

                            $frommonth = date("m", strtotime($val->from_date));
                            $tomonth = date("m", strtotime($val->to_date));
                            if ($frommonth == $tomonth) {
                                $tot_hpl = $val->no_of_leave;
                            } else {
                                $to = \Carbon\Carbon::createFromFormat('Y-m-d', $tomonthyr);
                                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $val->to_date);
                                $diff_in_days = $to->diffInDays($val->from_date);
                                $tot_hpl = ($diff_in_days) + 1;
                            }
                        }

                        if ($val->leave_type_name == 'MEDICAL LEAVE') {
                            $frommonth = date("m", strtotime($val->from_date));
                            $tomonth = date("m", strtotime($val->to_date));
                            if ($frommonth == $tomonth) {
                                $tot_ml = $val->no_of_leave;
                            } else {
                                $to = \Carbon\Carbon::createFromFormat('Y-m-d', $tomonthyr);
                                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $val->to_date);
                                $diff_in_days = $to->diffInDays($val->from_date);
                                $tot_ml = ($diff_in_days) + 1;
                            }
                        }

                        if ($val->leave_type_name == 'TOUR LEAVE') {
                            $frommonth = date("m", strtotime($val->from_date));
                            $tomonth = date("m", strtotime($val->to_date));
                            if ($frommonth == $tomonth) {
                                $tot_tl = $val->no_of_leave;
                            } else {
                                $to = \Carbon\Carbon::createFromFormat('Y-m-d', $tomonthyr);
                                $from = \Carbon\Carbon::createFromFormat('Y-m-d', $val->to_date);
                                $diff_in_days = $to->diffInDays($val->from_date);
                                $tot_tl = ($diff_in_days) + 1;
                            }
                        }
                    }
                }

                if (empty($process_attendance)) {

                    $calculate_basic_salary = $employee_rs->basic_pay;
                    $no_of_working_days = 0;
                    $no_of_present = 0;
                    $no_of_days_absent = 0;
                    $no_of_days_salary = 0;
                } else {

                    $calculate_basic_salary = ($employee_rs->basic_pay / $current_month_days) * ($process_attendance->no_of_working_days - $process_attendance->no_of_days_absent);

                    $calculate_basic_salary = round($calculate_basic_salary,2);

                    $no_of_working_days = $process_attendance->no_of_working_days;
                    $no_of_present = $process_attendance->no_of_present;
                    $no_of_days_absent = $process_attendance->no_of_days_absent;
                    $no_of_days_salary = $process_attendance->no_of_days_salary;
                }

                //Earnings
                $e_da = 0;
                $e_da_show = '';
                $e_vda = 0;
                $e_vda_show = '';
                $e_hra = 0;
                $e_hra_show = '';
                $e_tiffalw = 0;
                $e_tiffalw_show = '';
                $e_othalw = 0;
                $e_othalw_show = '';
                $e_conv = 0;
                $e_conv_show = '';
                $e_medical = 0;
                $e_medical_show = '';
                $e_miscalw = 0;
                $e_miscalw_show = '';
                $e_overtime = 0;
                $e_overtime_show = '';
                $e_bonus = 0;
                $e_bonus_show = '';
                $e_leaveenc = 0;
                $e_leaveenc_show = '';
                $e_hta = 0;
                $e_hta_show = '';
                $e_others = 0;
                $e_others_show = '';

                //Deductions
                $d_proftax = 0;
                $d_proftax_show = '';
                $d_pf = 0;
                $d_pf_show = '';
                $d_pfint = 0;
                $d_pfint_show = '';
                $d_apf = 0;
                $d_apf_show = '';
                $d_itax = 0;
                $d_itax_show = '';
                $d_insuprem = 0;
                $d_insuprem_show = '';
                $d_pfloan = 0;
                $d_pfloan_show = '';
                $d_esi = 0;
                $d_esi_show = '';
                $d_adv = 0;
                $d_adv_show = '';
                $d_hrd = 0;
                $d_hrd_show = '';
                $d_coop = 0;
                $d_coop_show = '';
                $d_furniture = 0;
                $d_furniture_show = '';
                $d_pf_employer = 0;
                $d_pf_employer_show = '';
                $d_miscded = 0;
                $d_miscded_show = '';
                $d_incometax = 0;
                $d_incometax_show = '';
                $d_others = 0;
                $d_others_show = '';

                //dd($process_payroll);
      //   $return_pf_int = [];
                for ($j = 0; $j < sizeof($process_payroll[3]); $j++) {


                    //DA
                    if ($process_payroll[3][$j]->rate_id == '1') {

                        if ($process_payroll[0]->da == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $emp_da = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $emp_da = round($emp_da,2);
                                $e_da = $emp_da;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_da = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_da_show = 'readonly';
                        } else if ($process_payroll[0]->da != null && $process_payroll[0]->da != '') {

                            $e_da = $process_payroll[0]->da;
                            //$e_da_show = '';

                        } else {
                            $emp_da = 0;
                            $e_da = $emp_da;
                            $e_da_show = 'readonly';
                        }
                    }

                    //vda
                    if ($process_payroll[3][$j]->rate_id == '2') {
                        if ($process_payroll[0]->vda == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $emp_vda = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);

                                $emp_vda = round($emp_vda,2);

                                $e_vda = $emp_vda;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_vda = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_vda_show = "readonly";
                        } else if ($process_payroll[0]->vda != null && $process_payroll[0]->vda != '') {
                            $e_vda = $process_payroll[0]->vda;
                            //$e_vda_show = "";
                        } else {
                            $emp_vda = 0;
                            $e_vda = $emp_vda;
                            $e_vda_show = "readonly";
                        }
                    }

                    //hra
                    if ($process_payroll[3][$j]->rate_id == '3') {
                        if ($process_payroll[0]->hra == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $emp_hra = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $emp_hra = round($emp_hra,0);
                                $e_hra = $emp_hra;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_hra = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_hra_show = "readonly";
                        } else if ($process_payroll[0]->hra != null && $process_payroll[0]->hra != '') {
                            
                            //$e_hra_show = "";
                            if($process_payroll[0]->hra_type=='V'){
                               // $emp_hra = 0;
                               $e_hra = $process_payroll[0]->hra;
                               $e_hra_show = "readonly";
                               if($e_hra > 0 && $no_of_working_days>0){
                                    $valc = ($e_hra / $no_of_working_days);
                                    $valc = ($valc*$no_of_days_salary);
                                    $valc = round($valc,2);
                                    $e_hra = $valc;

                               }else{
                                    $e_hra = 0;
                               }
                               
                            }else{

                                if ($process_payroll[3][$j]->inpercentage != '0') {
                                    $emp_hra = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                    $emp_hra = round($emp_hra,0);
                                    $e_hra = $emp_hra;
                                } else {
                                    if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                        $e_hra = $process_payroll[3][$j]->inrupees;
                                    }else{
                                        $e_hra = $process_payroll[0]->hra;
                                    }
                                }
                                $e_hra_show = "readonly";
                            }
                        } else {
                            $emp_hra = 0;
                            $e_hra = $emp_hra;
                            $e_hra_show = "readonly";
                        }
                    }

                    //other alw
                    if ($process_payroll[3][$j]->rate_id == '5') {
                        if ($process_payroll[0]->others_alw == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_othalw = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_othalw = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_othalw_show = "readonly";
                        } else if ($process_payroll[0]->others_alw != null && $process_payroll[0]->others_alw != '') {
                            $e_othalw = $process_payroll[0]->others_alw;
                            //$e_othalw_show = "";
                            if($process_payroll[0]->others_alw_type=='V'){
                                if($no_of_days_absent>0){
                                    $valc = ($process_payroll[0]->others_alw / $no_of_working_days);
                                    $valc = ($valc*$no_of_days_salary);
                                    $valc = round($valc,2);
                                    $e_othalw = $valc;
                                }else{
                                    // $emp_hra = 0;
                                    $e_othalw = $process_payroll[0]->others_alw;
                                    // $e_hra_show = "readonly";
                                }
                            }else{
 
                                if ($process_payroll[3][$j]->inpercentage != '0') {
                                    $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                    $valc = round($valc,2);
                                    $e_othalw = $valc;
                                } else {
                                    if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                        $e_othalw = $process_payroll[3][$j]->inrupees;
                                    }
                                }
                                $e_othalw_show = "readonly";
                            }
 
                        } else {
                            $valc = 0;
                            $e_othalw = $valc;
                            $e_othalw_show = "readonly";
                        }
                    }

                    //tiff alw
                    if ($process_payroll[3][$j]->rate_id == '6') {
                        if ($process_payroll[0]->tiff_alw == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_tiffalw = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_tiffalw = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_tiffalw_show = "readonly";
                        } else if ($process_payroll[0]->tiff_alw != null && $process_payroll[0]->tiff_alw != '') {
                            $e_tiffalw = $process_payroll[0]->tiff_alw;
                            $e_tiffalw_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_tiffalw = $valc;
                            $e_tiffalw_show = "readonly";
                        }
                    }

                    //conv
                    if ($process_payroll[3][$j]->rate_id == '7') {
                        if ($process_payroll[0]->conv == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_conv = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_conv = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_conv_show = "readonly";
                        } else if ($process_payroll[0]->conv != null && $process_payroll[0]->conv != '') {
                            $e_conv = $process_payroll[0]->conv;
                            $e_conv_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_conv = $valc;
                            $e_conv_show = "readonly";
                        }
                    }

                    //medical
                    if ($process_payroll[3][$j]->rate_id == '8') {
                        if ($process_payroll[0]->medical == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($employee_rs->basic_pay * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_medical = $valc;
                            } else {
                                if (($employee_rs->basic_pay<= $process_payroll[3][$j]->max_basic) && ($employee_rs->basic_pay >= $process_payroll[3][$j]->min_basic)) {
                                    $e_medical = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_medical_show = "readonly";
                        } else if ($process_payroll[0]->medical != null && $process_payroll[0]->medical != '') {
                            $e_medical = $process_payroll[0]->medical;
                            // $e_medical_show = "";
                        } else {
                            $valc = 0;
                            $e_medical = $valc;
                            $e_medical_show = "readonly";
                        }
                    }

                    //misc_alw
                    if ($process_payroll[3][$j]->rate_id == '9') {
                        if ($process_payroll[0]->misc_alw == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_miscalw = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_miscalw = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_miscalw_show = "readonly";
                        } else if ($process_payroll[0]->misc_alw != null && $process_payroll[0]->misc_alw != '') {
                            $e_miscalw = $process_payroll[0]->misc_alw;
                            $e_miscalw_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_miscalw = $valc;
                            $e_miscalw_show = "readonly";
                        }
                    }

                    //over_time
                    if ($process_payroll[3][$j]->rate_id == '10') {
                        if ($process_payroll[0]->over_time == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_overtime = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_overtime = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_overtime_show = "readonly";
                        } else if ($process_payroll[0]->over_time != null && $process_payroll[0]->over_time != '') {
                            $e_overtime = $process_payroll[0]->over_time;
                            $e_overtime_show = "readonly";
                        } else {
                            $valc = 0;
                            $e_overtime = $valc;
                            $e_overtime_show = "readonly";
                        }
                    }

                    //bouns
                    if ($process_payroll[3][$j]->rate_id == '11') {
                        if ($process_payroll[0]->bouns == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_bonus = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_bonus = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_bonus_show = "readonly";
                        } else if ($process_payroll[0]->bouns != null && $process_payroll[0]->bouns != '') {
                            $e_bonus = $process_payroll[0]->bouns;
                            //      $e_bonus_show = "";
                        } else {
                            $valc = 0;
                            $e_bonus = $valc;
                            $e_bonus_show = "readonly";
                        }
                    }

                    //leave_inc
                    if ($process_payroll[3][$j]->rate_id == '12') {
                        if ($process_payroll[0]->leave_inc == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_leaveenc = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_leaveenc = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_leaveenc_show = "readonly";
                        } else if ($process_payroll[0]->leave_inc != null && $process_payroll[0]->leave_inc != '') {
                            $e_leaveenc = $process_payroll[0]->leave_inc;
                            //                           $e_leaveenc_show = "";
                        } else {
                            $valc = 0;
                            $e_leaveenc = $valc;
                            $e_leaveenc_show = "readonly";
                        }
                    }

                    //hta
                    if ($process_payroll[3][$j]->rate_id == '13') {
                        if ($process_payroll[0]->hta == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $e_hta = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $e_hta = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $e_hta_show = "readonly";
                        } else if ($process_payroll[0]->hta != null && $process_payroll[0]->hta != '') {
                            $e_hta = $process_payroll[0]->hta;
                            //                           $e_hta_show = "";
                        } else {
                            $valc = 0;
                            $e_hta = $valc;
                            $e_hta_show = "readonly";
                        }
                    }

                    //pf
                    // if ($process_payroll[3][$j]->rate_id == '15') {
                    //     if ($process_payroll[0]->pf == '1') {
                    //         if ($process_payroll[3][$j]->inpercentage != '0') {
                    //             $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                    //             $valc = round($valc,2);
                    //             $d_pf = $valc;
                    //         } else {
                    //             if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                    //                 $d_pf = $process_payroll[3][$j]->inrupees;
                    //             }
                    //         }
                    //         $d_pf_show = "readonly";
                    //     } else if ($process_payroll[0]->pf != null && $process_payroll[0]->pf != '') {
                    //         $d_pf = $process_payroll[0]->pf;
                    //         //                           $d_pf_show = "";
                    //     } else {
                    //         $valc = 0;
                    //         $d_pf = $valc;
                    //         $d_pf_show = "readonly";
                    //     }
                    // }

                    //pf_int
                   
                    
                    if ($process_payroll[3][$j]->rate_id == '16') {
                        // return "okk0";
                        // return $process_payroll[0]->pf_int;
                        // $return_pf_int->setAttribute('pf_int', $process_payroll[0]->pf_int);
                        if ($process_payroll[0]->pf_int == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_pfint = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_pfint = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_pfint_show = "readonly";
                        } else if ($process_payroll[0]->pf_int != null && $process_payroll[0]->pf_int != '') {
                            $d_pfint = $process_payroll[0]->pf_int;
                            //                          $d_pfint_show = "";
                        } else {
                            $valc = 0;
                            $d_pfint = $valc;
                            $d_pfint_show = "readonly";
                        }
                        
                    }

                    //apf
                    if ($process_payroll[3][$j]->rate_id == '17') {
                        //$employee_rs->basic_pay

                        $valc = ($calculate_basic_salary * $employee_rs->apf_percent / 100);
                        $valc = round($valc,0);
                        $d_apf = $valc;

                        // if ($process_payroll[0]->apf == '1') {
                        //     if ($process_payroll[3][$j]->inpercentage != '0') {
                        //         $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                        //         $valc = round($valc,2);
                        //         $d_apf = $valc;
                        //     } else {
                        //         if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                        //             $d_apf = $process_payroll[3][$j]->inrupees;
                        //         }
                        //     }
                        //     $d_apf_show = "readonly";
                        // } else if ($process_payroll[0]->apf != null && $process_payroll[0]->apf != '') {
                        //     $d_apf = $process_payroll[0]->apf;
                        //     //                           $d_apf_show = "";
                        // } else {
                        //     $valc = 0;
                        //     $d_apf = $valc;
                        //     $d_apf_show = "readonly";
                        // }
                    }

                    //i_tax
                    if ($process_payroll[3][$j]->rate_id == '18') {
                        //dd('aaa');
                        if ($process_payroll[0]->i_tax == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_itax = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_itax = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_itax_show = "readonly";
                        } else if ($process_payroll[0]->i_tax != null && $process_payroll[0]->i_tax != '') {
                            $d_itax = $process_payroll[0]->i_tax;
                            $d_itax_show = "readonly";
                        } else {
                            $valc = 0;
                            $d_itax = $valc;
                            $d_itax_show = "readonly";
                        }
                        // echo  $d_itax=$process_incometax;
                        $d_itax = @$process_incometax->itax_amount;
                 
                       
                    }

                    //insu_prem
                    if ($process_payroll[3][$j]->rate_id == '19') {
                        if ($process_payroll[0]->insu_prem == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_insuprem = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_insuprem = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_insuprem_show = "readonly";
                        } else if ($process_payroll[0]->insu_prem != null && $process_payroll[0]->insu_prem != '') {
                            $d_insuprem = $process_payroll[0]->insu_prem;
                            $d_insuprem_show = "readonly";
                        } else {
                            $valc = 0;
                            $d_insuprem = $valc;
                            $d_insuprem_show = "readonly";
                        }
                        $d_insuprem = @$process_cooperative->insurance_prem;
                    }

                    //pf_loan
                    if ($process_payroll[3][$j]->rate_id == '20') {
                        if ($process_payroll[0]->pf_loan == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_pfloan = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_pfloan = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_pfloan_show = "readonly";
                        } else if ($process_payroll[0]->pf_loan != null && $process_payroll[0]->pf_loan != '') {
                            $d_pfloan = $process_payroll[0]->pf_loan;
                            //                           $d_pfloan_show = "";
                        } else {
                            $valc = 0;
                            $d_pfloan = $valc;
                            $d_pfloan_show = "readonly";
                        }
                    }

                    //esi
                    if ($process_payroll[3][$j]->rate_id == '21') {
                        if ($process_payroll[0]->esi == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_esi = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_esi = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_esi_show = "readonly";
                        } else if ($process_payroll[0]->esi != null && $process_payroll[0]->esi != '') {
                            $d_esi = $process_payroll[0]->esi;
                            //                           $d_esi_show = "";
                        } else {
                            $valc = 0;
                            $d_esi = $valc;
                            $d_esi_show = "readonly";
                        }
                    }

                    //adv
                    if ($process_payroll[3][$j]->rate_id == '22') {
                        if ($process_payroll[0]->adv == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_adv = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_adv = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_adv_show = "readonly";
                        } else if ($process_payroll[0]->adv != null && $process_payroll[0]->adv != '') {
                            $d_adv = $process_payroll[0]->adv;
                            //                           $d_adv_show = "";
                        } else {
                            $valc = 0;
                            $d_adv = $valc;
                            $d_adv_show = "readonly";
                        }
                    }

                    //hrd
                    if ($process_payroll[3][$j]->rate_id == '23') {
                        if ($process_payroll[0]->hrd == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_hrd = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_hrd = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_hrd_show = "readonly";
                        } else if ($process_payroll[0]->hrd != null && $process_payroll[0]->hrd != '') {
                            $d_hrd = $process_payroll[0]->hrd;
                            //                           $d_hrd_show = "";
                        } else {
                            $valc = 0;
                            $d_hrd = $valc;
                            $d_hrd_show = "readonly";
                        }
                    }

                    //co_op
                    if ($process_payroll[3][$j]->rate_id == '24') {
                        if ($process_payroll[0]->co_op == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_coop = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_coop = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_coop_show = "readonly";
                        } else if ($process_payroll[0]->co_op != null && $process_payroll[0]->co_op != '') {
                            $d_coop = $process_payroll[0]->co_op;
                            //                           $d_coop_show = "";
                        } else {
                            $valc = 0;
                            $d_coop = $valc;
                            $d_coop_show = "readonly";
                        }

                        $d_coop = @$process_cooperative->coop_amount;
                    }

                    //furniture
                    if ($process_payroll[3][$j]->rate_id == '25') {
                        if ($process_payroll[0]->furniture == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_furniture = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_furniture = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_furniture_show = "readonly";
                        } else if ($process_payroll[0]->furniture != null && $process_payroll[0]->furniture != '') {
                            $d_furniture = $process_payroll[0]->furniture;
                            //  $d_furniture_show = "";
                        } else {
                            $valc = 0;
                            $d_furniture = $valc;
                            $d_furniture_show = "readonly";
                        }
                    }

                    //misc_ded
                    if ($process_payroll[3][$j]->rate_id == '26') {
                        if ($process_payroll[0]->misc_ded == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_miscded = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_miscded = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_miscded_show = "readonly";
                        } else if ($process_payroll[0]->misc_ded != null && $process_payroll[0]->misc_ded != '') {
                            $d_miscded = $process_payroll[0]->misc_ded;
                            //                           $d_miscded_show = "";
                        } else {
                            $valc = 0;
                            $d_miscded = $valc;
                            $d_miscded_show = "readonly";
                        }

                        $d_miscded = @$process_cooperative->misc_ded;
                    }
                    //d_pf_employer
                    if ($process_payroll[3][$j]->rate_id == '29') {
                        if ($process_payroll[0]->pf_employerc == '1') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_pf_employer = $valc;
                            } else {
                                if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                    $d_pf_employer = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_pf_employer_show = "readonly";
                        } else if ($process_payroll[0]->pf_employerc != null && $process_payroll[0]->pf_employerc != '') {
                            $d_pf_employer = $process_payroll[0]->pf_employerc;
                            //                           $d_pf_employer_show = "";
                        } else {
                            $valc = 0;
                            $d_pf_employer = $valc;
                            $d_pf_employer_show = "readonly";
                        }
                    }

                }
                //dd($process_allowances);

                
                //set tiffin allowance from generation
                if (isset($process_allowances->tiffin_alw)) {
                    $e_tiffalw = $process_allowances->tiffin_alw;
                    $e_tiffalw = round($e_tiffalw,2);
                }

                //set convence allowance from generation
                if (isset($process_allowances->convence_alw)) {
                    $e_conv = $process_allowances->convence_alw;
                    $e_conv = round($e_conv,2);
                }

                //set misc. allowance from generation
                if (isset($process_allowances->misc_alw)) {
                    $e_miscalw = $process_allowances->misc_alw + $process_allowances->extra_misc_alw;
                    
                    $e_miscalw = round($e_miscalw,2);
                }
                
                //set other. allowance from generation
                if (isset($process_allowances->other_alw)) {
                    $e_othalw = $process_allowances->other_alw;
                    $e_othalw = round($e_othalw,2);
                }
                
                
                //set over_time. allowance from generation
                if (isset($process_overtimes->ot_alws)) {
                    $e_overtime = $process_overtimes->ot_alws;
                    $e_overtime = round($e_overtime,2);
                }
                //$salary_adv_loan
                //$pf_loan
                $d_adv=0;
                $d_pfloan=0;
                $d_pfint =0;

               
               // echo $emcode->emp_code.'<br>';
                $salary_adv_loan=$this->getLoanDeductionValue($emcode->emp_code,'SA',$request['month_yr']);
                $pf_loan=$this->getLoanDeductionValue($emcode->emp_code,'PF',$request['month_yr']);
                $pf_loan_balance=$this->getTotalLoanBalanceValue($emcode->emp_code,'PF',$request['month_yr']);
            
                //dd($salary_adv_loan);  

                if(!empty($salary_adv_loan)){
                   // echo $emcode->emp_code.'<br>';
                    //dd($salary_adv_loan);
                    foreach($salary_adv_loan as $rec){
                        //dd($rec['installment_amount']);
                        $d_adv=$d_adv+$rec['installment_amount'];
                    }
                    $d_adv = round($d_adv,2);
                }

                if(!empty($pf_loan)){
                    //dd('loan');
                    foreach($pf_loan as $rec){
                        $d_pfloan=$d_pfloan+$rec['installment_amount'];
                    }
                    $d_pfloan = round($d_pfloan,2);
                }


                if(!empty($pf_loan_balance)){
                    //echo $emcode->emp_code.'<br>';
                    //dd($pf_loan_balance);
                    // print("<pre>".print_r($pf_loan_balance,true)."</pre>");
                    $emp_pf_loan_balance=0;
                    foreach($pf_loan_balance as $rec){
                        $emp_pf_loan_balance=$emp_pf_loan_balance+$rec['balance_amount'];
                        // $emp_pf_loan_balance=$emp_pf_loan_balance+$rec['loan_amount'];
                    }

                    // return $emp_pf_loan_balance;
                    
                    // return $effective_pfloan_interest_rate;
                    
                    $d_pfint = (($emp_pf_loan_balance * $effective_pfloan_interest_rate) / 100)/12;
                    $d_pfint = round($d_pfint,2);
                    // print_r($d_pfint);
                    
                }



                //dd($process_payroll[3][0]->rate_id);
                //dd($e_vda);
                $total_of_earnings = (float)$e_da + (float)$e_vda + (float)$e_hra + (float)$e_tiffalw + (float)$e_othalw + (float)$e_conv + (float)$e_medical + (float)$e_miscalw + (float)$e_overtime + (float)$e_bonus + (float)$e_leaveenc + (float)$e_hta + (float)$e_others;

                // $total_of_earnings = $e_da + $e_vda + $e_hra + $e_tiffalw + $e_othalw + $e_conv + $e_medical + $e_miscalw + $e_overtime + $e_bonus + $e_leaveenc + $e_hta + $e_others;



                $total_of_earnings = round($total_of_earnings,2);

                //$total_gross = round($calculate_basic_salary + $da + $hra + $da_on_ta + $ta_rate + $ltc + $cea + $tr_a + $dla + $adv + $adjadv + $mr + $sa + $cha);

                //Gross Salary
                $total_gross = $calculate_basic_salary + $total_of_earnings;

                $total_gross = round($total_gross,2);
                $d_proftax = 0;
                for ($j = 0; $j < sizeof($process_payroll[3]); $j++) {
                    if ($process_payroll[3][$j]->rate_id == '4') {
                        if ($process_payroll[0]->prof_tax == '1' || $process_payroll[0]->prof_tax > '0') {
                            if ($process_payroll[3][$j]->inpercentage != '0') {
                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                $valc = round($valc,2);
                                $d_proftax = $valc;
                            } else {
                                if (($total_gross <= $process_payroll[3][$j]->max_basic) && ($total_gross >= $process_payroll[3][$j]->min_basic)) {
                                    $d_proftax = $process_payroll[3][$j]->inrupees;
                                }
                                if (($total_gross >= $process_payroll[3][$j]->max_basic) && ($total_gross <= $process_payroll[3][$j]->min_basic)) {
                                    $d_proftax = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            $d_proftax_show = "readonly";
                        } else if ($process_payroll[0]->prof_tax != null && $process_payroll[0]->prof_tax != '') {
                            if($process_payroll[0]->prof_tax>0){
                                $d_proftax = $process_payroll[0]->prof_tax;
                            }else{
                                if (($total_gross <= $process_payroll[3][$j]->max_basic) && ($total_gross >= $process_payroll[3][$j]->min_basic)) {
                                    $d_proftax = $process_payroll[3][$j]->inrupees;
                                }
                                if (($total_gross >= $process_payroll[3][$j]->max_basic) && ($total_gross <= $process_payroll[3][$j]->min_basic)) {
                                    $d_proftax = $process_payroll[3][$j]->inrupees;
                                }
                            }
                            
                            //                            $d_proftax_show = "";
                        } else {
                            $emp_hra = 0;
                            $d_proftax = $emp_hra;
                            $d_proftax_show = "readonly";
                        }

                    }
                    //dd($process_payroll[0]->pf_type);
                    $console_text="";
                    if ($process_payroll[3][$j]->rate_id == '15') {
                    //    echo $console_text=$console_text." caltype=".$process_payroll[0]->pf_type;
                        if ($process_payroll[0]->pf_type != 'V'){
                            // $console_text=$console_text." fixed block";

                            if ($process_payroll[0]->pf == '1') {
                                // echo $console_text=$console_text." pf==1 block";
                                if ($process_payroll[3][$j]->inpercentage != '0') {
                                    // $console_text=$console_text." in percent";
                                    $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                    $valc = round($valc,2);
                                    $d_pf = $valc;
                                } else {
                                    // echo $console_text=$console_text." in range";
                                    if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                        $d_pf = $process_payroll[3][$j]->inrupees;
                                    }
                                }
                                $d_pf_show = "readonly";
                            } else if ($process_payroll[0]->pf != null && $process_payroll[0]->pf != '' ) {
                                //&& $process_payroll[0]->pf>0
                                if($process_payroll[0]->pf>0){
                                    // echo $console_text=$console_text." -----PF greater zero----basic=".$calculate_basic_salary;
                                    if ($process_payroll[3][$j]->inpercentage != '0') {
                                        if($calculate_basic_salary>15000){
                                            // $console_text=$console_text." in percent basic less than 15k";
                                            if($process_payroll[0]->emp_pf_inactuals=='Y'){
                                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                                $valc = round($valc,2);
                                                $d_pf = $valc;
                                            }else{
                                                $valc = 1800;
                                                $d_pf = $valc;
                                            }
                                        }else{
                                            // echo $console_text=$console_text." else of in percent basic less than 15k";
                                            $acc_salary=$total_gross-$e_hra-$e_overtime;
                                            // echo $console_text=$console_text." acc-basic=".$acc_salary;
                                            $valc = ($acc_salary * $process_payroll[3][$j]->inpercentage / 100);
                                            $valc = round($valc,2);
                                            // echo $console_text=$console_text." acc-pf=".$valc;
                                            $d_pf = $valc;
                                            if($process_payroll[0]->emp_pf_inactuals=='Y'){
                                                $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                                $valc = round($valc,2);
                                                //$d_pf = $valc;
                                            }else{
                                                if($valc>1800){
                                                    $valc = 1800;
                                                }
                                                
                                            }     
                                            $d_pf = $valc;                                       
                                        }
                                    }else{
                                        if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                            $d_pf = $process_payroll[3][$j]->inrupees;
                                        }
                                    }
                                }else{
                                    // echo $console_text=$console_text." ZERO";
                                    $valc = 0;
                                    $d_pf = $valc;
                                    $d_pf_show = "readonly";
                                }
                                // if ($process_payroll[3][$j]->inpercentage != '0') {
                                //     if($calculate_basic_salary>15000){
                                //         if($process_payroll[0]->emp_pf_inactuals=='Y'){
                                //             $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                //             $valc = round($valc,2);
                                //             $d_pf = $valc;
                                //         }else{
                                //             $valc = 1800;
                                //             $d_pf = $valc;
                                //         }
                                //     }else{
                                //         $acc_salary=$total_of_earnings-$e_hra;
                                //         $valc = ($acc_salary * $process_payroll[3][$j]->inpercentage / 100);
                                //         $valc = round($valc,2);
                                //         $d_pf = $valc;
                                //         if($process_payroll[0]->emp_pf_inactuals=='Y'){
                                //             $valc = ($calculate_basic_salary * $process_payroll[3][$j]->inpercentage / 100);
                                //             $valc = round($valc,2);
                                //             $d_pf = $valc;
                                //         }else{
                                //             if($valc>1800){
                                //                 $valc = 1800;
                                //             }
                                //             $d_pf = $valc;
                                //         }
                                //     }
                                    
                                // } else {
                                //     if (($calculate_basic_salary <= $process_payroll[3][$j]->max_basic) && ($calculate_basic_salary >= $process_payroll[3][$j]->min_basic)) {
                                //         $d_pf = $process_payroll[3][$j]->inrupees;
                                //     }
                                // }
    
                                if ($process_payroll[0]->pf_type != 'F') {
                                    
                                    $d_pf_show = "";
                                }else{
                                   
                                    $d_pf_show = "readonly";
                                }
                            } else {
                                // echo $console_text=$console_text." last fixed *ZERO";
                                $valc = 0;
                                $d_pf = $valc;
                                $d_pf_show = "readonly";
                            }

                        }else{
                            $valc = $process_payroll[0]->pf;
                            // echo $console_text=$console_text." variable";
                            if($valc > 0){
                                $calculate_pf = ($valc / $current_month_days) * ($process_attendance->no_of_working_days - $process_attendance->no_of_days_absent);
                                $calculate_pf = round($calculate_pf,0);
                                $valc=$calculate_pf;
                            }else{
                                $valc = 0;
                            }

                            $d_pf = $valc;
                            $d_pf_show = "readonly";

                        }    
                        $d_pf=round($d_pf,0);
                    }

                }
                
                
                $total_deduction1 = 0; 
                $total_deduction2 = 0; 
                $total_deduction3 = 0; 
                $total_deduction4 = 0; 
                $total_deduction5 = 0; 
                $total_deduction6 = 0; 
                $total_deduction7 = 0; 
                $total_deduction8 = 0; 
                $total_deduction9 = 0; 
                $total_deduction10 = 0; 
                $total_deduction11 = 0; 
                $total_deduction12 = 0; 
                $total_deduction13 = 0; 
                $total_deduction14 = 0; 
                $total_deduction15 = 0; 
                
                
                $remain_salary = 0;
                $remain_salary1 = 0;
                $remain_salary2 = 0;
                $remain_salary3 = 0;
                $remain_salary4 = 0;
                $remain_salary5 = 0;
                $remain_salary6 = 0;
                $remain_salary7 = 0;
                $remain_salary8 = 0;
                $remain_salary9 = 0;
                $remain_salary10 = 0;
                $remain_salary11 = 0;
                $remain_salary12 = 0;
                $remain_salary13 = 0;
                $remain_salary14 = 0;
                
                if($calculate_basic_salary > ($d_proftax + $d_pf)){
                    $total_deduction1 = $d_proftax + $d_pf;
                    
                    $remain_salary = $total_gross - $total_deduction1;
                }else{
                    $total_deduction1 =0;
                }
                if($remain_salary > $d_itax){
                    $total_deduction2 = $d_itax;
                    $remain_salary1 = $remain_salary - $total_deduction2;
                }else{
                    $total_deduction2 = 0;
                }
                if($remain_salary1 > $d_insuprem){
                    $total_deduction3 = $d_insuprem;
                    $remain_salary2 = $remain_salary1 - $total_deduction3;
                }else{
                    $total_deduction3 = 0;
                }
                if($remain_salary2 > $d_pfloan){
                    $total_deduction4 = $d_pfloan;
                    $remain_salary3 = $remain_salary2 - $total_deduction4;
                }else{
                    $total_deduction4 = 0;
                }
                
                if($remain_salary3 > $d_adv){
                    $total_deduction5 = $d_adv;
                    $remain_salary4 = $remain_salary3 - $total_deduction5;
                }else{
                    $total_deduction5 = 0;
                }
                
                if($remain_salary4 > $d_coop){
                    $total_deduction6 = $d_coop;
                    $remain_salary5 = $remain_salary4 - $total_deduction6;
                }else{
                    $total_deduction6 = 0;
                }
                
                if($remain_salary5 > $d_esi){
                    $total_deduction7 = $d_esi;
                    $remain_salary6 = $remain_salary5 - $total_deduction7;
                }else{
                    $total_deduction7 = 0;
                }
                
                if($remain_salary6 > $d_hrd){
                    $total_deduction8 = $d_hrd;
                    $remain_salary7 = $remain_salary6 - $total_deduction8;
                }else{
                    $total_deduction8 = 0;
                }
                
                if($remain_salary7 > $d_furniture){
                    $total_deduction9 = $d_furniture;
                    $remain_salary8 = $remain_salary7 - $total_deduction9;
                }else{
                    $total_deduction9 = 0;
                }
                
                if($remain_salary8 > $d_pf_employer){
                    $total_deduction10 = $d_pf_employer;
                    $remain_salary9 = $remain_salary8 - $total_deduction10;
                }else{
                    $total_deduction10 = 0;
                }
                
                
                if($remain_salary9 > $d_pfint){
                    $total_deduction11 = $d_pfint;
                    $remain_salary10 = $remain_salary9 - $total_deduction11;
                }else{
                    $total_deduction11 = 0;
                }
                
                if($remain_salary10 > $d_apf){
                    $total_deduction12 = $d_apf;
                    $remain_salary11 = $remain_salary10 - $total_deduction12;
                }else{
                    $total_deduction12 = 0;
                }
                
                
                if($remain_salary11 > $d_miscded){
                    $total_deduction13 = $d_miscded;
                    $remain_salary12 = $remain_salary11 - $total_deduction13;
                }else{
                    $total_deduction13 = 0;
                }
                
                if($remain_salary12 > $d_incometax){
                    $total_deduction14 = $d_incometax;
                    $remain_salary13 = $remain_salary12 - $total_deduction14;
                }else{
                    $total_deduction14 = 0;
                }
                
                
                
                if($remain_salary13 > $d_others){
                    $total_deduction15 = $d_others;
                    $remain_salary14 = $remain_salary13 - $total_deduction15;
                }else{
                    $total_deduction15 = 0;
                }
                

                $total_deduction = ($total_deduction1  + $total_deduction2 + $total_deduction3 + $total_deduction4 + 
                    $total_deduction5 + $total_deduction6 + $total_deduction7 + $total_deduction8 + $total_deduction9
                    + $total_deduction10 + $total_deduction11 + $total_deduction12 + $total_deduction13 + $total_deduction14 + $total_deduction15);
                // $total_deduction = ($d_proftax + $d_pf + $d_pfint + $d_apf + $d_itax + $d_insuprem + $d_pfloan + $d_esi + $d_adv + $d_hrd + $d_coop + $d_furniture + $d_miscded + $d_incometax + $d_others + $d_pf_employer);
                $total_deduction = round($total_deduction,2);

                /* $ptax = 0;
                foreach ($rate_rs as $ratekey => $rateval) {

                if ($rateval->head_name == 'PTAX') {
                if ($employee_rs->professional_tax == '1') {

                if (($total_gross >= $rateval->min_basic) && ($total_gross <= $rateval->max_basic)) {
                $ptax = $rateval->inrupees;
                }
                } else {
                $ptax = 0;
                }
                }
                }*/

                //$total_deduction = round($tot_nps + $gsli + $ptax + $gpf + $income_tax + $cess + $other2);
                $netsalary = ($total_gross - $total_deduction);
                $netsalary = round($netsalary,2);

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td style="width:10px;"><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="hidden" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100px;" value="' . $employee_rs->emp_code . '">' . $employee_rs->old_emp_code . '</td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:120px;" value="' . $employee_rs->emp_fname . ' ' . $employee_rs->emp_mname . ' ' . $employee_rs->emp_lname . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100px;" value="' . $employee_rs->designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:74px;" value="' . $request['month_yr'] . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_basic_pay" name="emp_basic_pay' . $emcode->emp_code . '" style="width:100px;" value="' . $calculate_basic_salary . '"  id="emp_basic_pay_' . $emcode->emp_code . '" ></td>
								<td><input type="text" readonly class="form-control sm_emp_no_of_working" name="emp_no_of_working' . $emcode->emp_code . '" value="' . $no_of_working_days . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_no_of_present" name="emp_no_of_present' . $emcode->emp_code . '" value="' . $no_of_present . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_no_of_days_absent" name="emp_no_of_days_absent' . $emcode->emp_code . '" value="' . $no_of_days_absent . '"></td>
				  				<td><input type="text" readonly class="form-control sm_emp_no_of_days_salary" name="emp_no_of_days_salary' . $emcode->emp_code . '" value="' . $no_of_days_salary . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_cl" name="emp_tot_cl' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_cl . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_el" name="emp_tot_el' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_el . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_hpl" name="emp_tot_hpl' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_hpl . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_rh" name="emp_tot_rh' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_rh . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_cml" name="emp_tot_cml' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_cml . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_eol" name="emp_tot_eol' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_eol . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_lnd" name="emp_lnd' . $emcode->emp_code . '" value="0" style="width:50px;"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_ml" name="emp_tot_ml' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_ml . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tot_pl" name="emp_tot_pl' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_pl . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_totccl" name="emp_totccl' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_ccl . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_tour_leave" name="emp_tour_leave' . $emcode->emp_code . '" style="width:50px;" value="' . $tot_tl . '"></td>';
                //Earnings
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_da" id="e_da_' . $emcode->emp_code . '" name="e_da' . $emcode->emp_code . '" value="' . $e_da . '" ' . $e_da_show . ' onblur="recalculate(this);" ></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_vda" id="e_vda_' . $emcode->emp_code . '" name="e_vda' . $emcode->emp_code . '" value="' . $e_vda . '" ' . $e_vda_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_hra" id="e_hra_' . $emcode->emp_code . '" name="e_hra' . $emcode->emp_code . '" value="' . $e_hra . '" ' . $e_hra_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_tiffalw" id="e_tiffalw_' . $emcode->emp_code . '" name="e_tiffalw' . $emcode->emp_code . '" value="' . $e_tiffalw . '" ' . $e_tiffalw_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_othalw" id="e_othalw_' . $emcode->emp_code . '" name="e_othalw' . $emcode->emp_code . '" value="' . $e_othalw . '" ' . $e_othalw_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_conv" name="e_conv' . $emcode->emp_code . '" value="' . $e_conv . '" id="e_conv_' . $emcode->emp_code . '" ' . $e_conv_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_medical" name="e_medical' . $emcode->emp_code . '" value="' . $e_medical . '" id="e_medical_' . $emcode->emp_code . '" ' . $e_medical_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_miscalw" name="e_miscalw' . $emcode->emp_code . '" value="' . $e_miscalw . '" id="e_miscalw_' . $emcode->emp_code . '" ' . $e_miscalw_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_overtime" name="e_overtime' . $emcode->emp_code . '" value="' . $e_overtime . '" id="e_overtime_' . $emcode->emp_code . '" ' . $e_overtime_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_bonus" name="e_bonus' . $emcode->emp_code . '" value="' . $e_bonus . '" id="e_bonus_' . $emcode->emp_code . '" ' . $e_bonus_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_leaveenc" name="e_leaveenc' . $emcode->emp_code . '" value="' . $e_leaveenc . '" id="e_leaveenc_' . $emcode->emp_code . '" ' . $e_leaveenc_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_e_hta" name="e_hta' . $emcode->emp_code . '" value="' . $e_hta . '" id="e_hta_' . $emcode->emp_code . '" ' . $e_hta_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_e_others" name="e_others' . $emcode->emp_code . '" value="' . $e_others . '" style="width:100px;" id="e_others_' . $emcode->emp_code . '" ' . $e_others_show . ' onblur="recalculate(this);"></td>';

                //deductions
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_proftax" id="d_proftax_' . $emcode->emp_code . '" name="d_proftax' . $emcode->emp_code . '" style="width:50px;" value="' . $d_proftax . '" ' . $d_proftax_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_pf" name="d_pf' . $emcode->emp_code . '" style="width:50px;" value="' . $d_pf . '" ' . $d_pf_show . ' id="d_pf_' . $emcode->emp_code . '" onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_pfint" name="d_pfint' . $emcode->emp_code . '" style="width:50px;" value="' . $d_pfint . '" ' . $d_pfint_show . ' id="d_pfint_' . $emcode->emp_code . '" onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_apf" name="d_apf' . $emcode->emp_code . '" style="width:50px;" value="' . $d_apf . '" id="d_apf_' . $emcode->emp_code . '" ' . $d_apf_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_itax" name="d_itax' . $emcode->emp_code . '" style="width:50px;" value="' . $d_itax . '" id="d_itax_' . $emcode->emp_code . '" ' . $d_itax_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_insuprem" name="d_insuprem' . $emcode->emp_code . '" value="' . $d_insuprem . '" id="d_insuprem_' . $emcode->emp_code . '" ' . $d_insuprem_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" style="width:100px;" class="form-control sm_d_pfloan" name="d_pfloan' . $emcode->emp_code . '" value="' . $d_pfloan . '" id="d_pfloan_' . $emcode->emp_code . '" readonly onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_esi" name="d_esi' . $emcode->emp_code . '" style="width:100px;" value="' . $d_esi . '" id="d_esi_' . $emcode->emp_code . '" ' . $d_esi_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_adv" name="d_adv' . $emcode->emp_code . '" style="width:100px;" value="' . $d_adv . '" id="d_adv_' . $emcode->emp_code . '" readonly onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_hrd" name="d_hrd' . $emcode->emp_code . '" style="width:100px;" value="' . $d_hrd . '" id="d_hrd_' . $emcode->emp_code . '" ' . $d_hrd_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_coop" name="d_coop' . $emcode->emp_code . '" style="width:100px;" value="' . $d_coop . '" id="d_coop_' . $emcode->emp_code . '" ' . $d_coop_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_furniture" name="d_furniture' . $emcode->emp_code . '" style="width:100px;" value="' . $d_furniture . '" id="d_furniture_' . $emcode->emp_code . '" ' . $d_furniture_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_pf_employer" name="d_pf_employer' . $emcode->emp_code . '" style="width:100px;" value="' . $d_pf_employer . '" id="d_pf_employer_' . $emcode->emp_code . '" ' . $d_pf_employer_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_miscded" name="d_miscded' . $emcode->emp_code . '" style="width:100px;" value="' . $d_miscded . '" id="d_miscded_' . $emcode->emp_code . '" ' . $d_miscded_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_incometax" name="d_incometax' . $emcode->emp_code . '" style="width:100px;" value="' . $d_incometax . '" id="d_incometax_' . $emcode->emp_code . '" ' . $d_incometax_show . ' onblur="recalculate(this);"></td>';
                $result .= '<td><input type="text" class="form-control sm_d_others" name="d_others' . $emcode->emp_code . '" style="width:100px;" value="' . $d_others . '" id="d_others_' . $emcode->emp_code . '" ' . $d_others_show . ' onblur="recalculate(this);"></td>';

                $result .= '<td><input type="text" class="form-control sm_emp_total_gross" name="emp_total_gross' . $emcode->emp_code . '" style="width:120px;" value="' . $total_gross . '" id="emp_total_gross_' . $emcode->emp_code . '" readonly ></td>
								<td><input type="text" class="form-control sm_emp_total_deduction" name="emp_total_deduction' . $emcode->emp_code . '" style="width:120px;" value="' . $total_deduction . '" id="emp_total_deduction_' . $emcode->emp_code . '" readonly></td>
								<td><input type="text" class="form-control sm_emp_net_salary" name="emp_net_salary' . $emcode->emp_code . '" style="width:120px;" value="' . $netsalary . '" id="emp_net_salary_' . $emcode->emp_code . '" readonly></td>
							<input type="hidden" class="form-control sm_emp_d_status_co" name="status_co' . $emcode->emp_code . '" style="width:100px;" id="status_co_' . $emcode->emp_code . '">	
								
					</tr> ';
                // print_r($result);
                // die();
            }
            // return $emplist;
            // die();
            $month_yr_new = $request['month_yr'];
            return view('payroll/generate-payroll-all', compact('result','month_yr_new'));
        } else {
            return redirect('/');
        }
    }
    public function SavePayrollAll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->cboxes);
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {
                //var_dump($file = file_get_contents('php://input'));
                //var_dump($_POST);
                // dd($this->getRealPOST());

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);
                $sm_emp_basic_pay_ctrl = explode(',', $request->sm_emp_basic_pay_ctrl);
                $sm_emp_no_of_working_ctrl = explode(',', $request->sm_emp_no_of_working_ctrl);
                $sm_emp_no_of_present_ctrl = explode(',', $request->sm_emp_no_of_present_ctrl);
                $sm_emp_no_of_days_absent_ctrl = explode(',', $request->sm_emp_no_of_days_absent_ctrl);
                $sm_emp_no_of_days_salary_ctrl = explode(',', $request->sm_emp_no_of_days_salary_ctrl);
                $sm_emp_tot_cl_ctrl = explode(',', $request->sm_emp_tot_cl_ctrl);
                $sm_emp_tot_el_ctrl = explode(',', $request->sm_emp_tot_el_ctrl);
                $sm_emp_tot_hpl_ctrl = explode(',', $request->sm_emp_tot_hpl_ctrl);
                $sm_emp_tot_rh_ctrl = explode(',', $request->sm_emp_tot_rh_ctrl);
                $sm_emp_tot_cml_ctrl = explode(',', $request->sm_emp_tot_cml_ctrl);
                $sm_emp_tot_eol_ctrl = explode(',', $request->sm_emp_tot_eol_ctrl);
                $sm_emp_lnd_ctrl = explode(',', $request->sm_emp_lnd_ctrl);
                $sm_emp_tot_ml_ctrl = explode(',', $request->sm_emp_tot_ml_ctrl);
                $sm_emp_tot_pl_ctrl = explode(',', $request->sm_emp_tot_pl_ctrl);
                $sm_emp_totccl_ctrl = explode(',', $request->sm_emp_totccl_ctrl);
                $sm_emp_tour_leave_ctrl = explode(',', $request->sm_emp_tour_leave_ctrl);
                $sm_e_da_ctrl = explode(',', $request->sm_e_da_ctrl);
                $sm_e_vda_ctrl = explode(',', $request->sm_e_vda_ctrl);
                $sm_e_hra_ctrl = explode(',', $request->sm_e_hra_ctrl);
                $sm_e_tiffalw_ctrl = explode(',', $request->sm_e_tiffalw_ctrl);
                $sm_e_othalw_ctrl = explode(',', $request->sm_e_othalw_ctrl);
                $sm_e_conv_ctrl = explode(',', $request->sm_e_conv_ctrl);
                $sm_e_medical_ctrl = explode(',', $request->sm_e_medical_ctrl);
                $sm_e_miscalw_ctrl = explode(',', $request->sm_e_miscalw_ctrl);
                $sm_e_overtime_ctrl = explode(',', $request->sm_e_overtime_ctrl);
                $sm_e_bonus_ctrl = explode(',', $request->sm_e_bonus_ctrl);
                $sm_e_leaveenc_ctrl = explode(',', $request->sm_e_leaveenc_ctrl);
                $sm_e_hta_ctrl = explode(',', $request->sm_e_hta_ctrl);
                $sm_e_others_ctrl = explode(',', $request->sm_e_others_ctrl);
                $sm_d_proftax_ctrl = explode(',', $request->sm_d_proftax_ctrl);
                $sm_d_pf_ctrl = explode(',', $request->sm_d_pf_ctrl);
                $sm_d_pfint_ctrl = explode(',', $request->sm_d_pfint_ctrl);
                $sm_d_apf_ctrl = explode(',', $request->sm_d_apf_ctrl);
                $sm_d_itax_ctrl = explode(',', $request->sm_d_itax_ctrl);
                $sm_d_insuprem_ctrl = explode(',', $request->sm_d_insuprem_ctrl);
                $sm_d_pfloan_ctrl = explode(',', $request->sm_d_pfloan_ctrl);
                $sm_d_esi_ctrl = explode(',', $request->sm_d_esi_ctrl);
                $sm_d_adv_ctrl = explode(',', $request->sm_d_adv_ctrl);
                $sm_d_hrd_ctrl = explode(',', $request->sm_d_hrd_ctrl);
                $sm_d_coop_ctrl = explode(',', $request->sm_d_coop_ctrl);
                $sm_d_furniture_ctrl = explode(',', $request->sm_d_furniture_ctrl);
                $sm_d_pf_employer_ctrl = explode(',', $request->sm_d_pf_employer_ctrl);
                $sm_d_miscded_ctrl = explode(',', $request->sm_d_miscded_ctrl);
                $sm_d_incometax_ctrl = explode(',', $request->sm_d_incometax_ctrl);
                $sm_d_others_ctrl = explode(',', $request->sm_d_others_ctrl);
                $sm_emp_total_gross_ctrl = explode(',', $request->sm_emp_total_gross_ctrl);
                $sm_emp_total_deduction_ctrl = explode(',', $request->sm_emp_total_deduction_ctrl);
                $sm_emp_net_salary_ctrl = explode(',', $request->sm_emp_net_salary_ctrl);
                $sm_emp_d_status_co_ctrl = explode(',', $request->sm_emp_d_status_co_ctrl);

                // echo $key = array_search($request->empcode_check[0], $sm_emp_code_ctrl);

                // echo '<br>';
                // echo $request->empcode_check[0] . '<br>';
                // echo $sm_emp_name_ctrl[$key] . '<br>';
                // dd($request->all());

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    $data['employee_id'] = $value;

                    //$data['emp_name'] = $request['emp_name' . $value];
                    $data['emp_name'] = $sm_emp_name_ctrl[$index];

                    //$data['emp_designation'] = $request['emp_designation' . $value];
                    $data['emp_designation'] = $sm_emp_designation_ctrl[$index];

                    //$data['emp_basic_pay'] = $request['emp_basic_pay' . $value];
                    $data['emp_basic_pay'] = $sm_emp_basic_pay_ctrl[$index];

                    // $data['month_yr'] = $request['month_yr' . $value];
                    $data['month_yr'] = $sm_month_yr_ctrl[$index];

                    //$data['emp_present_days'] = $request['emp_no_of_present' . $value];
                    $data['emp_present_days'] = $sm_emp_no_of_present_ctrl[$index];

                    //$data['emp_cl'] = $request['emp_tot_cl' . $value];
                    $data['emp_cl'] = $sm_emp_tot_cl_ctrl[$index];

                    //$data['emp_el'] = $request['emp_tot_el' . $value];
                    $data['emp_el'] = $sm_emp_tot_el_ctrl[$index];

                    //$data['emp_hpl'] = $request['emp_tot_hpl' . $value];
                    $data['emp_hpl'] = $sm_emp_tot_hpl_ctrl[$index];

                    //$data['emp_absent_days'] = $request['emp_no_of_days_absent' . $value];
                    $data['emp_absent_days'] = $sm_emp_no_of_days_absent_ctrl[$index];

                    //$data['emp_rh'] = $request['emp_tot_rh' . $value];
                    $data['emp_rh'] = $sm_emp_tot_rh_ctrl[$index];

                    //$data['emp_cml'] = $request['emp_tot_cml' . $value];
                    $data['emp_cml'] = $sm_emp_tot_cml_ctrl[$index];

                    //$data['emp_eol'] = $request['emp_tot_eol' . $value];
                    $data['emp_eol'] = $sm_emp_tot_eol_ctrl[$index];

                    //$data['emp_lnd'] = $request['emp_lnd' . $value];
                    $data['emp_lnd'] = $sm_emp_lnd_ctrl[$index];

                    //$data['emp_maternity_leave'] = $request['emp_tot_ml' . $value];
                    $data['emp_maternity_leave'] = $sm_emp_tot_ml_ctrl[$index];

                    //$data['emp_paternity_leave'] = $request['emp_tot_pl' . $value];
                    $data['emp_paternity_leave'] = $sm_emp_tot_pl_ctrl[$index];

                    //$data['emp_ccl'] = $request['emp_totccl' . $value];
                    $data['emp_ccl'] = $sm_emp_totccl_ctrl[$index];

                    //Earnings
                    //$data['emp_da'] = $request['e_da' . $value];
                    $data['emp_da'] = $sm_e_da_ctrl[$index];

                    //$data['emp_vda'] = $request['e_vda' . $value];
                    $data['emp_vda'] = $sm_e_vda_ctrl[$index];

                    //$data['emp_hra'] = $request['e_hra' . $value];
                    $data['emp_hra'] = $sm_e_hra_ctrl[$index];

                    //$data['emp_others_alw'] = $request['e_othalw' . $value];
                    $data['emp_others_alw'] = $sm_e_othalw_ctrl[$index];

                    //$data['emp_tiff_alw'] = $request['e_tiffalw' . $value];
                    $data['emp_tiff_alw'] = $sm_e_tiffalw_ctrl[$index];

                    //$data['emp_conv'] = $request['e_conv' . $value];
                    $data['emp_conv'] = $sm_e_conv_ctrl[$index];

                    //$data['emp_medical'] = $request['e_medical' . $value];
                    $data['emp_medical'] = $sm_e_medical_ctrl[$index];

                    //$data['emp_misc_alw'] = $request['e_miscalw' . $value];
                    $data['emp_misc_alw'] = $sm_e_miscalw_ctrl[$index];

                    //$data['emp_over_time'] = $request['e_overtime' . $value];
                    $data['emp_over_time'] = $sm_e_overtime_ctrl[$index];

                    //$data['emp_bouns'] = $request['e_bonus' . $value];
                    $data['emp_bouns'] = $sm_e_bonus_ctrl[$index];

                    //$data['emp_leave_inc'] = $request['e_leaveenc' . $value];
                    $data['emp_leave_inc'] = $sm_e_leaveenc_ctrl[$index];

                    //$data['emp_hta'] = $request['e_hta' . $value];
                    $data['emp_hta'] = $sm_e_hta_ctrl[$index];

                    //$data['other_addition'] = $request['e_others' . $value];
                    $data['other_addition'] = $sm_e_others_ctrl[$index];

                    //Deductions
                    //$data['emp_prof_tax'] = $request['d_proftax' . $value];
                    $data['emp_prof_tax'] = $sm_d_proftax_ctrl[$index];

                    //$data['emp_pf'] = $request['d_pf' . $value];
                    $data['emp_pf'] = $sm_d_pf_ctrl[$index];

                    //$data['emp_pf_int'] = $request['d_pfint' . $value];
                    $data['emp_pf_int'] = $sm_d_pfint_ctrl[$index];

                    //$data['emp_co_op'] = $request['d_coop' . $value];
                    $data['emp_co_op'] = $sm_d_coop_ctrl[$index];

                    //$data['emp_apf'] = $request['d_apf' . $value];
                    $data['emp_apf'] = $sm_d_apf_ctrl[$index];

                    //$data['emp_i_tax'] = $request['d_itax' . $value];
                    $data['emp_i_tax'] = $sm_d_itax_ctrl[$index];

                    //$data['emp_insu_prem'] = $request['d_insuprem' . $value];
                    $data['emp_insu_prem'] = $sm_d_insuprem_ctrl[$index];

                    //$data['emp_pf_loan'] = $request['d_pfloan' . $value];
                    $data['emp_pf_loan'] = $sm_d_pfloan_ctrl[$index];

                    //$data['emp_esi'] = $request['d_esi' . $value];
                    $data['emp_esi'] = $sm_d_esi_ctrl[$index];

                    //$data['emp_adv'] = $request['d_adv' . $value];
                    $data['emp_adv'] = $sm_d_adv_ctrl[$index];

                    //$data['emp_furniture'] = $request['d_furniture' . $value];
                    $data['emp_furniture'] = $sm_d_furniture_ctrl[$index];

                    //$data['emp_pf_employer'] = $request['d_pf_employer' . $value];
                    $data['emp_pf_employer'] = $sm_d_pf_employer_ctrl[$index];

                    //$data['emp_misc_ded'] = $request['d_miscded' . $value];
                    $data['emp_misc_ded'] = $sm_d_miscded_ctrl[$index];

                    //$data['emp_income_tax'] = $request['d_incometax' . $value];
                    $data['emp_income_tax'] = $sm_d_incometax_ctrl[$index];

                    //$data['other_deduction'] = $request['d_others' . $value];
                    $data['other_deduction'] = $sm_d_others_ctrl[$index];

                    //$data['emp_hrd'] = $request['d_hrd' . $value];
                    $data['emp_hrd'] = $sm_d_hrd_ctrl[$index];

                    //$data['emp_gross_salary'] = $request['emp_total_gross' . $value];
                    $data['emp_gross_salary'] = $sm_emp_total_gross_ctrl[$index];

                    //$data['emp_total_deduction'] = $request['emp_total_deduction' . $value];
                    $data['emp_total_deduction'] = $sm_emp_total_deduction_ctrl[$index];

                    //$data['emp_net_salary'] = $request['emp_net_salary' . $value];
                    $data['emp_net_salary'] = $sm_emp_net_salary_ctrl[$index];
                    
                    $status['status_of_co_op'] = $sm_emp_d_status_co_ctrl[$index];

                    $data['proces_status'] = 'process';
                    $data['created_at'] = date('Y-m-d');

                    //dd($data);

                    $employee_pay_structure = Payroll_detail::where('employee_id', '=', $data['employee_id'])
                        ->where('month_yr', '=', $data['month_yr'])
                        ->first();

                    if (!empty($employee_pay_structure)) {
                        
                        Payroll_detail::where('month_yr', $data['month_yr'])->where('employee_id', $data['employee_id'])->update($data);
                        
                        MonthlyEmployeeCooperative::where('month_yr', $data['month_yr'])->where('emp_code', $data['employee_id'])->update($status);
                        
                        Session::flash('message', 'Record Successfully updated.');
                        // Session::flash('message', 'Payroll already generated for said period');
                    } else {
                        //echo 'Before:::: '.$data['employee_id'].'<br>';
                        Payroll_detail::insert($data);
                        
                        MonthlyEmployeeCooperative::where('month_yr', $data['month_yr'])->where('emp_code', $data['employee_id'])->update($status);
                        
                        $salary_adv_loan=$this->getLoanDeductionValue($data['employee_id'],'SA',$data['month_yr']);
                        $pf_loan=$this->getLoanDeductionValue($data['employee_id'],'PF',$data['month_yr']);
                        
                        
                        // if start for adv non diducated if salary balance 0
                        
                        if($data['emp_gross_salary'] > $data['emp_adv'] ){
                        
                            if(!empty($salary_adv_loan)){
                                //echo('****SA*****');
                                foreach($salary_adv_loan as $rec){
                                    $loanRecovery = new LoanRecovery;
                                    $loanRecovery->loan_id = $rec['id'];
                                    $loanRecovery->amount = $rec['installment_amount'];
                                    $loanRecovery->payout_month = $data['month_yr'];
                                    $loanRecovery->save();
                                }
                            }
                        }
                         // if end for adv non diducated if salary balance 0
                        
                        // if start for pfloan non diducated if salary balance 0
                        
                        if($data['emp_gross_salary'] > $data['emp_pf_loan'] ){
                            if(!empty($pf_loan)){
                                //echo('***PF LOAN*****');
                                foreach($pf_loan as $rec){
                                    $loanRecovery = new LoanRecovery;
                                    $loanRecovery->loan_id = $rec['id'];
                                    $loanRecovery->amount = $rec['installment_amount'];
                                    $loanRecovery->payout_month = $data['month_yr'];
                                    $loanRecovery->save();
                                }
                            }
                        }
                         // if end for pfloan non diducated if salary balance 0

                        //echo 'After:::: '.$data['employee_id'].'<br>';

                        $check_gpf = $this->checkGpfEligibility($data['employee_id']);

                        if (isset($check_gpf->pf) && $check_gpf->pf == '1') {
                            //$this->npsMonthlyEnty($data);
                            $this->gpfMonthlyEnty($data);
                        }
                        Session::flash('message', 'Payroll Information Successfully Saved.');
                    }
                }
            } else {
                Session::flash('error', 'No Payroll Generation is selected');
            }
            //dd('only payrol');
            return redirect('payroll/vw-payroll-generation-all-employee');
        } else {
            return redirect('/');
        }
    }
    public function getProcessPayroll()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['process_payroll'] = "";
            $data['rate_master'] = Rate_master::get();
            return view('payroll/vw-process-payroll', $data);
        } else {
            return redirect('/');
        }
    }
    public function vwProcessPayroll(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            //dd($request->all());
            $data['process_payroll'] = Payroll_detail::where('month_yr', '=', $request->month)
                ->where('proces_status', '=', 'process')
                ->select('payroll_details.*',DB::raw("(SELECT emp_code FROM employee WHERE payroll_details.employee_id=employee.emp_code) as old_emp_code"))
                ->get();

            // print_r(count($data['process_payroll']));
            // die();
            //dd($data);
            if (count($data['process_payroll']) == 0) {
                // print_r('Empty');
                // die();
                Session::flash('error', 'No Data Found.');
            }
            $data['rate_master'] = Rate_master::get();
            $data['monthlist'] = Payroll_detail::select('month_yr')->distinct('month_yr')->get();
            $data['month_yr'] = $request->month;
            //dd($data);

            return view('payroll/vw-process-payroll', $data);
        } else {
            return redirect('/');
        }
    }
    public function updateProcessPayroll(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
             //dd($request->all());
            if (isset($request->deleteme) && $request->deleteme == 'yes') {
                LoanRecovery::where('payout_month','=',$request->deletemy)->delete();
                Payroll_detail::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated payroll records for the month ' . $request->deletemy . ' deleted successfully.');
                return redirect('payroll/vw-process-payroll');
            }

            if (isset($request['payroll_id']) && count($request['payroll_id']) != 0) {
                foreach ($request['payroll_id'] as $payroll) {
                    $dataUpdate = Payroll_detail::where('id', '=', $payroll)
                        ->update(['proces_status' => 'completed']);
                }
                Session::flash('message', 'Pay Detail Save Successfully.');
            } else {
                Session::flash('error', 'No Pay Detail is Selected.');
            }
            return redirect('payroll/vw-process-payroll');
        } else {
            return redirect('/');
        }
    }
    public function deletePayroll($paystructure_id)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $emp_dtl = Payroll_detail::where('id', $paystructure_id)->first();
            $this->deleteNps($emp_dtl->month_yr, $emp_dtl->employee_id);
            $this->deleteGpf($emp_dtl->month_yr, $emp_dtl->employee_id);

            $allloans=Loan::where('emp_code', '=', $emp_dtl->employee_id)
                ->where('deduction', '=', 'Y')
                ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $emp_dtl->month_yr)
                ->get(); 

            foreach($allloans as $loan){
                LoanRecovery::where('loan_id','=',$loan->id)->where('payout_month','=',$emp_dtl->month_yr)->delete();
            }                         


            $result = Payroll_detail::where('id', $paystructure_id)->delete();
            Session::flash('message', 'Pay Detail Deleted Successfully.');
            return redirect('payroll/vw-process-payroll');
        } else {
            return redirect('/');
        }
    }
    public function viewPfOpeningBalance()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['pf_opening_balance'] = PfOpeningBalance::get();

            //dd($data['pf_opening_balance']);
            return view('payroll/view-pf-opening-balance', $data);
        } else {
            return redirect('/');
        }
    }

    public function importPfOpeningBalance(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            try {
                $file = $request->file('import_file');
                if ($file) {
                    $path1 = $request->file('import_file')->store('temp');
                    $path = storage_path('app') . '/' . $path1;
                    $data = Excel::import(new PfOpeningBalanceImport, $path);
                    Session::flash('message', 'Opening Balance Data imported Successfully.');
                    return redirect('payroll/pf-opening-balance');
                }

            } catch (Exception $e) {
                //throw new \App\Exceptions\AdminException($e->getMessage());
                return redirect('payroll/pf-opening-balance')->withErrors($e->getMessage())->withInput();
            }
        } else {
            return redirect('/');
        }
    }
    public function getAdjustPayroll()
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['payroll_rs'] = Payroll_detail::join('employee', 'employee.emp_code', '=', 'payroll_details.employee_id')
                                ->select('employee.old_emp_code', 'payroll_details.*')
                                ->where('payroll_details.emp_adjust_days', '>', 0)
                                ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                                ->get();
            $data['rate_master'] = Rate_master::get();
            //dd($data['payroll_rs'][0]);
            return view('payroll/view-adjust-payroll-generation', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewAdjustPayroll()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Employee'] = Employee::where('status', '=', 'active')->orderBy('emp_fname', 'asc')->get();
            return view('payroll/adjustment-payroll-generation', $data);
        } else {
            return redirect('/');
        }
    }
    public function saveAdjustmentPayrollDetails(Request $request)
    {

        // dd($request->all());
        $email = Session::get('emp_email');
        if (!empty($email)) {

            if (empty($request->emp_gross_salary)) {
                Session::flash('message', 'Gross Salary Cannot be Blank.');
                return redirect('payroll/vw-payroll-generation');
            }

            if (empty($request->emp_total_deduction)) {

                Session::flash('message', 'Total Salary Cannot be Blank.');
                return redirect('payroll/vw-payroll-generation');
            }

            if (empty($request->emp_net_salary)) {

                Session::flash('message', 'Net Salary Cannot be Blank.');
                return redirect('payroll/vw-payroll-generation');
            }

            $monthyr = $request->month_yr;
            $mnt_yr = date('m/Y', strtotime("$monthyr"));

            $data['employee_id'] = $request->empname;
            $data['emp_name'] = $request->emp_name;
            $data['emp_designation'] = $request->emp_designation;
            $data['emp_basic_pay'] = $request->emp_basic_pay;
            $data['month_yr'] = $mnt_yr;
            $data['emp_present_days'] = $request->emp_present_days;
            $data['emp_cl'] = $request->emp_cl;
            $data['emp_el'] = $request->emp_el;
            $data['emp_hpl'] = $request->emp_hpl;
            $data['emp_absent_days'] = $request->emp_absent_days;
            $data['emp_rh'] = $request->emp_rh;
            $data['emp_cml'] = $request->emp_cml;
            $data['emp_eol'] = $request->emp_eol;
            $data['emp_lnd'] = $request->emp_lnd;
            $data['emp_maternity_leave'] = $request->emp_maternity_leave;
            $data['emp_paternity_leave'] = $request->emp_paternity_leave;
            $data['emp_ccl'] = $request->emp_ccl;
            $data['emp_el'] = $request->emp_el;
            $data['emp_da'] = $request->emp_da;
            $data['emp_vda'] = $request->emp_vda;
            $data['emp_hra'] = $request->emp_hra;
            $data['emp_prof_tax'] = $request->emp_prof_tax;
            $data['emp_others_alw'] = $request->emp_others_alw;
            $data['emp_tiff_alw'] = $request->emp_tiff_alw;
            $data['emp_conv'] = $request->emp_conv;
            $data['emp_medical'] = $request->emp_medical;
            $data['emp_misc_alw'] = $request->emp_misc_alw;
            $data['emp_over_time'] = $request->emp_over_time;
            $data['emp_bouns'] = $request->emp_bouns;
            $data['emp_pf'] = $request->emp_pf;
            $data['emp_pf_int'] = $request->emp_pf_int;
            $data['emp_co_op'] = $request->emp_co_op;
            $data['emp_apf'] = $request->emp_apf;
            $data['emp_i_tax'] = $request->emp_i_tax;
            $data['emp_insu_prem'] = $request->emp_insu_prem;
            $data['emp_pf_loan'] = $request->emp_pf_loan;
            $data['emp_esi'] = $request->emp_esi;
            $data['emp_adv'] = $request->emp_adv;
            $data['emp_absent_deduction'] = $request->emp_absent_deduction;
            $data['emp_gross_salary'] = $request->emp_gross_salary;
            $data['emp_hrd'] = $request->emp_hrd;
            $data['emp_gross_salary'] = $request->emp_gross_salary;
            $data['emp_total_deduction'] = $request->emp_total_deduction;
            $data['emp_net_salary'] = $request->emp_net_salary;
            $data['emp_furniture'] = $request->emp_furniture;
            $data['emp_pf_employer'] = $request->emp_pf_employer;
            $data['emp_misc_ded'] = $request->emp_misc_ded;
            $data['emp_leave_inc'] = $request->emp_leave_inc;
            $data['emp_hta'] = $request->emp_hta;
            $data['emp_income_tax'] = $request->emp_income_tax;
            $data['other_deduction'] = $request->other_deduction;
            $data['other_addition'] = $request->other_addition;
            $data['emp_adjust_days'] = $request->emp_adjust_days;
            $data['proces_status'] = 'process';
            $data['created_at'] = date('Y-m-d');
            $status['status_of_co_op']=$request->status_co;

            $employee_pay_structure = Payroll_detail::where('employee_id', '=', $request->empname)
                ->where('month_yr', '=', $mnt_yr)
                ->first();

            if (!empty($employee_pay_structure)) {
                Session::flash('message', 'Payroll for this employee already generated for the month of "' . date('m-Y') . '". ');
            } else {

                Payroll_detail::insert($data);
                MonthlyEmployeeCooperative::where('month_yr', $mnt_yr)->where('emp_code', $request->empname)->update($status);

                $salary_adv_loan=$this->getLoanDeductionValue($request->empname,'SA',$mnt_yr);
                $pf_loan=$this->getLoanDeductionValue($request->empname,'PF',$mnt_yr);

                if(!empty($salary_adv_loan)){
                    foreach($salary_adv_loan as $rec){
                        $loanRecovery = new LoanRecovery;
                        $loanRecovery->loan_id = $rec['id'];
                        $loanRecovery->amount = $request->emp_adv;
                        $loanRecovery->payout_month = $mnt_yr;
                        $loanRecovery->save();
                    }
                }

                if(!empty($pf_loan)){
                    foreach($pf_loan as $rec){
                        $loanRecovery = new LoanRecovery;
                        $loanRecovery->loan_id = $rec['id'];
                        $loanRecovery->amount = $request->emp_pf_loan;
                        $loanRecovery->payout_month = $mnt_yr;
                        $loanRecovery->save();
                    }
                }


                $check_gpf = $this->checkGpfEligibility($data['employee_id']);

                if (isset($check_gpf->pf) && $check_gpf->pf == '1') {
                    //$this->npsMonthlyEnty($data);
                    $this->gpfMonthlyEnty($data);
                }

                Session::flash('message', 'Payroll Information Successfully Saved.');
            }

            return redirect('payroll/vw-adjustment-payroll-generation');
        } else {
            return redirect('/');
        }
    }

    public function getVoucherPayroll()
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['payroll_rs'] = PayrollDummy::join('employee', 'employee.emp_code', '=', 'payroll_dummies.employee_id')
                                ->select('employee.old_emp_code', 'payroll_dummies.*')
                                ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                                ->get();
            $data['rate_master'] = Rate_master::get();
            //dd($data['payroll_rs'][0]);
            return view('payroll/view-voucher-payroll-generation', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewVoucherPayroll()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Employee'] = Employee::where('status', '=', 'active')
                                ->orderByRaw('CAST(employee.old_emp_code AS UNSIGNED) ASC')
                                ->get();
            return view('payroll/voucher-payroll-generation', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveVoucherPayroll(Request $request)
    {

        // dd($request->all());
        $email = Session::get('emp_email');
        if (!empty($email)) {

            if (empty($request->emp_gross_salary)) {
                Session::flash('message', 'Gross Salary Cannot be Blank.');
                return redirect('payroll/vw-voucher-payroll-generation');
            }

            if (empty($request->emp_total_deduction)) {

                Session::flash('message', 'Total Salary Cannot be Blank.');
                return redirect('payroll/vw-voucher-payroll-generation');
            }

            if (empty($request->emp_net_salary)) {

                Session::flash('message', 'Net Salary Cannot be Blank.');
                return redirect('payroll/vw-voucher-payroll-generation');
            }

            $monthyr = $request->month_yr;
            $mnt_yr = date('m/Y', strtotime("$monthyr"));

            $data['employee_id'] = $request->empname;
            $data['emp_name'] = $request->emp_name;
            $data['emp_designation'] = $request->emp_designation;
            $data['emp_basic_pay'] = $request->emp_basic_pay;
            $data['month_yr'] = $mnt_yr;
            $data['emp_present_days'] = $request->emp_present_days;
            $data['emp_cl'] = $request->emp_cl;
            $data['emp_el'] = $request->emp_el;
            $data['emp_hpl'] = $request->emp_hpl;
            $data['emp_absent_days'] = $request->emp_absent_days;
            $data['emp_rh'] = $request->emp_rh;
            $data['emp_cml'] = $request->emp_cml;
            $data['emp_eol'] = $request->emp_eol;
            $data['emp_lnd'] = $request->emp_lnd;
            $data['emp_maternity_leave'] = $request->emp_maternity_leave;
            $data['emp_paternity_leave'] = $request->emp_paternity_leave;
            $data['emp_ccl'] = $request->emp_ccl;
            $data['emp_el'] = $request->emp_el;
            $data['emp_da'] = $request->emp_da;
            $data['emp_vda'] = $request->emp_vda;
            $data['emp_hra'] = $request->emp_hra;
            $data['emp_prof_tax'] = $request->emp_prof_tax;
            $data['emp_others_alw'] = $request->emp_others_alw;
            $data['emp_tiff_alw'] = $request->emp_tiff_alw;
            $data['emp_conv'] = $request->emp_conv;
            $data['emp_medical'] = $request->emp_medical;
            $data['emp_misc_alw'] = $request->emp_misc_alw;
            $data['emp_over_time'] = $request->emp_over_time;
            $data['emp_bouns'] = $request->emp_bouns;
            $data['emp_pf'] = $request->emp_pf;
            $data['emp_pf_int'] = $request->emp_pf_int;
            $data['emp_co_op'] = $request->emp_co_op;
            $data['emp_apf'] = $request->emp_apf;
            $data['emp_i_tax'] = $request->emp_i_tax;
            $data['emp_insu_prem'] = $request->emp_insu_prem;
            $data['emp_pf_loan'] = $request->emp_pf_loan;
            $data['emp_esi'] = $request->emp_esi;
            $data['emp_adv'] = $request->emp_adv;
            $data['emp_absent_deduction'] = $request->emp_absent_deduction;
            $data['emp_gross_salary'] = $request->emp_gross_salary;
            $data['emp_hrd'] = $request->emp_hrd;
            $data['emp_gross_salary'] = $request->emp_gross_salary;
            $data['emp_total_deduction'] = $request->emp_total_deduction;
            $data['emp_net_salary'] = $request->emp_net_salary;
            $data['emp_furniture'] = $request->emp_furniture;
            $data['emp_pf_employer'] = $request->emp_pf_employer;
            $data['emp_misc_ded'] = $request->emp_misc_ded;
            $data['emp_leave_inc'] = $request->emp_leave_inc;
            $data['emp_hta'] = $request->emp_hta;
            $data['emp_income_tax'] = $request->emp_income_tax;
            $data['other_deduction'] = $request->other_deduction;
            $data['other_addition'] = $request->other_addition;
            $data['emp_adjust_days'] = $request->emp_adjust_days;
            $data['proces_status'] = 'process';
            $data['created_at'] = date('Y-m-d');

            $employee_pay_structure = PayrollDummy::where('employee_id', '=', $request->empname)
                ->where('month_yr', '=', $mnt_yr)
                ->first();

            if (!empty($employee_pay_structure)) {
                Session::flash('message', 'Payroll for this employee already generated for the month of "' . date('m-Y') . '". ');
            } else {

                PayrollDummy::insert($data);

                // $salary_adv_loan=$this->getLoanDeductionValue($request->empname,'SA',$mnt_yr);
                // $pf_loan=$this->getLoanDeductionValue($request->empname,'PF',$mnt_yr);

                // if(!empty($salary_adv_loan)){
                //     foreach($salary_adv_loan as $rec){
                //         $loanRecovery = new LoanRecovery;
                //         $loanRecovery->loan_id = $rec['id'];
                //         $loanRecovery->amount = $request->emp_adv;
                //         $loanRecovery->payout_month = $mnt_yr;
                //         $loanRecovery->save();
                //     }
                // }

                // if(!empty($pf_loan)){
                //     foreach($pf_loan as $rec){
                //         $loanRecovery = new LoanRecovery;
                //         $loanRecovery->loan_id = $rec['id'];
                //         $loanRecovery->amount = $request->emp_pf_loan;
                //         $loanRecovery->payout_month = $mnt_yr;
                //         $loanRecovery->save();
                //     }
                // }


                // $check_gpf = $this->checkGpfEligibility($data['employee_id']);

                // if (isset($check_gpf->pf) && $check_gpf->pf == '1') {
                //     //$this->npsMonthlyEnty($data);
                //     $this->gpfMonthlyEnty($data);
                // }

                Session::flash('message', 'Payroll Information Successfully Saved.');
            }

            return redirect('payroll/vw-voucher-payroll-generation');
        } else {
            return redirect('/');
        }
    }

    public function getYearlyBonus()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();
            //dd($data);
            $data['result'] = '';
            

            return view('payroll/yearly-bonus', $data);
        } else {
            return redirect('/');
        }
    }
    public function viewYearlyBonus(Request $request)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            //dd($request->all());

            $data['yearlist'] = YearlyEmployeeBonus::select('year')->distinct('year')->get();

            $data['req_year'] = $request->year;

            $currentBonusRate=$this->getEffectiveBonustRate($request->year);  

            $employee_rs = YearlyEmployeeBonus::join('employee', 'employee.emp_code', '=', 'yearly_employee_bonuses.emp_code')
                ->select('employee.emp_fname', 'employee.emp_mname', 'employee.emp_lname', 'employee.designation', 'employee.old_emp_code', 'yearly_employee_bonuses.*')
                ->where('yearly_employee_bonuses.year', '=', $request->year)
                ->where('yearly_employee_bonuses.status', '=', 'process')
                // ->where('yearly_employee_bonuses.emp_code', '=', '7086')
                ->orderByRaw('cast(employee.old_emp_code as unsigned)', 'asc')
                ->get();

            // dd($employee_rs);
            if (count($employee_rs) == 0) {
                Session::flash('error', 'Bonus for the year ' . $request->year . ' already processed.');
                return redirect('payroll/vw-yearly-bonus');
            }
            $result = '';
            foreach ($employee_rs as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
                <td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
                <td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
                <td>' . $emcode->old_emp_code . '</td>
                <td>' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '</td>
                <td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['year'] . '"></td>
                <td><input type="number" step="any" class="form-control sm_basic" name="basic' . $emcode->emp_code . '" style="width:100%;" value="'.$emcode->basic.'" id="basic_' . $emcode->emp_code . '" onkeyup="calBonus('.$emcode->emp_code.','.$currentBonusRate.')"></td>
                <td><input type="number" step="any" class="form-control sm_bonus" name="bonus' . $emcode->emp_code . '" style="width:100%;" value="'.$emcode->bonus.'" id="bonus_' . $emcode->emp_code . '" readonly></td>
                <td><input type="number" step="any" class="form-control sm_exgratia" name="exgratia' . $emcode->emp_code . '" style="width:100%;" value="'.$emcode->exgratia.'" id="exgratia_' . $emcode->emp_code . '"></td>
                <td><input type="number" step="any" class="form-control sm_deduction" name="deduction' . $emcode->emp_code . '" style="width:100%;" value="'.$emcode->deduction.'" id="deduction_' . $emcode->emp_code . '"></td>';
            }

            $data['result'] = $result;

            return view('payroll/yearly-bonus', $data);
        } else {
            return redirect('/');
        }
    }
    public function addYearlyBonus()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['result'] = '';

            return view('payroll/add-yearly-bonus-all', $data);
        } else {
            return redirect('/');
        }
    }

    function getEffectiveBonustRate($paroll_month){
        $payrolldate = explode('/', $paroll_month);
        $payroll_date = $payrolldate[0];
        $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
        // Converting string to date
        $date = strtotime($datestring);
        //echo date("Y-m-t", $date);
        $last_paroll_month_date = date("Y-m-t", $date);

        $interest=BonusRate::where('effective_from', '<=', $last_paroll_month_date)
                ->where('status','=','active')
                ->orderBy('id', 'desc')
                ->first();

        if(isset($interest->interest)){
            return $interest->interest;
        }else{
            return "8.33";
        }        
    }
    public function deleteNps($month, $emp_code)
    {
        $result = Nps_details::where('month_year', $month)
            ->where('emp_code', $emp_code)
            ->delete();

    }
    public function deleteGpf($month, $emp_code)
    {
        $result = Gpf_details::where('month_year', $month)
            ->where('emp_code', $emp_code)
            ->delete();

    }
    public function empPayrollAjax($empid, $month, $year)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            // dd($month);
            $mnth_yr = $month . '/' . $year;

            //$tomonthyr=date("Y-m-t");
            //$formatmonthyr=date("Y-m-01");
            $tomonthyr = $year . "-" . $month . "-31";
            $formatmonthyr = $year . "-" . $month . "-01";

            $employee_rs = Employee::leftJoin('employee_pay_structures', 'employee_pay_structures.employee_code', '=', 'employee.emp_code')
                ->where('employee.emp_code', '=', $empid)
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
                ->select('employee.*', 'employee_pay_structures.*')->first();

            $leave_rs = Leave_apply::leftJoin('leave_types', 'leave_types.id', '=', 'leave_applies.leave_type')
                ->where('leave_applies.employee_id', '=', $empid)
                ->where('leave_applies.status', '=', 'APPROVED')
                ->where('leave_applies.from_date', '>=', $formatmonthyr)
                ->where('leave_applies.to_date', '<=', $tomonthyr)
                ->select('leave_applies.*', 'leave_types.leave_type_name')
                ->get();

            // $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $empid)
            //     ->where('process_attendances.month_yr', '=', $mnth_yr)
            //     ->first();
            //->toSql();

            //Get Monthly Attandance values
            $process_attendance = Process_attendance::where('process_attendances.employee_code', '=', $empid)
                ->where('process_attendances.month_yr', '=', $mnth_yr)
                ->first();

            //Get Monthly Cooperative values
            $process_cooperative = MonthlyEmployeeCooperative::where('monthly_employee_cooperatives.emp_code', '=', $empid)
                ->where('monthly_employee_cooperatives.month_yr', '=', $mnth_yr)
                ->first();

            //Get Monthly incometax values
            $process_incometax = MonthlyEmployeeItax::where('monthly_employee_itaxes.emp_code', '=', $empid)
                ->where('monthly_employee_itaxes.month_yr', '=', $mnth_yr)
                ->first();

            //Get Monthly allowances values
            $process_allowances = MonthlyEmployeeAllowance::where('monthly_employee_allowances.emp_code', '=', $empid)
                ->where('monthly_employee_allowances.month_yr', '=', $mnth_yr)
                ->first();

            //Get Monthly overtime values
            $process_overtimes = MonthlyEmployeeOvertime::where('monthly_employee_overtimes.emp_code', '=', $empid)
                ->where('monthly_employee_overtimes.month_yr', '=', $mnth_yr)
                ->first();

            $rate_rs = RateDetail::leftJoin('rate_masters', 'rate_masters.id', '=', 'rate_details.rate_id')
                ->select('rate_details.*', 'rate_masters.head_name', 'rate_masters.head_type')
                ->where('rate_details.from_date', '>=', date($year.'-01-01'))
                ->where('rate_details.to_date', '<=', date($year.'-12-31'))
                ->get();

            $salary_adv_loan=$this->getLoanDeductionValue($empid,'SA',$mnth_yr);
            $pf_loan=$this->getLoanDeductionValue($empid,'PF',$mnth_yr);
            $pf_loan_balance=$this->getTotalLoanBalanceValue($empid,'PF',$mnth_yr);
            $effective_pfloan_interest_rate = $this->getEffectivePFLoanInterestRate($mnth_yr);

            echo json_encode(array($employee_rs, $leave_rs, $process_attendance, $rate_rs, $process_cooperative, $process_incometax, $process_allowances,$process_overtimes,$salary_adv_loan,$pf_loan,$pf_loan_balance,$effective_pfloan_interest_rate));
        } else {
            return redirect('/');
        }
    }
    function getLoanDeductionValue($emp_code,$loan_type,$paroll_month){
        $allloans=Loan::where('emp_code', '=', $emp_code)
                ->where('loan_type', '=', $loan_type)
                ->where('deduction', '=', 'Y')
                ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $paroll_month)
                ->get(); 

        $loanDetails=array();

        foreach($allloans as $loan){
            
            // $loan_recoveries_count = LoanRecovery::where('loan_id','=',$loan->id)->count();
            $loanRecoveries=LoanRecovery::where('loan_id','=',$loan->id)->sum('amount');
           
        //   if($loan_recoveries_count > 0){
               if($loan->loan_amount > $loanRecoveries){
                    $ele=array();
                    $ele['id']=$loan->id;
                    $ele['installment_amount']=$loan->installment_amount;
                    array_push($loanDetails,$ele);
                }
                else{
                    $ele=array();
                    $ele['id']=$loan->id;
                    $ele['installment_amount']=0;
                    array_push($loanDetails,$ele);
                }
        //   }else{
        //         $ele=array();
        //         $ele['id']=$loan->id;
        //         $ele['installment_amount']=$loan->installment_amount;
        //         array_push($loanDetails,$ele);
        //   }
           
            
        }

        return $loanDetails;               
    }
    function getTotalLoanBalanceValue($emp_code,$loan_type,$paroll_month){
        $allloans=Loan::where('emp_code', '=', $emp_code)
                    ->where('loan_type', '=', $loan_type)
                    ->where('deduction', '=', 'Y')
                    ->where(DB::raw('DATE_FORMAT(loans.start_month, "%m/%Y")'), '<=', $paroll_month)
                    ->get();
    
            $loanDetails=array();
    
            foreach($allloans as $loan){
                
                $loanRecoveries=LoanRecovery::where('loan_id','=',$loan->id)->sum('amount');
               
                if($loan->loan_amount > $loanRecoveries){
                    $ele=array();
                    $ele['id']=$loan->id;
                    $ele['loan_amount']=$loan->loan_amount;
                    $ele['recoveries']=$loanRecoveries;
                    $ele['balance_amount']=($loan->loan_amount-$loanRecoveries);
                    array_push($loanDetails,$ele);
                }
            }
    
            return $loanDetails;               
    }
    function getEffectivePFLoanInterestRate($paroll_month){
        $payrolldate = explode('/', $paroll_month);
        $payroll_date = $payrolldate[0];
        $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
        // Converting string to date
        $date = strtotime($datestring);
        //echo date("Y-m-t", $date);
        $last_paroll_month_date = date("Y-m-t", $date);

        $interest=Interest::where('effective_from', '<=', $last_paroll_month_date)
                ->where('status','=','active')
                ->orderBy('id', 'desc')
                ->first();

        if(isset($interest->interest)){
            return $interest->interest;
        }else{
            return "9.1";
        }        
    }
    public function checkGpfEligibility($employee_id)
    {

        $check_gpf_status = Employee_pay_structure::where('employee_code', '=', $employee_id)->first();

        return $check_gpf_status;
    }
    


}
