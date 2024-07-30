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
<style>.app-form-text h5 {    margin: 0;
    color: #1572e8;
    padding: 15px 7px;
}.app-form-text h5 span {
    color: #000;
    padding-left: 10px;
}.download a {
    color: #fff;
    text-decoration: none;
}
.form-group{padding:0;}
.row:nth-child(even) {
   
    padding: 20px 0;
}


</style>
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
								<a href="{{url('recruitment/offer-letter')}}"> Generate Offer Letter </a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-sticky-note"></i> Generate Offer Letter</h4>
								</div>
								<div class="card-body">
								<form action="{{url('recruitment/edit-offer-letter')}}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
						
										
								<div class="row form-group">
								<div class="col-md-4">
											<div class="form-group ">		
											 <label for="user_id" class="placeholder">Select 	Candidate</label>	
											  <select class="form-control  " required="" name="user_id"  id="user_id" onchange="canuser(this.value);">
 <option value="">Select</option>
											  <?php foreach($employees as $employee){ ?>
								<option value="<?php echo $employee->user_id; ?>"  ><?php echo $employee->name; ?></option>
								<?php } ?>
											 											   
											  
												
											  </select>
											  
											    <!--<label for="inputFloatingLabel-recruitment" class="placeholder">Current Stage of Recruitment</label>-->
											</div>
										  </div>
										 
										<div class="col-md-4">
											<div class=" form-group ">
											      <label for="offered_sal" class="placeholder">Offered Salary</label>
											  <input type="text" id="offered_sal" class="form-control "  required="" name="offered_sal">
											  
											</div>
							   	    	</div>
							   	    	   <div class="col-md-4"   >
											<div class=" form-group ">
											      <label for="payment_type" class="placeholder">Payment Type</label>
											      <select id="payment_type" class="form-control "  required="" name="payment_type">
											           <option value="">Select</option>
											          <option value="Year">Year</option>
											            <option value="Month">Month</option>
											             <option value="Month">Month</option>
											              <option value="Week">Week</option>
											               <option value="Day">Day</option>
											                 <option value="Hour">Hour</option>
											      </select>
											 
											  
											</div>
							   	    	</div>
							   	    </div>
							   	    <div class="row form-group">
										  <div class="col-md-4"   >
											<div class=" form-group ">
											     <label for="date_jo" class="placeholder">Date Of Joining</label>
											  <input type="date" id="date_jo" class="form-control "  required="" name="date_jo">
											   
											</div>
							   	    	</div>
											
											
										  <div class="col-md-4"   >
											<div class="form-group ">
											    <label for="selectFloatingLabelra" class="placeholder">Reporting Authority</label>
<select class="form-control " id="selectFloatingLabelra" name="reportauthor" >
 <option value="">Select</option>
 @foreach($employeelists as $employeelist)
                        <option value="{{$employeelist->emp_code}}" >{{$employeelist->emp_fname}} {{$employeelist->emp_mname}} {{$employeelist->emp_lname}} ({{$employeelist->emp_code}})</option>
                        @endforeach
</select>

</div>
							   	    	</div>
							   	    	 <div class="col-md-4" style="display:none;"  id="jot">
												<div class="app-form-text">
													
												</div>
											</div>
											<div class="col-md-4" style="display:none;" id="ej">
												<div class="app-form-text" >
													
												</div>
											</div>
											<div class="col-md-4" style="display:none;"  id="pj">
												<div class="app-form-text" >
												
												</div>
											</div>
											
												<div class="row form-group" >
									
											  
                                             
                                   </div>
                                  
                                       	
										</div>
										<!-- 3rd row -->
	<div class="row form-group" style="margin-top:15px;background:none;">
										 <div class="col-md-12">
										    <button class="btn btn-default sub" type="submit">Submit</button>
										 </div>
									   </div>
										<!-- -----4th Row--------- -->
									
										<!-- -----5th Row-------- -->
								      
								      </div>	
                                        <!--------------------  -->
										

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
		function canuser(val) {
			
			
				$.ajax({
				type:'GET',
				url:'{{url('recruitment/get-employee')}}/'+val,
				success: function(response){


 

				  
				   var obj = jQuery.parseJSON(response);
				   
				  if(obj===null){
					   
				  }else{
					  
					  var job_title=obj.job_title; 
					   var email=obj.email; 
					    var phone=obj.phone; 
						document.getElementById("pj").style.display = "block";	
						document.getElementById("ej").style.display = "block";	
						document.getElementById("jot").style.display = "block";	
					 document.getElementById("pj").innerHTML = '<div class="app-form-text"><h5>Contact Number:<span><br>+'+ phone +'</span></h5></div>';
				   document.getElementById("ej").innerHTML = '<div class="app-form-text"><h5>Email:<span><br>'+ email +'</span></h5></div>';
				   document.getElementById("jot").innerHTML = '<div class="app-form-text"><h5>Job Title:<span><br>'+ job_title +'</span></h5></div>';
				   
				  }
				   
				
			  
			  
				}
			});
	
  
}
	</script>
	
</body>
</html>