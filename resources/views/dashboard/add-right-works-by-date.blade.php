<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<script src="{{ asset('employeeassets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
		<link rel="stylesheet" href="{{ asset('employeeassets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('employeeassets/css/atlantis.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/calander.css')}}">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('employeeassets/css/demo.css')}}">
	<link rel="stylesheet" href="{{ asset('employeeassets/css/datepicker.css')}}">
<style>
table .form-control{height: 35px !important;}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('dashboard.include.header')
		<!-- Sidebar -->
		
		 
		  <?php 
   function my_simple_crypt( $string, $action = 'encrypt' ) {
    // you may change these values to your own
    $secret_key = 'bopt_saltlake_kolkata_secret_key';
    $secret_iv = 'bopt_saltlake_kolkata_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'encrypt' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}
?>
		<!-- End Sidebar -->
		<div class="main-panel" style="width:100%">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<!-- <h4 class="page-title">Right to Work checks</h4> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{ url('dashboard-right-works') }}">Right to Work checks List
</a>
							</li>
							
						</ul>
					</div>
				
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Right to Work Checklist (RTW)</h4>
								</div>
								<div class="card-body">
									<form name="basicform" id="basicform" method="post" action="{{ url('add-right-works-by-date') }}" >
									       <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
        
        <div id="sf1" class="frm">
          <fieldset>
            <!-- <legend>Your Details</legend> -->

            <div class="row form-group">
       <div class="col-md-6">
       	<label>Name of Person</label>
        <select class="form-control"  id="employee_id" name="employee_id" required  onchange="checkemp(this.value);">
          <option value="">Applicant /Employee Name</option>
        @foreach($employee_rs as $employee)
                     <option value="{{$employee->emp_code}}" >{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{$employee->emp_code}})</option>
                       @endforeach
        </select>
      </div>
      <div class="col-md-6">
      	<label>Date of Check</label>
        <input type="date" class="form-control" id="date" placeholder="" name="date" required>
      </div>
     
   
      
      <div class="col-md-4">
      	<label>Work start time</label><br>
     <input type="date" class="form-control" placeholder="" name="start_date" id="start_date" required>
      </div>
      
  </div>
      
            <div class="clearfix" style="height: 10px;clear: both;"></div>


            <div class="form-group" style="margin-top: 30px">
              <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-primary open1" type="submit">Next <span class="fa fa-arrow-right"></span></button> 
              </div>
            </div>

          </fieldset>
        </div>

 


        

          <!------------------------------->

  






      
	  

        
      </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			 @include('employee.include.footer')
		</div>
		
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('employeeassets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('employeeassets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('employeeassets/js/plugin/datatables/datatables.min.js')}}"></script>
	<<!-- Atlantis JS -->
	<script src="{{ asset('employeeassets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('employeeassets/js/setting-demo2.js')}}"></script>
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
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript">
jQuery().ready(function() {
  // validate form on keyup and submit
    var v = jQuery("#basicform").validate({
      rules: {
        
        email: {
          required: true,
          
          email: true,
          
        },
        phone: {
          required: true,
          
        },
        method: {
          required: true,
          
        },
 city: {
          required: true,
          
        },
         country: {
          required: true,
          
        },
         postcode: {
          required: true,
          
        },
ca1: {
          required: true,
          
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
    });

  // Binding next button on first step
  $(".open1").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf2").show("slow");
      }
    });

     $(".open2").click(function() {
     if (v.form()) {
     $(".frm").hide("fast");
    $("#sf3").show("slow");
     }
    });
      $(".open3").click(function() {
     if (v.form()) {
     $(".frm").hide("fast");
    $("#sf4").show("slow");
     }
    });
    
    $(".open4").click(function() {
    
    });
    
    $(".back2").click(function() {
      $(".frm").hide("fast");
      $("#sf1").show("slow");
    });

    $(".back3").click(function() {
      $(".frm").hide("fast");
      $("#sf2").show("slow");
    });

    $(".back4").click(function() {
      $(".frm").hide("fast");
      $("#sf3").show("slow");
    });

  });
  	function checkemp(val){
		var empid=val;
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeetaxempByIdnewemployee')}}/'+empid,
        cache: false,
		success: function(response){
		
			 var obj = jQuery.parseJSON(response);
				console.log(obj[0]);
			  var emp_code=obj[0].emp_code;
		 
				  $("#emp_id").val(emp_code);
				
				    $("#emp_id").attr("readonly", true);
			
					 
				     if(obj[0].emp_doj!='1970-01-01'){
				     $("#start_date").val(obj[0].emp_doj);
				      var input = document.getElementById("date");
    					//input.setAttribute("max", obj[0].emp_doj);
				     }
				     $("#start_date").attr("readonly", true);
				        if(obj[0].emp_doj!='1970-01-01'){
				     $("#start_date").val(obj[0].emp_doj);
				     } 
				
				        if(obj[0].visa_review_date!='1970-01-01'){
				     $("#list_rightb_date").val(obj[0].visa_review_date);
				     } 
				         
					  
			 
		}
		});
		 	$.ajax({
		type:'GET',
		url:'<?=env("BASE_URL");?>pis/getEmployeedreportfileById/'+empid,
        cache: false,
		success: function(response){
			
		
			document.getElementById("scan_f").innerHTML = response;
				document.getElementById("scan_s").innerHTML = response;
					document.getElementById("scan_r").innerHTML = response;
						document.getElementById("evidence").innerHTML = response;
		}
		});
	}
	
	
	function checkscsnf(val){
    
    var emp_id=$("#emp_id").val();
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
        cache: false,
		success: function(response){
		    var gg="<?=env("BASE_URL");?>public/"+response;
	
	  
        $("#imgeid").attr("src",gg);
		$("#scan_f_img").val(response);  	   
		}
		});
    
}
function checkscsns(val){
    
    var emp_id=$("#emp_id").val();
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
        cache: false,
		success: function(response){
		    var gg="<?=env("BASE_URL");?>public/"+response;
	
	  
        $("#imgeids").attr("src",gg);
			    $("#scan_s_img").val(response);  
		}
		});
    
}
function checkscsnr(val){
    
    var emp_id=$("#emp_id").val();
    	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
        cache: false,
		success: function(response){
		    var gg="<?=env("BASE_URL");?>public/"+response;
	
	  
        $("#imgeidsj").attr("src",gg);
          $("#scan_r_img").val(response);
        
			   
		}
		});
    
}
</script>
</body>
</html>