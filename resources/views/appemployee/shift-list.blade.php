<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
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
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
	
</head>
<body>
	<div class="wrapper">

		<div class="main-panel">
	
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-clock" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Shift Management<span>		
									<a href="{{ url('approta/add-shift-management/'.base64_encode($Roledata->reg)) }}" data-toggle="tooltip" data-placement="bottom" title="Add Shift Management" ><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>	
							</h4>
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
									
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Shift Code</th>
													<th>Shift Description</th>
													<th>Work In Time</th>
													<th>Work Out Time</th>
													<th>Break Time From</th>
													<th>Break Time To</th>
													<th>Action</th>
												
														</tr>
											</thead>
											
											<tbody>
												   <?php $i = 1; ?>
									@foreach($employee_type_rs as $candidate)
									@php
                                                
                                                $duty_roaster=DB::table('duty_roster')->where('emid', '=',
                                                $Roledata->reg)->where('shift_code', '=',
                                                $candidate->id)->get();

												//dd($duty_roaster);

                                                @endphp
                                        <tr>
                                            
											<td>{{ $candidate->shift_code }}</td>
                                            <td>{{ $candidate->shift_des }}</td>
											 <td>{{ date('h:i a',strtotime($candidate->time_in)) }}</td>
											  <td>{{ date('h:i a',strtotime($candidate->time_out)) }}</td>
											   <td>{{ date('h:i a',strtotime($candidate->rec_time_in)) }}</td>
											    <td>{{ date('h:i a',strtotime($candidate->rec_time_out)) }}</td>
												
                                            <td>
											@if(count($duty_roaster)==0)
												<a href="{{url('approta/add-shift-management/'.base64_encode($Roledata->reg).'/')}}?id={{$candidate->id}}" data-toggle="tooltip" data-placement="bottom" title="Edit"  ><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}"></a>
											@endif

						
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