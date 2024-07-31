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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
</head>
<body>
	<div class="wrapper">
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
							<!-- <h4 class="page-title">Employee Management</h4> -->
	
			</div>
			<div class="content">
				<div class="page-inner">	
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">	
							        <h4 class="card-title"><i class="far fa-user"></i>  Add User Sidebar Role</h4>
                                    @if(Session::has('message'))										
                                        <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                                    @endif	
								</div>
								<div class="card-body">
									<form action="{{ url('superadmin/view-sidebar-permission') }}" method="post" enctype="multipart/form-data">
				                        <input type="hidden" name="_token" value="{{ csrf_token() }}">	
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
											        <label>Select Module</label><br>
													<select class="selectpicker" multiple data-live-search="true" name="module_name[]" required>											
                                                        <option value="" label="default"></option>
                                                        <option value="all">All</option>
                                                        @foreach($module as $mod)
                                                        <option value="{{$mod->id}}" <?php if(!empty($role_authorization->module_name)){  if($role_authorization->module_name == $mod->id){ ?> selected="selected" <?php } }?> >{{$mod->module_name}}</option>
                                                        @endforeach
                                                    </select>
											    </div>
										    </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label >Select Employee ID</label><br>
                                                    <select class="selectpicker" multiple data-live-search="true" name="member_id[]" required>
                                                        <option value="" label="default"></option>
                                                        @foreach($users as $user)
                                                        
                                                            <option value="{{$user->name}} (Code : {{$user->employee_id}})">{{$user->name}} (Code : {{$user->employee_id}}) </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
										</div>
										<div class="row form-group">
                                            <div class="col-md-12">
                                                <button class="btn btn-default" type="submit">Submit</button>
                                            </div>
										</div>	
									</form>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		
	<!--   Core JS Files   -->
  @include('admin.include.footer')
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
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
	{{-- <script >
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
		function getSubModules(module_id)
	{	
		$.ajax({
			type:'GET',
			url:'{{url('role/get-sub-modules')}}/'+module_id,				
			success: function(response){
			//console.log(response); 
				$("#role_menus").html(response);
			}
		});
	}

	function getMenu(sub_module_id)
	{	
		$.ajax({
			type:'GET',
			url:'{{url('role/get-role-menu')}}/'+sub_module_id,				
			success: function(response){
			console.log(response); 
			$("#role_menus").html(response);
			}
		});
	}
	
	</script> --}}
</body>
</html>
