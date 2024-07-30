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
		<!-- End Sidebar -->
		<div class="main-panel">
		    	<div class="page-header">
						<!--<h4 class="page-title"><i class="fas fa-newspaper"></i>  Application Status List</h4>-->
					
					</div>
			<div class="content">
				<div class="page-inner">
				
						<?php
				$cos_success_rs=0;
					$per_spi_appli=0;
				$per_spi_hr=0;
				if($start_date =='' && $end_date=='' ){
						$or_lince=DB::Table('registration')
		        	->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 
		        
				->get();
				}
				
					
				if($start_date!='' && $end_date!=''  ){
				   	$or_lince=DB::Table('registration')
		        ->join('tareq_app', 'registration.reg', '=', 'tareq_app.emid')
				  ->where('registration.status','=','active') 
				    ->where('registration.verify','=','approved') 
               ->where('registration.licence','=','yes') 
				 ->whereBetween('tareq_app.assign_date', [$start_date, $end_date])
		        
		        
				->get();

				}
				
				
				
				
				
				
				
				
					?>
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-newspaper"></i> Application Status
									@if(count($or_lince)!=0)
									
									<form  method="post" action="{{ url('superadmin/search-application-excel') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    
                                	<input  value="<?php echo $start_date;?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
										<input  value="<?php echo $end_date;?>"  name="end_date" type="hidden" class="form-control input-border-bottom" required="" >
											
										 <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="padding:10px 15px;margin-top: -30px;float:right;margin-right: 15px;background:none !important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>	
											</form>
											
											@endif</h4>
									@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl.No.</th>
													<th>Organisation Name</th>
														<th>Organisation Address</th>
															<th>Authorising Officer Name</th>
																<th>Authorising Officer Contact Number</th>
																	<th>Application Submission Date</th>
																	<th>Organisation Status</th>
													<th>Employee Name</th>
												
												</tr>
											</thead>
											
											<tbody>
											   <?php $i = 1; ?>
							@foreach($or_lince as $company)
								<?php
							
								$pass=DB::Table('tareq_app')
		        
				 ->where('emid','=',$company->reg) 
				  ->where('ref_id','=',$company->ref_id) 
		         
				->first();
				$passname=DB::Table('users_admin_emp')
		        
			
				  ->where('employee_id','=',$company->ref_id) 
		         
				->first(); 
				if(!empty($pass)){
				    $ss=$pass->asign_name ;
				    if($pass->last_date!='1970-01-01' && $pass->last_date!=''){
				     $sa_date=date('d/m/Y',strtotime($pass->last_date)) ;
				    }else{
				      $sa_date='';   
				    }
				}else{
				  $ss='';  
				
				  $sa_date='';
				   
				}
						$passhr=DB::Table('hr_apply')
		        
				 ->where('emid','=',$company->reg) 
				 
				->first();
				$hr_sts='';
					if(!empty($passhr)){
					     $hr_sts=$passhr->licence ;  
					    
					}else{
					 $hr_sts='Work In Progress' ;  
					}
				?>
				<tr>
						
							<td>{{ $i }}</td>
							<td>{{ $company->com_name }}</td>
                                 	<td>@if($company->address!=''){{ $company->address }} @if($company->address2!=''),{{ $company->address2 }}@endif,{{  $company->road }},{{  $company->city }},{{  $company->zip }},{{  $company->country }}@endif</td>
                                 
                                 		<td>{{ $company->f_name }} {{ $company->l_name }}</td>
                                 			<td>{{ $company->con_num }}</td>
                                 				<td>{{$sa_date}}</td>
                                 				<td>{{$hr_sts}}</td>
							<td>{{ $passname->name }}</td>
						
                           
							     
                           
							
						</tr>
						<?php
						$i++;?>
			
							
							    <?php
							    
							    
							
							
								
							?>
						
								
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
	</script>
</body>
</html>