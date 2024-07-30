<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../../assets/css/fonts.min.css']},
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
    .main-panel{margin-top:0;}
    .col-10.col-xs-11.col-sm-4.alert.alert-info{display:none !important;}

	.dash-inr {margin: -45px 15px;}
.alert.alert-info{display:none !important}
.dash-box{padding: 15px 30px;border-radius: 7px;    margin-bottom: 26px;}
.grn {background: #30a24b;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
.dash-box img{width:50px}
.dash-cont h4{color:#fff;padding-top:15px;font-size:13px;}
.numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('employee.include.header')
		<!-- Sidebar -->
		
		  @include('employee.include.sidebar')
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
				
				
					<div class="dash-inr">
				<div class="container">
					<div class="row">
				
				 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box grn">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4 style="font-size:14px;">Number of Active Employees</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										      
											  <h5 >{{ count($employee_active)}}</h5>
											
											</div>
											
											
										  </div>
										</div>
									  </div>
									</div>
				
					 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box red">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Number of Inctive Employees</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
										       
											  <h5 >	{{ (count($employee_inactive)-count($employee_active))}}</h5>
										
											  
											</div>
											
											
										  </div>
										</div>
									  </div>
									</div>
									
									
									<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box blue">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Number of Suspend Employees</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{ count($employee_suspened)}}</h5>
											</div>
											
											
										  </div>
										</div>
									  </div>
									</div>
									
									
									<div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box sky">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Number of Complete Profile Employees</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{ count($employee_complete)}}</h5>
											</div>
											
											
										  </div>
										</div>
									  </div>
									</div>
										
					 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box grn">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/employee.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Number of Incomplete Profile Employees</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{ count($employee_incomplete)}}</h5>
											</div>
											
										
										  </div>
										</div>
									  </div>
									</div>
									
					  
					 
			
					
					
					
				
									
					  
					 </div>
					 
					<div class="row"> 
					 
					 	<div class="col-md-6">
							<div class="card full-height">
								<div class="card-body">
								    							    
									<div class="card-title"> Number Of Employees</div>
									<div class="row py-3">
										
										<div class="col-md-12">
											<div id="chart-container"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
												<canvas id="totalIncomeChart" width="298" height="150" class="chartjs-render-monitor" style="display: block; width: 298px; height: 150px;"></canvas>
											</div>
										
				 
										
										
										
										</div>
									</div>
									
								</div>
							</div>
						</div>
						</div>	
						
						
				</div>
				</div>
				
			</div>
			  
		</div>
		
		<!-- Custom template | don't include it in your project! -->
		
		<!-- End Custom template -->
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
	
		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["Part Time", "Full Time", "Contractual" , "Regular","Suspend","Left"],
				datasets : [{
					label: "Total Employees",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [{{ count($employee_parttime)}}, {{ count($employee_fulltime)}}, {{ count($employee_constuct)}}, {{ count($employee_regular)}}, {{ count($employee_suspened)}}, {{ count($employee_ex_empoyee)}}],
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