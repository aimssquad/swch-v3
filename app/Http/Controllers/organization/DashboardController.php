<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ExcelFileExportStaff;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Mail;
use URL;
use PDF;
use Session;
use view;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.sopnsor-compliance';
        //$this->_model       = new CompanyJobs();
    }


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
                //dd('okk');
            return view($this->_routePrefix . '.dashboard',$data);
            //return view('dashboard/dashboard', $data);

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
            return view($this->_routePrefix . '.employee',$data);
            //return view('dashboard/employee', $data);
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
            return view($this->_routePrefix . '.employee-migrant',$data);
            //return view('dashboard/employee-migrant', $data);
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
            return view($this->_routePrefix . '.right-works',$data);

            //return view('dashboard/right-works', $data);
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
            return view($this->_routePrefix . '.add-right-works-by-date',$data);
            //return view('dashboard/add-right-works-by-date', $data);
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
            return view($this->_routePrefix . '.employee-key-link',$data);
            //return view('dashboard/employee-key-link', $data);
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
            return view($this->_routePrefix . '.employee-dossier',$data);
            //return view('dashboard/employee-dossier', $data);
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
            return view($this->_routePrefix . '.msg-list',$data);
            //return View('dashboard/msg-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function reportEmployeesexcelstaff(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $employee_rs = DB::table('employee')->where('emid', '=', $Roledata->reg)->get();

                return Excel::download(new ExcelFileExportStaff($Roledata->reg), 'staff.xlsx');

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
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
            return view($this->_routePrefix . '.absent-list',$data);
            //return view('dashboard/absent-list', $data);
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
            return view($this->_routePrefix . '.absent-list',$data);
            //return view('dashboard/absent-list', $data);

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
            return view($this->_routePrefix . '.absent-record',$data);
            //return view('dashboard/absent-record', $data);
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
            //dd($data['Roledata']);
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            return view($this->_routePrefix . '.change-list',$data);
            //return view('dashboard/change-list', $data);
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
            return view($this->_routePrefix . '.contract-list',$data);
            //return view('dashboard/contract-list', $data);
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
            //dd($Roledata->reg);
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
                //dd('okk');
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
                //dd('okkllll');
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
            } else { 
                //dd('oppps');
                $date_doj = date('d/m/Y', strtotime($employeet->emp_doj));
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
            $data['result'] .= 
                '<tr>
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
                    <td>' . $newpnapasas . '( ' . $stfol . ' )</td>
                    <td>'.$euss_exp.'</td>
                    <td>'.$dbs_exp.'</td>
                    <td>'.$nid_exp.'</td>
                    <td>' . $dataeotherdoc . '</td>
                    <td></td>
                    <td></td>
                    <td>' . date('d/m/Y', strtotime($anual_datenew)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/change/' . base64_encode($employee_code) . '/' . base64_encode($anual_datenew) . '" target="_blank"><i class="fas fa-eye" ></i></a>
                        &nbsp &nbsp <a href="' . env("BASE_URL") . 'employee/changesendlet/' . base64_encode($employee_code) . '/' . base64_encode($anual_datenew) . '" ><i class="fas fa-paper-plane" ></i></a>
                    </td>
                </tr>';
            //dd($employeet->emp_doj);
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
                    //dd('okkmmmm');
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

                        $data['result'] .= 
                            '<tr>
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
                                <td>' . $leave_allocation->pass_doc_no . '( ' . $stfol . ' )</td>
                                <td>'.$euss_exp.'</td>
                                <td>'.$dbs_exp.'</td>
                                <td>'.$nid_exp.'</td>
                                <td>' . $dataeotherdoc . '</td>
                                <td>' . $leave_allocation->hr . '</td>
                                <td>' . $leave_allocation->home . '</td>
                                <td>
                                    ' . date('d/m/Y', strtotime($anual_date)) . ' &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/change/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" target="_blank"><i class="fas fa-eye" ></i></a>
                                                &nbsp &nbsp <a href="' . env("BASE_URL") . 'dashboard/changesendlet/' . base64_encode($employee_code) . '/' . base64_encode($anual_date) . '" ><i class="fas fa-paper-plane" ></i></a>
                                </td>
                            </tr>';
                        $f++;
                    }
                } else {
                    //dd('dddd');
                    $dojg = date('m-d', strtotime($employeet->emp_doj));
                    $anual_date = date('Y-m-d', strtotime($m . '-' . $dojg . '  + 1 year'));
                    $no = '';
                    if (date('Y', strtotime($employeet->emp_doj)) != $m) {
                        if ($endtyear != $m) {
                            $no = 'no change ';
                        } else {
                            $no = '';
                        }
                        $data['result'] .= 
                            '<tr>
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
                        $f++;
                        //dd($data['result']);
                    }
                }
            }

            for ($o = ($endtyear + 1); $o <= ($endtyear + 4); $o++) {
                $dojg = date('m-d', strtotime($employeet->emp_doj));
                $anual_date = date('Y-m-d', strtotime($o . '-' . $dojg . '  + 1 year'));
                $data['result'] .= 
                '<tr>
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
            return view($this->_routePrefix . '.change-list',$data);
            //return view('dashboard/change-list', $data);
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
            //dd($data);
            return view($this->_routePrefix . '.contract-list',$data);
            //return view('dashboard/contract-list', $data);
        } else {
            return redirect('/');
        }
    }


} //End Class 
