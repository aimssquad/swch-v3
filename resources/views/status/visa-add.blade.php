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
	<style>.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('status.include.header')
		<!-- Sidebar -->
		
		  @include('status.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Organisation Status</h4>
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
								<a href="#">Visa File</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{url('organisation-status/view-visa')}}"> Visa File</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#"> New Visa File</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"> New Visa File</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data" id="myForm">
			 {{csrf_field()}}
			 
										<div class="row form-group">
										
								
				
											 
											<div class="col-md-9">
												<div class=" form-group form-floating-label">
													<select class="form-control input-border-bottom"   id="employee_id"  name="employee_id" required>
													    
													<option value="">&nbsp;</option>
														@foreach($employee_rs as $company)
													<option value="{{$company->emp_code}}">{{$company->emp_fname}} {{$company->emp_mname}} {{$company->emp_lname}} ({{$company->emp_code}})</option>
																
  @endforeach  
            	
													
												</select>
												
												<label for="employee_id" class="placeholder">Select Employee </label>
												</div>
											</div>
										
												@foreach($visa_act_rs as $visa)
													<div class="col-md-12">
													<h4 class="card-title">{{$visa->name}}</h4>
														</div>
													<input type="hidden" class="form-control input-border-bottom"   id="id}"  name="id[]" value="{{$visa->id}}" required>
												<input type="hidden" class="form-control input-border-bottom"   id="duration{{$visa->id}}"  name="duration{{$visa->id}}" value="{{$visa->duration}}" required>
												<input type="hidden" class="form-control input-border-bottom"   id="description{{$visa->id}}"  name="description{{$visa->id}}" value="{{$visa->name}}" required>
													
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input type="date" class="form-control input-border-bottom"  onchange="getreviewdate({{$visa->id}});"   id="start_date{{$visa->id}}"  name="start_date{{$visa->id}}" >
													
												
												<label for="start_date{{$visa->id}}" class="placeholder">  Start Date  </label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input type="date" class="form-control input-border-bottom"   id="end_date{{$visa->id}}"  name="end_date{{$visa->id}}" readonly >
													
												
												<label for="end_date{{$visa->id}}" class="placeholder"> End Date  </label>
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group form-floating-label">
													<input type="date" class="form-control input-border-bottom"   id="actual_date{{$visa->id}}"  name="actual_date{{$visa->id}}" >
													
												
												<label for="actual_date{{$visa->id}}" class="placeholder"> Actual Completion Date  </label>
												</div>
											</div>
											
											<div class="col-md-12">
												<div class=" form-group form-floating-label">
												    <textarea  id="remarks"  name="remarks{{$visa->id}}"    class="form-control input-border-bottom"  style="margin-top: 22px;"></textarea>
												
												
												<label for="remarks" class="placeholder"> Remarks</label>
												</div>
											</div>
											@endforeach  
												
					<div class="col-md-4" style="margin-top:25px;">
						<button type="submit" class="btn btn-default btn-up">Submit</button>
					</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('status.include.footer')
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
	function getreviewdate(val){
		var empid=document.getElementById("start_date"+ val).value; 
			var duration=document.getElementById("duration"+ val).value; 
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewdurationById')}}/'+empid+'/'+duration,
        cache: false,
		success: function(response){
			console.log(response);
			
		 $("#end_date"+val).val(response);
		}
		});
	}
 $(document).ready(function(){
    $('#myForm').on('submit', function(e){
         var empid=document.getElementById("job_date").value;
        e.preventDefault();
        if(empid!=''){
            this.submit();
        }else{
            $("#job_date").focus();
        }
    });
});  
    
    function bank_epmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_bank_new").style.display = "block";	
	}else{
		document.getElementById("criman_bank_new").style.display = "none";	
	}
  
}
</script>
</body>
</html>