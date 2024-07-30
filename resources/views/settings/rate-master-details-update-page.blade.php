<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
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
</head>
<body>
	<div class="wrapper">
	  @include('settings.include.header')
		<!-- Sidebar -->
		
		  @include('settings.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">HCM Master</h4> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('settingdashboard')}}">
									Home
								</a>
							</li>
							 <li class="separator">
							/
							</li>
							<li class="nav-item">
								<a href="#">HCM Master</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item">
									<a href="{{url('settings/vw-pincode')}}">class</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="#">Rate Details</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-building"></i>Rate Details</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{url('settings/rate-update-save')}}" method="post" enctype="multipart/form-data">
			                     {{csrf_field()}}
								 
									<div class="row">
										<div class="col-md-3">
										 <input type="hidden" name="detailsId" value="<?php print_r($rate['0']->id)?>" >
											<label for="inputFloatingLabel" class="placeholder">Head Type(*)</label>
												<select class="form-control" name="pay_type" id="headType" onchange="headtypeFunc()" readonly>
                                                   
                                                      <option value="EARNING" <?php if($rate['0']->pay_type=='EARNING'){?> selected="selected"<?php }?>>EARNING</option> 
                                                     <option value="DEDUCATION" <?php if($rate['0']->pay_type=='DEDUCATION'){?> selected="selected"<?php }?>>DEDUCATION</option> 
                                                </select>
										
                                         </div>
                                        <div class="col-md-3">
										
											<label for="inputFloatingLabel" class="placeholder">Head Name(*)</label>
                                            <select class="form-control" id="rate_id" name="rate_id" required readonly>
                                           
										    <option value="<?php print_r($rate['0']->rate_id) ?>"><?php print_r($rate['0']->head_name) ?></option>
								            </select>
										
                                        </div>
                                        <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Calculation Type<span>(*)</span></label>
                                    <select class="form-control" name="cal_type" id="cal_type" onchange="checkcaltype(this.value);" required>
                                        <!--<option value="" selected disabled >Select</option>-->
                                       
                                        <option value="F" <?php if($rate['0']->cal_type=="F") {?>FIXED <?php } ?>>FIXED</option>
                                        <option value="V" <?php if($rate['0']->cal_type=="V") {?>VARIABLE <?php } ?> >VARIABLE</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">In Percentage <span>(*)</span></label>
                                    <input type="text" class="form-control" id="inpercentage" name="inpercentage" value="<?php print_r($rate['0']->inpercentage)?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">In Rupees <span>(*)</span></label>
                                    <input type="text" class="form-control" id="inrupees" name="inrupees" value="<?php print_r($rate['0']->inrupees)?>"  required>
                                </div>
								  <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Min value <span>(*)</span></label>
                                    <input type="number" step="any" class="form-control" id="min_basic" name="min_basic" value="<?php print_r($rate['0']->min_basic)?>" required >
                                </div>
								  <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Max Value  <span>(*)</span></label>
                                    <input type="number" step="any" class="form-control" id="max_basic" name="max_basic" value="<?php print_r($rate['0']->max_basic)?>" required >
                                </div>

                                <div class="col-md-3">
                                    <label for="email-input" class=" form-control-label">Effective From<span>(*)</span></label>
                                    <input type="date" class="form-control" id="from_date" name="from_date" value="<?php print_r($rate['0']->from_date)?>" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="text-input" class=" form-control-label">Effective To <span>(*)</span></label>
                                    <input type="date" class="form-control" id="to_date" name="to_date" value="<?php print_r($rate['0']->to_date)?>" required>
                                </div>
                                        
                                        <div class="col-md-3">
										
											<label for="inputFloatingLabel" class="placeholder">Status</label>
											<select class="form-control" name="status">
                                              <option value="">Select</option>
                                              <option value="<?php print_r($rate['0']->status)?>" 
                                              <?php if($rate['0']->status==="Active"){?> selected="selected" <?php }?> > <?php print_r($rate['0']->status)?> </option>
                                            </select>
										
											</div>
											</div>
											<div class="row form-group">
										<div class="col-md-2"><button type="submit" class="btn btn-default">Submit</button></div>
										</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
 @include('settings.include.footer')
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
        function checkcaltype(type){
            console.log(type)
		  if(type=='V'){
			    $(inpercentage).val('0');
				   $("#inpercentage").attr("readonly", true);
				   $("#inrupees").val('0');
				   	$("#inrupees").attr("readonly", true);
					 $("#min_basic").val('0');
				   	$("#min_basic").attr("readonly", true);
					 $("#max_basic").val('0');
				   	$("#max_basic").attr("readonly", true);
		  }else{
			   $("#inpercentage").attr("readonly", false);
				
				   	$("#inrupees").attr("readonly", false);
					 
				   	$("#min_basic").attr("readonly", false);
					
				   	$("#max_basic").attr("readonly", false);
	  }
    }
        function headtypeFunc(){
            var headtype=$("#headType option:selected").text();
           
                $.ajax({
                url:"{{url('settings/headmaster')}}"+"/"+headtype,
                type:"GET", 
                success: function(response){
			
			document.getElementById("rate_id").innerHTML = response;
		       }
           
            })
           
            }
           
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