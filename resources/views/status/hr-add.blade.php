<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
	<style>.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('status.include.header')
		<!-- Sidebar -->
		
		  @include('status.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Organisation Status</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">HR File</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('organisation-status/view-hr')}}"> HR File</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#"> New HR File</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"> New HR File</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data" id="myForm">
			 {{csrf_field()}}
			 
										<div class="row form-group">
										
									<?php
									$ff= DB::table('company_employee')      
                 
                  ->where('emid','=',$Roledata->reg) 
                  ->get();
									if(count($ff)!=0){
									    $type=$Roledata->updated_at;
									    $d_type=date('Y-m-d',strtotime($Roledata->updated_at.'  + 3 Weeks'));
									    $sub_date=date('Y-m-d',strtotime($Roledata->updated_at.'  + 4  Weeks'));
									}else if(count($ff)==0){
									 $ffjj= DB::table('users')      
                 
                  ->where('emid','=',$Roledata->reg) 
                  ->first();
                  if(!empty($ffjj)){
                    $type=date('Y-m-d',strtotime($ffjj->created_at));
									    $d_type=date('Y-m-d',strtotime($type.'  + 3 Weeks'));
									    $sub_date=date('Y-m-d',strtotime($type.'  + 4  Weeks'));
                  }else{
									  $type=''; 
									  $d_type='';
									  $sub_date='';
									}
                  
									}else{
									  $type=''; 
									  $d_type='';
									  $sub_date='';
									}
									?>
				
											 
											<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input id="job_date" type="date"  name="job_date"    class="form-control input-border-bottom" style="margin-top: 22px;"   value="{{$type}}" readonly  required="">
												
												<label for="job_date" class="placeholder">Start Date for HR File Preparation</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input id="hr_file_date" type="date"  name="hr_file_date"    class="form-control input-border-bottom" style="margin-top: 22px;"   value="{{$d_type}}" readonly  required="">
												
												<label for="hr_file_date" class="placeholder">HR File Prearation Deadline</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="job_ad"  name="job_ad"  required="">
													<option value="">&nbsp;</option>
												<option value="Yes">Yes</option>
													<option value="No">No</option>
													
												</select>
												
												<label for="job_ad" class="placeholder">Job Advertisement</label>
												</div>
											</div>
												<div class="col-md-12">
												<div class=" form-group form-floating-label">
												    <textarea  id="remarks"  name="remarks"    class="form-control input-border-bottom"  style="margin-top: 22px;"></textarea>
												
												
												<label for="remarks" class="placeholder">Remarks</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="inpect"   name="inpect">
													<option value="">&nbsp;</option>
												<option value="Yes">Yes</option>
													<option value="No">No</option>
													
												</select>
												
												<label for="inpect" class="placeholder">HR File Ready for Inspection</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input id="due_date" type="date"  name="due_date"    class="form-control input-border-bottom" style="margin-top: 22px;"   >
												
												<label for="due_date" class="placeholder">Due Date for Home Office Feedback or Visit </label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input id="sub_due_date" type="date"  name="sub_due_date"    class="form-control input-border-bottom" style="margin-top: 22px;"    value="{{$sub_date}}" readonly>
												
												<label for="sub_due_date" class="placeholder">Lag Time After Submission</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="licence"  name="licence" onchange="bank_epmloyee(this.value);">
													<option value="">&nbsp;</option>
												<option value="Granted">Granted</option>
													<option value="Pending Decision">Pending Decision</option>
													<option value="Rejected">Rejected</option>
													<option value="NA">NA</option>
													
												</select>
												
												<label for="licence" class="placeholder">Licence Award Decision</label>
												</div>
											</div>
											  <div class="col-md-6 " id="criman_bank_new" style="display:none;" >
										    <div class="form-group form-floating-label">
										        	
												<input id="rect_deatils"  type="text" class="form-control input-border-bottom" name="rect_deatils"  >
											<label for="rect_deatils" class="placeholder">Give Details </label>
											</div>
										   </div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="identified"  name="identified">
													<option value="">&nbsp;</option>
												<option value="Yes">Yes</option>
													<option value="No">No</option>
													
												</select>
												
												<label for="identified" class="placeholder">Candidate Identified</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="preparation"  name="preparation">
													<option value="">&nbsp;</option>
												<option value="Complete">Complete</option>
													<option value="Not Complete">Not Complete</option>
													<option value="Work in Progress">Work in Progress</option>
													<option value="Not Started">Not Started</option>
													
												</select>
												
												<label for="preparation" class="placeholder">HR File Preparation Status</label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="home_off"   name="home_off" >
													<option value="">&nbsp;</option>
													<option value="Yes" Yes</option>
																<option value="No">No</option>
												
																
												
												
													
												</select>
												
												<label for="home_off" class="placeholder">Home Office Client Visit </label>
												</div>
											</div>
					<div class="col-md-4" style="margin-top:25px;">
						<button type="submit" class="btn btn-default btn-up">Submit</button>
					</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('status.include.footer')
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
   
   


<script>

  function checkcompany(){
	   var empid=document.getElementById("emidname").value;
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			var obj = jQuery.parseJSON(response);
			
			 console.log(obj);
			
			  var reg=obj[0].reg;
			
			 
				  $("#emid").val(reg);	   
		}
		});
   }

 $(document).ready(function(){
    $('#myForm').on('submit', function(e){
         var empid=document.getElementById("job_date").value;
        e.preventDefault();
        if(empid!=''){
            this.submit();
        }else{
            $("#job_date").focus();
        }
    });
});  
    
    function bank_epmloyee(val) {
	if(val=='Rejected'){
	document.getElementById("criman_bank_new").style.display = "block";	
	}else{
		document.getElementById("criman_bank_new").style.display = "none";	
	}
  
}
</script>
</body>
</html>