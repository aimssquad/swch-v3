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
         /*custom font*/
         @import url(import url here);
         body {
         /*font: normal 1em 'font';*/
         /* background-color: "red"; */
         }
         main {
         /*	margin-top: 4.5em; */
         }
         /* #section1 {
         height: 30em;
         } */
         /* Multi-Step Form */
         * {
         box-sizing: border-box;
         }
         /* #regForm {
         background-color: #fff;
         margin: 100px auto;
         font-family: Raleway;
         padding: 40px;
         width: 100%;
         min-width: 600px;
         } */
         h1 {
         text-align: center;  
         }
         input {
         padding: 10px;
         width: 100%;
         font-size: 17px;
         font-family: Raleway;
         border: 1px solid #aaaaaa;
         }
         /* Mark input boxes that get errors during validation: */
         input.invalid {
         background-color: #ffdddd;
         }
         /* Hide all steps by default: */
         .tab {
         display: none;
         }
         button {
         background-color: #4CAF50;
         color: #ffffff;
         border: none;
         padding: 10px 20px;
         font-size: 17px;
         font-family: Raleway;
         cursor: pointer;
         }
         button:hover {
         opacity: 0.8;
         }
         #prevBtn {
         background-color: #bbbbbb;
         }
         /* Step marker: Place in the form. */
         .step {
         height: 15px;
         width: 15px;
         margin: 0 2px;
         background-color: #bbbbbb;
         border: none;  
         border-radius: 50%;
         display: inline-block;
         opacity: 0.5;
         }
         .step.active {
         opacity: 1;
         }
         /* Mark the steps that are finished and valid: */
         .step.finish {
         background-color: #4CAF50;
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
                           <div class="avatar-preview">
                              <div id="imagePreview" style="background-image: url(https://2.bp.blogspot.com/-l9nGy2e3PnA/XLzG5A6u_cI/AAAAAAAAAgI/31bl8XZOrTwN0kTN8c18YOG3OhNiTUrsQCLcBGAs/s1600/rocket.png);">
                              </div>
                           </div>
                           <div id="divImageMediaPreview"></div>
                                    <!-- <div class="card-header"> <strong>Employee Master</strong> </div> -->
                                    <!-- @if(Session::has('message'))
                                       <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em ><i class="fa fa-check-square-o"></i> {{ Session::get('message') }}</em></div>
                                       @endif -->
                                    {{-- @include('include.messages') --}}
                                    <div class="card-body card-block">
                                       <div class="panel panel-primary">
                                          <div class="panel-body">
                                             <form name="basicform" id="basicform" method="post" action="{{url('employee/savemploy')}}" enctype="multipart/form-data" >
                                                {{ csrf_field() }}
                                                <div id="sf1" class="frm">
                                                   <fieldset>
                                                      <legend>Personal and Service Details</legend>
                                                      <div class="row form-group">
                                                         <div class="col-md-3">
                                                            <label>Employee ID </label>
                                                            <input type="text" value="<?php if (!empty($employee_code)) {echo $employee_code;}if (request()->get('q') != '') {echo $employee_rs[0]->emp_code;}?>" name="emp_code" class="form-control" readonly="1">
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Employee Code </label>
                                                            <input type="text" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->old_emp_code;}?>" name="old_emp_code" class="form-control">
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Salutation </label>
                                                            <select class="form-control" name="salutations" id="salutations" >
                                                               <option value="" label="Select">Select</option>
                                                               @if(isset($salutations) && !empty($salutations))
                                                               @foreach($salutations as $value)
                                                               <option value="{{ $value}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->salutation == $value) {echo 'selected';}}?>>{{ $value}}</option>
                                                               @endforeach
                                                               @endif
                                                            </select>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>First Name <span>(*)</span></label>
                                                            <input type="text" name="emp_fname" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_fname;}?>" class="form-control" id="fname" required>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Middle Name</label>
                                                            <input type="text" name="emp_mid_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_mname;}?>" class="form-control" id="fname">
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Last Name </label>
                                                            <input type="text" name="emp_lname" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_lname;}?>" class="form-control" id="lname">
                                                         </div>
                                                         <!-- </div>
                                                            <div class="row form-group"> -->
                                                         <div class="col-md-3">
                                                            <label>Father's Name <span>(*)</span></label>
                                                            <input type="text" name="emp_father_name" id="emp_father_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_father_name;}?>" class="form-control" required>
                                                         </div>
                                                         <!-- <div class="col-md-3">
                                                            <label>Present City Class <span>(*)</span></label>
                                                                          <select class="form-control" name="emp_present_city" required>
                                                            <option value="">Select</option>
                                                                           <option value="A class City" hidden <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_present_city_class == 'A class City') {echo 'selected';}}?>>A class City</option>
                                                            <option value="B class City" hidden <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_present_city_class == 'B class City') {echo 'selected';}}?>>B class City</option>
                                                            <option value="C class City" hidden <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_present_city_class == 'C class City') {echo 'selected';}}?>>C class City</option>
                                                            <option value="D class City" hidden <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_present_city_class == 'D class City') {echo 'selected';}}?>>D class City</option>
                                                            </select>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                               <label>Residential  Distance (in Km.)</label>
                                                                       <input type="hidden" name="emp_resdential_distance" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_residential_distance;}?>" class="form-control">
                                                            </div> -->
                                                         <!-- <div class="col-md-3">
                                                            <label>Home Town</label>
                                                                     <input type="hidden" name="emp_home_town" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_home_town;}?>" class="form-control">
                                                            </div> -->
                                                         <div class="col-md-3">
                                                            <label>Spouse Name</span></label>
                                                            <input type="text" name="emp_nearest_railway" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_nearest_railway;}?>" class="form-control">
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Caste</span></label>
                                                            <select class="form-control" name="emp_caste">
                                                               <option value="">Select</option>
                                                               @foreach($cast as $castname)
                                                               <option value="{{$castname->cast_name}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_caste == $castname->cast_name) {echo 'selected';}}?>>{{$castname->cast_name}}</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Sub Caste</span></label>
                                                            <select class="form-control" name="emp_sub_caste" id="emp_sub_caste">
                                                               <option value="">Select</option>
                                                               @foreach($sub_cast as $subcastname)
                                                               <option value="{{$subcastname->sub_cast_name}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_sub_caste == $subcastname->sub_cast_name) {echo 'selected';}}?>>{{$subcastname->sub_cast_name}}</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                         <!-- </div>
                                                            <div class="row form-group"> -->
                                                         <div class="col-md-3">
                                                            <label>Religion</span></label>
                                                            <select class="form-control" name="emp_religion">
                                                               <option value="">Select</option>
                                                               @foreach($religion as $rel)
                                                               <option value="{{$rel->religion_name}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_religion == $rel->religion_name) {echo 'selected';}}?>>{{$rel->religion_name}}</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label> Marital Status</span></label><br>
                                                            <div class="form-check-inline">
                                                               <label class="form-check-label">
                                                               <input type="radio"  class="form-check-input" value="Yes" <?php if (request()->get('q') != '') {if ($employee_rs[0]->marital_status == 'Yes') {echo 'checked';}}?> name="marital_status" onclick="showHideDiv()" id="marital_status" >Yes
                                                               </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                               <label class="form-check-label">
                                                                  <input type="radio" class="form-check-input" value="No" <?php if (request()->get('q') != '') {if ($employee_rs[0]->marital_status == 'No') {echo 'checked';}} else {echo 'checked';}?>  name="marital_status" onclick="showHideDiv()" >No
                                                            </div>
                                                         </div>
                                                         <div class="col-md-3" id="marriage_date">
                                                         <label>Date of Marriage</span></label>
                                                         <input type="date" name="marital_date" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->marital_date;}?>" class="form-control">
                                                         </div>
                                                      </div>
                                                      <div class="clearfix" style="height: 10px;clear: both;"></div>
                                                      <!-- <legend>Spouse Details</legend>
                                                         <div class="row form-group">
                                                            <div class="col-md-4">
                                                               <label>Spouse Working Status</label><br>
                                                               <div class="form-check-inline">
                                                                 <label class="form-check-label">
                                                         
                                                                                  <input type="hidden"  class="form-check-input" value="Employee" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_spouse_working_status == 'Employee') {echo 'checked';}}?> name="emp_spouse_working" onclick="showHideDiv()" id="emp_spouse_status" checked="checked">Employee
                                                                 </label>
                                                               </div>
                                                            <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                         <input type="hidden" class="form-check-input" value="House Wife" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_spouse_working_status == 'House Wife') {echo 'checked';}}?>  name="emp_spouse_working" onclick="showHideDiv()">House Wife
                                                              </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                                            <input type="hidden" class="form-check-input" value="Others" name="emp_spouse_working" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_spouse_working_status == 'Others') {echo 'checked';}}?> onclick="showHideDiv()">Others
                                                              </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                                            <input type="hidden" class="form-check-input" value="Same Organisation" name="emp_spouse_working" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_spouse_working_status == 'Same Organisation') {echo 'checked';}}?> onclick="hideDiv()">Same Organisation
                                                              </label>
                                                            </div>
                                                            </div>
                                                         
                                                               <div class="col-md-4" id="govt_emp" style="display: none;">
                                                                  <label>Government Employee?</label><br>
                                                                  <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                                            <input type="hidden" class="form-check-input" value="yes"  name="emp_government" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_government == 'yes') {echo 'checked';}}?>>Yes
                                                              </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                           <input type="hidden" class="form-check-input" value="no" name="emp_government" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_government == 'no') {echo 'checked';}}?>>No
                                                              </label>
                                                            </div>
                                                               </div>
                                                         
                                                               <div class="col-md-4" id="spouse_quarter" style="display: none;">
                                                                  <label>Spouse have Govt. quarter?</label><br>
                                                                  <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                            <input type="hidden" class="form-check-input" value="yes" name="emp_spouse_quarter" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_spouse_quarter == 'yes') {echo 'checked';}}?>>Yes
                                                              </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                              <label class="form-check-label">
                                                                              <input type="hidden" class="form-check-input" value="no" name="emp_spouse_quarter"  <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_spouse_quarter == 'no') {echo 'checked';}}?>>No
                                                              </label>
                                                            </div>
                                                               </div>
                                                            </div> -->
                                                      <!-------------service-details-------------->
                                                      <legend>Service Details</legend>
                                                      <div class="row form-group">
                                                         <div class="col-md-3">
                                                            <label>Department <span>(*)</span></label>
                                                            <select class="form-control" name="emp_department" required onchange="checkdepart(this.value)">
                                                               <option value="">Select</option>
                                                               @foreach($department as $dept)
                                                               <option value="{{$dept->department_name}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_department == $dept->department_name) {echo 'selected';}}?>>{{$dept->department_name}}</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Designation <span>(*)</span></label>
                                                            <select class="form-control" name="emp_designation" required id="emp_designation">
                                                               <option value="" label="Select">Select </option>
                                                            </select>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Date of Birth <span>(*)</span></label>
                                                            <input type="date" name="emp_dob" id="emp_dob" onchange="calculateDor()" data-date-format="DD MMMM YYYY" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_dob;}?>" class="form-control" required>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Date of Retirement </label>
                                                            <input type="text" name="emp_retirement_date" id="emp_retirement_date"  value="<?php if (request()->get('q') != '') {
                                                               $date_of_retire = date_create($employee_rs[0]->emp_retirement_date);
                                                               echo date_format($date_of_retire, 'd/m/Y');
                                                               }?>" class="form-control" readonly>
                                                         </div>
                                                      </div>
                                                      <div class="row form-group">
                                                         <div class="col-md-3">
                                                            <label>Date of Joining <span>(*)</span></label>
                                                            <input type="date" name="emp_doj" id="emp_doj" onchange="calculateDateOfIncrement()" data-date-format="DD MMMM YYYY" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_doj;}?>" class="form-control" required>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Confirmation Date</label>
                                                            <input type="date" name="emp_from_date" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_from_date;}?>" class="form-control">
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Next Increment Date </label>
                                                            <input type="date" name="emp_next_increment_date" id="emp_next_increment_date"  value="" class="form-control" >
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Eligible for Promotion</label>
                                                            <select class="form-control" name="emp_eligible_promotion">
                                                               <option value="">Select</option>
                                                               <option value="Yes" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_eligible_promotion == 'Yes') {echo 'selected';}}?>>Yes</option>
                                                               <option value="No" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_eligible_promotion == 'No') {echo 'selected';}}?>>No</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <div class="row form-group">
                                                         <div class="col-md-3">
                                                            <label>Employee Type <span>(*)</span></label>
                                                            <select class="form-control" name="emp_status" required>
                                                               <option value="">Select</option>
                                                               @foreach($employee_type as $emp)
                                                               <option value="{{$emp->employee_type_name}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_status == $emp->employee_type_name) {echo 'selected';}}?>>{{$emp->employee_type_name}}</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                         <!-- <div class="col-md-3">
                                                            <label>Till Date</label>
                                                                            <input type="hidden" name="emp_till_date" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_till_date;}?>" class="form-control">
                                                            </div> -->
                                                         <div class="col-md-3">
                                                            <label>Profile Image</label>
                                                            <input type="file" name="emp_image" class="form-control">
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Reporting Authority</label>
                                                            <select class="form-control" name="emp_reporting_auth" >
                                                               <option value="">Select</option>
                                                               @foreach($employeelists as $employeelist)
                                                               <option value="{{$employeelist->emp_code}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_reporting_auth == $employeelist->emp_code) {echo 'selected';}}?>>{{$employeelist->emp_fname}} {{$employeelist->emp_mname}} {{$employeelist->emp_lname}} ({{$employeelist->emp_code}})</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                         <div class="col-md-3">
                                                            <label>Leave Sanctioning Authority</label>
                                                            <select class="form-control" name="emp_lv_sanc_auth" >
                                                               <option value="">Select</option>
                                                               @foreach($employeelists as $employee)
                                                               <option value="{{$employee->emp_code}}" <?php if (request()->get('q') != '') {if ($employee_rs[0]->emp_lv_sanc_auth == $employee->emp_code) {echo 'selected';}}?>>{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}} ({{$employee->emp_code}})</option>
                                                               @endforeach
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <button class="btn btn-primary open1" type="button">Next <i class="ti-arrow-right"></i></button>
                                                   </fieldset>
                                                </div>

                                                <div id="sf2" class="frm" style="display: none;">
                                                   <fieldset>
                                                      <!---------------educational-details------------>
                                                      <legend>Educational Details</legend>
                                                      <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                         <thead>
                                                            <tr>
                                                               <th>Sl.No.</th>
                                                               <th>Qualification</th>
                                                               <th>Discipline</th>
                                                               <th>Institute Name</th>
                                                               <th>Board/University</th>
                                                               <th>Year of Passing</th>
                                                               <th>Percentage</th>
                                                               <th>Grade/Division</th>
                                                               <!--						<th>Action</th>-->
                                                            </tr>
                                                         </thead>
                                                         <tbody id="marksheet">
                                                            <?php $tr_id = 0;?>
                                                            <tr class="itemslot" id="<?php echo $tr_id; ?>">
                                                               <td>1</td>
                                                               <td>
                                                                  <select class="form-control" name="qualification[]">
                                                                     <option value='' selected>Select</option>
                                                                     {{-- @foreach($education as $educ)
                                                                     <option value='{{ $educ->id }}'>{{ $educ->education }}</option>
                                                                     @endforeach --}}
                                                                  </select>
                                                               </td>
                                                               <td><input type="text" name="discipline[]" value="" class="form-control"></td>
                                                               <td><input type="text" name="institute_name[]" value="" class="form-control"></td>
                                                               <td><input type="text" name="university[]" value="" class="form-control"></td>
                                                               <td><input type="text" name="year_of_passing[]" value="" class="form-control"></td>
                                                               <td><input type="text" name="percentage[]" value="" class="form-control"></td>
                                                               <td><input type="text" name="grade[]" value="" class="form-control"></td>
                                                               <td><button class="btn-success" type="button" id="add<?php echo ($tr_id + 1); ?>" onClick="addnewrow(<?php echo ($tr_id + 1); ?>)" data-id="<?php echo ($tr_id + 1); ?>"> <i class="ti-plus"></i> </button></td>
                                                            </tr>
                                                            <!--<tr>
                                                               <td>1</td>
                                                                                  <td><input type="text" name="emp_viii_qualification" readonly="" value="8th" class="form-control"></td>
                                                                                <td><input type="text" name="emp_viii_dicipline" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_viii_dicipline;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_viii_inst_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_viii_inst_name;}?>"  class="form-control"></td>
                                                               <td><input type="text" name="emp_viii_board_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_viii_board_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_viii_pass_year" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_viii_pass_year;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_viii_percentage" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_viii_percentage;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_viii_rank" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_viii_rank;}?>" class="form-control"></td>
                                                               
                                                               </tr>
                                                                            <tr>
                                                               <td>2</td>
                                                                                  <td><input type="text" name="emp_x_qualification" readonly="" value="10th" class="form-control"></td>
                                                                                <td><input type="text" name="emp_x_dicipline" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_x_dicipline;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_x_inst_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_x_institute_name;}?>"  class="form-control"></td>
                                                               <td><input type="text" name="emp_x_board_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_x_board_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_x_pass_year" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_x_pass_year;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_x_percentage" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_x_percentage;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_x_rank" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_x_rank;}?>" class="form-control"></td> -->
                                                            <!--<td style="width:150px;"><button type="button" id="add" class="btn btn-default pls"><i class="fa fa-plus"></i></button></td>-->
                                                            <!-- </tr>
                                                               <tr>
                                                               <td>3</td>
                                                                   <td><input type="text" name="emp_xii_qualification" readonly="" value="12th" class="form-control"></td>
                                                               <td><input type="text" name="emp_xii_dicipline" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_xii_dicipline;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_xii_inst_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_xii_institute_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_xii_board_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_xii_board_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_xii_pass_year" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_xii_pass_year;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_xii_percentage" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_xii_percentage;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_xii_rank" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_xii_rank;}?>" class="form-control"></td> -->
                                                            <!--<td style="width:150px;"><button type="button" id="add" class="btn btn-default pls"><i class="fa fa-plus"></i></button></td>-->
                                                            <!-- </tr>
                                                               <tr>
                                                               <td>4</td>
                                                                   <td><input type="text" name="emp_graduate_qualification" readonly="" value="Graduate" class="form-control"></td>
                                                               <td><input type="text" name="emp_graduate_dicipline" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_graduate_dicipline;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_graduate_inst_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_graduate_institute_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_graduate_board_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_graduate_board_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_graduate_pass_year" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_graduate_pass_year;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_graduate_percentage" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_graduate_percentage;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_graduate_rank" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_graduate_rank;}?>" class="form-control"></td>
                                                               
                                                               </tr>
                                                               <tr>
                                                               <td>5</td>
                                                                   <td><input type="text" name="emp_pgradu_qualification" readonly="" value="Post Graduate" class="form-control"></td>
                                                               <td><input type="text" name="emp_pgradu_dicipline" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_pgraduate_dicipline;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_pgradu_inst_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_pgraduate_institute_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_pgradu_board_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_pgraduate_board_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_pgradu_pass_year" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_pgraduate_pass_year;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_pgradu_percentage" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_pgraduate_percentage;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_pgradu_rank" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_pgraduate_rank;}?>" class="form-control"></td>
                                                               
                                                               </tr>
                                                               
                                                               <tr>
                                                               <td>6</td>
                                                                     <td><input type="text" name="emp_other_qualification" readonly="" value="other" class="form-control"></td>
                                                                   <td><input type="text" name="emp_other_dicipline" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_other_dicipline;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_other_inst_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_other_inst_name;}?>"  class="form-control"></td>
                                                               <td><input type="text" name="emp_other_board_name" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_other_board_name;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_other_pass_year" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_other_pass_year;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_other_percentage" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_other_percentage;}?>" class="form-control"></td>
                                                               <td><input type="text" name="emp_other_rank" value="<?php if (request()->get('q') != '') {echo $employee_rs[0]->emp_other_rank;}?>" class="form-control"></td>
                                                               
                                                               </tr> -->
                                                         </tbody>
                                                      </table>
                                                      <!---------------------------------------->
                                                      <div class="clearfix" style="height: 10px;clear: both;"></div>
                                                      <div class="form-group">
                                                         <button class="btn btn-warning back2" type="button"><i class="ti-arrow-left"></i> Back</button>
                                                         <button class="btn btn-primary open2" type="button">Next <i class="ti-arrow-right"></i></span></button>
                                                      </div>
                                                   </fieldset>
                                                </div>
                     
                                               
                                          
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                        </div>
                     </div>
                  </div>
               </div>
               </section>
               </main> 
               <!-- alerts are for fun of it -->
               {{-- <div class="alerts-container">
                  <div class="row">
                     <div id="timed-alert" class="alert alert-info animated tada" role="alert">
                        <span id="time"></span>
                     </div>
                  </div>
                  <div class="row">
                     <div id="click-alert" class="alert alert-warning" role="alert">
                     </div>
                  </div>
               </div> --}}
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
      <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

      <script type="text/javascript">
         $(document).ready(function() {
         $('#bootstrap-data-table-export').DataTable();
         });
      </script>
      <script type="text/javascript" src="{{ asset('js/jquery.validate.js') }}"></script>
      <script type="text/javascript">
         jQuery().ready(function() {
         
         
         
         $('#parmenent_country').val("INDIA");
         $('#emp_ps_country').val("INDIA");
         
         //var myLength = $("#parmenent_pincode").val().length;
         jQuery('#parmenent_pincode').change(function () {
               var parmenent_pincode =  $("#parmenent_pincode").val();
            var parmenent_pincode_length =  $("#parmenent_pincode").val().length;
              if($.isNumeric(parmenent_pincode)!=true)
          {
             $("#parmenent_pincode").val("");
            alert("Value is not Numeric");
          }
          if(parmenent_pincode_length!=6)
          {
             $("#parmenent_pincode").val("");
            alert("Pincode should be six digit");
          }
              //alert(parmenent_pincode);
         });
         
         jQuery('#present_pincode').change(function () {
               var present_pincode =  $("#present_pincode").val();
                var present_pincode_length =  $("#present_pincode").val().length;
              if($.isNumeric(present_pincode)!=true)
          {
             $("#present_pincode").val("");
            alert("Value is not Numeric");
          }
          if(present_pincode_length!=6)
          {
             $("#present_pincode").val("");
            alert("Pincode should be six digit");
          }
              //alert(parmenent_pincode);
         });
         
         
         
         
           showHideDiv();
         
         setbasicpay();
         populateBranch();
         
         var select_basic_id = "<?php if (request()->get('q') != '') {echo $employee_rs[0]->basic_pay;}?>";
         var select_branch_id = "<?php if (request()->get('q') != '') {echo $employee_rs[0]->bank_branch_id;}?>";
         
         setTimeout(function(){
             if(select_basic_id!=""){
         $("#emp_basic_pay option[value='"+select_basic_id+"']").prop('selected', true);
          }
         
          if(select_branch_id!=""){
         $("#bank_branch_id option[value='"+select_branch_id+"']").prop('selected', true);
          }
           },1000);
         
         
         
         jQuery('#fname').keyup(function () {
              this.value = this.value.replace(/[^a-zA-Z]/g,'');
         });
         
         jQuery('#emp_father_name').change(function () {
              this.value = this.value.replace(/[^a-zA-Z\s]/g,'');
         });
         
         jQuery('#parmenent_mobile').change(function () {
              this.value = this.value.replace(/[^0-9\.]/g,'');
              var parmenent_mobile_length =  $("#parmenent_mobile").val().length;
              if(parmenent_mobile_length!=10)
          {
             $("#parmenent_mobile").val("");
            alert("Phone No. should be ten digit");
          }
         });
         
         
         jQuery('#emp_ps_mobile').change(function () {
              this.value = this.value.replace(/[^0-9\.]/g,'');
              var emp_ps_mobile_length =  $("#emp_ps_mobile").val().length;
              if(emp_ps_mobile_length!=10)
          {
             $("#emp_ps_mobile").val("");
            alert("phone should be ten digit");
          }
         });
         
         
           // validate form on keyup and submit
           var v = jQuery("#basicform").validate({
             rules: {
               uname: {
                 required: false,
                 minlength: 2,
                 maxlength: 16
               },
               uemail: {
                 required: false,
                 minlength: 2,
                 email: true,
                 maxlength: 100,
               },
               upass1: {
                 required: false,
                 minlength: 6,
                 maxlength: 15,
               },
               upass2: {
                 required: false,
                 minlength: 6,
                 equalTo: "#upass1",
               }
         
             },
             errorElement: "span",
             errorClass: "help-inline-error",
           });
         
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
             if (v.form()) {
               $(".frm").hide("fast");
               $("#sf5").show("slow");
             }
           });
         $(".open5").click(function() {
             if (v.form()) {
               $(".frm").hide("fast");
               $("#sf6").show("slow");
             }
           });
         
           $(".open6").click(function() {
             if (v.form()) {
               $("#loader").show();
                setTimeout(function(){
                  $("#basicform").html('<h2>Employee Added Successfully</h2>');
                }, 1000);
               return false;
             }
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
         $(".back5").click(function() {
             $(".frm").hide("fast");
             $("#sf4").show("slow");
           });
         $(".back6").click(function() {
             $(".frm").hide("fast");
             $("#sf5").show("slow");
           });
         
         });
      </script>
      <script>
         function getGrades(company_id)
         {
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-grades')}}/'+company_id,
               success: function(response){
               console.log(response);
         
               $("#grade_id").html(response);
         
               }
         
            });
         }
         
         function calculateDor(){
            var emp_dob = $("#emp_dob").val();
               var dateOfBirth = new Date(emp_dob);
         
               var sixty_years_ago = new Date(dateOfBirth.getFullYear()+60,dateOfBirth.getMonth(),dateOfBirth.getDate());
         
               if(dateOfBirth.getDate()==1 && sixty_years_ago.getMonth()==0){
                  var lastdate = new Date(sixty_years_ago.getFullYear(), (sixty_years_ago.getMonth()+1), 0).getDate();
                  var lastDayWithSlashes = lastdate + '/' + '12' + '/' + (sixty_years_ago.getFullYear()-1);
         
               }else if(dateOfBirth.getDate()==1 && sixty_years_ago.getMonth()>0){
                  var lastdate = new Date(sixty_years_ago.getFullYear(), (sixty_years_ago.getMonth()), 0).getDate();
                  var lastDayWithSlashes = lastdate + '/' + (sixty_years_ago.getMonth()) + '/' + sixty_years_ago.getFullYear();
         
               }else{
                  var lastdate = new Date(sixty_years_ago.getFullYear(), (sixty_years_ago.getMonth()+1), 0).getDate();
                  var lastDayWithSlashes = lastdate +'/' + (sixty_years_ago.getMonth()+1) + '/' + sixty_years_ago.getFullYear();
               }
         
             $("#emp_retirement_date").val(lastDayWithSlashes);
         }
         
         
         
         function calculateDateOfIncrement(){
            var emp_doj = $("#emp_doj").val();
            var dateOfJoining= new Date(emp_doj);
            var joingMonth=dateOfJoining.getMonth()+ 1;
         
            if(dateOfJoining.getDate()==1 && joingMonth==1){
               var nextIncrementDate = '01' + '/' + '07' + '/' + dateOfJoining.getFullYear();
         
            }else if(dateOfJoining.getDate()>=1 && (joingMonth>=1 && joingMonth<=6)){
               var nextIncrementDate = '01' + '/' + '01' + '/' + (dateOfJoining.getFullYear() +1);
         
            }else if(dateOfJoining.getDate()==1 && joingMonth==7){
         
               var nextIncrementDate = '01' + '/' + '01' + '/' + (dateOfJoining.getFullYear() +1);
            }else {
         
               var nextIncrementDate = '01' + '/' + '07' + '/' + (dateOfJoining.getFullYear() +1);
            }
         
             $("#emp_next_increment_date").val(nextIncrementDate);
         
         }
         
         
         
         function setbasicpay(){
            var emp_payscale_id = $("#emp_payscale option:selected" ).val();
         
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-employee-scale')}}/'+emp_payscale_id,
               success: function(response){
                  if(response.length>0){
                     var option = '';
                  for (var i=0;i<response.length;i++){
                     option += '<option value="'+ response[i].pay_scale_basic + '">' + response[i].pay_scale_basic + '</option>';
                  }
                  $('#emp_basic_pay').html(option);
         
                  }
         
               }
            });
         }
         
         
         function populateBranch(){
         
            var emp_bank_id = $("#emp_bank_name option:selected" ).val();
         
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-employee-bank')}}/'+emp_bank_id,
               success: function(response){
                  console.log(response);
                  var option = '';
                  for (var i=0;i<response.length;i++){
                     option += '<option value="'+ response[i].id + '">' + response[i].branch_name + '</option>';
                  }
                  $('#bank_branch_id').html(option);
               }
            });
         }
         
         
         
         
         
         function getIfcs(){
         
            var emp_branch_id= $("#bank_branch_id option:selected" ).val();
         
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-employee-bank-ifsc-code')}}/'+emp_branch_id,
               success: function(response){
                  console.log(response);
                     var obj = jQuery.parseJSON(response);
                     $("#emp_ifsc_code" ).val(obj.ifsc_code);
               }
            });
         }
         
         
      </script>
      <script>
         function getEmployeeType(company_id)
         {
            //alert(company_id);
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-employee-type')}}/'+company_id,
               success: function(response){
               console.log(response);
         
               $("#employee_type_id").html(response);
         
               }
         
            });
         }
      </script>
      <script>
         function getDesignation(company_id)
         {
            //alert(company_id);
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-designation')}}/'+company_id,
               success: function(response){
               console.log(response);
         
               $("#designation_id").html(response);
         
               }
         
            });
         }
      </script>
      <script>
         function getHeadNames(grade_id)
         {
            var company_id=$("#company_id option:selected").val();
            //alert("Company"+company_id);
            //alert("Grade"+grade_id);
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-head-names')}}/'+company_id+'/'+grade_id,
               success: function(response){
               console.log(response);
         
               $("#head").html(response);
         
               }
         
            });
         }
      </script>
      <script type="text/javascript">
         function chckaddress() {
            var ischecked=$('#diffaddrress').is(":checked");
            //alert(ischecked);
            var permanent_street_no=$("#permanent_street_no").val();
            var permanent_city=$("#permanent_city").val();
            var permanent_state=$("#permanent_state").val();
            var permanent_country=$("#parmenent_country").val();
            var permanent_pin=$("#permanent_pin").val();
            var parmenent_mobile=$("#parmenent_mobile").val();
         
            if(ischecked)
            {
               $("#present_street_no").val(permanent_street_no);
               $("#present_city").val(permanent_city);
               $("#present_state").val(permanent_state);
               $("#emp_ps_country").val(permanent_country);
               $("#present_pin").val(permanent_pin);
               $("#present_mobile").val(parmenent_mobile);
         
         
            }
            else
            {
               $("#present_street_no").val('');
               $("#present_city").val('');
               $("#present_state").val('');
               $("#present_country").val('');
               $("#present_pin").val('');
               $("#present_mobile").val('');
            }
         
         
         
         }
         
      </script>
      <script src="{{ asset('js/jquery.autosuggest.js') }}"></script>
      <script>
         var reporting_person='';
         var persons= reporting_person;
         //alert("Suggest"+persons);
         $("#reporting_person").autosuggest({
                  sugggestionsArray: persons
               });
      </script>
      <script>
         function getReportingPerson(val)
         {
            alert(val);
            //var reporting_person= encodeURIComponent(val);
            //window.location = 'payment_receive.php?job_work_no='+reporting_person;\
            $.ajax({
               type:'GET',
               url:'{{url('attendance/get-reporting-names')}}',
               success: function(response){
               alert(response);
               //var jqObj = jQuery.parseJSON(response);
               //var jqObj =JSON.parse(response);
               //var jqObj = $.parseJSON(response);
               //console.log(jqObj.reporting_person);
               //alert(jqObj);
               $("#browsers").html(response);
               //reporting_person= response;
               //$("#reporting_person").val(jqObj.reporting_person);
               }
         
            });
         }
         
      </script>
      <script>
         function getBranches(company_id)
         {
            //alert(company_id);
            $.ajax({
               type:'GET',
               url:'{{url('pis/get-branches')}}/'+company_id,
               success: function(response){
               console.log(response);
         
               $("#branch_id").html(response);
         
               }
         
            });
         }
      </script>
      <script>
         $(document).ready(function() {
          var i = 1;
           //alert('hii');
          $('#add').click(function() {
            // alert('hii');
            i++;
            $('#marksheet').append('<tr id="row' + i + '"><td>'+ i +'</td><td><input type="text" name="qualification[]" class="form-control"></td><td><input type="text" name="dicipline[]" class="form-control"></td> <td><input type="text" name="inst_name[]" class="form-control"></td><td><input type="text" name="board_name[]" class="form-control"></td><td><input type="text" name="pass_year[]" class="form-control"></td><td><input type="text" name="percentage[]" class="form-control"></td><td><input type="text" name="rank[]" class="form-control"></td><td style="width:150px;"><button type="button" id="' + i + '" class="btn btn-default pls btn_remove" ><i class="fa fa-minus"></i></button></td></tr>');
         
          });
         
         
          $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
          });
         
         
         
         
         
         });
         
                        
      </script>
      <!--<td><input type="text" name="nomination_name[]" class="form-control"></td>
         <td><input type="text" name="nomination_relation[]" class="form-control"></td>
         <td><input type="text" name="nomination_age[]" class="form-control"></td>
         <td style="width:150px;"><button id="addnomination" class="btn btn-default pls"><i class="fa fa-plus"></i></button><button class="btn btn-default pls"><i class="fa fa-minus"></i></button></td>
         -->
      <script>
         $(document).ready(function() {
          var i = 1;
         
          $('#addnomination').click(function() {
         
            i++;
            $('#nomination').append('<tr id="rownominee' + i + '"><td>'+ i +'</td><td><input type="text" name="nomination_name[]" class="form-control"></td><td><input type="text" name="nomination_relation[]" class="form-control"></td> <td><input type="text" name="nomination_age[]" class="form-control"></td><td><button type="button" id="' + i + '" class="btn btn-default pls btn_remove_nominee"><i class="fa fa-minus"></i></button></td></tr>');
         
          });
         
         
          $(document).on('click', '.btn_remove_nominee', function() {
            var button_id = $(this).attr("id");
            $('#rownominee' + button_id + '').remove();
          });
         
         
         
         
         
         });
         
                        
      </script>
      <script>
         $(document).ready(function(){
               $("#filladdress").on("click", function(){
                  if (this.checked)
                  {
                     $("#present_street_name").val($("#parmenent_street_name").val());
                     $("#present_city").val($("#parmenent_city").val());
                     $("#present_state").val($("#parmenent_state").val());
                     $("#emp_ps_country").val($("#parmenent_country").val());
                     $("#present_pincode").val($("#parmenent_pincode").val());
                     $("#emp_ps_village").val($("#parmenent_village").val());
                     $("#emp_ps_post_office").val($("#emp_per_post_office").val());
                       $("#emp_ps_dist").val($("#emp_per_dist").val());
                       $("#emp_ps_policestation").val($("#emp_per_policestation").val());
                     $("#emp_ps_mobile").val($("#parmenent_mobile").val());
                     $("#present_street_name").prop("readonly", true);
                     $("#present_city").prop("readonly", true);
                     $("#emp_ps_country").prop("readonly", true);
                     $("#present_state").prop("readonly", true);
                     $("#present_pincode").prop("readonly", true);
                     $("#present_mobile").prop("readonly", true);
                 }
                 else
                 {
                     $("#present_street_name").val('');
                     $("#present_city").val('');
                     $("#present_country").val('');
                     $("#present_state").val('');
                     $("#present_pincode").val('');
                     $("#present_mobile").val('');
                     $("#present_street_name").prop("readonly", false);
                     $("#present_city").prop("readonly", false);
                     $("#present_country").prop("readonly", false);
                     $("#present_state").prop("readonly", false);
                     $("#present_pincode").prop("readonly", false);
                     $("#present_mobile").prop("readonly", false);
             }
             });
         
             /*$(document).on('change','#emp_bank_name', function(e){
                var ifsccode = $('#emp_bank_name option:selected').data('ifsccode');
                $('#emp_ifsc_code').val(ifsccode);
         
             });*/
         
         
         
         
         });
                 
      </script>
      <script>
         // function showHideDiv() {
         
         // 	var radioValue = $("input[name='emp_spouse_working']:checked").val();
            // 	if(radioValue=='Employee'){
            // 		$('#govt_emp').show();
         // 		$('#spouse_quarter').show();
            // 	}else{
            // 		$('#govt_emp').hide();
         // 		$('#spouse_quarter').hide();
         
            // 	}
         
         // }
      </script>
      <script>
         function showHideDiv() {
         
            var radioValue = $("input[name='marital_status']:checked").val();
            if(radioValue=='Yes'){
               $('#marriage_date').show();
            }else{
               $('#marriage_date').hide();
         
            }
         
         }
         
         
         function addnewrow(rowid)
            {
         
         
         
               if (rowid != ''){
                     $('#add'+rowid).attr('disabled',true);
         
               }
         
         
         
               $.ajax({
         
                     url:'{{url('settings/get-add-row-item')}}/'+rowid,
                     type: "GET",
         
                     success: function(response) {
         
                        $("#marksheet").append(response);
         
                     }
                  });
            }
         
         
            function delRow(rowid)
            {
               var lastrow = $(".itemslot:last").attr("id");
                 //alert(lastrow);
                 var active_div = (lastrow-1);
                 $('#add'+active_div).attr('disabled',false);
                 $(document).on('click','.deleteButton',function() {
                     $(this).closest("tr.itemslot").remove();
                 });
         
            }
         
          function checkdepart(emp_department){
         
                  $.ajax({
               type:'GET',
               url:'{{url('employee/department-name')}}/'+emp_department,
                 cache: false,
               success: function(response){
         
         
                  document.getElementById("emp_designation").innerHTML = response;
               }
               });
            }
             function checktext(val){
         
               if ($("#check_"+val).is(":checked")==true) {
                               $('#name_' +val).show();
                           $("#check_name_"+val).prop("required", true);
         
                             } else {
                                $('#name_'+val).hide();
                             $("#check_name_"+val).prop("required", false);
                             $("#check_name_"+val).val('');
         
                             }
            }
         
         
            function addnewrowearn(rowid)
            {
         
         
         
               if (rowid != ''){
                     $('#addearn'+rowid).attr('disabled',true);
         
               }
         
         
         
               $.ajax({
         
                     url:'{{url('settings/get-add-row-earn')}}/'+rowid,
                     type: "GET",
         
                     success: function(response) {
         
                        $("#marksheetearn").append(response);
         
                     }
                  });
            }
         
         
            function delRowearn(rowid)
            {
               var lastrow = $(".itemslotpayearn:last").attr("id");
                 //alert(lastrow);
                 var active_div = (lastrow);
                 $('#addearn'+active_div).attr('disabled',false);
                 $(document).on('click','.deleteButtonearn',function() {
                     $(this).closest("tr.itemslotpayearn").remove();
                 });
         
            }
         
         
            function addnewrowdeduct(rowid)
            {
         
         
         
               if (rowid != ''){
                     $('#adddeduct'+rowid).attr('disabled',true);
         
               }
         
         
         
               $.ajax({
         
                     url:'{{url('settings/get-add-row-deduct')}}/'+rowid,
                     type: "GET",
         
                     success: function(response) {
         
                        $("#marksheetdeduct").append(response);
         
                     }
                  });
            }
         
         
            function delRowdeduct(rowid)
            {
               var lastrow = $(".itemslotpaydeduct:last").attr("id");
                 //alert(lastrow);
                 var active_div = (lastrow);
                 $('#adddeduct'+active_div).attr('disabled',false);
                 $(document).on('click','.deleteButtondeduct',function() {
                     $(this).closest("tr.itemslotpaydeduct").remove();
                 });
         
            }
         
            function checkearnvalue(val,row)
         
            {
               var emp_basic_pay=$('#emp_basic_pay').val();
            var headname=$('#name_earn'+row).val();
         
            $.ajax({
         
                     url:'{{url('settings/get-earn')}}/'+headname+'/'+val+'/'+emp_basic_pay,
                     type: "GET",
         
                     success: function(response) {
                               if(val=='F'){
                        $("#value"+row).val(Math.round(response));
                          $("#value"+row).prop("readonly", true);
                          }else{
                            $("#value"+row).val('0');
                              $("#value"+row).prop("readonly", false);
                          }
         
                     }
                  });
         
         
            }
         
            function checkdeductvalue(val,row)
         
            {
               var emp_basic_pay=$('#emp_basic_pay').val();
            var headname=$('#name_deduct'+row).val();
         
            $.ajax({
         
                     url:'{{url('settings/get-earn')}}/'+headname+'/'+val+'/'+emp_basic_pay,
                     type: "GET",
         
                     success: function(response) {
                               if(val=='F'){
                        $("#valuededuct"+row).val(Math.round(response));
                          $("#valuededuct"+row).prop("readonly", true);
                          }else{
                            $("#valuededuct"+row).val('0');
                              $("#valuededuct"+row).prop("readonly", false);
                          }
         
                     }
                  });
         
         
            }
               function onlyUnique(value, index, self) {
           return self.indexOf(value) === index;
         }
         
            function checkearninghead()
         
            {
               var ernclsarr= document.getElementsByClassName("earninigcls");
               var earningarray = new Array();
                for(i=0;i<ernclsarr.length;i++) {
                   var headname=$('#name_earn'+i).val();
                   earningarray[i]=headname;
         
                }
                var unique = earningarray.filter(onlyUnique);
         
                var deductclsarr= document.getElementsByClassName("deductcls");
               var deductarray = new Array();
                for(i=0;i<deductclsarr.length;i++) {
                   var headname=$('#name_deduct'+i).val();
                   deductarray[i]=headname;
         
                }
                var uniquededuct = deductarray.filter(onlyUnique);
         
         
         
                if(ernclsarr.length!=unique.length){
                   alert("Same Earning Selected Multiple Times");
                }
                 if(deductclsarr.length!=uniquededuct.length){
                   alert("Same Deduct Selected Multiple Times");
                }
         
                if(ernclsarr.length==unique.length && deductclsarr.length==uniquededuct.length ) {
                    document.getElementById("basicform").submit();
                }
         
         
         
               }
         
      </script>
   </body>
</html>