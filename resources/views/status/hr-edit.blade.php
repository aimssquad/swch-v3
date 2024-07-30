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
							
							<li class="nav-item">
								<a href="{{url('organisation-status/view-hr')}}"> HR File</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="#"> Edit HR File</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Edit HR File</h4>
								</div>
								<div class="card-body">
									<form action="{{url('organisation-status/edit-hr')}}" method="post" enctype="multipart/form-data" id="myForm">
			 {{csrf_field()}}
			 
			 	<input id="id" type="hidden"  name="id"    class="form-control input-border-bottom"  value="{{$hr->id}}" >
										<div class="row form-group">
										
									<?php
									if(!empty($bill_rs)){
									    $type=$bill_rs->post_date;
									    $d_type=date('Y-m-d',strtotime($bill_rs->post_date.'  + 3 Weeks'));
									    $sub_date=date('Y-m-d',strtotime($bill_rs->post_date.'  + 4  Weeks'));
									}else{
									  $type=''; 
									  $d_type='';
									  $sub_date='';
									}
									?>
				
											 
											<div class="col-md-4">
												<div class=" form-group">
												    	<label for="job_date" class="placeholder">Start Date for HR File Preparation</label>
													<input id="job_date" type="date"  name="job_date"    class="form-control input-border-bottom"    value="{{$hr->job_date}}" readonly required="">
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												      <label for="hr_file_date" class="placeholder">HR File Prearation Deadline</label>
													<input id="hr_file_date" type="date"  name="hr_file_date"    class="form-control input-border-bottom"    value="{{$hr->hr_file_date}}" readonly required="">
												
												
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group" >
												  	<label for="job_ad" class="placeholder">Job Advertisement</label>
													<select class="form-control input-border-bottom"   id="job_ad"   name="job_ad"  >
													<option value="">&nbsp;</option>
														<option value="Yes" @if($hr->job_ad=='Yes') selected @endif>Yes</option>
													<option value="No" @if($hr->job_ad=='No') selected @endif>No</option>
											
													
												</select>
												
											
												</div>
											</div>
												<div class="col-md-8">
												<div class=" form-group">
												    	<label for="remarks" class="placeholder">Remarks</label>
												    <textarea  id="remarks"  name="remarks"    class="form-control input-border-bottom"  >{{$hr->remarks}}</textarea>
												
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="inpect" class="placeholder">HR File Ready for Inspection</label>
													<select class="form-control input-border-bottom"   id="inpect"   name="inpect" >
													<option value="">&nbsp;</option>
														<option value="Yes" @if($hr->inpect=='Yes') selected @endif>Yes</option>
													<option value="No" @if($hr->inpect=='No') selected @endif>No</option>
												
													
												</select>
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="due_date" class="placeholder">Due Date for Home Office Feedback or Visit </label>
													<input id="due_date" type="date"  name="due_date"    class="form-control input-border-bottom"     value="{{$hr->due_date}}" >
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="sub_due_date" class="placeholder">Lag Time After Submission</label>
													<input id="sub_due_date" type="date"  name="sub_due_date"    class="form-control input-border-bottom"     value="{{$hr->sub_due_date}}" readonly >
												
											
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
												    	<label for="hr_reply_date" class="placeholder">HR Reply Date </label>
													<input id="hr_reply_date" type="date"  name="hr_reply_date"    class="form-control input-border-bottom"     value="{{$hr->hr_reply_date}}" >
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="licence" class="placeholder">Licence Award Decision</label>
													<select class="form-control input-border-bottom"   id="licence"   name="licence"   onchange="bank_epmloyee(this.value);">
													<option value="">&nbsp;</option>
													<option value="Granted" @if($hr->licence=='Granted') selected @endif>Granted</option>
												<option value="Pending Decision" @if($hr->licence=='Pending Decision') selected @endif>Pending Decision</option>
												<option value="Rejected" @if($hr->licence=='Rejected') selected @endif>Rejected</option>
