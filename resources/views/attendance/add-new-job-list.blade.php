<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
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
	  @include('recruitment.include.header')
		<!-- Sidebar -->
		
		  @include('recruitment.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		    <div class="page-header">
						<!-- <h4 class="page-title">Recruitment</h4> -->
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
<a href="{{url('recruitment/job-list')}}">Job List</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="#"> New Job List</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									@if(isset($_GET['id']))
                            	
							<h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Job List</h4>
                            	@else
                                
							<h4 class="card-title"><i class="fas fa-briefcase"></i> Add Job List</h4>
                                @endif 
								</div>
								<div class="card-body" style="">
									<form action="" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
									<div class="row">
										
										<div class="col-md-6">
												<div class=" form-group">
												    <label for="inputFloatingLabel-soc-code" class="placeholder">SOC Code</label>
												<input id="inputFloatingLabel-soc-code" type="text" class="form-control input-border-bottom" required="" style="" name="soc" value="<?php if(isset($_GET['id'])){  echo $departments[0]->soc;  }?>{{ old('soc') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
												
												</div>
											</div>


											<div class="col-md-6">
												<div class=" form-group">
												    <label for="inputFloatingLabel-job-title" class="placeholder">Job Title</label>
												<input id="inputFloatingLabel-job-title" type="text" class="form-control input-border-bottom" required="" style="" name="title" value="<?php if(isset($_GET['id'])){  echo $departments[0]->title;  }?>{{ old('title') }}">
												
												</div>
											</div>
	<div class="col-md-6">
											<div class=" form-group">		
											<label for="inputFloatingLabel-job-type" style="" class="placeholder">Select Skill Level</label>
											  <select id="inputFloatingLabel-job-type" type="text" class="form-control input-border-bottom" required="" name="skil_set"  style="margin-top: 24px;">
											  	 <option value="" >&nbsp;</option>
											    <option  value="1"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='1'){ echo 'selected';} } ?>>1</option>
												<option  value="2"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='2'){ echo 'selected';} } ?>>2</option>
												<option  value="3"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='3'){ echo 'selected';} } ?>>3</option>
												<option  value="4"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='4'){ echo 'selected';} } ?>>4</option>
												<option  value="5"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='5'){ echo 'selected';} } ?>>5</option>
												<option  value="6"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='6'){ echo 'selected';} } ?>>6</option>
												<option  value="PhD"  <?php  if(request()->get('id')!=''){  if($departments[0]->skil_set=='PhD'){ echo 'selected';} } ?>>PhD</option>
												
											  </select>
											    
											</div>
										</div>

									
											<div class="col-md-6">
												<div class=" form-group">
												    <label for="inputFloatingLabel-job-title" style=""  class="placeholder">Job Descriptions</label>
												<input id="inputFloatingLabel-job-title" type="text" class="form-control input-border-bottom" required="" style="margin-top: 22px;" name="des_job" value="<?php if(isset($_GET['id'])){  echo $departments[0]->des_job;  }?>{{ old('des_job') }}">
												
												</div>
											</div>
									
									</div>
									<div class="row form-group">

                                       	  <div class="col-md-6"><button type="submit" class="btn btn-default" >Submit</button>
                                       	  </div> 
										</div>
									</form>
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
	</script>
</body>
</html>