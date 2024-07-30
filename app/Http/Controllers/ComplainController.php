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
class ComplainController extends Controller
{
     public function viewdash()
    {
    	try{

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
               $data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('email','=',$email) 
                  ->first();
				  $member = Session::get('admin_userpp_member'); 
              	 $data['opencomplain'] = DB::table('complain')      
           ->where('status', '=', 'open' )
    ->where('cr_by','=',$member)
            ->get(); 
            
            
                    $member = Session::get('admin_userpp_member'); 
                 $data['solvedcomplain'] = DB::table('complain')      
           ->where('status', '=', 'solved' )
    ->where('cr_by','=',$member)
            ->get();
              $data['closedcomplain'] = DB::table('complain')      
           ->where('status', '=', 'closed' )
    ->where('cr_by','=',$member)
            ->get(); 
      	return View('complain/dashboard',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
 public function viewopen()
    {
    	
 try{
            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                    $member = Session::get('admin_userpp_member'); 
              	 $data['opencomplain'] = DB::table('complain')      
           ->where('status', '=', 'open' )
    ->where('cr_by','=',$member)
            ->get(); 
				
      	return View('complain/view-open',$data);        
       }
       else
       {
            return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
   public function addcomplain()
    {
		 try{
      
$id=Input::get('id');


            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                    $member = Session::get('admin_userpp_member'); 
                  $data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('email','=',$email) 
                  ->first();
          $data['user']=DB::Table('role_authorization_admin_organ')

  ->where('member_id','=',$member)         
        ->get();
      $data['module']=DB::Table('module')

          
        ->get();

        if($id){
$decrypted_id = base64_decode( $id );
  $data['open']=DB::table('complain')->where('id','=',$decrypted_id )->first();

  return View('complain/edit-open',$data);     

}else{
  return View('complain/add-open',$data);     

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
    
     
	     public function saveopen(Request $request)
  {  
        try{  $email = Session::get('emp_email'); 
      if(!empty($email))
      {
             $data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('email','=',$email) 
                  ->first();
                 $member = Session::get('admin_userpp_member');  


                
 if(isset($request->newid) && $request->newid!=''){
   $id=$request->newid;
    if($request->has('flie')){

            $file = $request->file('flie');
            $extension = $request->flie->extension();
            $path = $request->flie->store('employee_logo','public');
             $dataggimg=array(
 'flie'=>$path,
            );
  DB::table('complain')->where('id', $id)->update($dataggimg);

        }
 $datagg=array(
                     'cr_by'=>$member,
         'emid'=>$request->emid,
           'p_name'=>$request->p_name,
              'cat_name'=>$request->cat_name,
               'others'=>$request->others,
                
                 'remarks'=>$request->remarks,
           'descrption'=>$request->descrption,
          
               
              
                );
                 DB::table('complain')->where('id', $id)->update($datagg);
                 Session::flash('message',' Complain Updated Successfully .');
               
        return redirect('complain/view-complain');  
 }else{

   if($request->has('flie')){

            $file = $request->file('flie');
            $extension = $request->flie->extension();
            $path = $request->flie->store('employee_logo','public');
            


        }else{
      
     $path = '';  
      
    }
      
              $datagg=array(
                     'cr_by'=>$member,
         'emid'=>$request->emid,
           'p_name'=>$request->p_name,
              'cat_name'=>$request->cat_name,
               'others'=>$request->others,
                 'flie'=>$path,
                   'status'=>'open',
           'descrption'=>$request->descrption,
          'cr_date'=>date('Y-m-d'),
               
              
                );
                 DB::table('complain')->insert($datagg);
  $Roledatagg = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('reg','=',$request->emid) 
                  ->first();
 $Roledathh = DB::table('complain')      
                 
                 ->orderBy('id', 'desc')
                  
                  ->get();
  $data = array('p_name'=>$request->p_name,'cat_name'=>$request->cat_name,'com_name'=>$Roledatagg->com_name,'descrption'=>$request->descrption,
  'others' =>$request->others,'ind'=>count($Roledathh));
                
                $toemail='ankita@eitpl.in';
                Mail::send('mailnewcom', $data, function($message) use($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('New Complain');
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                });	
                
                    $data = array('p_name'=>$request->p_name,'cat_name'=>$request->cat_name,'com_name'=>$Roledatagg->com_name,'descrption'=>$request->descrption,
  'others' =>$request->others,'ind'=>count($Roledathh));
                $toemail='tirtha@eitpl.in';
                Mail::send('mailnewcom', $data, function($message) use($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('New Complain');
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                });	
                      
 $data = array('p_name'=>$request->p_name,'cat_name'=>$request->cat_name,'com_name'=>$Roledatagg->com_name,'descrption'=>$request->descrption,
  'others' =>$request->others,'ind'=>count($Roledathh));        
                $toemail='subhasish@eitpl.in';
                Mail::send('mailnewcom', $data, function($message) use($toemail) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('New Complain');
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                });	
                   
        
  Session::flash('message',' Complain Added Successfully .');
               
        return redirect('complain/view-complain');    
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




  public function viewsolved()
    {
        try{  

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                    $member = Session::get('admin_userpp_member'); 
                 $data['opencomplain'] = DB::table('complain')      
           ->where('status', '=', 'solved' )
    ->where('cr_by','=',$member)
            ->get(); 
        
        return View('complain/view-solved',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    


   public function addcomplainsolved()
    {
        try{  
$id=Input::get('id');


            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                    $member = Session::get('admin_userpp_member'); 
                  $data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('email','=',$email) 
                  ->first();
          $data['user']=DB::Table('role_authorization_admin_organ')

  ->where('member_id','=',$member)         
        ->get();
      $data['module']=DB::Table('module')

          
        ->get();

        if($id){
$decrypted_id = base64_decode( $id );
  $data['open']=DB::table('complain')->where('id','=',$decrypted_id )->first();

  return View('complain/edit-solved',$data);     

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
    
     
       public function saveopensolved(Request $request)
  {    try{  
         $email = Session::get('emp_email'); 
      if(!empty($email))
      {
             $data['Roledata'] = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('email','=',$email) 
                  ->first();
                 $member = Session::get('admin_userpp_member');  


                
 if(isset($request->newid) && $request->newid!=''){
   $id=$request->newid;
    if($request->has('flie')){

            $file = $request->file('flie');
            $extension = $request->flie->extension();
            $path = $request->flie->store('employee_logo','public');
             $dataggimg=array(
 'flie'=>$path,
            );
  DB::table('complain')->where('id', $id)->update($dataggimg);

        }
 $datagg=array(
                    'status'=>$request->status,
                   'remarks'=>$request->remarks,

             'close_date'=>date('Y-m-d'),
          
               
              
                );
                 DB::table('complain')->where('id', $id)->update($datagg);
                 Session::flash('message',' Complain Updated Successfully .');
               
        return redirect('complain/view-solved-complain');  
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
public function viewclosed()
    {
       try{

            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                    $member = Session::get('admin_userpp_member'); 
                 $data['opencomplain'] = DB::table('complain')      
           ->where('status', '=', 'closed' )
    ->where('cr_by','=',$member)
            ->get(); 
        
        return View('complain/view-closed',$data);        
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



