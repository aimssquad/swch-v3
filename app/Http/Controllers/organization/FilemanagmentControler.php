<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\ExcelFileManager;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Exception;
use App\Models\Registration;
use App\Models\fileManager;
use App\Models\Employee;
use App\Models\UserModel;
use App\Models\fileDivision;
use App\Models\filesUpload;
use Carbon\Carbon;
use File;

class FilemanagmentControler extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.file-manager';
        //$this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request){
      $email = Session::get('emp_email');
      $user_email=Session::get('user_email');
      $dataReg = Registration::where("email",$email)->first();
      $organization_id = $dataReg['id'];
      $data['file_devision_count']= fileDivision::where("organization_id",$organization_id)->count();
      $data['file_manager_count'] = fileManager::where('organization_id', $dataReg->reg)->count();
      //dd($data);
      return view($this->_routePrefix . '.dashboard',$data);
    }

    public function filedivisionlist(Request $request){
        $email = Session::get('emp_email');
        $user_email=Session::get('user_email');
        $user_type=Session::get('user_type');
        $arrayEmail=[];
        if($user_type==="employer"){
           $email = Session::get('emp_email');
           array_push($arrayEmail, $email);
        }else{
           $user_email=Session::get('user_email');
           array_push($arrayEmail, $user_email);
        }
        $emp_email = implode(", ", $arrayEmail);
        if($user_type==="employer"){
           if(!empty($email)){
              $dataReg = Registration::where("email",$email)->first();
              $organization_id = $dataReg['id'];
              $data['file_details']= fileDivision::where("organization_id",$organization_id)->get();
              return view($this->_routePrefix . '.file-devision-list',$data);
              //return view("filemanagment/file-devision-list",$data);
              }else{
                  return redirect("/");
              }
        }else{
           if(!empty($user_email)){
              // $dataReg = Registration::where("email",$email)->first();
              // $organization_id = $dataReg['id'];
              $dataReg =DB::table('users')->where('email',$user_email)->first();
              // dd($dataReg);
              $data['file_details']= fileDivision::where("organization_id",$dataReg->employee_id)->get();
              return view($this->_routePrefix . '.file-devision-list',$data);
              //return view("filemanagment/file-devision-list",$data);
              }else{
                  return redirect("/");
              }
        }
   }

   public function filedivisionView(){
    $email = Session::get('emp_email');
    if(!empty($email)){
        return view($this->_routePrefix . '.file-devision-Add');
        //return view("filemanagment/file-devision-Add");
    }else{
     return redirect("/");
    }
  }


    public function filedivisionadd(Request $request){
        $email = Session::get('emp_email');
        $user_email=Session::get('user_email');
        $user_type=Session::get('user_type');
        $arrayEmail=[];
        if($user_type==="employer"){
        $email = Session::get('emp_email');
        array_push($arrayEmail, $email);
        }else{
        $user_email=Session::get('user_email');
        array_push($arrayEmail, $user_email);
        }
        $emp_email = implode(", ", $arrayEmail);

        if($user_type==="employer"){
            if(!empty($email)){
                $dataReg = Registration::where("email",$email)->first();
                $dataUser=UserModel::where("email",$email)->first();
                $organization_id = $dataReg['id'];
                $emp_id = $dataReg['reg'];
                $arryValue=array(
                    "name"=>$request->name,
                    "organization_id"=>$organization_id ,
                    "emp_id"=>$emp_id,
                    "sort_name"=>$request->sort_name,
                );
                $result = fileDivision::insert($arryValue);
                if($result){
                    Session::flash('message', 'File Division Successfully Insert.');
                    return redirect("file-management/file-devision-list");

                }else{
                    Session::flash('error', 'Something Went Wrong.');
                    return redirect()->back();

                }

            }else{
                return redirect("");
            }
        }else{
            if(!empty($user_email)){
                $dataUser=UserModel::where("email",$user_email)->first();
                $arryValue=array(
                    "name"=>$request->name,
                    "organization_id"=>$dataUser->employee_id,
                    "emp_id"=>$dataUser->emid,
                    "sort_name"=>$request->sort_name,
                );
                $result = fileDivision::insert($arryValue);
                if($result){
                    Session::flash('message', 'File Division Successfully Insert.');
                    return redirect("file-management/file-devision-list");

                }else{
                    Session::flash('error', 'Something Went Wrong.');
                    return redirect()->back();

                }

            }else{
                return redirect("");
            }
        }

    }

    public function filedivisionViewedit($id){
        $data['file_details']= fileDivision::where("id",$id)->first();
        return view($this->_routePrefix . '.file-devision-edit',$data);
        //return view("filemanagment/file-devision-edit",$data);
    }

    public function filedivisionViewupdate(Request $request){
        $email = Session::get('emp_email');
        $date=carbon::now()->toDateString();
        if(!empty($email)){
           $arryValue=array(
              "name"=>$request->name,
              "status"=>$request->status,
           );
           DB::table('file_devisions')->where('id',$request->id)->update($arryValue);
           Session::flash('message', 'File Division Successfully Update.');
           return redirect("file-management/file-devision-list");
        }else{
           Session::flash('message', 'File Division Tecnical Issue');
           return redirect("file-management/file-devision-list");
        }
      }

    public function fileManagmentList(){
        $email = Session::get('emp_email');
        $user_email=Session::get('user_email');
        $user_type=Session::get('user_type');
     
        if($user_type==="employer"){
           if(!empty($email)){
              $employee_code=Registration::where('email',$email)->first();
        if ($employee_code !== null) {
           $empId=$employee_code->reg;
     
            $data['file_details'] = fileManager::where('organization_id', $empId)->get();
            return view($this->_routePrefix . '.file-manager-list',$data);
            //return View("filemanagment/file-manager-list", $data);
        } else {
            $data['file_details'] = [];
            return view($this->_routePrefix . '.file-manager-list',$data);
            //return View("filemanagment/file-manager-list", $data);
        }
           }else{
              return redirect("/");
           }
        }else{
           if(!empty($user_email)){
              $employee_code=UserModel::where('email',$user_email)->first();
              $empId=$employee_code->employee_id;
             $emp_code = Employee::where('emid', $empId)->orWhere('emp_code', $empId)->first();
        if ($emp_code !== null) {
            $emp_codes = $emp_code->emp_code;
     
            $data['file_details'] = fileManager::where('organization_id', $emp_codes)
                ->orWhere('emp_id', $emp_codes)->get();
            return view($this->_routePrefix . '.file-manager-list',$data);
            //return View("filemanagment/file-manager-list", $data);
        } else {
            $data['file_details'] = [];
            return view($this->_routePrefix . '.file-manager-list',$data);
            //return View("filemanagment/file-manager-list", $data);
        }
           }else{
              return redirect("/");
           }
        }
    }

    public function folderCreate(Request $request, $id){
        $email = Session::get('emp_email');
        // dd($email);
        if(!empty($email)){
           $data['data']= fileManager::find($id);
           $filename=$data['data']->file_name;
           $data['file_image']=DB::table('folder_managers')->where("file_name",$filename)->get();
           return view($this->_routePrefix . '.folder-view',$data);
           //return view('filemanagment/folder-view',$data);
        }else{
         return redirect("/");
        }
      }

      public function fileManagmentView(){
        $email= Session::get('emp_email');
        $user_email=Session::get('user_email');
        $user_type=Session::get('user_type');
        $arrayEmail=[];
        if($user_type==="employer"){
           $email = Session::get('emp_email');
           array_push($arrayEmail, $email);
        }else{
           $user_email=Session::get('user_email');
           array_push($arrayEmail, $user_email);
        }
        $emp_email = implode(", ", $arrayEmail);
     
        if($user_type==="employer"){
           if(!empty($email)){
              $data["emp_record"]=UserModel::where("email",$email)->first();
              $empid= $data["emp_record"]->employee_id;
              $data["emp_details"]=Employee::where("emid",$empid)->first();
              // dd($data["emp_details"]);
              $data["emp_detail"]=Employee::where("emid",$empid)->get();
              $data['dataReg'] = Registration::where("email",$email)->first();
              $organization_id = $data['dataReg']->id;
              $data['file_division']=fileDivision::where("organization_id",$organization_id)->get();
              return view($this->_routePrefix . '.add-fileManagment',$data);
              //return View("filemanagment/add-fileManagment",$data);
         }else{
              return redirect("/");
         }
        }else{
           if(!empty($user_email)){
              $data["emp_record"]=UserModel::where("email",$user_email)->first();
              $empid= $data["emp_record"]->employee_id;
              $data["emp_details"]=Employee::where("emp_code",$empid)->first();
              $data["emp_detail"]=Employee::where("emp_code",$empid)->get();
              $data['dataReg'] = Registration::where("reg",$data["emp_details"]->emid)->first();
              $organization_id = $data['dataReg']->id;
              $data['file_division']=fileDivision::where("organization_id",$organization_id)->get();
              return view($this->_routePrefix . '.add-fileManagment',$data);
              //return View("filemanagment/add-fileManagment",$data);
         }else{
              return redirect("/");
         }
        }
      }

      public function savefilemanagment(Request $request){
        $email= Session::get('emp_email');
        $user_email=Session::get('user_email');
        $user_type=Session::get('user_type');
     
        if($user_type==="employer"){
     
        if(!empty($email)){
           $arryValue=array(
              "division"=>$request->division,
              "file_name"=>$request->file_name,
              "emp_id"=>$request->emp_id,
              "organization_id"=>$request->organization_id,
              "status"=>"Approved",
              "remarks"=>$request->remarks,
           );
     
           fileManager::insert($arryValue);
           $folderName = $request->file_name;
           $path = public_path().'filemanagment/' . $folderName;
           if (!is_dir($path)) {
              File::makeDirectory($path, $mode = 0777, true, true);
           }
     
           return redirect("file-management/fileManagmentList");
           Session::flash('message', 'File Manager Successfully Save.');
        }else{
           return redirect("/");
        }
        }else{
     
        if(!empty($user_email)){
           $arryValue=array(
              "division"=>$request->division,
              "file_name"=>$request->file_name,
              "emp_id"=>$request->emp_id,
              "organization_id"=>$request->organization_id,
              "status"=>"pending",
              "remarks"=>$request->remarks,
           );
     
           fileManager::insert($arryValue);
           $folderName = $request->file_name;
           $path = public_path().'filemanagment/' . $folderName;
           if (!is_dir($path)) {
              File::makeDirectory($path, $mode = 0777, true, true);
           }
     
           return redirect("file-management/fileManagmentList");
           Session::flash('message', 'File Manager Successfully Save.');
        }else{
           return redirect("/");
        }
        }
     
      }

      public function excelreport(){
         if (!empty(Session::get("emp_email"))) {
            $user_type=Session::get('user_type');
            $arrayEmail=[];
            if($user_type==="employer"){
               $email = Session::get('emp_email');
               array_push($arrayEmail, $email);
            }else{
               $user_email=Session::get('user_email');
               array_push($arrayEmail, $user_email);
            }
            $emp_email = implode(", ", $arrayEmail);
            dd($emp_email);
            return Excel::download(
               new ExcelFileManager($emp_email),
               "filemanagerexcel.xlsx"
           );
         }else{
            return redirect('/');
         }
       }









} // End Class 
