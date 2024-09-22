<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exceptions\FrontException;
use Auth;
use Mail;
use Exception;
use App\Models\Registration;
use App\Models\Employee;
use App\Models\UserModel;
use App\Models\module;
use App\Models\RoleAuthorization;

class UseraceesController extends Controller
{
    protected $_routePrefix;
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.user-access';
        //$this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request){
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = DB::table("registration")->where("status", "=", "active")->where("email", "=", $email)->first();
            $data["user_config_count"] = DB::table("users")
            ->where("emid", "=", $Roledata->reg)
            ->where("user_type", "=", "employee")
            ->count();
            $data["roles_management_count"] = RoleAuthorization::where("emid", "=", $Roledata->reg)->count();
            //dd($data);
            return view($this->_routePrefix . '.dashboard',$data);
        } else {
            return redirect("/"); 
        }
    }

    public function viewUserConfig()
    {  
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["users"] = DB::table("users")
                    ->join(
                        "employee",
                        "users.employee_id",
                        "=",
                        "employee.emp_code"
                    )

                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("users.emid", "=", $Roledata->reg)
                    ->select("users.*")
                    ->where("users.user_type", "=", "employee")
                    ->get();
                return view($this->_routePrefix . '.view-users',$data);
                //return view("role/view-users", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function viewUserConfigForm()
    {
        try {
          
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $data["employeeslist"] = Employee::where(
                    "emid",
                    "=",
                    $Roledata->reg
                )->get();
                //   dd($data["employeeslist"]);
                $data["users"] = UserModel::join(
                    "employee",
                    "users.employee_id",
                    "=",
                    "employee.emid"
                )

                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("users.emid", "=", $Roledata->reg)
                    ->select("users.*")
                    ->where("users.user_type", "=", "employee")
                    ->get();

                // dd($datass);
                $userlist = [];
                foreach ($data["users"] as $user) {
                    $userlist[] = $user->employee_id;
                }

                $data["employees"] = [];

                foreach ($data["employeeslist"] as $key => $employee) {
                    $data["employees"][] = [
                        "emp_code" => $employee->emp_code,
                        "em_email" => $employee->em_email,
                        "emp_fname" => $employee->emp_fname,
                        "emp_mname" => $employee->emp_mname,
                        "emp_lname" => $employee->emp_lname,
                    ];
                }
                return view($this->_routePrefix . '.view-user-config',$data);
                //return view("role/view-user-config", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function GetUserConfigForm($user_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["employeeslist"] = DB::table("employee")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                $data["users"] = DB::table("users")
                    ->join(
                        "employee",
                        "users.employee_id",
                        "=",
                        "employee.emp_code"
                    )

                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("users.emid", "=", $Roledata->reg)
                    ->select("users.*")
                    ->where("users.user_type", "=", "employee")
                    ->get();

                $userlist = [];
                foreach ($data["users"] as $user) {
                    $userlist[] = $user->employee_id;
                }

                $data["employees"] = [];
                foreach ($data["employeeslist"] as $key => $employee) {
                    if (in_array($employee->emp_code, $userlist)) {
                    } else {
                        $data["employees"][] = (object) [
                            "emp_code" => $employee->emp_code,
                            "emp_fname" => $employee->emp_fname,
                            "emp_mname" => $employee->emp_mname,
                            "emp_lname" => $employee->emp_lname,
                        ];
                    }
                }
                // dd($data["employees"]);

                $data["user"] = DB::table("users")
                    ->where("id", "=", $user_id)
                    ->first();
                return view($this->_routePrefix . '.view-user-config',$data);
                //return view("role/view-user-config", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function SaveUserConfigForm(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                if (!empty($request->employee_id)) {
                    $ckeck_email = DB::table("users")
                        ->where("email", "=", $request->user_email)
                        ->where("employee_id", "!=", $request->employee_id)
                        ->where("emid", "=", $Roledata->reg)
                        ->first();
                    if (!empty($ckeck_email)) {
                        Session::flash("message", "E-mail id  Already Exists.");
                        return redirect("user-access-role/vw-users");
                    }
                    if (
                        !empty($request->employee_id) &&
                        !empty($request->user_pass)
                    ) {
                        DB::table("users")
                            ->where("employee_id", "=", $request->employee_id)
                            ->where("emid", "=", $Roledata->reg)
                            ->update([
                                "password" => $request->user_pass,
                                "status" => $request->status,
                            ]);
                        Session::flash(
                            "message",
                            "User info Updated Successfully."
                        );
                        return redirect("user-access-role/vw-users");
                    } else {
                        DB::table("users")
                            ->where("employee_id", "=", $request->employee_id)
                            ->where("emid", "=", $Roledata->reg)
                            ->update(["status" => $request->status]);
                        Session::flash(
                            "message",
                            "User info Updated Successfully."
                        );
                    }
                } else {
                    $ckeck_email = DB::table("users")
                        ->where("email", "=", $request->user_email)
                        ->first();
                    if (!empty($ckeck_email)) {
                        Session::flash("message", "E-mail id  Already Exists.");
                        return redirect("user-access-role/vw-users");
                    }

                    $ins_data = [
                        "employee_id" => $request->emp_code,
                        "name" => $request->name,
                        "email" => $request->user_email,
                        "user_type" => "employee",
                        "password" => $request->user_pass,
                        "emid" => $Roledata->reg,
                    ];

                    DB::table("users")->insert($ins_data);
                    Session::flash("message", "User info Saved Successfully.");
                    return redirect("user-access-role/vw-users");
                }
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function viewUserAccessRights()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                // dd($Roledata->reg);
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $data["roles"] = module::get();
                $data["roles"] = RoleAuthorization::join(
                    "module",
                    "role_authorization.module_name",
                    "=",
                    "module.id"
                )
                    ->join(
                        "module_config",
                        "role_authorization.menu",
                        "=",
                        "module_config.id"
                    )
                    ->where("role_authorization.emid", "=", $Roledata->reg)
                    ->select(
                        "role_authorization.id",
                        "role_authorization.member_id",
                        "role_authorization.rights",
                        "role_authorization.emid",
                        "module.module_name",
                        "module_config.menu_name"
                    )
                    // ->groupBy('role_authorization.member_id')
                    // ->groupBy('role_authorization.menu')
                    // ->groupBy('role_authorization.rights')
                    ->orderBy("role_authorization.id", "DESC")
                    ->get();
                //dd($data);
                return view($this->_routePrefix . '.view-users-role',$data);        
                //return view("role/view-users-role", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function viewUserAccessRightsForm()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                //dd($email);
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $data["users"] = UserModel::join(
                    "employee",
                    "users.employee_id",
                    "=",
                    "employee.emp_code"
                )

                    ->where("employee.emid", "=", $Roledata->reg)
                    ->where("users.emid", "=", $Roledata->reg)
                    ->select("users.*")
                    ->where("users.user_type", "=", "employee")
                    ->get();
                $data["module"] = module::get();
                $data["menu"] = DB::table("module_config")->get();
                // dd($data);
                return view($this->_routePrefix . '.role',$data); 
                //return view("role/role", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function UserAccessRightsFormAuth(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                //dd($request->all());
                foreach ($request["member_id"] as $valuemenm) {
                    foreach ($request["menu_name"] as $key => $value) {
                        $ins_data["menu"] = $request["menu_name"][$key];
                        $ins_data["member_id"] = $valuemenm;
                        $ins_data["module_name"] = $request["module_name"];
                        $ins_data["sub_module_name"] =
                            $request["sub_module_name"];
                        $ins_data["emid"] = $Roledata->reg;

                        foreach (
                            $request["user_rights_name"]
                            as $keyrights => $rights
                        ) {
                            $ins_data["rights"] = $rights;
                            $check_user_access = $this->userWiseAccessList(
                                $valuemenm,
                                $ins_data["module_name"],
                                $ins_data["sub_module_name"],
                                $ins_data["menu"],
                                $ins_data["rights"]
                            );

                            if (is_null($check_user_access)) {
                               
                                $userrightRoledata =RoleAuthorization::where("member_id", "=", $valuemenm)->first();
                                
                                $employeeRoledata = Employee::where("emid", "=", $Roledata->reg)
                                    ->where("em_email", "=", $valuemenm)
                                    ->first();
                                    
                                $employeusereRoledata =UserModel::where("emid", "=", $Roledata->reg)
                                    ->where("email", "=", $valuemenm)
                                    ->where("user_type", "=", "employee")
                                    ->first();
                                    // dd("hello",$employeusereRoledata);
                                  
                                if (empty($userrightRoledata)) {
                                   
                                        $data = [
                                            "firstname" =>
                                                $employeeRoledata->emp_fname,
                                            "maname" =>
                                                $employeeRoledata->emp_mname,
                                            "email" => $valuemenm,
                                            "lname" => $employeeRoledata->emp_lname,
                                            "password" =>
                                                $employeusereRoledata->password,
                                        ];
                                         $toemail = $valuemenm;
                                        // Mail::send("mail", $data, function (
                                        //     $message
                                        // ) use ($toemail) {
                                        //     $message
                                        //         ->to($toemail, "Workpermitcloud")
                                        //         ->subject(
                                        //             "Employee Login  Details"
                                        //         );
                                        //     $message->from(
                                        //         "noreply@workpermitcloud.co.uk",
                                        //         "Workpermitcloud"
                                        //     );
                                        //  });
                                        
                                }
                                //dd($ins_data);
                                RoleAuthorization::insert(
                                    $ins_data
                                );
                                Session::flash(
                                    "message",
                                    "Role Successfully Saved."
                                );
                            } else {
                                Session::flash(
                                    "message",
                                    "User Permission already exist!!"
                                );
                            }
                        }
                    }
                }

                return redirect("user-access-role/view-users-role");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function userWiseAccessList( $usermailid, $module_name, $sub_module_name, $menu_name, $rights) {
        try {
            if (!empty(Session::get("emp_email"))) {
                //echo $usermailid; echo "--"; echo $module_name; echo "=="; echo $sub_module_name; echo "++"; echo $menu_name; echo "@@"; echo $rights;

                $useraccessdtl = DB::table("role_authorization")
                    ->select("role_authorization.*")
                    ->where("role_authorization.member_id", "=", $usermailid)
                    ->where("role_authorization.module_name", "=", $module_name)
                    ->where(
                        "role_authorization.sub_module_name",
                        "=",
                        $sub_module_name
                    )
                    ->where("role_authorization.menu", "=", $menu_name)
                    ->where("role_authorization.rights", "=", $rights)
                    ->first();

                return $useraccessdtl;
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function deleteUserAccess($role_authorization_id)
    {
        try { 
            if (!empty(Session::get("emp_email"))) {
                // echo $role_authorization_id; exit;
                //dd($role_authorization_id);
                $result = DB::table("role_authorization")
                    ->where("id", "=", $role_authorization_id)
                    ->delete();
                Session::flash(
                    "message",
                    "Access permission deleted Successfully."
                );
                return redirect("user-access-role/view-users-role");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }





} //End Class
