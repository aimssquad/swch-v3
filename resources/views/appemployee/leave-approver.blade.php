<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<link rel="icon" href="assetsemcor/img/icon.ico" type="image/x-icon"/>
	
	<!-- Fonts and icons -->
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
	<style>
		.main-panel{margin-top:0;}
		.nav-item active{
			
		}
	.btn-default.not-approved {
    background-color: #FFC107!important;
    text-align: center!important;
    padding: 10px 10px!important;
}.btn-default.approved {
    background-color: #25D366!important;
    text-align: center!important;
    padding: 10px 22px!important;
}

.btn-default.recomand {
    background-color: #17A2B8!important;
    text-align: center!important;
    padding: 10px 22px!important;
}
.btn-default.reject {
    background-color: #FF0000!important;
    text-align: center!important;
    padding: 10px 22px!important;
}


	</style>
</head>
<body>
	<div class="wrapper">
	 @include('leave-approver.include.header')
		<!-- Sidebar -->
		
		  @include('leave-approver.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
	
			<div class="content">
				<div class="page-inner">
				
								<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Leave Application Details</h4>
									  @if(Session::has('message'))
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif
							  @if(Session::has('error'))
								<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-cross" ></span><em > {{ Session::get('error') }}</em></div>
							@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover"  >
											<thead style="background:#2caaed; color:white;">
												<tr>
													<th>Sl No.</th>
													<th>Employment Type</th>
													<th>Employee Code</th>
													<th>Name</th>
													<th>Leave Type</th>
													<th>From Date</th>
													<th>To Date</th>
													<th>Date Of Application</th>
													<th>No. Of Leave</th>	
													<th>Status</th>												
													<th>Remarks(If any)</th>
													@if(Session::get('user_type')=='employee')
													<th>Action</th>
												  @endif
													
													
												</tr>
											</thead>
											
											<tbody>
											@if(count($LeaveApply)>0)
	
                                                @foreach($LeaveApply as $lvapply)
                                                <?php  $leaveapplyDate = date("d-m-Y", strtotime($lvapply->date_of_apply));

                                                $leaveapplyfromDate = date("d-m-Y", strtotime($lvapply->from_date));

                                                $leaveapplytoDate = date("d-m-Y", strtotime($lvapply->to_date));
$pemail = Session::get('emp_email');
     $Roledata = DB::table('registration')      
                 
                  ->where('email','=',$pemail) 
                  ->first();
 $job_details=DB::table('employee')->where('emp_code', '=', $lvapply->employee_id )->where('emid', '=', $Roledata->reg )->orderBy('id', 'DESC')->first();
  			
     



												?>
												
                                                <tr>
                                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
													   <td style="text-align:center;">{{$job_details->emp_status}}</td>
                                                    <td style="text-align:center;">{{$lvapply->employee_id}}</td>
                                                    <td style="text-align:center;"><span class="name">{{$job_details->emp_fname}} {{$job_details->emp_mname}} {{$job_details->emp_lname}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{$lvapply->leave_type_name}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{$leaveapplyfromDate}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{$leaveapplytoDate}}</span></td>
                                                    <td style="text-align:center;"><span class="date">{{$leaveapplyDate}}</span></td>
						                            <td style="text-align:center;"><span class="name">{{$lvapply->no_of_leave}}</span></td>
													
                                                    <td style="text-align:center;">
                                                        @if($lvapply->status=='NOT APPROVED')
                                                       
														<!-- <a href="#"><button class="btn btn-default not-approved" type="submit"> {{$lvapply->status}}</button></a> -->
														<a href="#"><button class="badge badge-warning" type="submit">{{$lvapply->status}}</button></a>

												
                                                        @elseif($lvapply->status=='REJECTED')
														<!-- <a href="#"><button class="btn btn-default reject" type="submit">{{$lvapply->status}}</button></a> -->
												
                                                        <span class="badge badge-danger">{{$lvapply->status}}</span>
                                                        @elseif($lvapply->status=='APPROVED')
                                                       
													<a href="#"><button class="badge badge-success" type="submit">{{$lvapply->status}}</button></a>
													
                                                        @elseif($lvapply->status=='RECOMMENDED')

														<!-- <a href="#"><button class="btn btn-default recomand" type="submit">{{$lvapply->status}}</button></a> -->
														<a href="#"><button class="badge badge-info" type="submit">{{$lvapply->status}}</button></a>

                                                        @elseif($lvapply->status=='CANCEL')
                                                   
														<a href="#"><button class="btn btn-default reject" type="submit">{{$lvapply->status}}</button></a>
                                                        @endif
                                                    </td>
												
                                                    
                                                    <td>{{ $lvapply->status_remarks }}</td>
                                                   
															
                                                    
                                                    

                                                   
                                                      @if(Session::get('user_type')=='employee')
														   <td>
														   @if($lvapply->status=='RECOMMENDED' || $lvapply->status=='NOT APPROVED')
                                                        <a href="{{url('appleave-approver/leave-approved-right')}}?id={{base64_encode($lvapply->id)}}&empid={{base64_encode($lvapply->employee_id)}}"><img  style="width: 30px;" src="{{ asset('assets/img/edit.png')}}"></a>
                                                        @endif
														</td>
														  @endif
                                                    

                                                </tr>

                                             @endforeach
											 @endif
												
												
											</tbody>
										</table>
									</div>
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
			function calculateDays(){
			var from_date= $("#inputFloatingLabel1").val();
			var to_date= $("#inputFloatingLabel2").val();
			var fromdate = new Date(from_date);
			var todate = new Date(to_date);
			var diffDays = (todate.getDate() - fromdate.getDate()) + 1 ;
			$("#inputFloatingLabel3").val(diffDays);
		}
	</script>
</body>
</html>