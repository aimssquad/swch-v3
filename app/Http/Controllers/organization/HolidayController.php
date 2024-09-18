<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use Validator;
use view;
use App\Models\Registration;
use App\Models\HolidayType;
use App\Models\Holiday;
use Exception;

class HolidayController extends Controller
{
    //
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.holiday';
        //$this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request){
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
            $data["holiday_list_count"] = Holiday::where("holiday.emid", "=", $Roledata->reg)->count();
            $data["holiday_type_count"] = HolidayType::where("emid", "=", $Roledata->reg)->count();
            //dd($data);
            return view($this->_routePrefix . '.dashboard',$data);
        }
    }

    public function holidayList(Request $request)
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
                return view($this->_routePrefix . '.holiday-list',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
    public function addHolidayList(Request $request)
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
                //return view("holiday/add-holiday", $data);
                return view($this->_routePrefix . '.add-holiday-list',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveHolidayList(Request $request)
    {  
        //dd('okkk');
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
                return redirect("organization/holiday-list");
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
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            if (!$Roledata) {
                return redirect("/")->with("error", "Unauthorized access.");
            }

            $holiday = Holiday::find($holiday_id);
            if (!$holiday) {
                return redirect("organization/holiday-list")->with("error", "Holiday not found.");
            }

            $holiday->delete();

            Session::flash("message", "Holiday Successfully Deleted.");
            return redirect("organization/holiday-list");
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
                //return view("holiday/add-holiday", $data);
                return view($this->_routePrefix . '.add-holiday-list',$data);
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

                //return view("holiday/holiday-type", $data);
                return view($this->_routePrefix . '.holiday-type',$data);
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
                //return view("holiday/add-holiday-type", $data);
                return view($this->_routePrefix . '.add-holiday-type',$data);
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
                    return redirect("organization/add-holiday-type")
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
                return redirect("organization/holiday-type");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    //Delete Holiday Type 
    public function deleteHolidayType($holiday_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                if (!$Roledata) {
                    return redirect("/")->with("error", "Unauthorized access.");
                }

                $holidayType = HolidayType::find($holiday_id);
                if (!$holidayType) {
                    return redirect("organization/holiday-type")
                        ->with("error", "Holiday Type not found.");
                }

                $holidayType->delete();

                Session::flash(
                    "message",
                    "Holiday Type Successfully Deleted."
                );
                return redirect("organization/holiday-type");
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
                return view($this->_routePrefix . '.add-holiday-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            //dd("Exception caught: " . $e->getMessage());
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

}
