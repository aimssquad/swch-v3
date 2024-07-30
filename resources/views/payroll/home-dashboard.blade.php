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
		body {
			background: #e0e0e0;
			font-family: 'Lato', sans-serif;
		}

		p {
			font-family: 'Lato', sans-serif;
		}

		.main-body {
			padding: 2% 11px;
		}

		.pis-hd h2 span {
			font-size: 12px;
		}

		.pis-hd {
			background: #034f88;
			width: 268px;
			padding: 15px 12px;
			color: #fff;
			border: 2px solid #fff;
			margin-right: 1px;
		}
		footer {
    background: #225c8e;
    color: #fff;
    text-align: center;
    padding: 5px;
    position: absolute;
    bottom:0;
    width:100%;
}

footer p{color:#fff;margin-bottom:0;}
.rice-logo {
			margin-top: 75px;
		}
		.hcm-head h1 span {
    font-size: 38px;
    font-weight: 600;
    color: #0e3d69;
}

.hcm-head h1 {
    font-size: 21px;
    color: #0e3d69;
}
		.rice-logo img {
			max-width: 240px;
			-ms-transform: rotate(20deg);
			-webkit-transform: rotate(20deg);
			transform: rotate(-90deg);
		}

		.pay-icon {
			background: #CE4C58;
			padding: 24px 0;
			border: 2px solid #fff;
		}

		.pay-icon img {
			width: 75px;
			height: auto;
		}

		.pay-cont.green a {
			background: #2c80e3;
			/* color: #999; */
		}

		.pay-cont {
			background: #fff;
			padding: 16.2px 10px;
			;
		}

		.pay-cont h3 {
			font-size: 19px;
			font-weight: 600;
			margin-bottom: 10%;
		}

		.pay-cont a {
			background: #ce4c58;
			color: #fff;
			padding: 9px 36px;
			border-radius: 50px;
		}

		.pay-icon.red {
			padding: 21px 0;
		}
		.header {
    background: #f4f4f4;
    padding: 10px;
    box-shadow: 2px -1px 5px 2px #999;
}
		.pay-icon.blue.lv-ap {
			background: #0a98da;
			padding: 21px 0;
		}

		.pay-icon.pink {
			background: #b928a6;
			padding: 21px 0;
		}

		.boxOuter {
			float: left !important;
			margin: 0px 2px 0 0;
			padding: 0px;
			width: 30% !important;
			margin-bottom: 3px;
		}

		.boxOuter .col-lg-3 {
			width: 100%;
			max-width: 100%;
			padding: 0px;
			margin: 0px;
		}

		.pay-cont.yellow a {
			background: #f1b632;
		}

		.boxOuter2 {
			float: left !important;
			margin: 0px 2px 0px 0px;
			padding: 0px;
			width: 44% !important;
		}

		.boxOuter2 .col-lg-6 {
			width: 100%;
			max-width: 100%;
			padding: 0px;
			margin: 0px;
		}

		.boxOuter2 .pay-icon {
			width: 50%;
			float: left;
			background: #7E3C94;
			text-align: center;
			min-height: 217px;
		}

		.boxOuter2 .pay-icon img {
			width: 75px;
			height: auto;
			text-align: center;
			display: block;
			margin: 0px auto;
		}

		.boxOuter2 .pay-cont {
			width: 50%;
			float: left;
			background: #ffffff;
			text-align: center;
			min-height: 217px;
		}

		.boxOuter2 .pay-cont h3 {
			font-size: 19px;
			font-weight: 600;
			margin-bottom: 20%;
			padding: 40px 10px 0px;
		}

		.boxOuter2 .pay-cont a {
			background: #7e3c94;
			color: #fff;
			padding: 9px 36px;
			border-radius: 50px;
		}

		.boxOuter2 .pay-cont.green a {
			background: #648304;
		}


		.boxOuter3 {
			float: left !important;
			margin: 0px 0px 0px 0px;
			padding: 0px;
			width: 24% !important;
		}

		.boxOuter3 .col-lg-3 {
			width: 100%;
			max-width: 100%;
			padding: 0px;
			margin: 0px;
		}

		.boxOuter2 .pay-icon.green {
			background: #2c80e3;
			min-height: 216px;
		}

		.boxOuter3 .pay-icon {
			width: 100%;
			float: left;
			background: #0FA5C8;
			text-align: center;
			min-height: 100px;
		}

		.boxOuter3 .pay-icon img {
			width: auto;
			height: 50px;
			text-align: center;
			display: block;
			margin: 0px auto;
		}

		.boxOuter3 .pay-cont {
			width: 100%;
			float: left;
			background: #ffffff;
			text-align: center;
			min-height: 103px;
			padding: 0px;
			margin: 0px;
		}

		.boxOuter3 .pay-cont h3 {
			font-size: 19px;
			font-weight: 600;
			margin-bottom: 10%;
			padding: 15px 10px 0px;
		}

		.boxOuter3 .pay-cont a {
			background: #0FA5C8;
			color: #fff;
			padding: 9px 36px;
			border-radius: 50px;
		}

		.pay-cont.pink a {
			background: #b928a6;
		}

		.pay-icon.green {
			background: #27a527;
			padding: 20.5px 0;
		}

		.user-name {
			text-align: right;    margin-top: 30px;
		}

		.user-name h4 {
			color: #7e3c94;
			FONT-SIZE: 18px;
			margin-top: 15px;
		}

		.user-name h4 span i {
			color: #7e3c94;
		}

		.pay-icon.yellow {
			background: #f1b632;
			padding: 24px 0;
		}

		.pay-cont.blue a {
			background: #0a98da;
		}

		.pay-icon.yellow.lv-ap img {
			width: 60px;
		}

		.pay-cont.ylw a {
			background: #f1b632;
		}

		.pay-icon.pink.pnk-holi img {
			width: 73px;
		}
		.inner-dashboard{background:#fff;}
		.hcm-head h1 {
    font-size: 21px;
    color: #0e3d69;
    padding: 15px 25px;
}
.inner-dashboard{border-radius:7px;}
.hcm-head {
    border-bottom: 1px solid #ddd;
}
/* .hcm-inner {
    padding: 15px 25px;
}	 */

.hcm-icon {
    background: #f1b732;
    padding: 26px 3px;
    text-align: center;height: 129px;;
}
.hcm-icon.green{background:#2c80e3;}
.hcm-icon.vio{background:#b928a7;}
.hcm-icon.sky{background:#0a98da;}
.hcm-icon.red{background:#ce4c58;}
.hcm-name {
    background: #d3d3d3;
    text-align: center;
    height: 129px;
    padding: 37px 19px;
}
.hcm-name.green a img{background:#2c80e3;}
.hcm-name.vio a img{background:#b928a7;}
.hcm-name.sky a img{background:#0a98da;}
.hcm-name.red a img{background:#ce4c58;}
.hcm-name p{color: #000;
    margin-bottom: 0;
    font-size: 18px;}
.hcm-icon img {
    max-width: 70px;

}
.hcm-name a img {
    background: #f1b732;
    width: 30px;
    height: 30px;
    /* width: 20px; */
    border-radius: 50%;
    margin-top: 9px;padding:4px;
}
.pl0{padding-left:0;}.pr0{padding-right:0;}
.hcm{margin-bottom:30px;width: 410px;margin: 40px 30px;}
.payroll-main {
    padding: 15px 25px 1px;
    margin-bottom: 0;
}
.main-panel-fixed {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 100%;
    float: right;
    transition: all 0.3s;
    margin-top: 63px;
}
	</style>
</head>
<body>
<div class="wrapper">

@include('payroll.include.header')
<!-- Sidebar -->
 {{-- @include('attendance.include.sidebar') --}}
<!-- End Sidebar -->

{{-- main content start  --}}
<div class="main-panel-fixed">
    <div class="main-body">
       <div class="container-fluid">
          <div class="inner-dashboard">
             <div class="hcm-head">
                <h1><span>PM</span> Payroll Management</h1>
             </div>
             <div class="text-center col-lg-12" style="padding:0;">
                <div class="payroll-main">
                   <div class="row">
                      <div class="col-md-4">
                         <div class="hcm" style="margin: 40px 30px 40px 0;">
                            <div class="row">
                               <div class="col-md-4 col-4 pr0">
                                  <div class="hcm-icon green">
                                     <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                  </div>
                               </div>
                               <div class="col-md-8 col-8 pl0">
                                  <div class="hcm-name green">
                                     <p>Payroll</p>
                                     <a href="{{ url('payroll/dashboard') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-md-4">
                         <div class="hcm" style="margin: 40px 30px 40px 0;">
                            <div class="row">
                               <div class="col-md-4 col-4 pr0">
                                  <div class="hcm-icon green">
                                     <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                  </div>
                               </div>
                               <div class="col-md-8 col-8 pl0">
                                  <div class="hcm-name green">
                                     <p>Loans</p>
                                     <a href="{{ url('loans/view-loans') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="col-md-4">
                         <div class="hcm" style="margin: 40px 30px 40px 0;">
                            <div class="row">
                               <div class="col-md-4 col-4 pr0">
                                  <div class="hcm-icon green">
                                     <img class="" src="{{ asset('theme/images/leave-application-icon.png') }}" alt=""style="max-width:120px;">
                                  </div>
                               </div>
                               <div class="col-md-8 col-8 pl0">
                                  <div class="hcm-name green">
                                     <p>Income Tax</p>
                                     <a href="{{ url('itax/dashboard') }}"><img class="" src="{{ asset('theme/images/arrow.png') }}" alt=""></a>
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
</div>

{{-- main content end --}}



@include('attendance.include.footer')
</div>
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
<script src="{{ asset('assets/js/jquery.base64.min.js')}}"></script>
<script >
   $(document).ready(function() {
   	$('#basic-datatables').DataTable({
   	});
   
   	$('#multi-filter-select').DataTable( {
   		"pageLength": 5,
   		initComplete: function () {
   			this.api().columns().every( function () {
   				var column = this;
   				var select = $('<select class="form-control"><option value=""></option></select>')
   				.appendTo( $(column.footer()).empty() )
   				.on( 'change', function () {
   					var val = $.fn.dataTable.util.escapeRegex(
   						$(this).val()
   						);
   
   					column
   					.search( val ? '^'+val+'$' : '', true, false )
   					.draw();
   				} );
   
   				column.data().unique().sort().each( function ( d, j ) {
   					select.append( '<option value="'+d+'">'+d+'</option>' )
   				} );
   			} );
   		}
   	});
   
   	// Add Row
   	$('#add-row').DataTable({
   		"pageLength": 5,
   	});
   
   	var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
   
   	$('#addRowButton').click(function() {
   		$('#add-row').dataTable().fnAddData([
   			$("#addName").val(),
   			$("#addPosition").val(),
   			$("#addOffice").val(),
   			action
   			]);
   		$('#addRowModal').modal('hide');
   
   	});
   });  
</script>
</body>
</html>