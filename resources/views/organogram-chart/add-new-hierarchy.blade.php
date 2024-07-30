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
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
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
		
  @include('organogram-chart.include.header')
		<!-- Sidebar -->
		
		  @include('organogram-chart.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		<div class="page-header">
						<!-- <h4 class="page-title">Organisation Hierarchy</h4> -->
						
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('organogramdashboard')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-home">
								<a href="{{url('organogram-chart/vw-hierarchy')}}">
								Organisation Hierarchy
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="{{url('organogram-chart/add-vw-hierarchy')}}"> Edit Organisation Hierarchy Details </a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title">  <i class="fa fa-sitemap" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Organisation Hierarchy Details</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
										

										<div class="row form-group">
												<div class="col-md-4">
											
											<div class="form-group">
											<label for="selectFloatingLabel" class="placeholder"> Select Employee Code</label>		
											<?php  if(app('request')->input('id')){ 
											
											
											 $employee_auth = DB::table('employee')      
                   
                    ->where('emp_code','=',$shift_management->employee_id) 
                  ->where('emid','=',$shift_management->emid) 
                  ->orderBy('id', 'DESC')
                  ->first(); ?>  
<input type="text" name="employee_id" value="{{ $employee_auth->emp_fname }} {{ $employee_auth->emp_mname }} {{ $employee_auth->emp_lname }} ({{  $shift_management->employee_id  }})"  class="form-control " id="selectFloatingLabel" readonly="1" required="" />

											<?php }else { ?>
												<select  class="form-control " id="selectFloatingLabel"  required=""    name="employee_id" onchange="getEmployeeName()" >
<option value="">&nbsp;</option>
								<?php foreach($employees as $employee){ ?>
								<option value="<?php echo $employee->emp_code; ?>"  ><?php echo $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname." (".$employee->emp_code.") "; ?></option>
								<?php } ?>
					</select>
					<?php } ?>
					
                        
										
												
											</div>
												
											</div>
										   
										   	<div class="col-md-4">
										<div class="form-group">
										    <label for="level" class="placeholder">Select Level</label>
												<select class="form-control input-border-bottom" id="level" required="" name="level">
													<option value="">&nbsp;</option>
													<?php foreach($level as $levelval){ ?>
								<option value="<?php echo $levelval->id; ?>"  <?php  if(app('request')->input('id')){  if($shift_management->level==$levelval->id){ echo 'selected';} } ?>  ><?php echo $levelval->level; ?></option>
								<?php } ?>
												</select>
												
											</div></div>
												<div class="col-md-4">
										<div class="form-group ">
										<label for="emp_designation" class="placeholder">Designation </label>
												<?php  if(app('request')->input('id')){ 
											
											
												 ?>
												<input type="text"   value="{{ $employee_auth->emp_designation }}" class="form-control " id="emp_designation" readonly="1" /> 
												 
												<?php
											 
												}else{
												?>
												<input type="text"    class="form-control " id="emp_designation" readonly="1" /> 
												
												<?php }
												 ?>
												
											</div></div>
										   
	
										</div>

											<div class="row">
											<div class="col-md-4">
										<div class="form-group">
										    	<label for="report_auth" class="placeholder">Have Reporting Authority?</label>
												<select class="form-control input-border-bottom" id="report_auth" required="" name="report_auth">
													<option value="">&nbsp;</option>
													<option value="yes" <?php  if(app('request')->input('id')){  if($shift_management->report_auth=='yes'){ echo 'selected';} } ?>>Yes</option>
													<option value="no" <?php  if(app('request')->input('id')){  if($shift_management->report_auth=='no'){ echo 'selected';} } ?>>No</option>
												</select>
											
											</div></div>
										<div class="col-md-4" >
										<div class="form-group">
											<label for="emp_report_auth_name" class="placeholder">Name of Reporting Authority</label>
												<?php  if(app('request')->input('id')){ 
											
											 if(!empty($employee_auth->emp_reporting_auth)){
											$employee_report_auth = DB::table('employee')      
                   
                    ->where('emp_code','=',$shift_management->emp_report_auth) 
					 ->where('emp_code','=',$employee_auth->emp_reporting_auth) 
                  ->where('emid','=',$shift_management->emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
							

											 }	
											 ?>  
<input type="text" name="emp_report_auth_name"  @if(!empty($employee_auth->emp_reporting_auth)) value="{{ $employee_report_auth->emp_fname }} {{ $employee_report_auth->emp_mname }} {{ $employee_report_auth->emp_lname }} ({{  $shift_management->emp_report_auth  }})"  @endif class="form-control input-border-bottom" id="emp_report_auth_name" readonly="1" />


<input type="hidden" name="emp_report_auth"  value="{{ $shift_management->emp_report_auth }}" class="form-control input-border-bottom" id="emp_report_auth"  />

											<?php }else { ?>
											
									<input type="text" name="emp_report_auth_name" value=""  class="form-control " id="emp_report_auth_name" readonly="1"  />
		<input type="hidden" name="emp_report_auth"   class="form-control input-border-bottom" id="emp_report_auth"  />

											<?php } ?>
											
											</div>
										</div>
										<div class="col-md-4">
										<div class="form-group">
										    <label for="level_report" class="placeholder">Level of reporting Authority</label>
												<select class="form-control input-border-bottom" id="level_report"  name="level_report">
													<option value="">&nbsp;</option>
													<?php foreach($level as $levelval){ ?>
								<option value="<?php echo $levelval->id; ?>"  <?php  if(app('request')->input('id')){  if($shift_management->level_report==$levelval->id){ echo 'selected';} } ?>  ><?php echo $levelval->level; ?></option>
								<?php } ?>
												</select>
												
											</div></div>
											
											<div class="col-md-4">
										<div class="form-group ">
										<label for="emp_designation" class="placeholder">Designation (Reporting Authority)</label>
												<?php  if(app('request')->input('id')){ 
											
											 if(!empty($employee_auth->emp_reporting_auth)){
												

											 }												
												 ?>
												<input type="text"   @if(!empty($employee_auth->emp_reporting_auth)) value="{{ $employee_report_auth->emp_designation }}"  @endif class="form-control " id="emp_designation_ath" readonly="1" /> 
												 
												<?php
											 
												}else{
												?>
												<input type="text"    class="form-control " id="emp_designation_ath" readonly="1" /> 
												
												<?php }
												 ?>
												
											</div></div>
										
										</div>
											<div class="row form-group">
											
										    <div class="col-md-4">
										    <div class="sub-reset-btn">	
								     		<a href="#">	
										    <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Submit</button></a>
											<!-- <i class="fas fa-ban reset-ban-icon"></i> -->
										    <a href="#">	
										    <button class="btn btn-default" type="submit" style=" background-color: #1572E8!important; color: #fff!important;">Reset</button></a>
										    </div>

								     		</div>
											</div>	



									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
				 @include('organogram-chart.include.footer')
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
		   
   function chngdepartment(empid){
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("designation").innerHTML = response;
		}
		});
   }
   
   function getEmployeeName()
	{	
		//$('#emplyeename').show();		
		var emp_code = $("#selectFloatingLabel option:selected").text();
		var empid = $("#selectFloatingLabel option:selected").val();
		var name = emp_code.split("(");
		
$.ajax({
				type:'GET',
				url:'{{url('organo/get-employee-all-organo-details')}}/'+empid,
				success: function(response){


 

				  
				   var obj = jQuery.parseJSON(response);
				  console.log(obj);
				  
					  var emp_designation=obj[0].emp_designation; 
$("#emp_designation").val(emp_designation); 
				   var emp_reporting_auth=obj[0].emp_reporting_auth; 
				  
				   if(obj[1]!=''){
					  var emp_designation_auth=obj[1].emp_designation; 
				
				 $("#emp_designation_ath").val(emp_designation_auth);
				 var emp_report_auth=obj[1].emp_code;
 $("#emp_report_auth").val(emp_report_auth); 
var emp_report_auth_name1=obj[1].emp_fname +"  "; 
	var emp_report_auth_name2=obj[1].emp_mname + "  "; 
var emp_report_auth_name3=obj[1].emp_lname;
 	var emp_report_auth_name4="  ( " + obj[1].emp_code + " ) ";
	 var value = emp_report_auth_name1.concat(emp_report_auth_name2,emp_report_auth_name3,emp_report_auth_name4);  
  $("#emp_report_auth_name").val(value);
$("#report_auth").val("yes");  
				   }else{
					   $("#emp_designation_ath").val('');
					    $("#emp_report_auth_name").val('');
						 $("#emp_report_auth").val('');
						 $("#report_auth").val("no"); 
				   }
				    			 
			  
				}
			});
		
			


		//$("#emp_name").attr("readonly", true);  
	}
	</script>
</body>
</html>