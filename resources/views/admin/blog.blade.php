<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
		<link rel="icon" href="{{ asset('img/favicon.png')}}">
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
</head>
<body>
	<div class="wrapper">
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<!--<h4 class="page-title">Blog </h4>-->
						<!--<ul class="breadcrumbs">-->
						<!--	<li class="nav-home">-->
						<!--		<a href="#">-->
						<!--			<i class="flaticon-home"></i>-->
						<!--		</a>-->
						<!--	</li>-->
						<!--	<li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
							
						<!--	<li class="nav-item">-->
						<!--		<a href="{{url('superadmin/blog')}}">Blog </a>-->
						<!--	</li>-->
							
						<!--</ul>-->
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-newspaper"></i> Blog 
<span>		<a data-toggle="tooltip" data-placement="bottom" title="Add New Blog "  href="{{ url('superadmin/add-blog') }}"><img  style="width: 25px;" src="{{ asset('img/plus1.png')}}"></a></span>								</h4>
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
                 <th>Blog Category </th>
                <th>Blog Name </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employee_type_rs as $employee_type)
            	<?php
								$pass=DB::Table('blog_cat')
		        
				 ->where('id','=',$employee_type->cat) 
				 
		         
				->first(); 
			
							?>
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                           <td> {{$pass->name}}</td>
                                            <td> {{$employee_type->name}}</td>
                                            
                                            
                                            
                                            
<td class="drp">


<div class="dropdown">
  <button class="btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="{{ url("superadmin/add-blog/".base64_encode($employee_type->id)) }}"><i class="far fa-edit"></i>&nbsp; Edit</a> 
    <a download class="dropdown-item" href='{{url("superadmin/delete-blog/".base64_encode($employee_type->id))}}'  onclick="return confirm('Are you sure you want to delete this blog ?');">
        <i class="far fa-trash-alt"></i></i>&nbsp; Delete</a> 
  </div>
</div
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