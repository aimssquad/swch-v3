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

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">COS  File</h4> -->
						<!--<ul class="breadcrumbs">-->
						<!--	<li class="nav-home">-->
						<!--		<a href="#">-->
						<!--			<i class="flaticon-home"></i>-->
						<!--		</a>-->
						<!--	</li>-->
						<!--	 <li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="#">COS  File</a>-->
						<!--	</li>-->
						<!--	<li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="{{url('superadmin/view-add-cos')}}"> COS  File</a>-->
						<!--	</li>-->
						<!--	<li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="#"> Edit COS  File</a>-->
						<!--	</li>-->
						<!--</ul>-->
					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-file-word"></i> Edit COS  File</h4>
								</div>
								<div class="card-body">
									<form action="{{url('superadmin/edit-cos')}}" method="post" enctype="multipart/form-data" id="myForm">
			 							{{csrf_field()}}

			 							<input id="id" type="hidden"  name="id"  value="{{$hr->id}}" >

										<div class="row form-group">
										@php
											$res = DB::table('registration')
												->where('reg','=',$hr->emid)
												->first();
										//dd($res);

										@endphp
										<div class="col-md-4">
											<div class="form-group">
												<label for="emidname" class="placeholder" style="padding-top:0;margin-top: -10px;">Organisation Name</label>
												<input type="text" class="form-control input-border-bottom" id="emidname" type="text"  name="emidname" required="" value="{{$res->com_name}}" readonly   onchange="checkcompany();">
												<input id="emid" type="hidden"  name="emid"  value="{{$hr->emid}}" >
											</div>
										</div>
										@php
											$candidate = DB::table('recruitment_file_emp')
														->where('emid', '=', $res->reg)
														->orderBy('employee_name', 'asc')
														->get();

														//dd($hr->addn_cos);
										@endphp

											<div class="col-md-4">
												<div class="form-group">
													<label for="employee_name" class="placeholder">Organisation Candidate Name</label>
													@if($hr->addn_cos=='Yes')
													<input id="employee_name" type="text"  name="employee_name"  value="{{$hr->employee_name}}" readonly>
													@else
													<select class="form-control input-border-bottom" id="employee_name"   name="employee_name" disabled>
														<option value="">&nbsp;</option>
														@foreach($candidate as $record)
															<option value="{{$record->employee_name}}" @if($hr->employee_name==$record->employee_name) selected @endif>{{$record->employee_name}}</option>
														@endforeach
														</select>
													@endif
														<input id="existing_employee_name" type="hidden"  name="existing_employee_name"  value="{{$hr->employee_name}}" >
												</div>
											</div>

										@php
											$passgg=DB::Table('users_admin_emp')
												->where('employee_id','=',$hr->employee_id)
												->first();
										@endphp
										@php
											$Exemp = DB::table('role_authorization_admin_organ')
												->where('status','=','active')
												->where('module_name','=',$hr->emid)
												->get();
										@endphp
											<div class="col-md-4">
												<div class="form-group">
													<label for="ref_id" class="placeholder" style="padding-top:0;margin-top: -10px;">Assign To</label>
													<select class="form-control input-border-bottom" id="employee_id" required=""  name="employee_id">
														<option value="">&nbsp;</option>
														@php
															foreach ($Exemp as $refrdepgt) {
																$rr = DB::table('users_admin_emp')
																	->where('employee_id', '=', $refrdepgt->member_id)
																	->first();
														@endphp
														<option value="{{$refrdepgt->member_id}}" @if($hr->employee_id==$refrdepgt->member_id) selected @endif>{{$rr->name}}</option>
														@php
															}
														@endphp
													</select>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-4">
												<button type="submit" class="btn btn-default">Submit</button>
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

  function checkcompany(){
	   var empid=document.getElementById("emidname").value;

	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkById')}}/'+empid,
        cache: false,
		success: function(response){


			var obj = jQuery.parseJSON(response);

			 console.log(obj);

			  var reg=obj[0].reg;


				  $("#emid").val(reg);
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
function bank_yyepmloyee(val) {
	if(val=='Yes'){
	document.getElementById("criman_banknn_new").style.display = "block";
	}else{
		document.getElementById("criman_banknn_new").style.display = "none";
	}

}
</script>
</body>
</html>
