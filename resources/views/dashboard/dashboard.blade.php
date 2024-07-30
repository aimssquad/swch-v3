<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
<style>
    
    .col-10.col-xs-11.col-sm-4.alert.alert-info{display:none !important;}

	.dash-inr {margin: -45px 15px;}
.alert.alert-info{display:none !important}
.dash-box{padding: 15px 30px;border-radius: 7px;    margin-bottom: 26px;}
.grn {background: #fff;}.red{background:#fff}.blue{background:#fff}.sky{background:#fff}.orange{background:orange}
.dash-box img{width:50px}
.dash-cont h4{color:#000;padding-top:15px;font-size:13px;}
.numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}.dash-cont {
    min-height: 61px;}
    .visa-head{background: linear-gradient(-45deg, #0484b4 , #01aef0) !important;
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;}
.visa-head h3{margin:0;}.footer{position:static;}
</style>
</head>
<body>
	<div class="wrapper">
		
  @include('dashboard.include.header-dashboard')
		<!-- Sidebar -->
		
		
		<!-- End Sidebar -->

		<div class="main-panel" style="width:100%">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">{{$Roledata->com_name}}</h2>
							<h4 class="text-white pb-2 fw-bold">	@if($Roledata->address!=''){{ $Roledata->address }} @if($Roledata->address2!='null'),{{ $Roledata->address2 }}@endif,{{  $Roledata->road }},{{  $Roledata->city }},{{  $Roledata->zip }},{{  $Roledata->country }}@endif</h4>
								
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								
							</div>
						</div>
					</div>
				</div>
				
					<?php
							
						
				    $usetype = Session::get('user_type'); 
					if( $usetype=='employee'){
						$usemail = Session::get('user_email'); 
					 $users_id = Session::get('users_id'); 
					 $dtaem=DB::table('users')      
                 
                  ->where('id','=',$users_id) 
                  ->first();
							 $Roles_auth = DB::table('role_authorization')      
                  ->where('emid','=',$dtaem->emid) 
                  ->where('member_id','=',$dtaem->email) 
                  ->get()->toArray();
$arrrole=array();
			foreach($Roles_auth as $valrol){
				$arrrole[]=$valrol->menu;
			}	
			
				  }
				   
			
				  ?>
					<div class="dash-inr">
				<div class="container">
					<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box sky bg-secondary-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/search.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4 style="font-size:14px;">Organisation Profile</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										      
											 @if($Roledata->updated_at!='' )
											  <h5 style="font-size:14px">Complete</h5>
											  @else
											  <h5 style="font-size:14px">Incomplete</h5>
											  @endif
											
											</div>
												<div class="view-more">
										 <a href="{{url('dashboard/edit-dashboard-company')}}?c_id={{base64_encode($Roledata->id)}}" >
				
				
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>
				 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box grn bg-success-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4 style="font-size:14px;">All Employee List
</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										      
											  <h5 >{{ count($employee_active)}}</h5>
											
											</div>
												<div class="view-more">
											<?php 
										if( $usetype=='employee'){
if(in_array('1', $arrrole))
{
	
	?>
				<a href="{{url('dashboard-employees')}}" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('dashboard-employees')}}" >
				
				<?php	
									}
									
?>					
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>
				
				
									
									<?php
										$t=0;
										
								foreach($employee_migarnt as $mirga){
								    
								    
								    //  if( $mirga->visa_exp_date!='1970-01-01') 
								    //  {
								     
								    //  if( $mirga->visa_exp_date!='null'){
								    //        if( $mirga->visa_exp_date!=''){
								    //     $t++; 
								    //        }
								    //  } 
								     
								    //  }
								
					  
								}
							
							
									?>
									<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box  red " style="background: linear-gradient(50deg, #ff0101, #4cfa02); padding: 1rem;">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Migrant Employee List
</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{ count($employee_migarnt)}}</h5>
											</div>
											
												<div class="view-more">
											<?php 
										if( $usetype=='employee'){
if(in_array('1', $arrrole))
{
	
	?>
				<a href="{{url('dashboard-migrant-employees')}}" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('dashboard-migrant-employees')}}" >
				
				<?php	
									}
									
