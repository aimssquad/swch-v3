<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Exception;
use App\Models\Registration;
use App\Models\HolidayType;
use App\Models\Holiday;
class HolidayController extends Controller
{
    public function viewdash()
    {
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["holiday_type"] = DB::table("holiday_type")
                    ->where("emid", "=", $data["Roledata"]->reg)
                    ->get();
                $data["holiday_rs"] = DB::Table("holiday")
                    ->where("holiday.emid", "=", $data["Roledata"]->reg)
                    ->select("holiday_type.name", "holiday.*")
                    ->join(
                        "holiday_type",
                        "holiday.holiday_type",
                        "=",
                        "holiday_type.id"
                    )
                    ->get();
                return View("holiday/dashboard", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function viewAddHoliday()
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
                $data["holiday_type"] = HolidayType::where("emid", "=", $Roledata->reg)
                    ->get();
                // dd($data);
                return view("holiday/add-holiday", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewHolidayDetails()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] =Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $data["holiday_rs"] = Holiday::where("holiday.emid", "=", $Roledata->reg)
                    ->select("holiday_type.name", "holiday.*")
                    ->join(
                        "holiday_type",
                        "holiday.holiday_type",
                        "=",
                        "holiday_type.id"
                    )
                    ->get();
                // dd($data['holiday_rs']);

                return view("holiday/companywise-holiday", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveHolidayData(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata =Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                //echo "<pre>";print_r($request->all()); exit;
                $validator = Validator::make(
                    $request->all(),
                    [
                        "years" => "required",
                        "from_date" => "required",
                        "to_date" => "required",
                        "month" => "required",
                        "day" => "required",
                        "holiday_descripion" => "required",
                    ],
                    [
                        "years.required" => "Year Required",
                        "from_date.required" => "From Date Required",
                        "to_date.required" => "To Date Required",
                        "month.required" => "Month Required",
                        "day.required" => "Day Required",
                        "holiday_descripion.required" =>
                            "Holiday Descripion Required",
                    ]
                );

                //$data = $request->all();

                //print_r($request->all()); exit;
                $monthYear = explode("-", $request->from_date);
                $data = [
                    "years" => $monthYear[0],
                    "month" => $monthYear[1],
                    "from_date" => $request->from_date,
                    "to_date" => $request->to_date,
                    "day" => $request->day,
                    "emid" => $Roledata->reg,
                    "weekname" => $request->weekname,
                    "holiday_type" => $request->holiday_type,
                    "updated_at" => date("Y-m-d h:i:s"),
                    "created_at" => date("Y-m-d h:i:s"),
                    "holiday_descripion" => $request->holiday_descripion,
                ];

                if (!empty($request->id)) {
                     Holiday::where("id", $request->id)
                        ->update($data);
                } else {
                     Holiday::insert($data);
                }

                Session::flash(
                    "message",
                    "Holiday Information Successfully Saved."
                );
                return redirect("holidays");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getHolidayDtl($holiday_id)
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

                $data["holidaydtl"] = DB::Table("holiday")
                    ->where("id", $holiday_id)
                    ->first();
                // dd($data);
                $data["holiday_type"] = DB::table("holiday_type")
                    ->where("emid", "=", $Roledata->reg)
                    ->get();
                return view("holiday/add-holiday", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function deleteHoliday($holiday_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $result = DB::table("holiday")
                    ->where("id", $holiday_id)
                    ->delete();
                Session::flash("message", "Holiday Deleted Successfully.");
                return redirect("holidays");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function viewHolidayTypeDetails()
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

                $data["holiday_rs"] = HolidayType::where("emid", "=", $Roledata->reg)
                    ->select("*")
                    ->get();
                // dd($data['holiday_rs']);

                return view("holiday/holiday-type", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function viewAddHolidayType()
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
                // dd($data);
                return view("holiday/add-holiday-type", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getHolidayTypeDtl($holiday_id)
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

                $data["holidaydtl"] = HolidayType::where("id", $holiday_id)
                    ->first();
                // dd($data);

                return view("holiday/add-holiday-type", $data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveHolidayTypeData(Request $request)
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

                //echo "<pre>";print_r($request->all()); exit;
                $validator = Validator::make(
                    $request->all(),
                    [
                        "name" => "required",
                    ],
                    [
                        "name.required" => "Holiday Type Required",
                    ]
                );

                if ($validator->fails()) {
                    return redirect("holiday/add-holiday-type")
                        ->withErrors($validator)
                        ->withInput();
                }
                $data = [
                    "name" => $request->name,

                    "emid" => $Roledata->reg,
                ];
                
                if (!empty($request->id)) {
                    
                    $data=db::table('holiday_type')->where("id", $request->id)
                        ->update($data);
                        
                } else {
                     
                     HolidayType::insert($data);
                }

                Session::flash(
                    "message",
                    "Holiday Type Information Successfully Saved."
                );
                return redirect("holiday-type");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
}
