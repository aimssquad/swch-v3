<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
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
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
</head>
<body>
	<div class="wrapper">
		
 		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					
				<div class="row">
						<div class="col-md-12">
							<div class="card">
							 @if(Session::has('error'))										
								<div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-cross" ></span><em > {{ Session::get('error') }}</em></div>
							@endif	
									 @if(Session::has('message'))										
								<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
							@endif	
								<div class="card-body">
									 <form action="#" method="post" enctype="multipart/form-data">
							<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
									
								
										<div class="row form-group">
								            <div class="col-md-6">
								            	<div class="pay-slip-heading">
								            		<h4 class="card-title">Change Password</h4>
												
								            	</div>
								            </div>
								          
								           </div> 
								         
 

										  <div class="row form-group">
                                         

										  
										

								     	<div class="col-md-4">
								     	    <div class=" form-group form-floating-label">
    

								     		  <input  type="text"  name="old" class="form-control input-border-bottom"  id="old" required=""   placeholder="" style="margin-top: 25px;">
											    
										 	<label for="old" class="placeholder">Old Password</label>
								     	
								     		</div>	
								     	</div>
									     	<div class="col-md-4">
    	
  <div class=" form-group form-floating-label">
								     		  <input  type="text"  name="new_p" class="form-control input-border-bottom"  id="new_p" required=""   placeholder="" style="margin-top: 25px;">
											    
										 <label for="new_p" class="placeholder">New Password</label>
								     	
								     		</div>		
								     	</div>

								     		<div class="col-md-4">
								     		    <div class=" form-group form-floating-label">
    	

								     		  <input  type="text"  name="con" class="form-control input-border-bottom"  id="con" required=""   placeholder="" style="margin-top: 25px;">
											    
									<label for="con" class="placeholder">Re-enter Cormfirm Password</label>	 
								     	
								     	</div>		
								     	</div> 
								    </div> 	
								   

								     <div class="row form-group">	
                                       	<div class="col-md-6">
										    	<a class="apply" href="#">	
										        <button class="btn btn-default apply" type="submit">Submit</button>
										       </a>
										       <a class="apply" href="#">	
										        <button class="btn btn-default apply" type="reset">Reset</button>
										       </a> 
										</div>
									
								     </div> 	



									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
				 @include('admin.include.footer')
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
		
		
		function getLeaveInHand(leavetype_id)
		{	
			
			$.ajax({
				type:'GET',
				url:'{{url('leave/get-leave-in-hand')}}/'+leavetype_id,				
				success: function(response){
				console.log(response); 
    				if(response==0){

                          $('#leave_inhand').val(null);
                        $("#from_date").attr('readonly', true);
                        $("#to_date").attr('readonly', true);

                    }else{

                        $("#leave_inhand").val(response);
                        $("#from_date").attr('readonly', false);
                        $("#to_date").attr('readonly', false);
                        $('#days').val('');
                        $("#from_date").val('');
                        $("#to_date").val('');
                    }
				}
			});

            
            /*if(($("#leave_inhand").val()) == '0')
            { 
                alert('hi');
                $('#days').attr('readonly', true);
                $("#from_date").attr('readonly', true);
                $("#to_date").attr('readonly', true);
            }*/
		}
		     
function get_duration()
{
    var from_date= $("#from_date").val();
    var to_date= $("#to_date").val();
    var leave_type = $("#leave_type option:selected").val();
    var lvinhand = $('#leave_inhand').val();
    var cl_type = 'full';

var date1 = new Date(from_date);
var date2 = new Date(to_date);
var diffTime = Math.abs(date2 - date1);
var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 


if(diffDays=='0'){

$('#days').val('1');
}else{
var diffDays=Math.abs(diffDays +1);
$('#days').val(diffDays);
}
   
        
}   

	</script>
</body>
</html>