<?php

namespace App\Http\Controllers;

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
public function dashboard(Request $request){
        return View('filemanagment/dashboard');
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

       $data['file_details'] = fileManager::where('organization_id', $empId)
                                           ->get();
       return View("filemanagment/file-manager-list", $data);
   } else {
       $data['file_details'] = [];
       return View("filemanagment/file-manager-list", $data);
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
                                           ->orWhere('emp_id', $emp_codes)
                                           ->get();
       return View("filemanagment/file-manager-list", $data);
   } else {
       $data['file_details'] = [];
       return View("filemanagment/file-manager-list", $data);
   }
      }else{
         return redirect("/");
      }
   }
 }
 public function getalldatafilemanagment($organizationId){
  $org =trim($organizationId);
  $data=fileManager::where('organization_id',$org)->get();
  echo json_encode($data);
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
         return View("filemanagment/add-fileManagment",$data);
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
         return View("filemanagment/add-fileManagment",$data);
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

      return redirect("fileManagment/fileManagmentList");
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

      return redirect("fileManagment/fileManagmentList");
      Session::flash('message', 'File Manager Successfully Save.');
   }else{
      return redirect("/");
   }
   }

 }
 public function fileManagmentViewedit($id){
   $data['file_details']=fileManager::where("id",$id)->first();
   return View("filemanagment/edit-fileManagment",$data);
 }
 public function savefilemanagmentupdate(Request $request){
   $date=carbon::now()->toDateString();
   $arryValue=array(
      "file_name"=>$request->file_name,
      "emp_id"=>$request->emp_id,
      "organization_id"=>$request->organization_id,
      "status"=>$request->status,
      "remarks"=>$request->remarks,
      "update_at"=>$date,

   );
   DB::table('file_managers')->where('id',$request->id)->update($arryValue);
   return redirect("fileManagment/fileManagmentList");
   Session::flash('message', 'File Manager Successfully Update.');
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
            return view("filemanagment/file-devision-list",$data);
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
            return view("filemanagment/file-devision-list",$data);
            }else{
                return redirect("/");
            }
      }
   // if(!empty($email)){
   //  $dataReg = Registration::where("email",$email)->first();
   //  $organization_id = $dataReg['id'];
   //  $data['file_details']= fileDivision::where("organization_id",$organization_id)->get();
   //  return view("filemanagment/file-devision-list",$data);
   //  }else{
   //      return redirect("/");
   //  }
 }
 public function filedivisionView(){
   $email = Session::get('emp_email');
   if(!empty($email)){
   return view("filemanagment/file-devision-Add");
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
              return redirect("fileManagment/file-devision-list");

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
              return redirect("fileManagment/file-devision-list");

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
  return view("filemanagment/file-devision-edit",$data);
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
      return redirect("fileManagment/file-devision-list");
      Session::flash('message', 'File Division Successfully Update.');
   }else{
      Session::flash('message', 'File Division Tecnical Issue');
   }
 }
 public function folderCreate(Request $request, $id){
   $email = Session::get('emp_email');
   // dd($email);
   if(!empty($email)){
      $data['data']= fileManager::find($id);
      $filename=$data['data']->file_name;
      $data['file_image']=DB::table('folder_managers')->where("file_name",$filename)->get();
      return view('filemanagment/folder-view',$data);
   }else{
    return redirect("/");
   }
 }

 public function saveFolderUpload(Request $request){
   $email = Session::get('emp_email');
   if(!empty($email)){
      $data=array(
         'emp_id'=>$request->empId,
         'org_id'=>$request->orgId,
         'file_id'=>$request->file_id,
         'file_name'=>$request->fileName,
         'folder_name'=>$request->folder_name,
         'status'=>'active',
      );
      $dataValue=DB::table('folder_managers')
      ->where('emp_id',$request->empId)
      ->where('folder_name',$request->folder_name)
      ->first();

      if($dataValue==null){
         DB::table('folder_managers')->insert($data);

         $folderName = $request->folder_name;
         $path = public_path().'filemanagment/'.$request->fileName.'/'. $folderName;
         if (!is_dir($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
         }
         Session::flash('message', 'Folder Add success');
         return redirect('fileManagment/folder-create/'.$request->file_id);
      }else{
         Session::flash('message', 'Alredy exit');
         return redirect('fileManagment/folder-create/'.$request->file_id);
      }

   }else{
      return redirect("/");
   }
 }
 public function fileAdd(Request $request, $id){

   $email = Session::get('emp_email');
   if(!empty($email)){
      // $data['data']= fileManager::find($id);
      $data['data']= DB::table('folder_managers')->find($id);
      // dd($data['data']);
      $filename=$data['data']->folder_name;
      $data['file_image']=filesUpload::where("folder_name",$filename)->get();
      return view('filemanagment/file-view',$data);
   }else{
    return redirect("/");
   }
 }
 public function saveFileUpload(Request $request){
   // dd($request->all());
   $file_id=$request->file_id;
   $file_add=$request->file_add;
   $date=carbon::now()->toDateString();
  if ($request->hasFile("uploadFile")) {
   $documents = $request->file("uploadFile");
   $empId=$request->input('empId');
   $fileName=$request->input('fileName');
   $orgId=$request->input('orgId');
   $file_rename=$request->input('file_rename');

   $folderName=$request->input('folderName');
   foreach ($documents as $key => $document) {
       $documentName =
           time() . "_" . $document->getClientOriginalName();
         //   dd($documentName);
            $document->move(("filemanagment".'/'.$fileName.'/'.$folderName), $documentName);
            DB::table('files_upload')->insert([
               'empId'=>$empId,
               'fileName'=>$fileName,
               'orgId'=>$orgId,
               'uploadFile'=>$documentName,
               'file_rename'=>$file_rename[$key],
               'folder_name'=>$folderName,
            ]);
   }
   $data['data']= fileManager::find($file_id);
//   dd($data['data']);
   $orgId=$data['data']->organization_id;
   $data['file_image']=filesUpload::where("orgId",$orgId)->get();


   Session::flash('message', 'Files Upload success');
   return redirect('fileManagment/file-add/'.$file_add);
}else{
   return redirect()->back()->with('error','Something goes wrong while uploading file!');
   // Session::flash('message', 'Files Upload Issue');
   // return redirect('fileManagment/fileManagmentList');
}
 }

 public function managerupdate(Request $request){
    $orgId=$request->org_id;
    $fileId=$request->fileupload_id;
    $file_rename=$request->file_rename;
    $data=array(
      'file_rename'=>$file_rename
    );
    DB::table('files_upload')->where('id',$fileId)->update($data);
    Session::flash('message', 'Files Name Update success');
    return redirect('fileManagment/file-add/'.$orgId);
 }

 public function filedeleted($id,$orgId){

   DB::table('files_upload')->where('id',$id)->delete();
   Session::flash('message', 'Files Name Deletd success');
   return redirect('fileManagment/file-add/'.$orgId);
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
      return Excel::download(
         new ExcelFileManager($emp_email),
         "filemanagerexcel.xlsx"
     );
   }else{
      return redirect('/');
   }
 }
}
