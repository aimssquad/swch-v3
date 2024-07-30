<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use view;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;
use Auth;
use PDF;
use File;
use Mail;
use App\Exports\ExcelFileExportAttandance;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
class TaskController extends Controller
{
     public function viewdash()
    {  try{
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
               $data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
				
      	return View('tasks/dashboard',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
 public function viewtasklist()
    {   try{
    	
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
              	$data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
				    $user_id = Session::get('users_id');
		 $users=DB::table('users')->where('id','=',$user_id)->first();
		 
				  
				   $data['employee_work']=DB::table('rota_employee')
				   ->where('employee_id','=',$users->employee_id)->where('emid','=',$users->emid) ->orderBy('date', 'DESC')
			 ->get();
       
	   $date=date('Y-m-d');       
      $Roledatad =DB::table('duty_roster')
	 
		
		->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
		 
		->where('duty_roster.employee_id', '=', $users->employee_id )
			->where('duty_roster.emid', '=', $users->emid )
->first();
	 
	  
 if(!empty( $Roledatad)){
	 $data['add']='yes';
 }else{
	  $data['add']='no';
 }
				  
      	return View('tasks/view-list',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
    
     
    
	
	 public function viewtaskemployeelist()
    {   try{
    	
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
              	$data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
				   
				     $data['employee_rs']=DB::table('employee')
			->join('users', 'employee.emp_code', '=', 'users.employee_id')->where('employee.emid', '=',  $data['Roledata']->reg)
			->where('users.emid', '=',  $data['Roledata']->reg)->get();

       
				  
      	return View('tasks/work-search-list',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
	
	
	 public function gettaskemployeelist(Request $request)
    {   try{
    	
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 $Roledata = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
              	$data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
				   
				     $data['employee_rs']=DB::table('employee')
			->join('users', 'employee.emp_code', '=', 'users.employee_id')->where('employee.emid', '=',  $data['Roledata']->reg)
			->where('users.emid', '=',  $Roledata->reg)->get();
			
	$start_date=date('Y-m-d',strtotime($request->start_date));
		$end_date=date('Y-m-d',strtotime($request->end_date));
        if($request->employee_id!='all'){
             $leave_allocation_rs=DB::table('rota_employee')
				      	->whereBetween('date', [$start_date, $end_date])
						   ->where('employee_id', '=', $request->employee_id )
						   ->where('emid', '=', $Roledata->reg )
                            ->get();
                   $leave_allocation__grouprs=DB::table('rota_employee')
				      	->whereBetween('date', [$start_date, $end_date])
						   ->where('employee_id', '=', $request->employee_id )
						    ->where('emid', '=', $Roledata->reg )
						   ->groupBy('employee_id')
						   
                            ->get();           
                             
        }else{
              $leave_allocation_rs=DB::table('rota_employee')
				      
						 ->whereBetween('date', [$start_date, $end_date]) 
						   ->where('emid', '=', $Roledata->reg )
                            ->get();
                            $leave_allocation__grouprs=DB::table('rota_employee')
				      	->whereBetween('date', [$start_date, $end_date])
						 ->where('emid', '=', $Roledata->reg )
						   
						   ->groupBy('employee_id')
                            ->get();  
                            
        }
    
	
                            
                            	$data['result'] ='';
                            	$sum=0;
                            	 $hy=0;
                            		if($leave_allocation_rs)
		{$f=1;
		
			    	 
				
			foreach($leave_allocation_rs as $leave_allocation)
			{
			    	$pass=DB::Table('employee')
		        
				 ->where('emp_code','=',$leave_allocation->employee_id) 
				
		          ->where('emid','=',$leave_allocation->emid) 
				
				->first(); 
				$file='';	
		 if($leave_allocation->file!=''){
			 $file='
			   <a href="https://workpermitcloud.co.uk/hrms/public/'.$leave_allocation->file.'" data-toggle="tooltip" data-placement="bottom" title="Download" download>

              <img style="width: 14px;" src="https://workpermitcloud.co.uk/hrms/public/assets/img/download.png"></a>';	
		 }else{
			 $file='';	
		 }
		


				$data['result'] .='<tr>
				<td>'.$f.'</td>
													<td>'.$pass->emp_fname.'  '.$pass->emp_mname.'  '.$pass->emp_lname.' ('.$pass->emp_code.' )</td>
													
													
														<td>'.date('d/m/Y',strtotime($leave_allocation->date)).'</td>
										<td>'.$leave_allocation->in_time.'</td>
														
														<td>'.$leave_allocation->out_time.'</td>
																		
													
														  	  <td>'.$leave_allocation->w_hours.' Hours (  '.$leave_allocation->w_min.') Minutes</td> 
														  	  <td>'.$leave_allocation->remarks.'</td>
															   <td class="icon" style="text-align: center;">
															   '.$file.'
															  
															   </td>
												
										
						</tr>';
			$f++;}
		}
		
            	
			$data['employee_id']=$request->employee_id;
				  
      	return View('tasks/work-search-list',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
	
	
	 public function viewadd()
    {   try{
    	
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
              	$data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
				   
				   
				  
      	return View('tasks/work-add',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
	
	public function viewsave(Request $request)
    {   try{
    	
    	

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
              	$data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active') 
                  ->where('email','=',$email) 
                  ->first();
				   
				   
				   $user_id = Session::get('users_id');
		 $users=DB::table('users')->where('id','=',$user_id)->first();
		 
				    $tot=$request->w_min+($request->w_hours*60);
					
					if($request->has('file')){

            $file_ps_doc = $request->file('file');
            $extension_ps_doc = $request->file->extension();
            $path_ps_doc = $request->file->store('tasks','public');
            


        }else{
			
		 $path_ps_doc = '';	
			
		}
      
              $datagg=array(
                  	 'employee_id'=>$users->employee_id,
			   'emid'=>$users->emid,
			   
			        'w_hours'=>$request->w_hours,
			         'w_min'=>$request->w_min,
			          'in_time'=>date('h:i A',strtotime($request->in_time)),
			           'out_time'=>date('h:i A',strtotime($request->out_time)),
			           'min_tol'=>$tot,
					   'file'=>$path_ps_doc,
			           	'date'=>date('Y-m-d',strtotime($request->date)),
			           
				   'remarks'=>$request->remarks,
					'cr_date'=>date('Y-m-d'),
               
              
                );
				
                 DB::table('rota_employee')->insert($datagg);
			 
      	Session::flash('message',' Tasks Added Successfully .');
               
				return redirect('task-list');    
       
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
	
	
}



