<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
class AppSettingController extends Controller
{
     public function viewdash()
    {
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
               $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				
      	return View('settings/dashboard',$data);        
       }
       else
       {
            return redirect('/');
       }
    }

public function getCompanies()
	{
		  $email = Session::get('emp_email'); 
		$data['companies_rs']= DB::table('registration')      
                 
                  ->where('email','=',$email) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
		return view('settings/company', $data);	
	} 
	public function viewAddCompany()
	{
            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
               $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				
      	return View('settings/edit-company',$data);        
       }
       else
       {
            return redirect('/');
       }
           
	}

public function saveCompany(Request $request)
	{        
            
		
		if(is_numeric($request->com_name)==1){
			Session::flash('message','Company Name Should not be numeric.');
		    return redirect('settings/edit-company?c_id='.$request->id);
		}
		

		$validator = Validator::make($request->all(), [
		'com_name'	=>'required|max:100',
		'f_name'	=>'required|max:100',
		'l_name'	=>'required|max:100',
		'address'=>'required|max:255',
		'p_no'	=>'required',
		'pan'	=>'required',
		
        ],
		[
		 'com_name.required'=>'Company Name Required',
		 'f_name.required'=>'First Name Required',
		 'l_name.required'=>'Last Name Required',
		 'address.required'=>'Company Address Required',
		 'p_no.required'=>'Company Phone Required',
		
		 'pan.required'=>'Company Pan Required',

		]);
		
		if ($validator->fails()) {
            return redirect('settings/edit-company?c_id='.$request->id)
                        ->withErrors($validator)
                        ->withInput();
        }
		
		    else
                 {
					 
					   $email = Session::get('emp_email'); 
					 if($request->has('image')){

            $file = $request->file('image');
            $extension = $request->image->extension();
            $path = $request->image->store('employee','public');
            $dataimg=array(
                 'logo'=>$path,
                );
				  DB::table('registration')->where('email',$email)->update($dataimg);
        }

                    
$data=array(
                'com_name'=>$request->com_name,
                'f_name'=>$request->f_name,

                'l_name'=>$request->l_name,
				
				  'p_no'=>$request->p_no,
                 'pan'=>$request->pan,
				 'address'=>$request->address,
				  'website'=>$request->website,
				   'fax'=>$request->fax,
                );



                DB::table('registration')->where('email',$email)->update($data);
                  
					Session::flash('message','Company Information Successfully saved.');
		return redirect('settings/company');
                 }
                
	
		
		
	}
	
  
	public function getDepartment($emp_id)
	{
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
						   
		 $data['department_rs']=  DB::table('department')  ->where('emid', '=', $Roledata->reg )->get();
		  $data['emid']=base64_decode($emp_id) ;
		return view('appsettings/department',$data);
               
	}
		public function getDesignations($emp_id)
	{
	
		$Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                 ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
						
						  $data['emid']=base64_decode($emp_id) ; 
						  
		$data['designation_rs']=DB::Table('designation')
        ->join('department', 'designation.department_code', '=', 'department.id')
        ->where('designation.designation_status','=','active')
		->where('designation.emid', '=', $Roledata->reg )
        ->select('designation.*', 'department.department_name')
        ->get();      
		return view('appsettings/designation',$data);
	}
	public function viewAddNewDepartment($emp_id)
	{
    
                 
               $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
                   $data['emid']=base64_decode($emp_id) ;
                if(Input::get('id'))
                {
                    $dt=DB::table('department')->where('id','=',Input::get('id'))->where('department_status','=','active')->get();
                 if(count($dt)>0){
                      $data['departments']=DB::table('department')->where('id','=',Input::get('id'))->get();
          
                     return view('appsettings/add-new-department',$data);
                 }else{
                     return redirect('appsettings/add-new-department');
                 }
                
                }
                else
                {
                     return view('appsettings/add-new-department',$data);
                }
                
	}
	
	
	
	public function saveDepartmentData(Request $request)
	{
        $department_name= strtoupper(trim($request->department_name));
		 
		 $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
		if(is_numeric($department_name)==1){
			Session::flash('message','Department Should not be numeric.');
		    return redirect('appsettings/vw-department/'.base64_encode($request->emid));
		}
		
	
         
        if(Input::get('id'))
        {
           	$ckeck_dept=DB::table('department')->where('department_name', $department_name)->where('emid', $Roledata ->reg) ->where('id', '!=', Input::get('id'))->first();
		if(!empty($ckeck_dept)){
			Session::flash('message','Department Already Exists.');
		    return redirect('appsettings/vw-department/'.base64_encode($request->emid));
		}
           $validator=Validator::make($request->all(),[
		'department_name'=>'required'
		],
		[
		'department_name.required'=>'Department Name Required'
			
		]);
		
		if($validator->fails())
		{
			return redirect('appsettings/add-new-department/'.base64_encode($request->emid))->withErrors($validator)->withInput();
			
		}
                    
        $data=array(
        'department_name'=>$department_name,
       
        );
        //print_r($data); exit;

        $dataInsert=DB::table('department')  
        ->where('id', Input::get('id'))
        ->update($data);
        Session::flash('message','Department Information Successfully Updated.');
        return redirect('appsettings/vw-department/'.base64_encode($request->emid));
        
        
        }
        else
        {
            	$ckeck_dept=DB::table('department')->where('department_name', $department_name)->where('emid', $Roledata ->reg)->first();
		if(!empty($ckeck_dept)){
		  
			Session::flash('message','Department Already Exists.');
		    return redirect('appsettings/vw-department/'.base64_encode($request->emid));
		}
            
         $validator=Validator::make($request->all(),[
		'department_name'=>'required'
				
		],
		[
		'department_name.required'=>'Department Name Required'
					
		]);
		
		if($validator->fails())
		{
			return redirect('appsettings/add-new-department/'.base64_encode($request->emid))->withErrors($validator)->withInput();
		}
	$lsatdeptnmdb=DB::table('department')->orderBy('id', 'DESC')->first();
	if(empty($lsatdeptnmdb)){
    $pid='D1';
}else{
    $pid='D'.($lsatdeptnmdb->id+1);
}    

        $data=array(
        'department_name'=>strtoupper($request->input('department_name')),
       'emid'=>$Roledata ->reg,
	   'department_code'=>$pid ,
        );


        
               
		
		$deptnmdb=DB::table('department')->where('department_name','=',trim(Input::get('department_name')))->where('department_status','=','active')->where('emid', $Roledata ->reg)->first();
        
		if(empty($deptnmdb)){
		DB::table('department')->insert($data);
		Session::flash('message','Department Information Successfully Saved.');
	    }
		return redirect('appsettings/vw-department/'.base64_encode($request->emid));
	
         }
                
       }
	   
	   public function viewAddDesignation($emp_id)
	{ 
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
               ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
						   
		  $data['emid']=base64_decode($emp_id) ;
	      if(Input::get('id'))
	      {
	          $data['designation']=DB::Table('designation')
		        ->join('department', 'designation.department_code', '=', 'department.id')
		        ->where('designation.id','=',Input::get('id'))
				
		        ->select('designation.*', 'department.department_name')
				
		        ->first();
		      
	          $data['department']=DB::Table('department')->where('department_status','=','active') ->where('emid', '=', $Roledata->reg )->get();
	          return view('appsettings/add-new-designation', $data);
	      }else{
			  
			$data['department']=DB::Table('department')->where('department_status','=','active') ->where('emid', '=', $Roledata->reg )->get();
		
			return view('appsettings/add-new-designation',$data);
	      }
	}
	
	public function saveDesignation(Request $request)
	{
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                   ->where('reg','=',$request->emid) 
                  ->first();
						   
	$lsatdeptnmdb=DB::table('designation')->orderBy('id', 'DESC')->first();
	if(empty($lsatdeptnmdb)){
    $pid='DE1';
}else{
    $pid='DE'.($lsatdeptnmdb->id+1);
}    
		$dept_code=trim($request['department_code']);
		$designation_name=strtoupper(trim($request['designation_name']));

		
		if(is_numeric($designation_name)==1){
			Session::flash('message','Designation Should not be numeric.');
		    return redirect('appsettings/vw-designation/'.base64_encode($request->emid));
		}
		
	
		$validator=Validator::make($request->all(),[
                    'department_code'=>'required',
                   // 'designation_code'=>'required|unique:designation,designation_code',
					'designation_name'=>'required|max:255'
					],
					[
					'department_code.required'=>'Please Select Department',
					//'designation_code.required'=>'Designation Code Required',
					'designation_name.required'=>'Designation Name Required'
			        //'designation_code.unique'=>'Designation Code Already Exist'  
					]);
		
		if($validator->fails())
		{
			return redirect('appsettings/designation/'.base64_encode($request->emid))->withErrors($validator)->withInput();
		}
        else
        {
                   
            if(Input::get('id'))
            {
                	$check_designation=DB::table('designation')->where('department_code', $dept_code)->where('designation_name', $request->designation_name) ->where('emid', '=', $Roledata->reg )->where('id','!=',Input::get('id'))->first();
		if(!empty($check_designation)){
			Session::flash('message','Alredy Exists.');
		    return redirect('appsettings/vw-designation/'.base64_encode($request->emid));
		}
		
                  
                $data=array(
                   	'department_code'=>$dept_code,
					'designation_name'=>$designation_name,
				
					'designation_status'=>'active',
                    );
				  DB::table('designation')->where('id',Input::get('id'))->update($data);
                  Session::flash('message','Designation Information Successfully Updated.');
			 return redirect('appsettings/vw-designation/'.base64_encode($request->emid));
            }else{ 

                  	//$data=request()->except(['_token'])+['designation_status' => 'active'];
                  		$check_designation=DB::table('designation')->where('department_code', $dept_code)->where('designation_name', $request->designation_name) ->where('emid', '=', $Roledata->reg )->first();
		if(!empty($check_designation)){
			Session::flash('message','Alredy Exists.');
		   return redirect('appsettings/vw-designation/'.base64_encode($request->emid));
		}
		
                  	$data=array(
                   	'department_code'=>$dept_code,
					'designation_code'=>$pid,
					'designation_name'=>$designation_name,
				'emid'=>$Roledata->reg,
					'designation_status'=>'active',
                    );
                  
					
					$desigdb=DB::table('designation')->where('department_code', $dept_code)->where('designation_name','=',$designation_name)->where('designation_status','=','active') ->where('emid', '=', $Roledata->reg )->first();
        
		           if(empty($desigdb)){
		              
					DB::table('designation')->insert($data);
					Session::flash('message','Designation Information Successfully saved.');
				   }else{
				   	Session::flash('settings','Designation Information Already Exist.');
				   }
				 return redirect('appsettings/vw-designation/'.base64_encode($request->emid));
            }
        }

        
	}
	
	public function getEmployeeTypes($emp_id)
	{  $data['emid']=base64_decode($emp_id) ;
		$Roledata = DB::table('registration')->where('status','=','active')       
               
                 ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                 ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
						   
		$data['employee_type_rs']=DB::Table('employee_type')
		  ->where('emid','=',$Roledata->reg) 
		->get();
		
		return view('appsettings/employee-type', $data);
	}
