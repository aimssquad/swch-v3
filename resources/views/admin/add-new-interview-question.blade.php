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
									<h4 class="card-title"><i class="fas fa-archive"></i> <?php if (!empty($employee_type->id)) {echo 'Edit';}else{ echo 'Add';}?> Interview Question</h4>
								</div>
								<div class="card-body" style="">
									<form action="{{ url('superadmin/add-interview-question') }}" method="post" enctype="multipart/form-data">
			                        {{csrf_field()}}
			                            <input type="hidden" name="id"  class="form-control" value="<?php if (!empty($employee_type->id)) {echo $employee_type->id;}?>">
										<div class="row">
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="interview_type" class="placeholder">Interview Type </label>
                                                    <select class="form-control" name="interview_type" id="interview_type" required onchange="getSections(this.value);">
                                                        <option value="">Select Interview Type</option>   
                                                        @foreach($types as $indx=>$item)
                                                        <option value="{{$indx}}" <?php if (isset($employee_type->type) && $employee_type->type == $indx) {echo 'selected';}?>>{{$item}}</option>
                                                        @endforeach 
                                   
                                                    </select>
											    </div>
										    </div>
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="section" class="placeholder">Question Section</label>
                                                    <select class="form-control" name="section" id="section" required >
                                                        <option value="">Select Section</option>   
                                                    </select>
											    </div>
										    </div>
		 	                                <div class="col-md-12">
										        <div class="form-group ">
										            <label for="question" class="placeholder">Question</label>
										      	        <input type="text" id="question" name="question"  class="form-control "   value="<?php if (!empty($employee_type->question)) {echo $employee_type->question;}?>" required>
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
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});
            
            <?php if (isset($employee_type->type)) { ?>
                getSections({{$employee_type->type}});
                
            <?php } ?>
            
		});

        function getSections(type_id)
        {
            //var type_id=$("#interview_type").val();

            $.ajax({
                type:'GET',
                url:"{{url('pis/get-interview-question-sections')}}/"+type_id,
                beforeSend: function() {
                    $('#section').attr('disabled', true);
                },
                success: function(response){
                    var obj = jQuery.parseJSON(response);
                   // console.log(obj);
                    var strOption="<option value=''>Select Section</option> ";
                    if(obj.length>0){
                        for(i=0;i<obj.length;i++){
                            //console.log(obj[i].section_name);
                            strOption=strOption+"<option value='"+obj[i].section_name+"'";
                            
                            strOption=strOption+">"+obj[i].section_name+"</option>";
                        }
                    }
                    $("#section").html(strOption);
                    $('#section').attr('disabled', false);
                    <?php if (isset($employee_type->section)) { ?>
                        $("#section").val('{{$employee_type->section}}');
                    <?php } ?>
                }
            });
        }

	</script>

</body>
</html>