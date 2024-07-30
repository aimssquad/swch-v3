<?php

$arrrole = Session::get('empsu_role');
$userType = Session::get('usersu_type');
$emp_email = Session::get('empsu_email');
// dd($userType)
 //dd($emp_email);
$data = DB::table('sub_admin_registrations')->where('email', $emp_email)->where('status', 'active')->first();
if ($data) {
    $org_code = $data->org_code;
    
}
//dd($org_code);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="{{ asset('img/favicon.png')}}">
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("assets/css/fonts.min.css")}}']},
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
.go{    background: #1572e8;
    width: 30px;
    border-radius: 50%;
    padding: 5px;
    margin-top: 15px;}
.flag {
        width: 47px;
    height: 47px;
    border: 2px solid #999;
    border-radius: 50%;
    padding-top: 5px;
    padding-left: 5px;
}
.table td, .table th{padding:0 2px !important;}
table.table.recent td {
    height: 71px;
}
.text-center{
	padding-bottom:15px;
}
</style>

</head>
<body>
	<div class="wrapper">

  		@include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
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
				
				@if($userType=='sub-admin')
					<div class="p-5">
						<div class="card p-2" style="width: 18rem;">
							<div class="card-body bg-info-gradient">
								<p class="card-text text-light">
									<b>This is Registration URL: <span id="registrationUrl">{{ url('register/' . $org_code) }}</span></b>
								</p>
								<span class="copy-button text-warning" id="copyButton" onclick="copyToClipboard()">Copy URL</span>
							</div>
						</div>
					</div>
					<input type="text" id="tempInput" style="position: absolute; left: -9999px;">
				@endif


				<div class="page-inner mt--5">
					<div class="row mt--2">
						@if($userType=='admin')
							<div class="col-md-12">
								<div class="card full-height">
									<div class="card-body">
										<form  method="get" action="{{ url('superadmindasboard') }}" enctype="multipart/form-data" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<div class="row form-group">
												<div class="col-md-5">
													<div class=" form-group">
														<label for="inputFloatingLabel-select-date"  class="placeholder">From Date</label>
														<input id="start_date" value="<?php if (isset($start_date) && $start_date) {echo date('Y-m-d', strtotime($start_date));}?>"  name="start_date" type="date" class="form-control input-border-bottom" required>
													</div>
												</div>

												<div class="col-md-5">
													<div class=" form-group">
													<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
													<input id="end_date" name="end_date" value="<?php if (isset($end_date) && $end_date) {echo date('Y-m-d', strtotime($end_date));}?>"  type="date" class="form-control input-border-bottom" required>


													</div>
												</div>
												<div class="col-md-2 btn-up">
												<button class="btn btn-default" type="submit">Submit</button>
												<a class="btn btn-primary" href="{{ url('superadmindasboard') }}">Reset</a>
												</div>
											</div>

										</form>
									</div>
									<div class="card-body rnd">
										<div class="card-title"> Overall Organisation Statistics</div>
										<!-- <div class="card-category">Daily information about statistics in system</div> -->
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-1"></div>
												<h6 class="fw-bold mt-3 mb-0">Registered Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/active?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #2bb930;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/active')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #2bb930;"></a>
												@endif

											</div>
												<div class="col-md-2  text-center">
												<div id="circles-2ua"></div>
												<h6 class="fw-bold mt-3 mb-0">Country Wise Organiztion Count</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-country')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-country')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											
											<div class="col-md-2  text-center">
												<!--<div id="circles-2ua"></div>-->
												<div id="circles-2ua">
												    <div class="circles-wrp" style="position: relative; display: inline-block;"><svg xmlns="http://www.w3.org/2000/svg" width="90" height="90"><path fill="transparent" stroke="#f1f1f1" stroke-width="7" d="M 44.99154756204665 3.500000860767564 A 41.5 41.5 0 1 1 44.942357332570026 3.500040032273624 Z" class="circles-maxValueStroke"></path><path fill="transparent" stroke="#FF9E27" stroke-width="7" d="M 44.99154756204665 3.500000860767564 A 41.5 41.5 0 0 1 47.5629156305626 3.579214596164192 " class="circles-valueStroke"></path></svg><div class="circles-text" style="position: absolute; top: 0px; left: 0px; text-align: center; width: 100%; font-size: 31.5px; height: 90px; line-height: 90px;"></div></div>
												</div>
												
												<h6 class="fw-bold mt-3 mb-0">Unassigned Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/not-assigned?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/not-assigned')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-2a"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-2"></div>
												<h6 class="fw-bold mt-3 mb-0">WIP Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/verify?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/verify')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											<!-- <div class="px-2 pb-2 pb-md-0 text-center">
												<div id="circles-3"></div>
												<h6 class="fw-bold mt-3 mb-0">Not Verified Organisation</h6>

												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/notverify')}}" style="padding: 0 10px 17px;">

												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #f25961;"></a>
											</div> -->
											<div class="col-md-2  text-center">
												<div id="circles-4"></div>
												<h6 class="fw-bold mt-3 mb-0">License Applied</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2 text-center">
												<div id="circles-6"></div>
												<h6 class="fw-bold mt-3 mb-0">License Internal</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7"></div>
												<h6 class="fw-bold mt-3 mb-0">License External</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-external?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-external')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>

											<!-- <div class="px-2 pb-2 pb-md-0 text-center">
												<div id="circles-5"></div>
												<h6 class="fw-bold mt-3 mb-0">License Not Applied</h6>

												<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-not-applied')}}" style="padding: 0 10px 17px;">


												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #c809ea;"></a>
											</div> -->

											<div class="col-md-2  text-center">
												<div id="circles-7_1stinv"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled 1<sup>st</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-first-inv-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-first-inv-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_1stinvbilled"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed 1<sup>st</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-first-inv-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-first-inv-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_unsignedhr"></div>
												<h6 class="fw-bold mt-3 mb-0">Unassigned HR</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_assignedhr"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned HR</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_hrwip"></div>
												<h6 class="fw-bold mt-3 mb-0">HR WIP</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/wip-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/wip-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_hrcomplete"></div>
												<h6 class="fw-bold mt-3 mb-0">HR Complete</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/complete-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/complete-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcgranted"></div>
												<h6 class="fw-bold mt-3 mb-0">License Granted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcrejected"></div>
												<h6 class="fw-bold mt-3 mb-0">License Rejected</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcrefused"></div>
												<h6 class="fw-bold mt-3 mb-0">License Refused</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/refused-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/refused-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcpd"></div>
												<h6 class="fw-bold mt-3 mb-0">License Pending</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-pending-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-pending-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_2ndUnbilledInv"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled 2<sup>nd</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-second-invoice-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-second-invoice-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2 text-center">
												<div id="circles-7_2ndbilledInv"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed 2<sup>nd</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-second-invoice-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-second-invoice-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
										</div>
										<div class="card-title"> Recruitment</div>
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-recassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-recruitmentfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-recruitmentfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recreq"></div>
												<h6 class="fw-bold mt-3 mb-0">Requested</h6>
													@if($start_date!='' && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-request-recruitment-file?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
													@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-request-recruitment-file')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
													@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recon"></div>
												<h6 class="fw-bold mt-3 mb-0">Ongoing</h6>
												@if($start_date!='' && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-ongoing-recruitment-file?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-ongoing-recruitment-file')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-rechired"></div>
												<h6 class="fw-bold mt-3 mb-0">Hired</h6>
												@if($start_date!='' && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-hired-recruitment-file?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-hired-recruitment-file')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recubill"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-recruitmentfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-recruitmentfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recbill"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-recruitmentfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-recruitmentfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>


										</div>
										<div class="card-title"> COS</div>
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-cosunassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Request For COS</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unassigned-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unassigned-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Requested COS</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cospending"></div>
												<h6 class="fw-bold mt-3 mb-0">Pending</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-pending-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-pending-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosgranted"></div>
												<h6 class="fw-bold mt-3 mb-0">Granted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-granted-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-granted-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosrejected"></div>
												<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-rejected-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-rejected-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosunassigned"></div>
												<h6 class="fw-bold mt-3 mb-0">Unassigned</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unsignedcos-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unsignedcos-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosassigned"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-signedcos-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-signedcos-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visaunbilled"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled </h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visabilled"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed </h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>


										</div>
										<div class="card-title"> VISA</div>
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-visaunassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Request For VISA</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visaassign"></div>
												<h6 class="fw-bold mt-3 mb-0">WIP VISA</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<!-- <div class="col-md-2  text-center">
												<div id="circles-visapending"></div>
												<h6 class="fw-bold mt-3 mb-0">Pending</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/pending-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/pending-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div> -->
											<div class="col-md-2  text-center">
												<div id="circles-visasubmitted"></div>
												<h6 class="fw-bold mt-3 mb-0">Submitted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/submitted-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/submitted-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visagranted"></div>
												<h6 class="fw-bold mt-3 mb-0">Granted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visarejected"></div>
												<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>


										</div>

									</div>
								</div>
							</div>

						@endif
						
						@if($userType=='user' && in_array('3', $arrrole))	
							<div class="col-md-12">
								<div class="card full-height">
									<div class="card-body">
										<form  method="get" action="{{ url('superadmindasboard') }}" enctype="multipart/form-data" >
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<div class="row form-group">
												<div class="col-md-5">
													<div class=" form-group">
														<label for="inputFloatingLabel-select-date"  class="placeholder">From Date</label>
														<input id="start_date" value="<?php if (isset($start_date) && $start_date) {echo date('Y-m-d', strtotime($start_date));}?>"  name="start_date" type="date" class="form-control input-border-bottom" required>
													</div>
												</div>

												<div class="col-md-5">
													<div class=" form-group">
													<label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
													<input id="end_date" name="end_date" value="<?php if (isset($end_date) && $end_date) {echo date('Y-m-d', strtotime($end_date));}?>"  type="date" class="form-control input-border-bottom" required>


													</div>
												</div>
												<div class="col-md-2 btn-up">
												<button class="btn btn-default" type="submit">Submit</button>
												<a class="btn btn-primary" href="{{ url('superadmindasboard') }}">Reset</a>
												</div>
											</div>

										</form>
									</div>
									<div class="card-body rnd">
										<div class="card-title"> Overall Organisation Statistics</div>
										<!-- <div class="card-category">Daily information about statistics in system</div> -->
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-1"></div>
												<h6 class="fw-bold mt-3 mb-0">Registered Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/active?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #2bb930;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/active')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #2bb930;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-2ua"></div>
												<h6 class="fw-bold mt-3 mb-0">Unassigned Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/not-assigned?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/not-assigned')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-2a"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-2"></div>
												<h6 class="fw-bold mt-3 mb-0">WIP Organisation</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/verify?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/verify')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #ff9e27;"></a>
												@endif
											</div>
											<!-- <div class="px-2 pb-2 pb-md-0 text-center">
												<div id="circles-3"></div>
												<h6 class="fw-bold mt-3 mb-0">Not Verified Organisation</h6>

												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/notverify')}}" style="padding: 0 10px 17px;">

												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #f25961;"></a>
											</div> -->
											<div class="col-md-2  text-center">
												<div id="circles-4"></div>
												<h6 class="fw-bold mt-3 mb-0">License Applied</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2 text-center">
												<div id="circles-6"></div>
												<h6 class="fw-bold mt-3 mb-0">License Internal</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7"></div>
												<h6 class="fw-bold mt-3 mb-0">License External</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-external?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-applied-external')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>

											<!-- <div class="px-2 pb-2 pb-md-0 text-center">
												<div id="circles-5"></div>
												<h6 class="fw-bold mt-3 mb-0">License Not Applied</h6>

												<a  data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-not-applied')}}" style="padding: 0 10px 17px;">


												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #c809ea;"></a>
											</div> -->

											<div class="col-md-2  text-center">
												<div id="circles-7_1stinv"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled 1<sup>st</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-first-inv-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-first-inv-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_1stinvbilled"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed 1<sup>st</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-first-inv-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-first-inv-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_unsignedhr"></div>
												<h6 class="fw-bold mt-3 mb-0">Unassigned HR</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_assignedhr"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned HR</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_hrwip"></div>
												<h6 class="fw-bold mt-3 mb-0">HR WIP</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/wip-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/wip-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_hrcomplete"></div>
												<h6 class="fw-bold mt-3 mb-0">HR Complete</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/complete-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/complete-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcgranted"></div>
												<h6 class="fw-bold mt-3 mb-0">License Granted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcrejected"></div>
												<h6 class="fw-bold mt-3 mb-0">License Rejected</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcrefused"></div>
												<h6 class="fw-bold mt-3 mb-0">License Refused</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/refused-hr-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/refused-hr-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_lcpd"></div>
												<h6 class="fw-bold mt-3 mb-0">License Pending</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-pending-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/license-pending-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2  text-center">
												<div id="circles-7_2ndUnbilledInv"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled 2<sup>nd</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-second-invoice-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unbilled-second-invoice-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
											<div class="col-md-2 text-center">
												<div id="circles-7_2ndbilledInv"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed 2<sup>nd</sup> Invoice</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-second-invoice-internal?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
												<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/billed-second-invoice-internal')}}" style="padding: 0 10px 17px;">
												<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif
											</div>
										</div>
										<div class="card-title"> Recruitment</div>
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-recassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-recruitmentfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-recruitmentfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recreq"></div>
												<h6 class="fw-bold mt-3 mb-0">Requested</h6>
													@if($start_date!='' && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-request-recruitment-file?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
													@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-request-recruitment-file')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
													@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recon"></div>
												<h6 class="fw-bold mt-3 mb-0">Ongoing</h6>
												@if($start_date!='' && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-ongoing-recruitment-file?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-ongoing-recruitment-file')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-rechired"></div>
												<h6 class="fw-bold mt-3 mb-0">Hired</h6>
												@if($start_date!='' && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-hired-recruitment-file?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-hired-recruitment-file')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recubill"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-recruitmentfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-recruitmentfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-recbill"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-recruitmentfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-recruitmentfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>


										</div>
										<div class="card-title"> COS</div>
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-cosunassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Request For COS</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unassigned-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unassigned-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Requested COS</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-assigned-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cospending"></div>
												<h6 class="fw-bold mt-3 mb-0">Pending</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-pending-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-pending-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosgranted"></div>
												<h6 class="fw-bold mt-3 mb-0">Granted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-granted-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-granted-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosrejected"></div>
												<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-rejected-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-rejected-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosunassigned"></div>
												<h6 class="fw-bold mt-3 mb-0">Unassigned</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unsignedcos-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unsignedcos-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-cosassigned"></div>
												<h6 class="fw-bold mt-3 mb-0">Assigned</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-signedcos-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-signedcos-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visaunbilled"></div>
												<h6 class="fw-bold mt-3 mb-0">Unbilled </h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-unbilled-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visabilled"></div>
												<h6 class="fw-bold mt-3 mb-0">Billed </h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-cosfile?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/list-billed-cosfile')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>


										</div>
										<div class="card-title"> VISA</div>
										<div class="row">
											<div class="col-md-2  text-center">
												<div id="circles-visaunassign"></div>
												<h6 class="fw-bold mt-3 mb-0">Request For VISA</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/unassigned-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visaassign"></div>
												<h6 class="fw-bold mt-3 mb-0">WIP VISA</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/assigned-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<!-- <div class="col-md-2  text-center">
												<div id="circles-visapending"></div>
												<h6 class="fw-bold mt-3 mb-0">Pending</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/pending-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/pending-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div> -->
											<div class="col-md-2  text-center">
												<div id="circles-visasubmitted"></div>
												<h6 class="fw-bold mt-3 mb-0">Submitted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/submitted-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/submitted-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visagranted"></div>
												<h6 class="fw-bold mt-3 mb-0">Granted</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/granted-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>
											<div class="col-md-2  text-center">
												<div id="circles-visarejected"></div>
												<h6 class="fw-bold mt-3 mb-0">Rejected</h6>
												@if(isset($start_date) && $start_date!='' && isset($end_date) && $end_date!='')
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-visafile-list?start_date='.date('Y-m-d',strtotime($start_date)).'&end_date='.date('Y-m-d',strtotime($end_date)))}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@else
													<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{url('superadmin/rejected-visafile-list')}}" style="padding: 0 10px 17px;">
													<img class="go" src="{{ asset('assets/img/login.png')}}" style="background: #037ae0;"></a>
												@endif

											</div>


										</div>

									</div>
								</div>
							</div>
						@endif

						@if($userType=='admin')
							<div class="col-md-8">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Yearly Invoice Generated For <?=date('Y');?></div>
									</div>
									<div class="card-body">
										<div class="chart-container">
											<canvas id="lineChart"></canvas>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Recent Invoice</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive table-hover table-sales">
													<table class="table recent">

														<tbody>
														<?php $bill_rers = DB::Table('billing')->where('status', '!=', 'cancel')->groupBy('in_id')->orderBy('in_id', 'desc')->limit(4)->get();?>
														<?php if (count($bill_rers) != 0) {?>
														<?php foreach ($bill_rers as $value) {?>

														<?php $pass = DB::Table('registration')->where('reg', '=', $value->emid)->first();?>
															<tr>
																<td width="50">
																	<div class="flag">
																	@if($pass->logo!='' && $value->billing_type=='Organisation')
																		<img src="{{ asset($pass->logo) }}" alt="EITPL" width="35" style="border-radius:50%;">
																	@else
																		<img src="{{ asset('assets/img/profile.png')}}" alt="EITPL" width="35" style="border-radius:50%;">
																		@endif
																	</div>
																</td>
																<td><h2 style="margin-bottom: 0;font-size: 15px;color: #999;">

																	@if($value->billing_type=='Organisation')
																	{{ $pass->com_name }}
																	@elseif($value->billing_type=='Candidate')
																		{{$value->canidate_name}}
																	@endif
																</h2><span style="color: #ababab;    font-size: 13px;">{{ date('d/m/Y',strtotime($value->date)) }}</span>

														@if($value->status=='paid')
														<span style="color:green; font-size: 13px;">	(	{{ strtoupper($value->status) }})</span>
														@elseif($value->status=='not paid')
															<span style="color:#f3545d; font-size: 13px;">	(	{{ strtoupper($value->status) }})</span>
																@elseif($value->status=='partially paid')
														<span style="color:#fdaf4b; font-size: 13px;">	(	{{ strtoupper($value->status) }})</span>
														@endif
														</td>
																<td class="text-center" style="width:100px;">
																	<h3 style="font-size: 18px;margin-bottom: 0;">&pound; {{ $value->amount }} </h3>
																	<span class="text-right"><a target="_blank" href="{{asset('public/billpdf/'.$value->dom_pdf)}}">View</a></span>
																</td>

															</tr>
														<?php }}?>


														</tbody>
													</table>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Paid, Unpaid and Partially Paid Statistics</div>
									</div>
									<div class="card-body">
										<div class="chart-container">
											<canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
										</div>
									</div>
								</div>
							</div>
						@endif
						@if($userType=='user' && in_array('4', $arrrole))
							<div class="col-md-8">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Yearly Invoice Generated For <?=date('Y');?></div>
									</div>
									<div class="card-body">
										<div class="chart-container">
											<canvas id="lineChart"></canvas>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Recent Invoice</div>
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<div class="table-responsive table-hover table-sales">
													<table class="table recent">

														<tbody>
														<?php $bill_rers = DB::Table('billing')->where('status', '!=', 'cancel')->groupBy('in_id')->orderBy('in_id', 'desc')->limit(4)->get();?>
														<?php if (count($bill_rers) != 0) {?>
														<?php foreach ($bill_rers as $value) {?>

														<?php $pass = DB::Table('registration')->where('reg', '=', $value->emid)->first();?>
															<tr>
																<td width="50">
																	<div class="flag">
																	@if($pass->logo!='' && $value->billing_type=='Organisation')
																		<img src="{{ asset($pass->logo) }}" alt="EITPL" width="35" style="border-radius:50%;">
																	@else
																		<img src="{{ asset('assets/img/profile.png')}}" alt="EITPL" width="35" style="border-radius:50%;">
																		@endif
																	</div>
																</td>
																<td><h2 style="margin-bottom: 0;font-size: 15px;color: #999;">

																	@if($value->billing_type=='Organisation')
																	{{ $pass->com_name }}
																	@elseif($value->billing_type=='Candidate')
																		{{$value->canidate_name}}
																	@endif
																</h2><span style="color: #ababab;    font-size: 13px;">{{ date('d/m/Y',strtotime($value->date)) }}</span>

														@if($value->status=='paid')
														<span style="color:green; font-size: 13px;">	(	{{ strtoupper($value->status) }})</span>
														@elseif($value->status=='not paid')
															<span style="color:#f3545d; font-size: 13px;">	(	{{ strtoupper($value->status) }})</span>
																@elseif($value->status=='partially paid')
														<span style="color:#fdaf4b; font-size: 13px;">	(	{{ strtoupper($value->status) }})</span>
														@endif
														</td>
																<td class="text-center" style="width:100px;">
																	<h3 style="font-size: 18px;margin-bottom: 0;">&pound; {{ $value->amount }} </h3>
																	<span class="text-right"><a target="_blank" href="{{asset('public/billpdf/'.$value->dom_pdf)}}">View</a></span>
																</td>

															</tr>
														<?php }}?>


														</tbody>
													</table>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Paid, Unpaid and Partially Paid Statistics</div>
									</div>
									<div class="card-body">
										<div class="chart-container">
											<canvas id="pieChart" style="width: 50%; height: 50%"></canvas>
										</div>
									</div>
								</div>
							</div>
						@endif
					</div>

					@if($userType=='admin')
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Duty Roster on Dated {{date('d/m/Y')}}</div>
									</div>
									<div class="card-body">
										<div class="table-responsive table-hover table-sales">
											<table class="table">
												<thead>

												<th>Employee Name</th>
												<th>Day</th>
												<th>Start Time</th>
												<th>End Time</th>
												<th>Working Hours</th>
												</thead>
												<tbody>
													<?php
														$ff = 0;
														$duty_rers = DB::Table('duty_roster_emp')->where('start_date', 'like', date('Y-m') . '%')->get();
														if (count($duty_rers) != 0) {
															foreach ($duty_rers as $valdu) {
																$pass = DB::Table('duty_emp_leave')->where('a_id', '=', $valdu->id)->where('date', '=', date('Y-m-d'))->first();

																$emp = DB::Table('users_admin_emp')->where('employee_id', '=', $valdu->employee_id)->first();
																	?>
																@if(isset($pass->hours) && $pass->hours!='')
																	<?php $ff++;?>
																	<tr>

																		<td>{{$emp->name}} (Code : {{$valdu->employee_id}})</td>
																		<td>{{$pass->day}}</td>
																		<td>@if($pass->start_time!='' && $pass->work!=0) {{date('h:i A',strtotime($pass->start_time))}}          @endif</td>
																		<td>@if($pass->end_time!='' && $pass->work!=0) {{date('h:i A',strtotime($pass->end_time))}}          @endif</td>
																		<td>@if(isset($pass->hours) && $pass->hours!='') {{$pass->hours}} @else 0 (Offday) @endif</td>
																	</tr>
																@endif
																<?php
															}
														}
														if ($ff == 0) {?>
														No data found
													<?php }?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Work Update on Dated {{date('d/m/Y',strtotime("-1 days"))}}</div>
									</div>
									<div class="card-body">
										<div class="table-responsive table-hover table-sales">
											<table class="table">
												<thead>

												<th>Employee Name</th>
												<th>Day</th>
												<th>From Time</th>
												<th>To Time</th>
												<th>Total Target Hours</th>
												<th>Total Achieved Hours</th>
												</thead>
												<tbody>
													<?php $old_date = date('Y-m-d', strtotime("-1 days"));
														$duty_rers = DB::Table('rota_inst')->where('date', '=', date('Y-m-d', strtotime("-1 days")))->groupBy('employee_id')->get();

														if (count($duty_rers) != 0) {
															foreach ($duty_rers as $valdu) {
																$pass = DB::Table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours'), DB::raw('sum(w_min) as w_min'))->where('employee_id', '=', $valdu->employee_id)->where('date', '=', $valdu->date)->first();

																$emp = DB::Table('users_admin_emp')->where('employee_id', '=', $valdu->employee_id)->first();
																if ($pass->w_min != '0') {
																	$min = $pass->w_min / 60;
																} else {
																	$min = 0;
																}
																$totltime = 0;
																$totltime = $pass->w_hours + $min;

																if ($totltime > '6' && $totltime < '7') {
																	$totltime = '7';
																	$totltime = $totltime;
																} else if ($totltime >= '7') {
																	$totltime = $totltime + 1;

																} else {
																	$totltime = $totltime;

																}

																$duty_reracs = DB::Table('duty_roster_emp')->where('employee_id', '=', $valdu->employee_id)->where('start_date', 'like', date('Y-m', strtotime($old_date)) . '%')->first();

																if (!empty($duty_reracs)) {
																	$passnew = DB::Table('duty_emp_leave')->where('a_id', '=', $duty_reracs->id)->where('date', '=', $valdu->date)->first();
																}
																$pasdutynews = DB::Table('rota_inst')->where('employee_id', '=', $valdu->employee_id)->where('date', '=', $valdu->date)->get();
																$count = count($pasdutynews);?>
													<tr>

														<td>{{$emp->name}} (Code : {{$valdu->employee_id}})</td>
														<td>{{date('l',strtotime($valdu->date))}}</td>
														<td> {{date('h:i A',strtotime($pasdutynews[0]->in_time))}}          </td>
														<td> {{date('h:i A',strtotime($pasdutynews[($count-1)]->out_time))}}   </td>
														<td>@if(!empty($duty_reracs) && !empty($passnew)) {{$passnew->hours}}   @endif </td>
														<td>{{  number_format(floor($totltime*100)/100,1, '.', '')}}</td>
													</tr>

													<?php }} else {?>
													No data found
													<?php }?>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif
					
					@if($userType=='user' && in_array('6', $arrrole))
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Duty Roster on Dated {{date('d/m/Y')}}</div>
									</div>
									<div class="card-body">
										<div class="table-responsive table-hover table-sales">
											<table class="table">
												<thead>

												<th>Employee Name</th>
												<th>Day</th>
												<th>Start Time</th>
												<th>End Time</th>
												<th>Working Hours</th>
												</thead>
												<tbody>
													<?php
															$ff = 0;
															$duty_rers = DB::Table('duty_roster_emp')->where('start_date', 'like', date('Y-m') . '%')->get();
															if (count($duty_rers) != 0) {
																foreach ($duty_rers as $valdu) {
																	$pass = DB::Table('duty_emp_leave')->where('a_id', '=', $valdu->id)->where('date', '=', date('Y-m-d'))->first();

																	$emp = DB::Table('users_admin_emp')->where('employee_id', '=', $valdu->employee_id)->first();
																	?>
																	@if(isset($pass->hours) && $pass->hours!='')
																	<?php $ff++;?>
																	<tr>

																		<td>{{$emp->name}} (Code : {{$valdu->employee_id}})</td>
																		<td>{{$pass->day}}</td>
																		<td>@if($pass->start_time!='' && $pass->work!=0) {{date('h:i A',strtotime($pass->start_time))}}          @endif</td>
																		<td>@if($pass->end_time!='' && $pass->work!=0) {{date('h:i A',strtotime($pass->end_time))}}          @endif</td>
																		<td>@if(isset($pass->hours) && $pass->hours!='') {{$pass->hours}} @else 0 (Offday) @endif</td>
																	</tr>
																	@endif
																	<?php
																}
															}
															if ($ff == 0) {?>
																No data found
															<?php
															}   ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Work Update on Dated {{date('d/m/Y',strtotime("-1 days"))}}</div>
									</div>
									<div class="card-body">
										<div class="table-responsive table-hover table-sales">
											<table class="table">
												<thead>

												<th>Employee Name</th>
												<th>Day</th>
												<th>From Time</th>
												<th>To Time</th>
												<th>Total Target Hours</th>
												<th>Total Achieved Hours</th>
												</thead>
												<tbody>
													<?php $old_date = date('Y-m-d', strtotime("-1 days"));
							$duty_rers = DB::Table('rota_inst')->where('date', '=', date('Y-m-d', strtotime("-1 days")))->groupBy('employee_id')->get();

							if (count($duty_rers) != 0) {
								foreach ($duty_rers as $valdu) {
									$pass = DB::Table('rota_inst')->select(DB::raw('sum(w_hours) as w_hours'), DB::raw('sum(w_min) as w_min'))->where('employee_id', '=', $valdu->employee_id)->where('date', '=', $valdu->date)->first();

									$emp = DB::Table('users_admin_emp')->where('employee_id', '=', $valdu->employee_id)->first();
									if ($pass->w_min != '0') {
										$min = $pass->w_min / 60;
									} else {
										$min = 0;
									}
									$totltime = 0;
									$totltime = $pass->w_hours + $min;

									if ($totltime > '6' && $totltime < '7') {
										$totltime = '7';
										$totltime = $totltime;
									} else if ($totltime >= '7') {
										$totltime = $totltime + 1;

									} else {
										$totltime = $totltime;

									}

									$duty_reracs = DB::Table('duty_roster_emp')->where('employee_id', '=', $valdu->employee_id)->where('start_date', 'like', date('Y-m', strtotime($old_date)) . '%')->first();

									if (!empty($duty_reracs)) {
										$passnew = DB::Table('duty_emp_leave')->where('a_id', '=', $duty_reracs->id)->where('date', '=', $valdu->date)->first();
									}
									$pasdutynews = DB::Table('rota_inst')->where('employee_id', '=', $valdu->employee_id)->where('date', '=', $valdu->date)->get();
									$count = count($pasdutynews);?>
													<tr>

														<td>{{$emp->name}} (Code : {{$valdu->employee_id}})</td>
														<td>{{date('l',strtotime($valdu->date))}}</td>
														<td> {{date('h:i A',strtotime($pasdutynews[0]->in_time))}}          </td>
														<td> {{date('h:i A',strtotime($pasdutynews[($count-1)]->out_time))}}   </td>
														<td>@if(!empty($duty_reracs) && !empty($passnew)) {{$passnew->hours}}   @endif </td>
														<td>{{  number_format(floor($totltime*100)/100,1, '.', '')}}</td>
													</tr>

													<?php }} else {?>
													No data found
													<?php }?>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif


				</div>


			</div>
		</div>

		@include('admin.include.footer')

	</div>

		<!-- Custom template | don't include it in your project! -->

		<!-- End Custom template -->
<!-- </div> -->
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


	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>


	<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('assets/js/plugin/jqvmap/jquery.vmap.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')}}"></script>

	<!-- Sweet Alert -->
	<!-- <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script> -->

	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo.js')}}"></script>
	<script src="{{ asset('assets/js/demo.js')}}"></script>
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>

	@if($userType=='admin')
		<script>

				Circles.create({
					id:'circles-1',
					radius:45,
					value: {{ count($or_active)}},
					maxValue:100,
					width:7,
					text: {{ count($or_active)}},
					colors:['#f1f1f1', '#2BB930'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-2',
					radius:45,
					value:{{ count($or_verify)}},
					maxValue:100,
					width:7,
					text: {{ count($or_verify)}},
					colors:['#f1f1f1', '#FF9E27'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-2ua',
					radius:45,
					value:{{ count($or_notassigned)}},
					maxValue:100,
					width:7,
					text: {{ count($or_notassigned)}},
					colors:['#f1f1f1', '#FF9E27'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-2a',
					radius:45,
					value:{{ count($or_assigned)}},
					maxValue:100,
					width:7,
					text: {{ count($or_assigned)}},
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
					value: {{ count($or_noverify)}},
					maxValue:100,
					width:7,
					text: {{ count($or_noverify)}},
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
					value:{{ count($or_lince)}},
					maxValue:100,
					width:7,
					text: {{ count($or_lince)}},
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
					value: {{ count($or_notlince)}},
					maxValue:100,
					width:7,
					text: {{ count($or_notlince)}},
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
					value: {{ count($or_lince_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($or_lince_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7',
					radius:45,
					value: {{ count($or_lince_external)}},
					maxValue:100,
					width:7,
					text: {{ count($or_lince_external)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_1stinv',
					radius:45,
					value: {{ count($unbill_first_inv_org)}},
					maxValue:100,
					width:7,
					text: {{ count($unbill_first_inv_org)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_1stinvbilled',
					radius:45,
					value: {{ count($bill_first_inv_org)}},
					maxValue:100,
					width:7,
					text: {{ count($bill_first_inv_org)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_unsignedhr',
					radius:45,
					value: {{ count($unassigned_hr_org)}},
					maxValue:100,
					width:7,
					text: {{ count($unassigned_hr_org)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_assignedhr',
					radius:45,
					value: {{ count($assigned_hr_org)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_hr_org)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_hrwip',
					radius:45,
					value: {{count($wip_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{count($wip_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_hrcomplete',
					radius:45,
					value: {{count($complete_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{count($complete_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_lcgranted',
					radius:45,
					value: {{count($license_granted_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{count($license_granted_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_lcrefused',
					radius:45,
					value: {{count($license_refused_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{count($license_refused_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_lcrejected',
					radius:45,
					value: {{count($license_rejected_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{count($license_rejected_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_lcpd',
					radius:45,
					value: {{count($license_pd_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{count($license_pd_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_2ndUnbilledInv',
					radius:45,
					value: {{count($second_unbilled_invoice_license)}},
					maxValue:100,
					width:7,
					text: {{count($second_unbilled_invoice_license)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-7_2ndbilledInv',
					radius:45,
					value: {{count($second_billed_invoice_license)}},
					maxValue:100,
					width:7,
					text: {{count($second_billed_invoice_license)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-recassign',
					radius:45,
					value: {{count($recruitementfile_assigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($recruitementfile_assigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-recreq',
					radius:45,
					value: {{count($recruitementfile_request_rs)}},
					maxValue:100,
					width:7,
					text: {{count($recruitementfile_request_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-recon',
					radius:45,
					value: {{count($recruitementfile_ongoing_rs)}},
					maxValue:100,
					width:7,
					text: {{count($recruitementfile_ongoing_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-rechired',
					radius:45,
					value: {{count($recruitementfile_hired_rs)}},
					maxValue:100,
					width:7,
					text: {{count($recruitementfile_hired_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-recubill',
					radius:45,
					value: {{count($recruitementfile_unbilled_rs)}},
					maxValue:100,
					width:7,
					text: {{count($recruitementfile_unbilled_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-recbill',
					radius:45,
					value: {{count($recruitementfile_billed_rs)}},
					maxValue:100,
					width:7,
					text: {{count($recruitementfile_billed_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-cosunassign',
					radius:45,
					value: {{count($cos_unassigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_unassigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-cosassign',
					radius:45,
					value: {{count($cos_assigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_assigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-cospending',
					radius:45,
					value: {{count($cos_pending_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_pending_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-cosgranted',
					radius:45,
					value: {{count($cos_granted_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_granted_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-cosrejected',
					radius:45,
					value: {{count($cos_rejected_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_rejected_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-cosassigned',
					radius:45,
					value: {{count($cos_granted_assigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_granted_assigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-cosunassigned',
					radius:45,
					value: {{count($cos_granted_unassigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cos_granted_unassigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circles-visaunassign',
					radius:45,
					value: {{count($visafile_unassigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($visafile_unassigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visapending',
					radius:45,
					value: {{count($visafile_pending_rs)}},
					maxValue:100,
					width:7,
					text: {{count($visafile_pending_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visasubmitted',
					radius:45,
					value: {{count($visafile_submitted_rs)}},
					maxValue:100,
					width:7,
					text: {{count($visafile_submitted_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visaassign',
					radius:45,
					value: {{count($visafile_assigned_rs)}},
					maxValue:100,
					width:7,
					text: {{count($visafile_assigned_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visagranted',
					radius:45,
					value: {{count($visafile_granted_rs)}},
					maxValue:100,
					width:7,
					text: {{count($visafile_granted_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visarejected',
					radius:45,
					value: {{count($visafile_rejected_rs)}},
					maxValue:100,
					width:7,
					text: {{count($visafile_rejected_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visaunbilled',
					radius:45,
					value: {{count($cosfile_unbilled_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cosfile_unbilled_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circles-visabilled',
					radius:45,
					value: {{count($cosfile_billed_rs)}},
					maxValue:100,
					width:7,
					text: {{count($cosfile_billed_rs)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				/*
				Circles.create({
					id:'circlesApp-1',
					radius:45,
					value: {{ count($or_lince_internal)-count($assigned_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($or_lince_internal)-count($assigned_internal)}},
					colors:['#f1f1f1', '#2BB930'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesApp-2',
					radius:45,
					value:{{ count($or_lince_external)-count($assigned_external)}},
					maxValue:100,
					width:7,
					text: {{ count($or_lince_external)-count($assigned_external)}},
					colors:['#f1f1f1', '#FF9E27'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesApp-3',
					radius:45,
					value: {{ count($assigned_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_internal)}},
					colors:['#f1f1f1', '#F25961'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesApp-4',
					radius:45,
					value:{{ count($assigned_external)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_external)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesApp-5',
					radius:45,
					value: {{ count($assigned_wip)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_wip)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesApp-6',
					radius:45,
					value: {{ count($complete_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($complete_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesApp-7',
					radius:45,
					value: {{ count($complete_external)}},
					maxValue:100,
					width:7,
					text: {{ count($complete_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesHr-1',
					radius:45,
					value: {{ count($assigned_hrfile)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_hrfile)}},
					colors:['#f1f1f1', '#2BB930'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesHr-2',
					radius:45,
					value:{{ count($assigned_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_hrfile_internal)}},
					colors:['#f1f1f1', '#FF9E27'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesHr-3',
					radius:45,
					value: {{ count($assigned_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($assigned_hrfile_external)}},
					colors:['#f1f1f1', '#F25961'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-4',
					radius:45,
					value:{{ count($wip_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($wip_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-5',
					radius:45,
					value: {{ count($wip_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($wip_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-6',
					radius:45,
					value:{{ count($complete_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($complete_hrfile_internal)}},
					colors:['#f1f1f1', '#037ae0'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-7',
					radius:45,
					value: {{ count($complete_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($complete_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-8',
					radius:45,
					value: {{ count($license_granted_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($license_granted_hrfile_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-9',
					radius:45,
					value: {{ count($license_granted_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($license_granted_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-10',
					radius:45,
					value: {{ count($license_complete_granted_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($license_complete_granted_hrfile_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-11',
					radius:45,
					value: {{ count($license_complete_granted_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($license_complete_granted_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})

				Circles.create({
					id:'circlesHr-12',
					radius:45,
					value: {{ count($needaction_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($needaction_hrfile_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-13',
					radius:45,
					value: {{ count($needaction_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($needaction_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-14',
					radius:45,
					value: {{ count($license_rejected_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($license_rejected_hrfile_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-15',
					radius:45,
					value: {{ count($license_rejected_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($license_rejected_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-16',
					radius:45,
					value: {{ count($license_refused_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($license_refused_hrfile_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-17',
					radius:45,
					value: {{ count($license_refused_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($license_refused_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-18',
					radius:45,
					value: {{ count($homeoffice_visit_hrfile_internal)}},
					maxValue:100,
					width:7,
					text: {{ count($homeoffice_visit_hrfile_internal)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				Circles.create({
					id:'circlesHr-19',
					radius:45,
					value: {{ count($homeoffice_visit_hrfile_external)}},
					maxValue:100,
					width:7,
					text: {{ count($homeoffice_visit_hrfile_external)}},
					colors:['#f1f1f1', '#c809ea'],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
			*/

			<?php
				$totasum = 0;
				$itemval_quan = array();
				for ($i = 1; $i < 13; $i++) {

					if ($i < 10) {
						$i = '0' . $i;
					}
					$start_date = date('Y') . '-' . $i . '-01';
					$end_date = date('Y') . '-' . $i . '-31';
					$bill_rs = DB::Table('billing')
						->where('status', '!=', 'cancel')
						->whereBetween('date', [$start_date, $end_date])
						->orderBy('id', 'desc')

						->get();

					$sum = 0;
					foreach ($bill_rs as $val) {
						$sum = $sum + $val->amount;
					}
					$itemval_quan[] = floatval($sum);

					$totasum = $totasum + $sum;
				}

				$strcanrefmongg = implode(",", $itemval_quan);

			?>
			var myLineChart = new Chart(lineChart, {
					type: 'line',
					data: {
						labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
						datasets: [{
							label: "<?php echo 'Invoice Genarated value ' . $totasum . ' for ' . date('Y'); ?> ",
							borderColor: "green",
							pointBorderColor: "#FFF",
							pointBackgroundColor: "green",
							pointBorderWidth: 2,
							pointHoverRadius: 4,
							pointHoverBorderWidth: 1,
							pointRadius: 4,
							backgroundColor: 'transparent',
							fill: true,
							borderWidth: 2,
							data: [<?=$strcanrefmongg;?>]
						}]
					},
					options : {
						responsive: true,
						maintainAspectRatio: false,
						legend: {
							position: 'bottom',
							labels : {
								padding: 10,
								fontColor: 'green',
							}
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



			<?php
				$bill_notrs = DB::Table('billing')

					->where('status', 'not paid')
					->orderBy('id', 'desc')

					->get();
				$bill_notrs = DB::Table('billing')

					->where('status', 'not paid')
					->orderBy('id', 'desc')

					->get();
				$bill_paidrs = DB::Table('billing')

					->where('status', 'paid')
					->orderBy('id', 'desc')

					->get();
				$bill_partpaidrs = DB::Table('billing')

					->where('status', 'partially paid')
					->orderBy('id', 'desc')

					->get();

			?>

				var myPieChart = new Chart(pieChart, {
					type: 'pie',
					data: {
						datasets: [{
							data: [<?=count($bill_paidrs);?>, <?=count($bill_notrs);?>,  <?=count($bill_partpaidrs);?>],
							backgroundColor :["green","#f3545d","#fdaf4b"],
							borderWidth: 0
						}],
						labels: ['Paid', 'Unpaid', 'Partially Paid']
					},
					options : {
						responsive: true,
						maintainAspectRatio: false,
						legend: {
							position : 'bottom',
							labels : {
								fontColor: '#000',
								fontSize: 14,
								usePointStyle : true,
								padding: 20
							}
						},
						pieceLabel: {
							render: 'percentage',
							fontColor: 'white',
							fontSize: 10.5,
						},
						tooltips: false,
						layout: {
							padding: {
								left: 0,
								right: 0,
								top: 0,
								bottom: 0
							}
						}
					}
				});

		</script>
	@endif

	<script>
		function copyToClipboard() {
		var urlText = document.getElementById('registrationUrl').innerText;
		var tempInput = document.getElementById('tempInput');
		tempInput.value = urlText;
		tempInput.select();
		tempInput.setSelectionRange(0, 99999); // For mobile devices
		document.execCommand('copy');
		var copyButton = document.getElementById('copyButton');
		copyButton.classList.remove('text-warning');
		copyButton.classList.add('text-dark');
		}

	</script>


</body>
</html>