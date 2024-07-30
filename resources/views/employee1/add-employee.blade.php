<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->

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
	.table td, .table th{padding:0 5px !important}
	.form-control {
    font-size: 14px;
    border-color: #ebedf2;
    padding: .6rem 1rem;
    height: 50px !important;
}
input[type="date"]
{
    display:block;
  
    /* Solution 1 */
     -webkit-appearance: textfield;
    -moz-appearance: textfield;
    min-height: 1.2em; 
  
    /* Solution 2 */
    /* min-width: 96%; */
}

	</style>
</head>
<body>
	<div class="wrapper">
			
  @include('employee.include.header')
		<!-- Sidebar -->
		
		  @include('employee.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		    <div class="page-header">
						<!--<h4 class="page-title">Employee</h4>-->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
								Home
								</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item">
								<a href="{{url('employees')}}">Employee</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="#">Add New Employee</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
						<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i>  Add New Employee</h4>
								</div>
							<div class="card-body">
									<div class="multisteps-form">
        <!--progress bar-->
        <div class="row">
          <div class="col-12 col-lg-12 ml-auto mr-auto mb-4" style="display:none;">
            <div class="multisteps-form__progress">
              <button class="multisteps-form__progress-btn js-active" type="button" title="User Info">User Info</button>
			  <button class="multisteps-form__progress-btn" type="button" title="service">Service</button>
			  <button class="multisteps-form__progress-btn" type="button" title="training">Training</button>
              <button class="multisteps-form__progress-btn" type="button" title="Address">Address</button>
              <button class="multisteps-form__progress-btn" type="button" title="Order Info">Order Info</button>
			  <button class="multisteps-form__progress-btn" type="button" title="license">License</button>
              <button class="multisteps-form__progress-btn" type="button" title="Comments">Comments</button>
			  <button class="multisteps-form__progress-btn" type="button" title="imigration">Immigration</button>
            </div>
          </div>
         
        </div>
        <!--form panels-->
        <div class="row">
          <div class="col-12 col-lg-12 m-auto">
          <!-- upload.blade.php -->
<div class="card">
	<div class="card-header">Add Bulk Data Of Employee</div>
	<div class="card-body">
    <form action="{{ route('addemployee.bulk.upload') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
            <div class="row mb-4">
				<label class="col-sm-2 col-label-form">Uplaod Excel File</label>
				<div class="col-sm-10">
                <input class="form-control" type="file" name="excel_file" accept=".xlsx">
				</div>
			</div>
			<div class="text-center">
				<input type="submit" class="btn btn-primary" value="Upload" />
			</div>
		</form>
	</div>
</div> 

<!-- Add Employee By Form -->

<div class="card">
	<div class="card-header">Add Employee</div>
	<div class="card-body">
            <form method="post" action="{{ route('addemployee.by.form') }}">
                @csrf
                <div class="mb-3">
                    <label for="si_no" class="form-label">SI No:</label>
                    <input type="text" name="si_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee ID:</label>
                    <input type="text" name="employee_id" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="employee_code" class="form-label">Employee Code:</label>
                    <input type="text" name="employee_code" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="employee_name" class="form-label">Employee Name:</label>
                    <input type="text" name="employee_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="father_name" class="form-label">Father Name:</label>
                    <input type="text" name="father_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department:</label>
                    <select class="form-control input-border-bottom" id="selectFloatingLabel" name="department" required>
                    @foreach($department as $dept)
                    <option value='{{ $dept->department_name }}'>{{ $dept->department_name }}</option>				
                    @endforeach                                                               </select>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">Designation:</label>
                    <select class="form-control input-border-bottom" id="selectFloatingLabel" name="designation" required>
                    @foreach($designation as $desig)
                    <option value='{{ $desig->designation_name }}'>{{ $desig->designation_name }}</option>				
                    @endforeach                                                               </select>
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="text" name="dob" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="doj" class="form-label">Date of Joining:</label>
                    <input type="text" name="doj" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="emp_status" class="form-label">Employee Status:</label>
                    <input type="text" name="emp_status" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <input type="text" name="status" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Religion:</label>
                    <select class="form-control input-border-bottom" id="selectFloatingLabel" name="religion" required>
                    @foreach($religion_master as $rel)
                    <option value='{{ $rel->religion_name }}'>{{ $rel->religion_name }}</option>				
                    @endforeach                                                               </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Caste:</label>
                    <select class="form-control input-border-bottom" id="selectFloatingLabel" name="caste" required>
                    @foreach($caste_master as $caste)
                    <option value='{{ $caste->caste_name }}'>{{ $caste->caste_name }}</option>				
                    @endforeach                                                               </select>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="city" class="form-label">City:</label>
                    <input type="text" name="city" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="state" class="form-label">State:</label>
                    <input type="text" name="state" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Country:</label>
                    <input type="text" name="country" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="pincode" class="form-label">Pincode:</label>
                    <input type="text" name="pincode" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="mobile_no" class="form-label">Mobile Number:</label>
                    <input type="text" name="mobile_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="class" class="form-label">Class:</label>
                    <input type="text" name="class" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="pf_no" class="form-label">PF Number:</label>
                    <input type="text" name="pf_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="uan_no" class="form-label">UAN Number:</label>
                    <input type="text" name="uan_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="pan_no" class="form-label">PAN Number:</label>
                    <input type="text" name="pan_no" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="bank" class="form-label">Bank:</label>
                    <input type="text" name="bank" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="ifsc_code" class="form-label">IFSC Code:</label>
                    <input type="text" name="ifsc_code" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="account_no" class="form-label">Account Number:</label>
                    <input type="text" name="account_no" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Add Employee</button>
            </form>
			</div>
</div> 
</div>
<!--Add Employee By Form -->
</body>
</html>