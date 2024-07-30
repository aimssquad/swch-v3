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

 <!-- Sweet Alert -->
 <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

 <!-- Atlantis JS -->
 <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>

 <!-- Atlantis DEMO methods, don't include it in your project! -->
 <script src="{{ asset('assets/js/setting-demo.js')}}"></script>
 <script src="{{ asset('assets/js/demo.js')}}"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
 <script type="text/javascript">
     var base_url = '{!! url("/") !!}';

     $(document).ready(function() {
         $('#bootstrap-data-table-export').DataTable();
     });
 </script>