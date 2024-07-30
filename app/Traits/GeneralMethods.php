<?php

namespace App\Traits;

use DB;
use Session;
use Storage;
trait GeneralMethods
{
    public function hello_world()
    {
        return "hello world";
    }

    public function addAdminLog($module_id, $action_text)
    {

        $data = array(

            'module_id' => $module_id,
            'username' => Session::get('empsu_name'),
            'useremail' => Session::get('empsu_email'),
            'user_type' => Session::get('usersu_type'),
            'users_id' => Session::get('users_id'),
            'action_text' => $action_text,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),

        );

        DB::table('activity_logs')->insert($data);
        //echo 'udate';

    }

    public function getDutyRoaster($employee_code, $emid, $start_date, $end_date)
    {
        $duty_auth = DB::table('duty_roster')
            ->where('employee_id', '=', $employee_code)
            ->where('emid', '=', $emid)
            ->whereDate('start_date', '<=', $start_date)
            ->whereDate('end_date', '>=', $end_date)
            ->orderBy('id', 'ASC')
            ->first();

        return $duty_auth;
    }

    public function getShiftInfo($shift_code, $emid)
    {
        $shift_auth = DB::table('shift_management')
            ->where('id', '=', $shift_code)
            ->where('emid', '=', $emid)
            ->orderBy('id', 'DESC')
            ->first();

        return $shift_auth;
    }

    public function getOffDayInfoViaShiftCode($shift_code, $emid)
    {
        $off_auth = DB::table('offday')
            ->where('shift_code', '=', $shift_code)
            ->where('emid', '=', $emid)
            ->orderBy('id', 'DESC')
            ->first();

        return $off_auth;
    }

}
