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
</head>
<body>
	<div class="wrapper">
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		  
		  
		  <div class="main-panel">
		  	<div class="page-header">
						<!-- <h4 class="page-title">Application Assign</h4> -->
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
						<!--		<a href="#">Application Assign</a>-->
						<!--	</li>-->
						<!--	 <li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="edit-company-profile.php">Edit Company Profile</a>-->
						<!--	</li>-->
							
						<!--</ul>-->
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-file-word"></i> New Application Assign</h4>
								</div>
								<div class="card-body" style="">
										<form action="" method="post" enctype="multipart/form-data" id="myForm">
			 {{csrf_field()}}
										<div class="row">
										 	<input id="emid" type="hidden"  name="emid"    class="form-control input-border-bottom" required="" style="margin-top: 22px;" >
										<div class="col-md-6">
						<div class="form-group">
						    <label for="emidname" class="placeholder">Organisation Name</label>
						    <select class="form-control" name="emidname" onchange="checkcompany();" id="emidname">
						        @foreach($org_list as $item)
						        <option>Select</option>
						        <option value="{{$item->com_name}}">{{$item->com_name}}</option>
						        @endforeach
						    </select>
												
												
												
											</div>
					</div>
								
	
										<div class="col-md-6">
										<div class="form-group">
										    <label for="trad" class="placeholder" style="padding-top:0;margin-top: -10px;">Trade Name</label>
												<input id="trad" type="text" class="form-control input-border-bottom" required="" name="trad" readonly>
												
											</div>
										</div>
										</div>
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
										    <label for="address" class="placeholder" style="padding-top:0;margin-top: -10px;">Address</label>
												<input id="address" type="text" class="form-control input-border-bottom" required="" name="address" readonly>
												
											</div>
										</div>
										
										</div>
										
										
									    <div class="row form-group">	
									<div class="col-md-4">
									<div class="form-group">
									    <label for="assign" class="placeholder">Assign Through</label>
												<select class="form-control input-border-bottom" id="assign" required="" name="assign" onchange="checkreff(this.value);">
													<option value="">&nbsp;</option>
													<option value="Own">Own</option>
													<option value="Partner">Partner</option>
												
												</select>
												
											</div>
									</div>
									<div class="col-md-4" id="reff_own" style="display:none;">
									<div class="form-group">
									    <label for="reffered" class="placeholder">Referred by</label>
												<select class="form-control input-border-bottom" id="reffered_own" required="" name="reffered_own">
												
													
													
													<option value="NA" selected> NA</option>
													
												</select>
												
											</div>
									</div>
									
										<div class="col-md-4" id="reff_part" style="display:none;">
									<div class="form-group">
									    <label for="reffered" class="placeholder">Referred by</label>
												<select class="form-control input-border-bottom" id="reffered_part" required=""  name="reffered_part">
													<option value="">&nbsp;</option>
														<?php foreach($ref as $refrdept){
													    ?>
													<option value="{{$refrdept->ref_id}}">{{$refrdept->name}}</option>
													<?php
													}
													?>
													
													
												
													
												</select>
												
											</div>
									</div>
									<div class="col-md-4">
									<div class="form-group">
									    <label for="relation" class="placeholder">Relationship Manager</label>
												<select class="form-control input-border-bottom" id="relation" required="" name="relation">
													<option value="">&nbsp;</option>
												
												<?php
													foreach($user as $userdept){
													    ?>
													<option value="{{$userdept->employee_id}}">{{$userdept->name}}</option>
													<?php
													}
													?>
													
													
													<option value="NA"> NA</option>
												</select>
												
											</div>
									</div>
									</div>
										
										
										<div class="row form-group">
										  <div class="col-md-4">
											<div class="form-group">
											    <label for="ref_id" class="placeholder" style="padding-top:0;margin-top: -10px;">Assign To</label>
											    	<select class="form-control input-border-bottom" id="ref_id" required=""  name="ref_id">
													<option value="">&nbsp;</option>
													
												</select>
												
												
											</div>
											</div>
											
											<div class="col-md-4">
											<div class="form-group">
											    <label for="authorising" class="placeholder" style="padding-top:0;margin-top: -10px;">Authorising Officer's Name</label>
												<input id="authorising" type="text" class="form-control input-border-bottom" required=""  readonly name="authorising" readonly>
												
											</div>
											</div>
											
											<div class="col-md-4">
											<div class="form-group">
											    <label for="desig" class="placeholder" style="padding-top:0;margin-top: -10px;">Designation</label>
												<input id="desig" type="text" class="form-control input-border-bottom" required="" name="desig" readonly>
												
											</div>
											</div>
											
											<div class="col-md-4">
											<div class="form-group">
											    <label for="auth_con" class="placeholder" style="padding-top:0;margin-top: -10px;">Authorising Officer's Contact No.</label>
												<input id="auth_con" type="tel" class="form-control input-border-bottom" required="" name="auth_con" readonly>
												
											</div>
											</div>
											
									
										   <div class="col-md-4">
										     <div class="form-group">
										         <label for="assign_date" class="placeholder" style="padding-top:0;margin-top: -10px;">Assigned Date</label>
												<input id="assign_date" type="date" class="form-control input-border-bottom" required="" name="assign_date" readonly value="{{date('Y-m-d')}}">
												
											</div>
										   </div>
										   <div class="col-md-4">
										   	<div class="form-group">
										   	    <label for="app_date" class="placeholder" style="padding-top:0;margin-top: -10px;">Application Target Date</label>
												<input id="app_date" type="date" class="form-control input-border-bottom" required="" name="app_date" readonly value="{{date('Y-m-d',strtotime('+4 days'))}}">
												
											</div>
										   </div>
										   
										  
										   <div class="col-md-12">
										    <div class="form-group">
										        <label for="remarks" class="placeholder">Remarks - Application Submission</label>
												<input id="remarks" type="text" class="form-control input-border-bottom"  name="remarks">
												
											</div>
										   </div>
										   
										   
										   
										   <div class="col-md-4">
										      <div class="form-group">
										          <label for="invoice" class="placeholder">Need Invoice</label>
												<select class="form-control input-border-bottom" id="invoice"  name="invoice">
													<option value="">&nbsp;</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													
												</select>
												
											</div>
										   </div>
										     <div class="col-md-4">
										      <div class="form-group">
										          <label for="invoice_se" class="placeholder">Need for 2nd Invoice</label>
												<select class="form-control input-border-bottom" id="invoice_se"  name="invoice_se">
													<option value="">&nbsp;</option>
													<option value="Yes">Yes</option>
													<option value="No">No</option>
													
												</select>
												
											</div>
										   </div>
										  <div class="col-md-4">
										      <div class="form-group">
										          <label for="hr_in" class="placeholder">HR Link Sent - Go Ahead with HR</label>
												<select class="form-control input-border-bottom" id="hr_in"   name="hr_in">
													<option value="">&nbsp;</option>
												<option value="Yes">Yes</option>
													<option value="No">No</option>
													
												</select>
												
											</div>
										   </div>
										
										</div>
										
										
										<div class="row form-group">
										  <div class="col-md-12">
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
	 
