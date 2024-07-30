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
	
	<style> .add-shift {
    float: right;
} .add-shift .add-shift-btn {
    padding: 6px 24px !important;
    font-size: 14px !important;
    margin: 0px 20px 15px 0px !important;
    background-color: #9e9797 !important;
    color: #fff !important;
}  </style>
</head>
<body>
	<div class="wrapper">
		
  @include('complain.include.header')
		<!-- Sidebar -->
		
		  @include('complain.include.sidebar')
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
								<a href="{{url('complain/view-complain')}}">Open Complain</a>
							</li>
						</ul>
					</div>	
			<div class="content">
				<div class="page-inner">
				
							<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Open Complain</h4>
									@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									 <form  method="post" action="{{ url('complain/add-solved-complain') }}" enctype="multipart/form-data" >
									 {{csrf_field()}}
									 <input id="newid"  type="hidden" class="form-control input-border-bottom" name="newid"  value="{{ $open->id }}" >
										<div class="row form-group">
												<div class="col-md-3">
											
											<div class="form-group">
											    	<label for="type" class="placeholder">   Project Name</label>
											   	<select id="p_name"  class="form-control input-border-bottom"   name="p_name" required disabled>
											   	    	<option value=""   >&nbsp;</option>
							<option value="Work Permit Cloud"   <?php    if($open->p_name=='Work Permit Cloud'){ echo 'selected';} ?>>Work Permit Cloud</option>
							<option value="Skilled Worker Route" <?php    if($open->p_name=='Skilled Worker Route'){ echo 'selected';} ?>  >Skilled Worker Route</option>
								
						</select>
					
                        
											
												
											</div>
												
											</div>
												<div class="col-md-3">
											
											<div class="form-group">
											    	<label for="type" class="placeholder">  Complain Type</label>
											   	<select id="cat_name"  class="form-control input-border-bottom"   name="cat_name" required onchange="bank_epmloyee(this.value);" disabled>
											   	    	<option value=""   >&nbsp;</option>
							 <option value="{{$open->cat_name}}"  selected>{{$open->cat_name}}</option>
                     
						</select>
					
                        
											
												
											</div>
												
											</div>
										
										  						
											 <div class="col-md-6 " id="criman_bank_new" <?php    if($open->cat_name=='Others'){ ?>  style="display:block;" <?php }else{ ?> style="display:none;"<?php }
											 ?> >
										    <div class="form-group" >
										        		<label for="others" class="placeholder">Give Details </label>
												<input id="others"  type="text" class="form-control input-border-bottom" name="others" disabled  value="{{ $open->others }}" >
										
											</div>
										   </div>
										<div class="col-md-6">
										  	<div class=" form-group">		
										  
	<label for="emid" class="placeholder"> select Organisation </label>
										  	  				<select class="form-control input-border-bottom" id="emid" name="emid"  disabled>
                                                                                            
							<option value="">&nbsp;</option>
							
			                 @foreach($user as $dept)
 <?php
$ff= DB::table('registration')->where('reg','=',$dept->module_name)->first();
 ?>
                     <option value="{{$dept->module_name}}" <?php    if($open->emid==$dept->module_name){ echo 'selected';} ?>>{{$ff->com_name}}</option>
                       @endforeach
                                                                                                
						</select>
									
										  
										  </div>
										  </div>
										  	<div class="col-md-6">
											
											<div class="form-group">
											    	<label for="descrption" class="placeholder">Description</label>
												<textarea class="form-control input-border-bottom"  required name="descrption" disabled>{{ $open->descrption }}</textarea>
											
											
											</div>
											
												</div>
												@if($open->flie!='') 
												
										 <div class="col-md-2">
											
											<div class="form-group">
											
												<label for="flie" class="placeholder"> Uplaod File </label>
												<p> <a href="{{asset('public/'.$open->flie)}}" download><img  style="width: 25px;" src="{{ asset('img/upload.png')}}"></a></p>
											</div>
											
												</div>
												@endif
											<div class="col-md-4">
											
											<div class="form-group">
											    	<label for="type" class="placeholder">   status</label>
											   	<select id="status"  class="form-control input-border-bottom"   name="status" required >
											   	    	<option value=""   >&nbsp;</option>
							<option value="open"   <?php    if($open->status=='open'){ echo 'selected';} ?>>Open</option>
							<option value="solved"   <?php    if($open->status=='solved'){ echo 'selected';} ?>>Solved</option>
								<option value="closed"   <?php    if($open->status=='closed'){ echo 'selected';} ?>>Closed</option>
						</select>
					
                        
											
												
											</div>
												
											</div>
										
										<div class="col-md-6">
											
											<div class="form-group">
											    	<label for="descrption" class="placeholder">Remarks</label>
												<textarea class="form-control input-border-bottom"   name="remarks">{{ $open->remarks }}</textarea>
											
											
											</div>
											
												</div>
												</div>
										
										<div class="row form-group">	
									 <div class="col-md-12">
											
										<button type="submit" class="btn btn-default">Submit</button>
										</div>
										
											</div>	
										
									
									
										 
										</div>


									
				</div>
			</div>
				 @include('complain.include.footer')
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
		  function chngdepartmentshift(empid){
	  
	 	
	
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("employee_code").innerHTML = response;
		}
		});
   }
     function chngdepartment(empid){
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("designation").innerHTML = response;
		}
		});
   }
    function bank_epmloyee(val) {
	if(val=='Others'){
	document.getElementById("criman_bank_new").style.display = "block";	
	
	  $("#others").prop("required", true);
	 
	}else{
		document.getElementById("criman_bank_new").style.display = "none";	
			
			 $("#others").prop("required", false);
			 
	}
  
}


function checktime(){
	   var in_time=btoa(document.getElementById("in_time").value);
	   var out_time=btoa(document.getElementById("out_time").value);
	  
	   	$.ajax({
		type:'GET',
		url:'https://workpermitcloud.co.uk/hrms/pis/gettimemintuesnew/'+in_time+'/'+out_time,
        cache: false,
		success: function(responsejj){
		
	var objh = jQuery.parseJSON(responsejj);
			 console.log(objh);
				    $("#w_hours").val(objh.hour);
				   $("#w_hours").attr("readonly", true);
				   $("#w_min").val(objh.min);
				   	$("#w_min").attr("readonly", true);
			
			  
			
			 
			   
		}
		});
   }

	</script>
</body>
</html>