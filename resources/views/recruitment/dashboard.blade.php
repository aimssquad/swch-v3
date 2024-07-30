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
	.dash-inr {margin: -45px 15px 0;}
.alert.alert-info{display:none !important}
.dash-box{padding: 15px 30px;border-radius: 7px;    margin-bottom: 26px;}
.grn {background: #30a24b;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
.dash-box img{width:50px}
.dash-cont h4{color:#fff;padding-top:15px;font-size: 17px;}
.numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}
.footer{position:relative;}.panel-header {
    background: #4e4e4e;
}
.go{    background: #1572e8;
    width: 30px;
    border-radius: 50%;
    padding: 5px;
    margin-top: 15px;}
</style>
</head>
<body>
	<div class="wrapper">
		
  @include('recruitment.include.header-dashboard')
		<!-- Sidebar -->
		
		  @include('recruitment.include.sidebar')
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
				   
			
				  ?>
		<div class="main-panel">
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
			<div class="content">
			    
			    
			    	<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body rnd">
									<div class="card-title"> Overall Statistics</div>
									<!-- <div class="card-category">Daily information about statistics in system</div> -->
									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">Job Applied</h6>
											<?php 
										if( $usetype=='employee'){
if(in_array('37', $arrrole))
{
	
	?>
			<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/candidate')}}" style="padding: 0 10px 17px;">
			
				<?php
}else{
	?> <a data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">
			
				
				<?php
}
									}else{
									?> <a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/candidate')}}" style="padding: 0 10px 17px;">
			
				
				<?php	
									}
									
?>					
												
										
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>

										</div>
										<div class="col-md-3 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">Shortlisted</h6>
 <?php 
										if( $usetype=='employee'){
if(in_array('38', $arrrole))
{
	
	?>
				<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/short-listing')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?> 	<a data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?>  	<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/short-listing')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>
										
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #2bb930;"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">Interview</h6>

 <?php 
										if( $usetype=='employee'){
if(in_array('40', $arrrole))
{
	
	?>
					<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/interview')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?> 	<a data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?>  	<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/interview')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>
										
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #f25961;"></a>
										</div>
										<div class="col-md-3 text-center">
											<div id="circles-4"></div>
											<h6 class="fw-bold mt-3 mb-0">Hired</h6>
										
																  <?php 
										if( $usetype=='employee'){
if(in_array('41', $arrrole))
{
	
	?>
				<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/hired')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?>  	<a data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?>  	<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/hired')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
										</div>
										</div>
									<div class="row pb-2 pt-4">
										<div class="col-md-3 text-center">
											<div id="circles-5"></div>
											<h6 class="fw-bold mt-3 mb-0">Offer Letter</h6>
								  <?php 
										if( $usetype=='employee'){
if(in_array('77', $arrrole))
{
	
	?>
				<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/offer-letter')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?> 	<a  data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?>  	<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/offer-letter')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>
										
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #c809ea;"></a>
										</div>
										
											<div class="col-md-3 text-center">
											<div id="circles-6"></div>
											<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
  <?php 
										if( $usetype=='employee'){
if(in_array('39', $arrrole))
{
	
	?>
			<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/reject')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?><a  data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?>  <a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/reject')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>
											
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #f3425f;"></a>
										</div>
											<div class="col-md-3 text-center">
											<div id="circles-7"></div>
											<h6 class="fw-bold mt-3 mb-0">Job Posting</h6>

<?php 
										if( $usetype=='employee'){
if(in_array('36', $arrrole))
{
	
	?>
			<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/job-post')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?>  <a  data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?> <a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/job-post')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>					
											
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #c808eb;"></a>
										</div>
										
											<div class="col-md-3 text-center">
											<div id="circles-8"></div>
											<h6 class="fw-bold mt-3 mb-0">Job Posting (External)</h6>

	<?php 
										if( $usetype=='employee'){
if(in_array('36', $arrrole))
{
	
	?>
				<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/job-published')}}" style="padding: 0 10px 17px;">		
										
				<?php
}else{
	?> 	<a  data-toggle="tooltip" data-placement="bottom" title="View" href="#" style="padding: 0 10px 17px;">		
										
				
				<?php
}
									}else{
									?> 	<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('recruitment/job-published')}}" style="padding: 0 10px 17px;">		
										
				
				<?php	
									}
									
?>					
										
							<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #c288eb;"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
			
				
			</div>
			
		<div class="row">
          <div class="col-md-7">
							<div class="card">
								<div class="card-header"><div class="card-title"></div></div>
								<div class="card-body">
			<div class="chart-container">
				<canvas id="barChart"></canvas>
			</div>
		</div>
							</div>
						</div>

		<div class="col-md-5">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Recently Sent Offer Letter</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive table-hover table-sales">
												<table class="table recent">
													
													<tbody>
													    @if(count($candidate_offer)!=0)
													     <?php $ij = 1; ?>
													    @foreach($candidate_offer as $offervalue)
													    @if($ij<6)
													<tr>
													
													<td><h2 style="margin-bottom: 0;font-size: 16px;color: #c1442e;">
															    
															    			{{$offervalue->name}}
				   															   </h2><span style="color: #ababab;    font-size: 13px;">Date of Sending : {{date('d/m/Y',strtotime($offervalue->cr_date))}}</span>
													
													 				
													 	 	 	</td>
															<td class="text-right">
												<h3 style="font-size: 15px;margin-bottom: 0;">&pound; {{ $offervalue->offered_sal }}</h3>
															<span style="color: #ababab;    font-size: 13px;">Date of Joinng : {{date('d/m/Y',strtotime($offervalue->date_jo))}}</span>
															</td>
															
														</tr>
														@endif
														  <?php
                                        $ij ++;
                                        ?>
														@endforeach
														@endif
															
														
													</tbody>
												</table>
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

	<script src="{{ asset('assets/js//setting-demo2.js')}}"></script>
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script>
		Circles.create({
			id:'circles-1',
			radius:45,
			value:{{ count($candidate_job)}},
			maxValue:100,
			width:7,
			text: {{ count($candidate_job)}},
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
			value:{{ count($candidate_short)}},
			maxValue:100,
			width:7,
			text: {{ count($candidate_short)}},
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
			value:{{ count($candidate_interview)}},
			maxValue:100,
			width:7,
			text: {{ count($candidate_interview)}},
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
			value:{{ count($candidate_hired)}},
			maxValue:100,
			width:7,
			text: {{ count($candidate_hired)}},
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
			value: {{ count($candidate_offer)}},
			maxValue:100,
			width:7,
			text: {{ count($candidate_offer)}},
			colors:['#f1f1f1', '#c809ea'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
Circles.create({
			id:'circles-6',
			radius:45,
			value:{{ count($candidate_rej)}},
			maxValue:100,
			width:7,
			text: {{ count($candidate_rej)}},
			colors:['#f1f1f1', '#f3425f'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		
		Circles.create({
			id:'circles-7',
			radius:45,
			value:{{ count($company_job_post_internal)}},
			maxValue:100,
			width:7,
			text: {{ count($company_job_post_internal)}},
			colors:['#f1f1f1', '#c808eb'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
			Circles.create({
			id:'circles-8',
			radius:45,
			value:{{ count($company_job_post_external)}},
			maxValue:100,
			width:7,
			text: {{ count($company_job_post_external)}},
			colors:['#f1f1f1', '#c288eb'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		
	
		
	var myBarChart = new Chart(barChart, {
			type: 'bar',
			data: {
				labels: ["Job Applied","Shortlisted","Interview","Hired","Offer Letter","Rejected"],
				datasets : [{
					 label: "Overall Statistics",
					backgroundColor: '#c809ea',
					borderColor: '#c809ea',
					data: [ {{ count($candidate_job)}}, {{ count($candidate_short)}}, {{ count($candidate_interview)}}, {{ count($candidate_hired)}}, {{ count($candidate_offer)}}, {{ count($candidate_rej)}}],
				}],
			},
			options: {
				responsive: true, 
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				},
			}
		});
	</script>
</body>
</html>