<?php

	$aryytestsys=array();

	foreach($or_de as $billdept){
	    
	    
		$aryytestsys[]='"'.$billdept->com_name.'"';
	}
	$strpsys=implode(',',$aryytestsys);
	
?>
<script src="{{ asset('js/jquery.autosuggest.js')}}"></script>
<script>
var component_name= [<?= $strpsys;?>];
console.log(component_name);
$("#emidname").autosuggest({
			sugggestionsArray: component_name
		});

  function checkcompany(){
	   var empid=document.getElementById("emidname").value;
	   console.log(empid);
	  
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
			console.log('response',response);
			
			 
				   $("#ref_id").html(response);
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
    divtest.innerHTML = '<div class="row form-group"><div class="col-md-4"><div class="form-group form-floating-label"><input type="text" class="form-control input-border-bottom" required=""><label class="placeholder">Type of Document</label></div></div><div class="col-md-4"><div class="form-group"><label for="exampleFormControlFile1">Upload Document</label><input type="file" class="form-control-file" id="exampleFormControlFile1"></div><span>*Document Size not more than 300 KB</span></div><div class="col-md-4"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
  
  
  function checkreff(val) {
	if(val=='Own'){
	document.getElementById("reff_own").style.display = "block";
		document.getElementById("reff_part").style.display = "none";
		$("#reffered_own").prop('required',true);
		$("#reffered_part").prop('required',false);
	}else if(val=='Partner'){
		document.getElementById("reff_own").style.display = "none";
			document.getElementById("reff_part").style.display = "block";
				$("#reffered_own").prop('required',false);
		$("#reffered_part").prop('required',true);
	}else{
		document.getElementById("reff_own").style.display = "none";
			document.getElementById("reff_part").style.display = "none";
				$("#reffered_own").prop('required',false);
		$("#reffered_part").prop('required',false);
	}
  
}

  $(document).ready(function(){
    $('#myForm').on('submit', function(e){
         var empid=document.getElementById("ref_id").value;
        e.preventDefault();
        if(empid!=''){
            this.submit();
        }else{
            $("#ref_id").focus();
        }
    });
});  
    

</script>
</body>
</html>