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
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Time Shift Management</h4>
						
					
					</div>
						
					
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title">Duty Roster of {{$employee_desigrs->name}}</h4>
									
								</div>
								<div class="card-body">
                                  <div class="add-shift">
                                  	
                                  </div>
                                  	<form method="post" action="{{ url('superadmin/edit-duty-roster') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="table-responsive">
										
										<table  class="display table table-striped table-hover" >
											<thead>
											    <tr>
													<th><div class="form-check"><label class="form-check-label">
													<span class="form-check-sign"> Select</span></label></div></th>
													<th>Date</th>
													<th>Day</th>
														<th>Start time</th>
													<th>End time</th>
													<th>Working Hours</th>
													
												
													
												</tr>
											
											</thead>
											
											<tbody>
															 <?php
											 $start_date=$tareq->start_date;
											  $end_date=$tareq->end_date;
															 $i=1;
 $start_mon=date('m',strtotime($start_date));
  $end_mon=date('m',strtotime($end_date));
$dutydesigrs=DB::table('duty_emp_leave')
     ->where('a_id', '=',  $tareq->id)
    
  ->get();
  $i=1;
  foreach($dutydesigrs as $valo){
		    
		    
		    ?>
		     <tr>
		         
		          <input type="hidden" value="{{$start_date}}" class="form-control" name="start_date"  id="start_date" readonly>
		          <input type="hidden" value="{{$end_date}}" class="form-control" name="end_date"  id="end_date" readonly>
		             <input type="hidden" value="{{$tareq->id}}" class="form-control" name="id"  id="id" readonly>
		             <input type="hidden" value="{{$valo->id}}" class="form-control" name="new_id<?=$i;?>"  id="new_id<?=$i;?>" readonly>
		             
		             	<td><div class="form-check"><label class="form-check-label"><input type="checkbox" name="date<?=$i;?>" value="{{$valo->date}}"  id="date<?=$i;?>"  onclick="myFunction(<?=$i;?>)"
		             	<?php
		             	 if($valo->work=='0'){
		             	     
		             	     
		             	 } else{
		             	     echo 'checked';
		             	 }
		             	     
		             	     ?>
		             	
		             	><span class="form-check-sign"> </span></label></div></td>
		             	 <td ><?= date('jS',strtotime($valo->date));?> - <?= date('M',strtotime($valo->date));?> - <?= date('Y',strtotime($start_date));?></td>
		             	  <td><?= date('l',strtotime($valo->date));?></td>
		             	  <td><input type="time" onchange="checktime(<?=$i;?>);"  name="start_time<?=$i;?>" class="form-control" id="start_time<?=$i;?>"   style="height: 35px !important" value="{{$valo->start_time}}" <?php
		             	 if($valo->work=='0'){
		             	     
		             	      echo 'readonly';
		             	    
		             	 }else{
							   echo 'required';
		             	   
		             	 }
		             	     
		             	     ?>></td>
		             	     <td><input type="time"   onchange="checktime(<?=$i;?>);" name="end_time<?=$i;?>" class="form-control" id="end_time<?=$i;?>"   style="height: 35px !important" value="{{$valo->end_time}}" <?php
		             	 if($valo->work=='0'){
		             	     
		             	      echo 'readonly';
		             	    
		             	 }else{
		             	    echo 'required';
		             	 }
		             	     
		             	     ?>></td>
		             	  	<td><input type="text"  name="hours<?=$i;?>" class="form-control" id="hoursbb<?=$i;?>"   style="height: 35px !important" value="{{$valo->hours}}" <?php
		             	 if($valo->work=='0'){
		             	     
		             	      echo 'readonly';
		             	    
		             	 }else{
		             	     echo 'readonly';
		             	 }
		             	     
		             	     ?>></td>
		          </tr>
		    <?php
		    
		    $i++;
		    
		    }
		    
      

?>
			
											</tbody>
												<tfoot>
														<tr>
														<td ><div class="form-check"><label class="form-check-label"><input id="selectAllval" class="form-check-input" type="checkbox" name="allval" >
													<span class="form-check-sign"> </span>Check All</label></div></td>
															<td colspan="2"><button style="float:right" class="btn btn-default">Save</button></td>
														</tr>
													</tfoot>
										</table>
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
   
   $("#selectAllval").click(function() {
    $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});
$("input[type=checkbox]").click(function() {
    if (!$(this).prop("checked")) {
        $("#selectAllval").prop("checked", false);
    }
});
	$('#allval').click(function(event) {  
		
			if(this.checked) {
				//alert("test");
				// Iterate each checkbox
				$(':checkbox').each(function() {
					this.checked = true;                        
				});
			} else {
				$(':checkbox').each(function() {
					this.checked = false;                       
				});
			}
		});
		
		function myFunction(val) {
  // Get the checkbox
  var checkBox = document.getElementById("date"+val);
  // Get the output text


  // If the checkbox is checked, display the output text
   if (checkBox.checked == true){
    
      
          $("#hoursbb"+val).prop("readonly", false);
         
          $("#start_time"+val).prop("readonly", false);
        
          $("#end_time"+val).prop("readonly", false);
		   $("#start_time"+val).prop("required", true);
		    $("#end_time"+val).prop("required", true);
  
  } else {
       
          $("#hoursbb"+val).prop("readonly", true);
         
          $("#start_time"+val).prop("readonly", true);
         
          $("#end_time"+val).prop("readonly", true);
		   $("#start_time"+val).prop("required", false);
		    $("#end_time"+val).prop("required", false);
     
  }
}


function checktime(val){
	   var in_time=btoa(document.getElementById("start_time"+val).value);
	   var out_time=btoa(document.getElementById("end_time" +val).value);
	  
	   	$.ajax({
		type:'GET',
		url:'https://workpermitcloud.co.uk/hrms/pis/gettimemintuesnew/'+in_time+'/'+out_time,
        cache: false,
		success: function(responsejj){
		
	var objh = jQuery.parseJSON(responsejj);
			 console.log(objh);
				    $("#hoursbb"+val).val(objh.hour+ '.' +objh.min );
				   $("#hoursbb"+val).attr("readonly", true);
				  
			
			  
			
			 
			   
		}
		});
   }
		
	</script>
</body>
</html>