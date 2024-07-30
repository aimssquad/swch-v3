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
	<style>
body {background: #f2f3f3;}

.main-panel .collapse {
    /*border-top: 1px solid #ececec;*/
}
.card h6{font-size: 16px;}
.arrow i{color: #fff;
    background: #136cdd;
    width: 30px;
    height: 30px;
    padding: 8px 7px;
    border-radius: 50%;
    font-size: 17px;}
.bg-primary-gradient {
    background: #1572e8!important;
    background: -webkit-linear-gradient(legacy-direction(-45deg),#06418e,#1572e8)!important;
    background: linear-gradient(
-45deg
 ,#06418e,#1572e8)!important;
}
.go{    background: #1572e8;
    width: 30px;
    border-radius: 50%;
    padding: 5px;
    margin-top: 15px; margin-bottom: 16px;}
.card{border-top: none;}
.alert [data-notify=title]{display:none !important;}
.alert [data-notify=message]{display:none !important}
.alert [data-notify=icon]{display:none !important}
.main-dash {margin: 30px;}.org-dasicon {background: #00efa2;color: #fff;width: 100%;height: 100%;padding: 32px 21px;}
.org-dasicon i{font-size: 25px;color:#fff;}
.pl0{padding-left: 0 !important} .pr0{padding-right:0 !important;}.mb0{margin-bottom: 0}.mt0{margin-top: 0;}
.org-dashcont {
    background: #fff;
    padding: 9px 20px 3px;
        min-height: 92px;
}
.main-dash h3 span{text-align: right;
    float: right;
    background: #08c286;
    color: #fff;
    padding: 2px 10px;
   }
ul{padding-left: 0;list-style: none;}.main-dash ul li{margin-bottom: 20px;}
.org-dasicon.orange{background: #f39c12;}.org-dasicon.red{background: #c00000;}
.org-dashcont p a {
    color: #343a40;
    text-decoration: none;
}
.accordion .card .card-body {
    border-top: 1px solid #ebebeb;
    padding: 20px;
}
.card{margin-bottom: 5px;}
.card .card-header, .card-light .card-header {
    padding: 0.5rem 0.25rem;border-bottom: none !important;}
.footer{position:relative;}
.card h5 {
    padding: 0;
    font-size: 20px;text-align: left;color: #1572e8;;}
   button.btn.btn-link:hover {
    text-decoration: none !important;
}
.card-header {
    text-align: left !important;
    text-decoration: none;
}
.card-header a:hover, .card-header a, .card-header a:focus{text-decoration:none;}
.btn-link{background: #dfdfdf  !important;}
.btn-link:focus, .btn-link:hover {
    text-decoration: none !important;
    background: #dfdfdf  !important;
    border: 0 !important;
}
.card-header i.fa.fa-plus {
    background: green;
    width: 23px;
    height: 23px;
    color: #fff;
    border-radius: 50%;
    padding: 5px;
    margin-right: 15px;
}
.card-header i.fa.fa-minus{
	background: red;
    width: 23px;
    height: 23px;
    color: #fff;
    border-radius: 50%;
    padding: 5px;
    margin-right: 15px;
}
/*.card-header{background: #e8e7e7;}*/
</style>

</head>
<body>
	<div class="wrapper">


		  <div class="main-panel">
			<div class="content">



<div class="main-dash">
	<div class="container">
		<div class="row">
		<div class="col-md-12">
			<h3 style="color: #fff;
    background: #878686;
    text-align: center;
    margin-bottom: 0;
    padding: 5px 5px 8px;" class="text fw-bold">Leave Status</h3>
		</div>
		<div class="col-md-12">
				<div class="accordion" id="accordionExample">
<?php $j = 1;?>
			@if(count($LeaveAllocation))

				@foreach($LeaveAllocation as $Leave)


		<div class="card">
		<a class="btn btn-link @if($j!='1') collapsed @endif" data-toggle="collapse" data-target="#collapse<?=$j?>">
			<div class="card-header">
				<i class="fa fa-plus"></i> Leave type :  {{$Leave->leave_type_name}}


			</div>
</a>
			<div class="collapse @if($j=='1') show @endif" id="collapse<?=$j?>" data-parent="#accordionExample">
				<div class="card-body">

		<div class="table-responsive">
										<table class="table">

										<!-- <tr><td><b>	Total No Of Leave :</b></td> <td>{{ $Leave->leave_in_hand }}</td></tr> -->
										<tr><td><b>Leave In Hand :</b></td> <td>{{ $Leave->leave_in_hand }}</td></tr>
										<tr><td><b>Leave Taken :</b></td> <td>{{ $Leave->leave_taken }}</td></tr>

                                      </tr>
</table>
</div>
				</div>
			</div>
		</div>



		  	<?php $j++;?>
  @endforeach
			@endif

	</div>





		</div>





	</div>
</div>
		<!-- @include('admin.include.footer') -->
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
$(document).ready(function(){
  //Add a minus icon to the collapse element that is open by default
  	$('.collapse.show').each(function(){
		$(this).parent().find(".fa").removeClass("fa-plus").addClass("fa-minus");
    });

  //Toggle plus/minus icon on show/hide of collapse element
	$('.collapse').on('shown.bs.collapse', function(){
		$(this).parent().find(".fa").removeClass("fa-plus").addClass("fa-minus");
	}).on('hidden.bs.collapse', function(){
		$(this).parent().find(".fa").removeClass("fa-minus").addClass("fa-plus");
	});
});
</script>
</body>
</html>