<option value="Refused" @if($hr->licence=='Refused') selected @endif>Refused</option>
												<option value="NA" @if($hr->licence=='NA') selected @endif>NA</option>
											
													
												</select>
												
											
												</div>
											</div>
											 <div class="col-md-4 " id="criman_bank_newd" @if($hr->licence=='Rejected') style="display:block;" @else style="display:none;" @endif >
										    <div class="form-group">
										        		<label for="reject_date" class="placeholder">Rejection Date </label>
												<input id="reject_date"  type="date" class="form-control input-border-bottom" name="reject_date"  value="{{$hr->reject_date}}" >
										
											</div>
										   </div>
											 <div class="col-md-4 " id="criman_bank_new" @if($hr->licence=='Rejected') style="display:block;" @else style="display:none;" @endif >
										    <div class="form-group">
										        		<label for="rect_deatils" class="placeholder">Give Details </label>
												<input id="rect_deatils"  type="text" class="form-control input-border-bottom" name="rect_deatils"  value="{{$hr->rect_deatils}}" >
										
											</div>
										   </div>
										    <div class="col-md-4 " id="criman_bank_new_l" @if($hr->licence=='Refused') style="display:block;" @else style="display:none;" @endif >
										    <div class="form-group">
										        		<label for="refused_date" class="placeholder">Refuseal date </label>
												<input id="refused_date"  type="date" class="form-control input-border-bottom" name="refused_date"  value="{{$hr->refused_date}}" >
										
											</div>
										   </div>
										    <div class="col-md-4 " id="criman_bank_new_g" @if($hr->licence=='Granted') style="display:block;" @else style="display:none;" @endif >
										    <div class="form-group">
										        		<label for="grant_date" class="placeholder">License Grant date </label>
												<input id="grant_date"  type="date" class="form-control input-border-bottom" name="grant_date"  value="{{$hr->grant_date}}" >
										
											</div>
										   </div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="identified" class="placeholder">Candidate Identified</label>
													<select class="form-control input-border-bottom"   id="identified"   name="identified" >
													<option value="">&nbsp;</option>
														<option value="Yes" @if($hr->identified=='Yes') selected @endif>Yes</option>
														<option value="No" @if($hr->identified=='No') selected @endif>No</option>
											
													
												</select>
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="preparation" class="placeholder">HR File Preparation Status</label>
													<select class="form-control input-border-bottom"   id="preparation"   name="preparation" >
													<option value="">&nbsp;</option>
														<option value="Complete" @if($hr->preparation=='Complete') selected @endif>Complete</option>
										<option value="Not Complete" @if($hr->preparation=='Not Complete') selected @endif>Not Complete</option>	
									<option value="Work in Progress" @if($hr->preparation=='Work in Progress') selected @endif>Work in Progress</option>	
									<option value="Not Started" @if($hr->preparation=='Not Started') selected @endif>Not Started</option>			
											
													
												
													
												</select>
												
											
												</div>
											</div>
											
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="need_action" class="placeholder">Need action </label>
													<select class="form-control input-border-bottom"   id="need_action"   name="need_action" onchange="bank_yyepmloyee(this.value);">
													<option value="">&nbsp;</option>
													<option value="Yes" @if($hr->need_action=='Yes') selected @endif >Yes</option>
																<option value="No" @if($hr->need_action=='No') selected @endif @if($hr->need_action=='') selected  @endif>No</option>
												
																
												
												
													
												</select>
												
											
												</div>
											</div>
											  <div class="col-md-6 " id="criman_banknn_new" @if($hr->need_action=='Yes') style="display:block;" @else style="display:none;" @endif >
										    <div class="form-group">
										        		<label for="other" class="placeholder">Give Details </label>
												<input id="other_action"  type="text" class="form-control input-border-bottom" name="other_action"  value="{{$hr->other_action}}" >
										
											</div>
										   </div>
										   
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="home_off" class="placeholder">Home Office Client Visit </label>
													<select class="form-control input-border-bottom"   id="home_off"   name="home_off"  onchange="bank_homeepmloyee(this.value);">
													<option value="">&nbsp;</option>
													<option value="Yes" @if($hr->home_off=='Yes') selected @endif >Yes</option>
																<option value="No" @if($hr->home_off=='No') selected @endif @if($hr->home_off=='') selected  @endif>No</option>
												
																
												
												
													
												</select>
												
											
												</div>
											</div>
											  <div class="col-md-6 " id="criman_banknnhome_new" @if($hr->home_off=='Yes') style="display:block;" @else style="display:none;" @endif >
										    <div class="form-group">
										        	<label for="home_visit_date" class="placeholder">Home Office Visit Date</label>	
												<input id="home_visit_date"  type="date" class="form-control input-border-bottom" name="home_visit_date"  value="{{$hr->home_visit_date}}" >
										
											</div>
										   </div>
										   
										   
											  <div class="col-md-4">
										      <div class="form-group">
										          <label for="status" class="placeholder"  style="padding-top:0;margin-top: -10px;">Status</label>
												<select class="form-control input-border-bottom"   id="status"   name="status" required="">
													<option value="">&nbsp;</option>
												
													<option value="Incomplete" @if($hr->status=='Incomplete') selected @endif>Incomplete</option>
													<option value="Complete" @if($hr->status=='Complete') selected @endif>Complete</option>
													<option value="Not Interested" @if($hr->status=='Not Interested') selected @endif>License Granted but not interested to do HR</option>	
												</select>
												
											</div>
										   </div>
										   </div><div class="row">
												<div class="col-md-4">
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
		if(empid==''){
			alert("HR File Preparation Date required");
			$("#job_date").focus();
		}
		else if(document.getElementById("licence").value=="Rejected" && document.getElementById("reject_date").value==""){
			alert("HR File Rejection Date required");
			$("#reject_date").focus();
		}
		else if(document.getElementById("licence").value=="Granted" && document.getElementById("grant_date").value==""){
			alert("HR File Granted Date required");
			$("#grant_date").focus();
		}
		else if(document.getElementById("licence").value=="Refused" && document.getElementById("refused_date").value==""){
			alert("HR File Refusal Date required");
			$("#refused_date").focus();
		}
		else{
			this.submit();
		}

        // if(empid!=''){
        //     this.submit();
        // }else{
        //     $("#job_date").focus();
        // }
    });
});  
    
    function bank_epmloyee(val) {
	if(val=='Rejected'){
	document.getElementById("criman_bank_new").style.display = "block";
	document.getElementById("criman_bank_newd").style.display = "block";
		document.getElementById("criman_bank_new_l").style.display = "none";
		document.getElementById("criman_bank_new_g").style.display = "none";
	}
	else if(val=='Refused'){
	document.getElementById("criman_bank_new").style.display = "none";	
	document.getElementById("criman_bank_newd").style.display = "none";	
		document.getElementById("criman_bank_new_g").style.display = "none";
		document.getElementById("criman_bank_new_l").style.display = "block";
	}
	else if(val=='Granted'){
	document.getElementById("criman_bank_new").style.display = "none";	
	document.getElementById("criman_bank_newd").style.display = "none";	
		document.getElementById("criman_bank_new_l").style.display = "none";
		document.getElementById("criman_bank_new_g").style.display = "block";
	}
	else{
		document.getElementById("criman_bank_new").style.display = "none";
		document.getElementById("criman_bank_newd").style.display = "none";
			document.getElementById("criman_bank_new_l").style.display = "none";
			document.getElementById("criman_bank_new_g").style.display = "none";
	}
  
}
function bank_yyepmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_banknn_new").style.display = "block";	
	}else{
		document.getElementById("criman_banknn_new").style.display = "none";	
	}
  
}
function bank_homeepmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_banknnhome_new").style.display = "block";	
	}else{
		document.getElementById("criman_banknnhome_new").style.display = "none";	
	}
  
}

</script>
</body>
</html>