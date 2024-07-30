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
	<style>
	.dash-inr {margin: -45px 15px;}
.alert.alert-info{display:none !important}
.dash-box{padding: 15px 30px;border-radius: 7px;    margin-bottom: 26px;}
.grn {background: #30a24b;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
.dash-box img{width:50px}
.dash-cont h4{color:#fff;padding-top:15px;font-size: 13px;}
.numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}</style>
</head>
<body>
	<div class="wrapper">

  @include('attendance.include.header-dashboard')
		<!-- Sidebar -->

		  @include('attendance.include.sidebar')
		<!-- End Sidebar -->
<?php


				    $usetype = Session::get('user_type');
					if( $usetype=='employee'){
						$usemail = Session::get('user_email');
					 $users_id = Session::get('users_id');
					 $dtaem=DB::table('users')

                  ->where('id','=',$users_id)
                  ->first();
							 $Roles_auth = DB::table('role_authorization')
                  ->where('emid','=',$dtaem->emid)
                  ->where('member_id','=',$dtaem->email)
                  ->get()->toArray();
$arrrole=array();
			foreach($Roles_auth as $valrol){
				$arrrole[]=$valrol->menu;
			}

				  }

				  	$email = Session::get('emp_email');
     $Roledata = DB::table('registration')

                  ->where('email','=',$email)
                  ->first();

                   $employee_rs=DB::Table('employee')
              ->join('attandence','employee.emp_code','=','attandence.employee_code')

            ->where('employee.emid', '=', $Roledata->reg )
              ->where('attandence.emid', '=', $Roledata->reg )

			  ->where('attandence.date', '=',date('Y-m-d') )

             ->select('employee.*')
               ->distinct()
              ->get();
			$employee_rs_ab=DB::Table('employee')

            ->where('emid', '=', $Roledata->reg )


              ->get();
	$ab=count($employee_rs_ab)-count($employee_rs);


	    $leave_apply_rs =  DB::Table('employee')
              ->join('leave_apply','employee.emp_code','=','leave_apply.employee_id')

            ->where('employee.emid', '=', $Roledata->reg )
              ->where('leave_apply.emid', '=', $Roledata->reg )
		  ->whereMonth('leave_apply.to_date', date('m'))

			   ->where('leave_apply.status', '=','APPROVED' )
             ->select('leave_apply.*')
               ->distinct()
              ->get();

	    $co=0;

	   if(!empty($leave_apply_rs)){

      foreach($leave_apply_rs as $leave_rs){

           $leave_apply =  DB::Table('leave_apply')

            ->where('employee_id', '=', $leave_rs->employee_id )
              ->where('emid', '=', $Roledata->reg )

			  ->where('from_date', '<=', date('Y-m-d'))
			    ->where('to_date', '>=', date('Y-m-d'))
			   ->where('status', '=','APPROVED' )

              ->first();

              if(!empty($leave_apply)){
                   $co++;
              }else{

              }

      }
	   }


				  ?>
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
											  <img src="{{ asset('assets/img/employee-no.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4> Total No Of Employee Present</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{ count($employee_rs)}}</h5>
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
											  <img src="{{ asset('assets/img/emp-absent.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Total No Of Employee Absent</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{$ab}}</h5>
											</div>


										  </div>
										</div>
									  </div>
									</div>

					 <div class="col-xl-4 col-lg-4 col-md-6">
									  <div class="dash-box blue" style="background: #a19f9f;">
									    <div class="row">
										  <div class="col-md-8 col-8">
										    <div class="dash-ico">
											  <img src="{{ asset('assets/img/emp-leave.png')}}" alt="">
											</div>
											 <div class="dash-cont">
											   <h4>Total No Of Employee On Leave</h4>
											 </div>
										  </div>
										  <div class="col-md-4 col-4">
										    <div class="numb">
											  <h5>{{$co}}</h5>
											</div>


										  </div>
										</div>
									  </div>
									</div>










					 </div>
				</div>
				</div>
			</div>

			  @include('attendance.include.footer')
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
		Circles.create({
			id:'circles-1',
			radius:45,
			value:60,
			maxValue:100,
			width:7,
			text: 5,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:70,
			maxValue:100,
			width:7,
			text: 36,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:40,
			maxValue:100,
			width:7,
			text: 12,
			colors:['#f1f1f1', '#F25961'],
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