public function viewAddEmployeeType($emp_id)
	{
	    
	    $data['emid']=base64_decode($emp_id) ;
		$email = Session::get('emp_email');
		$Roledata = DB::table('registration')->where('status','=','active')       
                 
                ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
               ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
		
		return view('appsettings/add-new-employee-type', $data);
	}
	
public function saveEmployeeType(Request $request)
	{
	
		$Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
		$employee_type_name= strtoupper(trim($request->employee_type_name));
		
		if(is_numeric($employee_type_name)==1){
			Session::flash('message','Employee Type Should not be numeric.');
		    return redirect('appsettings/vw-employee-type/'.base64_encode($request->emid));
			
		}
		
		$validator=Validator::make($request->all(),[
			'employee_type_name'=>'required|max:255'
		],
		['employee_type_name.required'=>'Employee Type Name required']);
		
		if($validator->fails())
		{
			return redirect('appsettings/employee-type/'.base64_encode($request->emid))->withErrors($validator)->withInput();			
		}
		
		//$data=request()->except(['_token']);
		
		

		if(empty($request->id)){
		     $employee_type=DB::table('employee_type')->where('employee_type_name', $request->employee_type_name) ->where('emid', '=', $Roledata->reg )->first();
	
		 
	if(!empty($employee_type)){
	    
			Session::flash('message','Employee Type Alredy Exists.');
		    return redirect('appsettings/vw-employee-type/'.base64_encode($request->emid));
		}
			DB::table('employee_type')->insert(
			    ['employee_type_name' => $employee_type_name,'employee_type_status' => 'Active','emid' => $Roledata->reg]
			);
			

            Session::flash('message','Employee Type Information Successfully saved.');
			
			return redirect('appsettings/vw-employee-type/'.base64_encode($request->emid));

		}else{
		   
   $employee_type=DB::table('employee_type')->where('employee_type_name', $request->employee_type_name) ->where('emid', '=', $Roledata->reg )  ->where('id','!=', $request->id)->first();
	

		    	if(!empty($employee_type)){
			Session::flash('message','Employee Type Alredy Exists.');
		    return redirect('appsettings/vw-employee-type/'.base64_encode($request->emid));
		}
			DB::table('employee_type')
            ->where('id', $request->id)
            ->update(['employee_type_name' => $employee_type_name]);
            Session::flash('message','Employee Type Information Successfully Updated.');
		    return redirect('appsettings/vw-employee-type/'.base64_encode($request->emid));
		}
		
		
		
	}
		public function getTypeById($emp_id,$id)
	{
		$data['emid']=base64_decode($emp_id) ;
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                 ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
               ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
		$data['employee_type']=DB::table('employee_type')->where('id', $id)->first();
	
		return view('appsettings/add-new-employee-type', $data);
	}
	
	
	
	public function getGrades($emp_id)
	{
		$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
             if(Input::get('del'))
             {
                  DB::table('grade')
            ->where('id', Input::get('del'))
            ->update(['grade_status' => 'Trash']);
                   Session::flash('message','paygroup Successfully Deleted.');
                  return back();
             }
            
		$data['grade_rs']=DB::Table('grade')
                        
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
      
		return view('appsettings/paylevel',  $data);
	}
	    //
  	public function viewAddGrade($emp_id)
  	{
		
		$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
               if(Input::get('id'))
               {
                   $data['getGrade']=DB::table('grade')->where('id','=',Input::get('id'))->get();
                   return view('appsettings/add-new-paylevel',$data);
               }else{
  		
  		return view('appsettings/add-new-paylevel',$data);
               }
  	}
	
	
	 public function saveGrade(Request $request)
	  {

     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                ->where('reg','=',$request->emid) 
                  ->first();
      $grade_name= strtoupper(trim($request->grade_name));

    
    if(is_numeric($grade_name)==1){
      Session::flash('message','pay Group Should not be numeric.');
      return redirect('appsettings/vw-paygroup/'.base64_encode($request->emid));
    }
 if(Input::get('id'))
              { 
  $check_grade=DB::table('grade')->where('grade_name', $grade_name)->where('id','!=',Input::get('id'))->where('emid','=',$Roledata->reg ) ->first();
    if(!empty($check_grade)){
      Session::flash('message','paygroup Alredy Exists.');
        return redirect('appsettings/vw-paygroup/'.base64_encode($request->emid));
    }		  
			  }else{
				  $check_grade=DB::table('grade')->where('grade_name', $grade_name)->where('emid','=',$Roledata->reg ) ->first();
    if(!empty($check_grade)){
      Session::flash('message','paygroup Alredy Exists.');
        return redirect('appsettings/vw-paygroup/'.base64_encode($request->emid));
    }  
			  }
  




		
		$validator = Validator::make($request->all(), [
		'grade_name' => 'required|max:255'		
                 ],
		[
		 'grade_name.required'=>'paygroup Name Required'
		]);
		
            if ($validator->fails()) 
            {
            return redirect('appsettings/paygroup/'.base64_encode($request->emid))
            ->withErrors($validator)
            ->withInput();
            }
            else
            {
              if(Input::get('id'))
              {  
                  $data=array(
                    'grade_name'=>strtoupper($request->grade_name),
                    
                    'grade_status'=>$request->grade_status,
                   );
                 DB::table('grade')->where('id',Input::get('id'))->update($data);
                  Session::flash('message','Pay Group Information Successfully Updated.');
              return redirect('appsettings/vw-paygroup/'.base64_encode($request->emid));
                  
              }
              else
              {
                    
        		//$data = request()->except(['_token']);
            $data=array(
                        'grade_name'=>strtoupper($request->grade_name),
                        'emid' =>$Roledata->reg ,
						 'grade_status'=>$request->grade_status,
                       );
        		
        		
        		 DB::table('grade')->insert($data);
        		//$company->save($data);  //time stamps false in model
        		Session::flash('message','Pay Group Information Successfully saved.');
        		return redirect('appsettings/vw-paygroup/'.base64_encode($request->emid));
                          }
                        }
        	}
         public function getRateList() 
    {
		$email = Session::get('emp_email');
		$Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				   $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
        $data['ratelist'] = DB::table('rate_details')
            ->join('rate_master', 'rate_details.rate_id', '=', 'rate_master.id')
			->where('rate_details.emid','=',$Roledata->reg )
            ->select('rate_details.*',  'rate_master.head_name')
            ->get();
         
        return view('settings/rate',$data);
    } 	
	 public function getRateChart($rate_id) 
    {   $email = Session::get('emp_email');
		$Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				   $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
        $data['ratedtl'] = DB::table('rate_details')
            ->join('rate_master', 'rate_details.rate_id', '=', 'rate_master.id')
             ->where('rate_details.id', '=', $rate_id)
			
            ->select('rate_details.*',  'rate_master.head_name')
            ->get();
        return view('settings/add-new-rate',$data);
    }
	
	 public function saveRateChart(Request $request) {

      $request->validate([
        'inpercentage'=>'required|numeric',
        'inrupees'=>'required|numeric'
      ]);
      $data=array(
      'id'=>$request->id,
      'inpercentage'=>$request->inpercentage,
      'inrupees'=> $request->inrupees
      );
      
        DB::table('rate_details')
        ->where('id', $request->id)
        ->update(['inpercentage' =>$request['inpercentage'],
        'inrupees'=>$request['inrupees']]);
      //return back()->with('success','Rate Save successfully');
        Session::flash('message','Pay Item Details Successfully Updated.');
        //return back();
        return redirect('settings/payitemlist');   
    }
	public function getBanks($emp_id)
	{
		
		   	$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
		 $data['bank_rs']=  	 DB::table('bank')
		 ->where('bank.emid', '=', $Roledata->reg )
    			->select('bank_masters.master_bank_name','bank.*')
                 ->join('bank_masters','bank.bank_name','=','bank_masters.id')
                 ->get();
	
		 
		
		return view('appsettings/view-banks', $data);	
	}
	 
	public function viewAddBank($emp_id)
	{ 	$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
		if(Input::get('id')){

			$bankid= Input::get('id');
			$data['bankdetails']= DB::table('bank')->where('id',$bankid)->get()->toArray();
			$data['MastersbankName']=DB::table('bank_masters')->get();
			//print_r($data['MastersbankName']);die;
			
			return view('appsettings/add-bank', $data);	
		}else{
			$data['MastersbankName']=DB::table('bank_masters')->get();
			//print_r($data['master_bank_name']); exit;
			return view('appsettings/add-bank', $data);	
		}
			
	}
	
	
	
	public function saveBank(Request $request)
	{
	   
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                 ->where('reg','=',$request->emid) 
                  ->first();
		
		if($request->bankid)
        {
              
            $data=array(
               	'bank_name'=>$request->bank_name,
				'bank_sort'=>$request->bank_sort,
				
				'created_at'=>date('Y-m-d h:i:s'),
				'updated_at'=>date('Y-m-d h:i:s'),
				'bank_status'=>'active',
                );
			 DB::table('bank')  ->where('id',$request->bankid)->update($data);
            Session::flash('message','Bank Information Successfully Updated.');
			return redirect('appsettings/vw-bank/'.base64_encode($request->emid));
        }else{ 
			$validator=Validator::make($request->all(),[
			'bank_name'=>'required|max:255',
			'bank_sort'=>'required|max:255',
			
			],
			[
			'bank_name.required'=>'Bank Name Required.',
			'bank_sort.required'=>'Branch name Required',
			'bank_sort.unique'=>'Branch name already exsits',
			
			]);
			
			if ($validator->fails()) {
	           return redirect('appsettings/vw-bank/'.base64_encode($request->emid))
	                        ->withErrors($validator)
	                        ->withInput();
	        }else{
	        	 $data=array(
               	'bank_name'=>$request->bank_name,
				'bank_sort'=>$request->bank_sort,
				
				'emid'=>$Roledata->reg,
				'created_at'=>date('Y-m-d h:i:s'),
				'updated_at'=>date('Y-m-d h:i:s'),
				'bank_status'=>'active',
                );
	            	
					
					 DB::table('bank')->insert($data);
					Session::flash('message','Bank Information Successfully saved.');
					 return redirect('appsettings/vw-bank/'.base64_encode($request->emid));
			}
        }
		
		
	}	
	
	
	public function getPayscale($emp_id)
	{
		$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                   ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
           
            
		$data['pay_scale_rs']=DB::Table('pay_scale_master')
                        ->join('grade', 'pay_scale_master.payscale_code', '=', 'grade.id')
        ->where('grade.grade_status','=','active')
		->where('pay_scale_master.emid','=',$Roledata->reg ) 
        ->select('pay_scale_master.*', 'grade.grade_name')
						
		                    ->get();
      
		return view('appsettings/payscale',  $data);
	}
	public function viewAddPayscale($emp_id)
  	{
		
			$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                   ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
           
               if(Input::get('id'))
               {
				   $data['paygroup_rs']=DB::Table('grade')
                        ->where('grade_status','=','active' ) 
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
							
                   $data['getPayscale']=DB::table('pay_scale_master')->where('id','=',Input::get('id'))->get();
				    $data['getPaybac']=DB::table('pay_scale_basic_master')->where('pay_scale_master_id','=',Input::get('id'))->orderBy('id', 'Asc')->get();
					
                   return view('appsettings/add-new-payscale',$data);
               }else{
  		 $data['paygroup_rs']=DB::Table('grade')
                        ->where('grade_status','=','active' ) 
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
  		return view('appsettings/add-new-payscale',$data);
               }
  	}
	
	
	
	
	
	
		 public function savePayscale(Request $request)
	  {
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                   ->where('reg','=',$request->emid) 
                  ->first();
      $grade_name= $request->payscale_code;

    
   
 if(Input::get('id'))
              { 
  $check_grade=DB::table('pay_scale_master')->where('payscale_code', $grade_name)->where('id','!=',Input::get('id'))->where('emid','=',$Roledata->reg ) ->first();
    if(!empty($check_grade)){
      Session::flash('message','Annual Pay Alredy Exists.');
        return redirect('appsettings/vw-annualpay/'.base64_encode($request->emid));
    }		  
			  }else{
				  $check_grade=DB::table('pay_scale_master')->where('payscale_code', $grade_name)->where('emid','=',$Roledata->reg ) ->first();
    if(!empty($check_grade)){
      Session::flash('message','Annual Pay Alredy Exists.');
        return redirect('appsettings/vw-annualpay/'.base64_encode($request->emid));
    }  
			  }
  




		
		$validator = Validator::make($request->all(), [
		'payscale_code' => 'required|max:255'		
                 ],
		[
		 'payscale_code.required'=>'Annual Pay Name Required'
		]);
		
            if ($validator->fails()) 
            {
            return redirect('appsettings/vw-annualpay/'.base64_encode($request->emid))
            ->withErrors($validator)
            ->withInput();
            }
            else
            {
              if(Input::get('id'))
              {  
                  $data=array(
                    'payscale_code'=>$request->payscale_code,
                    
                    
                   );
				   
				    $tot_item=count($request->pay_scale_basic);
        		DB::table('pay_scale_basic_master')->where('pay_scale_master_id', '=', Input::get('id'))->delete();
        		for($i=0;$i<$tot_item;$i++)
    {
 $datapay=array(
                        'pay_scale_master_id'=>Input::get('id'),
                        'pay_scale_basic' =>$request->pay_scale_basic[$i],
						 
                       );
 DB::table('pay_scale_basic_master')->insert($datapay);
	}
				   
                 DB::table('pay_scale_master')->where('id',Input::get('id'))->update($data);
                  Session::flash('message','Annual Pay Information Successfully Updated.');
              return redirect('appsettings/vw-annualpay/'.base64_encode($request->emid));
                  
              }
              else
              {
                    
        		//$data = request()->except(['_token']);
            $data=array(
                        'payscale_code'=>$request->payscale_code,
                        'emid' =>$Roledata->reg ,
						 
                       );
					    DB::table('pay_scale_master')->insert($data);
						$lastdata = DB::table('pay_scale_master')      
                 
                  ->where('payscale_code','=',$request->payscale_code) 
                  ->first();
				   
					    $tot_item=count($request->pay_scale_basic);
        		
        		for($i=0;$i<$tot_item;$i++)
    {
 $datapay=array(
                        'pay_scale_master_id'=>$lastdata->id,
                        'pay_scale_basic' =>$request->pay_scale_basic[$i],
						 
                       );
 DB::table('pay_scale_basic_master')->insert($datapay);
	}
        		
        		//$company->save($data);  //time stamps false in model
        		Session::flash('message','Annual Pay Information Successfully saved.');
        	 return redirect('appsettings/vw-annualpay/'.base64_encode($request->emid));
                          }
                        }
        	}
			
			
			
				public function getTaxmaster($emp_id)
	{
	$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
        
		$data['tax_rs']=DB::Table('tax_master')
                        
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
      
		return view('appsettings/taxmas',  $data);
	}
		public function viewAddTaxmaster($emp_id)
	{
	  
	$data['emid']=base64_decode($emp_id) ;
	 
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
		if(Input::get('id')){

			$bankid= Input::get('id');
			$data['taxdetails']= DB::table('tax_master')->where('id',$bankid)->get()->toArray();
			
			//print_r($data['MastersbankName']);die;
			
			return view('appsettings/add-tax', $data);	
		}else{
		
			//print_r($data['master_bank_name']); exit;
			return view('appsettings/add-tax', $data);	
		}
			
	}
	 
	
	
	
		public function saveTaxmaster(Request $request)
	{
	   
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                    ->where('reg','=',$request->emid) 
                  ->first();
		
		if($request->taxid)
        {
              
            $data=array(
               	'tax_code'=>$request->tax_code,
				'per_de'=>$request->per_de,
				
				'tax_ref'=>$request->tax_ref,
                );
			 DB::table('tax_master')  ->where('id',$request->taxid)->update($data);
            Session::flash('message','Tax Information Successfully Updated.');
			return redirect('appsettings/vw-tax/'.base64_encode($request->emid));
        }else{ 
			$validator=Validator::make($request->all(),[
			'tax_code'=>'required|max:255',
			'per_de'=>'required|max:255',
						'tax_ref'=>'required|max:255',

			],
			[
			'per_de.required'=>'Tax Code Required.',
			'per_de.required'=>'Percentage of Deduction Required',
			'tax_ref.required'=>'Tax Reference Required',
			
			]);
			
			if ($validator->fails()) {
	            return redirect('appsettings/vw-tax/'.base64_encode($request->emid))
	                        ->withErrors($validator)
	                        ->withInput();
	        }else{
	        	 $data=array(
               	'tax_code'=>$request->tax_code,
				'per_de'=>$request->per_de,
				
				'tax_ref'=>$request->tax_ref,
				'emid'=>$Roledata->reg,
				
                );
	            	
					
					 DB::table('tax_master')->insert($data);
					Session::flash('message','Tax Information Successfully saved.');
					return redirect('appsettings/vw-tax/'.base64_encode($request->emid));
			}
        }
		
		
	}	
	
	
	
	
	
			
			
				public function getPaytypemaster($emp_id)
	{
     	$data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
        
		$data['paytype_rs']=DB::Table('payment_type_master')
                        
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
      
		return view('appsettings/pay-type',  $data);
	}
		public function viewAddPaytypemaster($emp_id)
	{
	    
	    $data['emid']=base64_decode($emp_id) ;
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
		if(Input::get('id')){

			$bankid= Input::get('id');
			$data['paytypedetails']= DB::table('payment_type_master')->where('id',$bankid)->get()->toArray();
			
			//print_r($data['MastersbankName']);die;
			
			return view('appsettings/add-pay-type', $data);	
		}else{
			
			//print_r($data['master_bank_name']); exit;
			return view('appsettings/add-pay-type', $data);	
		}
			
	}
	
	
	
	
	
	
	public function savePaytypemaster(Request $request)
	{
	
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                 ->where('reg','=',$request->emid) 
                  ->first();
		
		if($request->paytypeid)
        {
              
            $data=array(
               	'pay_type'=>$request->pay_type,
				'work_hour'=>$request->work_hour,
				
				'rate'=>$request->rate,
                );
			 DB::table('payment_type_master')  ->where('id',$request->paytypeid)->update($data);
            Session::flash('message','Pay type Information Successfully Updated.');
			return redirect('appsettings/vw-pay-type/'.base64_encode($request->emid));
        }else{ 
			$validator=Validator::make($request->all(),[
			'pay_type'=>'required|max:255',
			

			],
			[
			'pay_type.required'=>'Payment Type Required.',
			
			]);
			
			if ($validator->fails()) {
	           	return redirect('appsettings/vw-pay-type/'.base64_encode($request->emid))
	                        ->withErrors($validator)
	                        ->withInput();
	        }else{
	        	 $data=array(
               		'pay_type'=>$request->pay_type,
				'work_hour'=>$request->work_hour,
				
				'rate'=>$request->rate,
				'emid'=>$Roledata->reg,
				
                );
	            	
					
					 DB::table('payment_type_master')->insert($data);
					Session::flash('message','Pay type Information Successfully saved.');
					return redirect('appsettings/vw-pay-type/'.base64_encode($request->emid));
			}
        }
		
		
	}	
	
	
	
	
	
	
	
	
	
	
	public function getcurrenmaster()
	{
		$email = Session::get('emp_email');
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
        
		$data['curren_rs']=DB::Table('currency_master')
                        
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
      
		return view('settings/currency',  $data);
	}
		public function viewAddcurrenmaster()
	{
		if(Input::get('id')){

			$bankid= Input::get('id');
			$data['currendetails']= DB::table('currency_master')->where('id',$bankid)->get()->toArray();
			
			//print_r($data['MastersbankName']);die;
			
			return view('settings/add-currency', $data);	
		}else{
			
			//print_r($data['master_bank_name']); exit;
			return view('settings/add-currency');	
		}
			
	}
	
	
	
	
	
	
	public function savecurrenmaster(Request $request)
	{
	    $email = Session::get('emp_email');
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
		
		if($request->currenid)
        {
              
            $data=array(
               	'name'=>strtoupper($request->name),
				
                );
			 DB::table('currency_master')  ->where('id',$request->currenid)->update($data);
            Session::flash('message','currency Information Successfully Updated.');
			return redirect('settings/vw-currency');
        }else{ 
			$validator=Validator::make($request->all(),[
			'name'=>'required|max:255',
			

			],
			[
			'name.required'=>'Currency Name Required.',
			
			]);
			
			if ($validator->fails()) {
	            return redirect('settings/currency')
	                        ->withErrors($validator)
	                        ->withInput();
	        }else{
	        	 $data=array(
               		'name'=>strtoupper($request->name),
				
				'emid'=>$Roledata->reg,
				
                );
	            	
					
					 DB::table('currency_master')->insert($data);
					Session::flash('message','Currency Information Successfully saved.');
					return redirect('settings/vw-currency');
			}
        }
		
		
	}	
	
	
	
	
	
	
	
	public function getNationmaster()
	{
		$email = Session::get('emp_email');
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
        
		$data['nation_rs']=DB::Table('nationality_master')
                        
						->where('emid','=',$Roledata->reg ) 
		                    ->get();
      
		return view('settings/nationality',  $data);
	}
		public function viewAddNationmaster()
	{
		if(Input::get('id')){

			$bankid= Input::get('id');
			$data['nationdetails']= DB::table('nationality_master')->where('id',$bankid)->get()->toArray();
			
			//print_r($data['MastersbankName']);die;
			
			return view('settings/add-nationality', $data);	
		}else{
			
			//print_r($data['master_bank_name']); exit;
			return view('settings/add-nationality');	
		}
			
	}
	
	
	
	
	
	
	public function saveNationmaster(Request $request)
	{
	    $email = Session::get('emp_email');
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
		
		if($request->nationid)
        {
              
            $data=array(
               	'name'=>$request->name,
				
                );
			 DB::table('nationality_master')  ->where('id',$request->nationid)->update($data);
            Session::flash('message','Nationality Information Successfully Updated.');
			return redirect('settings/vw-nationality');
        }else{ 
			$validator=Validator::make($request->all(),[
			'name'=>'required|max:255',
			

			],
			[
			'name.required'=>'Nationality  Required.',
			
			]);
			
			if ($validator->fails()) {
	            return redirect('settings/nationality')
	                        ->withErrors($validator)
	                        ->withInput();
	        }else{
	        	 $data=array(
               		'name'=>$request->name,
				
				'emid'=>$Roledata->reg,
				
                );
	            	
					
					 DB::table('nationality_master')->insert($data);
					Session::flash('message','Nationality Information Successfully saved.');
					return redirect('settings/vw-nationality');
			}
        }
		
		
	}
	  	public function getwedgesPaytypemaster($emp_id)
	{
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                ->where('reg','=',base64_decode($emp_id)) 
                  ->first();
						   
		 $data['paytype_rs']=  DB::table('payment_type_wedes')  ->where('emid', '=', $Roledata->reg )->get();
		  $data['emid']=base64_decode($emp_id) ;
		return view('appsettings/wedgespay-type',$data);
               
	}
		public function viewAddwedgesPaytypemaster($emp_id)
	{
	      $data['emid']=base64_decode($emp_id) ;
		if(Input::get('id')){

			$bankid= base64_decode(Input::get('id'));
			$data['paytypedetails']= DB::table('payment_type_wedes')->where('id',$bankid)->get()->toArray();
			
		
			
			return view('appsettings/add-wedgespay-type', $data);	
		}else{
			
		
			return view('appsettings/add-wedgespay-type', $data);	
		}
			
	}
	public function savewedgesPaytypemaster(Request $request)
	{
	  
		$Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$request->emid) 
                  ->first();
		

		

		
		

		if(empty($request->id)){
		     $employee_type=DB::table('payment_type_wedes')->where('pay_type', $request->pay_type) ->where('emid', '=', $Roledata->reg )->first();
	
		 
	if(!empty($employee_type)){
	    
			Session::flash('message','Wedges pay mode Alredy Exists.');
		    return redirect('appsettings/vw-wedgespay-type/'.base64_encode($request->emid));
		}
			DB::table('payment_type_wedes')->insert(
			    ['pay_type' => $request->pay_type,'emid' => $Roledata->reg]
			);
			

            Session::flash('message','Wedges pay mode Information Successfully saved.');
			
			return redirect('appsettings/vw-wedgespay-type/'.base64_encode($request->emid));

		}else{
		   
   $employee_type=DB::table('payment_type_wedes')->where('pay_type', $request->pay_type) ->where('emid', '=', $Roledata->reg )  ->where('id','!=', $request->id)->first();
	

		    	if(!empty($employee_type)){
		Session::flash('message','Wedges pay mode Alredy Exists.');
		    return redirect('appsettings/vw-wedgespay-type/'.base64_encode($request->emid));
		}
			DB::table('payment_type_wedes')
            ->where('id', $request->id)
            ->update(['pay_type' => $request->pay_type]);
            Session::flash('message','Wedges pay modeInformation Successfully Updated.');
		   return redirect('appsettings/vw-wedgespay-type/'.base64_encode($request->emid));
		}
		
		
		
	}
}

