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
								<a href="{{url('recruitment/ca-assessment-report')}}">Cognitive Ability Assessment Report</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-briefcase"></i> Cognitive Ability Assessment Report
<!-- <span>		<a  data-toggle="tooltip" data-placement="bottom" title="Add New Interview Form" href="{{ url('recruitment/add-interview-form') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>	</h4> -->
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
									
								</div>
								<div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
			                            {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group ">
                                                    <label for="job_id" class="placeholder">Position Name</label>
                                                    
                                                    <select id="job_id" name="job_id"  class="form-control" required>
                                                        <option value=""> Select Postion</option>
                                                        @foreach($joblist as $record)
                                                        <option value="{{$record->id}}" @if(isset($job_id) && $job_id==$record->id) selected @endif>{{$record->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group ">
                                                    <label for="form_id" class="placeholder">Interview Form</label>
                                                    
                                                    <select id="form_id" name="form_id"  class="form-control" required>
                                                        <option value=""> Select Form</option>
                                                        @foreach($int_forms as $record)
                                                        <option value="{{$record->id}}" @if(isset($form_id) && $form_id==$record->id) selected @endif>{{$record->form_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group ">
                                                   <br>
                                                    <button type="submit" style="margin-top: 8px;" class="btn btn-default" >View Report</button>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </form>
								</div>
								@if(isset($interview_form_ca) && count($recruitment_interviews)>0)
								<div class="card-body">
                                    <form action="{{ url('recruitment/ca-assessment-report-pdf') }}" method="post" enctype="multipart/form-data">
			                            {{csrf_field()}}
                                        <input type="hidden" name="job_id" value="{{$job_id}}">
                                        <input type="hidden" name="form_id" value="{{$form_id}}">
                                        <button type="submit"  class="btn btn-default" style="margin-bottom:10px;float:right;"><i class="fa fa-download"></i>&nbsp;Download Report</button>
                                    
                                    </form>
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl. No.</th>
													<th>Candidate Name</th>
													<th>Assesment Date</th>
													@foreach($interview_form_ca as $rec)
													<th>{{ $rec->cognitive_ability_name }}</th>
													@endforeach
													<th>Total Score</th>
													<th>Comment</th>
                                                </tr>
											</thead>
											
											<tbody>
												<?php $i = 1; ?>
												@foreach($recruitment_interviews as $record)
												<tr>
													<td><?php echo $i++; ?></td>
													<td>{{ $record->candidate_name }}</td>
													<td>{{ $record->interview_date }}</td>
													@foreach($interview_form_ca as $rec)
													<td>
														@php
															$ca=DB::table('mock_factor_details')->where('mock_factor_details.mock_interview_id', '=', $record->id)->where('mock_factor_details.form_cognitive_ability_id', '=', $rec->id)->first();
															//print_r($ca);
														@endphp
														{{$ca->caf_score}}
													</td>
													@endforeach
													<td>{{ $record->caf_score }}</td>
													<td>{{ $record->recommendation }}</td>
												</tr>
												@endforeach  
											</tbody>
										</table>
									</div>
								</div>

								@endif
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