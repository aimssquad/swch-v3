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
		
  @include('recruitment.include.header')
		<!-- Sidebar -->
		
		  @include('recruitment.include.sidebar')
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
							<li class="nav-item active">
								<a href="{{url('recruitment/interviews')}}">Interviews</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-briefcase"></i> Interviews
<!-- <span>		<a  data-toggle="tooltip" data-placement="bottom" title="Add New Interview Form" href="{{ url('recruitment/add-interview-form') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>	</h4> -->
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
									
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl. No.</th>
													<th>Job Title</th>
													<th>Form Name</th>
													<th>Candidate</th>
													<th>Industry</th>
													<th>Interview Date</th>
													<th>Interview Time</th>
													<th>Capstone Score</th>
													<th>Cognitive Ability Score</th>
													
													<th>Action</th>			
                                                </tr>
											</thead>
											
											<tbody>
												   <?php $i = 1; ?>
									@foreach($recruitment_interviews as $record)
                                        <tr>
                                            <td><?php echo $i++; ?></td>
											<td>{{ $record->title }}</td>
											<td>{{ $record->form_name }}</td>
											<td>{{ $record->candidate_name }}</td>
											<td>{{ $record->category_name }}</td>
											<td>{{ date('d-M-Y',strtotime($record->interview_date)) }}</td>
											<td>{{ $record->interview_time }}</td>
											<td>{{ $record->capstone_score }}</td>
											<td>{{ $record->caf_score }}</td>
                                            <td class="drp">
												<div class="dropdown">
													<button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														@if($record->feedback_submitted=='Y')
														<a class="dropdown-item" href="{{url('recruitment/interview/')}}/{{$record->id}}"><i class="far fa-eye"></i>&nbsp; View Interview</a> 
														@else
														<a class="dropdown-item" href="{{url('recruitment/interview/edit/')}}/{{$record->id}}"><i class="far fa-edit"></i>&nbsp; Edit Interview</a>
														@endif

														<a class="dropdown-item" href="{{url('recruitment/interview-feedback/')}}/{{$record->id}}"><i class="fa fa-comment"></i>&nbsp; Feedback</a>

														@if($record->feedback_submitted=='Y')
														<a class="dropdown-item" href="{{url('recruitment/interview-feedback-report/')}}/{{$record->id}}"><i class="fa fa-download"></i>&nbsp; Download Summary Report</a>
														@endif
														<hr>
														<a class="dropdown-item" style="color:red;" href="javascript:void;" onclick="deleteInterview({{$record->id}});"><i class="fa fa-trash"></i>&nbsp; Delete Interview</a>
													
													</div>
												</div>
						
											</td>
                                        </tr>
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
				 @include('recruitment.include.footer')
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

		function deleteInterview(interview_id){
			if (confirm("Are you sure of deleting the interview?") == true) {
				var url="{{url('recruitment/delete-interview/')}}"+'/'+interview_id;
				window.location.href=url;
			}
		}
	</script>
</body>
</html>