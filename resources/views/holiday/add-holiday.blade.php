<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
	<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<!-- Fonts and icons -->
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
	 @include('holiday.include.header')
		<!-- Sidebar -->
		
		  @include('holiday.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		<div class="page-header">
						<!-- <h4 class="page-title">Holiday Management</h4> -->
							
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
								<a href="{{url('holidays')}}">
								Holiday List
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="{{url('holiday/add-holiday')}}"> Edit Holiday List</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
								
											@if(isset($holidaydtl) && !empty($holidaydtl))
                            	
							<h4 class="card-title"> <i class="far fa-calendar" aria-hidden="true" style="color:#10277f;"></i>&nbsp; Edit Holiday List</h4>
                            	@else
                                
							<h4 class="card-title"> <i class="far fa-calendar" aria-hidden="true" style="color:#10277f;"></i>  Add Holiday List</h4>
                                @endif 
								</div>
								<div class="card-body">
									 <form action="{{ url('holiday/add-holiday') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
									  
			 {{csrf_field()}}
			 <input type="hidden" name="id" value="<?php  if(!empty($holidaydtl->id)){echo $holidaydtl->id;} ?>">
										<div class="row form-group">
											<div class="col-md-3"><div class="form-group ">
											    <label for="inputFloatingLabel1" class="placeholder">From Date</label>
												<input id="inputFloatingLabel1" type="date" class="form-control "  required="" name="from_date"  value="<?php  if(!empty($holidaydtl->from_date)){echo $holidaydtl->from_date;} ?>" >
												
												@if ($errors->has('from_date'))
											<div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
										@endif
											</div>
											</div>
											
											<div class="col-md-3"><div class="form-group ">
											    	<label for="inputFloatingLabel2" class="placeholder">To Date</label>
												<input id="inputFloatingLabel2" type="date" class="form-control " name="to_date"  required=""  value="<?php  if(!empty($holidaydtl->to_date)){echo $holidaydtl->to_date;} ?>"  onchange="calculateDays()" onclick="calculateDays()">
											
												@if ($errors->has('to_date'))
											<div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
										@endif
											</div></div>
											<div class="col-md-3">
											
												<div class="form-group ">
											<label for="selectFloatingLabel" class="placeholder">Day</label>
													<select class="form-control input-border-bottom" id="selectFloatingLabel" required="" name="weekname"  required="">
												<option value="sunday" <?php if(!empty($holidaydtl->weekname)){ if("sunday"== $holidaydtl->weekname) { echo "selected"; } } ?>>Sunday</option>
												<option value="monday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'monday'){ echo "selected"; } } ?>>Monday</option>
												<option value="tuesday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'tuesday'){ echo "selected"; } } ?>>Tuesday</option>
												<option value="wednesday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'wednesday'){ echo "selected"; } } ?>>Wednesday</option>
												<option value="thrusday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'thrusday'){ echo "selected"; } } ?>>Thursday</option>
												<option value="friday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'friday'){ echo "selected"; } } ?>>Friday</option>
												<option value="saturday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'saturday'){ echo "selected"; } } ?>>Saturday</option>
												
											</select>
											
												
												@if ($errors->has('weekname'))
												<div class="error" style="color:red;">{{ $errors->first('weekname') }}</div>
											@endif
											</div>
												
											</div>
											<div class="col-md-3">
												
												<div class="form-group">
												    	<label for="selectFloatingLabel" class="placeholder">Holiday Type</label>
											
												<select class="form-control input-border-bottom" id="selectFloatingLabel" required="" name="holiday_type">
											  @foreach($holiday_type as $value):
                 <option value="{{ $value->id }}" <?php if(!empty($holidaydtl->holiday_type)){ if($value->id== $holidaydtl->holiday_type) { echo "selected"; } } ?>>
                                             {{ $value->name }} 
                                         </option>
                                        @endforeach
										</select>
											
												@if ($errors->has('holiday_type'))
												<div class="error" style="color:red;">{{ $errors->first('holiday_type') }}</div>
											@endif
											</div>
												
											</div>
										
										</div>
										
										<div class="row form-group">
											<div class="col-md-3">
												<div class="form-group ">
												    	<label for="inputFloatingLabel3" class="placeholder">No. of Days</label>
												<input id="inputFloatingLabel3" type="text" class="form-control " required=""  name="day" value="<?php  if(!empty($holidaydtl->day)){echo $holidaydtl->day;} ?>"  readonly>
											
												@if ($errors->has('day'))
											<div class="error" style="color:red;">{{ $errors->first('day') }}</div>
										@endif
											</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
												    <label for="inputFloatingLabel4" class="placeholder">Holiday Description</label>
												<input id="inputFloatingLabel4" type="text" class="form-control input-border-bottom" required="" name="holiday_descripion" value="<?php  if(!empty($holidaydtl->holiday_descripion)){echo $holidaydtl->holiday_descripion;} ?>">
												
												@if ($errors->has('holiday_descripion'))
											<div class="error" style="color:red;">{{ $errors->first('holiday_descripion') }}</div>
										@endif
											</div>
											</div>
											</div>
												<div class="row form-group">
											<div class="col-md-3">
										<button type="submit" class="btn btn-default">Submit</button>
										</div>
										</div>
										
										
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('holiday.include.footer')
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