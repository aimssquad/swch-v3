<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assetsemcor/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
	<style>
.leave-status {
    background: linear-gradient(-45deg,#06418e,#1572e8);
    padding: 4px 0px;
    margin: 0 0px;
}
.leave-status p{margin:0;} .alert.alert-info{display:none !important;}
	</style>
</head>
<body style="background-color: #E4E5E6">
	<div class="wrapper">
		
  @include('employee-corner-organisation.include.header-dashboard')
		<!-- Sidebar -->
		
		  @include('employee-corner-organisation.include.sidebar')
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
								
							</div>
							
							
							<div class="ml-md-auto py-2 py-md-0">
								
							</div>
						</div>
					</div>
				</div>
				
				<div class="page-inner mt--5">
				    
				    <div class="row mt--2">
				        @if(count($LeaveAllocation)!=0)
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
									<div class="card-title">Leave Status</div>
									<div class="card-category">Leave in Hand</div>
									<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
									<?php
									$k=1;
									?>
									 @foreach($LeaveAllocation as $LeaveAlloca)
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-{{$k}}"><div class="circles-wrp" style="position: relative; display: inline-block;"><svg xmlns="http://www.w3.org/2000/svg" width="90" height="90"><path fill="transparent" stroke="#f1f1f1" stroke-width="7" d="M 44.99154756204665 3.500000860767564 A 41.5 41.5 0 1 1 44.942357332570026 3.500040032273624 Z" class="circles-maxValueStroke"></path><path fill="transparent" stroke="#FF9E27" stroke-width="7" d="M 44.99154756204665 3.500000860767564 A 41.5 41.5 0 1 1 20.644357636259837 78.60137921350231 " class="circles-valueStroke"></path></svg><div class="circles-text" style="position: absolute; top: 0px; left: 0px; text-align: center; width: 100%; font-size: 31.5px; height: 90px; line-height: 90px;">{{$LeaveAlloca->leave_in_hand}}</div></div></div>
											<h6 class="fw-bold mt-3 mb-0">{{$LeaveAlloca->alies}}</h6>
										</div>
										<?php
									$k++;
									?>
										 @endforeach
										
									</div>
								</div>
							</div>
						</div>
						@endif
						 <?php
							
						
				    $usetype = Session::get('user_type_new'); 
					if( $usetype=='employee'){
						$usemail = Session::get('user_email_new'); 
					 $users_id = Session::get('users_id_new'); 
					 $dtaem=DB::table('users')      
                 
                  ->where('id','=',$users_id) 
                  ->first();
                  	 $employee_auth = DB::table('employee')      
                   ->where('emp_code','=',$dtaem->employee_id) 
                  ->where('emid','=',$dtaem->emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  if(!empty($employee_auth->emp_department)){
                    
                    
                     $employee_depers=DB::table('department')
     ->where('department_name', '=',  $employee_auth->emp_department)
    ->where('emid', '=',  $dtaem->emid)
  ->first();
  
             $employee_desigrs=DB::table('designation')
     ->where('designation_name', '=',  $employee_auth->emp_designation)
      ->where('department_code', '=',  $employee_depers->id)
    ->where('emid', '=',  $dtaem->emid)
  ->first();    
  							 $duty_auth = DB::table('duty_roster')      
                   ->where('department','=',$employee_depers->id)
                   ->where('designation','=',$employee_desigrs->id)
                    ->where('employee_id','=',$dtaem->employee_id) 
                  ->where('emid','=',$dtaem->emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  if(!empty($duty_auth)){
                  	 $shift_auth = DB::table('shift_management')      
                   ->where('department','=',$employee_depers->id)
                    ->where('id','=',$duty_auth->shift_code)
                   ->where('designation','=',$employee_desigrs->id)
                   
                  ->where('emid','=',$dtaem->emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
                   $off_auth = DB::table('offday')      
                   ->where('department','=',$employee_depers->id)
                    ->where('shift_code','=',$duty_auth->shift_code)
                   ->where('designation','=',$employee_desigrs->id)
                   
                  ->where('emid','=',$dtaem->emid) 
                  ->orderBy('id', 'DESC')
                  ->first();
                  
                  $datein = strtotime(date("Y-m-d ".$shift_auth->time_in));
			$dateout = strtotime(date("Y-m-d ".$shift_auth->time_out));
			$difference = abs($dateout - $datein)/60;
			$hours = floor($difference / 60);
		    $minutes = ($difference % 60);
			$duty_hours= $hours;
                  $offarr=array();
                  $off_day=array();
                  if(!empty($off_auth)){
                   if($off_auth->sun=='1' ){
                    $offarr[]='0'; 
                    $off_day[]='Sunday';
                  } else{
                       $offarr[]=$duty_hours;
                  }
                  
                  if($off_auth->mon=='1' ){
                    $offarr[]='0'; 
                     $off_day[]='Monday';
                  } else{
                       $offarr[]=$duty_hours;
                       
                  }  
                  
                   if($off_auth->tue=='1' ){
                    $offarr[]='0';
                     $off_day[]='Tuesday';
                  } else{
                       $offarr[]=$duty_hours;
                  }  
                  
                  
                   if($off_auth->wed=='1' ){
                    $offarr[]='0'; 
                     $off_day[]='wednesday';
                  } else{
                       $offarr[]=$duty_hours;
                  } 
                  
                  if($off_auth->thu=='1' ){
                    $offarr[]='0'; 
                     $off_day[]='Thursday';
                  } else{
                       $offarr[]=$duty_hours;
                  } 
                  
                  if($off_auth->fri=='1' ){
                    $offarr[]='0';  
                    $off_day[]='Friday';
                  } else{
                       $offarr[]=$duty_hours;
                  } 
                  if($off_auth->sat=='1' ){
                    $offarr[]='0'; 
                     $off_day[]='Saturday';
                  } else{
                       $offarr[]=$duty_hours;
                  } 
                  }
           $of_str='';       
        $of_str=implode(',',$offarr);         
         $of_str_val='';  
         $of_str_val=implode(',',$off_day); 
        
                  }
                   
                  }
                
                 
                
}
if(isset($of_str) && !empty($of_str)  ){
    $of_str=$of_str;
    
}else{
    $of_str='';
}
if(isset($of_str_val) && !empty($of_str_val)  ){
    $of_str_val=$of_str_val;
    
}else{
    $of_str_val='';
}		
				  ?>
						@if(isset($of_str) && !empty($of_str)  )
						<div class="col-md-6">
							<div class="card full-height">
								<div class="card-body">
								    							    
									<div class="card-title">Duty Roster</div>
									<div class="row py-3">
										
										<div class="col-md-12">
											<div id="chart-container"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
												<canvas id="totalIncomeChart" width="298" height="150" class="chartjs-render-monitor" style="display: block; width: 298px; height: 150px;"></canvas>
											</div>
										
				  @if(!empty($duty_auth) && isset($duty_auth))	<p>Shift Name: {{ $shift_auth->shift_code }}
											</p>
											<p>Shift Time: {{ date('h:i a',strtotime($shift_auth->time_in)) }} - {{ date('h:i a',strtotime($shift_auth->time_out)) }}</p>
											<p style="color:gray;font-size:15px;">Day Off:</span><span style="color:green;font-size:15px;"> {{$of_str_val }}</span>.</p>
										@endif
										
										
										
										</div>
									</div>
									
								</div>
							</div>
						</div>
						@endif
						
						
					</div>
				</div>
				  @if(Session::has('message'))										
				<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
		@endif	 @if(count($leaveApply)!=0)
				  <div class="leave-status">
                  	<p>View Approved & Unapproved Leave</p>
                  </div>	
                  
                                   	<div class="row form-group">
                                   		<div class="col-md-12">
                                   			<div class="table-heading">
                                   				
                                   			</div>
                                   			
                                   			<div class="table-responsive">
                                   			
                                   			<table id="" class="display table table-striped table-hover" >
											<thead>
												<tr class="table-th-bg">
													<th>SL No.</th>
                                                    <th>Employee Code</th>
													<th>Name</th>
													<th>Leave Type</th>
													<th>Date Of Application</th>
													<th>No. Of Leave</th>	
													<th>Duration</th>	
													<th>Status</th>
													<th>Remarks (If Any)</th>
												</tr>
											</thead>
											     <tbody>
                                                @foreach($leaveApply as $lvapply)
                                                <tr>
                                                    <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                                                    
                                                    <td style="text-align:center;">{{$lvapply->employee_id}}</td>
                                                    <td style="text-align:center;"><span class="name">{{$lvapply->employee_name}}</span></td>
                                                    <td style="text-align:center;"><span class="product">{{$lvapply->leave_type_name}}</span></td>
                                                    <td style="text-align:center;"><span class="date"><?php $date=date_create($lvapply->date_of_apply);
                                                        echo date_format($date,"d/m/Y");  ?></span></td>

						<td style="text-align:center;"><span class="name">{{$lvapply->no_of_leave}}</span></td>

                        <td style="text-align:center;"><span class="date"><?php $fromdate=date_create($lvapply->from_date);
                                                        echo date_format($fromdate,"d/m/Y");  ?> To <?php $todate=date_create($lvapply->to_date);
                                                        echo date_format($todate,"d/m/Y");  ?></span></td>
                                                    <td style="text-align:center;">@if($lvapply->status=='NOT APPROVED')<span class="badge badge-warning">{{$lvapply->status}}</span>@elseif($lvapply->status=='REJECTED')<span class="badge badge-danger">{{$lvapply->status}}</span>@elseif($lvapply->status=='APPROVED')<span class="badge badge-success">{{$lvapply->status}}</span>
                                                    @elseif($lvapply->status=='RECOMMENDED')<span class="badge badge-info">{{$lvapply->status}}</span>
                                                    @elseif($lvapply->status=='CANCEL')<span class="badge badge-danger">{{$lvapply->status}}</span>    
                                                    @endif</td>

                                                  
                                                    <td>{{ $lvapply->status_remarks }}</td>
                                                   
                                                </tr>
                                             @endforeach
                                            </tbody>
										</table>
										</div>
                                   			
                                   		</div>
                                 </div>
                                 @endif



			</div>
			
			  @include('employee-corner-organisation.include.footer')
		</div>
		
		<!-- Custom template | don't include it in your project! -->
		
		<!-- End Custom template -->
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('assetsemcor/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>


	<!-- Chart JS -->
	<script src="{{ asset('assetsemcor/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assetsemcor/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assetsemcor/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{ asset('assetsemcor/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('assetsemcor/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('assetsemcor/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{ asset('assetsemcor/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('assetsemcor/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('assetsemcor/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script>
	
<?php
									$m=1;
									?>
									 @foreach($LeaveAllocation as $LeaveAlloca)
										Circles.create({
			id:'circles-{{$m}}',
			radius:45,
			value:{{$LeaveAlloca->leave_in_hand}},
			maxValue:100,
			width:7,
			text: {{$LeaveAlloca->leave_in_hand}},
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

										<?php
									$m++;
									?>
										 @endforeach
		
		
		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["S", "M", "T", "W", "T", "F", "S"],
				datasets : [{
					label: "Duty Hours",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [<?=$of_str;?>],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							display: false //this will remove only the label
						},
						gridLines : {
							drawBorder: false,
							display : false
						}
					}],
					xAxes : [ {
						gridLines : {
							drawBorder: false,
							display : false
						}
					}]
				},
			}
		});

		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>
</body>
</html>