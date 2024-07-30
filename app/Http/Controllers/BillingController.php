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
class BillingController extends Controller
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
				
      	return View('billing/dashboard',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
 public function viewbillng() {
	 
	 try{
          $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
               $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
          	$data['bill_rs']=DB::Table('billing')
 ->where('status','=','not paid') 
 ->where('emid','=',$data['Roledata']->reg)
 ->groupBy('in_id')
      ->orderBy('in_id', 'desc')
				->get();
			
			
          	return View('billing/billing-list',$data);        
       }
       else
       {
            return redirect('/');
       }
	   }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    

      public function addbillng() {
		  try{
        $email = Session::get('emp_email');
      if(!empty($email))
      {
          
           $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
          	$data['bill_rs']=DB::Table('billing')

				->get();
          	$data['or_de']=DB::Table('registration')
 ->where('status','=','active') 
				    ->where('verify','=','approved') 
               ->where('licence','=','yes') 
				->get();
			$data['candidate_rs']=DB::Table('candidate')
			 ->join('company_job', 'company_job.id', '=', 'candidate.job_id')
             ->where('company_job.emid','=',$data['Roledata']->reg) 
              ->where('candidate.status','=','Hired') 
				->get();
			$userlist=array();
	            foreach($data['bill_rs'] as $user){
	            	$userlist[]=$user->emid;
	            }
            
             	$data['package_rs']=DB::Table('package')
              ->where('status','=','active') 
				->get();
				
				$data['tax_rs']=DB::Table('tax_bill')
              ->where('status','=','active') 
				->get();
            
          	return View('billing/billing-add',$data);        
       }
       else
       {
            return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
    
    
    
    
    	public function viewsendbilldetails($send_id)
    {
      try{
      $email = Session::get('emp_email');; 
      if(!empty($email))
      {
          $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
        $pdf='' ;  
        $fo='';
  $job=DB::table('billing')->where('in_id', '=', base64_decode($send_id) )->first();
  	$pass=DB::Table('registration')
		        
				 ->where('reg','=',$job->emid) 
				 
		         
				->first(); 
				$com_name='';
				if($job->billing_type=='Organisation'){
					
				$com_name=$pass->com_name;	
				}else if($job->billing_type=='Candidate'){
					$com_name=$job->canidate_name;
				}
			
			
  $add='';
  $add= $pass->address;
  if($pass->address2!=''){
      $add .= ' ,'.$pass->address2; 
  }
   if($pass->road!=''){
      $add .= ' ,'.$pass->road; 
  }
   if($pass->city!=''){
      $add .= ' ,'.$pass->city; 
  }
   if($pass->zip!=''){
      $add .= ' ,'.$pass->zip; 
  }
   if($pass->country!=''){
      $add .= ' ,'.$pass->country; 
  }
    $path=public_path().'/billpdf/'.$job->dom_pdf;
    
                	$usersnew=DB::Table('users')
		        
				 ->where('employee_id','=',$job->emid) 
				 
		         
				->first(); 
    $data = array('name'=>$pass->f_name.' '.$pass->l_name,'com_name'=>$com_name,'address' =>$add ,'users'=>$usersnew,'billing_type'=>$job->billing_type);
                  
             if($job->billing_type=='Organisation'){
					
				 $toemail=$pass->email;
				}else if($job->billing_type=='Candidate'){
					 $toemail=$job->canidate_email;
					
				}
             
                Mail::send('mailbillsend', $data, function($message) use($toemail,$path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('Bill Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
                $data = array('name'=>$pass->f_name.' '.$pass->l_name,'com_name'=>$com_name,'address' =>$add ,'users'=>$usersnew,'billing_type'=>$job->billing_type);
      
                $toemail='accounts@workpermitcloud.co.uk';
             
                Mail::send('mailbillsend', $data, function($message) use($toemail,$path) {
                $message->to($toemail, 'WorkPermitCloud')->subject
                ('Invoice Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','WorkPermitCloud');
                });
                
               	$usersnew=DB::Table('users')
		        
				 ->where('employee_id','=',$job->emid) 
				 
		         
				->first(); 
    $data = array('name'=>$pass->f_name.' '.$pass->l_name,'com_name'=>$com_name,'address' =>$add ,'users'=>$usersnew,'billing_type'=>$job->billing_type);
             
                $toemail=$pass->organ_email;
             
                Mail::send('mailbillsend', $data, function($message) use($toemail,$path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('Bill Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
	  $dataimgedit=array(
                 'bill_send'=>date('Y-m-d'),
                );
  DB::table('billing')
   
         ->where('in_id', '=', base64_decode($send_id) )
            ->update($dataimgedit);
  			
       Session::flash('message','Bill  send Successfully.');
				   
					return redirect('billing/billinglist');  
      }
					 	  else
       {
            return redirect('/');
       }
       
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
	
	
	  public function savebillng(Request $request) 
    {
       
        try{
         $email=Session::get('emp_email');
      if(!empty($email))
      {
          
         $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
        
                
        $ckeck_email=DB::Table('registration')

               ->where('reg','=',$request->emid) 
				->first();
		
        	$lsatdeptnmdb=DB::table('billing')->whereYear('date', '=', date('Y'))  ->whereMonth('date', '=', date('m')) 
->groupBy('in_id')->orderBy('in_id', 'DESC')->first();
        	
        	
        	
	if(empty($lsatdeptnmdb)){
   $pid=date('Y').'/'.date('m').'/001';
}else{
    $str=str_replace(date('Y').'/'.date('m').'/',"",$lsatdeptnmdb->in_id);
    if($str<=8){
      $pid=date('Y').'/'.date('m').'/00'.($str+1);   
    }else if($str<99){
         $pid=date('Y').'/'.date('m').'/0'.($str+1);   
    }else{
         $pid=date('Y').'/'.date('m').'/'.($str+1);   
    }
   
}  
$lsatdeptnmdbexit=DB::table('billing')->where('in_id', '=', $pid)->orderBy('in_id', 'DESC')->first();
   
   if(!empty($lsatdeptnmdbexit)){
	  Session::flash('error','Invoice Number already Exits. ');
		  return redirect('billing/billinglist');  
   }else{
	 $pidhh=str_replace("/","-",$pid);
$filename=$pidhh.'.pdf';
	$Roledata=DB::Table('registration')
->where('status','=','active')    
               ->where('reg','=',$request->emid) 
				->first();		
$datap = ['Roledata' => $Roledata,'in_id' => $pid,'des' => $request->des,'date' =>date('Y-m-d'),'package'=>$request->package ,
'net_amount'=>$request->net_amount, 'discount'=>$request->discount, 'discount_amount'=>$request->discount_amount
,'anount_ex_vat'=>$request->anount_ex_vat,'vat'=>$request->vat,'amount_after_vat'=>$request->amount_after_vat,
'billing_type'=>$request->billing_type,
'canidate_name'=>$request->canidate_name, 'candidate_id'=>$request->candidate_id
];
        $pdf = PDF::loadView('mybillPDF', $datap);
  
        $pdf->save(public_path().'/billpdf/'.$filename);
		$totamount=0;
	if($request->package && count($request->package )!=0){
	for($i=0;$i<count($request->package );$i++)
    {
		
		$totamount=$totamount+$request->net_amount[$i];
		
	}
	}
	
	if($request->package && count($request->package )!=0){
	for($i=0;$i<count($request->package );$i++)
    {
	
         $data=array(
                
						   'in_id'=>$pid,
						   'emid'=>$request->emid,
						   'pay_mode'=>$request->pay_mode,
				    'status'=>'not paid',
					 'amount'=>$totamount,
					  'due'=>$totamount,
					'des'=>htmlspecialchars($request->des[$i]),
					'date'=>date('Y-m-d'),
					'dom_pdf'=>$filename,
					 'discount'=>$request->discount[$i],
					  'discount_amount'=>$request->discount_amount[$i],
					   'anount_ex_vat'=>$request->anount_ex_vat[$i],
					    'vat'=>$request->vat[$i],
						 'amount_after_vat'=>$request->amount_after_vat[$i],
						  'net_amount'=>$request->net_amount[$i],
						    'package'=>$request->package[$i],
					 'hold_st'=>'',
					 'canidate_name'=>$request->canidate_name,
					 'canidate_email'=>$request->canidate_email,
					 'candidate_id'=>$request->candidate_id,
					 'billing_type'=>$request->billing_type,
                );



                DB::table('billing')->insert($data);
				}
	}
       
       	Session::flash('message','Bill Added Successfully .');
					
					
				
					 	return redirect('billing/billinglist');  
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
    
    
    	public function viewAddbillingy($comp_id)
	{ try{
            $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
                  $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
                  
               $data['bill'] = DB::table('billing')      
                 
                  ->where('in_id','=',base64_decode($comp_id)) 
                  ->get();
				  	$data['package_rs']=DB::Table('package')
              ->where('status','=','active') 
				->get();
				
				return View('billing/bill-edit',$data);   

     
       }
       else
       {
            return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
           
	}
	
		public function saveAddbillingy(Request $request)
	{    try{
	       $email = Session::get('emp_email'); 
      if(!empty($email))
      {
             $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
                  
          
                 
          if(File::exists(public_path('billpdf/'.$request->dom_pdf))){
            File::delete(public_path('billpdf/'.$request->dom_pdf));
        }
               
              
		$Roledata=DB::Table('registration')
->where('status','=','active')    
               ->where('reg','=',$request->emid) 
				->first();		
$datap = ['Roledata' => $Roledata,'in_id' => $request->in_id,'des' => $request->des,'date' =>date('Y-m-d'),'package'=>$request->package ,
'net_amount'=>$request->net_amount, 'discount'=>$request->discount, 'discount_amount'=>$request->discount_amount
,'anount_ex_vat'=>$request->anount_ex_vat,'vat'=>$request->vat,'amount_after_vat'=>$request->amount_after_vat,
'billing_type'=>$request->billing_type,
'canidate_name'=>$request->canidate_name, 'candidate_id'=>$request->candidate_id];    
		$pdf = PDF::loadView('mybillPDF', $datap);
  $filename=$request->dom_pdf;
        $pdf->save(public_path().'/billpdf/'.$filename);
	   $billexit=DB::Table('billing')

              ->where('in_id', '=', $request->in_id)
				->first();
			$dateex=$billexit->date;
           
			 
			DB::table('billing')->where('in_id', '=', $request->in_id)->delete();
  
            $totamount=0;
	if($request->package && count($request->package )!=0){
	for($i=0;$i<count($request->package );$i++)
    {
		
		$totamount=$totamount+$request->net_amount[$i];
		
	}
	}
	
	if($request->package && count($request->package )!=0){
	for($i=0;$i<count($request->package );$i++)
    {
	
         $data=array(
                
						   'in_id'=>$request->in_id,
						   'emid'=>$request->emid,
						 'status'=>'not paid',
					 'amount'=>$totamount,
					  'due'=>$totamount,
					'des'=>htmlspecialchars($request->des[$i]),
					'date'=>$dateex,
					'dom_pdf'=>$filename,
					 'discount'=>$request->discount[$i],
					  'discount_amount'=>$request->discount_amount[$i],
					   'anount_ex_vat'=>$request->anount_ex_vat[$i],
					    'vat'=>$request->vat[$i],
						 'amount_after_vat'=>$request->amount_after_vat[$i],
						  'net_amount'=>$request->net_amount[$i],
						    'package'=>$request->package[$i],
					'hold_st'=>$request->hold_st,
                'other'=>$request->other,
                 'pay_mode'=>$request->pay_mode,
				  'canidate_name'=>$request->canidate_name,
					 'canidate_email'=>$request->canidate_email,
					 'candidate_id'=>$request->candidate_id,
					 'billing_type'=>$request->billing_type,
                );



                DB::table('billing')->insert($data);
				
				}
	}
	Session::flash('message','Bill Changed Successfully .');
               
				return redirect('billing/billinglist');    

     
       }
       else
       {
            return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
         
	}


  public function viewpayre() {
	  try{
        $email = Session::get('emp_email'); 
      if(!empty($email))
      {
                 
                  $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
          
          
          	$data['pay_rs']=DB::Table('payment')
          		->where(function ($query) {
            $query ->where('status','=','paid')
                 ->orWhere('status','=','partially paid');
        })
          	->where('emid',$data['Roledata']->reg)
 ->orderBy('id', 'desc')
				->get();
			
          	return View('billing/payment-list',$data);        
       }
       else
       {
             return redirect('/');
       }
	     }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
       public function addpayre() {
		   try{
         $email = Session::get('emp_email'); 
      if(!empty($email))
      {
             $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('email','=',$email) 
                  ->first();
                   
          
          	$data['bill_rs']=DB::Table('billing')

	->where('emid',$data['Roledata']->reg)

	->where(function ($query) {
            $query ->where('status','=','not paid')
                 ->orWhere('status','=','partially paid');
        })
       
    ->where(function ($query) {
        $query->where('hold_st', '=', 'No')
            ->orWhereNull('hold_st');
    }
)

 ->orderBy('id', 'desc')
				->get();
				
				
		
          	return View('billing/payment-add',$data);        
       }
       else
       {
            return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
    

		  public function savepayre(Request $request) 
    {
         try{
           $email = Session::get('emp_email'); 
      if(!empty($email))
      {
		  $lsatdeptnmdb=DB::table('billing') ->where('id','=',$request->in_id) ->orderBy('id', 'DESC')->first();
        	
        if($request->amount==$request->re_amount){
            
          $lsatdeptnmdbnew=DB::table('payment')->whereYear('payment_date', '=', date('Y')) 
			->whereMonth('payment_date', '=', date('m')) 
	
       			->orderBy('id', 'DESC')->first();
		
 		if(empty($lsatdeptnmdbnew)){
   $pid=date('Y').'/'.date('m').'/001';
}else{
    $str=str_replace(date('Y').'/'.date('m').'/',"",$lsatdeptnmdbnew->pay_recipt);
   
    if($str<=8){
      $pid=date('Y').'/'.date('m').'/00'.($str+1);   
    }else if($str<99){
         $pid=date('Y').'/'.date('m').'/0'.($str+1);   
    }else{
         $pid=date('Y').'/'.date('m').'/'.($str+1);   
    }
   
}  		 


 $pidhh=str_replace("/","-",$pid);
        
        
         $filename=$pidhh.'.pdf';
	  	$lsatdeptnmdb=DB::table('billing') ->where('id','=',$request->in_id) ->orderBy('id', 'DESC')->first();
        	
          $Roledata = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('reg','=',$lsatdeptnmdb->emid) 
                  ->first();         
                  
                   
$datap = ['Roledata' => $Roledata,'pay_recipt' => $pid,'re_amount'=>$request->re_amount,'des'=>$request->des,'date' =>date('d/m/Y'),'billing'=>$lsatdeptnmdb,'method'=>'Ofline'];
       
	   $pdf = PDF::loadView('myinvoicePDF', $datap);
  
        $pdf->save(public_path().'/paypdf/'.$filename);

           $data=array(
                
						   'in_id'=>$lsatdeptnmdb->in_id,
						   'emid'=>$lsatdeptnmdb->emid,
				    'status'=>'paid',
					 'amount'=>$lsatdeptnmdb->amount,
					 're_amount'=>$request->re_amount,
					  'due_amonut'=>$request->due_amonut,
					   'payable_amount'=>$request->due_amonut,
					'des'=>htmlspecialchars($request->des),
					'date'=>$lsatdeptnmdb->date,
					'payment_date'=>date('Y-m-d'),
					'dom_pdf'=>$lsatdeptnmdb->dom_pdf,
				
					'pay_recipt'=>$pid,
						'pay_recipt_pdf'=>$filename,
					 'remarks'=>'Transaction Success ',
					
                );




                DB::table('payment')->insert($data);
				
       
       
       $dataup=array(
           'due'=>0,
                   'status'=>'paid',
                    );
				  DB::table('billing')->where('in_id',$lsatdeptnmdb->in_id)->update($dataup);
				  
			    $Roledata = DB::table('registration')      
                 ->where('status','=','active')    
                  ->where('reg','=',$lsatdeptnmdb->emid) 
                  ->first();
				$path=public_path().'/paypdf/'.$filename;
       $datanew = array('f_name'=>$Roledata->f_name,'l_name'=>$Roledata->l_name,'com_name'=>$Roledata->com_name,'p_no'=>$Roledata->p_no,'email'=>$Roledata->email,'pass'=>$Roledata->pass,'amount'=>$request->re_amount,'bill'=>$lsatdeptnmdb->in_id);
                $toemail=$Roledata->email;
             
                Mail::send('mailorpayre', $datanew, function($message) use($toemail,$path) {
                $message->to($toemail, 'Skilledworkerroute')->subject
                ('Payment Receive   Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
                	$path=public_path().'/paypdf/'.$filename;
        $datanew = array('f_name'=>$Roledata->f_name,'l_name'=>$Roledata->l_name,'com_name'=>$Roledata->com_name,'p_no'=>$Roledata->p_no,'email'=>$Roledata->email,'pass'=>$Roledata->pass,'amount'=>$request->re_amount,'bill'=>$lsatdeptnmdb->in_id);
               $toemail=$Roledata->authemail;   
                Mail::send('mailorpayre', $datanew, function($message) use($toemail,$path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('Payment Receive   Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
                
				  $path=public_path().'/paypdf/'.$filename;
        $datanew = array('f_name'=>$Roledata->f_name,'l_name'=>$Roledata->l_name,'com_name'=>$Roledata->com_name,'p_no'=>$Roledata->p_no,'email'=>$Roledata->email,'pass'=>$Roledata->pass,'amount'=>$request->re_amount,'bill'=>$lsatdeptnmdb->in_id);
               $toemail="accounts@workpermitcloud.co.uk";   
                Mail::send('mailorpayre', $datanew, function($message) use($toemail,$path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('Payment Receive   Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
				  		
	
       	Session::flash('message','Payment Received Successfully .'); 
           
        }else if($request->amount>$request->re_amount){
             
               $lsatdeptnmdbnew=DB::table('payment')->whereYear('payment_date', '=', date('Y')) 
			->whereMonth('payment_date', '=', date('m')) 
	
       			->orderBy('id', 'DESC')->first();
		
 		if(empty($lsatdeptnmdbnew)){
   $pid=date('Y').'/'.date('m').'/001';
}else{
    $str=str_replace(date('Y').'/'.date('m').'/',"",$lsatdeptnmdbnew->pay_recipt);
   
    if($str<=8){
      $pid=date('Y').'/'.date('m').'/00'.($str+1);   
    }else if($str<99){
         $pid=date('Y').'/'.date('m').'/0'.($str+1);   
    }else{
         $pid=date('Y').'/'.date('m').'/'.($str+1);   
    }
   
}  		 


 $pidhh=str_replace("/","-",$pid);
        
        
         $filename=$pidhh.'.pdf';
	  	$lsatdeptnmdb=DB::table('billing') ->where('id','=',$request->in_id) ->orderBy('id', 'DESC')->first();
        	
          $Roledata = DB::table('registration')      
                 
                  ->where('reg','=',$lsatdeptnmdb->emid) 
                  ->first();         
                  
                   
$datap = ['Roledata' => $Roledata,'pay_recipt' => $pid,'re_amount'=>$request->re_amount,'des'=>$request->des,'date' =>date('d/m/Y'),'billing'=>$lsatdeptnmdb,'method'=>'Ofline'];
       
	   $pdf = PDF::loadView('myinvoicePDF', $datap);
  
        $pdf->save(public_path().'/paypdf/'.$filename);

             
           $data=array(
                
						   'in_id'=>$lsatdeptnmdb->in_id,
						   'emid'=>$lsatdeptnmdb->emid,
				    'status'=>'partially paid',
					 'amount'=>$lsatdeptnmdb->amount,
					 're_amount'=>$request->re_amount,
					  'due_amonut'=>$request->due_amonut,
					   'payable_amount'=>$request->due_amonut,
					'des'=>$request->des,
					'date'=>$lsatdeptnmdb->date,
					'payment_date'=>date('Y-m-d'),
					'dom_pdf'=>$lsatdeptnmdb->dom_pdf,
						'pay_recipt'=>$pid,
						'pay_recipt_pdf'=>$filename,
					 'remarks'=>'Transaction Success ',
                );


                DB::table('payment')->insert($data);
				
       
       
       $dataup=array(
           'due'=>($request->due_amonut-$request->re_amount),
                   'status'=>'partially paid',
                    );
				  DB::table('billing')->where('in_id',$lsatdeptnmdb->in_id)->update($dataup);
				  
				    $Roledata = DB::table('registration')      
                 
                  ->where('reg','=',$lsatdeptnmdb->emid) 
                  ->first();
					
		$path=public_path().'/paypdf/'.$filename;
       $datanew = array('f_name'=>$Roledata->f_name,'l_name'=>$Roledata->l_name,'com_name'=>$Roledata->com_name,'p_no'=>$Roledata->p_no,'email'=>$Roledata->email,'pass'=>$Roledata->pass,'amount'=>$request->re_amount,'bill'=>$lsatdeptnmdb->in_id);
                $toemail=$Roledata->email;
             
                Mail::send('mailorpayre', $datanew, function($message) use($toemail,$path) {
                $message->to($toemail, 'Skilledworkerroute')->subject
                ('Payment Receive   Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
                	$path=public_path().'/paypdf/'.$filename;
        $datanew = array('f_name'=>$Roledata->f_name,'l_name'=>$Roledata->l_name,'com_name'=>$Roledata->com_name,'p_no'=>$Roledata->p_no,'email'=>$Roledata->email,'pass'=>$Roledata->pass,'amount'=>$request->re_amount,'bill'=>$lsatdeptnmdb->in_id);
               $toemail=$Roledata->authemail;   
                Mail::send('mailorpayre', $datanew, function($message) use($toemail,$path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('Payment Receive   Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
                
				  $path=public_path().'/paypdf/'.$filename;
        $datanew = array('f_name'=>$Roledata->f_name,'l_name'=>$Roledata->l_name,'com_name'=>$Roledata->com_name,'p_no'=>$Roledata->p_no,'email'=>$Roledata->email,'pass'=>$Roledata->pass,'amount'=>$request->re_amount,'bill'=>$lsatdeptnmdb->in_id);
               $toemail="info@workpermitcloud.co.uk";   
                Mail::send('mailorpayre', $datanew, function($message) use($toemail,$path) {
                $message->to($toemail, 'Workpermitcloud')->subject
                ('Payment Receive   Details');
                  $message->attach($path);
                $message->from('noreply@workpermitcloud.co.uk','Workpermitcloud');
                }); 
				  
       	Session::flash('message','Payment Received Successfully .');
            
            }else{
          	Session::flash('message','Payment Amount Is Bigger Than Amount.');    
        }	
        	

           
             

           
             
				
					 	return redirect('billing/payment-received');
      }
					 	  else
       {
            return redirect('/');
       }
	    }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function viewNewbillingpage($comp_id)
	{ try{
          
                 
                
               $data['bill'] = DB::table('billing')      
                 
                  ->where('in_id','=',base64_decode($comp_id)) 
                  ->get();
				  	$data['package_rs']=DB::Table('package')
              ->where('status','=','active') 
				->get();
				  $data['Roledata'] = DB::table('registration')->where('status','=','active')       
                 
                  ->where('reg','=',$data['bill'][0]->emid) 
                  ->first();
                  
				return View('billing/view-bill',$data);   

     
       }catch(Exception $e){
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
           
	}
    
}

