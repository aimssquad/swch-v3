<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

		<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}'] },
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
		
  @include('leave.include.header-dashboard')
		<!-- Sidebar -->
		
		  @include('leave.include.sidebar')
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
				          @if(count($leave_type_tot)!=0)
				        <div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
								  
									<div class="card-title">Leave Type</div>
								
									<!--<div class="card-category">Daily information about statistics in system</div>-->
									<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
									    	<?php
									$k=1;
									?>
									     @foreach($leave_type_tot as $LeaveAlloca)
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-{{$k}}"></div>
											<h6 class="fw-bold mt-3 mb-0">{{$LeaveAlloca->leave_type_name}}</h6>
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
						  @if(count($leave_rule_tot)!=0)
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
								   
									<div class="card-title">Annual Total Leave</div>
								
								
									<div class="row py-3">
									
										<div class="col-md-12">
											<div id="chart-container">
												<canvas id="multipleLineChart"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							@endif
				    </div>
				    
				</div>
				
			</div>
			
			  @include('leave.include.footer')
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


	<!-- Chart JS -->
	<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script>
		<?php
									$k=1;
									$m=1;
									?>
									     @foreach($leave_type_tot as $LeaveAlloca)
									     <?php
								if($m=='4'){
								 $m=1;   
								}
								if($m=='1'){
								    $cor="'#f1f1f1', '#FF9E27'";
								}
									if($m=='2'){
								    $cor="'#f1f1f1', '#2BB930'";
								}	if($m=='3'){
								    $cor="'#f1f1f1', '#F25961'";
								}
									     ?>
										Circles.create({
			id:'circles-{{$k}}',
			radius:45,
			value:100,
			maxValue:100,
			width:7,
			text:{{ $LeaveAlloca->max_no}},
			colors:[<?= $cor;?>],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
											<?php
											$m++;
									$k++;
									?>
										@endforeach
		<?php
		  $offarr=array();
		   $offarrval=array();
		  ?>
	
 @foreach($leave_rule_tot as $LeaveAllocan)
 <?php
  $offarr[]='" Total '.$LeaveAllocan->alies.'"';
   $offarrval[]=$LeaveAllocan->max_no;
  ?>
	@endforeach
	<?php
		   $of_str='';     
		    $of_str_val=''; 
        $of_str=implode(',',$offarr);
         $of_str_val=implode(',',$offarrval);
		  ?>
		
		multipleLineChart = document.getElementById('multipleLineChart').getContext('2d');
		  <?php
				     $par=array();
				     ?>
			 @foreach($leave_rule_tot as $LeaveAllocanval) 
			 <?php
			 $par[]='0';
			 ?>
			 @endforeach
		
		
		var myMultipleLineChart = new Chart(multipleLineChart, {
			type: 'line',
			data: {
				labels: [<?= $of_str;?>],
				datasets: [
				    
				    <?php
		  $p=1;
		  	$o=1;
		  ?>
				  @foreach($leave_rule_tot as $LeaveAllocanval)  
				     <?php
				    
								if($o=='4'){
								 $o=1;   
								}
								if($o=='1'){
								    $corl="'#FF9E27'";
								}
									if($o=='2'){
								    $corl="'#2BB930'";
								}	if($o=='3'){
								    $corl="'#F25961'";
								}
$kk=array();
	foreach($par as $key=> $value){
	    $oo=$p-1;
	    
	    if($key==$oo){
	        
	        $kk[]=$LeaveAllocanval->max_no;

	    }else{
	        $kk[]=0;
	    }
	}
$stroo='';
$stroo=implode(',',$kk);

							
								
									     ?>
				    {
					label: <?php echo '"'.$LeaveAllocanval->leave_type_name.'"'; ?>,
					borderColor: <?= $corl;?>,
					pointBorderColor: "#FFF",
					pointBackgroundColor: <?= $corl;?>,
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: [<?=$stroo;?>]
				}	<?php
				if(count($leave_rule_tot)>$p){
				 echo '	,';   
				}
				?>
			<?php
			$o++;
				$p++;
				?>
				@endforeach]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position: 'top',
				},
				tooltips: {
					bodySpacing: 4,
					mode:"nearest",
					intersect: 0,
					position:"nearest",
					xPadding:10,
					yPadding:10,
					caretPadding:10
				},
				layout:{
					padding:{left:15,right:15,top:15,bottom:15}
				}
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