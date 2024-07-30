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
	<style>
    .star{
		color:red;
	}
	</style>
</head>
<body>
	<div class="wrapper">

  		@include('status.include.header')
		<!-- Sidebar -->

		@include('status.include.sidebar')


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
						<a href="#">Application Status</a>
					</li>
						<li class="separator">
					/
					</li>
					<li class="nav-item active">
						<a href="edit-company-profile.php">Edit Company Profile</a>
					</li>

				</ul>
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-paste"></i> Edit Application Status</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{url('organisation-status/edit-application')}}" method="post" enctype="multipart/form-data">
			 							{{csrf_field()}}
			 							<input type="hidden" class="form-control input-border-bottom" id="id" name="id"  value="{{$tareq->id}}">
										<input id="emid" type="hidden"  name="emid" class="form-control input-border-bottom"  style="margin-top: 22px;" value="{{$tareq->emid}}" >
										@php
										$res = DB::table('registration')
											->where('reg', '=', $tareq->emid)
											->first();
										@endphp
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
						    						<label for="emidname" class="placeholder" style="padding-top:0;">Organisation Name</label>
													<input type="text" class="form-control input-border-bottom" id="emidname" type="text"  name="emidname"  value="{{$res->com_name}}" readonly   onchange="checkcompany();">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
										    		<label for="trad" class="placeholder" style="padding-top:0;">Trade Name</label>
													<input id="trad" type="text" class="form-control input-border-bottom" ="" name="trad"  value="{{$tareq->trad}}" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
										    		<label for="address" class="placeholder" style="padding-top:0;">Address</label>
													<input id="address" type="text" class="form-control input-border-bottom" ="" name="address"  value="{{$tareq->address}}" readonly>
												</div>
											</div>
										</div>
									    <div class="row form-group">
											<div class="col-md-4">
												<div class="form-group">
									    			<label for="assign" class="placeholder"  style="padding-top:0;">Assign Through</label>
													<select class="form-control input-border-bottom" id="assign" name="assign"  onchange="checkreff(this.value);" disabled>
														<option value="">&nbsp;</option>
														<option value="Own"   @if($tareq->assign=='Own') selected @endif>Own</option>
														<option value="Partner"  @if($tareq->assign=='Partner') selected @endif>Partner</option>
													</select>
												</div>
											</div>
											<div class="col-md-4"  id="reff_own"  @if($tareq->assign=='Own') style="display:block;"  @else style="display:none;"  @endif>
												<div class="form-group">
									    			<label for="reffered" class="placeholder"  style="padding-top:0;">Referred by</label>
													<select class="form-control input-border-bottom" id="reffered_own"   name="reffered_own" disabled>
														<option value="NA" @if($tareq->reffered=='NA') selected @endif> NA</option>
													</select>
												</div>
											</div>
											<div class="col-md-4"  id="reff_part"  @if($tareq->assign=='Partner') style="display:block;"  @else style="display:none;" @endif>
												<div class="form-group">
									    			<label for="reffered" class="placeholder"  style="padding-top:0;">Referred by</label>
													<select class="form-control input-border-bottom" id="reffered_part"  name="reffered_part" disabled>
														<option value="">&nbsp;</option>
													@foreach ($ref as $refrdept)
														<option value="{{$refrdept->ref_id}}"  @if($tareq->reffered==$refrdept->ref_id) selected @endif>{{$refrdept->name}}</option>
													@endforeach
													</select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
									    			<label for="relation" class="placeholder"  style="padding-top:0;">Relationship Manager</label>
													<select class="form-control input-border-bottom" id="relation" name="relation" disabled>
														<option value="">&nbsp;</option>
													@foreach ($user as $userdept)
														<option value="{{$userdept->employee_id}}" @if($tareq->relation==$userdept->employee_id) selected @endif>{{$userdept->name}}</option>
													@endforeach
														<option value="NA"  @if($tareq->relation=='NA') selected @endif> NA</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-4">
												<div class="form-group">
											    	<label for="asign_name" class="placeholder" style="padding-top:0;">Assign To</label>
													<input id="asign_name" type="text" class="form-control input-border-bottom"  value="{{$tareq->asign_name}}" readonly  name="asign_name">
													<input id="ref_id" type="text" class="form-control input-border-bottom" value="{{$tareq->ref_id}}" readonly  name="ref_id" hidden>

												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
											    	<label for="authorising" class="placeholder" style="padding-top:0;">Authorising Officer's Name</label>
													<input id="authorising" type="text" class="form-control input-border-bottom"  value="{{$tareq->authorising}}" readonly  name="authorising">
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
											    	<label for="desig" class="placeholder" style="padding-top:0;">Designation</label>
													<input id="desig" type="text" class="form-control input-border-bottom"  readonly name="desig" value="{{$tareq->desig}}">
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
											    	<label for="auth_con" class="placeholder" style="padding-top:0;">Authorising Officer's Contact No.</label>
													<input id="auth_con" type="tel" class="form-control input-border-bottom"  name="auth_con" readonly value="{{$tareq->auth_con}}">
												</div>
											</div>
											<div class="col-md-4">
										    	<div class="form-group">
										        	<label for="assign_date" class="placeholder" style="padding-top:0;">Assigned Date</label>
													<input id="assign_date" type="date" class="form-control input-border-bottom"  name="assign_date"  value="{{$tareq->assign_date}}" readonly>
												</div>
										   	</div>
										   	<div class="col-md-4">
										   		<div class="form-group">
										   	    	<label for="app_date" class="placeholder" style="padding-top:0;">Application Target Date</label>
													<input id="app_date"  value="{{$tareq->app_date}}" type="date" class="form-control input-border-bottom" name="app_date" readonly>
												</div>
										   	</div>
	 									   	<div class="col-md-12">
										    	<div class="form-group">
										        	<label for="remarks" class="placeholder"  style="padding-top:0;">Remarks - Application Submission</label>
													<input id="remarks" type="text" class="form-control input-border-bottom"  name="remarks" value="{{$tareq->remarks}}"  disabled>
												</div>
										   	</div>
										    <div class="col-md-4">
										      	<div class="form-group">
										          	<label for="invoice" class="placeholder"  style="padding-top:0;">Need Invoice</label>
													<select class="form-control input-border-bottom" id="invoice" name="invoice" >
														<option value="">&nbsp;</option>
														<option value="Yes"  @if($tareq->invoice=='Yes') selected @endif>Yes</option>
														<option value="No"  @if($tareq->invoice=='No') selected @endif>No</option>
													</select>
												</div>
										   	</div>
										    <div class="col-md-4">
										      	<div class="form-group">
										          	<label for="invoice_se" class="placeholder"  style="padding-top:0;">Need for 2nd Invoice</label>
													<select class="form-control input-border-bottom" id="invoice_se"  name="invoice_se"  >
														<option value="">&nbsp;</option>
														<option value="Yes"  @if($tareq->invoice_se=='Yes') selected @endif>Yes</option>
														<option value="No"  @if($tareq->invoice_se=='No') selected @endif>No</option>
													</select>
												</div>
										   	</div>
										  	<div class="col-md-4">
										      	<div class="form-group">
										          	<label for="hr_in" class="placeholder"  style="padding-top:0;">HR Link Sent - Go Ahead with HR</label>
													<select class="form-control input-border-bottom"   id="hr_in" name="hr_in">
														<option value="">&nbsp;</option>
														<option value="Yes" @if($tareq->hr_in=='Yes') selected @endif>Yes</option>
														<option value="No" @if($tareq->hr_in=='No') selected @endif>No</option>
													</select>
												</div>
										   	</div>
											
										   	<div class="col-md-4">
										     	<div class="form-group">
										         	<label for="last_date" class="placeholder" style="padding-top:0;">Application Submission Date</label>
													<input id="last_date" type="date" class="form-control input-border-bottom"  name="last_date"  value="{{$tareq->last_date}}" onchange="getreviewdate(this.value)">

												</div>
										   	</div>
										    <div class="col-md-4">
										     	<div class="form-group">
										         	<label for="last_sub" class="placeholder" style="padding-top:0;">Last Date of Submission</label>
													<input id="last_sub" type="date" class="form-control input-border-bottom"  name="last_sub"  value="{{$tareq->last_sub}}"  min="{{date('Y-m-d')}}" readonly>

												</div>
										   	</div>

										    <div class="col-md-12">
										    	<div class="form-group">
										        	<label for="remark_su" class="placeholder"  style="padding-top:0;">Remarks </label>
													<input id="remark_su" type="text" class="form-control input-border-bottom"  name="remark_su" value="{{$tareq->remark_su}}"  >

												</div>
										   	</div>
										</div>
										<div class="row form-group">
											<div class="col-md-6">
												<label for="need_action" class="placeholder">Need action </label>
												<select class="form-control input-border-bottom"   id="need_action"   name="need_action" onchange="bank_yyepmloyee(this.value);" >
													<option value="">&nbsp;</option>
													<option value="Yes" @if($tareq->need_action=='Yes') selected @endif >Yes</option>
													<option value="No" @if($tareq->need_action=='No') selected @endif @if($tareq->need_action=='') selected  @endif>No</option>
												</select>
											</div>
											<div class="col-md-6 " id="criman_banknn_new" @if($tareq->need_action=='Yes') style="display:block;" @else style="display:none;" @endif >
										        <label for="other" class="placeholder">Give Details </label>
												<input id="other_action"  type="text" class="form-control input-border-bottom" name="other_action"  value="{{$tareq->other_action}}" >
											</div>
											<div class="col-md-6">
										  		<div class="form-group ">
										  			<label for="licence" class="placeholder">License Applied <span class="star">(#)</span></label>
													@if ($Roledata->status == "inactive" || $Roledata->verify == "not approved" || $tareq->last_date==NULL)
														<input type="text" class="form-control "  name="licence_o" readonly value="@if($Roledata->licence=='yes') APPLIED @else NOT APPLIED @endif" >
														<input type="hidden" class="form-control "   name="licence"  value="{{$Roledata->licence}}" >
													@else
														<!-- <select id="licence"  class="form-control "   name="licence" <?php //if ($Roledata->status == "inactive" || $Roledata->verify == "not approved") {?> readonly <?php //}?>>
															<option value="yes" <?php //if (!empty($Roledata->licence)) {if ($Roledata->licence == "yes") {?> selected="selected" <?php //}}?>  >APPLIED</option>
															<option value="no" <?php //if (!empty($Roledata->licence)) {if ($Roledata->licence == "no") {?> selected="selected" <?php // }}?>>NOT APPLIED</option>
														</select> -->
														<input type="text" class="form-control "  name="licence_o" readonly value="@if($Roledata->licence=='yes') APPLIED @else NOT APPLIED @endif" >
														<input type="hidden" class="form-control "   name="licence"  value="{{$Roledata->licence}}" >

													@endif
												</div>
											</div>

											<div class="col-md-6">
										  		<div class="form-group ">
										  			<label for="licence" class="placeholder">Type</label>
													@if ($Roledata->status == "inactive" || $Roledata->verify == "not approved")
														<input type="text" class="form-control "  name="license_type_o" readonly value="NA" >
														<input type="hidden" class="form-control "   name="license_type"  value="{{$Roledata->license_type}}" >
													@else
														<select id="license_type"  class="form-control "   name="license_type" @if($Roledata->status == "inactive" || $Roledata->verify == "not approved")  readonly @else required @endif  >
															<option value=""></option>
															<option value="Internal" <?php if (!empty($Roledata->license_type)) {if ($Roledata->license_type == "Internal") {?> selected="selected" <?php }}?>  >Internal</option>
															<option value="External" <?php if (!empty($Roledata->license_type)) {if ($Roledata->license_type == "External") {?> selected="selected" <?php }}?>>External</option>
														</select>

													@endif
												</div>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<button type="submit" class="btn btn-default">Submit</button>
											</div>
											<div class="col-md-12">

												  <p style="color:red;text-align:right;margin:5px 5px 0 0;font-size:14px">(#) marked fields requires application submission date to be updated.</p>
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

<?php

$aryytestsys = array();

foreach ($or_de as $billdept) {

    $aryytestsys[] = '"' . $billdept->com_name . '"';
}
$strpsys = implode(',', $aryytestsys);

?>
<script src="{{ asset('js/jquery.autosuggest.js')}}"></script>
<script>
var component_name= [<?=$strpsys;?>];
console.log(component_name);
$("#emidname").autosuggest({
			sugggestionsArray: component_name
		});

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
			 var address=obj[0].address;
			  if(obj[0].address2){
			       var address2=' , '+obj[0].address2;
			  }else{
			      var address2='';
			  }

			  if(obj[0].road){
			       var road=' , '+obj[0].road;
			  }else{
			      var road='';
			  }
			  if(obj[0].city){
			       var city=' , '+obj[0].city;
			  }else{
			      var city='';
			  }
			  if(obj[0].zip){
			       var zip=' , '+obj[0].zip;
			  }else{
			      var zip='';
			  }
			   if(obj[0].country){
			       var country=' , '+obj[0].country;
			  }else{
			      var country='';
			  }

			var address=address+' '+address2+''+road+''+city+''+zip+''+country;


				  $("#emid").val(reg);
				   $("#trad").val(obj[0].trad_name);
				    $("#address").val(address);
				    $("#authorising").val(obj[0].f_name+''+obj[0].l_name);
				      $("#desig").val(obj[0].desig);
				       $("#auth_con").val(obj[0].con_num);
		}
		});

			$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkByIdauthof')}}/'+empid,
        cache: false,
		success: function(response){


			var obj = jQuery.parseJSON(response);

			 console.log(obj);

			  var name=obj[0].name;


				  $("#asign_name").val(name);
				   $("#ref_id").val(obj[0].employee_id);
		}
		});
   }


	function getreviewdate(){
		var empid=document.getElementById("app_date").value;

			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewByIdnewdate')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);

		 $("#last_date").val(response);
		}
		});
	}
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
   $('#selectFloatingLabel').change(function() {
        $('.write-type').hide();
        $('#' + $(this).val()).show();
 });



