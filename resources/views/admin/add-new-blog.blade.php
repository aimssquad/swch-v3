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
	 <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
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
						<!--<h4 class="page-title">Blog</h4>-->
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
						<!--	<a href="{{url('superadmin/blog')}}">Blog</a>-->
						<!--	</li>-->
						<!--	<li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="#">  Blog</a>-->
						<!--	</li>-->
						<!--</ul>-->
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-newspaper"></i> Blog</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{ url('superadmin/add-blog') }}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
			 <input type="hidden" name="id"  class="form-control" value="<?php if(!empty($employee_type->id)){ echo $employee_type->id;}?>">
										<div class="row">
										  
		 	<div class="col-md-4">
										  <div class="form-group ">
										      <label for="selectFloatingLabel3" class="placeholder">Blog Name</label>		
										  
										  
										      	<input type="text" id="name" name="name"  class="form-control "  required  value="<?php if(!empty($employee_type->id)){ echo $employee_type->name;}?>">
										
										      	
									
											
											</div>
										  
										</div>
										<div class="col-md-4">
										  <div class="form-group ">
										  	<label for="selectFloatingLabel3" class="placeholder">Blog Category</label>
										  <select id="cat"  class="form-control "   name="cat" required >
										      @foreach($blog_cat_type_rs as $blog_cat_type)
								<option value="{{$blog_cat_type->id}}" <?php if(!empty($employee_type->id)){  if(!empty($employee_type->cat)){  if($employee_type->cat == $blog_cat_type->id){ ?> selected="selected" <?php } } }?>  >{{$blog_cat_type->name}}</option>
						   @endforeach 
						</select>
												
												</select>
												
												</div>
											</div>
												<div class="col-md-4">
										  <div class="form-group ">
										      <label for="selectFloatingLabel3" class="placeholder">Create By</label>		
										  
										  
										      	<input type="text" id="cr_by" name="cr_by"  class="form-control "   value="<?php if(!empty($employee_type->id)){ echo $employee_type->cr_by;}?>">
										
										      	
									
											
											</div>
										  
										</div>
																			<div class="col-md-4">
    <label for="selectFloatingimage" class="placeholder">Image  </label>
   
       
											
      <input id="image" type="file" class="form-control "  name="image" placeholder="Address Line 1"  onchange="Filevalidationproimge()" accept="image/png, image/gif, image/jpeg">
        <small> Please select  image which size up to 2mb</small>
  </div>	<div class="col-md-2">
       <br>							  
		<?php  if(!empty($employee_type->id)){  if($employee_type->image!=''){ ?>
  <img src="{{url('public/'.$employee_type->image)}}" height="50px" width="50px">
  <?php }  }?>
 	</div>	
										
   
   	<div class="col-md-4">
										  <div class="form-group ">
										  	<label for="selectFloatingLabel3" class="placeholder">Status</label>
										  <select id="selectFloatingLabel3"  class="form-control "   name="status" required >
								<option value="active" <?php if(!empty($employee_type->id)){  if(!empty($employee_type->status)){  if($employee_type->status == "active"){ ?> selected="selected" <?php } } }?>  >Active</option>
							<option value="inactive" <?php if(!empty($employee_type->id)){  if(!empty($employee_type->status)){ if($employee_type->status == "inactive"){ ?> selected="selected" <?php } } } ?>>Inactive</option>
						</select>
												
												</select>
												
											
											</div>
										  
										</div>
										<div class="col-md-12"><div class="form-group">
										    	<label for="editor">Description </label>
										     <textarea  class="form-control"   id="editor" name="content"  required> <?php if(!empty($employee_type->id)){ echo $employee_type->content;}?></textarea>
   
											
											</div></div>
											</div>
						 <div class="row form-group ">
											
										<div class="col-md-2"><button type="submit" class="btn btn-default">Submit</button></div>
										</div>
									</form>
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
		
		
			Filevalidationproimge = () => { 
        const fi = document.getElementById('image'); 
        // Check if any file is selected. 
        
        if (fi.files.length > 0) { 
            for (const i = 0; i <= fi.files.length - 1; i++) { 
  
                const fsize = fi.files.item(i).size; 
                const file = Math.round((fsize / 1024)); 
                // The size of the file. 
                 if (file <= 2048) { 
                    
                } else { 
                  alert( 
                      "File is too Big, please select a file up to 2mb");
                      	$("#image").val('');  
                } 
            } 
        } 
    }

	</script>
	  <script>CKEDITOR.replace( 'editor' );</script>
	  	  <script>CKEDITOR.replace( 'editor2' );</script>
	  	  	  <script>CKEDITOR.replace( 'editor3' );</script>
</body>
</html>