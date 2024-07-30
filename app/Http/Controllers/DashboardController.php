<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Mail;
use URL;
use PDF;
use Session;
use view;

class DashboardController extends Controller
{
    public function getamployeedas()
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['employee_active'] = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')

                ->where('employee.emid', '=', $Roledata->reg)
                ->where('users.emid', '=', $Roledata->reg)
                ->where('users.status', '=', 'active')
                ->where('users.user_type', '=', 'employee')
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->select('users.*')->get();
            $data['employee_inactive'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();

            $data['employee_migarnt'] = DB::table('users')
                ->join('employee', 'users.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('users.emid', '=', $Roledata->reg)
                ->where('users.status', '=', 'active')
                ->where(function ($query) {
                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->where(function ($query) {
                    $query->whereNotNull('employee.visa_doc_no')
                        //->orWhereNotNull('employee.visa_exp_date')
                        //->orWhereNotNull('employee.euss_exp_date')
                        ->orWhereNotNull('employee.euss_ref_no')
                        ;
                })
                ->where('users.user_type', '=', 'employee')
                ->select('employee.*')
                ->get();

            $data['employee_suspened'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'SUSPEND')
                ->get();
            $data['employee_complete'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();
            $data['employee_incomplete'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'not approved')
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();

            $data['employee_constuct'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'CONTRACTUAL')
                ->get();
            $data['employee_fulltime'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'FULL TIME')
                ->get();
            $data['employee_regular'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'REGULAR')
                ->get();
            $data['employee_parttime'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'PART TIME')
                ->get();
            $data['employee_ex_empoyee'] = DB::table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where('verify_status', '=', 'approved')
                ->where('emp_status', '=', 'LEFT')
                ->get();
            return view('dashboard/dashboard', $data);

        } else {
            return redirect('/');
        }
    }

    public function viewAddCompany()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['cuurenci_master'] = DB::table('currencies')->get();
            $data['nat_or_master'] = DB::table('nat_or')->get();
            $data['type_or_master'] = DB::table('type_or')->get();
            $data['employee_upload_rs'] = DB::table('company_upload')
                ->where('emid', '=', $data['Roledata']->reg)
                ->get();
            $data['employee_or_rs'] = DB::table('company_employee')
                ->where('emid', '=', $data['Roledata']->reg)
                ->get();
            return View('dashboard/edit-company', $data);
        } else {
            return redirect('/');
        }

    }

    public function getEmployees()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_rs'] = DB::table('employee')
            ->where('emid', '=', $Roledata->reg)
            ->where(function ($query) {

                $query->whereNull('employee.emp_status')
                    ->orWhere('employee.emp_status', '!=', 'LEFT');
            })
            ->get();

            return view('dashboard/employee', $data);
        } else {
            return redirect('/');
        }
    }
    public function getEmployeesdossier()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            return view('dashboard/employee-dossier', $data);
        } else {
            return redirect('/');
        }
    }

    public function getEmployeesmigrant()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            // $data['employee_rs'] = DB::table('employee')
            //     ->where('emid', '=', $Roledata->reg)
            //     ->where(function ($query) {
            //         $query->whereNull('employee.emp_status')
            //             ->orWhere('employee.emp_status', '!=', 'LEFT');
            //     })
            //     ->where(function ($query) {
            //         $query->whereNotNull('employee.visa_doc_no')
            //             //->orWhereNotNull('employee.visa_exp_date')
            //             //->orWhereNotNull('employee.euss_exp_date')
            //             ->orWhereNotNull('employee.euss_ref_no')
            //             ;
            //     })

            //     ->get();

                $data['employee_rs'] = DB::table('users')
                ->join('employee', 'users.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('users.emid', '=', $Roledata->reg)
                ->where('users.status', '=', 'active')
                ->where(function ($query) {
                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->where(function ($query) {
                    $query->whereNotNull('employee.visa_doc_no')
                        //->orWhereNotNull('employee.visa_exp_date')
                        //->orWhereNotNull('employee.euss_exp_date')
                        ->orWhereNotNull('employee.euss_ref_no')
                        ;
                })
                ->where('users.user_type', '=', 'employee')
                ->select('employee.*')
                ->get();

            // dd($data['employee_rs']);

            return view('dashboard/employee-migrant', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewattendanabsent()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

            return view('dashboard/absent-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function getattendanabsent(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $at = 1;

            $increment = 0;

            $data['result'] = '';

            for ($y = 1; $y < 13; $y++) {
                if ($y <= 9) {
                    $y = '0' . $y;
                } else {
                    $y = $y;
                }
                $first_day_this_year = $request->year_value . '-' . $y . '-01';
                $my_year = $request->year_value;
                if ($y == '01' || $y == '03' || $y == '05' || $y == '07' || $y == '08' || $y == '10' || $y == '12') {
                    $last_day_this_year = $request->year_value . '-' . $y . '-31';
                }

                if ($y == '04' || $y == '06' || $y == '09' || $y == '11') {
                    $last_day_this_year = $request->year_value . '-' . $y . '-30';
                }

                if ($y == '02') {
                    if ($my_year % 400 == 0) {
                        $last_day_this_year = $request->year_value . '-' . $y . '-29';

                    }

                    if ($my_year % 4 == 0) {
                        $last_day_this_year = $request->year_value . '-' . $y . '-29';

                    } else if ($my_year % 100 == 0) {
                        $last_day_this_year = $request->year_value . '-' . $y . '-28';

                    } else {
                        $last_day_this_year = $request->year_value . '-' . $y . '-28';

                    }
                }

                $filename =

                $per_day_salary = $late_salary_deducted = $no_of_days_salary_deducted = $no_of_days_salary = 0;

                $working_day = 30;

                $department = $request->department;
                $designation = $request->designation;

                $employee_desigrs = DB::table('designation')
                    ->where('id', '=', $designation)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $employee_depers = DB::table('department')
                    ->where('id', '=', $department)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();

                $holidays = DB::table('holiday')->where('from_date', '>=', $first_day_this_year)
                    ->where('to_date', '<=', $last_day_this_year)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                $totday = 0;
                $offgholi = array();
                foreach ($holidays as $holiday) {
                    $totday = $totday + $holiday->day;
                    if ($holiday->day > 1) {

                        for ($weh = date('d', strtotime($holiday->from_date)); $weh <= date('d', strtotime($holiday->to_date)); $weh++) {
                            if ($weh < 10 && $weh != '01') {
                                $weh = '0' . $weh;
                            } else if ($weh == '01') {
                                $weh = $weh;
                            } else {
                                $weh = $weh;
                            }

                            $offgholi[] = date('Y-m', strtotime($holiday->from_date)) . '-' . $weh;
                        }
                    } else {
                        $offgholi[] = $holiday->from_date;
                    }
                }

                $total_wk_days = 0;
                $date1_ts = strtotime($first_day_this_year);
                $date2_ts = strtotime($last_day_this_year);
                $diff = $date2_ts - $date1_ts;

                $total_wk_days = (round($diff / 86400) + 1);

                $emp_v = $request->employee_code;

                $employee_rs = DB::Table('employee')
                    ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                    ->whereBetween('attandence.date', [$first_day_this_year, $last_day_this_year])
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_code', '=', $emp_v)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->select('employee.*')
                    ->distinct()
                    ->get();

                if (count($employee_rs) != 0) {

                    foreach ($employee_rs as $emp) {
                        $tour_leave_count = 0;
                        $number_of_days_leave = 0;
                        $leave_apply_rs = DB::select(DB::raw("SELECT SUM(no_of_leave) as number_of_days ,SUM(status),(to_date) as to_date , from_date as from_date FROM `leave_apply` WHERE employee_id='$emp->emp_code' and emid='$Roledata->reg'
        AND status='APPROVED' AND (to_date  between '$first_day_this_year' and '$last_day_this_year' OR from_date  between '$first_day_this_year' and '$last_day_this_year')"));

                        //dd(count($tour_leave));
                        if ($leave_apply_rs[0]->number_of_days != null) {
                            for ($wehgg = date('d', strtotime($first_day_this_year)); $wehgg <= date('d', strtotime($last_day_this_year)); $wehgg++) {
                                if ($wehgg < 10 && $wehgg != '01') {
                                    $wehgg = '0' . $wehgg;
                                } else if ($wehgg == '01') {
                                    $wehgg = $wehgg;
                                } else {
                                    $wehgg = $wehgg;
                                }
                                if ($leave_apply_rs[0]->from_date <= date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg && $leave_apply_rs[0]->to_date >= date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg) {

                                    $laevepp = DB::table('leave_apply')

                                        ->where('employee_id', '=', $emp->emp_code)
                                        ->where('emid', '=', $Roledata->reg)
                                        ->where('from_date', '<=', date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg)
                                        ->where('to_date', '>=', date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg)
                                        ->where('status', '=', 'APPROVED')
                                        ->orderBy('id', 'DESC')
                                        ->first();
                                    if (!empty($laevepp)) {

                                        $leave_typenewmm = $laevepp->leave_type;
                                        $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                        if ($leave_tyepenew->alies == 'H') {
                                            if (in_array(date('l', strtotime(date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg)), $offg)) {

                                            } else {
                                                $number_of_days_leave = $number_of_days_leave + 1;
                                            }

                                        } else {
                                            $number_of_days_leave = $number_of_days_leave + 1;
                                        }
                                    }

                                }

                            }
                        }

                        if ($number_of_days_leave == null) {
                            $number_of_days_leave = 0;
                        }

                        $no_of_present = 0;
                        $mon_y = date('m/Y', strtotime($first_day_this_year));

                        $upload_attendence =
                        DB::table('attandence')

                            ->where('employee_code', '=', $emp->emp_code)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('month', '=', $mon_y)
                            ->groupBy('date')
                            ->get();

                        if (count($upload_attendence) != 0) {
                            $no_of_present = count($upload_attendence);
                        } else {
                            $no_of_present = 0;
                        }

                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp->emp_code)
                            ->where('emid', '=', $Roledata->reg)

                            ->where('end_date', '>=', $first_day_this_year)
                            ->orderBy('id', 'DESC')
                            ->first();
                        if (!empty($duty_auth)) {

                            $shift_auth = DB::table('shift_management')

                                ->where('id', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();
                            $off_auth = DB::table('offday')

                                ->where('shift_code', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();

                            $off_day = 0;
                            if (!empty($off_auth)) {
                                if ($off_auth->sun == '1') {

                                    $off_day = $off_day + 1;
                                    $offg[] = 'Sunday';
                                }
                                if ($off_auth->mon == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Monday';
                                }

                                if ($off_auth->tue == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Tuesday';
                                }

                                if ($off_auth->wed == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Wednesday';
                                }

                                if ($off_auth->thu == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Thursday';
                                }

                                if ($off_auth->fri == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Friday';
                                }
                                if ($off_auth->sat == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Saturday';
                                }

                            }
                            $new_off = 0;
                            for ($we = date('d', strtotime($first_day_this_year)); $we <= $total_wk_days; $we++) {

                                if ($we < 10 && $we != '01') {
                                    $we = '0' . $we;
                                } else if ($we == '01') {
                                    $we = $we;
                                } else {
                                    $we = $we;
                                }

                                $new_f = date('Y-m', strtotime($first_day_this_year)) . '-' . $we;

                                $laeveppnre = DB::table('leave_apply')

                                    ->where('employee_id', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('from_date', '<=', $new_f)
                                    ->where('to_date', '>=', $new_f)
                                    ->where('status', '=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                if ($off_day >= 1) {
                                    if (empty($laeveppnre)) {
                                        if (in_array(date('l', strtotime($new_f)), $offg)) {

                                            if (in_array($new_f, $offgholi)) {

                                            } else {
                                                $new_off = $new_off + 1;
                                            }

                                        } else {

                                        }

                                    }
                                }

                            }
                            $off_day = $new_off;
                        } else {
                            $off_day = 0;
                        }

                        $absent_days = 0;
                        $totleave_present = $no_of_present + $number_of_days_leave + $tour_leave_count;

                        $absent_days = $total_wk_days - $totleave_present - $off_day - $totday;

                        $totsal = $no_of_present + $number_of_days_leave + $off_day + $totday;
                        $total_salary_deduction = $total_wk_days - $totsal + $off_day + $totday;

                        if (!empty($no_of_present)) {
                            $data['result'] .= '<tr>


								<input type="hidden" class="form-control" readonly="" name="department" value="' . $department . '">
									<input type="hidden" class="form-control" readonly="" name="designation" value="' . $designation . '">

								<input type="hidden" class="form-control" readonly="" name="no_of_working_days' . $at . '" value="' . $total_wk_days . '">

                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_absent' . $at . '" value="' . $absent_days . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_leave_taken' . $at . '" value="' . $number_of_days_leave . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_present' . $at . '" value="' . $no_of_present . '">
                                                                <input type="hidden" class="form-control" readonly="" name="total_sal' . $at . '" value="' . $totsal . '">
								<td>' . $at . '</td>
							<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
								<td>' . $emp->emp_code . '</td>
								<td>' . $emp->emp_fname . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname . '</td>
									<td>' . date('F', strtotime($y . '/10/2020')) . '</td>

									<td>' . $total_wk_days . '</td>

								<td>' . $no_of_present . '</td>



								<td>' . $number_of_days_leave . '</td>



							</tr>';
                            $increment++;
                            $at++;
                        }

                    }
                } else {

                    $emp_v = $request->employee_code;

                    $employee_rs_emp = DB::Table('employee')

                        ->where('emid', '=', $Roledata->reg)
                        ->where(function ($query) {

                            $query->whereNull('employee.emp_status')
                                ->orWhere('employee.emp_status', '!=', 'LEFT');
                        })
                        ->where('emp_code', '=', $emp_v)
                        ->where('emp_designation', '=', $employee_desigrs->designation_name)
                        ->where('emp_department', '=', $employee_depers->department_name)
                        ->select('employee.*')
                        ->distinct()
                        ->get();

                    foreach ($employee_rs_emp as $emp) {
                        $tour_leave_count = 0;
                        $number_of_days_leave = 0;

                        $leave_apply_rs = DB::select(DB::raw("SELECT SUM(no_of_leave) as number_of_days ,SUM(status),(to_date) as to_date , from_date as from_date FROM `leave_apply` WHERE employee_id='$emp->emp_code' and emid='$Roledata->reg'
        AND status='APPROVED' AND (to_date  between '$first_day_this_year' and '$last_day_this_year' OR from_date  between '$first_day_this_year' and '$last_day_this_year')"));

                        //dd(count($tour_leave));

                        if ($number_of_days_leave == null) {
                            $number_of_days_leave = 0;
                        }

                        $no_of_present = 0;
                        $mon_y = date('m/Y', strtotime($first_day_this_year));

                        $upload_attendence =
                        DB::table('attandence')

                            ->where('employee_code', '=', $emp->emp_code)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('month', '=', $mon_y)
                            ->groupBy('date')
                            ->get();

                        if (count($upload_attendence) != 0) {
                            $no_of_present = count($upload_attendence);
                        } else {
                            $no_of_present = 0;
                        }

                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp->emp_code)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('end_date', '>=', $first_day_this_year)

                            ->orderBy('id', 'DESC')
                            ->first();
                        if (!empty($duty_auth)) {

                            $shift_auth = DB::table('shift_management')

                                ->where('id', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();
                            $off_auth = DB::table('offday')

                                ->where('shift_code', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();

                            $off_day = 0;
                            if (!empty($off_auth)) {
                                if ($off_auth->sun == '1') {

                                    $off_day = $off_day + 1;
                                    $offg[] = 'Sunday';
                                }
                                if ($off_auth->mon == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Monday';
                                }

                                if ($off_auth->tue == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Tuesday';
                                }

                                if ($off_auth->wed == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Wednesday';
                                }

                                if ($off_auth->thu == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Thursday';
                                }

                                if ($off_auth->fri == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Friday';
                                }
                                if ($off_auth->sat == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Saturday';
                                }

                            }
                            $new_off = 0;
                            for ($we = date('d', strtotime($first_day_this_year)); $we <= $total_wk_days; $we++) {

                                if ($we < 10 && $we != '01') {
                                    $we = '0' . $we;
                                } else if ($we == '01') {
                                    $we = $we;
                                } else {
                                    $we = $we;
                                }

                                $new_f = date('Y-m', strtotime($first_day_this_year)) . '-' . $we;
                                $laeveppnre = DB::table('leave_apply')

                                    ->where('employee_id', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('from_date', '<=', $new_f)
                                    ->where('to_date', '>=', $new_f)
                                    ->where('status', '=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                if ($off_day >= 1) {
                                    if (empty($laeveppnre)) {
                                        if (in_array(date('l', strtotime($new_f)), $offg)) {

                                            if (in_array($new_f, $offgholi)) {

                                            } else {
                                                $new_off = $new_off + 1;
                                            }

                                        } else {

                                        }

                                    }
                                }

                            }
                            $off_day = $new_off;

                        } else {
                            $off_day = 0;
                        }
                        if ($leave_apply_rs[0]->number_of_days != null) {
                            for ($wehgg = date('d', strtotime($first_day_this_year)); $wehgg <= date('d', strtotime($last_day_this_year)); $wehgg++) {
                                if ($wehgg < 10 && $wehgg != '01') {
                                    $wehgg = '0' . $wehgg;
                                } else if ($wehgg == '01') {
                                    $wehgg = $wehgg;
                                } else {
                                    $wehgg = $wehgg;
                                }
                                if ($leave_apply_rs[0]->from_date <= date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg && $leave_apply_rs[0]->to_date >= date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg) {

                                    $laevepp = DB::table('leave_apply')

                                        ->where('employee_id', '=', $emp->emp_code)
                                        ->where('emid', '=', $Roledata->reg)
                                        ->where('from_date', '<=', date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg)
                                        ->where('to_date', '>=', date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg)
                                        ->where('status', '=', 'APPROVED')
                                        ->orderBy('id', 'DESC')
                                        ->first();
                                    if (!empty($laevepp)) {

                                        $leave_typenewmm = $laevepp->leave_type;
                                        $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                        if ($leave_tyepenew->alies == 'H') {
                                            if (in_array(date('l', strtotime(date('Y-m', strtotime($first_day_this_year)) . '-' . $wehgg)), $offg)) {

                                            } else {
                                                $number_of_days_leave = $number_of_days_leave + 1;
                                            }

                                        } else {
                                            $number_of_days_leave = $number_of_days_leave + 1;
                                        }
                                    }

                                }

                            }
                        }
                        $absent_days = 0;
                        $totleave_present = $no_of_present + $number_of_days_leave + $tour_leave_count;

                        $absent_days = $total_wk_days - $totleave_present - $off_day - $totday;

                        $totsal = $no_of_present + $number_of_days_leave + $off_day + $totday;
                        $total_salary_deduction = $total_wk_days - $totsal + $off_day + $totday;

                        $data['result'] .= '<tr>


								<input type="hidden" class="form-control" readonly="" name="department" value="' . $department . '">
									<input type="hidden" class="form-control" readonly="" name="designation" value="' . $designation . '">

								<input type="hidden" class="form-control" readonly="" name="no_of_working_days' . $at . '" value="' . $total_wk_days . '">

                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_absent' . $at . '" value="' . $absent_days . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_leave_taken' . $at . '" value="' . $number_of_days_leave . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_present' . $at . '" value="' . $no_of_present . '">
                                                                <input type="hidden" class="form-control" readonly="" name="total_sal' . $at . '" value="' . $totsal . '">
								<td>' . $at . '</td>
							<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
								<td>' . $emp->emp_code . '</td>
								<td>' . $emp->emp_fname . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname . '</td>
									<td>' . date('F', strtotime($y . '/10/2020')) . '</td>

									<td>' . $total_wk_days . '</td>

								<td>' . $no_of_present . '</td>



								<td>' . $number_of_days_leave . '</td>


							</tr>';
                        $increment++;
                        $at++;

                    }

                }

            }
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
            $data['employee_code'] = $request->employee_code;
            $data['year_value'] = $request->year_value;

            return view('dashboard/absent-list', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewattendanabsentreport($absent_id, $year_value)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            $data['employee_code'] = base64_decode($absent_id);
            $data['year_value'] = base64_decode($year_value);

            $data['employee_code'] = base64_decode($absent_id);
            $data['year_value'] = base64_decode($year_value);

            $employee_code = base64_decode($absent_id);
            $year_value = base64_decode($year_value);
            $increment = 0;

            $data['result'] = '';

            $employeenmae = DB::Table('employee')

                ->where('emid', '=', $Roledata->reg)
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->where('emp_code', '=', $data['employee_code'])

                ->select('employee.*')
                ->distinct()
                ->first();
            $data['employeenmae'] = $employeenmae;
            $resultnew = '';

            for ($y = 1; $y < 13; $y++) {
                $off_day = 0;
                $sun = '';
                $mon = '';
                $tue = '';
                $wed = '';
                $thu = '';
                $fri = '';
                $sat = '';
                if ($y <= 9) {
                    $y = '0' . $y;
                } else {
                    $y = $y;
                }
                $my_year = $year_value;
                $first_day_this_year = $year_value . '-' . $y . '-01';
                if ($y == '01' || $y == '03' || $y == '05' || $y == '07' || $y == '08' || $y == '10' || $y == '12') {
                    $last_day_this_year = $year_value . '-' . $y . '-31';
                    $last_day = '31';
                }

                if ($y == '04' || $y == '06' || $y == '09' || $y == '11') {
                    $last_day_this_year = $year_value . '-' . $y . '-30';
                    $last_day = '30';
                }

                if ($y == '02') {
                    if ($my_year % 400 == 0) {
                        $last_day_this_year = $year_value . '-' . $y . '-29';
                        $last_day = '29';
                    }

                    if ($my_year % 4 == 0) {
                        $last_day_this_year = $year_value . '-' . $y . '-29';
                        $last_day = '29';
                    } else if ($my_year % 100 == 0) {
                        $last_day_this_year = $year_value . '-' . $y . '-28';
                        $last_day = '28';
                    } else {
                        $last_day_this_year = $year_value . '-' . $y . '-28';
                        $last_day = '28';
                    }

                }

                $filename =

                $per_day_salary = $late_salary_deducted = $no_of_days_salary_deducted = $no_of_days_salary = 0;

                $working_day = 30;

                $holidays = DB::table('holiday')->where('from_date', '>=', $first_day_this_year)
                    ->where('to_date', '<=', $last_day_this_year)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                $totday = 0;
                $offgholi = array();
                foreach ($holidays as $holiday) {
                    $totday = $totday + $holiday->day;
                    if ($holiday->day > 1) {

                        for ($weh = date('d', strtotime($holiday->from_date)); $weh <= date('d', strtotime($holiday->to_date)); $weh++) {
                            if ($weh < 10 && $weh != '01') {
                                $weh = '0' . $weh;
                            } else if ($weh == '01') {
                                $weh = $weh;
                            } else {
                                $weh = $weh;
                            }

                            $offgholi[] = date('Y-m', strtotime($holiday->from_date)) . '-' . $weh;
                        }
                    } else {
                        $offgholi[] = $holiday->from_date;
                    }
                }

                $total_wk_days = 0;
                $date1_ts = strtotime($first_day_this_year);
                $date2_ts = strtotime($last_day_this_year);
                $diff = $date2_ts - $date1_ts;

                $total_wk_days = (round($diff / 86400) + 1);

                $emp_v = $employee_code;
                $employee_data_new = DB::Table('employee')

                    ->where('emid', '=', $Roledata->reg)

                    ->where('emp_code', '=', $emp_v)

                    ->select('employee.*')

                    ->first();
                $join_date = '';

                if ($employee_data_new->emp_doj != '1970-01-01') {if ($employee_data_new->emp_doj != '') {$join_date = $employee_data_new->emp_doj;}}

                $employee_rs = DB::Table('employee')
                    ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                    ->whereBetween('attandence.date', [$first_day_this_year, $last_day_this_year])
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_code', '=', $emp_v)

                    ->select('employee.*')
                    ->distinct()
                    ->get();

                if (count($employee_rs) != 0) {

                    foreach ($employee_rs as $emp) {

                        $yes = date('Y', strtotime($first_day_this_year));

                        $duty_authco = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp->emp_code)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('start_date', 'like', $yes . '%')

                            ->orderBy('id', 'DESC')
                            ->get();
                        if (count($duty_authco) == 1) {
                            $duty_auth = DB::table('duty_roster')

                                ->where('employee_id', '=', $emp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('end_date', '>=', $first_day_this_year)

                                ->orderBy('id', 'DESC')
                                ->first();
                        } else if (count($duty_authco) > 1) {
                            $duty_auth = DB::table('duty_roster')

                                ->where('employee_id', '=', $emp->emp_code)
                                ->where('emid', '=', $Roledata->reg)

                                ->where('start_date', '>=', $first_day_this_year)
                                ->where('end_date', '<=', $last_day_this_year)
                                ->orderBy('id', 'DESC')
                                ->first();
                        }

                        $offg = array();

                        if (!empty($duty_auth)) {

                            $shift_auth = DB::table('shift_management')

                                ->where('id', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();
                            $off_auth = DB::table('offday')

                                ->where('shift_code', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();

                            $off_day = 0;
                            $sun = '';
                            $mon = '';
                            $tue = '';
                            $wed = '';
                            $thu = '';
                            $fri = '';
                            $sat = '';
                            if (!empty($off_auth)) {
                                if ($off_auth->sun == '1') {
                                    $sun = 'Sunday';
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Sunday';
                                }
                                if ($off_auth->mon == '1') {
                                    $off_day = $off_day + 1;
                                    $mon = 'Monday';
                                    $offg[] = 'Monday';
                                }

                                if ($off_auth->tue == '1') {
                                    $off_day = $off_day + 1;
                                    $tue = 'Tuesday';
                                    $offg[] = 'Tuesday';
                                }

                                if ($off_auth->wed == '1') {
                                    $off_day = $off_day + 1;
                                    $wed = 'Wednesday';
                                    $offg[] = 'Wednesday';
                                }

                                if ($off_auth->thu == '1') {
                                    $off_day = $off_day + 1;
                                    $thu = 'Thursday';
                                    $offg[] = 'Thursday';
                                }

                                if ($off_auth->fri == '1') {
                                    $off_day = $off_day + 1;
                                    $fri = 'Friday';
                                    $offg[] = 'Friday';
                                }
                                if ($off_auth->sat == '1') {
                                    $off_day = $off_day + 1;
                                    $sat = 'Saturday';
                                    $offg[] = 'Saturday';
                                }

                            }
                            $new_off = 0;
                            for ($we = date('d', strtotime($first_day_this_year)); $we <= $total_wk_days; $we++) {

                                if ($we < 10 && $we != '01') {
                                    $we = '0' . $we;
                                } else if ($we == '01') {
                                    $we = $we;
                                } else {
                                    $we = $we;
                                }

                                $new_f = date('Y-m', strtotime($first_day_this_year)) . '-' . $we;

                                if ($off_day > 1) {
                                    if (in_array(date('l', strtotime($new_f)), $offg)) {
                                        $new_off = $new_off + 1;
                                    } else {

                                    }

                                }
                            }
                            $off_day = $new_off;
                        } else {
                            $off_day = 0;
                        }

                        $resultnew .= '<tr class="tr-calender">
    <td class="mo">

		' . date('M', strtotime($y . '/10/2020')) . '</td>


          ';

                        for ($m = 1; $m < 32; $m++) {
                            if ($m <= 9) {
                                $m = '0' . $m;
                            } else {
                                $m = $m;
                            }
                            if ($last_day >= $m) {

                                $nfd = $y . '/' . $m . '/' . $year_value;
                                $Roledatad = DB::table('duty_roster')

                                    ->whereDate('start_date', '<=', $nfd)
                                    ->whereDate('end_date', '>=', $nfd)

                                    ->where('duty_roster.employee_id', '=', $emp_v)
                                    ->where('duty_roster.emid', '=', $Roledata->reg)
                                    ->first();

                                $att = DB::table('attandence')

                                    ->where('employee_code', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('date', '=', $year_value . '-' . $y . '-' . $m)
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                $laevepp = DB::table('leave_apply')

                                    ->where('employee_id', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                    ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                    ->where('status', '=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                $laeveppnrejj = DB::table('leave_apply')

                                    ->where('employee_id', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                    ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                    ->where('status', '!=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();

                                if ($join_date <= $year_value . '-' . $y . '-' . $m) {
                                    $add = '';
                                    if (!empty($laevepp) || !empty($laeveppnrejj)) {
                                        if (!empty($laevepp)) {
                                            $leave_typenewmm = $laevepp->leave_type;
                                        }
                                        if (!empty($laeveppnrejj)) {
                                            $leave_typenewmm = $laeveppnrejj->leave_type;
                                        }
                                        $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                        if ($leave_tyepenew->alies == 'H' && in_array(date('l', strtotime($nfd)), $offg)) {
                                            $add = 'yes';
                                        } else {
                                            $add = 'no';
                                        }

                                    } else {
                                        $add = 'no';
                                    }
                                    if (in_array($year_value . '-' . $y . '-' . $m, $offgholi) && (empty($laevepp))) {
                                        $resultnew .= '
     <td>PH</td>

    ';} else if (!empty($att) && empty($laevepp) && empty($laeveppnrejj)) {

                                        $resultnew .= '
     <td>P</td>

    ';} else if ((!empty($laevepp) || !empty($laeveppnrejj)) && $join_date != $nfd && $add == 'no') {

                                        if (!empty($laevepp)) {
                                            $laeveppnrnamee = DB::table('leave_type')

                                                ->where('id', '=', $laevepp->leave_type)

                                                ->first();
                                            if ($laeveppnrnamee->leave_type_name == 'Holiday') {
                                                $lc = 'H';
                                            } else {
                                                $lc = $laeveppnrnamee->alies;
                                            }
                                        }

                                        if (!empty($laeveppnrejj)) {
                                            $laeveppnrnamee = DB::table('leave_type')

                                                ->where('id', '=', $laeveppnrejj->leave_type)

                                                ->first();
                                            $lc = 'U';
                                        }

                                        $resultnew .= '

      <td>' . $lc . '</td>



    ';
                                    } else if (isset($sun) && $sun != '' && $sun == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($mon) && $mon != '' && $mon == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td> ';

                                    } else if (isset($tue) && $tue != '' && $tue == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($wed) && $wed != '' && $wed == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($thu) && $thu != '' && $thu == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($fri) && $fri != '' && $fri == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
    ';

                                    } else if (isset($sat) && $sat != '' && $sat == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
     ';

                                    } else {

                                        if (count($duty_authco) == 1) {
                                            $duty_auth_new_oow = DB::table('duty_roster')

                                                ->where('employee_id', '=', $emp->emp_code)
                                                ->where('emid', '=', $Roledata->reg)
                                                ->where('end_date', '>=', $first_day_this_year)

                                                ->orderBy('id', 'DESC')
                                                ->first();
                                        } else if (count($duty_authco) > 1) {
                                            $duty_auth_new_oow = DB::table('duty_roster')

                                                ->where('employee_id', '=', $emp->emp_code)
                                                ->where('emid', '=', $Roledata->reg)

                                                ->where('start_date', '>=', $first_day_this_year)
                                                ->where('end_date', '<=', $last_day_this_year)
                                                ->orderBy('id', 'DESC')
                                                ->first();
                                        }
                                        if (empty($duty_auth_new_oow)) {

                                            $resultnew .= '
      <td></td>

     ';

                                        } else {
                                            if (empty($Roledatad)) {

                                                $resultnew .= '
      <td></td>



   ';
                                            } else {

                                                $resultnew .= '
      <td>A</td>




   ';

                                            }

                                        }}

                                } else {
                                    $resultnew .= '
      <td></td>
    ';
                                }
                            } else {
                                $resultnew .= '
      <td></td>
    ';
                            }
                        }$resultnew .= '

  </tr>

   ';
                    }
                } else {
                    $emp_v = $employee_code;

                    $employeepp = DB::Table('employee')

                        ->where('emid', '=', $Roledata->reg)

                        ->where('.emp_code', '=', $emp_v)

                        ->select('employee.*')
                        ->distinct()
                        ->first();

                    $yes = date('Y', strtotime($first_day_this_year));

                    $duty_authco = DB::table('duty_roster')

                        ->where('employee_id', '=', $emp_v)
                        ->where('emid', '=', $Roledata->reg)
                        ->where('start_date', 'like', $yes . '%')

                        ->orderBy('id', 'DESC')
                        ->get();

                    if (count($duty_authco) == 1) {
                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp_v)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('end_date', '>=', $first_day_this_year)

                            ->orderBy('id', 'DESC')
                            ->first();
                    } else if (count($duty_authco) > 1) {

                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp_v)
                            ->where('emid', '=', $Roledata->reg)

                            ->where('start_date', '>=', $first_day_this_year)
                            ->where('end_date', '<=', $last_day_this_year)
                            ->orderBy('id', 'DESC')
                            ->first();

                    }

                    $offg = array();
                    if (!empty($duty_auth)) {

                        $shift_auth = DB::table('shift_management')

                            ->where('id', '=', $duty_auth->shift_code)

                            ->where('emid', '=', $Roledata->reg)
                            ->orderBy('id', 'DESC')
                            ->first();
                        $off_auth = DB::table('offday')

                            ->where('shift_code', '=', $duty_auth->shift_code)

                            ->where('emid', '=', $Roledata->reg)
                            ->orderBy('id', 'DESC')
                            ->first();

                        $off_day = 0;
                        $sun = '';
                        $mon = '';
                        $tue = '';
                        $wed = '';
                        $thu = '';
                        $fri = '';
                        $sat = '';
                        if (!empty($off_auth)) {
                            if ($off_auth->sun == '1') {
                                $sun = 'Sunday';
                                $off_day = $off_day + 1;
                                $offg[] = 'Sunday';
                            }
                            if ($off_auth->mon == '1') {
                                $off_day = $off_day + 1;
                                $mon = 'Monday';
                                $offg[] = 'Monday';
                            }

                            if ($off_auth->tue == '1') {
                                $off_day = $off_day + 1;
                                $tue = 'Tuesday';
                                $offg[] = 'Tuesday';
                            }

                            if ($off_auth->wed == '1') {
                                $off_day = $off_day + 1;
                                $wed = 'Wednesday';
                                $offg[] = 'Wednesday';
                            }

                            if ($off_auth->thu == '1') {
                                $off_day = $off_day + 1;
                                $thu = 'Thursday';
                                $offg[] = 'Thursday';
                            }

                            if ($off_auth->fri == '1') {
                                $off_day = $off_day + 1;
                                $fri = 'Friday';
                                $offg[] = 'Friday';
                            }
                            if ($off_auth->sat == '1') {
                                $off_day = $off_day + 1;
                                $sat = 'Saturday';
                                $offg[] = 'Saturday';
                            }

                        }
                        $new_off = 0;
                        for ($we = date('d', strtotime($first_day_this_year)); $we <= $total_wk_days; $we++) {

                            if ($we < 10 && $we != '01') {
                                $we = '0' . $we;
                            } else if ($we == '01') {
                                $we = $we;
                            } else {
                                $we = $we;
                            }

                            $new_f = date('Y-m', strtotime($first_day_this_year)) . '-' . $we;

                            if ($off_day > 1) {
                                if (in_array(date('l', strtotime($new_f)), $offg)) {
                                    $new_off = $new_off + 1;
                                } else {

                                }

                            }
                        }
                        $off_day = $new_off;
                    } else {
                        $off_day = 0;
                    }

                    $resultnew .= '
                   <tr class="tr-calender">
    <td class="mo">' . date('M', strtotime($y . '/10/2020')) . '</td>
      ';

                    for ($m = 1; $m < 32; $m++) {
                        if ($m <= 9) {
                            $m = '0' . $m;
                        } else {
                            $m = $m;
                        }
                        $nfd = $y . '/' . $m . '/' . $year_value;

                        $Roledatad = DB::table('duty_roster')

                            ->whereDate('start_date', '<=', $nfd)
                            ->whereDate('end_date', '>=', $nfd)

                            ->where('duty_roster.employee_id', '=', $emp_v)
                            ->where('duty_roster.emid', '=', $Roledata->reg)
                            ->first();

                        if ($last_day >= $m) {

                            $att = DB::table('attandence')

                                ->where('employee_code', '=', $employeepp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('date', '=', $year_value . '-' . $y . '-' . $m)
                                ->orderBy('id', 'DESC')
                                ->first();

                            $laevepp = DB::table('leave_apply')

                                ->where('employee_id', '=', $employeepp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                ->where('status', '=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            $laeveppnrejj = DB::table('leave_apply')

                                ->where('employee_id', '=', $employeepp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                ->where('status', '!=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            if ($join_date <= $year_value . '-' . $y . '-' . $m) {
                                $add = '';
                                if (!empty($laevepp) || !empty($laeveppnrejj)) {
                                    if (!empty($laevepp)) {
                                        $leave_typenewmm = $laevepp->leave_type;
                                    }
                                    if (!empty($laeveppnrejj)) {
                                        $leave_typenewmm = $laeveppnrejj->leave_type;
                                    }
                                    $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();
                                    if ($leave_tyepenew->alies == 'H' && in_array(date('l', strtotime($nfd)), $offg)) {
                                        $add = 'yes';
                                    } else {
                                        $add = 'no';
                                    }

                                } else {
                                    $add = 'no';
                                }

                                if (in_array($year_value . '-' . $y . '-' . $m, $offgholi) && (empty($laevepp))) {
                                    $resultnew .= '
     <td>PH</td>

   ';
                                } else if (!empty($att) && empty($laevepp) && empty($laeveppnrejj)) {
                                    $resultnew .= '
     <td>P</td>

   ';} else if ((!empty($laevepp) || !empty($laeveppnrejj)) && $join_date != $nfd && $add == 'no') {

                                    if (!empty($laevepp)) {
                                        $laeveppnrnamee = DB::table('leave_type')

                                            ->where('id', '=', $laevepp->leave_type)

                                            ->first();

                                        if ($laeveppnrnamee->leave_type_name == 'Holiday') {

                                            $lc = 'H';
                                        } else {
                                            $lc = $laeveppnrnamee->alies;
                                        }
                                    }

                                    if (!empty($laeveppnrejj)) {
                                        $laeveppnrnamee = DB::table('leave_type')

                                            ->where('id', '=', $laeveppnrejj->leave_type)

                                            ->first();
                                        $lc = 'U';
                                    }

                                    $resultnew .= '
     <td>' . $lc . '</td>



   ';
                                } else if (isset($sun) && $sun != '' && $sun == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($mon) && $mon != '' && $mon == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
     ';

                                } else if (isset($tue) && $tue != '' && $tue == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($wed) && $wed != '' && $wed == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
     ';

                                } else if (isset($thu) && $thu != '' && $thu == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($fri) && $fri != '' && $fri == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($sat) && $sat != '' && $sat == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
   ';

                                } else {

                                    if (count($duty_authco) == 1) {
                                        $duty_auth_new_oow = DB::table('duty_roster')

                                            ->where('employee_id', '=', $employeepp->emp_code)
                                            ->where('emid', '=', $Roledata->reg)
                                            ->where('end_date', '>=', $first_day_this_year)

                                            ->orderBy('id', 'DESC')
                                            ->first();
                                    } else if (count($duty_authco) > 1) {
                                        $duty_auth_new_oow = DB::table('duty_roster')

                                            ->where('employee_id', '=', $employeepp->emp_code)
                                            ->where('emid', '=', $Roledata->reg)

                                            ->where('start_date', '>=', $first_day_this_year)
                                            ->where('end_date', '<=', $last_day_this_year)
                                            ->orderBy('id', 'DESC')
                                            ->first();
                                    }
                                    if (empty($duty_auth_new_oow)) {

                                        $resultnew .= '
      <td></td>



     ';
                                    } else {
                                        if (empty($Roledatad)) {

                                            $resultnew .= '
      <td></td>



    ';
                                        } else {

                                            $resultnew .= '
      <td>A</td>



   ';

                                        }

                                    }}
                            } else {
                                $resultnew .= '
      <td></td>



    ';
                            }
                        } else {
                            $resultnew .= '
      <td></td>



    ';
                        }
                    }$resultnew .= '
  </tr>
                 ';

                }
            }

            $data['resultnew'] = $resultnew;

            return view('dashboard/absent-record', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewattendanabsentreportpdf($absent_id, $year_value)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            $data['employee_code'] = base64_decode($absent_id);
            $data['year_value'] = base64_decode($year_value);

            $data['employee_code'] = base64_decode($absent_id);
            $data['year_value'] = base64_decode($year_value);

            $employee_code = base64_decode($absent_id);
            $year_value = base64_decode($year_value);
            $increment = 0;

            $data['result'] = '';

            $employeenmae = DB::Table('employee')

                ->where('emid', '=', $Roledata->reg)

                ->where('emp_code', '=', $data['employee_code'])

                ->select('employee.*')
                ->distinct()
                ->first();
            $data['employeenmae'] = $employeenmae;
            $resultnew = '';

            for ($y = 1; $y < 13; $y++) {
                $off_day = 0;
                $sun = '';
                $mon = '';
                $tue = '';
                $wed = '';
                $thu = '';
                $fri = '';
                $sat = '';
                if ($y <= 9) {
                    $y = '0' . $y;
                } else {
                    $y = $y;
                }
                $my_year = $year_value;
                $first_day_this_year = $year_value . '-' . $y . '-01';
                if ($y == '01' || $y == '03' || $y == '05' || $y == '07' || $y == '08' || $y == '10' || $y == '12') {
                    $last_day_this_year = $year_value . '-' . $y . '-31';
                    $last_day = '31';
                }

                if ($y == '04' || $y == '06' || $y == '09' || $y == '11') {
                    $last_day_this_year = $year_value . '-' . $y . '-30';
                    $last_day = '30';
                }

                if ($y == '02') {
                    if ($my_year % 400 == 0) {
                        $last_day_this_year = $year_value . '-' . $y . '-29';
                        $last_day = '29';
                    }

                    if ($my_year % 4 == 0) {
                        $last_day_this_year = $year_value . '-' . $y . '-29';
                        $last_day = '29';
                    } else if ($my_year % 100 == 0) {
                        $last_day_this_year = $year_value . '-' . $y . '-28';
                        $last_day = '28';
                    } else {
                        $last_day_this_year = $year_value . '-' . $y . '-28';
                        $last_day = '28';
                    }

                }

                $filename =

                $per_day_salary = $late_salary_deducted = $no_of_days_salary_deducted = $no_of_days_salary = 0;

                $working_day = 30;

                $holidays = DB::table('holiday')->where('from_date', '>=', $first_day_this_year)
                    ->where('to_date', '<=', $last_day_this_year)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                $totday = 0;
                $offgholi = array();
                foreach ($holidays as $holiday) {
                    $totday = $totday + $holiday->day;
                    if ($holiday->day > 1) {

                        for ($weh = date('d', strtotime($holiday->from_date)); $weh <= date('d', strtotime($holiday->to_date)); $weh++) {
                            if ($weh < 10 && $weh != '01') {
                                $weh = '0' . $weh;
                            } else if ($weh == '01') {
                                $weh = $weh;
                            } else {
                                $weh = $weh;
                            }

                            $offgholi[] = date('Y-m', strtotime($holiday->from_date)) . '-' . $weh;
                        }
                    } else {
                        $offgholi[] = $holiday->from_date;
                    }
                }

                $total_wk_days = 0;
                $date1_ts = strtotime($first_day_this_year);
                $date2_ts = strtotime($last_day_this_year);
                $diff = $date2_ts - $date1_ts;

                $total_wk_days = (round($diff / 86400) + 1);

                $emp_v = $employee_code;
                $employee_data_new = DB::Table('employee')

                    ->where('emid', '=', $Roledata->reg)

                    ->where('emp_code', '=', $emp_v)

                    ->select('employee.*')

                    ->first();
                $join_date = '';

                if ($employee_data_new->emp_doj != '1970-01-01') {if ($employee_data_new->emp_doj != '') {$join_date = $employee_data_new->emp_doj;}}

                $employee_rs = DB::Table('employee')
                    ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                    ->whereBetween('attandence.date', [$first_day_this_year, $last_day_this_year])
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_code', '=', $emp_v)

                    ->select('employee.*')
                    ->distinct()
                    ->get();

                if (count($employee_rs) != 0) {

                    foreach ($employee_rs as $emp) {

                        $yes = date('Y', strtotime($first_day_this_year));

                        $duty_authco = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp->emp_code)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('start_date', 'like', $yes . '%')

                            ->orderBy('id', 'DESC')
                            ->get();
                        if (count($duty_authco) == 1) {
                            $duty_auth = DB::table('duty_roster')

                                ->where('employee_id', '=', $emp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('end_date', '>=', $first_day_this_year)

                                ->orderBy('id', 'DESC')
                                ->first();
                        } else if (count($duty_authco) > 1) {
                            $duty_auth = DB::table('duty_roster')

                                ->where('employee_id', '=', $emp->emp_code)
                                ->where('emid', '=', $Roledata->reg)

                                ->where('start_date', '>=', $first_day_this_year)
                                ->where('end_date', '<=', $last_day_this_year)
                                ->orderBy('id', 'DESC')
                                ->first();
                        }

                        $offg = array();

                        if (!empty($duty_auth)) {

                            $shift_auth = DB::table('shift_management')

                                ->where('id', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();
                            $off_auth = DB::table('offday')

                                ->where('shift_code', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $Roledata->reg)
                                ->orderBy('id', 'DESC')
                                ->first();

                            $off_day = 0;
                            $sun = '';
                            $mon = '';
                            $tue = '';
                            $wed = '';
                            $thu = '';
                            $fri = '';
                            $sat = '';
                            if (!empty($off_auth)) {
                                if ($off_auth->sun == '1') {
                                    $sun = 'Sunday';
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Sunday';
                                }
                                if ($off_auth->mon == '1') {
                                    $off_day = $off_day + 1;
                                    $mon = 'Monday';
                                    $offg[] = 'Monday';
                                }

                                if ($off_auth->tue == '1') {
                                    $off_day = $off_day + 1;
                                    $tue = 'Tuesday';
                                    $offg[] = 'Tuesday';
                                }

                                if ($off_auth->wed == '1') {
                                    $off_day = $off_day + 1;
                                    $wed = 'Wednesday';
                                    $offg[] = 'Wednesday';
                                }

                                if ($off_auth->thu == '1') {
                                    $off_day = $off_day + 1;
                                    $thu = 'Thursday';
                                    $offg[] = 'Thursday';
                                }

                                if ($off_auth->fri == '1') {
                                    $off_day = $off_day + 1;
                                    $fri = 'Friday';
                                    $offg[] = 'Friday';
                                }
                                if ($off_auth->sat == '1') {
                                    $off_day = $off_day + 1;
                                    $sat = 'Saturday';
                                    $offg[] = 'Saturday';
                                }

                            }
                            $new_off = 0;
                            for ($we = date('d', strtotime($first_day_this_year)); $we <= $total_wk_days; $we++) {

                                if ($we < 10 && $we != '01') {
                                    $we = '0' . $we;
                                } else if ($we == '01') {
                                    $we = $we;
                                } else {
                                    $we = $we;
                                }

                                $new_f = date('Y-m', strtotime($first_day_this_year)) . '-' . $we;

                                if ($off_day > 1) {
                                    if (in_array(date('l', strtotime($new_f)), $offg)) {
                                        $new_off = $new_off + 1;
                                    } else {

                                    }

                                }
                            }
                            $off_day = $new_off;
                        } else {
                            $off_day = 0;
                        }

                        $resultnew .= '<tr class="tr-calender">
    <td class="mo">

		' . date('M', strtotime($y . '/10/2020')) . '</td>


          ';

                        for ($m = 1; $m < 32; $m++) {
                            if ($m <= 9) {
                                $m = '0' . $m;
                            } else {
                                $m = $m;
                            }
                            if ($last_day >= $m) {

                                $nfd = $y . '/' . $m . '/' . $year_value;
                                $Roledatad = DB::table('duty_roster')

                                    ->whereDate('start_date', '<=', $nfd)
                                    ->whereDate('end_date', '>=', $nfd)

                                    ->where('duty_roster.employee_id', '=', $emp_v)
                                    ->where('duty_roster.emid', '=', $Roledata->reg)
                                    ->first();

                                $att = DB::table('attandence')

                                    ->where('employee_code', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('date', '=', $year_value . '-' . $y . '-' . $m)
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                $laevepp = DB::table('leave_apply')

                                    ->where('employee_id', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                    ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                    ->where('status', '=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                $laeveppnrejj = DB::table('leave_apply')

                                    ->where('employee_id', '=', $emp->emp_code)
                                    ->where('emid', '=', $Roledata->reg)
                                    ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                    ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                    ->where('status', '!=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();

                                if ($join_date <= $year_value . '-' . $y . '-' . $m) {
                                    $add = '';
                                    if (!empty($laevepp) || !empty($laeveppnrejj)) {
                                        if (!empty($laevepp)) {
                                            $leave_typenewmm = $laevepp->leave_type;
                                        }
                                        if (!empty($laeveppnrejj)) {
                                            $leave_typenewmm = $laeveppnrejj->leave_type;
                                        }
                                        $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                        if ($leave_tyepenew->alies == 'H' && in_array(date('l', strtotime($nfd)), $offg)) {
                                            $add = 'yes';
                                        } else {
                                            $add = 'no';
                                        }

                                    } else {
                                        $add = 'no';
                                    }
                                    if (in_array($year_value . '-' . $y . '-' . $m, $offgholi) && (empty($laevepp))) {
                                        $resultnew .= '
     <td>PH</td>

    ';} else if (!empty($att) && empty($laevepp) && empty($laeveppnrejj)) {

                                        $resultnew .= '
     <td>P</td>

    ';} else if ((!empty($laevepp) || !empty($laeveppnrejj)) && $join_date != $nfd && $add == 'no') {

                                        if (!empty($laevepp)) {
                                            $laeveppnrnamee = DB::table('leave_type')

                                                ->where('id', '=', $laevepp->leave_type)

                                                ->first();
                                            if ($laeveppnrnamee->leave_type_name == 'Holiday') {
                                                $lc = 'H';
                                            } else {
                                                $lc = $laeveppnrnamee->alies;
                                            }
                                        }

                                        if (!empty($laeveppnrejj)) {
                                            $laeveppnrnamee = DB::table('leave_type')

                                                ->where('id', '=', $laeveppnrejj->leave_type)

                                                ->first();
                                            $lc = 'U';
                                        }

                                        $resultnew .= '

      <td>' . $lc . '</td>



    ';
                                    } else if (isset($sun) && $sun != '' && $sun == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($mon) && $mon != '' && $mon == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td> ';

                                    } else if (isset($tue) && $tue != '' && $tue == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($wed) && $wed != '' && $wed == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($thu) && $thu != '' && $thu == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
   ';

                                    } else if (isset($fri) && $fri != '' && $fri == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
    ';

                                    } else if (isset($sat) && $sat != '' && $sat == date("l", strtotime($nfd))) {

                                        $resultnew .= '
      <td>Off</td>
     ';

                                    } else {

                                        if (count($duty_authco) == 1) {
                                            $duty_auth_new_oow = DB::table('duty_roster')

                                                ->where('employee_id', '=', $emp->emp_code)
                                                ->where('emid', '=', $Roledata->reg)
                                                ->where('end_date', '>=', $first_day_this_year)

                                                ->orderBy('id', 'DESC')
                                                ->first();
                                        } else if (count($duty_authco) > 1) {
                                            $duty_auth_new_oow = DB::table('duty_roster')

                                                ->where('employee_id', '=', $emp->emp_code)
                                                ->where('emid', '=', $Roledata->reg)

                                                ->where('start_date', '>=', $first_day_this_year)
                                                ->where('end_date', '<=', $last_day_this_year)
                                                ->orderBy('id', 'DESC')
                                                ->first();
                                        }
                                        if (empty($duty_auth_new_oow)) {

                                            $resultnew .= '
      <td></td>

     ';

                                        } else {
                                            if (empty($Roledatad)) {

                                                $resultnew .= '
      <td></td>



   ';
                                            } else {

                                                $resultnew .= '
      <td>A</td>




   ';

                                            }

                                        }}

                                } else {
                                    $resultnew .= '
      <td></td>
    ';
                                }
                            } else {
                                $resultnew .= '
      <td></td>
    ';
                            }
                        }$resultnew .= '

  </tr>

   ';
                    }
                } else {
                    $emp_v = $employee_code;
                    $employeepp = DB::Table('employee')

                        ->where('emid', '=', $Roledata->reg)

                        ->where('.emp_code', '=', $emp_v)

                        ->select('employee.*')
                        ->distinct()
                        ->first();

                    $yes = date('Y', strtotime($first_day_this_year));

                    $duty_authco = DB::table('duty_roster')

                        ->where('employee_id', '=', $emp_v)
                        ->where('emid', '=', $Roledata->reg)
                        ->where('start_date', 'like', $yes . '%')

                        ->orderBy('id', 'DESC')
                        ->get();

                    if (count($duty_authco) == 1) {
                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp_v)
                            ->where('emid', '=', $Roledata->reg)
                            ->where('end_date', '>=', $first_day_this_year)

                            ->orderBy('id', 'DESC')
                            ->first();
                    } else if (count($duty_authco) > 1) {
                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $emp_v)
                            ->where('emid', '=', $Roledata->reg)

                            ->where('start_date', '>=', $first_day_this_year)
                            ->where('end_date', '<=', $last_day_this_year)
                            ->orderBy('id', 'DESC')
                            ->first();
                    }

                    $offg = array();

                    if (!empty($duty_auth)) {

                        $shift_auth = DB::table('shift_management')

                            ->where('id', '=', $duty_auth->shift_code)

                            ->where('emid', '=', $Roledata->reg)
                            ->orderBy('id', 'DESC')
                            ->first();
                        $off_auth = DB::table('offday')

                            ->where('shift_code', '=', $duty_auth->shift_code)

                            ->where('emid', '=', $Roledata->reg)
                            ->orderBy('id', 'DESC')
                            ->first();

                        $offg = array();
                        $off_day = 0;
                        $sun = '';
                        $mon = '';
                        $tue = '';
                        $wed = '';
                        $thu = '';
                        $fri = '';
                        $sat = '';
                        if (!empty($off_auth)) {
                            if ($off_auth->sun == '1') {
                                $sun = 'Sunday';
                                $off_day = $off_day + 1;
                                $offg[] = 'Sunday';
                            }
                            if ($off_auth->mon == '1') {
                                $off_day = $off_day + 1;
                                $mon = 'Monday';
                                $offg[] = 'Monday';
                            }

                            if ($off_auth->tue == '1') {
                                $off_day = $off_day + 1;
                                $tue = 'Tuesday';
                                $offg[] = 'Tuesday';
                            }

                            if ($off_auth->wed == '1') {
                                $off_day = $off_day + 1;
                                $wed = 'Wednesday';
                                $offg[] = 'Wednesday';
                            }

                            if ($off_auth->thu == '1') {
                                $off_day = $off_day + 1;
                                $thu = 'Thursday';
                                $offg[] = 'Thursday';
                            }

                            if ($off_auth->fri == '1') {
                                $off_day = $off_day + 1;
                                $fri = 'Friday';
                                $offg[] = 'Friday';
                            }
                            if ($off_auth->sat == '1') {
                                $off_day = $off_day + 1;
                                $sat = 'Saturday';
                                $offg[] = 'Saturday';
                            }

                        }
                        $new_off = 0;
                        for ($we = date('d', strtotime($first_day_this_year)); $we <= $total_wk_days; $we++) {

                            if ($we < 10 && $we != '01') {
                                $we = '0' . $we;
                            } else if ($we == '01') {
                                $we = $we;
                            } else {
                                $we = $we;
                            }

                            $new_f = date('Y-m', strtotime($first_day_this_year)) . '-' . $we;

                            if ($off_day > 1) {
                                if (in_array(date('l', strtotime($new_f)), $offg)) {
                                    $new_off = $new_off + 1;
                                } else {

                                }

                            }
                        }
                        $off_day = $new_off;
                    } else {
                        $off_day = 0;
                    }

                    $resultnew .= '
                   <tr class="tr-calender">
    <td class="mo">' . date('M', strtotime($y . '/10/2020')) . '</td>
      ';

                    for ($m = 1; $m < 32; $m++) {
                        if ($m <= 9) {
                            $m = '0' . $m;
                        } else {
                            $m = $m;
                        }
                        $nfd = $y . '/' . $m . '/' . $year_value;
                        $Roledatad = DB::table('duty_roster')

                            ->whereDate('start_date', '<=', $nfd)
                            ->whereDate('end_date', '>=', $nfd)

                            ->where('duty_roster.employee_id', '=', $emp_v)
                            ->where('duty_roster.emid', '=', $Roledata->reg)
                            ->first();

                        if ($last_day >= $m) {

                            $att = DB::table('attandence')

                                ->where('employee_code', '=', $employeepp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('date', '=', $year_value . '-' . $y . '-' . $m)
                                ->orderBy('id', 'DESC')
                                ->first();

                            $laevepp = DB::table('leave_apply')

                                ->where('employee_id', '=', $employeepp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                ->where('status', '=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            $laeveppnrejj = DB::table('leave_apply')

                                ->where('employee_id', '=', $employeepp->emp_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $year_value . '-' . $y . '-' . $m)
                                ->where('to_date', '>=', $year_value . '-' . $y . '-' . $m)
                                ->where('status', '!=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            if ($join_date <= $year_value . '-' . $y . '-' . $m) {
                                $add = '';
                                if (!empty($laevepp) || !empty($laeveppnrejj)) {
                                    if (!empty($laevepp)) {
                                        $leave_typenewmm = $laevepp->leave_type;
                                    }
                                    if (!empty($laeveppnrejj)) {
                                        $leave_typenewmm = $laeveppnrejj->leave_type;
                                    }
                                    $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                    if ($leave_tyepenew->alies == 'H' && in_array(date('l', strtotime($nfd)), $offg)) {
                                        $add = 'yes';
                                    } else {
                                        $add = 'no';
                                    }

                                } else {
                                    $add = 'no';
                                }
                                if (in_array($year_value . '-' . $y . '-' . $m, $offgholi) && (empty($laevepp))) {
                                    $resultnew .= '
     <td>PH</td>

   ';
                                } else if (!empty($att) && empty($laevepp) && empty($laeveppnrejj)) {
                                    $resultnew .= '
     <td>P</td>

   ';} else if ((!empty($laevepp) || !empty($laeveppnrejj)) && $join_date != $nfd && $add == 'no') {

                                    if (!empty($laevepp)) {
                                        $laeveppnrnamee = DB::table('leave_type')

                                            ->where('id', '=', $laevepp->leave_type)

                                            ->first();
                                        if ($laeveppnrnamee->leave_type_name == 'Holiday') {
                                            $lc = 'H';
                                        } else {
                                            $lc = $laeveppnrnamee->alies;
                                        }
                                    }

                                    if (!empty($laeveppnrejj)) {
                                        $laeveppnrnamee = DB::table('leave_type')

                                            ->where('id', '=', $laeveppnrejj->leave_type)

                                            ->first();
                                        $lc = 'U';
                                    }

                                    $resultnew .= '
     <td>' . $lc . '</td>



   ';
                                } else if (isset($sun) && $sun != '' && $sun == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($mon) && $mon != '' && $mon == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
     ';

                                } else if (isset($tue) && $tue != '' && $tue == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($wed) && $wed != '' && $wed == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
     ';

                                } else if (isset($thu) && $thu != '' && $thu == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($fri) && $fri != '' && $fri == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
    ';

                                } else if (isset($sat) && $sat != '' && $sat == date("l", strtotime($nfd))) {

                                    $resultnew .= '
      <td>Off</td>
   ';

                                } else {
                                    if (count($duty_authco) == 1) {
                                        $duty_auth_new_oow = DB::table('duty_roster')

                                            ->where('employee_id', '=', $employeepp->emp_code)
                                            ->where('emid', '=', $Roledata->reg)
                                            ->where('end_date', '>=', $first_day_this_year)

                                            ->orderBy('id', 'DESC')
                                            ->first();
                                    } else if (count($duty_authco) > 1) {
                                        $duty_auth_new_oow = DB::table('duty_roster')

                                            ->where('employee_id', '=', $employeepp->emp_code)
                                            ->where('emid', '=', $Roledata->reg)

                                            ->where('start_date', '>=', $first_day_this_year)
                                            ->where('end_date', '<=', $last_day_this_year)
                                            ->orderBy('id', 'DESC')
                                            ->first();
                                    }
                                    if (empty($duty_auth_new_oow)) {

                                        $resultnew .= '
      <td></td>



     ';
                                    } else {
                                        if (empty($Roledatad)) {

                                            $resultnew .= '
      <td></td>



    ';
                                        } else {

                                            $resultnew .= '
      <td>A</td>



   ';

                                        }

                                    }}
                            } else {
                                $resultnew .= '
      <td></td>



    ';
                            }
                        } else {
                            $resultnew .= '
      <td></td>



    ';
                        }
                    }$resultnew .= '
  </tr>
                 ';

                }
            }

            $data['resultnew'] = $resultnew;
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'emid' => $Roledata->reg,
                'employee_code' => $data['employee_code'], 'employee_type_rs' => $data['employee_type_rs'], 'Roledata' => $Roledata, 'year_value' => $data['year_value'], 'resultnew' => $resultnew, 'employeenmae' => $employeenmae];

            $pdf = PDF::loadView('mypdfabsentrecordcard', $datap);
            return $pdf->download('absentrecordcard.pdf');

        } else {
            return redirect('/');
        }

    }
    public function viewchangecircumstancesedit()
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            return view('dashboard/change-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function savechangecircumstancesedit(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $employee_code = $request->employee_code;
            $employee_type = $request->employee_type;

            $data['result'] = '';
            //dd($leave_allocation_rs);
            $f = 2;

            $employeet = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->first();
            $date1 = date('Y', strtotime($employeet->emp_doj)) . date('m-d');
            $date2 = date('Y-m-d');

            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365 * 60 * 60 * 24));
            date('Y', strtotime($date1));
            $endtyear = date('Y', strtotime($date1)) + ($years);

            $employeetnew = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->first();
            $employeetcircumnew = DB::table('change_circumstances_history')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->first();

            $employeetemployeeother = DB::table('circumemployee_other_doc_history')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->get();

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
            if (!empty($employeetcircumnew)) {
                $date_doj = date('d/m/Y', strtotime($employeetcircumnew->date_change));
                $anual_datenew = date('Y-m-d', strtotime($employeetcircumnew->date_change . '  + 1 year'));
                $peradd = '';
                $peradd = $employeetcircumnew->emp_pr_street_no;
                if ($employeetcircumnew->emp_per_village) {$peradd .= ',' . $employeetcircumnew->emp_per_village;}
                if ($employeetcircumnew->emp_pr_state) {$peradd .= ',' . $employeetcircumnew->emp_pr_state
                    ;}if ($employeetcircumnew->emp_pr_city) {$peradd .= ',' . $employeetcircumnew->emp_pr_city;}
                if ($employeetcircumnew->emp_pr_pincode) {$peradd .= ',' . $employeetcircumnew->emp_pr_pincode;}
                if ($employeetcircumnew->emp_pr_country) {$peradd .= ',' . $employeetcircumnew->emp_pr_country;};

                if ($employeetcircumnew->visa_exp_date != '1970-01-01') {if ($employeetcircumnew->visa_exp_date != '') {
                    $visa_exp_date = date('d/m/Y', strtotime($employeetcircumnew->visa_exp_date));
                } else {
                    $visa_exp_date = '';
                }} else {
                    $visa_exp_date = '';
                }
                if ($employeetcircumnew->pass_exp_date != '1970-01-01') {if ($employeetcircumnew->pass_exp_date != '') {
                    $stfol = date('d/m/Y', strtotime($employeetcircumnew->pass_exp_date));
                } else {
                    $stfol = '';
                }} else {
                    $stfol = '';

                }

                $euss_exp = '';
                if ($employeetcircumnew->euss_exp_date != '1970-01-01') {
                    if ($employeetcircumnew->euss_exp_date != 'null' && $employeetcircumnew->euss_exp_date != NULL) {
                        $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetcircumnew->euss_exp_date));
                    }
                }
                $euss_exp = $employeetcircumnew->euss_ref_no . $euss_exp;

                $dbs_exp = '';
                if ($employeetcircumnew->dbs_exp_date != '1970-01-01') {
                    if ($employeetcircumnew->dbs_exp_date != 'null' && $employeetcircumnew->dbs_exp_date != NULL) {
                        $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetcircumnew->dbs_exp_date));
                    }
                }
                $dbs_exp = $employeetcircumnew->dbs_ref_no . $dbs_exp;

                $nid_exp = '';
                if ($employeetcircumnew->nat_exp_date != '1970-01-01') {
                    if ($employeetcircumnew->nat_exp_date != 'null' && $employeetcircumnew->nat_exp_date != NULL) {
                        $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetcircumnew->nat_exp_date));
                    }
                }
                $nid_exp = $employeetcircumnew->nat_id_no . $nid_exp;


                $desinf = $employeetcircumnew->emp_designation;
                $newph = $employeetcircumnew->emp_ps_phone;
                $newpnati = $employeetcircumnew->nationality;
                $newpnavia = $employeetcircumnew->visa_doc_no;
                $newpnapasas = $employeetcircumnew->pass_doc_no;
            } else { $date_doj = date('d/m/Y', strtotime($employeet->emp_doj));

                $anual_datenew = date('Y-m-d', strtotime($employeet->emp_doj . '  + 1 year'));
                $peradd = '';
                $peradd = $employeetnew->emp_pr_street_no;
                if ($employeetnew->emp_per_village) {$peradd .= ',' . $employeetnew->emp_per_village;}
                if ($employeetnew->emp_pr_state) {$peradd .= ',' . $employeetnew->emp_pr_state
                    ;}if ($employeetnew->emp_pr_city) {$peradd .= ',' . $employeetnew->emp_pr_city;}
                if ($employeetnew->emp_pr_pincode) {$peradd .= ',' . $employeetnew->emp_pr_pincode;}
                if ($employeetnew->emp_pr_country) {$peradd .= ',' . $employeetnew->emp_pr_country;};

                if ($employeetnew->visa_exp_date != '1970-01-01') {if ($employeetnew->visa_exp_date != '') {
                    $visa_exp_date = date('d/m/Y', strtotime($employeetnew->visa_exp_date));
                } else {
                    $visa_exp_date = '';
                }} else {
                    $visa_exp_date = '';
                }
                if ($employeetnew->pass_exp_date != '1970-01-01') {if ($employeetnew->pass_exp_date != '') {
                    $stfol = date('d/m/Y', strtotime($employeetnew->pass_exp_date));
                } else {
                    $stfol = '';
                }} else {
                    $stfol = '';
                }

                $euss_exp = '';
                if ($employeetnew->euss_exp_date != '1970-01-01') {
                    if ($employeetnew->euss_exp_date != 'null' && $employeetnew->euss_exp_date != NULL) {
                        $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetnew->euss_exp_date));
                    }
                }
                $euss_exp = $employeetnew->euss_ref_no . $euss_exp;

                $dbs_exp = '';
                if ($employeetnew->dbs_exp_date != '1970-01-01') {
                    if ($employeetnew->dbs_exp_date != 'null' && $employeetnew->dbs_exp_date != NULL) {
                        $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetnew->dbs_exp_date));
                    }
                }
                $dbs_exp = $employeetnew->dbs_ref_no . $dbs_exp;

                $nid_exp = '';
                if ($employeetnew->nat_exp_date != '1970-01-01') {
                    if ($employeetnew->nat_exp_date != 'null' && $employeetnew->nat_exp_date != NULL) {
                        $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($employeetnew->nat_exp_date));
                    }
                }
                $nid_exp = $employeetnew->nat_id_no . $nid_exp;


                $desinf = $employeetnew->emp_designation;
                $newph = $employeetnew->emp_ps_phone;
                $newpnati = $employeetnew->nationality;
                $newpnavia = $employeetnew->visa_doc_no;
                $newpnapasas = $employeetnew->pass_doc_no;
            }
            $data['result'] .= '<tr>
			<td>1</td>
													<td>' . $date_doj . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $employee_code . '</td>
													<td>' . $employeetnew->emp_fname . '  ' . $employeetnew->emp_mname . ' ' . $employeetnew->emp_lname . '</td>

													<td>' . $desinf . '</td>
														<td>' . $peradd . '</td>

													<td>' . $newph . '</td>
														<td>' . $newpnati . '</td>

															<td>' . $newpnavia . '</td>
															<td>' . $visa_exp_date . '</td>
																<td>Not Applicable </td>
															<td>' . $newpnapasas . '
														( ' . $stfol . ' )</td>
                                                        <td>'.$euss_exp.'</td>
                                                        <td>'.$dbs_exp.'</td>
                                                        <td>'.$nid_exp.'</td>
														<td>' . $dataeotherdoc . '</td>
															<td></td>
															<td></td>
															<td>' . date('d/m/Y', strtotime($anual_datenew)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/change/' . base64_encode($employee_code) . '/' . base64_encode($anual_datenew) . '" target="_blank"><i class="fas fa-eye" ></i></a>


															 &nbsp &nbsp <a href="' . env("BASE_URL") . 'employee/changesendlet/' . base64_encode($employee_code) . '/' . base64_encode($anual_datenew) . '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';

            for ($m = date('Y', strtotime($employeet->emp_doj)); $m <= $endtyear; $m++) {

                $strartye = date($m . '-01-01');
                $endtye = date($m . '-12-31');

                $leave_allocation_rs = DB::table('change_circumstances')
                    ->join('employee', 'change_circumstances.emp_code', '=', 'employee.emp_code')
                    ->where('change_circumstances.emp_code', '=', $employee_code)
                    ->where('change_circumstances.emid', '=', $Roledata->reg)
                    ->where('employee.emp_code', '=', $employee_code)
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('employee.emp_status', '=', $employee_type)
                    ->whereBetween('date_change', [$strartye, $endtye])
                    ->orderBy('date_change', 'ASC')
                    ->select('change_circumstances.*')
                    ->get();
                if (count($leave_allocation_rs) != 0) {

                    foreach ($leave_allocation_rs as $leave_allocation) {

                        $peradd = '';
                        $peradd = $leave_allocation->emp_pr_street_no;
                        if ($leave_allocation->emp_per_village) {$peradd .= ',' . $leave_allocation->emp_per_village;}
                        if ($leave_allocation->emp_pr_state) {$peradd .= ',' . $leave_allocation->emp_pr_state
                            ;}if ($leave_allocation->emp_pr_city) {$peradd .= ',' . $leave_allocation->emp_pr_city;}
                        if ($leave_allocation->emp_pr_pincode) {$peradd .= ',' . $leave_allocation->emp_pr_pincode;}
                        if ($leave_allocation->emp_pr_country) {$peradd .= ',' . $leave_allocation->emp_pr_country;};

                        $preadd = '';
                        $preadd = $leave_allocation->emp_ps_street_no;
                        if ($leave_allocation->emp_ps_village) {$preadd .= ',' . $leave_allocation->emp_ps_village;}
                        if ($leave_allocation->emp_ps_state) {$preadd .= ',' . $leave_allocation->emp_ps_state
                            ;}if ($leave_allocation->emp_ps_city) {$preadd .= ',' . $leave_allocation->emp_ps_city;}
                        if ($leave_allocation->emp_ps_pincode) {$preadd .= ',' . $leave_allocation->emp_ps_pincode;}
                        if ($leave_allocation->emp_ps_country) {$preadd .= ',' . $leave_allocation->emp_ps_country;};
                        if ($leave_allocation->emp_dob != '1970-01-01') {if ($leave_allocation->emp_dob != '') {
                            $dov = date('d/m/Y', strtotime($leave_allocation->emp_dob));
                        } else {
                            $dov = '';
                        }} else {
                            $dov = '';
                        }
                        if ($leave_allocation->visa_exp_date != '1970-01-01') {if ($leave_allocation->visa_exp_date != '') {
                            $visa_exp_date = date('d/m/Y', strtotime($leave_allocation->visa_exp_date));
                        } else {
                            $visa_exp_date = '';
                        }} else {
                            $visa_exp_date = '';
                        }
                        if ($leave_allocation->pass_exp_date != '1970-01-01') {if ($leave_allocation->pass_exp_date != '') {
                            $stfol = date('d/m/Y', strtotime($leave_allocation->pass_exp_date));
                        } else {
                            $stfol = '';
                        }} else {
                            $stfol = '';
                        }

                        $euss_exp = '';
                        if ($leave_allocation->euss_exp_date != '1970-01-01') {
                            if ($leave_allocation->euss_exp_date != 'null' && $leave_allocation->euss_exp_date != NULL) {
                                $euss_exp = '  EXPIRE:' . date('jS F Y', strtotime($leave_allocation->euss_exp_date));
                            }
                        }
                        $euss_exp = $leave_allocation->euss_ref_no . $euss_exp;

                        $dbs_exp = '';
                        if ($leave_allocation->dbs_exp_date != '1970-01-01') {
                            if ($leave_allocation->dbs_exp_date != 'null' && $leave_allocation->dbs_exp_date != NULL) {
                                $dbs_exp = '  EXPIRE:' . date('jS F Y', strtotime($leave_allocation->dbs_exp_date));
                            }
                        }
                        $dbs_exp = $leave_allocation->dbs_ref_no . $dbs_exp;

                        $nid_exp = '';
                        if ($leave_allocation->nat_exp_date != '1970-01-01') {
                            if ($leave_allocation->nat_exp_date != 'null' && $leave_allocation->nat_exp_date != NULL) {
                                $nid_exp = '  EXPIRE:' . date('jS F Y', strtotime($leave_allocation->nat_exp_date));
                            }
                        }
                        $nid_exp = $leave_allocation->nat_id_no . $nid_exp;


                        $employeet = DB::table('employee')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)->first();

                        $dojg = date('m-d', strtotime($employeet->emp_doj));

                        $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));

                        $employeetemployeeother = DB::table('circumemployee_other_doc')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)
                            ->where('cir_id', '=', $leave_allocation->id)->orderBy('id', 'DESC')->get();

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

                        $data['result'] .= '<tr>
			<td>' . $f . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->date_change)) . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $leave_allocation->emp_code . '</td>
													<td>' . $employeet->emp_fname . '  ' . $employeet->emp_mname . ' ' . $employeet->emp_lname . '</td>

													<td>' . $leave_allocation->emp_designation . '</td>
														<td>' . $peradd . '</td>

													<td>' . $leave_allocation->emp_ps_phone . '</td>
														<td>' . $leave_allocation->nationality . '</td>

															<td>' . $leave_allocation->visa_doc_no . '</td>
															<td>' . $visa_exp_date . '</td>
																<td>' . $leave_allocation->res_remark . '</td>
															<td>' . $leave_allocation->pass_doc_no . '
														( ' . $stfol . ' )</td>
                                                        <td>'.$euss_exp.'</td>
                                                        <td>'.$dbs_exp.'</td>
                                                        <td>'.$nid_exp.'</td>
															<td>' . $dataeotherdoc . '</td>
															<td>' . $leave_allocation->hr . '</td>
															<td>' . $leave_allocation->home . '</td>
															<td>' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/change/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" ></i></a>


															 &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/changesendlet/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';

                        $f++;}
                } else {

                    $dojg = date('m-d', strtotime($employeet->emp_doj));
                    $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));
                    $no = '';
                    if (date('Y', strtotime($employeet->emp_doj)) != $m) {
                        if ($endtyear != $m) {
                            $no = 'no change ';
                        } else {
                            $no = '';
                        }
                        $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>

													<td></td>
														<td></td>

													<td></td>
														<td></td>

															<td></td>
															<td> </td>
																<td>' . $no . '</td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td>' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/change/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" ></i></a>&nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/changesendlet/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';
                        $f++;}
                }
            }

            for ($o = ($endtyear + 1); $o <= ($endtyear + 4); $o++) {

                $dojg = date('m-d', strtotime($employeet->emp_doj));
                $anual_date = date('Y-m-d', strtotime($o . '-' . $dojg . '  + 1 year'));

                $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>

													<td></td>
														<td></td>

													<td></td>
														<td></td>

															<td></td>
															<td> </td>
																<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td>' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/change/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" ></i></a>&nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/changesendlet/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" ><i class="fas fa-paper-plane" ></i></a></td>


						</tr>';
                $f++;
            }

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['employee_code'] = $employee_code;
            $data['employee_type'] = $employee_type;
            return view('dashboard/change-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewemployeeagreement()
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

            return view('dashboard/contract-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveemployeeagreement(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $employee_code = $request->employee_code;
            $employee_type = $request->employee_type;

            $data['result'] = '';if ($employee_code != '') {

                $leave_allocation_rs = DB::table('employee')

                    ->where('emp_code', '=', $employee_code)
                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_status', '=', $employee_type)

                    ->select('employee.*')
                    ->get();
            } else {
                $leave_allocation_rs = DB::table('employee')

                    ->where('emid', '=', $Roledata->reg)
                    ->where('emp_status', '=', $employee_type)

                    ->select('employee.*')
                    ->get();
            }

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {$f = 1;

                foreach ($leave_allocation_rs as $leave_allocation) {

                    $peradd = '';
                    $peradd = $leave_allocation->emp_pr_street_no;
                    if ($leave_allocation->emp_per_village) {$peradd .= ',' . $leave_allocation->emp_per_village;}
                    if ($leave_allocation->emp_pr_state) {$peradd .= ',' . $leave_allocation->emp_pr_state
                        ;}if ($leave_allocation->emp_pr_city) {$peradd .= ',' . $leave_allocation->emp_pr_city;}
                    if ($leave_allocation->emp_pr_pincode) {$peradd .= ',' . $leave_allocation->emp_pr_pincode;}
                    if ($leave_allocation->emp_pr_country) {$peradd .= ',' . $leave_allocation->emp_pr_country;};

                    $preadd = '';
                    $preadd = $leave_allocation->emp_ps_street_no;
                    if ($leave_allocation->emp_ps_village) {$preadd .= ',' . $leave_allocation->emp_ps_village;}
                    if ($leave_allocation->emp_ps_state) {$preadd .= ',' . $leave_allocation->emp_ps_state
                        ;}if ($leave_allocation->emp_ps_city) {$preadd .= ',' . $leave_allocation->emp_ps_city;}
                    if ($leave_allocation->emp_ps_pincode) {$preadd .= ',' . $leave_allocation->emp_ps_pincode;}
                    if ($leave_allocation->emp_ps_country) {$preadd .= ',' . $leave_allocation->emp_ps_country;};

                    $employeet = DB::table('employee')->where('emp_code', '=', $leave_allocation->emp_code)->where('emid', '=', $Roledata->reg)->first();

                    $dteemployeet = '';
                    if ($employeet->visa_exp_date != '1970-01-01') {$dteemployeet = date('d/m/Y', strtotime($employeet->visa_exp_date));}
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $employee_type . '</td>
													<td>' . $leave_allocation->emp_code . '</td>
													<td>' . $employeet->emp_fname . '  ' . $employeet->emp_mname . ' ' . $employeet->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->emp_dob)) . '</td>
													<td>' . $leave_allocation->emp_ps_phone . '</td>
														<td>' . $leave_allocation->nationality . '</td>
														<td>' . $leave_allocation->ni_no . '</td>
															<td>' . $dteemployeet . '</td>
															<td>' . $leave_allocation->pass_doc_no . '</td>
															<td>' . $peradd . '</td>


													<td><a href="contract-agreement-edit/' . base64_encode($leave_allocation->emp_code) . '"><i class="fas fa-file-pdf"></i></a>
													<a href="contract-word/' . base64_encode($leave_allocation->emp_code) . '"><i class="fas fa-file-word"></i></a></td>


						</tr>';
                    $f++;}
            }
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['employee_code'] = $request->employee_code;
            $data['employee_type'] = $request->employee_type;
            return view('dashboard/contract-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewemployeeagreementdit($emp_id)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-31');
            $offarr = 0;
            $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

            $currency_auth = DB::table('currencies')

                ->where('code', '=', $emjob->currency)
                ->orderBy('id', 'DESC')
                ->first();
            $pay_type_auth = DB::table('payment_type_master')

                ->where('id', '=', $emjob->emp_payment_type)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($emjob->emp_department)) {

                $employee_depers = DB::table('department')
                    ->where('department_name', '=', $emjob->emp_department)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();

                $employee_desigrs = DB::table('designation')
                    ->where('designation_name', '=', $emjob->emp_designation)
                    ->where('department_code', '=', $employee_depers->id)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $duty_auth = DB::table('duty_roster')
                    ->where('department', '=', $employee_depers->id)
                    ->where('designation', '=', $employee_desigrs->id)
                    ->where('employee_id', '=', base64_decode($emp_id))
                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                if (!empty($duty_auth)) {
                    $shift_auth = DB::table('shift_management')
                        ->where('department', '=', $employee_depers->id)
                        ->where('id', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $off_auth = DB::table('offday')
                        ->where('department', '=', $employee_depers->id)
                        ->where('shift_code', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                    $difference = abs($dateout - $datein) / 60;
                    $hours = floor($difference / 60);
                    $minutes = ($difference % 60);
                    $duty_hours = $hours;
                    $offarr = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;

                        }

                        if ($off_auth->mon == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->tue == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->wed == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->thu == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->fri == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                        if ($off_auth->sat == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                    }

                }

            } else {
                $offarr = 0;
            }

            $data['LeaveAllocation'] = DB::table('leave_allocation')
                ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
                ->where('leave_allocation.emid', '=', $Roledata->reg)
                ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

                ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                ->get();
            $sdate = $emjob->start_date;
            $edate = $emjob->end_date;

            $date_diff = abs(strtotime($edate) - strtotime($sdate));

            $years = floor($date_diff / (365 * 60 * 60 * 24));
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = '';
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = '';
            }
            $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'date' => $emjob->emp_doj, 'date_con' => $emjob->start_date, 'date_end' => $emjob->end_date, 'job_loc' => $emjob->job_loc, 'emid' => $emjob->emid, 'emp_code' => $emjob->emp_code, 'emp_pay_scale' => $emjob->emp_pay_scale, 'em_name' => $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname, 'em_pos' => $emjob->emp_designation, 'em_depart' => $emjob->emp_department, 'address_emp' => $emjob->emp_pr_street_no . ',' . $emjob->emp_per_village . ',' . $emjob->emp_pr_state . ',' . $emjob->emp_pr_city . ',' . $emjob->emp_pr_pincode . ',' . $emjob->emp_pr_country, 'em_co' => $Roledata->country, 'currency' => $emjob->currency, 'symbol' => $symbol, 'week_time' => $offarr, 'year_time' => $years, 'pay_type' => $pay_ty, 'LeaveAllocation' => $data['LeaveAllocation'], 'birth' => $emjob->country_birth
                , 'emp_de' => $emjob, 'Roledata' => $Roledata];

                //dd($datap);

            $pdf = PDF::loadView('mypdfagree', $datap);
            return $pdf->download('contract.pdf');
            Session::flash('message', 'Contract Agreement Create Successfully.');
            return redirect('dashboard/contract-agreement');
        } else {
            return redirect('/');
        }

    }

    public function msword($emp_id)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $first_day_this_year = date('Y-01-01');
            $last_day_this_year = date('Y-12-31');
            $offarr = 0;
            $emjob = DB::table('employee')->where('emp_code', '=', base64_decode($emp_id))->where('emid', '=', $Roledata->reg)->first();

            $currency_auth = DB::table('currencies')

                ->where('code', '=', $emjob->currency)
                ->orderBy('id', 'DESC')
                ->first();
            $pay_type_auth = DB::table('payment_type_master')

                ->where('id', '=', $emjob->emp_payment_type)
                ->orderBy('id', 'DESC')
                ->first();

            if (!empty($emjob->emp_department)) {

                $employee_depers = DB::table('department')
                    ->where('department_name', '=', $emjob->emp_department)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();

                $employee_desigrs = DB::table('designation')
                    ->where('designation_name', '=', $emjob->emp_designation)
                    ->where('department_code', '=', $employee_depers->id)
                    ->where('emid', '=', $Roledata->reg)
                    ->first();
                $duty_auth = DB::table('duty_roster')
                    ->where('department', '=', $employee_depers->id)
                    ->where('designation', '=', $employee_desigrs->id)
                    ->where('employee_id', '=', base64_decode($emp_id))
                    ->where('emid', '=', $Roledata->reg)
                    ->orderBy('id', 'DESC')
                    ->first();

                if (!empty($duty_auth)) {
                    $shift_auth = DB::table('shift_management')
                        ->where('department', '=', $employee_depers->id)
                        ->where('id', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $off_auth = DB::table('offday')
                        ->where('department', '=', $employee_depers->id)
                        ->where('shift_code', '=', $duty_auth->shift_code)
                        ->where('designation', '=', $employee_desigrs->id)

                        ->where('emid', '=', $Roledata->reg)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                    $difference = abs($dateout - $datein) / 60;
                    $hours = floor($difference / 60);
                    $minutes = ($difference % 60);
                    $duty_hours = $hours;
                    $offarr = 0;
                    if (!empty($off_auth)) {
                        if ($off_auth->sun == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;

                        }

                        if ($off_auth->mon == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->tue == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->wed == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->thu == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }

                        if ($off_auth->fri == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                        if ($off_auth->sat == '1') {
                            $offarr = $offarr + 0;
                        } else {
                            $offarr = $offarr + $duty_hours;
                        }
                    }

                }

            } else {
                $offarr = 0;
            }

            $LeaveAllocation = DB::table('leave_allocation')
                ->join('leave_type', 'leave_allocation.leave_type_id', '=', 'leave_type.id')
                ->where('leave_allocation.employee_code', '=', base64_decode($emp_id))
                ->where('leave_allocation.emid', '=', $Roledata->reg)
                ->whereBetween('leave_allocation.created_at', [$first_day_this_year, $last_day_this_year])

                ->select('leave_allocation.*', 'leave_type.leave_type_name', 'leave_type.alies')
                ->get();
            $sdate = $emjob->start_date;
            $edate = $emjob->end_date;

            $date_diff = abs(strtotime($edate) - strtotime($sdate));

            $years = floor($date_diff / (365 * 60 * 60 * 24));
            if (!empty($currency_auth)) {
                $symbol = $currency_auth->symbol;
            } else {
                $symbol = '';
            }
            if (!empty($pay_type_auth)) {
                $pay_ty = $pay_type_auth->pay_type;
            } else {
                $pay_ty = '';
            }

            $laeve_arr = array();
            $laeve_srt = '';
            $laeve_arr1 = array();
            $laeve_srt1 = '';

            if (count($LeaveAllocation) != 0) {
                foreach ($LeaveAllocation as $value) {
                    $laeve_arr[] = $value->leave_in_hand . '  days  ' . strtolower($value->leave_type_name);
                    $laeve_arr1[] = $value->max_no . '  days  ' . strtolower($value->leave_type_name);
                }

                $laeve_srt = implode(',', $laeve_arr);
                $laeve_srt1 = implode(',', $laeve_arr1);

            } else {
                $laeve_srt = '';
                $laeve_srt1 = '';
            }

            $address_emp = '';
            $em_name = $emjob->emp_fname . ' ' . $emjob->emp_mname . ' ' . $emjob->emp_lname;
            $address_emp .= $emjob->emp_pr_street_no;
            if ($emjob->emp_per_village) {$address_emp .= ', ' . $emjob->emp_per_village;}
            if ($emjob->emp_pr_state) {$address_emp .= ', ' . $emjob->emp_pr_state;}if ($emjob->emp_pr_city) {$address_emp .= ', ' . $emjob->emp_pr_city;}
            if ($emjob->emp_pr_pincode) {$address_emp .= ', ' . $emjob->emp_pr_pincode;}if ($emjob->emp_pr_country) {$address_emp .= ', ' . $emjob->emp_pr_country;}

            if ($emjob->start_date != '1970-01-01') {
                if ($emjob->start_date != '') {
                    $date_con = date('d/m/Y', strtotime($emjob->start_date));}
            } else {
                $date_con = '';
            }

            $job_r = DB::table('company_job_list')

                ->where('title', '=', $emjob->emp_designation)
                ->where('emid', '=', $Roledata->reg)
                ->orderBy('id', 'DESC')
                ->first();
            if (!empty($job_r)) {
                $job_p = ($job_r->des_job);

            } else {
                $job_p = '';
            }

            if (!empty($emjob->emp_payment_type)) {
                $emp_payment_type = DB::table('payment_type_master')

                    ->where('id', '=', $emjob->emp_payment_type)

                    ->orderBy('id', 'DESC')
                    ->first();
                if (strpos($emp_payment_type->pay_type, 'Weekly') !== false) {
                    $pay_y = 'Weekly';
                } else {
                    $pay_y = $emp_payment_type->pay_type;
                }

                $offarr = $emjob->min_work;
                $rate = $emjob->min_rate;
            } else {
                $pay_y = '';
                $offarr = '';
                $rate = '';
            }

            $perwd = '';

            if (!empty($emjob->wedges_paymode)) {
                $emp_wedgpayment_type = DB::table('payment_type_wedes')

                    ->where('id', '=', $emjob->wedges_paymode)

                    ->orderBy('id', 'DESC')
                    ->first();
                $perwd = $emp_wedgpayment_type->pay_type;
            }
            if ($Roledata->logo != '') {
                $imgf = '<img src="' . env("BASE_URL") . 'public/' . $Roledata->logo . '" alt="" width="100" height="100"  >';
            } else {
                $imgf = '';
            }
            $cash = '';
            if (!empty($emjob->emp_pay_type) && $emjob->emp_pay_type == 'Bank') {
                $cash = 'BACS';} else if ($emjob->emp_pay_type == 'Cash') {$cash = 'cash';} else {
                $cash = 'BACS';
            }
            $mainadd = $Roledata->address;
            if ($Roledata->address2 != '') {
                $mainadd .= $Roledata->address2;
            }
            if ($Roledata->road != '') {
                $mainadd .= $Roledata->road;
            }
            if ($Roledata->city != '') {
                $mainadd .= $Roledata->city;
            }
            if ($Roledata->zip != '') {
                $mainadd .= $Roledata->zip;
            }
            if ($Roledata->country != '') {
                $mainadd .= $Roledata->country;
            }

            $headers = array(

                "Content-type" => "text/html",
                'name' => 'Arial', 'size' => 20, 'bold' => true,
                "Content-Disposition" => "attachment;Filename=contract.doc",

            );

            $content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Employee Agreement</title>
</head>


  <body>
  <table width="100%" style="text-align: left;">
    <tbody>
      <tr>
 <th style="text-align: left;">';
            $content .= $imgf;
            $content .= ' </th>
   </tr>
      <tr><th><h2 style="margin: 0;text-align: left;">';
            $content .= $Roledata->com_name;

            $content .= '  <tr><th><h1 style="text-align:left;"><span style="border-bottom: 1px solid">Contract of Employment</span></h1></th></tr>
    <tr>
        <td><p style="margin: 0;font-weight:600;">Between the Employer, ';
            $content .= $Roledata->com_name;

            $content .= ' <p style="margin: 0;font-weight:600;">';
            $content .= $mainadd;
            $content .= '
</p>
          <p style="margin: 0;font-weight:600;">and the Employee, ';
            $content .= $em_name;

            $content .= '</p>
          <p style="margin: 0;font-weight:600;">';
            $content .= $address_emp;

            $content .= '   </p>
        </td>
      </tr>
      <tr><td><h3 style="font-weight: 600">Start of Employment and Duration of Contract</h3>
        <p>The employment will start on ';
            $content .= $date_con;

            $content .= '  and
        the Initial duration of work is a 3 year period. This contract may be extended in future subject to your performance and subject to immigration control if
        it is required for your visa condition.</p></td></tr>
<tr><td>
        <h3 style="font-weight: 600;">Probationary Period</h3>
        <p>The employment is subject to the completion of a 3months probationary period.</p>

<p>If, at the end of the probationary period, the Employee performance is considered to be of a satisfactory standard, the appointment will be made permanent.</p>

<p>During the probationary period, one-week notice may be given by either party to terminate this contract.</p>
<p>In lieu of notice during the probationary period, the Employer may pay the Employee the salary that he would have earned till the end of probationary period.</p></td>
      </tr>
      <tr><td>

<h3 style="font-weight: 600;">Job Description</h3>
<p>The Employee is engaged initially to perform the duties of   ';
            $content .= $emjob->emp_designation;

            $content .= ' </p> ';
            $content .= $job_p;

            $content .= ' <p>The Employee will, however, be expected to carry out any other reasonable duties in line with his responsibilities to assist in the smooth operation of the business.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Medical Fitness</h3>
<p>It is a condition of the employment that the Employer is satisfied on the Employee medical fitness to carry out duties.</p>

<p>This appointment is conditional on a satisfactory Occupational Health Service/Employer Doctor assessment.</p>

<p>Should it be deemed necessary during the employment, the Employee may be required to attend for a medical examination from the Employer Doctor/Occupational Health Service.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Qualifications</h3>
<p>If the Employee employment with the Employer is dependent upon the possession of particular qualifications or registration with a statutory Body or other Authority, then evidence of this must be produced on request.</p>

<p>Failure to produce such evidence may lead to the termination of the employment.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Place of Work</h3>
<p>The normal place of work will be at the Employer address shown above.</p>

<p>Following reasonable notice and consultation, however, the Employee would be expected to work at any other premises if required.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Working Hours</h3>
<p>The working hours are ';
            $content .= $offarr;

            $content .= '    per week.</p>

<p>The Employer may require the Employee to vary the pattern of his working hours to meet the needs of the service.</p>

<p>The Employee entitlement to have paid refreshment breaks.</p>
<p><b>Remuneration</b></p>
<p>You are entitled to be paid GBP ';
            $content .= $rate;

            $content .= '   per ';
            $content .= $pay_y;

            $content .= ' . Your salary will be paid ';
            $content .= $perwd;
            $content .= ' by ';
            $content .= $cash;
            $content .= '.</p>


<p>Your rate of pay will be reviewed in every six months. Your rate of pay will not necessarily increase as a result of the review. </p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Overtime payments</h3>
<p>Additional payments will be made for overtime worked as per company policy.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Holidays</h3>
<p>The Management holiday year runs from 1st January to 31st December inclusive. If you work part time your pro-rata entitlement will be based on the number of hours you work. If you work as a full time employee you will be entitled to have 28 days paid holiday in each year, in addition to statutory holidays.You are allowed to take an unpaid holiday subject to special circumstances, but it must be prior approved by the management.</p>

<p>You must obtain authorization from the Management before making any holiday arrangements. The date
of holidays must be agreed with the Employer and a Holiday Request must be completed and authorized by the Employer at least 14 days prior to your proposed holiday dates.
<b>Any unauthorized absence for more than 10 days will be notified to the Home Office UKVI if it is required for your visa condition.</b>
Furthermore, disciplinary action may be taken against you. You must inform the management immediately if there is any change of circumstance,such as change of contact details, change of your immigration status etc</p>

</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Sickness</h3>
<p>Subject to you complying with the above notification and certification requirements, plus any additional rules introduced from time to time, you will, if eligible, be paid Statutory Sick Pay in accordance with the legislation applying from time to time.</p>

<p>For the purpose of Statutory Sick Pay, your qualifying days are Monday to Friday.</p>

<p>The Employer does not operate a sick pay scheme other than Statutory Sick Pay.</p>
</td>
      </tr>
      <tr><td>

<h3 style="font-weight: 600;">Pension Scheme</h3>
<p>We"ll automatically enroll you into our occupational pension scheme within two months of the start of the employment in accordance with our obligations under Part 1 of the Pensions Act 2008. You will have the option to opt out of automatic enrollment. Details of the scheme will be provided once you join.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Notice of Termination</h3>
<p>Where there is just cause for termination, the Employer may terminate the Employee employment without notice, as permitted by law.</p>

<p>The Employee and the Employer agree that reasonable and sufficient notice of termination of employment by the Employer is the greater of four (4) weeks or any minimum notice required by law.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Redundancy</h3>
<p>If the Employer decides to reduce manning levels, suitable volunteers will be asked for.</p>

<p>In addition, the Employer may select other employees for redundancy on the basis of an assessment of relative capabilities, performance, service length, conduct, reliability, attendance record and suitability for the remaining work.</p>

<p>In the event of redundancy, statutory redundancy terms will apply.</p>

</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Rules of Conduct</h3>
<p>The Employee must:</p>
<ul>
<li>not endanger the health or safety of any employee whilst at work;</li>
<li>at all times use as instructed any protective clothing or equipment which has been issued;</li>
<li>immediately report accidents, no matter how slight;</li>
<li>observe all rules concerning smoking and fire hazards;</li>
<li>act wholeheartedly in the interests of the Employer at all times;</li>
<li>acquaint (himself/herself) with all authorised notices displayed at his place of work;</li>
<li>inform the Employer if he contracts a contagious illness;</li>
<li>not remove any material or equipment from his place of work without prior permission;</li>
<li>not use the Employer time, material or equipment for unauthorised work;</li>
<li>at all times follow Employer working and operation procedures.</li>

</ul>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Misconduct Leading to Summary Dismissal Without Notice</h3>
<ul>
<li>theft of the Employer property;</li>
<li>fighting, physical assault or dangerous horseplay;</li>
<li>failure to carry out a direct instruction from a superior during working hours;</li>
<li>use of bad language or aggressive behavior on the Employer premises or in front of customers;</li>
<li>wilful and/or deliberate damage of the Employer property;</li>
<li>incapability through alcohol or illegal drugs;</li>
<li>loss of driving licence where driving is an essential part of the job;</li>
<li>endangering the health or safety of another person at the place of work;</li>
<li>deliberately falsifying the Employer records;</li>
<li>receiving bribes to affect the placing of business with a supplier of goods or services;</li>
<li>falsely claiming to be sick in order to defraud the Employer;</li>
<li>immoral conduct.</li>
</ul>
</td>
      </tr>
      <tr><td>


<h3 style="font-weight: 600;">Disciplinary Action</h3>
<p>Should the need for disciplinary action be deemed necessary, this will be taken in accordance with the Employer Policy and Procedure on Disciplinary Action.</p>
</td>
      </tr>
      <tr><td>
<h3 style="font-weight: 600;">Grievances</h3>
<p>Where the Employee has a grievance relating to any aspect of their employment,they should contact their immediate manager and give full details of his grievance, in confidence.</p>

<p>The Employee should allow reasonable time for consideration of all the facts before remedial action can be taken.</p>
</td>
      </tr>
      <tr><td>
<p>Where the Employee immediate manager is not able satisfactorily to resolve the grievance, the Employee should refer the matter in writing to the most senior manager available.</p>

<p>The Employee has the right to be accompanied by a work colleague or by another person as in accordance with the current legislation throughout the grievance procedure.</p>


<p style="font-weight: 600;">If you agree with the above terms and conditions please sign both copies of this Contract, retain one and return the other to me.</p>

      </td>
    </tr>
<tr>
  <td><p style="font-weight: 600;">Signed  ______________________________<br>for ';
            $content .= $Roledata->com_name;

            $content .= ' , <span style="float:right;">Date: ';
            $content .= '  _______________';

            $content .= '  </span></p>
<br>
    <p style="font-weight: 600;">Signed ______________________________<br>for ';
            $content .= $em_name;

            $content .= ' , <span style="float:right;">Date:';
            $content .= '  _______________';

            $content .= ' </span> </p>
  </td>
</tr>
    </tbody>
  </table>





  </body>
</html>';

            return \Response::make($content, 200, $headers);

        } else {
            return redirect('/');
        }

    }
    public function viewAddEmployeereportnewsenmail($comp_id, $emp_id)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($comp_id))
                ->first();
            $data['employeedata'] = DB::table('employee')

                ->where('emid', '=', base64_decode($comp_id))
                ->where('emp_code', '=', base64_decode($emp_id))
                ->first();

            return View('dashboard/msg-add-migrant', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewAddEmployeereportnewsenmailtext($comp_id, $emp_id)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($comp_id))
                ->first();
            $data['employeedata'] = DB::table('employee')

                ->where('emid', '=', base64_decode($comp_id))
                ->where('emp_code', '=', base64_decode($emp_id))
                ->first();

            return View('dashboard/msg-add-migrant', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewmsgcen()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['msg_rs'] = DB::Table('employee_messaage_center')
                ->where('emid', '=', $Roledata->reg)
                ->orderBy('id', 'desc')
                ->get();

            return View('dashboard/msg-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function addmscen()
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['or_rs'] = DB::Table('employee')
                ->where('emid', '=', $Roledata->reg)

                ->get();

            return View('dashboard/msg-add', $data);
        } else {
            return redirect('/');
        }
    }

    public function savemscen(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            if ($request->has('file')) {

                $file_visa_doc = $request->file('file');
                $extension_visa_doc = $request->file->extension();
                $path_visa_doc = $request->file->store('msg_file_user', 'public');

            } else {

                $path_visa_doc = '';

            }

            $data = array(

                'emid' => $Roledata->reg,
                'employee_id' => $request->employee_id,
                'file' => $path_visa_doc,
                'subject' => $request->subject,
                'msg' => $request->msg,
                'email' => $request->email,
                'date' => date('Y-m-d'),

            );

            DB::table('employee_messaage_center')->insert($data);
            $Roleempdata = DB::Table('employee')
                ->where('emid', '=', $Roledata->reg)
                ->where('emp_code', '=', $request->employee_id)
                ->first();
            if ($path_visa_doc != '') {
                $path = public_path() . '/' . $path_visa_doc;
                $sub = $request->subject;
                $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                    'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                $toemail = $request->email;
                Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub, $path) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ($sub);
                    $message->attach($path);
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });

                if ($request->cc != '') {

                    $path = public_path() . '/' . $path_visa_doc;
                    $sub = $request->subject;
                    $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                        'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                    $toemail = $request->cc;
                    Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub, $path) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ($sub);
                        $message->attach($path);
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }
            } else {
                $sub = $request->subject;
                $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                    'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                $toemail = $request->email;
                Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ($sub);
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });

                if ($request->cc != '') {

                    $sub = $request->subject;
                    $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                        'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                    $toemail = $request->cc;
                    Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ($sub);
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }
            }

            Session::flash('message', 'Message Send Successfully .');

            return redirect('dashboard/message-center');
        } else {
            return redirect('/');
        }
    }

    public function savemscenmigrant(Request $request)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            if ($request->has('file')) {

                $file_visa_doc = $request->file('file');
                $extension_visa_doc = $request->file->extension();
                $path_visa_doc = $request->file->store('msg_file_user', 'public');

            } else {

                $path_visa_doc = '';

            }

            $data = array(

                'emid' => $Roledata->reg,
                'file' => $path_visa_doc,
                'employee_id' => $request->employee_id,
                'subject' => $request->subject,
                'msg' => $request->msg,
                'email' => $request->email,
                'date' => date('Y-m-d'),

            );

            DB::table('employee_messaage_center')->insert($data);
            $Roleempdata = DB::Table('employee')
                ->where('emid', '=', $Roledata->reg)
                ->where('emp_code', '=', $request->employee_id)
                ->first();
            if ($path_visa_doc != '') {
                $path = public_path() . '/' . $path_visa_doc;
                $sub = $request->subject;
                $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                    'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                $toemail = $request->email;
                Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub, $path) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ($sub);
                    $message->attach($path);
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });
                if ($request->cc != '') {

                    $path = public_path() . '/' . $path_visa_doc;
                    $sub = $request->subject;
                    $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                        'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                    $toemail = $request->cc;
                    Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub, $path) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ($sub);
                        $message->attach($path);
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }
            } else {
                $sub = $request->subject;
                $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                    'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                $toemail = $request->email;
                Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub) {
                    $message->to($toemail, 'Workpermitcloud')->subject
                        ($sub);
                    $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                });
                if ($request->cc != '') {
                    $sub = $request->subject;
                    $data = array('name' => $Roleempdata->emp_fname . ' ' . $Roleempdata->emp_mname . ' ' . $Roleempdata->emp_lname, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->emp_ps_mobile,
                        'email' => $Roleempdata->emp_ps_email, 'msg' => $request->msg);
                    $toemail = $request->cc;
                    Mail::send('mailormsgcenemp', $data, function ($message) use ($toemail, $sub) {
                        $message->to($toemail, 'Workpermitcloud')->subject
                            ($sub);
                        $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
                    });

                }
            }

            Session::flash('message', 'Message Send Successfully .');

            return redirect('dashboard/message-center');
        } else {
            return redirect('/');
        }
    }
    public function viewofferdownsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/firstmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewofferdownsendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/secondmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewofferdownsendcandidatedetailsthired($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/thirdmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

            $toemail = $job->emp_ps_email;

            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Visa Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function viewsendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Visa Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }
    public function viewsendcandidatedetailsthird($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;
            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Visa Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }
    public function viewsendcandidatedetailssendnew($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;

            Mail::send('mailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Visa Review Reminder send Successfully.');

            return redirect('dashboard-migrant-employees');
        } else {
            return redirect('/');
        }

    }

    public function viewsendcandidatedetailssecondsendnew($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('mailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Visa Review Reminder send Successfully.');

            return redirect('dashboard-migrant-employees');
        } else {
            return redirect('/');
        }

    }
    public function viewsendcandidatedetailsthirdsendnew($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;
            Mail::send('mailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Visa 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Visa Review Reminder send Successfully.');

            return redirect('dashboard-migrant-employees');
        } else {
            return redirect('/');
        }

    }

    public function getEmployeesright()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_rs'] = DB::table('right_works')->where('emid', '=', $Roledata->reg)->get();

            return view('dashboard/right-works', $data);
        } else {
            return redirect('/');
        }
    }

    public function addEmployeesright()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_rs'] = DB::table('employee')
                ->where('emid', '=', $Roledata->reg)
                ->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->get();

            return view('dashboard/add-right-works', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveEmployeesright(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $date['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            if ($request->date != '') {
                $vis_due = date('Y-m-d', strtotime($request->date));
            } else {
                $vis_due = '';
            }
            if (isset($_POST['type']) && $_POST['type'] != '') {
                $type = implode(',', $_POST['type']);
            } else {
                $type = '';
            }

            if (isset($_POST['mediumgg']) && $_POST['mediumgg'] != '') {
                $medium = implode(',', $_POST['mediumgg']);
            } else {
                $medium = '';
            }
            if ($request->start_date != '') {
                $start_date = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start_date = '';
            }
            if (isset($_POST['list_ap']) && $_POST['list_ap'] != '') {
                $list_ap = implode(',', $_POST['list_ap']);
            } else {
                $list_ap = '';
            }

            if (isset($_POST['list_bp']) && $_POST['list_bp'] != '') {
                $list_bp = implode(',', $_POST['list_bp']);
            } else {
                $list_bp = '';
            }
            if (isset($_POST['list_bpc']) && $_POST['list_bpc'] != '') {
                $list_bpc = implode(',', $_POST['list_bpc']);
            } else {
                $list_bpc = '';
            }
            if (isset($_POST['passports']) && $_POST['passports'] != '') {
                $passports = implode(',', $_POST['passports']);
            } else {
                $passports = '';
            }
            if (isset($_POST['type_of_excuse']) && $_POST['type_of_excuse'] != '') {
                $type_of_excuse = implode(',', $_POST['type_of_excuse']);
            } else {
                $type_of_excuse = '';
            }
            if ($request->list_euss_follow != '') {
                $list_euss_follow = date('Y-m-d', strtotime($request->list_euss_follow));
            } else {
                $list_euss_follow = '';
            }

            $pay = array(
                'type_of_excuse' => $type_of_excuse,
                'employee_id' => $request->employee_id,
                'emid' => $Roledata->reg,
                'name' => $request->name,
                'list_euss_follow' => $list_euss_follow,
                'list_eusss' => $request->list_eusss,
                'list_euss_follow' => $request->list_euss_follow,
                'date' => $vis_due,

                'medium' => $medium,
                'type' => $type,
                'evidence' => $request->evidence,

                'start_date' => $start_date,
                'start_time' => $request->start_time,
                'list_ap' => $list_ap,
                'list_bp' => $list_bp,
                'list_bpc' => $list_bpc,
                'photographs' => $request->photographs,
                'dates' => $request->dates,
                'expiry' => $request->expiry,
                'checked' => $request->checked,
                'satisfied' => $request->satisfied,
                'reasons' => $request->reasons,
                'passports' => $passports,
                'list_right' => $request->list_right,
                'list_right_follow' => $request->list_right_follow,
                'list_right_date' => $request->list_right_date,
                'list_rightb' => $request->list_rightb,
                'list_rightb_follow' => $request->list_rightb_follow,
                'list_rightb_date' => $request->list_rightb_date,
                'list_rightti' => $request->list_rightti,
                'list_rightti_follow' => $request->list_rightti_follow,
                'list_rightti_date' => $request->list_rightti_date,
                'list_rightbs' => $request->list_rightbs,
                'list_rightbs_follow' => $request->list_rightbs_follow,
                'list_rightbs_date' => $request->list_rightbs_date,
                'scan_f' => $request->scan_f,
                'scan_s' => $request->scan_s,
                'scan_r' => $request->scan_r,
                'result' => $request->result,
                'remarks' => $request->remarks,
                'checker' => $request->checker,
                'contact' => $request->contact,
                'emp_id' => $request->emp_id,
                'designation' => $request->designation,
                'email' => $request->email,
                'scan_f_img' => $request->scan_f_img,
                'scan_s_img' => $request->scan_s_img,
                'scan_r_img' => $request->scan_r_img,
                'cr_date' => date('Y-m-d'),
                'up_date' => date('Y-m-d'),
            );
            DB::table('right_works')->insert($pay);
            Session::flash('message', 'Right to Work checks Added Successfully');

            return redirect('dashboard-right-works');

        } else {
            return redirect('/');
        }

    }

    public function viewsendcandidatedetailswork($send_id)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['work_rs'] = DB::table('right_works')->where('id', '=', base64_decode($send_id))->first();
            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $data['work_rs']->employee_id)->first();

            if ($data['work_rs']->date >= '2021-07-01') {
                return view('dashboard/view-work', $data);

            } else {
                return view('dashboard/view-work-new', $data);
            }

        } else {
            return redirect('/');
        }
    }
    public function viewsendcandidatedetailsworkauth($send_id,$eml)
    {

        // if (!empty(Session::get('emp_email'))) {

            $email = base64_decode($eml);
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['work_rs'] = DB::table('right_works')->where('id', '=', base64_decode($send_id))->first();
            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $data['work_rs']->employee_id)->first();

            if ($data['work_rs']->date >= '2021-07-01') {
                return view('dashboard/pdf-work', $data);

            } else {
                return view('dashboard/pdf-work-new', $data);
            }

        // } else {
        //     return redirect('/');
        // }
    }

    public function downloadsendcandidatedetailswork($send_id)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['work_rs'] = DB::table('right_works')->where('id', '=', base64_decode($send_id))->first();
            // $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $data['work_rs']->employee_id)->first();

            // if ($data['work_rs']->date >= '2021-07-01') {
            //     return view('dashboard/view-work', $data);

            // } else {
            //     return view('dashboard/view-work-new', $data);
            // }
            $url = URL::to("/");

            $urlView = $url . '/dashboard/work-view-auth/' . $send_id.'/'.base64_encode($email);
            $html90 = file_get_contents($urlView);

            //manipulations for pdf
            // $pattern = '/<embed/i';
            // $pattern1 = '/<\/embed>/i';
            // $html90 = preg_replace($pattern, '<img',$html90);
            // $html90 = preg_replace($pattern1, '',$html90);

            // dd($html90);

            $datapdf = [
                'html_content' => $html90,
            ];

            $pdf = PDF::loadView('mypdfRTW',$datapdf);
            $file='RTW_'.$data['work_rs']->employee_id.'.pdf';
            return $pdf->download($file);


        } else {
            return redirect('/');
        }
    }

    public function viewsendcandidatedetailsworkedit($send_id)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $date['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['work_rs'] = DB::table('right_works')->where('id', '=', base64_decode($send_id))->first();
            $data['employeeh'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->where('emp_code', '=', $data['work_rs']->employee_id)->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();

            if ($data['work_rs']->date >= '2021-07-01') {
                return view('dashboard/edit-work', $data);

            } else {
                return view('dashboard/edit-work-new', $data);
            }
        } else {
            return redirect('/');
        }
    }
    public function saveEmployeesrightedit(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $date['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            if ($request->date != '') {
                $vis_due = date('Y-m-d', strtotime($request->date));
            } else {
                $vis_due = '';
            }
            if (isset($_POST['type']) && $_POST['type'] != '') {
                $type = implode(',', $_POST['type']);
            } else {
                $type = '';
            }

            if (isset($_POST['medium']) && $_POST['medium'] != '') {
                $medium = implode(',', $_POST['medium']);
            } else {
                $medium = '';
            }
            if ($request->start_date != '') {
                $start_date = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start_date = '';
            }
            if (isset($_POST['list_ap']) && $_POST['list_ap'] != '') {
                $list_ap = implode(',', $_POST['list_ap']);
            } else {
                $list_ap = '';
            }

            if (isset($_POST['list_bp']) && $_POST['list_bp'] != '') {
                $list_bp = implode(',', $_POST['list_bp']);
            } else {
                $list_bp = '';
            }
            if (isset($_POST['list_bpc']) && $_POST['list_bpc'] != '') {
                $list_bpc = implode(',', $_POST['list_bpc']);
            } else {
                $list_bpc = '';
            }
            if (isset($_POST['passports']) && $_POST['passports'] != '') {
                $passports = implode(',', $_POST['passports']);
            } else {
                $passports = '';
            }

            if (isset($_POST['type_of_excuse']) && $_POST['type_of_excuse'] != '') {
                $type_of_excuse = implode(',', $_POST['type_of_excuse']);
            } else {
                $type_of_excuse = '';
            }
            if ($request->list_euss_follow != '') {
                $list_euss_follow = date('Y-m-d', strtotime($request->list_euss_follow));
            } else {
                $list_euss_follow = '';
            }

            $pay = array(

                'type_of_excuse' => $type_of_excuse,
                'date' => $vis_due,

                'medium' => $medium,
                'type' => $type,
                'evidence' => $request->evidence,
                'list_euss_follow' => $list_euss_follow,
                'list_eusss' => $request->list_eusss,
                'list_euss_follow' => $request->list_euss_follow,
                'start_date' => $start_date,
                'start_time' => $request->start_time,
                'list_ap' => $list_ap,
                'list_bp' => $list_bp,
                'list_bpc' => $list_bpc,
                'photographs' => $request->photographs,
                'dates' => $request->dates,
                'expiry' => $request->expiry,
                'checked' => $request->checked,
                'satisfied' => $request->satisfied,
                'reasons' => $request->reasons,
                'passports' => $passports,
                'list_right' => $request->list_right,
                'list_right_follow' => $request->list_right_follow,
                'list_right_date' => $request->list_right_date,
                'list_rightb' => $request->list_rightb,
                'list_rightb_follow' => $request->list_rightb_follow,
                'list_rightb_date' => $request->list_rightb_date,
                'list_rightti' => $request->list_rightti,
                'list_rightti_follow' => $request->list_rightti_follow,
                'list_rightti_date' => $request->list_rightti_date,
                'list_rightbs' => $request->list_rightbs,
                'list_rightbs_follow' => $request->list_rightbs_follow,
                'list_rightbs_date' => $request->list_rightbs_date,
                'scan_f' => $request->scan_f,
                'scan_s' => $request->scan_s,
                'scan_r' => $request->scan_r,
                'result' => $request->result,
                'remarks' => $request->remarks,
                'checker' => $request->checker,
                'contact' => $request->contact,
                'emp_id' => $request->emp_id,
                'designation' => $request->designation,
                'email' => $request->email,
                'scan_f_img' => $request->scan_f_img,
                'scan_s_img' => $request->scan_s_img,
                'scan_r_img' => $request->scan_r_img,

                'up_date' => date('Y-m-d'),
            );
            DB::table('right_works')->where('id', $request->newid)->update($pay);
            Session::flash('message', 'Right to Work checks Edited Successfully');

            return redirect('dashboard-right-works');

        } else {
            return redirect('/');
        }

    }
    public function viewofferdownsendcandidatedetailssend_iddate($send_id, $date)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $date = base64_decode($date);

            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $jocirb = DB::table('change_circumstances')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'job' => $job, 'circum' => $jocirb, 'date' => ($date));

            return View('dashboard/mailcircum', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewsendcandidatedetailsthirdsend_iddate($send_id, $date)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $date = base64_decode($date);
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $jocirb = DB::table('change_circumstances')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'job' => $job, 'circum' => $jocirb, 'date' => ($date));

            $toemail = $job->emp_ps_email;

            Mail::send('mailcircum', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Change of Circumstances - Annual Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;
            Mail::send('mailcircum', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    (' Change of Circumstances - Annual Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('message', 'Annual  Reminder send Successfully.');

            return redirect('dashboard/change-of-circumstances');
        } else {
            return redirect('/');
        }

    }
    public function getCompaniesofficerkey()
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            return view('dashboard/employee-key-link', $data);
        } else {
            return redirect('/');
        }
    }

    public function addEmployeesrightByDate()
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();

            return view('dashboard/add-right-works-by-date', $data);
        } else {
            return redirect('/');
        }
    }

    public function saveEmployeesrightByDate(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['employee_rs'] = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();
            if ($request->date != '') {
                $data['vis_due'] = date('Y-m-d', strtotime($request->date));
            } else {
                $data['vis_due'] = '';
            }

            if ($request->start_date != '') {
                $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            } else {
                $data['start_date'] = '';
            }
            $data['employee_id'] = $request->employee_id;
            if ($data['vis_due'] >= '2021-07-01') {
                return view('dashboard/add-right-works', $data);

            } else {
                return view('dashboard/add-right-works-new', $data);
            }

        } else {
            return redirect('/');
        }
    }

    public function viewpassportdownsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/passportfirstmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewpassportdownsendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/passportsecondmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewpassportdownsendcandidatedetailsthired($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/passportthirdmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewpassportsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

            $toemail = $job->emp_ps_email;

            Mail::send('passmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Passport 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('passmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Passport 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'Passport Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function viewpassportsendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('passmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Passport 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('passmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Passport 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'Passport Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }
    public function viewpassportsendcandidatedetailsthird($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('passmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Passport 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;
            Mail::send('passmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary Passport 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'Passport Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function viewAddpassportEmployeereportnewsenmailtext($comp_id, $emp_id)
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('reg', '=', base64_decode($comp_id))
                ->first();
            $data['employeedata'] = DB::table('employee')

                ->where('emid', '=', base64_decode($comp_id))
                ->where('emp_code', '=', base64_decode($emp_id))
                ->first();

            return View('dashboard/msg-add-migrant', $data);
        } else {
            return redirect('/');
        }

    }
    //DBS
    public function viewdbsdownsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/dbsfirstmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewdbsdownsendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/dbssecondmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewdbsdownsendcandidatedetailsthired($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/dbsthirdmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function viewdbssendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

            $toemail = $job->emp_ps_email;

            Mail::send('dbsmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary DBS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('dbsmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary DBS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'DBS Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function viewdbssendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('dbsmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary DBS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('dbsmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary DBS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'DBS Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function viewdbssendcandidatedetailsthird($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('dbsmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary DBS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;
            Mail::send('dbsmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary DBS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'DBS Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }
    //EUSS
    public function vieweussdownsendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/eussfirstmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function vieweussdownsendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/eusssecondmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function vieweussdownsendcandidatedetailsthired($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'Roledata' => $Roledata, 'offer' => $job);

            return View('dashboard/eussthirdmail', $data);

        } else {
            return redirect('/');
        }

    }

    public function vieweusssendcandidatedetails($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);

            $toemail = $job->emp_ps_email;

            Mail::send('eussmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('eussmailsendfirt', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 90-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'EUSS Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function vieweusssendcandidatedetailssecond($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;

            Mail::send('eussmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            $toemail = $Roledata->authemail;

            Mail::send('eussmailsendsecond', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 60-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'EUSS Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

    public function vieweusssendcandidatedetailsthird($send_id)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $pdf = '';
            $fo = '';
            $job = DB::table('employee')->where('emp_code', '=', base64_decode($send_id))->where('emid', '=', $Roledata->reg)->first();

            $data = array('com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'Roledata' => $Roledata, 'offer' => $job);
            $toemail = $job->emp_ps_email;
            //$toemail = 'm.subhasish@gmail.com';

            Mail::send('eussmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });
            $toemail = $Roledata->authemail;
            //$toemail = 'm.subhasish@gmail.com';
            Mail::send('eussmailsendthird', $data, function ($message) use ($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                    ('Right to Work Documentation – Temporary EUSS 30-day Reminder');

                $message->from('noreply@workpermitcloud.co.uk', 'Workpermitcloud');
            });

            Session::flash('pasmessage', 'EUSS Review Reminder send Successfully.');

            return redirect('dashboarddetails');
        } else {
            return redirect('/');
        }

    }

}
