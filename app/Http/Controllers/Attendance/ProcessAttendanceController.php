<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Employee;
use App\Models\Attendance\Process_attendance;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelFileExportAttendanceEntry;

class ProcessAttendanceController extends Controller
{
    public function addMonthlyAttendancePAAllemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['result'] = '';
            $data['ClassName'] = 'add-montly-attendance-data-all';
            return View('attendance/add-monthly-process-attandance-all',$data);
        }

    }
    public function listAttendanceAllemployee(Request $request)
    {
        // dd($request->all());
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['ClassName'] = 'add-montly-attendance-data-all';
            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $month_yr_new = $request['month_yr'];

            // $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
            //     ->select('rate_details.*', 'rate_masters.head_name')
            //     ->get();

            $result = '';
            $emplist = Employee::where('status', '=', 'active')
               // ->where('emp_status', '!=', 'TEMPORARY')
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('emp_fname', 'asc')
                ->get();

                foreach ($emplist as $mainkey => $emcode) {

                    $result .= '<tr id="' . $emcode->emp_code . '">
                                    <td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
                                    <td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
                                    <td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"><input type="hidden" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_designation . '"></td>
                                    <td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>
                                    <td><input type="number" class="form-control sm_n_workingd" name="n_workingd' . $emcode->emp_code . '" style="width:100%;" value="' . $current_month_days . '" id="n_workingd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_presentd" name="n_presentd' . $emcode->emp_code . '" style="width:100%;" value="' . $current_month_days . '" id="n_presentd_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_leaved" name="n_leaved' . $emcode->emp_code . '" style="width:100%;" value="0" id="n_leaved_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_absentd" name="n_absentd' . $emcode->emp_code . '" style="width:100%;" value="0" id="n_absentd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_salaryd" name="n_salaryd' . $emcode->emp_code . '" style="width:100%;" value="' . $current_month_days . '" id="n_salaryd_' . $emcode->emp_code . '" readonly ></td><td><input type="number" class="form-control sm_n_salaryadjd" name="n_salaryadjd' . $emcode->emp_code . '" style="width:100%;" value="0" id="n_salaryadjd_' . $emcode->emp_code . '"  ></td>';
    
                }
                //dd($result);
                return view('attendance/add-monthly-process-attandance-all', compact('result', 'month_yr_new'));
        }

    }
    public function SaveAttendanceAllemployee(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
           // $data['ClassName'] = 'add-montly-attendance-data-all';
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_n_workingd_ctrl = explode(',', $request->sm_n_workingd_ctrl);
                $sm_n_absentd_ctrl = explode(',', $request->sm_n_absentd_ctrl);
                $sm_n_leaved_ctrl = explode(',', $request->sm_n_leaved_ctrl);
                $sm_n_presentd_ctrl = explode(',', $request->sm_n_presentd_ctrl);
                $sm_n_salaryd_ctrl = explode(',', $request->sm_n_salaryd_ctrl);
                $sm_n_salaryadjd_ctrl = explode(',', $request->sm_n_salaryadjd_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    if($value!=""){

                        $data['employee_code'] = $value;
                        //$data['emp_name'] = $request['emp_name' . $value];
                        // $data['emp_name'] = $sm_emp_name_ctrl[$index];
    
                        //$data['emp_designation'] = $request['emp_designation' . $value];
                        //$data['emp_designation'] = $sm_emp_designation_ctrl[$index];
    
                        // $data['month_yr'] = $request['month_yr' . $value];
                        $data['month_yr'] = $sm_month_yr_ctrl[$index];
    
                        $data['no_of_working_days'] = $sm_n_workingd_ctrl[$index];
                        $data['no_of_days_absent'] = $sm_n_absentd_ctrl[$index];
                        $data['no_of_days_leave_taken'] = $sm_n_leaved_ctrl[$index];
                        $data['no_of_present'] = $sm_n_presentd_ctrl[$index];
                        $data['no_of_tour_leave'] = '0';
                        $data['no_of_days_salary'] = $sm_n_salaryd_ctrl[$index];
                        $data['no_sal_adjust_days'] = $sm_n_salaryadjd_ctrl[$index];
    
                        // $data['status'] = 'process';
                        $data['created_at'] = date('Y-m-d H:i:s');
    
                        // dd($data);
                        $process_attendance = Process_attendance::where('employee_code', '=', $value)
                            ->where('month_yr', '=', $data['month_yr'])
                            ->first();
    
                        if (!empty($process_attendance)) {
                             Process_attendance::where('month_yr', $sm_month_yr_ctrl[$index])->where('employee_code', $value)->update($data);
                            Session::flash('message', 'Record Successfully updated.');
                            // Session::flash('error', 'Attendance already generated for said period');
                        } else {
                            Process_attendance::insert($data);
    
                            Session::flash('message', 'Record Successfully Saved.');
    
                        }

                    }    

                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('attendance/add-montly-attendance-data-all');
        } else {
            return redirect('/');
        }
    }
    public function viewMonthlyAttendanceAllemployee(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['ClassName'] = 'view-montly-attendance-data-all';
            $data['result'] = '';
            $data['monthlist'] = Process_attendance::select('month_yr')->distinct('month_yr')->get();
            return view('attendance/set-monthly-process-attandance-all', $data);

        }else{
            return redirect('/');
        }

    }

    public function listMonthlyAttendanceAllemployee(Request $request){
       // dd($request->all());
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $ClassName = 'view-montly-attendance-data-all';
            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $month_yr_new = $request['month_yr'];
            $monthlist = Process_attendance::select('month_yr')->distinct('month_yr')->get();
            $result = '';

            $emplist = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
                ->where('process_attendances.month_yr', '=', $month_yr_new)
                // ->where('process_attendances.status', '=', 'P')
                ->where('employee.emp_status', '!=', 'TEMPORARY')
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                ->orderBy('employee.emp_fname', 'asc')
                ->get();

            if (count($emplist) == 0) {
                Session::flash('error', 'Attendance for the month ' . $month_yr_new . ' already processed.');
                return redirect('attendance/view-montly-attendance-data-all');
            }

            foreach ($emplist as $mainkey => $emcode) {

                $result .= '<tr id="' . $emcode->emp_code . '">
								<td><div class="checkbox"><label><input type="checkbox" name="empcode_check[]" id="chk_' . $emcode->emp_code . '" value="' . $emcode->emp_code . '" class="checkhour"></label></div></td>
								<td><input type="text" readonly class="form-control sm_emp_code" name="emp_code' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_code . '"></td>
								<td><input type="text" readonly class="form-control sm_emp_name" name="emp_name' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '"><input type="hidden" readonly class="form-control sm_emp_designation" name="emp_designation' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->emp_designation . '"></td>
								<td><input type="text" readonly class="form-control sm_month_yr" name="month_yr' . $emcode->emp_code . '" style="width:100%;" value="' . $request['month_yr'] . '"></td>
								<td><input type="number" class="form-control sm_n_workingd" name="n_workingd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_working_days . '" id="n_workingd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_presentd" name="n_presentd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_present . '" id="n_presentd_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_leaved" name="n_leaved' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_days_leave_taken . '" id="n_leaved_' . $emcode->emp_code . '" onkeyup="calculate_days(' . $emcode->emp_code . ');"></td><td><input type="number" class="form-control sm_n_absentd" name="n_absentd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_days_absent . '" id="n_absentd_' . $emcode->emp_code . '" readonly></td><td><input type="number" class="form-control sm_n_salaryd" name="n_salaryd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_of_days_salary . '" id="n_salaryd_' . $emcode->emp_code . '" readonly ></td><td><input type="number" class="form-control sm_n_salaryadjd" name="n_salaryadjd' . $emcode->emp_code . '" style="width:100%;" value="' . $emcode->no_sal_adjust_days . '" id="n_salaryadjd_' . $emcode->emp_code . '"  ></td>';

            }

            return view('attendance/set-monthly-process-attandance-all', compact('result', 'ClassName', 'month_yr_new', 'monthlist'));

        }else{
            return redirect('/');
        }

    }

    public function UpdateAttendanceAllemployee(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {
            // $data['ClassName'] = 'view-montly-attendance-data-all';
            if (isset($request->deleteme) && $request->deleteme == 'yes') {
                Process_attendance::where('month_yr', $request->deletemy)->delete();
                Session::flash('message', 'All generated attendance records deleted successfully.');
                return redirect('attendance/view-montly-attendance-data-all');
            }
            $request->empcode_check = explode(',', $request->cboxes);

            if (isset($request->empcode_check) && count($request->empcode_check) != 0) {

                $sm_emp_code_ctrl = explode(',', $request->sm_emp_code_ctrl);
                $sm_emp_name_ctrl = explode(',', $request->sm_emp_name_ctrl);
                $sm_emp_designation_ctrl = explode(',', $request->sm_emp_designation_ctrl);
                $sm_month_yr_ctrl = explode(',', $request->sm_month_yr_ctrl);

                $sm_n_workingd_ctrl = explode(',', $request->sm_n_workingd_ctrl);
                $sm_n_absentd_ctrl = explode(',', $request->sm_n_absentd_ctrl);
                $sm_n_leaved_ctrl = explode(',', $request->sm_n_leaved_ctrl);
                $sm_n_presentd_ctrl = explode(',', $request->sm_n_presentd_ctrl);
                $sm_n_salaryd_ctrl = explode(',', $request->sm_n_salaryd_ctrl);
                $sm_n_salaryadjd_ctrl = explode(',', $request->sm_n_salaryadjd_ctrl);

                foreach ($request->empcode_check as $key => $value) {

                    $index = array_search($value, $sm_emp_code_ctrl);

                    if($value !=""){
                        $data['employee_code'] = $value;
                        $data['month_yr'] = $sm_month_yr_ctrl[$index];
                        $data['no_of_working_days'] = $sm_n_workingd_ctrl[$index];
                        $data['no_of_days_absent'] = $sm_n_absentd_ctrl[$index];
                        $data['no_of_days_leave_taken'] = $sm_n_leaved_ctrl[$index];
                        $data['no_of_present'] = $sm_n_presentd_ctrl[$index];
                        $data['no_of_tour_leave'] = '0';
                        $data['no_of_days_salary'] = $sm_n_salaryd_ctrl[$index];
                        $data['no_sal_adjust_days'] = $sm_n_salaryadjd_ctrl[$index];
                        $data['status'] = 'A';
                        $data['updated_at'] = date('Y-m-d H:i:s');
                        Process_attendance::where('month_yr', $sm_month_yr_ctrl[$index])->where('employee_code', $value)->update($data);
                        Session::flash('message', 'Record Successfully updated.');
                    }
                }
            } else {
                Session::flash('error', 'No Record is selected');
            }

            return redirect('attendance/view-montly-attendance-data-all');

        }else{
            return redirect('/');
        }

    }
    public function reportMonthlyAttendanceAllemployee()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['result'] = '';
            $data['monthlist'] = Process_attendance::select('month_yr')->distinct('month_yr')->get();

            return view('attendance/report-monthly-attandance', $data);
        } else {
            return redirect('/');
        }
    }
    public function getMonthlyAttendanceReport(Request $request)
    {
       

        $email = Session::get('emp_email');
        if (!empty($email)) {
        
            $req_month=$request['month_yr'];
           
            $payrolldate = explode('/', $request['month_yr']);
            $payroll_date = "0" . ($payrolldate[0] - 2);
            $origDate = $payroll_date . "/" . $payrolldate[1];

            //$current_month_days = cal_days_in_month(CAL_GREGORIAN, $payrolldate[0], $payrolldate[1]);
            //dd($current_month_days);
            $datestring = $payrolldate[1] . '-' . $payrolldate[0] . '-01';
            // Converting string to date
            $date = strtotime($datestring);
            $current_month_days = date("t", strtotime(date("Y-m-t", $date)));

            $tomonthyr = $payrolldate[1] . "-" . $payroll_date . "-" . $current_month_days;
            $formatmonthyr = $payrolldate[1] . "-" . $payroll_date . "-01";

            $month_yr_new = $request['month_yr'];
            $monthlist = Process_attendance::select('month_yr')->distinct('month_yr')->get();

            // $rate_rs = Rate_master::leftJoin('rate_details', 'rate_details.rate_id', '=', 'rate_masters.id')
            //     ->select('rate_details.*', 'rate_masters.head_name')
            //     ->get();

            $result = '';

            $emplist = Process_attendance::join('employee', 'employee.emp_code', '=', 'process_attendances.employee_code')
                ->where('process_attendances.month_yr', '=', $month_yr_new)
                ->where('process_attendances.status', '=', 'A')
                ->where('employee.emp_status', '!=', 'TEMPORARY')
                ->where('employee.emp_status', '!=', 'EX-EMPLOYEE')
                ->where('employee.emp_status', '!=', 'EX- EMPLOYEE')
            // ->where('employees.emp_code', '=', '1831')
                // ->orderByRaw('cast(employee.emp_code as unsigned)', 'asc')
                ->get();
// dd($emplist);
            // if (count($emplist) == 0) {
            //     Session::flash('error', 'Attendance for the month ' . $month_yr_new . ' already processed.');
            //     return redirect('attendance/view-montly-attendance-data-all');
            // }
            $cnt=0;
            foreach ($emplist as $mainkey => $emcode) {

                $cnt=$cnt+1;

                $result .= '<tr>
								<td>'.$cnt.'</td>
								<td>' . $emcode->emp_code . '</td>
								<td>' . $emcode->emp_fname . ' ' . $emcode->emp_mname . ' ' . $emcode->emp_lname . '</td>
								<td>' . $request['month_yr'] . '</td>
								<td>' . $emcode->no_of_working_days . '</td>
                                <td>' . $emcode->no_of_present . '</td>
                                <td>' . $emcode->no_of_days_leave_taken . '</td>
                                <td>' . $emcode->no_of_days_absent . '</td>
                                <td>' . $emcode->no_of_days_salary . '</td>
                                <td>' . $emcode->no_sal_adjust_days . '</td>';

            }
            return view('attendance/report-monthly-attandance', compact('result','month_yr_new', 'monthlist','req_month'));
        } else {
            return redirect('/');
        }
    }
    public function attandence_xlsexport(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {
            
            $month_yr = '';
            if (isset($request->month_yr)) {
                $month_yr = $request->month_yr;
            }
            $month_yr_str='';
            if($month_yr!=''){
                $month_yr_str=explode('/',$month_yr);
                $month_yr_str=implode('-',$month_yr_str);
            }

            return Excel::download(new ExcelFileExportAttendanceEntry($month_yr), 'AttendanceReport-'.$month_yr_str.'.xlsx');
        
        } else {
            return redirect('/');
        }
        

    }



}