?>					
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>
	 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box grn bg-warning-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Right to Work checks
</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
											 <a href="{{url('dashboard-right-works')}}" >	<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
										 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box sky bg-secondary-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/hr.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Recruitment Process 

</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
												<?php 
										if( $usetype=='employee'){
if(in_array('2', $arrrole))
{
	
	?>
				<a href="{{url('recruitmentdashboard')}}" target="_blank" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('recruitmentdashboard')}}" target="_blank" >
				
				<?php	
									}
									
?>						<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
										 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box bg-warning-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/search.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Leave Management


</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
												<?php 
										if( $usetype=='employee'){
if(in_array('3', $arrrole))
{
	
	?>
				<a href="{{url('leavedashboard')}}" target="_blank" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('leavedashboard')}}" target="_blank" >
				
				<?php	
									}
									
?>						<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
									 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box sky bg-primary-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Payroll
</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
											 <a href="#" >	<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box blue bg-warning-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Key Contact

</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
											 <a href="{{url('dashboard/key-contact')}}" >	<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
										<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box grn bg-primary-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Sponsor Management Dossier


</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
											 <a href="{{url('dashboard/sponsor-management-dossier')}}" >	<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
									
										<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box bg-success-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/search.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Monitoring & Reporting 



</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
											<?php 
										if( $usetype=='employee'){
if(in_array('1', $arrrole))
{
	
	?>
				<a href="{{url('dashboard-migrant-employees')}}" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('dashboard-migrant-employees')}}" >
				
				<?php	
									}
									
?>						<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>
											<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box  blue bg-primary-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Message Centre

</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										   
											
												<div class="view-more">
								 <a href="{{url('dashboard/message-center')}}" >
				
				
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>	
									 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box sky bg-success-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Staff Report</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											
										
											  
											</div>
												<div class="view-more">
											 <form  method="post" action="{{ url('document/staff-report-excel') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	
										 <button class="btn btn-default" style="background: none !important;margin-top: 51px;" type="submit"><img src="{{ asset('assets/img/login.png')}}" style="width: 22px;"></button>	
											</form>
											</div>
											
											
											
										  </div>
										</div>
									  </div>
									</div>	
				
					  
					 
			<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box  grn bg-info-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Absent Report</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										   
											
												<div class="view-more">
											<?php 
										if( $usetype=='employee'){
if(in_array('54', $arrrole))
{
	
	?>
				<a href="{{url('dashboard/absent-report')}}" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('dashboard/absent-report')}}" >
				
				<?php	
									}
									
?>					
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>
									
									
					
						<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box  blue bg-success-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Change Of Circumstances</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										   
											
												<div class="view-more">
											<?php 
										if( $usetype=='employee'){
if(in_array('76', $arrrole))
{
	
	?>
				<a href="{{url('dashboard/change-of-circumstances')}}" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('dashboard/change-of-circumstances')}}" >
				
				<?php	
									}
									
?>					
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>
					
				
						<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box  grn bg-info-gradient">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Contract Agreement</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										   
											
												<div class="view-more">
											<?php 
										if( $usetype=='employee'){
if(in_array('78', $arrrole))
{
	
	?>
				<a href="{{url('dashboard/contract-agreement')}}" >
				<?php
}else{
	?>  <a href="#">
				
				<?php
}
									}else{
									?> <a href="{{url('dashboard/contract-agreement')}}" >
				
				<?php	
									}
									
