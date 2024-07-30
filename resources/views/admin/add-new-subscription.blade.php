<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
		<link rel="icon" href="{{ asset('img/favicon.png')}}">
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
    <link rel="stylesheet" href="{{ asset('css/select2.min.css')}}">
	 <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

	 <style>
input[type=checkbox], input[type=radio] {
    /* padding-right: 10px; */
    margin-right: 8px;
}
.vat{margin-top:17px;}
	 </style>
</head>
<body>
	<div class="wrapper">

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">Package</h4> -->
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-archive"></i> Add Subscription Plan</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{ url('superadmin/add-subscription') }}" method="post" enctype="multipart/form-data">
			                        {{csrf_field()}}
			                            <input type="hidden" name="id"  class="form-control" value="<?php if (!empty($employee_type->id)) {echo $employee_type->id;}?>">
										<div class="row">
		 	                                <div class="col-md-3">
										        <div class="form-group ">
										            <label for="emid" class="placeholder">Organisation</label>
                                                    
                                                    <select id="emid" name="emid"  class="form-control select2_el" required>
                                                        <option value=""> Select Organisation</option>
                                                        @foreach($companies as $record)
                                                        <option value="{{ $record->reg}}" <?php if (!empty($employee_type->id) && $employee_type->emid==$record->reg) {?>selected <?php } ?> >{{ $record->com_name}}</option>
                                                        @endforeach
                                                    </select>
                                                  
											    </div>
										    </div>
		 	                                <div class="col-md-3">
										        <div class="form-group ">
										            <label for="plan_id" class="placeholder">Plan Name</label>
                                                    <select id="plan_id" name="plan_id"  class="form-control select2_el" required onchange="cal_expiry();">
                                                        <option value=""> Select Subscription Plan</option>
                                                        @foreach($plans as $record)
                                                        <option value="{{ $record->id}}" <?php if (!empty($employee_type->id) && $employee_type->plan_id==$record->id) {?>selected <?php } ?> >{{ $record->plan_name}}</option>
                                                        @endforeach
                                                    </select>
											    </div>
										    </div>
										    <div class="col-md-3">
										        <div class="form-group ">
										            <label for="start_date" class="placeholder">Start Date</label>
										      	    <input type="date" id="start_date" name="start_date"  class="form-control "   value="<?php if (!empty($employee_type->id)) {echo $employee_type->start_date;}?>" required onchange="cal_expiry();" onblur="cal_expiry();">
											    </div>
										    </div>
										    <div class="col-md-3">
										        <div class="form-group ">
										            <label for="expiry_date" class="placeholder">Expiry Date</label>
										      	    <input type="text" id="expiry_date" name="expiry_date" readonly  class="form-control"   value="<?php if (!empty($employee_type->id)) {echo date('d/m/Y',strtotime($employee_type->expiry_date));}?>">
											    </div>
										    </div>
                                            <div class="col-md-3">
										        <div class="form-group ">
										  	        <label for="status" class="placeholder">Status</label>
										            <select id="status"  class="form-control "   name="status" required >
                                                        <option value="">Select Status</option>
								                        <option value="active" <?php if (!empty($employee_type->id)) {if (!empty($employee_type->status)) {if ($employee_type->status == "active") {?> selected="selected" <?php }}}?>  >Active</option>
							                            <option value="inactive" <?php if (!empty($employee_type->id)) {if (!empty($employee_type->status)) {if ($employee_type->status == "inactive") {?> selected="selected" <?php }}}?>>Inactive</option>
						                            </select>
											    </div>
										    </div>
   	                                        
                                            <div class="col-md-12 btn-up">
                                                <button type="submit" class="btn btn-default">Submit</button></div>
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
    <script type="text/javascript">
        function cal_expiry(){
            var plan_id=$("#plan_id").val();
            var start_date=$("#start_date").val();
            if(plan_id!="" && start_date!=""){
                $.ajax({
                    type:'GET',
                    url:'{{url('pis/calulate-expiry-date')}}/'+plan_id+'/'+start_date,
                    cache: false,
                    success: function(response){
                        
                        //console.log(response);
                        $("#expiry_date").val(response)
                    }
                });

            }
        }
    </script>
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        initailizeSelect2();
    });
    // Initialize select2
    function initailizeSelect2() {

        $(".select2_el").select2();
    }
</script>

</body>
</html>