<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>

	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title"> Need Action List</h4> -->
					
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-list"></i> Need Action List </h4>
									@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<?php
				$cos_success_rs=0;
					$per_spi_appli=0;
				$per_spi_hr=0;
				if($start_date =='' && $end_date=='' && $employee_id=='' ){
					$or_appli=DB::Table('registration')
					->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        ->where('registration.status','=','active') 
				  
				->get();
					$or_lince=DB::Table('registration')
		        	->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 
		        
				->get();
					$data['or_verify']=DB::Table('registration')
		        	->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no') 
				->get(); 
					$or_verify=DB::Table('registration')
		        	->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no') 
				->get(); 
					$or_noverify=DB::Table('registration')
		        	->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
               ->where('registration.verify','=','not approved') 
				   ->where('registration.licence','=','no') 
		        
				->get();
					$bill_rs=DB::Table('billing')
 
 	->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
   ->orderBy('billing.id', 'desc')
      ->select('billing.*','tareq_app.ref_id')
				->get();
					$first_invoice_rs=DB::Table('tareq_app')
 
 	->join('billing', 'tareq_app.emid', '=', 'billing.emid')
 	->where('tareq_app.invoice','=','Yes')
   ->orderBy('tareq_app.id', 'desc')
      ->select('tareq_app.*')
				->get();
					$bill_paid_rs=DB::Table('payment')
						->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
->where(function ($query) {
            $query ->where('payment.status','=','paid')
                 ->orWhere('payment.status','=','partially paid');
        })
   ->orderBy('payment.id', 'desc')
				->get();
				$sum=0;
				foreach($bill_rs as $val){
				  $sum=$sum+$val->amount;  
				}
				
					$hr_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_com_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.status','=','Complete') 
				->get();
				$hr_home_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.home_off','=','Yes') 
				->get();

					$hr_reject_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.licence','=','Rejected') 
				->get();
					$hr_granted_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.licence','=','Granted') 
				->get();
				$hr_wip_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.status','=','Incomplete') 
				->get();
				
				
				
					$need_action_apply_rs=DB::Table('tareq_app')

  ->where('need_action','=','Yes')
   ->orderBy('id', 'desc')
				->get();
					$need_action_hr_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.need_action','=','Yes') 
				->get();

				
					$cos_rs=DB::Table('cos_apply')
 
 
   ->orderBy('id', 'desc')
				->get();
				
				$cos_requesrt_rs=DB::Table('cos_apply')
 
 ->where('status','=','Request')
   ->orderBy('id', 'desc')
				->get();
			$cos_granted_rs=DB::Table('cos_apply')
 
 ->where('status','=','Granted')
   ->orderBy('id', 'desc')
				->get();	
				$cos_rejected_rs=DB::Table('cos_apply')
 
 ->where('status','=','Rejected')
   ->orderBy('id', 'desc')
				->get();
				if(count($cos_rs)!=0){
				$cos_success_rs=(count($cos_granted_rs)*100)/count($cos_rs);
				}
				
				$per_spi_appli=0;
				$per_spi_hr=0;
				
				
				
					$cos_further_rs=DB::Table('cos_apply')
 
 ->where('fur_query','=','Yes')
   ->orderBy('id', 'desc')
				->get();
					$hr_lag_time_rs=DB::Table('hr_apply')
 
 ->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
   ->orderBy('hr_apply.id', 'desc')
    ->where('hr_apply.status','=','Incomplete') 
				->get();
				}
				
						 if($start_date =='' && $end_date=='' && $employee_id!='' ){
					$or_appli=DB::Table('registration')
					->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
						->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        ->where('registration.status','=','active') 
				   ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				->get();
					$or_lince=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 
		        
				->get();
					$data['or_verify']=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no') 
				->get(); 
					$or_verify=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no') 
				->get(); 
					$or_noverify=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				  ->where('registration.status','=','active') 
               ->where('registration.verify','=','not approved') 
				   ->where('registration.licence','=','no') 
		        
				->get();
					$bill_rs=DB::Table('billing')
 	->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
 		->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
 
   ->orderBy('billing.id', 'desc')
      ->select('billing.*','tareq_app.ref_id')
				->get();
				
					$first_invoice_rs=DB::Table('tareq_app')
 	->join('role_authorization_admin_organ', 'tareq_app.emid', '=', 'role_authorization_admin_organ.module_name')
 	->join('billing', 'tareq_app.emid', '=', 'billing.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
 	->where('tareq_app.invoice','=','Yes')
   ->orderBy('tareq_app.id', 'desc')
     ->select('tareq_app.*')
				->get();
					$bill_paid_rs=DB::Table('payment')
						->join('role_authorization_admin_organ', 'payment.emid', '=', 'role_authorization_admin_organ.module_name')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
	->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
 ->where(function ($query) {
            $query ->where('payment.status','=','paid')
                 ->orWhere('payment.status','=','partially paid');
        })
   ->orderBy('payment.id', 'desc')
				->get();
				$sum=0;
				foreach($bill_rs as $val){
				  $sum=$sum+$val->amount;  
				}
				
				$hr_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_com_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
   ->where('hr_apply.status','=','Complete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_home_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
      ->where('hr_apply.home_off','=','Yes')
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_reject_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
     ->where('hr_apply.licence','=','Rejected') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_granted_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
     ->where('hr_apply.licence','=','Granted') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_wip_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
   ->where('hr_apply.status','=','Incomplete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$need_action_apply_rs=DB::Table('tareq_app')
 ->where('ref_id','=',$employee_id) 
  ->where('need_action','=','Yes')
   ->orderBy('id', 'desc')
				->get();
					$need_action_hr_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
     ->where('hr_apply.need_action','=','Yes') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				
				$cos_further_rs=DB::Table('cos_apply')
 
 ->where('fur_query','=','Yes')
   ->where('employee_id','=',$employee_id) 
   ->orderBy('id', 'desc')
				->get();	
					$cos_rs=DB::Table('cos_apply')
  ->where('employee_id','=',$employee_id) 
 
   ->orderBy('id', 'desc')
				->get();
				
				$cos_requesrt_rs=DB::Table('cos_apply')
  ->where('employee_id','=',$employee_id) 
 ->where('status','=','Request')
   ->orderBy('id', 'desc')
				->get();
			$cos_granted_rs=DB::Table('cos_apply')
  ->where('employee_id','=',$employee_id) 
 ->where('status','=','Granted')
   ->orderBy('id', 'desc')
				->get();	
				$cos_rejected_rs=DB::Table('cos_apply')
  ->where('employee_id','=',$employee_id) 
 ->where('status','=','Rejected')
   ->orderBy('id', 'desc')
				->get();
				if(count($cos_rs)!=0){
				$cos_success_rs=(count($cos_granted_rs)*100)/count($cos_rs);
				}
				 $fof=0;
				if(count($or_lince)!=0){
				   $tokgg=DB::table('role_authorization_admin_time') ->where('type','=','Application Time') ->first(); 
				    foreach($or_lince as $lival){
				        $tok=DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours')) ->where('employee_id','=',$employee_id)->where('type','=','Application Time') ->where('emid','=',$lival->reg)->first(); 
				   
				        if(!empty($tok->w_hours)){
				        if($tokgg->time>=($tok->w_hours)){
				             
				        }else{
				             $fof++;
				        }
				        }else{
				            $fof++; 
				        }
				    }
				    
				    
				}
				
				
				$gof=0;
					if(count($hr_com_rs)!=0){
				   $tokgg=DB::table('role_authorization_admin_time') ->where('type','=','HR Time') ->first(); 
				    foreach($hr_com_rs as $lival){
				        $tok=DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours')) ->where('employee_id','=',$employee_id)->where('type','=','HR Time') ->where('emid','=',$lival->emid)->first(); 
				      
				        if(!empty($tok->w_hours)){
				        if($tokgg->time>=($tok->w_hours)){
				            
				        }else{
				             $gof++;
				        }
				        }else{
				            $gof++; 
				        }
				    }
				}
					if(count($or_lince)!=0){
					  
				if($fof>=1){
				   	$per_spi_appli=1; 
				}else{
				   $per_spi_appli=0;  
				}}else{
					  	$per_spi_appli=1;   
					}
			
					if(count($hr_com_rs)!=0){
				if($gof>=1){
				   	$per_spi_hr=1; 
				}else{
				   $per_spi_hr=0;  
				}
					}else{
					  	$per_spi_hr=1;   
					}
			
				$hr_lag_time_rs=DB::Table('hr_apply')
				->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
 	 ->where('tareq_app.ref_id','=',$employee_id) 
     ->where('hr_apply.status','=','Incomplete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				
				}
				
				
				
				
				if($start_date!='' && $end_date!='' && $employee_id=='' ){
				    $start_date=date('Y-m-d',strtotime($start_date));
				     $end_date=date('Y-m-d',strtotime($end_date));
					$or_appli=DB::Table('registration')
					->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        ->where('registration.status','=','active') 
				   ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
				->get();
					$or_lince=DB::Table('registration')
		        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
		        
				->get();
					$data['or_verify']=DB::Table('registration')
		        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
		          ->where('registration.licence','=','no') 
				->get(); 
					$or_verify=DB::Table('registration')
		        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no') 
		           ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
				->get(); 
					$or_noverify=DB::Table('registration')
		         ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
               ->where('registration.verify','=','not approved') 
				   ->where('registration.licence','=','no') 
				    ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
		        
				->get();
					$bill_rs=DB::Table('billing')
 ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
  ->whereBetween('billing.date', [$start_date, $end_date])
   ->orderBy('billing.id', 'desc')
      ->select('billing.*','tareq_app.ref_id')
				->get();
					$first_invoice_rs=DB::Table('tareq_app')
 ->join('billing', 'tareq_app.emid', '=', 'billing.emid')
  ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
  ->where('tareq_app.invoice','=','Yes')
   ->orderBy('tareq_app.id', 'desc')
     ->select('tareq_app.*')
				->get();
					$bill_paid_rs=DB::Table('payment')
					 ->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
->where(function ($query) {
            $query ->where('payment.status','=','paid')
                 ->orWhere('payment.status','=','partially paid');
        })
  ->whereBetween('payment.date', [$start_date, $end_date])
   ->orderBy('payment.id', 'desc')
				->get();
				$sum=0;
				foreach($bill_rs as $val){
				  $sum=$sum+$val->amount;  
				}
				
					$hr_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_com_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
    ->where('hr_apply.status','=','Complete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_home_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
      ->where('hr_apply.home_off','=','Yes') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_reject_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
     ->where('hr_apply.licence','=','Rejected') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_granted_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
     ->where('hr_apply.licence','=','Granted') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_wip_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
    ->where('hr_apply.status','=','Incomplete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$need_action_apply_rs=DB::Table('tareq_app')
   	->join('registration', 'tareq_app.emid', '=', 'registration.reg')
				 ->where('registration.status','=','active')
              
				  ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
  ->where('tareq_app.need_action','=','Yes')
   ->orderBy('tareq_app.id', 'desc')
				->get();
				$need_action_hr_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
       ->where('hr_apply.need_action','=','Yes') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$cos_further_rs=DB::Table('cos_apply')
   ->whereBetween('update_new_ct', [$start_date, $end_date])
 ->where('fur_query','=','Yes')
   ->orderBy('id', 'desc')
				->get();
					$cos_rs=DB::Table('cos_apply')
 
  ->whereBetween('update_new_ct', [$start_date, $end_date])
   ->orderBy('id', 'desc')
				->get();
				
				$cos_requesrt_rs=DB::Table('cos_apply')
  ->whereBetween('update_new_ct', [$start_date, $end_date])
 ->where('status','=','Request')
   ->orderBy('id', 'desc')
				->get();
			$cos_granted_rs=DB::Table('cos_apply')
  ->whereBetween('update_new_ct', [$start_date, $end_date])
 ->where('status','=','Granted')
   ->orderBy('id', 'desc')
				->get();	
				$cos_rejected_rs=DB::Table('cos_apply')
  ->whereBetween('update_new_ct', [$start_date, $end_date])
 ->where('status','=','Rejected')
   ->orderBy('id', 'desc')
				->get();
	if(count($cos_rs)!=0){
				$cos_success_rs=(count($cos_granted_rs)*100)/count($cos_rs);
				}
					$per_spi_appli=0;
				$per_spi_hr=0;
				
				
				
					$hr_lag_time_rs=DB::Table('hr_apply')
							->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.sub_due_date', [$start_date, $end_date])
      ->where('hr_apply.status','=','Incomplete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();

				}
				
				
				
				
				
				
				
				
					 if($start_date!='' && $end_date!='' && $employee_id!='' ){
					     
					     $start_date=date('Y-m-d',strtotime($start_date));
				     $end_date=date('Y-m-d',strtotime($end_date));
				     
					$or_appli=DB::Table('registration')
					->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
						->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        ->where('registration.status','=','active') 
		        
				   ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				   	 ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
				->get();
					$or_lince=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
		        	 
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
                ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
				 
		        
				->get();
					$data['or_verify']=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no') 
		           ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
				->get(); 
					$or_verify=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				 ->where('registration.status','=','active')
               ->where('registration.verify','=','approved') 
				 
		          ->where('registration.licence','=','no')
		           ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
				->get(); 
					$or_noverify=DB::Table('registration')
		        	->join('role_authorization_admin_organ', 'registration.reg', '=', 'role_authorization_admin_organ.module_name')
		        		->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
				  ->where('registration.status','=','active') 
               ->where('registration.verify','=','not approved') 
				   ->where('registration.licence','=','no') 
				    ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
		        
				->get();
					$bill_rs=DB::Table('billing')
 	->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
 	->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
 ->whereBetween('billing.date', [$start_date, $end_date])
   ->orderBy('billing.id', 'desc')
      ->select('billing.*','tareq_app.ref_id')
				->get();
									$first_invoice_rs=DB::Table('tareq_app')
 	->join('role_authorization_admin_organ', 'tareq_app.emid', '=', 'role_authorization_admin_organ.module_name')
 	->join('billing', 'tareq_app.emid', '=', 'billing.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
 ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
 ->where('tareq_app.invoice','=','Yes')
   ->orderBy('tareq_app.id', 'desc')
     ->select('tareq_app.*')
				->get();

					$bill_paid_rs=DB::Table('payment')
						->join('role_authorization_admin_organ', 'payment.emid', '=', 'role_authorization_admin_organ.module_name')
						->join('tareq_app', 'payment.emid', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
->where(function ($query) {
            $query ->where('payment.status','=','paid')
                 ->orWhere('payment.status','=','partially paid');
        })
  ->whereBetween('payment.date', [$start_date, $end_date])
   ->orderBy('payment.id', 'desc')
				->get();
				$sum=0;
				foreach($bill_rs as $val){
				  $sum=$sum+$val->amount;  
				}
				
				$hr_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_com_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
   ->where('hr_apply.status','=','Complete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_home_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
     ->where('hr_apply.home_off','=','Yes')
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_reject_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
    ->where('hr_apply.licence','=','Rejected') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
					$hr_granted_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
    ->where('hr_apply.licence','=','Granted') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				$hr_wip_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
   ->where('hr_apply.status','=','Incomplete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
						$need_action_apply_rs=DB::Table('tareq_app')
   	->join('registration', 'tareq_app.emid', '=', 'registration.reg')
				 ->where('registration.status','=','active')
              
				  ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
  ->where('tareq_app.need_action','=','Yes')
   ->where('tareq_app.ref_id','=',$employee_id)
   ->orderBy('tareq_app.id', 'desc')
				->get();
					$need_action_hr_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.update_new_ct', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
     ->where('hr_apply.need_action','=','Yes') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				
				$cos_rs=DB::Table('cos_apply')
  ->where('employee_id','=',$employee_id) 
  ->whereBetween('update_new_ct', [$start_date, $end_date])
   ->orderBy('id', 'desc')
				->get();
					$cos_further_rs=DB::Table('cos_apply')
   ->whereBetween('update_new_ct', [$start_date, $end_date])
    ->where('employee_id','=',$employee_id) 
 ->where('fur_query','=','Yes')
   ->orderBy('id', 'desc')
				->get();
				$cos_requesrt_rs=DB::Table('cos_apply')
  ->whereBetween('update_new_ct', [$start_date, $end_date])
   ->where('employee_id','=',$employee_id) 
 ->where('status','=','Request')
   ->orderBy('id', 'desc')
				->get();
			$cos_granted_rs=DB::Table('cos_apply')
			 ->where('employee_id','=',$employee_id) 
  ->whereBetween('update_new_ct', [$start_date, $end_date])
 ->where('status','=','Granted')
   ->orderBy('id', 'desc')
				->get();	
				$cos_rejected_rs=DB::Table('cos_apply')
  ->where('employee_id','=',$employee_id) 
   ->whereBetween('update_new_ct', [$start_date, $end_date])
 ->where('status','=','Rejected')
   ->orderBy('id', 'desc')
				->get();
				if(count($cos_rs)!=0){
				$cos_success_rs=(count($cos_granted_rs)*100)/count($cos_rs);
				}
				
				
				 $fof=0;
				if(count($or_lince)!=0){
				   $tokgg=DB::table('role_authorization_admin_time') ->where('type','=','Application Time') ->first(); 
				    foreach($or_lince as $lival){
				        $tok=DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours')) ->where('employee_id','=',$employee_id)->where('type','=','Application Time') ->where('emid','=',$lival->reg)->first(); 
				       
				        if(!empty($tok->w_hours)){
				        if($tokgg->time>=($tok->w_hours)){
				            
				        }else{
				             $fof++;
				        }
				        }else{
				            $fof++; 
				        }
				    }
				    
				    
				}
				
				
				$gof=0;
					if(count($hr_com_rs)!=0){
				   $tokgg=DB::table('role_authorization_admin_time') ->where('type','=','HR Time') ->first(); 
				    foreach($hr_com_rs as $lival){
				        $tok=DB::table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours')) ->where('employee_id','=',$employee_id)->where('type','=','HR Time') ->where('emid','=',$lival->emid)->first(); 
				       
				        if(!empty($tok->w_hours)){
				        if($tokgg->time>=($tok->w_hours)){
				            
				        }else{
				             $gof++;
				        }
				        }else{
				            $gof++; 
				        }
				    }
				}
				
				if(count($or_lince)!=0){
				if($fof>=1){
				   	$per_spi_appli=1; 
				}else{
				   $per_spi_appli=0;  
				}}else{
					  	$per_spi_appli=1;   
					}
			
					if(count($hr_com_rs)!=0){
				if($gof>=1){
				   	$per_spi_hr=1; 
				}else{
				   $per_spi_hr=0;  
				}
					}else{
					  	$per_spi_hr=1;   
					}
						$hr_lag_time_rs=DB::Table('hr_apply')
						->join('tareq_app', 'hr_apply.emid', '=', 'tareq_app.emid')
  ->whereBetween('hr_apply.sub_due_date', [$start_date, $end_date])
  ->where('tareq_app.ref_id','=',$employee_id) 
      ->where('hr_apply.status','=','Incomplete') 
   ->orderBy('hr_apply.id', 'desc')
				->get();
				}
				
				$ongo=0;
				foreach($bill_rs as $valoh){
				    if($valoh->hold_st=='Yes'){
				      $ongo++;     
				    }
				 
				}	
				$aydngo=0;
				
				
				if($start_date =='' && $end_date=='' && $employee_id=='' ){
						$bill30da_rs=DB::Table('billing')
 
 	->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
 	 ->where('billing.status','=','not paid') 
   ->orderBy('billing.id', 'desc')
   
 ->select('billing.*','tareq_app.ref_id')
				->get();
				
				}
				
						 if($start_date =='' && $end_date=='' && $employee_id!='' ){
						$bill30da_rs=DB::Table('billing')
 	->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
 		->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
 	 ->where('billing.status','=','not paid') 
   ->orderBy('billing.id', 'desc')
   ->select('billing.*','tareq_app.ref_id')
				->get();
					
				}
				
				
				
				
				if($start_date!='' && $end_date!='' && $employee_id=='' ){
				    $start_date=date('Y-m-d',strtotime($start_date));
				     $end_date=date('Y-m-d',strtotime($end_date));
					$bill30da_rs=DB::Table('billing')
 ->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
  ->whereBetween('billing.date', [$start_date, $end_date])
  	 ->where('billing.status','=','not paid') 
   ->orderBy('billing.id', 'desc')
  ->select('billing.*','tareq_app.ref_id')
				->get();
				}
				
				
				
				
				
				
				
				
					 if($start_date!='' && $end_date!='' && $employee_id!='' ){
					     
					     $start_date=date('Y-m-d',strtotime($start_date));
				     $end_date=date('Y-m-d',strtotime($end_date));
				     
					$bill30da_rs=DB::Table('billing')
 	->join('role_authorization_admin_organ', 'billing.emid', '=', 'role_authorization_admin_organ.module_name')
 	->join('tareq_app', 'billing.emid', '=', 'tareq_app.emid')
		        	 ->where('role_authorization_admin_organ.member_id','=',$employee_id) 
		        	 	 ->where('billing.status','=','not paid') 
 ->whereBetween('billing.date', [$start_date, $end_date])
   ->orderBy('billing.id', 'desc')
 ->select('billing.*','tareq_app.ref_id')
				->get();
				 
				}
				$aydngo15=0;
			
				foreach($bill30da_rs as $companyjhnvg){
				    
				   	
								 if($companyjhnvg->status=='not paid' && $companyjhnvg->hold_st!='Yes' || $companyjhnvg->hold_st!=' ' || is_null($companyjhnvg->hold_st)) {
				     
				        $daten=date('Y-m-d',strtotime($companyjhnvg->date.'  + 30 days'));
				         $daten15=date('Y-m-d',strtotime($companyjhnvg->date.'  + 15 days'));
				        
				        if($daten<date('Y-m-d')){
				      $aydngo++;  
				        }
				      if($daten15<date('Y-m-d')){
				      $aydngo15++;  
				        }
				          
				        
				    }
				 
				}	
				
			
		
				?>			<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl.No.</th>
													<th>Organisation Name</th>
													<th>Employee Name</th>
													<th>Start Date for HR File Preparation</th>
													<th>HR File Prearation Deadline</th>
												
													<th>Remarks</th>
													
												
												</tr>
											</thead>
											
											<tbody>
											  <?php $i = 1; ?>
							@foreach($need_action_hr_rs as $company)
								<?php
							
								$pass=DB::Table('registration')
		        
				 ->where('reg','=',$company->emid) 
				 
				->first();
				$terf=DB::Table('tareq_app')
		        
			
				  ->where('emid','=',$company->emid) 
		         
				->first(); 
				$passname=DB::Table('users_admin_emp')
		        
			
				  ->where('employee_id','=',$terf->ref_id) 
		         
				->first();  
				if(!empty($company->job_date)){
				  
				     $sa_date=date('d/m/Y',strtotime($company->job_date)) ;
				       $app_date=date('d/m/Y',strtotime($company->hr_file_date)) ;
				    
				}else{
				 
				  $app_date='';
				  $sa_date='';
				    $re='';
				}
				?>
				<tr>
						
							<td>{{ $i }}</td>
							<td>{{ $pass->com_name }}</td>
                                                                           
							<td>{{ $passname->name }}</td>
							<td>{{$sa_date}}</td>
                              <td>{{ $app_date }}</td>
                              
							     
                           
							
							     <td>
                 {{$company->remarks}}
                  </td>
                            
						</tr>
						<?php
						$i++;?>
			
							
								
  @endforeach  
            								</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('admin.include.footer')
		</div>
		
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
</body>
</html>