<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Helper
{
    public static function getSidebarItems()
    {
        $email = Session::get("emp_email");
        $user_type = Session::get("user_type");
        $sidebarItems = [];

        if ($user_type == "employer") {
            $Roledata = DB::table("registration")
                ->where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            if ($Roledata) {
                $Roles_auth = DB::table("othorized_organization_module")
                    ->where("employee_id", "=", $Roledata->reg)
                    ->get();

                foreach ($Roles_auth as $role) {
                    $sidebarItems[] = [
                        'module_name' => $role->module_name
                        //'module_display_name' => $role->module_display_name // Assuming you have a display name
                    ];
                }
            }
        } else {
            $users_id = Session::get("users_id");
            $dtaem = DB::table("users")
                ->where("id", "=", $users_id)
                ->first();

            if ($dtaem) {
                $Roles_auth = DB::table("role_authorization")
                    ->where("emid", "=", $dtaem->emid)
                    ->where("member_id", "=", $dtaem->email)
                    ->get();

                foreach ($Roles_auth as $role) {
                    $sidebarItems[] = [
                        'module_name' => $role->module_name
                       // 'module_display_name' => $role->module_display_name // Assuming you have a display name
                    ];
                }
            }
        }
        //dd($sidebarItems);
        return $sidebarItems;
    }
}




?>