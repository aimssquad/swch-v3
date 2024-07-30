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
class OrganogramController extends Controller
{
     public function viewdash()
    {
    	try{

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
               $data['Roledata'] = DB::table('registration')->where('status','=','active')        
                 
                  ->where('email','=',$email) 
                  ->first();
                  
		//dd($data);		
      	return View('organogram-chart/dashboard',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

	public function viewlevel()
	{  try{
	       if(!empty(Session::get('emp_email')))
      {
           $email = Session::get('emp_email');
     $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
				    $data['Roledata'] = DB::table('registration')->where('status','=','active')        
                 
                  ->where('email','=',$email) 
                  ->first();
						   
		 $data['employee_type_rs']=  DB::table('employee_level')  ->where('emid', '=', $Roledata->reg ) ->get();
		
		return view('organogram-chart/level-list',$data);
      }
       else
       {
              return redirect('/');
       }
         
        }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }		 
	}
		
	// public function viewAddNewLevel(Request $request)
	// {    
    //     try{  
    //         // ddd();
    //         if(!empty(Session::get('emp_email')))
    //         {
    //             $email = Session::get('emp_email');      
    //             $data['Roledata'] = DB::table('registration')->where('status','=','active')        
    //                 ->where('email','=',$email) 
    //                 ->first(); 
    //             //dd($data['Roledata']->id);    
    //             if(Input::get('id'))
    //             {
    //                 $dt=DB::table('employee_level')->where('id','=',Input::get('id'))->first();
    //                 //dd($dt);
    //                 if(!empty($dt)){
    //                     $data['shift_management']=DB::table('employee_level')->where('id','=',Input::get('id'))->first();
    
    //                     return view('organogram-chart/add-new-level',$data);
    //                 }else{
    //                     return redirect('organogram-chart/vw-level');
    //                 }
    //             }
    //             else
    //             {
    //                 return view('organogram-chart/add-new-level',$data);
    //             }
    //         }
    //         else
    //         {
    //             return redirect('/');
    //         }
	//     }catch(Exception $e){
    //         throw new \App\Exceptions\FrontException($e->getMessage());
    //         dd($e);
    //     }          
	// }
	

    public function viewAddNewLevel(Request $request)
    {   //dd($request->input('id'));
        try {
            if (!empty($request->session()->get('emp_email'))) {
                $email = $request->session()->get('emp_email');
                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                if ($request->input('id')) {
                    $dt = DB::table('employee_level')
                        ->where('id', '=', $request->input('id'))
                        ->first();

                    if (!empty($dt)) {
                        $data['shift_management'] = DB::table('employee_level')
                            ->where('id', '=', $request->input('id'))
                            ->first();

                        return view('organogram-chart/add-new-level', $data);
                    } else {
                        return redirect('organogram-chart/vw-level');
                    }
                } else { //dd('ppp');
                    return view('organogram-chart/add-new-level', $data);
                }
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            report($e);
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }


	public function saveLevelData(Request $request)
	{
	     try{ 
        if(!empty(Session::get('emp_email')))
      {
       
        $department_name= strtoupper(trim($request->level));
		  $email = Session::get('emp_email');
		 $Roledata = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
		
		
         
        if($request->input('id'))
        {
        $ckeck_dept=DB::table('employee_level')->where('level', $department_name)->where('id','!=', $request->input('id'))->where('emid', $Roledata ->reg)->first();
		if(!empty($ckeck_dept)){
			Session::flash('message','Level Name Already Exists.');
		     return redirect('organogram-chart/vw-level');
		}
          
                    
        $data=array(
        
		'level'=>$department_name,
     
        );
        
        $dataInsert=DB::table('employee_level')  
        ->where('id', $request->input('id'))
        ->update($data);
        Session::flash('message','Level Information Successfully Updated.');
        return redirect('organogram-chart/vw-level');
        
        
        }
        else
        {
        $ckeck_dept=DB::table('employee_level')->where('level', $department_name)->where('emid', $Roledata ->reg)->first();
		if(!empty($ckeck_dept)){
			Session::flash('message','Level Name Already Exists.');
		     return redirect('organogram-chart/vw-level');
		}  

        $data=array(
      
		'level'=>$department_name,
       
       'emid'=>$Roledata ->reg,
	  
        );


        
               
		
		
		
		DB::table('employee_level')->insert($data);
		Session::flash('message','Level  Information Successfully Saved.');
	   
		 return redirect('organogram-chart/vw-level');
	
         }
      }
       else
       {
              return redirect('/');
       }
        }catch(Exception $e){
            report($e);
            throw new \App\Exceptions\FrontException($e->getMessage());
        }       
    }
	   
	public function viewhierarchy()
	{  
        try{ 
	        if(!empty(Session::get('emp_email')))
            {
                $email = Session::get('emp_email');
                $data['Roledata'] = DB::table('registration')->where('status','=','active')        
                    ->where('email','=',$email) 
                    ->first();  
                            
                $data['employee_type_rs']=  DB::table('employee_hierarchy')  ->where('emid', '=', $data['Roledata']->reg ) ->get();
                //dd($data);
                return view('organogram-chart/hierarchy-list',$data);
            }
            else
            {
                return redirect('/');
            }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }  
               
	}
	  
	public function viewAddNewHierarchy(Request $request)
	{
        try{ 
            if(!empty(Session::get('emp_email')))
            {
                $email = Session::get('emp_email'); 
                //dd($email);      
                $data['Roledata'] = DB::table('registration')->where('status','=','active')                        
                ->where('email','=',$email) 
                ->first();
                $Roledata = DB::table('registration')->where('status','=','active')      
                ->where('email','=',$email) 
                ->first();
                $data['level']=DB::table('employee_level') ->where('emid', '=', $Roledata->reg ) ->get();

                $data['employeeslist']=DB::table('employee')->where('emid', '=', $Roledata->reg )->get();

                $data['users']=DB::table('employee_hierarchy')->join('employee', 'employee_hierarchy.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $Roledata->reg )
                ->where('employee_hierarchy.emid', '=', $Roledata->reg )
                ->select('employee_hierarchy.*')->get();
                
                $userlist=array();
                foreach($data['users'] as $user){
                    $userlist[]=$user->employee_id;
                }
                    
                $data['employees']=array();
                foreach($data['employeeslist'] as $key=>$employee){
                    if(in_array($employee->emp_code, $userlist)) 
                    { 
                    
                    } 
                    else
                    { 
                        $data['employees'][]= (object) array("emp_code"=>$employee->emp_code,"emp_ps_email"=>$employee->emp_ps_email,"emp_fname"=>$employee->emp_fname,"emp_mname"=>$employee->emp_mname,"emp_lname"=>$employee->emp_lname);
                    }

                }
                             
                if($request->input('id'))
                {
                    $dt=DB::table('employee_hierarchy')->where('id','=',$request->input('id'))->first();
                    if(!empty($dt)){
                        $data['shift_management']=DB::table('employee_hierarchy')->where('id','=',$request->input('id'))->first();
                        //dd($data);
                        return view('organogram-chart/add-new-hierarchy',$data);
                    }else{
                        return redirect('organogram-chart/vw-hierarchy');
                    }
                }
                else
                {   
                    return view('organogram-chart/add-new-hierarchy',$data);
                }
                        
            }
            else
            {
                return redirect('/');
            } 
        }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        } 		  
	}
	
    public function saveHierarchyData(Request $request)
	{  
        try{ 
	        if(!empty(Session::get('emp_email')))
            {
                $department_name= strtoupper(trim($request->level));
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status','=','active')             
                ->where('email','=',$email) 
                ->first();
                if($request->input('id'))
                {
                $ckeck_dept=DB::table('employee_hierarchy')->where('employee_id', $request->employee_id)->where('id','!=', $request->input('id'))->where('emid', $Roledata ->reg)->first();
                if(!empty($ckeck_dept)){
                    Session::flash('message','Employee Id Already Exists.');
                    return redirect('organogram-chart/vw-hierarchy');
                }            
                $data=array(
                'level'=>$request->level,
                'level_report'=>$request->level_report,
                );
                
                $dataInsert=DB::table('employee_hierarchy')  
                ->where('id', $request->input('id'))
                ->update($data);
                Session::flash('message','Organisation Hierarchy Information Successfully Updated.');
                return redirect('organogram-chart/vw-hierarchy');
                
                
                }else{
                    $ckeck_dept=DB::table('employee_hierarchy')->where('employee_id', $request->employee_id)->where('emid', $Roledata ->reg)->first();
                    if(!empty($ckeck_dept)){
                        Session::flash('message','Employee Id Already Exists.');
                        return redirect('organogram-chart/vw-hierarchy');
                    }  

                    $data=array(
                
                    'level'=>$request->level,
                    'level_report'=>$request->level_report,
                
                    'employee_id'=>$request->employee_id,
                    'emp_report_auth'=>$request->emp_report_auth,
                    'report_auth'=>$request->report_auth,
                    'emid'=>$Roledata ->reg,
                
                    );


                    
                        
                    
                    
                    
                    DB::table('employee_hierarchy')->insert($data);
                    Session::flash('message','Organisation Hierarchy  Information Successfully Saved.');
                
                    return redirect('organogram-chart/vw-hierarchy');
            
                }
            }
            else
            {
                    return redirect('/');
            }
         
        }catch(Exception $e){
                    throw new \App\Exceptions\FrontException($e->getMessage());
        } 		 
    }
	

    public function showHierarchy()
    {
        $employee_type_rs = DB::table('employee_hierarchy')->get(); // Adjust this query to match your table structure
        $hierarchyData = $this->getHierarchyData($employee_type_rs);
        //dd($hierarchyData);
        return view('organogram-chart.show', compact('hierarchyData'));
    }

    /**
     * Get hierarchical data for jsTree.
     *
     * @param  \Illuminate\Support\Collection  $employee_type_rs
     * @return array
     */
    private function getHierarchyData($employee_type_rs)
    {
        $data = [];
       //dd($employee_type_rs);
        foreach ($employee_type_rs as $candidate) {
            $employee_auth = DB::table('employee')
                ->where('emp_code', '=', $candidate->employee_id)
                ->where('emid', '=', $candidate->emid)
                ->orderBy('id', 'DESC')
                ->first();

            if ($employee_auth) {
                $node = [
                    'id' => $candidate->employee_id,
                    'parent' => $candidate->emp_report_auth ?: '#',
                    'text' => $employee_auth->emp_fname . ' ' . $employee_auth->emp_lname . ' (' . $candidate->employee_id . ')',
                ];
                $data[] = $node;
            }
        }
        //dd($data);
        return $data;
    }

}

