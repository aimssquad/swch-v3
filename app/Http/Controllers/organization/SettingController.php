<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;
use view;
use App\Models\RateDetail;
use App\Models\Masters\Cast;
use App\Models\Masters\Sub_cast;
use App\Models\Masters\Bank;
use App\Models\Rate_master;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.settings';
        //$this->_model       = new CompanyJobs();
    }

    public function getCompanyBank(){
        $data['grades']=DB::table('company-bank-master')->get();
        return view($this->_routePrefix . '.company_bank',$data);
        //return view("settings/company_bank",$data);
    }

    public function addComapnyBankAdd(){
        return view($this->_routePrefix . '.add-new-bank-comapny');
        //return view("settings/add-new-bank-comapny");
    }

    public function addcmpbankDetails(){
        $dataArray=[
            "bankname"=>$_POST['bankname'],
            "bankbranch"=>$_POST['bankbranch'],
            "ifsccode"=>$_POST['ifsccode'],
            "micrcode"=>$_POST['micrcode'],
            "status"=>$_POST['status'],
        ];
        DB::table('company-bank-master')->insert($dataArray);
        Session::flash('message', 'Company Bank Information Successfully Add.');
        return redirect('org-settings/vw-cmp-bank');
    }

    public function cmpbankedit($id){
        $data['bank']=DB::table('company-bank-master')->where("id",$id)->get();
        // dd($data['bank']);
        return view($this->_routePrefix . '.updatecmpbank',$data);
        //return view("settings/updatecmpbank",$data);
    }

    public function cmpBankDetailsupdate(){
        $dataArray=[
            "bankname"=>$_POST['bankname'],
            "bankbranch"=>$_POST['bankbranch'],
            "ifsccode"=>$_POST['ifsccode'],
            "micrcode"=>$_POST['micrcode'],
            "status"=>$_POST['status'],
        ];
        DB::table('company-bank-master')->where("id",$_POST['id'])->update($dataArray);
        Session::flash('message', 'Company Bank Information Successfully Update.');
        return redirect('org-settings/vw-cmp-bank');
    }

    public function getempBank(){
        $data['bank_rs'] = Bank::getMasterAndBank();
        return view($this->_routePrefix . '.emp_bank_details',$data);
       // return view("settings/emp_bank_details",compact('bank_rs'));
    }

    public function addempBankAdd(){
        $data['MastersbankName'] = Bank::getMastersBank();
        return view($this->_routePrefix . '.add-new-bank-emp',$data);
        //return view("settings/add-new-bank-emp",$data);
    }

    public function addempbankDetails(Request $request) {
        // Validate the incoming request
        $request->validate([
            'bank_name' => 'required',
            'branch_name' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        //dd($request->all());
        // Create a new bank record using the Bank model
        $bank = new Bank([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'ifsc_code' => $request->ifsc_code,
            'swift_code' => $request->swift_code,  // Assuming you meant to map swift_code to micr_code
            'bank_status' => $request->status,
        ]);
    
        // Save the record to the database
        $bank->save();
    
        // Flash success message and redirect
        Session::flash('message', 'Employee Bank Information Successfully Added.');
        return redirect('org-settings/vw-emp-bank');
    }

    public function empbankedit($id){
        $bankid = $id;
        $data['bankdetails'] = Bank::where('id', $bankid)->get()->toArray();
        $data['MastersbankName'] = Bank::getMastersBank();
        return view($this->_routePrefix . '.updateempbank',$data);
        //return view("settings/updateempbank",$data);
    }

    public function empBankDetailsupdate(Request $request){
        
        if (is_numeric($request->branch_name) == 1) {
            Session::flash('error', 'Branch Name Should not be numeric.');
            return redirect('org-settings/vw-emp-bank');
        }

        $data = array(
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'ifsc_code' => $request->ifsc_code,
            'swift_code' => $request->swift_code,
            'bank_status' => $request->bank_status,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
            // 'bank_status' => $request->des_status,
        );
        Bank::where('id', $request->bankid)->update($data);
        Session::flash('message', 'Employee Bank Information Successfully Update.');
        return redirect('org-settings/vw-emp-bank');
    }

    public function getCaste()
    {
       // $data['enteries'] = DB::table('caste_master')->get();
        $data['enteries'] = Cast::get();
        return view($this->_routePrefix . '.caste',$data);
        //return view('settings/caste', $data); 
    }

    public function viewAddNewCaste(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('caste_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('caste_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-caste',$data);
                        //return view('settings/add-new-caste', $data);
                    } else {
                        return redirect('org-settings/add-new-caste');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-caste',$data);
                    //return view('settings/add-new-caste', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveCasteData(Request $request)
    {  
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
         $cast_name = strtoupper($request->cast_name);
         if (is_numeric($cast_name) == 1) {
              Session::flash('error', 'Caste Should not be numeric.');
              return redirect()->back();
            }
      
        $data = array(
            // 'idcaste_master' => $request->idcaste_master,
            'cast_name' => $request->cast_name,
            'cast_status' => "active",
        );
       // DB::table('casts')->insert($data);
       $castemdb = Cast::where('cast_name', '=', trim($request->cast_name))->where('cast_status', '=', 'active')->first();

       if (empty($castemdb)) {
         $dataInsert = Cast::insert($data);
         Session::flash('message', 'Cast Successfully saved.');
       } else {
         Session::flash('message', 'Cast Already Exits.');
       }
        return redirect('org-settings/vw-caste');
    }

    public function castUpdate($id){
        if ($id != '') {
            $data['cast'] = Cast::where('id', $id)->get();
            //dd($data);
            return view($this->_routePrefix . '.gt-cast',$data);
            //return view("settings/gt-cast",$data);
        }else{
            return redirect('org-settings/vw-caste');
        }
     
    }

    public function subcastGet()
    {
        // $data['enteries'] = DB::table('sub_cast')->get();
        $data['enteries'] = Sub_cast::leftJoin('casts', 'sub_casts.cast_id', '=', 'casts.id')
        // ->where('sub_cast_status','=','active')
        ->select('sub_casts.*', 'casts.cast_name')
        ->get();
        return view($this->_routePrefix . '.sub-cast-reli',$data);
        //return view('settings/sub-cast-reli', $data);
    }

    public function addsubcast(){
        // DB::table('sub_cast')->insert($_POST);
        $data['getCast'] = Cast::where('cast_status', '=', 'active')->get();
        return view($this->_routePrefix . '.sub_cast_add',$data);
        //return view('settings/sub_cast_add',$data);
    }

    public function saveSubCasteData(Request $request){
        $sub_cast_name = strtoupper(trim($request->sub_cast_name));
      if (is_numeric($sub_cast_name) == 1) {
        Session::flash('error', 'Sub cast Should not be numeric.');
        return redirect('org-settings/add-sub-caste');
      }
      $subcast_id = $request->sub_cast_id;
      $subcast_name = strtoupper($request->sub_cast_name);
      $cast_id = $request->cast_id;
      $validator = Validator::make(
        $request->all(),
        [
          'cast_id' => 'required',
          'sub_cast_name' => 'required|max:255'

        ],
        [
          //'cast_id.required'=>'Cast ID Required',
          'sub_cast_name.required' => 'Sub Cast Name Required',
          'sub_cast_id.required' => 'Sub Cast ID Required',
        ]
      );

      if ($validator->fails()) {
        return redirect('org-settings/add-sub-caste')->withErrors($validator)->withInput();
      } else {

        $data = array(
          'cast_id' => $cast_id,
          'sub_cast_id' => $subcast_id,
          'sub_cast_name' => $subcast_name,
          'sub_cast_status' => 'active'

        );

        $subcastemdb = Sub_cast::where('sub_cast_name', '=', trim($request->sub_cast_name))->where('sub_cast_status', '=', 'active')->first();

        if (empty($subcastemdb)) { 
          $check_sub_cast = Sub_cast::where('sub_cast_name', $sub_cast_name)->first();
          if (!empty($check_sub_cast)) {
            Session::flash('message', 'Already Exists.');
            return redirect('org-settings/add-sub-caste');
          }
          $dataInsert = Sub_cast::insert($data);
          Session::flash('message', 'Sub Cast Successfully saved.');
          
            return redirect('org-settings/vw-subcast');
        } else { 
          Session::flash('error', 'Sub Cast Already Exits.');
          return redirect('org-settings/add-sub-caste');
        }
        return redirect('org-settings/vw-subcast');
      }
    }

    public function editSubCast($id){
        if ($id != ' ') {
            $data['getCast'] = Sub_cast::leftJoin('casts', 'sub_casts.cast_id', '=', 'casts.id')
              ->where('sub_casts.id', '=', $id)
              ->select('sub_casts.*', 'casts.cast_name')
              ->get();
            //$data['getCast']=DB::table('cast')->where('cast_status','=','active')->get();
            return view($this->_routePrefix . '.sub-cast-edit',$data);
            //return view('settings/sub-cast-edit', $data);
          } else {
    
            $data['getCast'] = Cast::where('cast_status', '=', 'active')->get();
            return view($this->_routePrefix . '.sub_cast_add',$data);
            //return view('settings/sub_cast_add',$data);
          }
    }

    public function updateSubCast(Request $request)
    { 
        $sub_cast_name = strtoupper(trim($request->sub_cast_name));
        if (is_numeric($sub_cast_name) == 1) {
          Session::flash('error', 'Sub cast Should not be numeric.');
          return redirect('org-settings/vw-subcast');
        }
        $subcast_id = $request->sub_cast_id;
        $subcast_name = strtoupper($request->sub_cast_name);
        $cast_id = $request->cast_id;
        $validator = Validator::make(
          $request->all(),
          [
            'cast_id' => 'required',
            'sub_cast_name' => 'required|max:255'
  
          ],
          [
            //'cast_id.required'=>'Cast ID Required',
            'sub_cast_name.required' => 'Sub Cast Name Required',
            'sub_cast_id.required' => 'Sub Cast ID Required',
          ]
        );
  
        if ($validator->fails()) {
          return redirect('org-settings/add-sub-caste')->withErrors($validator)->withInput();
        } else {
  
  
          $data = array(
            'id' => $cast_id,
            'sub_cast_id' => $subcast_id,
            'sub_cast_name' => $subcast_name,
            'sub_cast_status' => $request->cast_status
  
          );
  
          Sub_cast::where('id', $request->cast_id)
            ->update($data);
          Session::flash('message', 'Sub Cast Successfully Updated.');
          return redirect('org-settings/vw-subcast');
        }
    }

    public function getClasses()
    {
        $data['enteries'] = DB::table('emp_class_master')->get();
        return view($this->_routePrefix . '.class',$data);
    }

    public function viewAddNewClass(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('emp_class_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('emp_class_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-class',$data);
                        //return view('settings/add-new-class', $data);
                    } else {
                        return redirect('org-settings/add-new-class');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-class',$data);
                    //return view('settings/add-new-class', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveClassData(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255', // Adjust as per your needs
        ]);
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')->where('email', '=', $email)->first();
        $data = array(
            'class_name' => $request->class_name
        );
        DB::table('emp_class_master')->insert($data);
        Session::flash('message', 'Employee Class Successfully Saved.');
        return redirect('org-settings/vw-class');
    }

    public function getClassesById($id)
    {
     try{
       
        $data['enteries'] = DB::table('emp_class_master')
        ->where("class_id",$id)
        ->get();
        return view($this->_routePrefix . '.edit-class',$data);
        //return view('settings/edit-class',$data);
     }   
     catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function updateClassById(){
        try{
            $data = array(
                'class_name' =>$_POST['class_name'],
    
            );
            $dataInsert = DB::table('emp_class_master')
                ->where('class_id', $_POST['class_id'])
                ->update($data);
            Session::flash('message', 'Class Information Successfully Updated.');
            return redirect('org-settings/vw-class');
    
        }catch(Exception $e){
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    
    public function getPincode()
    {
        $data['enteries'] = DB::table('pin_code_master')->get();
        return view($this->_routePrefix . '.pincode',$data);
        //return view('settings/pincode', $data);
    }

    public function viewAddNewPincode(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('pin_code_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('pin_code_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-pincode',$data);
                        //return view('settings/add-new-pincode', $data);
                    } else {
                        return redirect('org-settings/add-new-pincode');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-pincode',$data);
                    //return view('org-settings/add-new-pincode', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function savePincodeData(Request $request)
    {
        $request->validate([
            'pin_code' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'district' => 'required',
        ]);
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        $data = array(
            'pin_code' => $request->pin_code,
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'district' => $request->district,
        );
        DB::table('pin_code_master')->insert($data);
        Session::flash('message', 'Pincode successfully saved.');
        return redirect('org-settings/vw-pincode');
    }


    public function pincodeGetbyId($id) { 
        $data['pincode'] = DB::table("pin_code_master")->where('id', '=', $id)->first();
        return view($this->_routePrefix . '.gt-pincode', $data);
    }    

    public function pincodeUpdate()
    {
        $data=[
            "pin_code"=>$_POST['pin_code'],
            "country"=>$_POST['country'],
            "city"=>$_POST['city'],
            "state"=>$_POST['state'],
            "district"=>$_POST['district'],
        ];
        // print_r($data);die;
        DB::table("pin_code_master")
        ->where("id",$_POST['pincode_id'])
        ->update($data);
        Session::flash('message', 'Pincode Information Successfully Updated.');
                return redirect('org-settings/vw-pincode');
    }

    public function getType()
    {
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            // dd($Roledata->reg);
        $data['enteries'] = DB::table('employ_type_master')->where('emid',$Roledata->reg)->get();
        return view($this->_routePrefix . '.type', $data);
        //return view('settings/type', $data);
    }

    public function viewAddNewType(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('employ_type_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('employ_type_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-type', $data);
                        //return view('settings/add-new-type', $data);
                    } else {
                        return redirect('org-settings/add-new-type');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-type', $data);
                    //return view('settings/add-new-type', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveTypeData(Request $request)
    {

        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        $data = array(
            'employ_type_name' => $request->employ_type_name,
            'emid'=>$Roledata->reg
            );
        DB::table('employ_type_master')->insert($data);
        Session::flash('message', 'Employee Type  Successfully Save.');
        return redirect('org-settings/vw-type');
    }

    public function typeofedit($id)
    {
        $data['enteries'] = DB::table('employ_type_master')
        ->where("employ_type_id",$id)
        ->first(); 
        return view($this->_routePrefix . '.edit-employee', $data);
        //return view('settings/edit-employee',$data);  
    }

    public function typeofupdate()
    {
        $insertArray=[
            "employ_type_name"=>$_POST['employ_type_name']
        ];
        $data['enteries'] = DB::table('employ_type_master')
        ->where('employ_type_id',$_POST['id'])
        ->update($insertArray);
        Session::flash('message', 'Employee Information Successfully Updated.');
        return redirect('org-settings/vw-type'); 
    }

    public function getmodeOfEmpType(){
        $data['enteries']=DB::table("mode_of_employee")->get();
        // print_r($data);die;
        return view($this->_routePrefix . '.mode-type', $data);
        //return view('settings/mode-type',$data);
    }

    public function modeemployeeadd(){
        return view($this->_routePrefix . '.modeemployeeadd');
        //return view("settings/modeemployeeadd");
    }

    public function addmodeemployeesucc(Request $request) {
        $validatedData = $request->validate([
            'mode_emp_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $data = [
            "mode_emp_name" => $validatedData['mode_emp_name'],
            "status" => $validatedData['status']
        ];
        DB::table('mode_of_employee')->insert($data);
        Session::flash('message', 'Mode Of Employee Information Successfully Added.');
        return redirect('org-settings/vw-mode-type');
    }

    public function editEmpMode($id){
        $data['enteries']=DB::table("mode_of_employee")->where("id",$id)->first();
        return view($this->_routePrefix . '.vw-edit-mode-employee', $data);
        //return view("settings/vw-edit-mode-employee",$data);
    }

    public function modeEmpUpdate(Request $request){
        $validatedData = $request->validate([
            'mode_emp_name' => 'required|string|max:255',
            'status' => 'required',
            'id'     => 'required'
        ]);
        $data = [
            "mode_emp_name" => $validatedData['mode_emp_name'],
            "status" => $validatedData['status']
        ];
        DB::table('mode_of_employee')
        ->where("id",$request->id)
        ->update($data);
        Session::flash('message', 'Mode Of Employee Information Successfully Update.');
        return redirect('org-settings/vw-mode-type'); 
    }

    public function getIfsc()
    {
        $data['enteries'] = DB::table('ifsc_master')->get();
        return view($this->_routePrefix . '.ifsc', $data);
        //return view('settings/ifsc', $data);
    }

    public function viewAddNewIfsc(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('ifsc_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('ifsc_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-ifsc', $data);
                        //return view('settings/add-new-ifsc', $data);
                    } else {
                        return redirect('org-settings/add-new-ifsc');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-ifsc', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveIfscData(Request $request)
    {
        $request->validate([
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'bank_address' => 'required|string|max:500',
        ]);
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')->where('email', '=', $email)->first();
        $data = [
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'bank_address' => $request->bank_address,
        ];
        DB::table('ifsc_master')->insert($data);
        Session::flash('message', 'IFSC added successfully.');
        return redirect('org-settings/vw-ifsc');
    }

    public function editviewAddNewIfsc($id)
    {
        $data['enteries'] = DB::table('ifsc_master')->where('ifsc_no',$id)->first();
        return view($this->_routePrefix . '.edit-ifsc', $data);
       
        //return view('settings/edit-ifsc', $data);
    }

    public function updatesaveIfscData(Request $request){
        $request->validate([
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'bank_address' => 'required|string|max:500',
        ]);
        $arrayValue=array(
            "ifsc_code"=>$request->ifsc_code,
            "bank_name"=>$request->bank_name,
            "bank_address"=>$request->bank_address,
        );
        DB::table('ifsc_master')->where('ifsc_no',$request->ifsc_id)->update($arrayValue);
        Session::flash('message', 'Ifsc Details Update Successfully saved.');
        return redirect('org-settings/vw-ifsc');
    }

    public function getReligion()
    {
        $data['enteries'] = DB::table('religion_master')->get();
        return view($this->_routePrefix . '.religion', $data);
        //return view('settings/religion', $data);
    }

    public function viewAddNewReligion(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('religion_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('religion_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-religion', $data);
                        //return view('settings/add-new-religion', $data);
                    } else {
                        return redirect('org-settings/add-new-religion');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-religion', $data);
                    //return view('settings/add-new-religion', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveReligionData(Request $request)
    {
        $request->validate([
            'religion_name' => 'required|string|max:255',
        ]);
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')->where('email', '=', $email)->first();
        $data = [
            'religion_name' => $request->religion_name,
        ];
        DB::table('religion_master')->insert($data);
        Session::flash('message', 'Religion added successfully.');
        return redirect('org-settings/vw-religion');
    }

    public function editViewsaveReligionData($id)
    {
        $data['enteries'] = DB::table('religion_master')->where('idreligion_master',$id)->first();
        return view($this->_routePrefix . '.religion-edit', $data);
        //return view('settings/religion-edit', $data);
    }

    public function updateViewsaveReligionData(Request $request){
        $arrayValue=array(
            "religion_name"=>$request->religion_name,
            "status"=>$request->status,
        );
         DB::table('religion_master')->where('idreligion_master',$request->rel_id)->update($arrayValue);
         Session::flash('message', 'Religion Information Successfully Updated.');
         return redirect('org-settings/vw-religion');
    }

    public function getEducation()
    {
        $data['enteries'] = DB::table('education_master')->get();
        return view($this->_routePrefix . '.education', $data);
        //return view('settings/education', $data);
    }

    public function viewAddNewEducation(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('education_master')->where('id', '=', $request->id)->where('grade_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['grades'] = DB::table('education_master')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-education', $data);
                        //return view('settings/add-new-education', $data);
                    } else {
                        return redirect('org-settings/add-new-education');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-education', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveEducationData(Request $request)
    {
        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        $data = array(
            'education_name' => $request->education_name,
        );
        DB::table('education_master')->insert($data);
        Session::flash('message', 'Education Information Successfully Save.');
        return redirect('org-settings/vw-education');
    }

    public function editViewEducationData($id){
        $data['education'] = DB::table('education_master')->where('ideducation_master',$id)->first();
        return view($this->_routePrefix . '.edit-education', $data);
        //return view('settings/edit-education', $data);
    }
    
    public function editEducationData(Request $request){
        $arrayValue=array(
           "education_name"=>$request->education_name,
        );
        DB::table('education_master')->where('ideducation_master',$request->edu_id)->update($arrayValue);
        Session::flash('message', 'Education Update Success.');
        return redirect('org-settings/vw-education');
       
    }

    public function getDepartment()
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['department_rs'] = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
                return view($this->_routePrefix . '.department', $data);
                //return view('settings/department', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddNewDepartment(Request $request)
    {
        try{
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');

                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $dt = DB::table('department')->where('id', '=', $request->id)->where('department_status', '=', 'active')->get();
                    if (count($dt) > 0) {
                        $data['departments'] = DB::table('department')->where('id', '=', $request->id)->get();
                        return view($this->_routePrefix . '.add-new-department', $data);
                    } else {
                        return redirect('org-settings/add-new-department');
                    }

                } else {
                    return view($this->_routePrefix . '.add-new-department', $data);
                    //return view('settings/add-new-department', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function saveDepartmentData(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $department_name = strtoupper(trim($request->department_name));
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if (is_numeric($department_name) == 1) {
                    Session::flash('message', 'Department Should not be numeric.');
                    return redirect('org-settings/vw-department');

                }

                if ($request->id) {
                    $ckeck_dept = DB::table('department')->where('department_name', $department_name)->where('emid', $Roledata->reg)->where('id', '!=', $request->id)->first();
                    if (!empty($ckeck_dept)) {
                        Session::flash('message', 'Department Already Exists.');
                        return redirect('org-settings/vw-department');
                    }
                    $validator = Validator::make($request->all(), [
                        'department_name' => 'required',
                    ],
                        [
                            'department_name.required' => 'Department Name Required',

                        ]);

                    if ($validator->fails()) {
                        return redirect('org-settings/add-new-department')->withErrors($validator)->withInput();

                    }

                    $data = array(
                        'department_name' => $department_name,

                    );
                    //print_r($data); exit;

                    $dataInsert = DB::table('department')
                        ->where('id', $request->id)
                        ->update($data);
                    Session::flash('message', 'Department Information Successfully Updated.');
                    return redirect('org-settings/vw-department');

                } else {
                    $ckeck_dept = DB::table('department')->where('department_name', $department_name)->where('emid', $Roledata->reg)->first();
                    if (!empty($ckeck_dept)) {

                        Session::flash('message', 'Department Already Exists.');
                        return redirect('org-settings/vw-department');
                    }

                    $validator = Validator::make($request->all(), [
                        'department_name' => 'required',

                    ],
                        [
                            'department_name.required' => 'Department Name Required',

                        ]);

                    if ($validator->fails()) {
                        return redirect('org-settings/add-new-department')->withErrors($validator)->withInput();
                    }
                    $lsatdeptnmdb = DB::table('department')->orderBy('id', 'DESC')->first();
                    if (empty($lsatdeptnmdb)) {
                        $pid = 'D1';
                    } else {
                        $pid = 'D' . ($lsatdeptnmdb->id + 1);
                    }

                    $data = array(
                        'department_name' => strtoupper($request->input('department_name')),
                        'emid' => $Roledata->reg,
                        'department_code' => $pid,
                    );

                    $deptnmdb = DB::table('department')->where('department_name', '=', trim('department_name'))->where('department_status', '=', 'active')->where('emid', $Roledata->reg)->first();

                    if (empty($deptnmdb)) {
                        DB::table('department')->insert($data);
                        Session::flash('message', 'Department Information Successfully Saved.');
                    }
                    return redirect('org-settings/vw-department');

                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getDesignations()
    {
        try {if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            $data['designation_rs'] = DB::Table('designation')
                ->join('department', 'designation.department_code', '=', 'department.id')
                ->where('designation.designation_status', '=', 'active')
                ->where('designation.emid', '=', $Roledata->reg)
                ->select('designation.*', 'department.department_name')
                ->get();
            return view($this->_routePrefix . '.designation', $data);
            //return view('settings/designation', $data);
        } else {
            return redirect('/');
        }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddDesignation(Request $request)
    {
        try {if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            if ($request->id) {
                $data['designation'] = DB::Table('designation')
                    ->join('department', 'designation.department_code', '=', 'department.id')
                    ->where('designation.id', '=', $request->id)

                    ->select('designation.*', 'department.department_name')

                    ->first();

                $data['department'] = DB::Table('department')->where('department_status', '=', 'active')->where('emid', '=', $Roledata->reg)->get();
                return view($this->_routePrefix . '.add-new-designation', $data);
                //return view('settings/add-new-designation', $data);
            } else {

                $data['department'] = DB::Table('department')->where('department_status', '=', 'active')->where('emid', '=', $Roledata->reg)->get();
                return view($this->_routePrefix . '.add-new-designation', $data);
                //return view('settings/add-new-designation', $data);
            }
        } else {
            return redirect('/');
        }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveDesignation(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $lsatdeptnmdb = DB::table('designation')->orderBy('id', 'DESC')->first();
                if (empty($lsatdeptnmdb)) {
                    $pid = 'DE1';
                } else {
                    $pid = 'DE' . ($lsatdeptnmdb->id + 1);
                }
                $dept_code = trim($request['department_code']);
                $designation_name = strtoupper(trim($request['designation_name']));

                if (is_numeric($designation_name) == 1) {
                    Session::flash('message', 'Designation Should not be numeric.');
                    return redirect('org-settings/vw-designation');
                }

                $validator = Validator::make($request->all(), [
                    'department_code' => 'required',
                    // 'designation_code'=>'required|unique:designation,designation_code',
                    'designation_name' => 'required|max:255',
                ],
                    [
                        'department_code.required' => 'Please Select Department',
                        //'designation_code.required'=>'Designation Code Required',
                        'designation_name.required' => 'Designation Name Required',
                        //'designation_code.unique'=>'Designation Code Already Exist'
                    ]);

                if ($validator->fails()) {
                    return redirect('org-settings/designation')->withErrors($validator)->withInput();
                } else {

                    if ($request->id) {
                        $check_designation = DB::table('designation')->where('department_code', $dept_code)->where('designation_name', $request->designation_name)->where('emid', '=', $Roledata->reg)->where('id', '!=', $request->id)->first();
                        if (!empty($check_designation)) {
                            Session::flash('message', 'Alredy Exists.');
                            return redirect('org-settings/vw-designation');
                        }

                        $data = array(
                            'department_code' => $dept_code,
                            'designation_name' => $designation_name,

                            'designation_status' => 'active',
                        );
                        DB::table('designation')->where('id', $request->id)->update($data);
                        Session::flash('message', 'Designation Information Successfully Updated.');
                        return redirect('org-settings/vw-designation');
                    } else {

                        //$data=request()->except(['_token'])+['designation_status' => 'active'];
                        $check_designation = DB::table('designation')->where('department_code', $dept_code)->where('designation_name', $request->designation_name)->where('emid', '=', $Roledata->reg)->first();
                        if (!empty($check_designation)) {
                            Session::flash('message', 'Alredy Exists.');
                            return redirect('org-settings/vw-designation');
                        }

                        $data = array(
                            'department_code' => $dept_code,
                            'designation_code' => $pid,
                            'designation_name' => $designation_name,
                            'emid' => $Roledata->reg,
                            'designation_status' => 'active',
                        );

                        $desigdb = DB::table('designation')->where('department_code', $dept_code)->where('designation_name', '=', $designation_name)->where('designation_status', '=', 'active')->where('emid', '=', $Roledata->reg)->first();

                        if (empty($desigdb)) {

                            DB::table('designation')->insert($data);
                            Session::flash('message', 'Designation Information Successfully saved.');
                        } else {
                            Session::flash('error', 'Designation Information Already Exist.');
                        }
                        return redirect('org-settings/vw-designation');
                    }
                }

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getEmployeeTypes()
    {
        try {

            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['employee_type_rs'] = DB::Table('employee_type')
                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                return view($this->_routePrefix . '.employee-type', $data);
                //return view('settings/employee-type', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddEmployeeType()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                return view($this->_routePrefix . '.add-new-employee-type', $data);
                //return view('settings/add-new-employee-type', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveEmployeeType(Request $request)
    {
        try {

            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $employee_type_name = strtoupper(trim($request->employee_type_name));

                if (is_numeric($employee_type_name) == 1) {
                    Session::flash('message', 'Employee Type Should not be numeric.');
                    return redirect('org-settings/vw-employee-type');

                }
                $employee_type = DB::table('employee_type')->where('employee_type_name', $request->employee_type_name)->where('emid', '=', $Roledata->reg)->first();
                if (!empty($employee_type)) {
                    Session::flash('message', 'Employee Type Alredy Exists.');
                    return redirect('org-settings/vw-employee-type');
                }

                $validator = Validator::make($request->all(), [
                    'employee_type_name' => 'required|max:255',
                ],
                    ['employee_type_name.required' => 'Employee Type Name required']);

                if ($validator->fails()) {
                    return redirect('org-settings/employee-type')->withErrors($validator)->withInput();
                }

                //$data=request()->except(['_token']);

                if (empty($request->id)) {

                    DB::table('employee_type')->insert(
                        ['employee_type_name' => $employee_type_name, 'employee_type_status' => 'Active', 'emid' => $Roledata->reg]
                    );

                    Session::flash('message', 'Employee Type Information Successfully saved.');

                    return redirect('org-settings/vw-employee-type');

                } else {
                    DB::table('employee_type')
                        ->where('id', $request->id)
                        ->update(['employee_type_name' => $employee_type_name]);
                    Session::flash('message', 'Employee Type Information Successfully Updated.');
                    return redirect('org-settings/vw-employee-type');
                }

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function getTypeById($id)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['employee_type'] = DB::table('employee_type')->where('id', $id)->first();
                return view($this->_routePrefix . '.add-new-employee-type', $data);
                //return view('settings/add-new-employee-type', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getGrades()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                // if (Input::get('del')) {
                //     DB::table('grade')
                //         ->where('id', Input::get('del'))
                //         ->update(['grade_status' => 'Trash']);
                //     Session::flash('message', 'paygroup Successfully Deleted.');
                //     return back();
                // }

                $data['grade_rs'] = DB::Table('grade')

                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                return view($this->_routePrefix . '.paylevel', $data);
                //return view('settings/paylevel', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddGrade(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $data['getGrade'] = DB::table('grade')->where('id', '=', $request->id)->get();
                    return view($this->_routePrefix . '.add-new-paylevel', $data);
                    //return view('settings/add-new-paylevel', $data);
                } else {
                    return view($this->_routePrefix . '.add-new-paylevel', $data);
                   // return view('settings/add-new-paylevel', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveGrade(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $grade_name = strtoupper(trim($request->grade_name));

                if (is_numeric($grade_name) == 1) {
                    Session::flash('message', 'pay Group Should not be numeric.');
                    return redirect('org-settings/vw-paygroup');
                }
                if ($request->id) {
                    $check_grade = DB::table('grade')->where('grade_name', $grade_name)->where('id', '!=', $request->id)->where('emid', '=', $Roledata->reg)->first();
                    if (!empty($check_grade)) {
                        Session::flash('message', 'paygroup Alredy Exists.');
                        return redirect('org-settings/vw-paygroup');
                    }
                } else {
                    $check_grade = DB::table('grade')->where('grade_name', $grade_name)->where('emid', '=', $Roledata->reg)->first();
                    if (!empty($check_grade)) {
                        Session::flash('message', 'paygroup Alredy Exists.');
                        return redirect('org-settings/vw-paygroup');
                    }
                }

                $validator = Validator::make($request->all(), [
                    'grade_name' => 'required|max:255',
                ],
                    [
                        'grade_name.required' => 'paygroup Name Required',
                    ]);

                if ($validator->fails()) {
                    return redirect('org-settings/paygroup')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    if ($request->id) {
                        $data = array(
                            'grade_name' => strtoupper($request->grade_name),

                            'grade_status' => $request->grade_status,
                        );
                        DB::table('grade')->where('id', $request->id)->update($data);
                        Session::flash('message', 'Pay Group Information Successfully Updated.');
                        return redirect('org-settings/vw-paygroup');

                    } else {

                        //$data = request()->except(['_token']);
                        $data = array(
                            'grade_name' => strtoupper($request->grade_name),
                            'emid' => $Roledata->reg,
                            'grade_status' => $request->grade_status,
                        );

                        DB::table('grade')->insert($data);
                        //$company->save($data);  //time stamps false in model
                        Session::flash('message', 'Pay Group Information Successfully saved.');
                        return redirect('org-settings/vw-paygroup');
                    }
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getPayscale()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                // dd($Roledata->reg);
                $data['pay_scale_rs'] = DB::Table('pay_scale_master')
                    ->join('grade', 'pay_scale_master.payscale_code', '=', 'grade.id')
                    ->where('grade.grade_status', '=', 'active')
                    ->where('pay_scale_master.emid', '=', $Roledata->reg)
                    ->select('pay_scale_master.*', 'grade.grade_name')
                    ->get();
                // dd($data['pay_scale_rs']);
                return view($this->_routePrefix . '.payscale', $data);
                //return view('settings/payscale', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddPayscale(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                if ($request->id) {
                    $data['paygroup_rs'] = DB::Table('grade')->where('emid',$data['Roledata']->reg)
                        ->get();

                    $data['getPayscale'] = DB::table('pay_scale_master')->where('id', '=', $request->id)->get();
                    $data['getPaybac'] = DB::table('pay_scale_basic_master')->where('pay_scale_master_id', '=', $request->id)->orderBy('id', 'Asc')->get();
                    return view($this->_routePrefix . '.add-new-payscale', $data);
                    //return view('settings/add-new-payscale', $data);
                } else {
                    $data['paygroup_rs'] = DB::Table('grade')->where('emid',$data['Roledata']->reg)
                        ->get();
                    return view($this->_routePrefix . '.add-new-payscale', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function savePayscale(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $grade_name = $request->payscale_code;

                if ($request->id) {
                    $check_grade = DB::table('pay_scale_master')->where('payscale_code', $grade_name)->where('id', '!=', $request->id)->where('emid', '=', $Roledata->reg)->first();
                    if (!empty($check_grade)) {
                        Session::flash('message', 'Annual Pay Alredy Exists.');
                        return redirect('org-settings/vw-annualpay');
                    }
                } else {
                    $check_grade = DB::table('pay_scale_master')->where('payscale_code', $grade_name)->where('emid', '=', $Roledata->reg)->first();
                    if (!empty($check_grade)) {
                        Session::flash('message', 'Annual Pay Alredy Exists.');
                        return redirect('org-settings/vw-annualpay');
                    }
                }

                $validator = Validator::make($request->all(), [
                    'payscale_code' => 'required|max:255',
                ],
                    [
                        'payscale_code.required' => 'Annual Pay Name Required',
                    ]);

                if ($validator->fails()) {
                    return redirect('org-settings/annualpay')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    if ($request->id) {
                        $data = array(
                            'payscale_code' => $request->payscale_code,

                        );

                        $tot_item = count($request->pay_scale_basic);
                        DB::table('pay_scale_basic_master')->where('pay_scale_master_id', '=', $request->id)->delete();
                        for ($i = 0; $i < $tot_item; $i++) {
                            $datapay = array(
                                'pay_scale_master_id' => $request->id,
                                'pay_scale_basic' => $request->pay_scale_basic[$i],

                            );
                            DB::table('pay_scale_basic_master')->insert($datapay);
                        }

                        DB::table('pay_scale_master')->where('id', $request->id)->update($data);
                        Session::flash('message', 'Annual Pay Information Successfully Updated.');
                        return redirect('org-settings/vw-annualpay');

                    } else {

                        //$data = request()->except(['_token']);
                        $data = array(
                            'payscale_code' => $request->payscale_code,
                            'emid' => $Roledata->reg,

                        );
                        DB::table('pay_scale_master')->insert($data);
                        $lastdata = DB::table('pay_scale_master')

                            ->where('payscale_code', '=', $request->payscale_code)
                            ->first();

                        $tot_item = count($request->pay_scale_basic);

                        for ($i = 0; $i < $tot_item; $i++) {
                            $datapay = array(
                                'pay_scale_master_id' => $lastdata->id,
                                'pay_scale_basic' => $request->pay_scale_basic[$i],

                            );
                            DB::table('pay_scale_basic_master')->insert($datapay);
                        }

                        //$company->save($data);  //time stamps false in model
                        Session::flash('message', 'Annual Pay Information Successfully saved.');
                        return redirect('org-settings/vw-annualpay');
                    }
                }

            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getBanks()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['bank_rs'] = DB::table('bank')
                    ->where('bank.emid', '=', $Roledata->reg)
                    ->select('bank_masters.master_bank_name', 'bank.*')
                    ->join('bank_masters', 'bank.bank_name', '=', 'bank_masters.id')
                    ->get();
                return view($this->_routePrefix . '.view-banks', $data);
                //return view('settings/view-banks', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddBank(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                if ($request->id) {

                    $bankid = $request->id;
                    $data['bankdetails'] = DB::table('bank')->where('id', $bankid)->get()->toArray();
                    $data['MastersbankName'] = DB::table('bank_masters')->get();
                    //print_r($data['MastersbankName']);die;
                    return view($this->_routePrefix . '.add-bank', $data);
                    //return view('settings/add-bank', $data);
                } else {
                    $data['MastersbankName'] = DB::table('bank_masters')->get();
                    //print_r($data['master_bank_name']); exit;
                    return view($this->_routePrefix . '.add-bank', $data);
                    //return view('settings/add-bank', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveBank(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->bankid) {

                    $data = array(
                        'bank_name' => $request->bank_name,
                        'bank_sort' => $request->bank_sort,

                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'bank_status' => 'active',
                    );
                    DB::table('bank')->where('id', $request->bankid)->update($data);
                    Session::flash('message', 'Bank Information Successfully Updated.');
                    return redirect('org-settings/vw-bank-sortcode');
                } else {
                    $validator = Validator::make($request->all(), [
                        'bank_name' => 'required|max:255',
                        'bank_sort' => 'required|max:255',

                    ],
                        [
                            'bank_name.required' => 'Bank Name Required.',
                            'bank_sort.required' => 'Branch name Required',
                            'bank_sort.unique' => 'Branch name already exsits',

                        ]);

                    if ($validator->fails()) {
                        return redirect('org-settings/bank-sortcode')
                            ->withErrors($validator)
                            ->withInput();
                    } else {
                        $data = array(
                            'bank_name' => $request->bank_name,
                            'bank_sort' => $request->bank_sort,

                            'emid' => $Roledata->reg,
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'bank_status' => 'active',
                        );

                        DB::table('bank')->insert($data);
                        Session::flash('message', 'Bank Information Successfully saved.');
                        return redirect('org-settings/vw-bank-sortcode');
                    }
                }

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getPaytypemaster()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['paytype_rs'] = DB::Table('payment_type_master')

                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                return view($this->_routePrefix . '.pay-type', $data);
                //return view('settings/pay-type', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddPaytypemaster(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                if ($request->id) {

                    $bankid = $request->id;
                    $data['paytypedetails'] = DB::table('payment_type_master')->where('id', $bankid)->get()->toArray();

                    //print_r($data['MastersbankName']);die;
                    return view($this->_routePrefix . '.add-pay-type', $data);
                    //return view('settings/add-pay-type', $data);
                } else {

                    //print_r($data['master_bank_name']); exit;
                    return view($this->_routePrefix . '.add-pay-type');
                    //return view('settings/add-pay-type');
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function savePaytypemaster(Request $request)
    {
        try {if (!empty(Session::get('emp_email'))) {

            $email = Session::get('emp_email');
            $Roledata = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                ->where('email', '=', $email)
                ->first();

            if ($request->paytypeid) {

                $data = array(
                    'pay_type' => $request->pay_type,
                    'work_hour' => $request->work_hour,

                    'rate' => $request->rate,
                );
                DB::table('payment_type_master')->where('id', $request->paytypeid)->update($data);
                Session::flash('message', 'Pay type Information Successfully Updated.');
                return redirect('org-settings/vw-pay-type');
            } else {
                $validator = Validator::make($request->all(), [
                    'pay_type' => 'required|max:255',

                ],
                    [
                        'pay_type.required' => 'Payment Type Required.',

                    ]);

                if ($validator->fails()) {
                    return redirect('org-settings/pay-type')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    $data = array(
                        'pay_type' => $request->pay_type,
                        'work_hour' => $request->work_hour,

                        'rate' => $request->rate,
                        'emid' => $Roledata->reg,

                    );

                    DB::table('payment_type_master')->insert($data);
                    Session::flash('message', 'Pay type Information Successfully saved.');
                    return redirect('org-settings/vw-pay-type');
                }
            }
        } else {
            return redirect('/');
        }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function getwedgesPaytypemaster()
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['paytype_rs'] = DB::Table('payment_type_wedes')

                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                return view($this->_routePrefix . '.wedgespay-type', $data);
                //return view('settings/wedgespay-type', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddwedgesPaytypemaster(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                
                if ($request->id) {
                    $bankid = $request->id;
                    $bankid = base64_decode($bankid);
                    $data['paytypedetails'] = DB::table('payment_type_wedes')->where('id', $bankid)->get()->toArray();
                    return view($this->_routePrefix . '.add-wedgespay-type', $data);
                    //return view('settings/add-wedgespay-type', $data);
                } else {
                    return view($this->_routePrefix . '.add-wedgespay-type');
                    //return view('settings/add-wedgespay-type');
                }
            
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function savewedgesPaytypemaster(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->paytypeid) {

                    $data = array(
                        'pay_type' => $request->pay_type,

                    );
                    DB::table('payment_type_wedes')->where('id', $request->paytypeid)->update($data);
                    Session::flash('message', 'Wedges pay mode Information Successfully Updated.');
                    return redirect('org-settings/vw-wedgespay-type');
                } else {

                    $data = array(
                        'pay_type' => $request->pay_type,

                        'emid' => $Roledata->reg,

                    );

                    DB::table('payment_type_wedes')->insert($data);
                    Session::flash('message', 'Wedges pay mode Information Successfully saved.');
                    return redirect('org-settings/vw-wedgespay-type');

                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }

    }

    public function getTaxmaster()
    {
        try {
            if (!empty(Session::get('emp_email'))) {

                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                $data['tax_rs'] = DB::Table('tax_master')

                    ->where('emid', '=', $Roledata->reg)
                    ->get();
                return view($this->_routePrefix . '.taxmas', $data);
                //return view('settings/taxmas', $data);

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddTaxmaster(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                if ($request->id) {

                    $bankid = $request->id;
                    $data['taxdetails'] = DB::table('tax_master')->where('id', $bankid)->get()->toArray();

                    //print_r($data['MastersbankName']);die;
                    return view($this->_routePrefix . '.add-tax', $data);
                    //return view('settings/add-tax', $data);
                } else {

                    //print_r($data['master_bank_name']); exit;
                    return view($this->_routePrefix . '.add-tax');
                    //return view('settings/add-tax');
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveTaxmaster(Request $request)
    {
        try {
            if (!empty(Session::get('emp_email'))) {
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();

                if ($request->taxid) {

                    $data = array(
                        'tax_code' => $request->tax_code,
                        'per_de' => $request->per_de,

                        'tax_ref' => $request->tax_ref,
                    );
                    DB::table('tax_master')->where('id', $request->taxid)->update($data);
                    Session::flash('message', 'Tax Information Successfully Updated.');
                    return redirect('org-settings/vw-tax');
                } else {
                    $validator = Validator::make($request->all(), [
                        'tax_code' => 'required|max:255',
                        'per_de' => 'required|max:255',
                        'tax_ref' => 'required|max:255',

                    ],
                        [
                            'per_de.required' => 'Tax Code Required.',
                            'per_de.required' => 'Percentage of Deduction Required',
                            'tax_ref.required' => 'Tax Reference Required',

                        ]);

                    if ($validator->fails()) {
                        return redirect('org-settings/tax')
                            ->withErrors($validator)
                            ->withInput();
                    } else {
                        $data = array(
                            'tax_code' => $request->tax_code,
                            'per_de' => $request->per_de,

                            'tax_ref' => $request->tax_ref,
                            'emid' => $Roledata->reg,

                        );

                        DB::table('tax_master')->insert($data);
                        Session::flash('message', 'Tax Information Successfully saved.');
                        return redirect('org-settings/vw-tax');
                    }
                }

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }










} // End Class
