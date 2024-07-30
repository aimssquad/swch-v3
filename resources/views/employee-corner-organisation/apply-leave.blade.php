<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assetsemcor/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">
		
 		
  @include('employee-corner.include.header')
		<!-- Sidebar -->
		
		  @include('employee-corner.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		    	<div class="page-header">
					
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									Home
								</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item">
								<a href="#">Employee Access Value</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="{{url('employee-corner/leave-apply')}}">Leave application</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
				
				<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								
								<div class="card-body">
									 <form action="#" method="post" enctype="multipart/form-data">
							<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="employee_id" value="{{$employee->emp_code}}">
                                     <input type="hidden" name="employee_name" value="{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}">
                                     
										<div class="row form-group">
								            <div class="col-md-6">
								            	<div class="pay-slip-heading">
								            		<h4 class="card-title">Leave Application</h4>
													 @if(Session::has('Leave_msg'))										
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('Leave_msg') }}</em></div>
							@endif	
								            	</div>
								            </div>
								            <div class="col-md-6">
								            	<div class="pay-slip-heading">
								            		<h4 class="card-title holiday"><a style="color: #4e9d05;" href="{{ url('employee-corner/holiday') }}" target="_blank"><i class="far fa-calendar-alt calender-icon"></i>Holiday Calender</a></h4>
								            	</div>
								            </div>
								           </div> 
								          <div class="row form-group">
											<div class="col-md-3">
												<div class="app-form-text">
													<h5>Employment Type:<span>{{$employee->emp_status}}</span></h5>
												</div>
											</div>
											<div class="col-md-3">
												<div class="app-form-text">
													<h5>Employee Code:<span>{{$employee->emp_code}}</span></h5>
												</div>
											</div>
											<div class="col-md-3">
												<div class="app-form-text">
													<h5>Employee Name:<span>{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}</span></h5>
												</div>
											</div>
											<div class="col-md-3">
												<div class="app-form-text date">
													<h5>Date Of Application:<span>
													     <input type="date" name="date_of_apply" required>
								
													    <!--<?php echo date('d/m/Y'); ?>--></span></h5>
												</div>
											</div>
											
										</div>
 

										  <div class="row form-group">
                                            	
										   <div class="col-md-4">
										  	<div class=" form-group form-floating-label">		
										  

										  	  <select  id="leave_type" name="leave_type" onchange="getLeaveInHand(this.value);"  class="form-control input-border-bottom" required=""  style="margin-top: 20px;">
											   
											   <option  value="">&nbsp;</option>
												@foreach($leave_type_rs as $leave)
                                                <option value="{{$leave->id}}">{{$leave->leave_type_name}}</option>
											@endforeach
											  </select>
										  	<label for="leave_type" class="placeholder">Leave Type</label>
										  </div>
										  </div>


										  
										

								     	<div class="col-md-4">
	<label for="leave_inhand" class="placeholder">Leave In Hand</label>

								     		  <input  type="text"readonly="" name="leave_inhand" class="form-control"  id="leave_inhand" required=""   placeholder="" style="margin-top: 25px;">
											    
										   @if ($errors->has('leave_inhand'))
                                        <div class="error" style="color:red;">{{ $errors->first('leave_inhand') }}</div>
                                    @endif
								     	
								     			
								     	</div>

								     	  <div class="col-md-4">
												<div class=" form-group form-floating-label">
												
												<input type="date" id="from_date" name="from_date"  value="{{ old('from_date') }}""  type="date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
												<label for="from_date"  class="placeholder">Form Date</label>
@if ($errors->has('from_date'))
											<div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
										@endif
									           </div>
								         	</div>	


								    </div> 	
								     <div class="row form-group">	

								     	  <div class="col-md-4">
												<div class=" form-group form-floating-label">
												
												<input  id="to_date" name="to_date" value="{{ old('to_date') }}" onchange="get_duration()" type="date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
												<label for="to_date"  class="placeholder">To Date</label>
@if ($errors->has('to_date'))
											<div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
										@endif
									        	</div>		
								     	   	</div>

								     	  <div class="col-md-4">
<label for="days" class="placeholder">No. Of Days</label>
								     		  <input   name="days" class="form-control" id="days"  type="text" readonly="" class="form-control input-border-bottom" required=""  placeholder="" style="margin-top: 25px;">
											   
											  
										  	

								     	
								     			
								     	</div>

								   </div>

								     <div class="row form-group">	
                                       	<div class="col-md-6">
										    	<a class="apply" href="#">	
										        <button class="btn btn-default apply" type="submit">Apply</button>
										       </a>
										       <a class="apply" href="#">	
										        <button class="btn btn-default apply" type="submit">Reset</button>
										       </a> 
										</div>
									
								     </div> 	



									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
				 @include('employee-corner.include.footer')
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
		
		
		function getLeaveInHand(leavetype_id)
		{	
			
			$.ajax({
				type:'GET',
				url:'{{url('leave/get-leave-in-hand')}}/'+leavetype_id,				
				success: function(response){
				console.log(response); 
    				if(response==0){

                          $('#leave_inhand').val(null);
                        $("#from_date").attr('readonly', true);
                        $("#to_date").attr('readonly', true);

                    }else{

                        $("#leave_inhand").val(response);
                        $("#from_date").attr('readonly', false);
                        $("#to_date").attr('readonly', false);
                        $('#days').val('');
                        $("#from_date").val('');
                        $("#to_date").val('');
                    }
				}
			});

            
            /*if(($("#leave_inhand").val()) == '0')
            { 
                alert('hi');
                $('#days').attr('readonly', true);
                $("#from_date").attr('readonly', true);
                $("#to_date").attr('readonly', true);
            }*/
		}
		     
function get_duration()
{
    var from_date= $("#from_date").val();
    var to_date= $("#to_date").val();
    var leave_type = $("#leave_type option:selected").val();
    var lvinhand = $('#leave_inhand').val();
    var cl_type = 'full';

var date1 = new Date(from_date);
var date2 = new Date(to_date);
var diffTime = Math.abs(date2 - date1);
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 


if(diffDays=='0'){

$('#days').val('1');
}else{
var diffDays=Math.abs(diffDays +1);
$('#days').val(diffDays);
}
   
        
}   

	</script>
</body>
</html>