?>					
										
							<img src="{{ asset('assets/img/login.png')}}"></a>
											</div>
											
										  </div>
										</div>
									  </div>
									</div>
									
								
							
									
			<div class="col-lg-12 col-md-12">
			   <div class="visa-head">
			       <h3>Visa Notification</h3>
			     
			   </div> 
			     @if(Session::has('message'))										
										<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
								@endif
			   
			   <div class="card" style="margin-bottom:30px;">
			       <div class="card-body">
			           
			           <div class="table-responsive">
							<table id="basic-datatables" class="display table table-striped table-hover" >
							    <thead>
							        <tr>
							            <th>Employee Code</th>
							            <th>Employee Name</th>
							            <th>Address</th>
							            <th>Passport No.</th>
							            <th>BRP No.</th>
							            <th>Visa Issue Date</th>
							            <th>Visa Expiry Date</th>
							            <th>Visa Reminder - 90 days </th>
										<th>View </th>
										<th>Send </th>
							                <th>Visa Reminder - 60 days </th>
											<th>View </th>
											<th>Send </th>
							             <th>Visa Reminder - 30 days </th>
										 <th>View</th>
										 <th>Send </th>
							            	<th>Email Send</th>
							        </tr>
							    </thead>
							    
							    <tbody>
							        	
									  @foreach($employee_migarnt as $employee)
									   @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')
                                            <tr>
                                           
                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
  @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
                                            


 <td>{{ $employee->pass_doc_no }}</td>
 <td>{{ $employee->visa_doc_no }}</td>
 
 <td>    @if( $employee->visa_issue_date!='1970-01-01') @if( $employee->visa_issue_date!='') {{ date('d/m/Y',strtotime($employee->visa_issue_date)) }} @endif  @endif</td>
 
 <td>    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>
  <td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 90  days'))}} 
  	&nbsp &nbsp  <td><a href="{{url('dashboard/migrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
  	&nbsp
  <td><a href="{{url('dashboard/migrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
						 @endif  @endif</td>

  <td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 60  days'))}}  
  	&nbsp &nbsp <td> <a href="{{url('dashboard/migrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
	  	&nbsp
  <td><a href="{{url('dashboard/migrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

  <td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 30  days'))}} 
   	&nbsp &nbsp  
	   <td><a href="{{url('dashboard/migrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
  	&nbsp
    <td><a href="{{url('dashboard/migrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

 
 <td>
                                               
                                            <a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                            </td>
                                            </tr>
                                             @endif  @endif
                                     @endforeach  
							        
							    </tbody>
							</table>
						</div>
			       </div>
			   </div>
			   
			   
			    <div class="visa-head">
			       <h3>Passport Notification</h3>
			   	</div> 
			    @if(Session::has('pasmessage'))										
						<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('pasmessage') }}</em></div>
				@endif
			   
			   	<div class="card" style="margin-bottom:30px;">
			       <div class="card-body">
			           <div class="table-responsive">
							<table id="pass-datatables" class="display table table-striped table-hover" >
							    <thead>
							        <tr>
							            <th>Employee Code</th>
							            <th>Employee Name</th>
							            <th>Address</th>
							            <th>Passport No.</th>
							            <th>BRP No.</th>
							            <th>Passport Issue Date</th>
							            <th>Passport Expiry Date</th>
							            <th>Passport Reminder - 90 days </th>
										<th>View </th>
										<th>Send </th>
							                <th>Passport Reminder - 60 days </th>
											<th>View </th>
											<th>Send </th>
							             <th>Passport Reminder - 30 days </th>
										 <th>View</th>
										 <th>Send </th>
							            	<th>Email Send</th>
							        </tr>
							    </thead>
							    
							    <tbody>
							        	
									  @foreach($employee_migarnt as $employee)
									   @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='')
                                            <tr>
                                           
                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
											<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
 											 @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
                                            


											<td>{{ $employee->pass_doc_no }}</td>
											<td>{{ $employee->visa_doc_no }}</td>
											
											<td>    @if( $employee->pas_iss_date!='1970-01-01') @if( $employee->pas_iss_date!='') {{ date('d/m/Y',strtotime($employee->pas_iss_date)) }} @endif  @endif</td>
											
											<td>    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{ date('d/m/Y',strtotime($employee->pass_exp_date)) }} @endif  @endif</td>
											<td  style="color:red;">    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{   date('d/m/Y',strtotime($employee->pass_exp_date.'  - 90  days'))}} 
												&nbsp &nbsp  <td><a href="{{url('dashboard/passportmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
												&nbsp
											<td><a href="{{url('dashboard/passportmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
																	@endif  @endif</td>

											<td  style="color:red;">    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{   date('d/m/Y',strtotime($employee->pass_exp_date.'  - 60  days'))}}  
												&nbsp &nbsp <td> <a href="{{url('dashboard/passportmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
													&nbsp
											<td><a href="{{url('dashboard/passportmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

											<td  style="color:red;">    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{   date('d/m/Y',strtotime($employee->pass_exp_date.'  - 30  days'))}} 
												&nbsp &nbsp  
												<td><a href="{{url('dashboard/passportmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
												&nbsp
												<td><a href="{{url('dashboard/passportmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

											
											<td>
																						
															<a href="{{url('dashboard-details/passend-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
															</td>
                                            </tr>
                                             @endif  
											 @endif
                                     @endforeach  
							        
							    </tbody>
							</table>
						</div>
			       </div>
			   </div>
			   
			    <div class="visa-head">
			       <h3>DBS Notification</h3>
			   	</div> 
			    @if(Session::has('pasmessage'))										
						<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('pasmessage') }}</em></div>
				@endif
			   
			   	<div class="card" style="margin-bottom:30px;">
			       <div class="card-body">
			           <div class="table-responsive">
							<table id="dbs-datatables" class="display table table-striped table-hover" >
							    <thead>
							        <tr>
							            <th>Employee Code</th>
							            <th>Employee Name</th>
							            <th>Address</th>
							            <th>DBS Type</th>
							            <th>Reference Number No.</th>
							            <th>Issue Date</th>
							            <th>Expiry Date</th>
							            <th>Reminder - 90 days </th>
										<th>View </th>
										<th>Send </th>
							            <th>Reminder - 60 days </th>
										<th>View </th>
										<th>Send </th>
							             <th>Reminder - 30 days </th>
										 <th>View</th>
										 <th>Send </th>
							            <th>Email Send</th>
							        </tr>
							    </thead>
							    
							    <tbody>
							        	
									  @foreach($employee_migarnt as $employee)
									   @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='')
                                            <tr>
                                           
                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
											<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
 											 @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
                                            


											<td>{{ $employee->dbs_type }}</td>
											<td>{{ $employee->dbs_ref_no }}</td>
											
											<td>    @if( $employee->dbs_issue_date!='1970-01-01') @if( $employee->dbs_issue_date!='') {{ date('d/m/Y',strtotime($employee->dbs_issue_date)) }} @endif  @endif</td>
											
											<td>    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{ date('d/m/Y',strtotime($employee->dbs_exp_date)) }} @endif  @endif</td>
											<td  style="color:red;">    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{   date('d/m/Y',strtotime($employee->dbs_exp_date.'  - 90  days'))}} 
												&nbsp &nbsp  <td><a href="{{url('dashboard/dbsmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
												&nbsp
											<td><a href="{{url('dashboard/dbsmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
																	@endif  @endif</td>

											<td  style="color:red;">    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{   date('d/m/Y',strtotime($employee->dbs_exp_date.'  - 60  days'))}}  
												&nbsp &nbsp <td> <a href="{{url('dashboard/dbsmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
													&nbsp
											<td><a href="{{url('dashboard/dbsmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

											<td  style="color:red;">    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{   date('d/m/Y',strtotime($employee->dbs_exp_date.'  - 30  days'))}} 
												&nbsp &nbsp  
												<td><a href="{{url('dashboard/dbsmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
												&nbsp
												<td><a href="{{url('dashboard/dbsmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

											
											<td>
																						
											<a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
															</td>
                                            </tr>
                                             @endif  
											 @endif
                                     @endforeach  
							        
							    </tbody>
							</table>
						</div>
			       </div>
			   </div>
			   
			    <div class="visa-head">
			       <h3>EUSS Notification</h3>
			   	</div> 
			    @if(Session::has('pasmessage'))										
						<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('pasmessage') }}</em></div>
				@endif
			   
			   	<div class="card" style="margin-bottom:30px;">
			       <div class="card-body">
			           <div class="table-responsive">
							<table id="dbs-datatables" class="display table table-striped table-hover" >
							    <thead>
							        <tr>
							            <th>Employee Code</th>
							            <th>Employee Name</th>
							            <th>Address</th>
							            <th>Reference Number No.</th>
							            <th>Issue Date</th>
							            <th>Expiry Date</th>
							            <th>Reminder - 90 days </th>
										<th>View </th>
										<th>Send </th>
							            <th>Reminder - 60 days </th>
										<th>View </th>
										<th>Send </th>
							             <th>Reminder - 30 days </th>
										 <th>View</th>
										 <th>Send </th>
							            <th>Email Send</th>
							        </tr>
							    </thead>
							    <tbody>
									  @foreach($employee_migarnt as $employee)
									   @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='')
                                            <tr>
                                            <td>{{ $employee->emp_code}}</td>
                                            <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
											<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
 											 @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
											<td>{{ $employee->euss_ref_no }}</td>
											<td>    @if( $employee->euss_issue_date!='1970-01-01') @if( $employee->euss_issue_date!='') {{ date('d/m/Y',strtotime($employee->euss_issue_date)) }} @endif  @endif</td>
											
											<td>    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{ date('d/m/Y',strtotime($employee->euss_exp_date)) }} @endif  @endif</td>
											<td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 90  days'))}} 
												&nbsp &nbsp  <td><a href="{{url('dashboard/eussmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
												&nbsp
											<td><a href="{{url('dashboard/eussmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
																	@endif  @endif</td>

											<td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 60  days'))}}  
												&nbsp &nbsp <td> <a href="{{url('dashboard/eussmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
													&nbsp
											<td><a href="{{url('dashboard/eussmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

											<td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 30  days'))}} 
												&nbsp &nbsp  
												<td><a href="{{url('dashboard/eussmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
												&nbsp
												<td><a href="{{url('dashboard/eussmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>

											
											<td>
																						
											<a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
															</td>
                                            </tr>
                                             @endif  
											 @endif
                                     @endforeach  
							        
							    </tbody>
							</table>
						</div>
			       </div>
			   </div>
			   
			   
			   <div class="visa-head">
			       <h3>Right to Work</h3>
			   </div>
			   
			   <div class="card">
			       <div class="card-body">
			           <div class="table-responsive">
			          <table class="table table-striped" style="width:100%">
			              <thead>
			                  <tr>
			                      <td>Sl. No.</td>
			                      <td>Subject</td>
			                      <td>Link</td>
			                  </tr>
			                  
			              </thead>
			              <tbody>
			                  <tr class="odd">
			                      <td>1</td>
			                      <td>Right to Work</td>
			                      <td><a href="https://www.gov.uk/view-right-to-work" target="_blank">https://www.gov.uk/view-right-to-work</a></td>
			                  </tr>
			              </tbody>
			          </table>
			          </div>
			       </div>
			   </div>
			</div>
									
					  
					 </div>
					 
					
						
						
				</div>
				</div>
				
			</div>
			  @include('dashboard.include.footer')
		</div>
		
		<!-- Custom template | don't include it in your project! -->
		
		<!-- End Custom template -->
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


	<!-- Chart JS -->
	<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			
			$('#pass-datatables').DataTable({
			});
			$('#dbs-datatables').DataTable({
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
	<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script>
	
		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["Part Time", "Full Time", "Contractual" , "Regular","Suspend","Left"],
				datasets : [{
					label: "Total Employees",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [{{ count($employee_parttime)}}, {{ count($employee_fulltime)}}, {{ count($employee_constuct)}}, {{ count($employee_regular)}}, {{ count($employee_suspened)}}, {{ count($employee_ex_empoyee)}}],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							display: false //this will remove only the label
						},
						gridLines : {
							drawBorder: false,
							display : false
						}
					}],
					xAxes : [ {
						gridLines : {
							drawBorder: false,
							display : false
						}
					}]
				},
			}
		});

		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>

	
</body>
</html>