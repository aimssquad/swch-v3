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
    height: 37px !important;
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
								<a href="#">Generate Report</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
						<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i>Generate Report</h4>
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
        

<!-- Add Employee By Form -->

<div class="card">
	<div class="card-header">Generate Report</div>
	<div class="card-body">
    <form action="{{ route('download.report') }}" method="get">
        <div class="form-group">
            <label for="selectedDepartments">Select Departments:</label>
            <select class="form-control input-border-bottom" id="selectedDepartments" name="selectedDepartments[]" >
                @foreach ($departments as $department)
                    <option value="{{ $department->department_name }}">{{ $department->department_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectedGrades">Select Grades:</label>
            <select class="form-control input-border-bottom" id="selectedGrades" name="selectedGrades[]" >
                @foreach ($grades as $grade)
                    <option value="{{ $grade->class_name }}">{{ $grade->class_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectedDesignations">Select Designations:</label>
            <select class="form-control input-border-bottom" id="selectedDesignations" name="selectedDesignations[]" >
                @foreach ($designations as $designation)
                    <option value="{{ $designation->designation_name }}">{{ $designation->designation_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>
			</div>
</div> 
</div>
<!--Add Employee By Form -->
<script>
    $(document).ready(function() {
        $('#selectedDepartments').select2();
        $('#selectedGrades').select2();
        $('#selectedDesignations').select2();
    });
</script>

</body>
</html>