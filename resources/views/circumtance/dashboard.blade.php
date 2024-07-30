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
         .col-10.col-xs-11.col-sm-4.alert.alert-info{display:none !important;}
         .dash-inr {margin: -45px 15px;}
         .alert.alert-info{display:none !important}
         .dash-box{padding: 15px 30px;border-radius: 7px;    margin-bottom: 26px;}
         .grn {background: #30a24b;}.red{background:#f3425f}.blue{background:#763ee7}.sky{background:#1878f3}.orange{background:orange}
         .dash-box img{width:50px}
         .dash-cont h4{color:#fff;padding-top:15px;font-size:13px;}
         .numb h5{color: #fff;font-size: 28px;}.view-more a img{width: 22px;padding-top: 19px;}.numb{text-align: right;}.view-more{text-align: right;}.dash-cont {
         min-height: 61px;
         }
         .bg-primary-gradient {
         background: #1572e8!important;
         background: -webkit-linear-gradient(90deg, rgba(0,70,96,1) 0%, rgba(54,150,136,1) 42%, rgba(0,212,255,1) 100%)!important;
         background: linear-gradient(90deg, rgba(0,70,96,1) 0%, rgba(54,150,136,1) 42%, rgba(0,212,255,1) 100%);
         }
      </style>
   </head>
   <body>
      <div class="wrapper">
         @include('circumtance.include.header-dashboard')
         <!-- Sidebar -->
         @include('circumtance.include.sidebar')
         <!-- End Sidebar -->

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

   </body>
</html>
