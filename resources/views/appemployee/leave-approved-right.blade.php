<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}'] },
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
	<style>.main-panel{margin-top:0;}</style>
</head>
<body>
	<div class="wrapper">
		
 		
 
		<!-- End Sidebar -->
		<div class="main-panel">
		
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title">Leave Approval Details</h4>
								</div>
								<?php
							
 $job_details=DB::table('employee')->where('emp_code', '=', $LeaveApply->employee_id )->where('emid', '=', $Roledata->reg )->orderBy('id', 'DESC')->first();
  			
			?>
								<div class="card-body">
								   <form action="{{url('appleave-approver/leave-approved-right-save')}}" method="post" enctype="multipart/form-data" >
								
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								  <input type="hidden" name="apply_id" value="{{ $LeaveApply->id }}">
								   <input type="hidden" name="employeenew_id" value="{{ $employee_id }}">
								  
								<input type="hidden" name="employee_id" value="{{ $LeaveApply->employee_id }}">
								 <input type="hidden" name="no_of_leave" value="{{ $LeaveApply->no_of_leave }}">
								<input type="hidden" name="leave_type" value="{{ $LeaveApply->leave_type}}">
							
                                <input type="hidden" name="month_yr" value="{{ date("Y", strtotime($LeaveApply->from_date))}}">
										<div class="row form-group">
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Employment Type:<span>{{$job_details->emp_status}}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Employee Code:<span>{{ $LeaveApply->employee_id }}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Employee Name:<span>{{$job_details->emp_fname}} {{$job_details->emp_mname}} {{$job_details->emp_lname}}</span></h5>
												</div>
											</div>
											
										</div>
										<input type="hidden" id="current_status" value="{{ $LeaveApply->status }}">
                                        <!-- 2nd Row -->
										<div class="row form-group">
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Leave Type:<span>{{ $LeaveApply->leave_type_name }}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>Leave Status:<span>{{ $LeaveApply->status }}</span></h5>
												</div>
											</div>
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>No. Of Leave:<span>{{ $LeaveApply->no_of_leave }}</span></h5>
												</div>
											</div>
																						
										</div>
										<!-- 3rd row -->

										<div class="row form-group">
											<div class="col-md-4">
												<div class="app-form-text">
													<h5>From Date:<span>{{ $leaveapplyfromDate = date("d/m/Y", strtotime($LeaveApply->from_date)) }}</span></h5>
												</div>
											</div>

											<div class="col-md-4">
												<div class="app-form-text">
													<h5>To Date:<span>{{ $leaveapplytoDate = date("d/m/Y", strtotime($LeaveApply->to_date)) }}</span></h5>
												</div>
											</div>
											
										
											
										</div>
									 

										<!-- Table -->

                                   	<div class="row form-group">
                                   		<div class="col-md-12">
                                   			<div class="table-heading">
                                   				<h2>List of Last Three Approved Leave</h2>
                                   			</div>
                                   			
                                   			<table id="" class="display table table-striped table-hover" >
											<thead>
												<tr class="table-th-bg">
													<th>SL No.</th>
                                                    <th>From Date</th>
													<th>To Date</th>
													<th>Date Of Application</th>
													<th>No.of Leave</th>
													<th>Approved Date</th>		
												</tr>
											</thead>
											
											<tbody>
											
												<?php 
												
												if(count($Prev_leave)!=0){
													?>
													 @foreach($Prev_leave as $lvapply)
                                                
                                                <tr class="table-tr">
                                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                                                    <td style="text-align:center;"><span class="product">{{\Carbon\Carbon::parse($lvapply->from_date)->format('d/m/Y')}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{\Carbon\Carbon::parse($lvapply->to_date)->format('d/m/Y')}}</span></td>
                                                    <td style="text-align:center;"><span class="date">{{\Carbon\Carbon::parse($lvapply->date_of_apply)->format('d/m/Y')}}</span></td>
													 <td style="text-align:center;"><span class="date">{{ $lvapply->no_of_leave }}</span></td>
                                                    <td style="text-align:center;"><span class="name">{{\Carbon\Carbon::parse($lvapply->updated_at)->format('d/m/Y')}}</span></td>
                                                    
                                                </tr>
                                             @endforeach
												
												<?php
												}
												else{ ?>
													
												  <tr class="table-tr">
                                                    <td class="serial" style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;">No Data Found.</td>
													 <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    
                                                </tr>	
												<?php }
												 ?>

												
											</tbody>
										</table>
                                   			
                                   		</div>
                                 </div>	

                                 <!-- Leave request Status -->


                                     <div class="row form-group">
                                
											<div class="col-md-4 ">
											<div class=" form-group form-floating-label">		
											
											  <select id="leave_status" type="text" class="form-control input-border-bottom"  name="leave_check" id="leave_status" onchange="remarkStatus();" required  style="margin-top: 10px;">
											    
												<option value="">Select</option>
												<option  value="NOT APPROVED" <?php  if($LeaveApply->status!=''){  if($LeaveApply->status=='NOT APPROVED'){ echo 'selected';} } ?> >Not Approved</option>
                                                <option value="APPROVED" <?php  if($LeaveApply->status!=''){  if($LeaveApply->status=='APPROVED'){ echo 'selected';} } ?> >Approved</option>
                                                <option value="RECOMMENDED" <?php  if($LeaveApply->status!=''){  if($LeaveApply->status=='RECOMMENDED'){ echo 'selected';} } ?> >Recommended</option>
                                                <option  value="REJECTED" <?php  if($LeaveApply->status!=''){  if($LeaveApply->status=='REJECTED'){ echo 'selected';} } ?> >Rejected</option>
                                                <option  value="CANCEL" <?php  if($LeaveApply->status!=''){  if($LeaveApply->status=='CANCEL'){ echo 'selected';} } ?> >Cancel</option>
											  </select>
											    <label for="leave_status" style="font-size: 14px!important;" class="placeholder">Leave Request Status</label>
											</div>
										</div>

										
											<div class="col-md-4">
											<div class=" form-group form-floating-label">		
											
											  <input id="status_remarks" type="text"  name="status_remarks"   value="<?php  if(!empty($LeaveApply->status_remarks)){ echo $LeaveApply->status_remarks;} ?>" class="form-control input-border-bottom"  >
												
											    <label for="status_remarks" style="font-size: 14px!important;" class="placeholder">Remarks</label>
											</div>
										</div>
										
										
										<div class="col-md-4">
										    	<a class="apply" href="#">	
										        <button class="btn btn-default apply" type="submit">Apply</button>
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
				 @include('leave-approver.include.footer')
		</div>
		
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('assetsemcor/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('assetsemcor/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assetsemcor/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assetsemcor/js/setting-demo2.js')}}"></script>
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