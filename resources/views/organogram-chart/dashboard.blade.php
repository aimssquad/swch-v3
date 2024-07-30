<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
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
	/*Now the CSS*/
* {margin: 0; padding: 0;}

.tree ul {
    padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree li a{
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
	display: inline-block;
	
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
	border-color:  #94a0b4;
}

/*Thats all. I hope you enjoyed it.
Thanks :)*/

.alert [data-notify=title], .alert [data-notify=icon], .alert [data-notify=message], .col-10.col-xs-11.col-sm-4.alert.alert-info{display:none !important}
.lev1, .lev1:hover{background: #1164cf !important;color: #fff !important;border: 1px solid #1164cf !important;}
.lev2, .lev2:hover{background: #04a704 !important;color: #fff !important;border: 1px solid #04a704 !important;}
.lev3, .lev3:hover{background: #d8028c !important;color: #fff !important;border: 1px solid #d8028c !important;}
.lev4, .lev4:hover{background: #f7a002 !important;color: #fff !important;border: 1px solid #f7a002 !important;}
.lev5, .lev5:hover{background: #07cc83 !important;color: #fff !important;border: 1px solid #07cc83 !important;}
.lev6, .lev6:hover{background: #deb900 !important;color: #fff !important;border: 1px solid #deb900 !important;}
.lev7, .lev7:hover{background: #9030f9 !important;color: #fff !important;border: 1px solid #9030f9 !important;}
	</style>
</head>
<body>
	<div class="wrapper">
		
  @include('organogram-chart.include.header-dashboard')
		<!-- Sidebar -->
		
		  @include('organogram-chart.include.sidebar')
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
							<h2 class="text-white pb-2 fw-bold">Organogram Chart</h2>								
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								
							</div>
						</div>
					</div>
				</div>				
			</div>
			<div>
				{{-- Check if employee_rs exists --}}
			<?php ?>
					@if(isset($employee_rs))
						<h3>Employee Details:</h3>
						<p>First Name: {{ $employee_rs->emp_fname }}</p>
						<p>Last Name: {{ $employee_rs->emp_lname }}</p>
						<!-- Add more fields as needed -->
					@else
						<p>No employee details available.</p>
					@endif

					{{-- Check if employee_rs_report exists --}}
					@if(isset($employee_rs_report))
						<h3>Reporting Authority Details:</h3>
						<p>First Name: {{ $employee_rs_report->emp_fname }}</p>
						<p>Last Name: {{ $employee_rs_report->emp_lname }}</p>
						<!-- Add more fields as needed -->
					@else
						<p>No reporting authority details available.</p>
					@endif

			</div>
			  @include('organogram-chart.include.footer')
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
	<!-- Datatables -->
	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assets/js/setting-demo2.js')}}"></script>

</body>
</html>