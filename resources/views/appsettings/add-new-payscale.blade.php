<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
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
	<style>.main-panel{margin-top:0;}</style>
</head>
<body>
	<div class="wrapper">

		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"> Annual Pay</h4>
								</div>
								<div class="card-body">
									  <?php if(isset($_GET['id'])){ 
								    ?>
									<form action="{{url('appsettings/annualpay?id='.$_GET['id'])}}" method="post" enctype="multipart/form-data">
									    <?php
								}else{
								    ?>
								     <form action="{{url('appsettings/annualpay')}}" method="post" enctype="multipart/form-data">
								    <?php
								}
								?>
			 {{csrf_field()}}
			 <input id="emid" type="hidden" class="form-control input-border-bottom" required="" name="emid"  value="{{$emid}}" >
									
									<div id="education_fields">
										<div class="row form-group">
										<div class="col-md-4">
										<div class="form-group form-floating-label">
												
													<select class="form-control input-border-bottom" id="inputFloatingLabel" required="" name="payscale_code">
													@foreach($paygroup_rs as $grade)
													<option value="{{ $grade->id}}"  <?php  if(app('request')->input('id')){ if($getPayscale[0]->payscale_code==$grade->id){ echo 'selected'; } } ?> >{{ $grade->grade_name}}</option>
                                     
                                                       @endforeach   
												</select>
												<label for="inputFloatingLabel" class="placeholder">Paygroup Code</label>
											</div>
																									  
										</div>
										@if (app('request')->input('id'))
											<?php   $tr_id=0;
$countpay= count($getPaybac)			;?>
@foreach($getPaybac as $gradebas)
										<div class="col-md-4">
										<div class="form-group form-floating-label">
												<input id="inputFloatingLabel<?php echo  $tr_id;?>" type="text" class="form-control input-border-bottom" required="" name="pay_scale_basic[]" value="{{ $gradebas->pay_scale_basic}}" >
												<label for="inputFloatingLabel<?php echo  $tr_id;?>" class="placeholder">Annual Pay</label>
											</div>
										
					</div>
					</br>
					<?php $tr_id++; ?>
					  @if ($tr_id==($countpay))
										<div class="col-md-4" style="margin-top:13px;">
										   <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
										   
										</div>
										 @endif
										@endforeach   
										@endif
										@if (empty(app('request')->input('id')))
															<div class="col-md-4">
										<div class="form-group form-floating-label">
												<input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="pay_scale_basic[]" >
												<label for="inputFloatingLabel1" class="placeholder">Annual Pay</label>
											</div>
										
					</div>
					
										<div class="col-md-4" style="margin-top:13px;">
										   <button class="btn btn-success" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button>
										   
										</div>
										
										
										
																				@endif
																				
										</div>
									</div>
									<div class="row form-group">
									<div class="col-md-2"><button type="submit" class="btn btn-default">Submit</button></div>	
									</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>

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
<script>
var room = 1;
function education_fields() {
 
    room++;
    var objTo = document.getElementById('education_fields')
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+room);
	var rdiv = 'removeclass'+room;
    divtest.innerHTML = '<div class="row"><div class="col-md-4"><div class="form-group form-floating-label"><input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required=""  name="pay_scale_basic[]" ><label for="inputFloatingLabel1" class="placeholder">Annual Pay</label></div></div><div class="col-md-4" style="margin-top:13px;"><div class="input-group-btn"><button class="btn btn-success" style="margin-right: 15px;" type="button"  onclick="education_fields();"> <i class="fas fa-plus"></i> </button><button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"><i class="fas fa-minus"></i></button></div></div></div>';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
</script>

</body>
</html>