</script>

<script>
$('#selectFloatingLabel1').change(function() {
        $('.nature').hide();
        $('#' + $(this).val()).show();
 });
 </script>
 <script>
$('#selectFloatingLabel2').change(function() {
        $('.prmt').hide();
        $('#' + $(this).val()).show();
 });
 </script>
<script>
var room = 1;
function education_fields() {

    room++;
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+room);
	var rdiv = 'removeclass'+room;
    divtest.innerHTML = '<div class="row form-group"><div class="col-md-4"><div class="form-group"><input type="text" class="form-control input-border-bottom" =""><label class="placeholder">Type of Document</label></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlFile1">Upload Document</label><input type="file" class="form-control-file" id="exampleFormControlFile1"></div><span>*Document Size not more than 300 KB</span></div><div class="col-md-4"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';

    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
   function checkreff(val) {
	if(val=='Own'){
	document.getElementById("reff_own").style.display = "block";
		document.getElementById("reff_part").style.display = "none";
		$("#reffered_own").prop('',true);
		$("#reffered_part").prop('',false);
	}else if(val=='Partner'){
		document.getElementById("reff_own").style.display = "none";
			document.getElementById("reff_part").style.display = "block";
				$("#reffered_own").prop('',false);
		$("#reffered_part").prop('',true);
	}else{
		document.getElementById("reff_own").style.display = "none";
			document.getElementById("reff_part").style.display = "none";
				$("#reffered_own").prop('',false);
		$("#reffered_part").prop('',false);
	}
}

  	function getreviewdate(){
		var empid=document.getElementById("last_date").value;

			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewByIdnewdate')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);

		 $("#last_sub").val(response);
		}
		});
	}
	function bank_yyepmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_banknn_new").style.display = "block";
	}else{
		document.getElementById("criman_banknn_new").style.display = "none";
	}

}
</script>
</body>
</html>