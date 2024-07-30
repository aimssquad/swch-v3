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
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets/css/fonts.min.css']},
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
	.dash-inr {margin: -45px 15px;}
.alert.alert-info{display:none !important}
.dash-box{padding: 15px 30px;border-radius: 7px;margin-bottom: 26px;}
.grn {background: #30a24b;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
.dash-box img{width:50px}
.dash-cont h4{color:#fff;padding-top:15px;font-size:13px;}
.numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}
.bg-primary-gradient {
/*    background: #1572e8!important;*/
/*    background: -webkit-linear-gradient(legacy-direction(-45deg),#06418e,#1572e8)!important;*/
/*    background: linear-gradient( */
/*-45deg*/
/* ,#06418e,#1572e8)!important;*/
}
.go {
    background: #1572e8;
    width: 30px;
    border-radius: 50%;
    padding: 5px;
    margin: 15px 0;
}
/*.footer{position:relative;}*/
</style>
</head>
<body>
	<div class="wrapper">
		
  @include('company.include.header-dashboard')
		<!-- Sidebar -->
		
		  @include('company.include.sidebar')
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
					    
					    <div class="col-md-12">
							<div class="card full-height">
								<div class="card-body rnd">
									<div class="card-title">Organisation Statistics</div>
									<!-- <div class="card-category">Daily information about statistics in system</div> -->
									<div class="row pb-2 pt-4">
										<div class="col-md-4 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">Profile Status (  @if($Roledata->updated_at!='' ) Complete  @else Incomplete  @endif)</h6>
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('company-profile/edit-company')}}?c_id={{base64_encode($Roledata->id)}}" style="padding: 0 10px 17px;">
			
										
							<img class="go" src="https://climbr.co.in/assets/img/login.png" style="background: #2bb930;"></a>

										</div>
										<div class="col-md-4 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">Employees According to RTI</h6>

											<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('company-employee-rti')}}" style="padding: 0 10px 17px;">		
										
							<img class="go" src="https://climbr.co.in/assets/img/login.png" style="background: #ff9e27;"></a>
										</div>
										<div class="col-md-4 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">Authorizing Officer</h6>

											<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('company-authorizing-officer')}}" style="padding: 0 10px 17px;">		
										
							<img class="go" src="https://climbr.co.in/assets/img/login.png" style="background: #f25961;"></a>
										</div>
										</div>
										<div class="row pb-2 pt-4">	
										<div class="col-md-4 text-center">
											<div id="circles-4"></div>
											<h6 class="fw-bold mt-3 mb-0">Key Contact</h6>
											<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('company-key-contact')}}" style="padding: 0 10px 17px;">		
										
							<img class="go" src="https://climbr.co.in/assets/img/login.png" style="background: #037ae0;"></a>
										</div>
										<div class="col-md-4 text-center">
											<div id="circles-5"></div>
											<h6 class="fw-bold mt-3 mb-0">level 1 user</h6>

											<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('company-level-user')}}" style="padding: 0 10px 17px;">		
										
							<img class="go" src="https://climbr.co.in/assets/img/login.png" style="background: #c809ea;"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					 </div>
				</div>
				
			</div>
			
			  @include('company.include.footer')
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
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
	<script>
		

		Circles.create({
			id:'circles-1',
			radius:45,
			value:  <?php if($Roledata->updated_at!='' ){ echo '100';  }else{ echo '0';} ?>,
			maxValue:100,
			width:7,
			text: <?php if($Roledata->updated_at!='' ){ echo '100';  }else{ echo '0';} ?>,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
   <?php  
											     $employee_or_rs = DB::table('company_employee')
                      ->where('emid','=',$Roledata->reg)
                 ->get();
                 ?>
		Circles.create({
			id:'circles-2',
			radius:45,
			value: <?= count($employee_or_rs);?>,
			maxValue:100,
			width:7,
			text: <?= count($employee_or_rs);?>,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value: 100,
			maxValue:100,
			width:7,
			text: 100,
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-4',
			radius:45,
			value:<?php if($Roledata->key_f_name!='' ){ echo '100';  }else{ echo '0';} ?>,
			maxValue:100,
			width:7,
			text: <?php if($Roledata->key_f_name!='' ){ echo '100';  }else{ echo '0';} ?>,
			colors:['#f1f1f1', '#037ae0'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		Circles.create({
			id:'circles-5',
			radius:45,
			value: <?php if($Roledata->level_f_name!='' ){ echo '100';  }else{ echo '0';} ?>,
			maxValue:100,
			width:7,
			text: <?php if($Roledata->level_f_name!='' ){ echo '100';  }else{ echo '0';} ?>,
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
				datasets : [{
					label: "Total Income",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
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