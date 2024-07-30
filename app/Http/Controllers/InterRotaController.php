<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use view;

class InterRotaController extends Controller
{
    public function viewdash()
    {try {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            return View('interroata/dashboard', $data);
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }
    public function viewscheduleRights()
    {try {

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['roleshh'] = DB::table('role_authorization_admin_time')

                ->get();

            return View('interroata/view-schedule', $data);
        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

    public function viewoffday()
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['employee_type_rs'] = DB::table('offday_emp')->where('employee_id', '=', $member)->get();
                return View('interroata/offday-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewroster()
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {$member = Session::get('admin_userpp_member');

                $data['employee_type_rs'] = DB::table('duty_roster_emp')
                    ->where('employee_id', '=', $member)
                    ->where('start_date', '>=', date('Y-m-01'))
                    ->where('end_date', '<=', date('Y-m-31'))
                    ->get();

                return View('interroata/roster-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function dutyrostimerAccess($res_id)
    {
        try {

            $data['departs'] = DB::table('duty_roster_emp')->where('id', '>=', base64_decode($res_id))->first();

            return view('admin/roster-record', $data);
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function viewwork()
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');
                $data['employee_type_rs'] = DB::table('rota_inst')->where('employee_id', '=', $member)->orderBy('date', 'DESC')->get();
                return View('interroata/work-list', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddworky()
    {
        try {

            $email = Session::get('emp_email');
            if (!empty($email)) {
                $member = Session::get('admin_userpp_member');

                $data['user'] = DB::Table('role_authorization_admin_organ')

                    ->where('member_id', '=', $member)
                    ->get();

                if (Input::get('id')) {

                    $bankid = base64_decode(Input::get('id'));
                    $data['rotadetails'] = DB::table('rota_inst')->where('id', $bankid)->get()->toArray();

                    return View('interroata/work-add', $data);
                } else {

                    return View('interroata/work-add', $data);
                }

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveAddworky(Request $request)
    {try {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();

            $member = Session::get('admin_userpp_member');

            if ($request->rotid) {
                $tot = $request->w_min + ($request->w_hours * 60);

                $datagg = array(
                    'employee_id' => $member,
                    'emid' => $request->emid,
                    'type' => $request->type,
                    'w_hours' => $request->w_hours,
                    'w_min' => $request->w_min,
                    'in_time' => date('h:i A', strtotime($request->in_time)),
                    'out_time' => date('h:i A', strtotime($request->out_time)),
                    'min_tol' => $tot,
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'remarks' => $request->remarks,
                    'rect_deatils' => $request->rect_deatils,
                    'cr_date' => date('Y-m-d'),

                );

                DB::table('rota_inst')->where('id', $request->rotid)->update($datagg);
                Session::flash('message', ' Daily Work Update Updated Successfully .');

                return redirect('interroata/work-update');

            } else {
                $tot = $request->w_min + ($request->w_hours * 60);

                $datagg = array(
                    'employee_id' => $member,
                    'emid' => $request->emid,
                    'type' => $request->type,
                    'w_hours' => $request->w_hours,
                    'w_min' => $request->w_min,
                    'in_time' => date('h:i A', strtotime($request->in_time)),
                    'out_time' => date('h:i A', strtotime($request->out_time)),
                    'min_tol' => $tot,
                    'date' => date('Y-m-d', strtotime($request->date)),
                    'remarks' => $request->remarks,
                    'rect_deatils' => $request->rect_deatils,
                    'cr_date' => date('Y-m-d'),

                );
                DB::table('rota_inst')->insert($datagg);

                Session::flash('message', ' Daily Work Update Added Successfully .');

                return redirect('interroata/work-update');

            }

        } else {
            return redirect('/');
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
    }

}