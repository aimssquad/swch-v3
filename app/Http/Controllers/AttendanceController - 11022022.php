<?php

namespace App\Http\Controllers;

use App\Exports\ExcelFileExportAttandance;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Session;
use view;

class AttendanceController extends Controller
{
    public function viewdash()
    {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            return View('attendance/dashboard', $data);
        } else {
            return redirect('/');
        }
    }

    public function viewattendancedaily()
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

            return view('attendance/daily-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewattendancereport()
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

            return view('attendance/report-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function getReportAttandance(Request $request)
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
            $department = $request->department;
            $designation = $request->designation;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $employee_desigrs = DB::table('designation')
                ->where('id', '=', $designation)
                ->where('emid', '=', $Roledata->reg)
                ->first();
            $job_details = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->first();

            $employee_depers = DB::table('department')
                ->where('id', '=', $department)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            if (date('m', strtotime($end_date)) != date('m', strtotime($start_date))) {
                Session::flash('message', 'Month are not same');
                return redirect('attendance/attendance-report');
            } else {
                if ($job_details->emp_doj != '1970-01-01') {
                    if ($job_details->emp_doj != '') {
                        $join_date = $job_details->emp_doj;
                    }
                } else {
                    $join_date = '';
                }
                // dd($join_date);
                $data['result'] = '';
                $total_wk_days = 0;
                $date1_ts = strtotime($start_date);
                $date2_ts = strtotime($end_date);
                $diff = $date2_ts - $date1_ts;

                $total_wk_days = (round($diff / 86400) + 1);

                $holidays = DB::table('holiday')->where('from_date', '>=', $start_date)
                    ->where('to_date', '<=', $end_date)
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

                $new_off = 0;
                $fh = 1;

                if (date('d', strtotime($start_date)) > $total_wk_days) {
                    $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                    //echo 'con1<br>';
                } else if (date('d', strtotime($start_date)) != 1) {
                    $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                    //echo 'con2<br>';
                } else {
                    $total_wk_days = $total_wk_days;
                    //echo 'con3<br>';
                }

                if (date('d', strtotime($start_date)) == date('d', strtotime($end_date))) {
                    $total_wk_days = date('d', strtotime($start_date));
                }

                //dd(date('d', strtotime($start_date)));

                for ($we = date('d', strtotime($start_date)); $we <= $total_wk_days; $we++) {
                    if ($we < 10 && $we != '01') {
                        $we = '0' . $we;
                    } else if ($we == '01') {
                        $we = $we;
                    } else {
                        $we = $we;
                    }
                    $new_f = date('Y-m', strtotime($start_date)) . '-' . $we;

                    $duty_auth = DB::table('duty_roster')
                        ->where('employee_id', '=', $employee_code)
                        ->where('emid', '=', $Roledata->reg)

                        ->whereDate('start_date', '<=', $new_f)
                        ->whereDate('end_date', '>=', $new_f)
                        ->orderBy('id', 'ASC')
                        ->first();
                    //dd($duty_auth);
                    //echo $new_f . '<br>';
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
                        //dd($offg);
                    }
                    //dd($join_date . '--' . $new_f);
                    if ($join_date <= $new_f) {

                        if (!empty($duty_auth)) {

                            $employee_attendence =
                            DB::table('employee')

                                ->where('emp_code', '=', $employee_code)
                                ->where('emid', '=', $Roledata->reg)

                                ->first();

                            $laeveppnre = DB::table('leave_apply')
                                ->where('employee_id', '=', $employee_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $new_f)
                                ->where('to_date', '>=', $new_f)
                                ->where('status', '=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            $laeveppnrejj = DB::table('leave_apply')

                                ->where('employee_id', '=', $employee_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $new_f)
                                ->where('to_date', '>=', $new_f)
                                ->where('status', '!=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            $add = '';

                            // dd($laeveppnrejj);
                            if ($off_day >= 0) {
                                if (!empty($laeveppnre) || !empty($laeveppnrejj)) {
                                    if (!empty($laeveppnre)) {
                                        $leave_typenewmm = $laeveppnre->leave_type;
                                    }
                                    if (!empty($laeveppnrejj)) {
                                        $leave_typenewmm = $laeveppnrejj->leave_type;
                                    }
                                    $leave_tyepenew = DB::table('leave_type')->where('id', '=', $leave_typenewmm)->first();

                                    if ($leave_tyepenew->alies == 'H' && in_array(date('l', strtotime($new_f)), $offg)) {
                                        $add = 'yes';

                                    } else {
                                        $add = 'no';
                                    }

                                } else {
                                    $add = 'no';
                                }
                                //dd($add);
                                if ((!empty($laeveppnre) || !empty($laeveppnrejj)) && $join_date != $new_f && $add == 'no') {

                                    if (!empty($laeveppnre)) {
                                        $laeveppnrnamee = DB::table('leave_type')
                                            ->where('id', '=', $laeveppnre->leave_type)
                                            ->first();

                                        if ($laeveppnrnamee->leave_type_name == 'Holiday') {
                                            $lc = 'Annual Leave';
                                        } else {
                                            $lc = $laeveppnrnamee->leave_type_name;
                                        }
                                    }

                                    if (!empty($laeveppnrejj) && $join_date != $new_f) {
                                        $laeveppnrnamee = DB::table('leave_type')

                                            ->where('id', '=', $laeveppnrejj->leave_type)

                                            ->first();
                                        $lc = 'Unauthorized Absent';
                                    }

                                    $data['result'] .= '<tr>


				                                    <td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>' . $lc . '</td>
														<td></td>
														<td></td>
													<td></td>
													<td></td>

						                            </tr>';

                                    $fh++;
                                } else {
                                    //dd(in_array(date('l', strtotime($new_f)), $offg));
                                    if (in_array(date('l', strtotime($new_f)), $offg)) {
                                        // dd('in false');
                                        if (in_array($new_f, $offgholi)) {
                                            $data['result'] .= '<tr>


				                                    <td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>Public Holiday</td>
														<td></td>
														<td></td>
													<td></td>
													<td></td>

						                            </tr>';

                                            $fh++;

                                        } else if ($join_date == $new_f) {

                                            $month_entrynew = DB::table('attandence')->where('month', '=', date('m/Y', strtotime($start_date)))->where('date', '=', $new_f)->where('employee_code', '=', $job_details->emp_code)->where('emid', '=', $data['Roledata']->reg)->get();

                                            if (count($month_entrynew) != 0) {
                                                foreach ($month_entrynew as $month_entry) {

                                                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                                                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                                                    $difference = abs($dateout - $datein) / 60;
                                                    $hours = floor($difference / 60);
                                                    $minutes = ($difference % 60);
                                                    $duty_hours = $hours . ":" . $minutes;
                                                    $time_in = '';
                                                    if ($month_entry->time_in != '') {

                                                        $time_in = date('h:i a', strtotime($month_entry->time_in));
                                                    }
                                                    $time_out = '';
                                                    if ($month_entry->time_out != '') {

                                                        $time_out = date('h:i a', strtotime($month_entry->time_out));
                                                    }
                                                    $data['result'] .= '<tr>


				                                    <td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $month_entry->employee_code . '</td>
													<td>' . $job_details->emp_fname . ' ' . $job_details->emp_mname . ' ' . $job_details->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($month_entry->date)) . '</td>
														<td>' . $time_in . '</td>
													<td>' . $month_entry->time_in_location . '</td>
														<td>' . $time_out . '</td>
													<td>' . $month_entry->time_out_location . '</td>
													<td>' . $month_entry->duty_hours . '</td>

						                                </tr>';

                                                    $fh++;
                                                }
                                            }

                                        } else {
                                            //dd($employee_attendence);
                                            $data['result'] .= '<tr>


				                                <td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>Offday</td>
													<td></td>
														<td></td>
													<td></td>
													<td></td>

						                            </tr>';

                                            $fh++;
                                        }

                                    } else {
                                        //dd('chk true');
                                        if (in_array($new_f, $offgholi)) {

                                            $data['result'] .= '<tr>


				                                    <td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
														<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>

													<td>Public Holiday</td>
														<td></td>
														<td></td>
													<td></td>
													<td></td>

						                            </tr>';

                                            $fh++;
                                        } else {

                                            $month_entrynew = DB::table('attandence')->where('month', '=', date('m/Y', strtotime($start_date)))->where('date', '=', $new_f)->where('employee_code', '=', $job_details->emp_code)->where('emid', '=', $data['Roledata']->reg)->get();
                                            //dd($month_entrynew);
                                            if (count($month_entrynew) != 0) {
                                                foreach ($month_entrynew as $month_entry) {

                                                    $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                                                    $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                                                    $difference = abs($dateout - $datein) / 60;
                                                    $hours = floor($difference / 60);
                                                    $minutes = ($difference % 60);
                                                    $duty_hours = $hours . ":" . $minutes;
                                                    $time_in = '';
                                                    if ($month_entry->time_in != '') {

                                                        $time_in = date('h:i a', strtotime($month_entry->time_in));
                                                    }
                                                    $time_out = '';
                                                    if ($month_entry->time_out != '') {

                                                        $time_out = date('h:i a', strtotime($month_entry->time_out));
                                                    }
                                                    $data['result'] .= '<tr>


				                                        <td>' . $fh . '</td>

													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $month_entry->employee_code . '</td>
													<td>' . $job_details->emp_fname . ' ' . $job_details->emp_mname . ' ' . $job_details->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($month_entry->date)) . '</td>
														<td>' . $time_in . '</td>
													<td>' . $month_entry->time_in_location . '</td>
														<td>' . $time_out . '</td>
													<td>' . $month_entry->time_out_location . '</td>
													<td>' . $month_entry->duty_hours . '</td>

						                            </tr>';

                                                    $fh++;
                                                }
                                            }

                                        }
                                    }
                                }
                            }

                        }

                    }
                }

            }
            //dd($data['result']);
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

            $data['employee_code'] = $request->employee_code;
            $data['department'] = $request->department;
            $data['designation'] = $request->designation;
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));

            return view('attendance/report-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function getDailyAttandance(Request $request)
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
            $date = date('Y-m-d', strtotime($request->date));

            $data['result'] = '';if ($employee_code != '') {

                $leave_allocation_rs = DB::table('attandence')
                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')
                    ->where('attandence.employee_code', '=', $employee_code)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->where('attandence.date', '=', $date)
                    ->select('attandence.*')
                    ->get();
            } else {
                $leave_allocation_rs = DB::table('attandence')

                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')

                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->where('attandence.date', '=', $date)
                    ->select('attandence.*')
                    ->get();
            }
            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {$f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
													<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $leave_allocation->employee_code . '</td>
													<td>' . $leave_allocation->employee_name . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
													<td>' . date('h:i a', strtotime($leave_allocation->time_in)) . '</td>
													<td>' . $leave_allocation->time_in_location . '</td>
														<td>' . date('h:i a', strtotime($leave_allocation->time_out)) . '</td>
													<td>' . $leave_allocation->time_out_location . '</td>
													<td>' . $leave_allocation->duty_hours . '</td>
													<td><a href="edit-daily/' . base64_encode($leave_allocation->id) . '"><img  style="width: 30px;" src="' . env("BASE_URL") . 'public/assets/img/edit.png"></a></td>


						</tr>';
                    $f++;}
            }
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

            return view('attendance/daily-list', $data);
        } else {
            return redirect('/');
        }
    }

    public function getReportAttandancedetails($repot_id)
    {

        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['job'] = DB::table('attandence')->where('id', '=', base64_decode($repot_id))->first();

            $data['job_details'] = DB::table('employee')->where('emp_code', '=', $data['job']->employee_code)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            return View('attendance/repot-edit', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveReportAttandancedetails(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $datein = strtotime(date("Y-m-d " . $request->time_in));
            $dateout = strtotime(date("Y-m-d " . $request->time_out));
            $difference = abs($dateout - $datein) / 60;
            $hours = floor($difference / 60);
            $minutes = ($difference % 60);
            $duty_hours = $hours . ":" . $minutes;

            $dataupdate = array(

                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'duty_hours' => $duty_hours,
            );
            DB::table('attandence')->where('id', '=', $request->id)->update($dataupdate);

            Session::flash('message', 'Attendance Information Successfully Updated.');

            return redirect('attendance/attendance-report');
        } else {
            return redirect('/');
        }
    }

    public function getDailyAttandancedetails($daily_id)
    {
        if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['job'] = DB::table('attandence')->where('id', '=', base64_decode($daily_id))->first();

            $data['job_details'] = DB::table('employee')->where('emp_code', '=', $data['job']->employee_code)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            return View('attendance/daily-edit', $data);
        } else {
            return redirect('/');
        }

    }

    public function saveDailyAttandancedetails(Request $request)
    {

        if (!empty(Session::get('emp_email'))) {

            $datein = strtotime(date("Y-m-d " . $request->time_in));
            $dateout = strtotime(date("Y-m-d " . $request->time_out));
            $difference = abs($dateout - $datein) / 60;
            $hours = floor($difference / 60);
            $minutes = ($difference % 60);
            $duty_hours = $hours . ":" . $minutes;

            $dataupdate = array(

                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'duty_hours' => $duty_hours,
            );
            DB::table('attandence')->where('id', '=', $request->id)->update($dataupdate);

            Session::flash('message', 'Attendance Information Successfully Updated.');

            return redirect('attendance/daily-attendance');
        } else {
            return redirect('/');
        }

    }

    public function viewattendanceprocess()
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

            return view('attendance/process-list', $data);
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

            return view('attendance/absent-list', $data);
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

            return view('attendance/absent-record', $data);
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
                            $offg = array();
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

            return view('attendance/absent-list', $data);

        } else {
            return redirect('/');
        }

    }

    public function getProcessAttandance(Request $request)
    {if (!empty(Session::get('emp_email'))) {

        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();
        $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $filename =
        $data['result'] = '';
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

        $end_date = date('Y-m-d', strtotime($request->end_date));
        $start_date = date('Y-m-d', strtotime($request->start_date));

        if (date('m', strtotime($end_date)) != date('m', strtotime($start_date))) {
            Session::flash('message', 'Month are not same');
            return redirect('attendance/process-attendance');
        }
        $holidays = DB::table('holiday')->where('from_date', '>=', $request->start_date)
            ->where('to_date', '<=', $end_date)
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
        $date1_ts = strtotime($start_date);
        $date2_ts = strtotime($end_date);
        $diff = $date2_ts - $date1_ts;

        $total_wk_days = (round($diff / 86400) + 1);

        $emp_v = $request->employee_code;
        if ($emp_v != '') {
            $employee_rs = DB::Table('employee')
                ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                ->whereBetween('attandence.date', [$start_date, $end_date])
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('attandence.emid', '=', $Roledata->reg)
                ->where('employee.emp_code', '=', $emp_v)
                ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                ->where('employee.emp_department', '=', $employee_depers->department_name)
                ->select('employee.*')
                ->distinct()
                ->get();

        } else {

            $employee_rs = DB::Table('employee')
                ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                ->whereBetween('attandence.date', [$start_date, $end_date])
                ->where('employee.emid', '=', $Roledata->reg)
                ->where('attandence.emid', '=', $Roledata->reg)
                ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                ->where('employee.emp_department', '=', $employee_depers->department_name)
                ->select('employee.*')
                ->distinct()
                ->get();
        }

        //print_r($employee_rs);
        $increment = 0;

        $at = 1;
        foreach ($employee_rs as $emp) {
            $tour_leave_count = 0;
            $number_of_days_leave = 0;
            $leave_apply_rs = DB::select(DB::raw("SELECT SUM(no_of_leave) as number_of_days ,SUM(status),(to_date) as to_date , from_date as from_date FROM `leave_apply` WHERE employee_id='$emp->emp_code' and emid='$Roledata->reg'
        AND status='APPROVED' AND (to_date  between '$start_date' and '$end_date' OR from_date  between '$start_date' and '$end_date')"));

            //dd(count($tour_leave));
            if ($leave_apply_rs[0]->number_of_days != null) {
                for ($wehgg = date('d', strtotime($start_date)); $wehgg <= date('d', strtotime($end_date)); $wehgg++) {
                    if ($wehgg < 10 && $wehgg != '01') {
                        $wehgg = '0' . $wehgg;
                    } else if ($wehgg == '01') {
                        $wehgg = $wehgg;
                    } else {
                        $wehgg = $wehgg;
                    }
                    if ($leave_apply_rs[0]->from_date <= date('Y-m', strtotime($start_date)) . '-' . $wehgg && $leave_apply_rs[0]->to_date >= date('Y-m', strtotime($start_date)) . '-' . $wehgg) {
                        $number_of_days_leave = $number_of_days_leave + 1;
                    }

                }
            }
            if ($number_of_days_leave == null) {
                $number_of_days_leave = 0;
            }

            $no_of_present = 0;
            $mon_y = date('m/Y', strtotime($start_date));

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
                ->where('end_date', '>=', $start_date)

                ->orderBy('id', 'DESC')
                ->first();

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

                for ($we = date('d', strtotime($start_date)); $we <= $total_wk_days; $we++) {

                    if ($we < 10 && $we != '01') {
                        $we = '0' . $we;
                    } else if ($we == '01') {
                        $we = $we;
                    } else {
                        $we = $we;
                    }

                    $new_f = date('Y-m', strtotime($start_date)) . '-' . $we;
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

            $no_of_days_salary = $no_of_present + $number_of_days_leave + $off_day + $totday;

            if (!empty($no_of_present)) {
                $data['result'] .= '<tr>

								<input type="hidden" class="form-control" readonly="" name="start_date" value="' . $start_date . '">
								<input type="hidden" class="form-control" readonly="" name="department" value="' . $department . '">
									<input type="hidden" class="form-control" readonly="" name="designation" value="' . $designation . '">
								<input type="hidden" class="form-control" readonly="" name="end_date" value="' . $end_date . '">
								<input type="hidden" class="form-control" readonly="" name="no_of_working_days' . $at . '" value="' . $total_wk_days . '">

                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_absent' . $at . '" value="' . $absent_days . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_days_leave_taken' . $at . '" value="' . $number_of_days_leave . '">
                                                                <input type="hidden" class="form-control" readonly="" name="no_of_present' . $at . '" value="' . $no_of_present . '">
                                                                <input type="hidden" class="form-control" readonly="" name="total_sal' . $at . '" value="' . $totsal . '">
								<td><div class="checkbox"><label><input type="checkbox" name="employee_code[]" value="' . $emp->emp_code . '"></label></div>' . $at . '</td>
							<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
								<td>' . $emp->emp_code . '</td>
								<td>' . $emp->emp_fname . ' ' . $emp->emp_mname . ' ' . $emp->emp_lname . '</td>
								<td>' . $total_wk_days . '</td>

								<td>' . $no_of_present . '</td>



								<td>' . $number_of_days_leave . '</td>

								<td>' . $totsal . '</td>
							</tr>';
                $increment++;
                $at++;
            }
        }

        $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();

        $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

        return view('attendance/process-list', $data);
    } else {
        return redirect('/');
    }
    }

    public function saveProcessAttandance(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            //print_r($request->all()); exit;
            $i = 0;
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $enteremployee = array();
            $checkattendence = DB::table('process_attendance')->where('month_yr', '=', date('m/Y', strtotime($request->end_date)))->where('emid', '=', $Roledata->reg)->get();
            foreach ($checkattendence as $chckatt) {
                $enteremployee[] = $chckatt->employee_code;
            }
            $allocation_list = $request->all();

            if (!empty($request->employee_code)) {
                $pr = 1;
                foreach ($request->employee_code as $checked) {
                    $dataval['month_yr'] = date('m/Y', strtotime($request->end_date));
                    $dataval['employee_code'] = $request->employee_code[$i];
                    $dataval['no_of_working_days'] = $allocation_list['no_of_working_days' . $pr];

                    $dataval['no_of_days_leave_taken'] = $allocation_list['no_of_days_leave_taken' . $pr];
                    $dataval['no_of_present'] = $allocation_list['no_of_present' . $pr];
                    $dataval['no_of_days_absent'] = $allocation_list['no_of_days_absent' . $pr];
                    $dataval['no_of_days_salary'] = $allocation_list['total_sal' . $pr];
                    $dataval['emid'] = $Roledata->reg;
                    $dataval['created_at'] = date('Y-m-d');
                    $dataval['updated_at'] = date('Y-m-d');

                    if (in_array($request->employee_code[$i], $enteremployee)) {
                        Session::flash('message', 'Already Attendance Processed for the dates of ' . date('d/m/Y', strtotime($request->start_date)) . ' and ' . date('d/m/Y', strtotime($request->end_date)) . ' .');
                        return redirect('attendance/process-attendance');
                    } else {
                        if (($dataval['no_of_working_days'] < $dataval['no_of_days_salary']) || ($dataval['no_of_present'] < 0) || ($dataval['no_of_days_absent'] < 0)) {
                            Session::flash('message', 'There was a problem in your  attendance.');
                            return redirect('attendance/process-attendance');

                        } else {
                            DB::table('process_attendance')->insert($dataval);
                        }

                    }

                    $i++;
                    $pr++;}
                Session::flash('message', 'Attendance Process Information Successfully Saved.');
                return redirect('attendance/process-attendance');

            } else {
                Session::flash('message', 'Please select before process!!.');
                return redirect('attendance/process-attendance');
            }
        } else {
            return redirect('/');
        }
    }

    public function viewUploadAttendence()
    {

        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            return view('attendance/upload-data', $data);
        } else {
            return redirect('/');
        }
    }
    public function importExcel(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $file = $request->file('upload_csv');
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            // File Details

            // Valid File Extensions
            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152;
            // Check file extension
            if (in_array(strtolower($extension), $valid_extension)) {

                // Check file size
                if ($fileSize <= $maxFileSize) {

                    $path = $request->upload_csv->store('upcsv', 'public');
                    // Reading file
                    $pat = 'public/' . $path;
                    $file = fopen($pat, "r");

                    $importData_arr = array();
                    $i = 0;

                    while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                        $num = count($filedata);
                        //dd($filedata[3]);
                        // Skip first row (Remove below comment if you want to skip the first row)
                        /*if($i == 0){
                        $i++;
                        continue;
                        }*/
                        for ($c = 0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata[$c];
                        }
                        $i++;
                    }
                    fclose($file);
                    // dd($importData_arr);
                    foreach ($importData_arr as $importData) {
                        $month_entry = DB::table('attandence')->where('month', '=', $importData[5])->where('date', '=', date('Y-m-d', strtotime($importData[2])))->where('employee_code', '=', $importData[0])->where('emid', '=', $data['Roledata']->reg)->first();

                        //dd($month_entry);

                        if (!empty($month_entry)) {
                            Session::flash('message', 'Already process is completed for these Date');
                            return redirect('attendance/upload-data');
                        }
                    }
                    // Insert to MySQL database
                    foreach ($importData_arr as $importData) {
                        //dd($importData[5]);
                        $insertData = array();
                        $datein = '';
                        $dateout = '';
                        $difference = '';
                        $minutes = '';
                        $hours = '';
                        $duty_hours = '';
                        $time_in = '';
                        $time_out = '';
/*
$datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
$dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
$difference = abs($dateout - $datein) / 60;
$hours = floor($difference / 60);
$minutes = ($difference % 60);
$duty_hours = $hours . ":" . $minutes;
 */
                        $time_in = date('h:i', strtotime($importData[3]));
                        $time_out = date('h:i', strtotime($importData[4]));

                        $datein = strtotime(date("Y-m-d " . $importData[3]));
                        // $datein = strtotime(date("Y-m-d " . $time_in));
                        // $dateout = strtotime(date("Y-m-d " . $time_out));
                        $dateout = strtotime(date("Y-m-d " . $importData[4]));
                        $difference = abs($dateout - $datein) / 60;
                        $hours = floor($difference / 60);
                        $minutes = ($difference % 60);
                        $duty_hours = $hours . ":" . $minutes;

                        $insertData = array(
                            "employee_code" => $importData[0],
                            "employee_name" => $importData[1],
                            "date" => date('Y-m-d', strtotime($importData[2])),
                            "time_in" => date('H:i', strtotime($importData[3])),
                            "time_out" => date('H:i', strtotime($importData[4])),
                            "month" => $importData[5],
                            "time_in_location" => $importData[6],
                            "time_out_location" => $importData[7],
                            "duty_hours" => $duty_hours,
                            "emid" => $data['Roledata']->reg,
                        );

                        // dd($insertData);

                        DB::table('attandence')->insert($insertData);

                    }

                    Session::flash('message', 'Attendance Uploaded Successfully.');

                    return redirect('attendance/upload-data');
                } else {
                    Session::flash('message', 'File too large. File must be less than 2MB.');
                    return redirect('attendance/upload-data');
                }

            } else {
                Session::flash('message', 'Invalid File Extension.');
                return redirect('attendance/upload-data');
            }

        } else {
            return redirect('/');
        }
    }

    public function importdtaa(Request $request)
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
            $department = $request->department;
            $designation = $request->designation;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $employee_desigrs = DB::table('designation')
                ->where('id', '=', $designation)
                ->where('emid', '=', $Roledata->reg)
                ->first();
            $employee_depers = DB::table('department')
                ->where('id', '=', $department)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            if ($employee_code != '') {
                $leave_allocation_rs = DB::table('attandence')
                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')
                    ->where('attandence.employee_code', '=', $employee_code)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->select('attandence.*')
                    ->get();

            } else {

            }

            if ($employee_code != '') {

                $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo,
                    'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country,
                    'emid' => $Roledata->reg, 'leave_allocation_rs' => $leave_allocation_rs, 'designation_name' => $employee_desigrs->designation_name,
                    'department_name' => $employee_depers->department_name, 'start_date' => $start_date, 'end_date' => $end_date, 'employee_code' => $employee_code];

                $pdf = PDF::loadView('mypdfattdance', $datap);
                return $pdf->download('attendancereport.pdf');

            } else {

                $holidays = DB::table('holiday')->where('from_date', '>=', $request->start_date)
                    ->where('to_date', '<=', $end_date)
                    ->where('emid', '=', $Roledata->reg)
                    ->get();

                $employee_rs = DB::Table('employee')
                    ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->select('employee.*')
                    ->distinct()
                    ->get();
                $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country, 'emid' => $Roledata->reg, 'holidays' => $holidays, 'designation_name' => $employee_desigrs->designation_name, 'department_name' => $employee_depers->department_name, 'start_date' => $start_date, 'end_date' => $end_date, 'employee_rs' => $employee_rs];

                $pdf = PDF::loadView('mypdfattdancetot', $datap);
                return $pdf->download('attendancereport.pdf');

            }

            $data['result'] = '';if ($employee_code != '') {

                $leave_allocation_rs = DB::table('attandence')
                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')
                    ->where('attandence.employee_code', '=', $employee_code)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->select('attandence.*')
                    ->get();
            } else {
                $leave_allocation_rs = DB::table('attandence')

                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')

                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->select('attandence.*')
                    ->get();
            }

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {$f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
												<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $leave_allocation->employee_code . '</td>
													<td>' . $leave_allocation->employee_name . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
													<td>' . date('h:i a', strtotime($leave_allocation->time_in)) . '</td>
													<td>' . $leave_allocation->time_in_location . '</td>
														<td>' . date('h:i a', strtotime($leave_allocation->time_out)) . '</td>
													<td>' . $leave_allocation->time_out_location . '</td>
													<td>' . $leave_allocation->duty_hours . '</td>


						</tr>';
                    $f++;}
            }
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

            $data['employee_code'] = $request->employee_code;
            $data['department'] = $request->department;
            $data['designation'] = $request->designation;
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));

            return view('attendance/report-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function importdtaaexcel(Request $request)
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
            $department = $request->department;
            $designation = $request->designation;
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $employee_desigrs = DB::table('designation')
                ->where('id', '=', $designation)
                ->where('emid', '=', $Roledata->reg)
                ->first();
            $employee_depers = DB::table('department')
                ->where('id', '=', $department)
                ->where('emid', '=', $Roledata->reg)
                ->first();

            if ($employee_code != '') {
                $leave_allocation_rs = DB::table('attandence')
                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')
                    ->where('attandence.employee_code', '=', $employee_code)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->select('attandence.*')
                    ->get();

            } else {

                $employee_rs = DB::Table('employee')
                    ->join('attandence', 'employee.emp_code', '=', 'attandence.employee_code')
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->where('employee.emid', '=', $Roledata->reg)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->select('employee.*')
                    ->distinct()
                    ->get();

            }
            if ($employee_code != '') {
                $new_emp = $employee_code;
            } else {
                $new_emp = 'all';
            }
            return Excel::download(new ExcelFileExportAttandance($start_date, $end_date, $employee_depers->department_name, $employee_desigrs->designation_name, $new_emp, $Roledata->reg), 'attendance.xlsx');

            $data['result'] = '';if ($employee_code != '') {

                $leave_allocation_rs = DB::table('attandence')
                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')
                    ->where('attandence.employee_code', '=', $employee_code)
                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->select('attandence.*')
                    ->get();
            } else {
                $leave_allocation_rs = DB::table('attandence')

                    ->join('employee', 'attandence.employee_code', '=', 'employee.emp_code')

                    ->where('attandence.emid', '=', $Roledata->reg)
                    ->where('employee.emp_designation', '=', $employee_desigrs->designation_name)
                    ->where('employee.emp_department', '=', $employee_depers->department_name)
                    ->whereBetween('attandence.date', [$start_date, $end_date])
                    ->select('attandence.*')
                    ->get();
            }

            //dd($leave_allocation_rs);
            if ($leave_allocation_rs) {$f = 1;
                foreach ($leave_allocation_rs as $leave_allocation) {
                    $data['result'] .= '<tr>
				<td>' . $f . '</td>
												<td>' . $employee_depers->department_name . '</td>
														<td>' . $employee_desigrs->designation_name . '</td>
													<td>' . $leave_allocation->employee_code . '</td>
													<td>' . $leave_allocation->employee_name . '</td>
													<td>' . date('d/m/Y', strtotime($leave_allocation->date)) . '</td>
													<td>' . date('h:i a', strtotime($leave_allocation->time_in)) . '</td>
													<td>' . $leave_allocation->time_in_location . '</td>
														<td>' . date('h:i a', strtotime($leave_allocation->time_out)) . '</td>
													<td>' . $leave_allocation->time_out_location . '</td>
													<td>' . $leave_allocation->duty_hours . '</td>


						</tr>';
                    $f++;}
            }
            $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
            $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();

            $data['employee_code'] = $request->employee_code;
            $data['department'] = $request->department;
            $data['designation'] = $request->designation;
            $data['start_date'] = date('Y-m-d', strtotime($request->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($request->end_date));

            return view('attendance/report-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function viewGenerateAttendence()
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

            return view('attendance/genarate-list', $data);
        } else {
            return redirect('/');
        }

    }

    public function importGenerate(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['result'] = '';

            $employee_code = $request->employee_code;
            $end_date = date('Y-m-d', strtotime($request->end_date));
            $start_date = date('Y-m-d', strtotime($request->start_date));

            if (date('m', strtotime($end_date)) != date('m', strtotime($start_date))) {
                Session::flash('message', 'Month are not same');
                return redirect('attendance/generate-data');
            } else {

                $emp_details = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $Roledata->reg)->orderBy('id', 'DESC')->first();
                $join_date = $emp_details->emp_doj;
                $total_wk_days = 0;
                $date1_ts = strtotime($start_date);
                $date2_ts = strtotime($end_date);
                $diff = $date2_ts - $date1_ts;
                $gu = 0;

                $total_wk_days = (round($diff / 86400) + 1);
                $holidays = DB::table('holiday')->where('from_date', '>=', $start_date)
                    ->where('to_date', '<=', $end_date)
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

                $duty_auth = DB::table('duty_roster')

                    ->where('employee_id', '=', $employee_code)
                    ->where('emid', '=', $Roledata->reg)

                    ->where('shift_code', '=', $request->shift_code)

                    ->orderBy('id', 'ASC')
                    ->first();

                $offg = array();

                if (!empty($duty_auth)) {

                    $shift_auth = DB::table('shift_management')

                        ->where('id', '=', $request->shift_code)

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
                    $fh = 1;

                    if (date('d', strtotime($start_date)) > $total_wk_days) {
                        $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                    } else if (date('d', strtotime($start_date)) != 1) {
                        $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                    } else {
                        $total_wk_days = $total_wk_days;
                    }
                    if (date('d', strtotime($start_date)) == date('d', strtotime($end_date))) {
                        $total_wk_days = date('d', strtotime($start_date));
                    }

                    for ($we = date('d', strtotime($start_date)); $we <= $total_wk_days; $we++) {

                        if (!empty($duty_auth)) {

                            //    if($we<10 && $we!='01'){
                            //        $we='0'.$we;
                            //  }else if($we=='01'){
                            // $we=$we;
                            //  }else{
                            //$we=$we;
                            //  }

                            $new_f = date('Y-m', strtotime($start_date)) . '-' . $we;

                            $laeveppnre = DB::table('leave_apply')

                                ->where('employee_id', '=', $employee_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $new_f)
                                ->where('to_date', '>=', $new_f)
                                ->where('status', '=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();
                            $laeveppnrejj = DB::table('leave_apply')

                                ->where('employee_id', '=', $employee_code)
                                ->where('emid', '=', $Roledata->reg)
                                ->where('from_date', '<=', $new_f)
                                ->where('to_date', '>=', $new_f)
                                ->where('status', '!=', 'APPROVED')
                                ->orderBy('id', 'DESC')
                                ->first();

                            if ($off_day >= 0) {

                                if ((!empty($laeveppnre) || !empty($laeveppnrejj) && $join_date != $new_f)) {

                                    if (in_array(date('l', strtotime($new_f)), $offg) && $join_date != $new_f) {

                                        if (in_array($new_f, $offgholi) && $join_date != $new_f) {

                                        } else {

                                            $new_off = $new_off + 1;
                                        }

                                    }
                                } else {

                                    if (in_array($new_f, $offgholi) && $join_date != $new_f) {

                                    } else if (in_array(date('l', strtotime($new_f)), $offg) && $join_date != $new_f) {

                                    } else {

                                        $month_entry = DB::table('attandence')->where('month', '=', date('m/Y', strtotime($start_date)))
                                            ->where('time_in', '=', $shift_auth->time_in)
                                            ->where('date', '=', $new_f)
                                            ->where('employee_code', '=', $employee_code)->where('emid', '=', $data['Roledata']->reg)->first();

                                        if (empty($month_entry)) {

                                            $employee_attendence =
                                            DB::table('employee')

                                                ->where('emp_code', '=', $employee_code)
                                                ->where('emid', '=', $Roledata->reg)

                                                ->first();
                                            $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                                            $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                                            $difference = abs($dateout - $datein) / 60;
                                            $hours = floor($difference / 60);
                                            $minutes = ($difference % 60);
                                            $duty_hours = $hours . ":" . $minutes;
                                            $data['result'] .= '<tr>

								<input type="hidden" class="form-control" readonly="" name="employee_code" value="' . $employee_attendence->emp_code . '">
									<input type="hidden" class="form-control" readonly="" name="employee_name" value="' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '">
								<input type="hidden" class="form-control" readonly="" name="month[]" value="' . date('m/Y', strtotime($start_date)) . '">
								<input type="hidden" class="form-control" readonly="" name="date[]" value="' . $new_f . '">
								<input type="hidden" class="form-control" readonly="" name="time_in[]" value="' . $shift_auth->time_in . '">
								<input type="hidden" class="form-control" readonly="" name="time_out[]" value="' . $shift_auth->time_out . '">
								<input type="hidden" class="form-control" readonly="" name="time_in_location[]" value="NA">
								<input type="hidden" class="form-control" readonly="" name="time_out_location[]" value="NA">
								<input type="hidden" class="form-control" readonly="" name="duty_hours[]" value="' . $duty_hours . '">
				<td>' . $fh . '</td>

													<td>' . $employee_attendence->emp_code . '</td>
													<td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
													<td>' . date('d/m/Y', strtotime($new_f)) . '</td>
													<td>' . date('h:i a', strtotime($shift_auth->time_in)) . '</td>
													<td>NA</td>
														<td>' . date('h:i a', strtotime($shift_auth->time_out)) . '</td>
													<td>NA</td>
													<td>' . $duty_hours . '</td>


						</tr>';

                                            $fh++;
                                        } else if (!empty($month_entry)) {
                                            $gu++;
                                        }

                                    }
                                }

                            }

                        }

                    }

                }

                $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $Roledata->reg)->where('employee_type_status', '=', 'Active')->get();
                $data['departs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
                if ($gu > 0) {
                    Session::flash('message', 'Attendance Data already exits');
                }

                return view('attendance/genarate-list', $data);
            }

        } else {
            return redirect('/');
        }
    }

    public function saveGenerate(Request $request)
    {
        if (!empty(Session::get('emp_email'))) {

            //print_r($request->all()); exit;
            $i = 0;
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $enteremployee = array();

            $allocation_list = $request->all();
            $i = 0;
            $pr = 0;
            if (!empty($request->date)) {

                foreach ($request->date as $checked) {$dataval['employee_code'] = $request->employee_code;
                    $dataval['employee_name'] = $request->employee_name;

                    $dataval['month'] = $allocation_list['month'][$i];
                    $dataval['date'] = $allocation_list['date'][$i];
                    $dataval['time_in'] = $allocation_list['time_in'][$i];
                    $dataval['time_out'] = $allocation_list['time_out'][$i];
                    $dataval['time_out'] = $allocation_list['time_out'][$i];
                    $dataval['time_in_location'] = $allocation_list['time_in_location'][$i];
                    $dataval['time_out_location'] = $allocation_list['time_out_location'][$i];
                    $dataval['duty_hours'] = $allocation_list['duty_hours'][$i];

                    $dataval['emid'] = $Roledata->reg;

                    $month_entry = DB::table('attandence')
                        ->where('month', '=', $allocation_list['month'][$i])
                        ->where('date', '=', $allocation_list['date'][$i])->where('employee_code', '=', $request->employee_code)
                        ->where('time_in', '=', $allocation_list['time_in'][$i])
                        ->where('emid', '=', $data['Roledata']->reg)->first();

                    if (empty($month_entry)) {
                        $pr++;
                        DB::table('attandence')->insert($dataval);

                    }

                    $i++;
                }
                if ($pr > 0) {
                    Session::flash('message', 'Attendance  Information Successfully Saved.');
                    return redirect('attendance/generate-data');
                } else {
                    Session::flash('message', 'Already Attendance  for the Month ');
                    return redirect('attendance/generate-data');
                }

            } else {
                Session::flash('message', 'Please select before process!!.');
                return redirect('attendance/generate-data');
            }
        } else {
            return redirect('/');
        }
    }
}
