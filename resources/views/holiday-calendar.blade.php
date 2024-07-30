<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assetsemcor/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.css' rel='stylesheet' />
 
	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
	<style>
	#calendar {
      max-width: 100%;
    margin: 40px 10px;
    background: #fff;
    padding: 15px;
}
.fc-theme-standard th {
    border: 1px solid #ddd;
    border: 1px solid #ccc8c8;
    background: #00bfff;
    color: #ffff;
}
.alert [data-notify=title]{display:none !important;}
.alert [data-notify=message], .alert [data-notify=icon]{display:none !important;}
	</style>
</head>
<body>
	<div class="wrapper">
		
  @include('employee-corner.include.header')
		<!-- Sidebar -->
		
		  @include('employee-corner.include.sidebar')
		  <?php print_r($holidays); ?>
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
			<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Holiday Calender</h2>
								
							</div>


							<div class="ml-md-auto py-2 py-md-0">
								
							</div>
						</div>
					</div>
				</div>
                  <div id='calendar'></div>
			</div>
				 @include('employee-corner.include.footer')
		</div>
		
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
	<!-- Datatables -->
	<script src="{{ asset('assetsemcor/js/plugin/datatables/datatables.min.js')}}"></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assetsemcor/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('assetsemcor/js/setting-demo2.js')}}"></script>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.0/main.min.js'></script>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    initialDate: '2020-09-12',
    eventColor: 'green',
    events: [
	<?php $k=1;
	 $couh=count($holidays);
	?>
	@foreach($holidays as $holiday)
				{
					title: '{{ $holiday->holiday_descripion }}',
					start: '{{ $holiday->from_date }}',
					end: '{{ $holiday->to_date }}',
					
					color: 'purple',
				}
				
				<?php 
				
	 if($couh!=$k && $couh>$k ){
		echo ',' ;
		
	 }
	 $k ++;
	?>
				@endforeach
     
    ]
  });

  calendar.render();
});
	</script>
	
</body>
</html>