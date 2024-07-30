<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
								<a href="{{url('superadmin/duty-roster')}}">Duty Roster</a>
							</li>
							
						</ul>
					</div>
						
					
						<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Duty Roster of {{$employee_desigrs->name}}</h4>
									
								</div>
								<div class="card-body">
                                  <div class="add-shift">
                                  	
                                  </div>
                                  	<form method="post" action="{{ url('superadmin/add-employee-duty-save') }}">
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
															 $i=1;
 $start_mon=date('m',strtotime($start_date));
  $end_mon=date('m',strtotime($end_date));
  for($y=$start_mon;$y<=$end_mon;$y++){
      
       if($y<=9){
		        $y=$y;
		    }else{
		        $y=$y;
		    }
		    
		     $my_year=date('Y');
		     $first_day_this_year = date('Y').'-'.$y.'-01'; 
		   if($y=='01' || $y=='03' || $y=='05' || $y=='07' || $y=='08' || $y=='10' || $y=='12'){
		       $last_day_this_year  = date('Y').'-'.$y.'-31' ;
		       $last_day='31';
		   }
        
      if($y=='04' || $y=='06' || $y=='09' || $y=='11' ){
		       $last_day_this_year  = date('Y').'-'.$y.'-30' ;
		         $last_day='30';
		   }
        
       if($y=='02'){
          if ($my_year % 400 == 0){
            $last_day_this_year  = date('Y').'-'.$y.'-29' ;
		        $last_day='29';   
          }
    
   if ($my_year % 4 == 0){
      $last_day_this_year  = date('Y').'-'.$y.'-29' ;
		        $last_day='29';    
   }
     
   else if ($my_year % 100 == 0){
       $last_day_this_year  = date('Y').'-'.$y.'-28' ;
		        $last_day='28';   
   }
      
   else
     {
        $last_day_this_year  = date('Y').'-'.$y.'-28' ;
		        $last_day='28';    
     }
		      
		   }
		     $off_auth = DB::table('offday_emp')      
                  
                    ->where('employee_id', '=',  $employee_desigrs->employee_id)
                  ->orderBy('id', 'DESC')
                  ->first();
                   $off_day=0;
                   $sun='';
                   $mon='';
                   $tue='';
                  $wed='';
                  $thu='';
                  $fri='';
                  $sat='';
                  if(!empty($off_auth)){
                   if($off_auth->sun=='1' ){
                    $sun='Sunday';
                   $off_day=$off_day+1;
                  }
                  if($off_auth->mon=='1' ){
                    $off_day=$off_day+1;
                     $mon='Monday';
                  } 
                  
                   if($off_auth->tue=='1' ){
                  $off_day=$off_day+1;
                   $tue='Tuesday';
                  } 
                  
                  
                   if($off_auth->wed=='1' ){
                   $off_day=$off_day+1;
                     $wed='Wednesday';
                  } 
                  
                  if($off_auth->thu=='1' ){
                  $off_day=$off_day+1;
                    $thu='Thursday';
                  } 
                  
                  if($off_auth->fri=='1' ){
                  $off_day=$off_day+1;
                    $fri='Friday';
                  } 
                  if($off_auth->sat=='1' ){
                    $off_day=$off_day+1;
                     $sat='Saturday';
                  } 
                  
                  
                  
                  }
		       for($m=1;$m<32;$m++){
         if($m<=9){
		        $m='0'.$m;
		    }else{
		        $m=$m;
		    }
		    if($last_day>=$m){
		        
		    
		    $nfd=date('Y',strtotime($start_date)).'-'.$y.'-'.$m;
		    
		    
		    
		    ?>
		     <tr>
		         
		          <input type="hidden" value="{{$start_date}}" class="form-control" name="start_date"  id="start_date" readonly>
		          <input type="hidden" value="{{$end_date}}" class="form-control" name="end_date"  id="end_date" readonly>
		             <input type="hidden" value="{{$employee_id}}" class="form-control" name="employee_id"  id="employee_id" readonly>
		             
		             	<td><div class="form-check"><label class="form-check-label"><input type="checkbox" name="date<?=$i;?>" value="{{$nfd}}"  id="date<?=$i;?>"  onclick="myFunction(<?=$i;?>)"
		             	<?php
		             	 if(isset($mon) && $mon!='' && $mon==date("l",strtotime($nfd))){
		             	     
		             	     
		             	 } else if(isset($tue) && $tue!='' && $tue==date("l",strtotime($nfd))){
		             	     
		             	     
		             	 } else if(isset($wed) && $wed!='' && $wed==date("l",strtotime($nfd))){
		             	     
		             	     
		             	 }else if(isset($thu) && $thu!='' && $thu==date("l",strtotime($nfd))){
		          
		          
		          
		             	 } else if(isset($fri) && $fri!='' && $fri==date("l",strtotime($nfd))){
		             	     
		             	     
		             	 } else if(isset($sat) && $sat!='' && $sat==date("l",strtotime($nfd))){
		         
		         
		             	 }  else if(isset($sun) && $sun!='' && $sun==date("l",strtotime($nfd))){
		             	     
		             	     
		             	 }else{
		             	     echo 'checked';
		             	 }
		             	     
		             	     ?>
		             	
		             	><span class="form-check-sign"> </span></label></div></td>
		             	 <td ><?= date('jS',strtotime($nfd));?> - <?= date('M',strtotime($nfd));?> - <?= date('Y',strtotime($start_date));?></td>
		             	  <td><?= date('l',strtotime($nfd));?></td>
		             	  
		             	  <td><input type="time" onchange="checktime(<?=$i;?>);"  name="start_time<?=$i;?>" class="form-control" id="start_time<?=$i;?>"   style="height: 35px !important" <?php
		             	 if(isset($mon) && $mon!='' && $mon==date("l",strtotime($nfd))){
		             	     
		             	      echo 'readonly';
		             	 } else if(isset($tue) && $tue!='' && $tue==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 } else if(isset($wed) && $wed!='' && $wed==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 }else if(isset($thu) && $thu!='' && $thu==date("l",strtotime($nfd))){
		          
		           echo 'readonly';
		          
		             	 } else if(isset($fri) && $fri!='' && $fri==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 } else if(isset($sat) && $sat!='' && $sat==date("l",strtotime($nfd))){
		          echo 'readonly';
		         
		             	 }  else if(isset($sun) && $sun!='' && $sun==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 }else{
		             	 echo 'required'; 
		             	 }
		             	     
		             	     ?>></td>
		             	     <td><input type="time"   onchange="checktime(<?=$i;?>);" name="end_time<?=$i;?>" class="form-control" id="end_time<?=$i;?>"   style="height: 35px !important" <?php
		             	 if(isset($mon) && $mon!='' && $mon==date("l",strtotime($nfd))){
		             	     
		             	      echo 'readonly';
		             	 } else if(isset($tue) && $tue!='' && $tue==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 } else if(isset($wed) && $wed!='' && $wed==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 }else if(isset($thu) && $thu!='' && $thu==date("l",strtotime($nfd))){
		          
		           echo 'readonly';
		          
		             	 } else if(isset($fri) && $fri!='' && $fri==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 } else if(isset($sat) && $sat!='' && $sat==date("l",strtotime($nfd))){
		          echo 'readonly';
		         
		             	 }  else if(isset($sun) && $sun!='' && $sun==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 }else{
		             	    echo 'required'; 
		             	 }
		             	     
		             	     ?>></td>
		             	  	<td><input type="text"  name="hours<?=$i;?>" class="form-control" id="hoursbb<?=$i;?>"   style="height: 35px !important" <?php
		             	 if(isset($mon) && $mon!='' && $mon==date("l",strtotime($nfd))){
		             	     
		             	      echo 'readonly';
		             	 } else if(isset($tue) && $tue!='' && $tue==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 } else if(isset($wed) && $wed!='' && $wed==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 }else if(isset($thu) && $thu!='' && $thu==date("l",strtotime($nfd))){
		          
		           echo 'readonly';
		          
		             	 } else if(isset($fri) && $fri!='' && $fri==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 } else if(isset($sat) && $sat!='' && $sat==date("l",strtotime($nfd))){
		          echo 'readonly';
		         
		             	 }  else if(isset($sun) && $sun!='' && $sun==date("l",strtotime($nfd))){
		             	      echo 'readonly';
		             	     
		             	 }else{
		             	  echo 'required'; 
		             	 
		             	 }
		             	     
		             	     ?>></td>
		          </tr>
		    <?php
		    
		    $i++;
		    
		    }
		    
      
		       }
      
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
		   $("#start_time"+val).prop("required", true);
		    $("#end_time"+val).prop("required", true);
        
          $("#end_time"+val).prop("readonly", false);
  
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