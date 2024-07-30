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
            <style>
               .profile_img{
               background-color: #ccc;
               width: 100px;
               height: 100px;
               border-radius: 50%;
               -moz-border-radius: 50%;
               -webkit-border-radius: 50%;
               /* margin: 0 auto; */
               float: right;
               margin-right: 20px;
               margin-top: 10px;
               padding:0px;
               overflow:hidden;
               border:2px solid #ccc;
               }
               .profile_img img{
               border-radius: 50%;
               -moz-border-radius: 50%;
               -webkit-border-radius: 50%;
               }
            </style>
           
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
                           <div class="text-right">
                              <div id="divImageMediaPreview" class="profile_img"></div>
                           </div>
                           <div class="card-body">
                              <main class="content" role="content">
                                 <section id="section1">
                                    <div class="container-fluid">
                                       <form id="regForm" action="{{url('employee/update-profile')}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          <div class="tab">
                                             <p>Personal and Service Details</p>
                                             <hr/>
                                             <input type="hidden" name="employyeId" value="<?php print_r($employee_rs->id) ?>">
                                             <input type="hidden" value="<?php if (!empty($employee_code)) {echo $employee_code;}if (request()->get('q') != '') {echo $employee_rs[0]->emp_code;}?>" placeholder="Employee Code..." class="form-control"   name="emp_code"></p>
                                             <div class="row">
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Code <span style="color: red">(*)</label>
                                                      <input type="text"  placeholder="Employee Code..." class="form-control"   name="emp_old_code" id="old_emp_code" value="<?php print_r($employee_rs->old_emp_code) ?>" readonly></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Salutation</label>
                                                      <select name="salutation" class="form-control" >
                                                         <option value="">select</option>
                                                         <option value="MR." <?php if($employee_rs->salutation=='MR.'){?> selected="selected"<?php }?> >MR.</option>
                                                         <option value="MRS." <?php if($employee_rs->salutation=='MRS.'){?> selected="selected"<?php }?>>MRS.</option>
                                                         <option value="MS." <?php if($employee_rs->salutation=='MS.'){?> selected="selected"<?php }?>>MS.</option>
                                                         <option value="DR." <?php if($employee_rs->salutation=='DR.'){?> selected="selected"<?php }?>>DR.</option>
                                                         <option value="MISS" <?php if($employee_rs->salutation=='MISS'){?> selected="selected"<?php }?>>MISS</option>
                                                      </select>
                                                      <!-- <input type="text" placeholder="Salutation..."  class="form-control" name="salutation"></p> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>First Name <span style="color:red">(*)</span></label>
                                                      <input type="text" placeholder="First Name..."  class="form-control" name="emp_fname" id="emp_fname" value="<?php print_r($employee_rs->emp_fname) ?>" required ></p>
                                                      <span id="fname"></span>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Middle Name</label>
                                                      <input type="text" placeholder="Middle Name..."  class="form-control" name="emp_mname" value="<?php print_r($employee_rs->emp_mname) ?>" ></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Last Name</label>
                                                      <input type="text" placeholder="Last Name..."  class="form-control" name="emp_lname" value="<?php print_r($employee_rs->emp_lname) ?>" ></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Father Name<span style="color:red">(*)</span></label>
                                                      <input type="text" placeholder="Father Name..."  class="form-control" id="emp_father_name" name="emp_father_name" value="<?php print_r($employee_rs->emp_father_name) ?>" ></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Spouse Name</label>
                                                      <input type="text" placeholder="Spouse Name..."  class="form-control" name="spousename" value="<?php print_r($employee_rs->spousename) ?>" ></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Email <span style="color: red">(*)</span></label>
                                                      <input type="text" placeholder="Employee Email..."  class="form-control" name="em_email" id="emp_email" value="<?php print_r($employee_rs->em_email) ?>" ></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Phone <span style="color: red">(*)</span></label>
                                                      <input type="text" placeholder="Phone Number..."  class="form-control" name="em_phone" id="emp_phone" value="<?php print_r($employee_rs->em_phone) ?>" ></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Caste</label>
                                                      <select class="form-control" name="emp_caste" >
                                                         <option>Select</option>
                                
                                                         @foreach($cast as $item)
                                                         <option value='{{ $item->cast_name }}' <?php if($employee_rs->emp_caste==$item->cast_name){?> selected="selected"<?php }?>>{{ $item->cast_name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Sub Caste</label>
                                                      <select class="form-control" name="emp_sub_caste" style="width:205px" >
                                                         <option>Select</option>
                                                         @foreach($sub_cast as $item)
                                                         <option value='{{ $item->sub_cast_name }}' <?php if($employee_rs->emp_sub_caste==$item->sub_cast_name){?> selected="selected"<?php }?>>{{ $item->sub_cast_name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Religion</label>
                                                      <select class="form-control" name="emp_religion"  style="width:205px" >
                                                         <option>Select</option>
                                                         @foreach($religion as $item)
                                                         <option value='{{ $item->religion_name }}' <?php if($employee_rs->emp_religion==$item->religion_name){?> selected="selected"<?php }?>>{{ $item->religion_name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Marital Status</label>
                                                      <select class="form-control" name="maritalstatus" style="width:205px" id="marid" onchange="MaritalChange()" >
                                                         <option>Select</option>
                                                         <option value="YES" <?php if($employee_rs->maritalstatus=='YES'){?> selected="selected"<?php }?>>YES</option>
                                                         <option value="NO" <?php if($employee_rs->maritalstatus=='NO'){?> selected="selected"<?php }?>>NO</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <div id="mariddate"></div>
                                                   </div>
                                                </div>
                                             </div>
                                             <p>Service Details</p>
                                             <hr/>
                                             <div class="row">
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Department<span style="color:red">(*)</span></label>
                                                      <select class="form-control" name="department" id="deptid" onclick="deptFunc()" >
                                                         <option></option>
                                                         @foreach($department as $dept)
                                                         <option value='{{ $dept->department_name }}' <?php if($employee_rs->department==$dept->department_name){?> selected="selected"<?php }?>>{{ $dept->department_name }}</option>
                                                         @endforeach   
                                                      </select>
                                                      <!-- <input type="text" class="form-control" name="department" placeholder="Your Department"> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Designation <span style="color:red">(*)</span></label>
                                                      <select class="form-control" id="rate_id" name="designation" required >
                                                         <option value="" selected disabled required>Select</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Date Of Birth <span style="color:red">(*)</span></label>
                                                      <input type="date" name="dateofbirth" class="form-control" id="dateofbirth" value="<?php print_r($employee_rs->dateofbirth) ?>" onchange="datefunction()" ><br/>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Date Of Retirement</label>
                                                      <input type="text" name="dateofretirement" id="dateofretirementDate" value="<?php print_r($employee_rs->dateofretirement) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Date Of Retirement BVC</label>
                                                      <input type="text" name="dateofretirementbvc" id="dateofretirementbvcid" value="<?php print_r($employee_rs->dateofretirementbvc) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Date of Joining <span style="color:red">(*)</span></label>
                                                      <input type="date" name="dateofJoining" class="form-control" id="dateofjoin" value="<?php print_r($employee_rs->dateofJoining) ?>" onchange="dateofjoinfunc()" >
                                                   </div>
                                                </div>
                                                <div id="datecon"></div>
                                               
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Next Increment Date</label>
                                                      <input type="date" name="nextincrementdate" value="<?php print_r($employee_rs->nextincrementdate) ?>"  class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Eligible for Promotion</label>
                                                      <select class="form-control" name="eligibleforpromotion" >
                                                         <option>Eligible for Promotion</option>
                                                         <option value="YES">YES</option>
                                                         <option value="NO">NO</option>
                                                      </select>
                                                      <br/>
                                                      <!-- <input type="date" name="nextincrementdate"  class="form-control"> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Type <span style="color:red">(*)</span></label>
                                                      <select name="employeetype" class="form-control" id="type" onchange="employeeFunc()" >
                                                         <option>Employee Type</option>
                                                         
                                                         @foreach($employeeType_masters as $emp)
                                                         <option value="{{$emp->employ_type_name}}" <?php if($emp->employ_type_name==$emp->employ_type_name){?> selected="selected"<?php }?>>{{$emp->employ_type_name}}</option>
                                                         @endforeach
                                                        
                                                      </select>
                                                      <!-- <input type="date" name="nextincrementdate"  class="form-control"> -->
                                                   </div>
                                                </div>
                                                <div id="reviniueDate"></div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="imageUpload">Profile Image</label>
                                                      <input type="file" class="form-control" id="ImageMedias" multiple="multiple" accept=".png, .jpg, .jpeg" name="profileimage" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Reporting Authority</label>
                                                      <select class="form-control" name="reportingauthority" >
                                                         <option>Reporting Authority</option>
                                                  
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Leave Sanctioning Authority</label>
                                                      <select class="form-control" name="leaveauthority" >
                                                         <option>Leave Sanctioning Authority</option>
                                                         <option></option>
                                                      </select>
                                                      <br/>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Grade</label>
                                                      <input type="text" name="grade" class="form-control" placeholder="Employee Grade" value="<?php print_r($employee_rs->grade) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Registration No</label>
                                                      <input type="text" name="registration_no" class="form-control" placeholder="Employee Registration No" value="<?php print_r($employee_rs->registration_no) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Registration Date</label>
                                                      <input type="date" name="registration_date" class="form-control" placeholder="Employee Registration No" value="<?php print_r($employee_rs->registration_date) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Registration Council</label>
                                                      <input type="text" name="registration_counci" class="form-control" placeholder="Employee Registration Council" value="<?php print_r($employee_rs->registration_counci) ?>" ><br/>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Employee Date Of Up Gradation</label>
                                                      <input type="date" name="date_of_up_gradation" value="<?php print_r($employee_rs->date_of_up_gradation) ?>" class="form-control" placeholder="Employee Registration No" >
                                                   </div>
                                                </div>
                                                <!-- <div class="avatar-preview">
                                                   <div id="imagePreview" style="background-image: url(https://2.bp.blogspot.com/-l9nGy2e3PnA/XLzG5A6u_cI/AAAAAAAAAgI/31bl8XZOrTwN0kTN8c18YOG3OhNiTUrsQCLcBGAs/s1600/rocket.png);">
                                                   </div>
                                                   </div>
                                                   <div id="divImageMediaPreview"></div> -->
                                             </div>
                                             <!-- </div> -->
                                           
                                          </div>
                                          <div class="tab">
                                             <div class="row">
                                                <legend>Personal Records</legend>
                                                <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                   <thead>
                                                      <tr>
                                                         <th>Sl.No.</th>
                                                         <th>Document Type</th>
                                                         <th>Document Upload</th>
                                                         <th></th>
                                                        
                                                      </tr>
                                                   </thead>
                                                   
                                                   <?php if(sizeof($EmployeePersonalRecord) == 0) {?>
                                                   
                                                   <tbody id="marksheet">
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <td>
                                                            <select class="form-control" name="document_name[]">
                                                               <option></option>
                                                               <option value="aadhar card">Aadhar Card</option>
                                                               <option value="voter">Voter Id</option>
                                                               <option value="Pan">Pan Card</option>
                                                               <option value="driving licence">Driving Licence</option>
                                                               <option value="passport">Passport</option>
                                                            </select>
                                                         </td>
                                                         <td><input type="file" name="document_upload[]" class="form-control" id="docc"></td>
                                                         <td>
                                                            <button class="btn-success" type="button" id="add1" onClick="addnewrow(1)" data-id="1"> <i class="fas fa-plus"></i> </button>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                   <?php } else { ?>
                                                    <tbody id="marksheet">
                                                      @foreach($EmployeePersonalRecord as $item)
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <input type="hidden" name="perid[]" value="<?php print_r($item->id) ?>">
                                                         <td>
                                                            <select class="form-control" name="document_name[]">
                                                               <option></option>
                                                               <option value="aadhar card" <?php if($item->document_name=='aadhar card'){?> selected="selected"<?php }?>>Aadhar Card</option>
                                                               <option value="voter" <?php if($item->document_name=='voter'){?> selected="selected"<?php }?>>Voter Id</option>
                                                               <option value="Pan" <?php if($item->document_name=='Pan'){?> selected="selected"<?php }?>>Pan Card</option>
                                                               <option value="driving licence" <?php if($item->document_name=='driving licence'){?> selected="selected"<?php }?>>Driving Licence</option>
                                                               <option value="passport" <?php if($item->document_name=='passport'){?> selected="selected"<?php }?>>Passport</option>
                                                            </select>
                                                         </td>
                                                         <td><input type="file" name="document_upload[]" class="form-control" id="docc"></td>
                                                            <td><img src="{{asset('emp_pic/'.$item->document_upload)}}" alt="none" style="height: 50px; width:50px"/></td>
                                                        
                                                      </tr>
                                                      @endforeach
                                                   </tbody>
                                                   <?php } ?>
                                                  
                                                </table>
                                                <legend>Academic & Experience Records</legend>
                                                <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                   <thead>
                                                      <tr>
                                                         <th>Sl.No.</th>
                                                         <th>Qualification</th>
                                                         <th>Board</th>
                                                         <th>Year of passing</th>
                                                         <th>Grade</th>
                                                         <th>Document Upload</th>
                                                         <th></th>
                                                        
                                                      </tr>
                                                   </thead>
                                                    <?php if(sizeof($ExperienceRecords) == 0) {?>
                                                    <tbody id="marksheet1">
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <td>
                                                            <select class="form-control" name="emp_document_name[]">
                                                               <option></option>
                                                               <option value="10 th">10 th</option>
                                                               <option value="11 th">11 th</option>
                                                               <option value="12 th">12 th</option>
                                                               <option value="BA">BA</option>
                                                               <option value="ma">Ma</option>
                                                            </select>
                                                         </td>
                                                         <td>
                                                            <input type="text" name="boardss[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="date" name="yearofpassing[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="text" name="emp_grade[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="file" name="emp_document_upload[]" class="form-control">
                                                         </td>
                                                         <td><button class="btn-success" type="button" id="add1" onClick="accademinewrow(1)" data-id="1"> <i class="fas fa-plus"></i> </button></td>
                                                      </tr>
                                                   </tbody>
                                                    <?php } else { ?>
                                                      <tbody id="marksheet1">
                                                      @foreach($ExperienceRecords as $item)
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <input type="hidden" name="erprec[]" value="<?php print_r($item->id)?>">
                                                         <td>
                                                            <select class="form-control" name="emp_document_name[]">
                                                               <option></option>
                                                               <option value="10 th" <?php if($item->emp_document_name=='10 th'){?> selected="selected"<?php }?>>10 th</option>
                                                               <option value="11 th" <?php if($item->emp_document_name=='11 th'){?> selected="selected"<?php }?>>11 th</option>
                                                               <option value="12 th" <?php if($item->emp_document_name=='12 th'){?> selected="selected"<?php }?>>12 th</option>
                                                               <option value="BA" <?php if($item->emp_document_name=='BA'){?> selected="selected"<?php }?>>BA</option>
                                                               <option value="ma" <?php if($item->emp_document_name=='ma'){?> selected="selected"<?php }?>>Ma</option>
                                                            </select>
                                                         </td>
                                                         <td>
                                                            <input type="text" name="boardss[]" class="form-control" value="<?php print_r($item->boardss) ?>">
                                                         </td>
                                                         <td>
                                                            <input type="date" name="yearofpassing[]" class="form-control" value="<?php print_r($item->yearofpassing) ?>">
                                                         </td>
                                                         <td>
                                                            <input type="text" name="emp_grade[]" class="form-control" value="<?php print_r($item->emp_grade) ?>">
                                                         </td>
                                                         <td>
                                                            <input type="file" name="emp_document_upload[]" class="form-control">
                                                         </td>
                                                         <td><img src="{{asset('emp_pic/'.$item->emp_document_upload)}}" alt="none" style="height: 50px; width:50px"/></td>
                                                         
                                                        
                                                      </tr>
                                                      @endforeach
                                                   </tbody> 
                                                    <?php } ?>
                                                   
                                                </table>
                                                <legend>Professional Records</legend>
                                                <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                   <thead>
                                                      <tr>
                                                         <th>Sl.No.</th>
                                                         <th>Organization</th>
                                                         <th>Desigination</th>
                                                         <th>From date</th>
                                                         <th>To date</th>
                                                         <th>Document Upload</th>
                                                         <th></th>
                                                
                                                      </tr>
                                                   </thead>
                                                   <?php if(sizeof($ProfessionalRecords) == 0) {?>
                                                   <tbody id="marksheet2">
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <td>
                                                            <input type="text" name="Organization[]" class="form-control" placeholder="Organization">
                                                         </td>
                                                         <td>
                                                            <input type="text" name="Desigination[]" class="form-control" placeholder="Desigination">
                                                         </td>
                                                         <td>
                                                            <input type="date" name="formdate[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="date" name="todate[]" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="file" name="emp1_document_upload[]" class="form-control">
                                                         </td>
                                                         <td><button class="btn-success" type="button" id="add1" onClick="proaddnewrow(1)" data-id="1"> <i class="fas fa-plus"></i> </button></td>
                                                      </tr>
                                                   </tbody>
                                                   <?php } else {?>
                                                    <tbody id="marksheet2">
                                                      @foreach($ProfessionalRecords as $item)
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <input type="hidden" value="<?php print_r($item->id) ?>" name="proId[]">
                                                         <td>
                                                            <input type="text" name="Organization[]" value="<?php print_r($item->Organization) ?>" class="form-control" placeholder="Organization">
                                                         </td>
                                                         <td>
                                                            <input type="text" name="Desigination[]" value="<?php print_r($item->Desigination) ?>" class="form-control" placeholder="Desigination">
                                                         </td>
                                                         <td>
                                                            <input type="date" name="formdate[]" value="<?php print_r($item->formdate) ?>" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="date" name="todate[]" value="<?php print_r($item->todate) ?>" class="form-control">
                                                         </td>
                                                         <td>
                                                            <input type="file" name="emp1_document_upload[]" class="form-control">
                                                         </td>
                                                         <td><img src="{{asset('emp_pic/'.$item->emp1_document_upload)}}" alt="none" style="height: 50px; width:50px"/></td>

                                                         
                                                      </tr>
                                                      @endforeach
                                                   </tbody>
                                                   <?php } ?>
                                                   
                                                  
                                                </table>
                                                <legend>Misc. Documents </legend>
                                                <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                   <thead>
                                                      <tr>
                                                         <th>Sl.No.</th>
                                                         <th>Category</th>
                                                         <th>Document Upload</th>
                                                         <th></th>
                                                        
                                                      </tr>
                                                   </thead>
                                                    <?php if(sizeof($MiscDocuments) == 0) {?>
                                                     <tbody id="marksheet3">
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <td>
                                                            <select class="form-control" name="emp_traning[]">
                                                               <option>Select</option>
                                                               <option value="traning">Traning</option>
                                                               <option value="legal">Legal</option>
                                                               <option value="other">other's</option>
                                                            </select>
                                                         </td>
                                                         <td>
                                                            <input type="file" name="traning1_document_upload[]" class="form-control">
                                                         </td>
                                                         <td><button class="btn-success" type="button" id="add1" onClick="Miscnewrow(1)" data-id="1"> <i class="fas fa-plus"></i> </button></td>
                                                      </tr>
                                                   </tbody>
                                                    <?php }else{ ?>
                                                     <tbody id="marksheet3">
                                                      @foreach($MiscDocuments as $item)
                                                      <tr class="itemslot" id="0">
                                                         <td>1</td>
                                                         <input type="hidden" name="miscId[]" value="<?php print_r($item->id) ?>">
                                                         <td>
                                                            <select class="form-control" name="emp_traning[]">
                                                               <option>Select</option>
                                                               <option value="traning" <?php if($item->emp_traning=='traning'){?> selected="selected"<?php }?>>Traning</option>
                                                               <option value="legal" <?php if($item->emp_traning=='legal'){?> selected="selected"<?php }?>>Legal</option>
                                                               <option value="other" <?php if($item->emp_traning=='other'){?> selected="selected"<?php }?>>other's</option>
                                                            </select>
                                                         </td>
                                                         <td>
                                                            <input type="file" name="traning1_document_upload[]" class="form-control">
                                                         </td>
                                                         <td><img src="{{asset('emp_pic/'.$item->traning1_document_upload)}}" alt="none" style="height: 50px; width:50px"/></td>
                                                         
                                                        
                                                      </tr>
                                                      @endforeach
                                                   </tbody>
                                                    <?php } ?>
                                                  
                                                </table>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <div class="row">
                                                <legend>Medical Information</legend>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Blood Group</label>
                                                      <select class="form-control" name="emp_blood_grp" >
                                                         <option value="">Select</option>
                                                         <option value="A +" <?php if($employee_rs->emp_blood_grp=='A +'){?> selected="selected"<?php }?> >A +</option>
                                                         <option value="A -"  <?php if($employee_rs->emp_blood_grp=='A -'){?> selected="selected"<?php }?>>A -</option>
                                                         <option value="B +"  <?php if($employee_rs->emp_blood_grp=='B +'){?> selected="selected"<?php }?>>B +</option>
                                                         <option value="B -"  <?php if($employee_rs->emp_blood_grp=='B -'){?> selected="selected"<?php }?>>B -</option>
                                                         <option value="AB +"  <?php if($employee_rs->emp_blood_grp=='AB +'){?> selected="selected"<?php }?>>AB +</option>
                                                         <option value="AB -"  <?php if($employee_rs->emp_blood_grp=='AB -'){?> selected="selected"<?php }?>>AB -</option>
                                                         <option value="O +" <?php if($employee_rs->emp_blood_grp=='o +'){?> selected="selected"<?php }?> >O +</option>
                                                         <option value="O -" <?php if($employee_rs->emp_blood_grp=='o -'){?> selected="selected"<?php }?> >O -</option>
                                                         <option value="Unknown" <?php if($employee_rs->emp_blood_grp=='Unknown'){?> selected="selected"<?php }?>>Unknown</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Eye Sight (Left)</label>
                                                      <input type="text" name="emp_eye_sight_left" class="form-control" value="<?php print_r($employee_rs->emp_eye_sight_left) ?>">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Eye Sight (Right)</label>
                                                      <input type="text" name="emp_eye_sight_right" value="<?php print_r($employee_rs->emp_eye_sight_right) ?>" class="form-control" id="">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label class="">Family Plan Status</label>
                                                      <select class="form-control" name="emp_family_plan_status">
                                                         <option value="">Select</option>
                                                         <option value="yes"  <?php if($employee_rs->emp_family_plan_status=='yes'){?> selected="selected"<?php }?>>yes</option>
                                                         <option value="no"  <?php if($employee_rs->emp_family_plan_status=='no'){?> selected="selected"<?php }?>>No</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Family Plan Date</span></label>
                                                      <input type="date" name="emp_family_plan_date" value="<?php print_r($employee_rs->emp_family_plan_date) ?>" class="form-control" id="">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Height (in cm)</label>
                                                      <input type="text" name="emp_height" value="<?php print_r($employee_rs->emp_height) ?>" class="form-control" id="">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label class="">Weight (in Kgs)</label><br>
                                                      <input type="text" name="emp_weight" value="<?php print_r($employee_rs->emp_weight) ?>" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Identification Mark (1)</label><br>
                                                      <input type="text" name="emp_identification_mark_one" value="<?php print_r($employee_rs->emp_identification_mark_one) ?>" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Identification Mark (2)</label><br>
                                                      <input type="text" name="emp_identification_mark_two" value="<?php print_r($employee_rs->emp_identification_mark_two) ?>" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Physically Challenged</label>
                                                      <select class="form-control" name="emp_physical_status">
                                                         <option value="no" <?php if($employee_rs->emp_physical_status=='no'){?> selected="selected"<?php }?>>No</option>
                                                         <option value="yes" <?php if($employee_rs->emp_physical_status=='yes'){?> selected="selected"<?php }?>>Yes</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <legend>Permanent Address</legend>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Street No. and Name</label>
                                                         <input type="text" name="emp_pr_street_no" value="<?php print_r($employee_rs->emp_pr_street_no) ?>" id="parmenent_street_name" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Village</label>
                                                         <input  name="emp_per_village" id="village" value="<?php print_r($employee_rs->emp_per_village) ?>" type="text" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>City</label>
                                                         <input type="text" name="emp_pr_city" value="<?php print_r($employee_rs->emp_pr_city) ?>" id="parmenent_city" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Post Office</label>
                                                         <input id="emp_per_post_office" name="emp_per_post_office" value="<?php print_r($employee_rs->emp_per_post_office) ?>" type="text" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Police Station</label>
                                                         <input type="text" id="emp_per_policestation" name="emp_per_policestation" value="<?php print_r($employee_rs->emp_per_policestation) ?>" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Pin Code <span style="color:red">(*)</span> </label>
                                                         <input id="parmenent_pincode" name="emp_pr_pincode" value="<?php print_r($employee_rs->emp_pr_pincode) ?>" type="text" class="form-control" required >
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>District</label>
                                                         <input type="text" id="emp_per_dist" name="emp_per_dist" value="<?php print_r($employee_rs->emp_per_dist)?>" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>State <span style="color:red">(*)</span></label>
                                                         <select name="emp_pr_state" id="parmenent_state" class="form-control" required>
                                                            <option value="" label="Select">Select</option>
                                                            <option value="JAMMU AND KASHMIR" <?php if($employee_rs->emp_pr_state=='JAMMU AND KASHMIR'){?> selected="selected"<?php }?>>JAMMU AND KASHMIR</option>
                                                            <option value="HIMACHAL PRADESH" <?php if($employee_rs->emp_pr_state=='HIMACHAL PRADESH'){?> selected="selected"<?php }?>>HIMACHAL PRADESH</option>
                                                            <option value="PUNJAB" <?php if($employee_rs->emp_pr_state=='PUNJAB'){?> selected="selected"<?php }?>>PUNJAB</option>
                                                            <option value="CHANDIGARH" <?php if($employee_rs->emp_pr_state=='CHANDIGARH'){?> selected="selected"<?php }?>>CHANDIGARH</option>
                                                            <option value="UTTARAKHAND" <?php if($employee_rs->emp_pr_state=='UTTARAKHAND'){?> selected="selected"<?php }?>>UTTARAKHAND</option>
                                                            <option value="HARYANA" <?php if($employee_rs->emp_pr_state=='HARYANA'){?> selected="selected"<?php }?>>HARYANA</option>
                                                            <option value="DELHI" <?php if($employee_rs->emp_pr_state=='DELHI'){?> selected="selected"<?php }?>>DELHI</option>
                                                            <option value="RAJASTHAN" <?php if($employee_rs->emp_pr_state=='RAJASTHAN'){?> selected="selected"<?php }?>>RAJASTHAN</option>
                                                            <option value="UTTAR PRADESH" <?php if($employee_rs->emp_pr_state=='UTTAR PRADESH'){?> selected="selected"<?php }?>>UTTAR PRADESH</option>
                                                            <option value="BIHAR" <?php if($employee_rs->emp_pr_state=='BIHAR'){?> selected="selected"<?php }?>>BIHAR</option>
                                                            <option value="SIKKIM" <?php if($employee_rs->emp_pr_state=='SIKKIM'){?> selected="selected"<?php }?>>SIKKIM</option>
                                                            <option value="ARUNACHAL PRADESH" <?php if($employee_rs->emp_pr_state=='ARUNACHAL PRADESH'){?> selected="selected"<?php }?>>ARUNACHAL PRADESH</option>
                                                            <option value="NAGALAND" <?php if($employee_rs->emp_pr_state=='NAGALAND'){?> selected="selected"<?php }?>>NAGALAND</option>
                                                            <option value="MANIPUR" <?php if($employee_rs->emp_pr_state=='MANIPUR'){?> selected="selected"<?php }?>>MANIPUR</option>
                                                            <option value="MIZORAM" <?php if($employee_rs->emp_pr_state=='MIZORAM'){?> selected="selected"<?php }?>>MIZORAM</option>
                                                            <option value="TRIPURA" <?php if($employee_rs->emp_pr_state=='TRIPURA'){?> selected="selected"<?php }?>>TRIPURA</option>
                                                            <option value="MEGHALAYA" <?php if($employee_rs->emp_pr_state=='MEGHALAYA'){?> selected="selected"<?php }?>>MEGHALAYA</option>
                                                            <option value="ASSAM" <?php if($employee_rs->emp_pr_state=='ASSAM'){?> selected="selected"<?php }?>>ASSAM</option>
                                                            <option value="WEST BENGAL" <?php if($employee_rs->emp_pr_state=='WEST BENGAL'){?> selected="selected"<?php }?>>WEST BENGAL</option>
                                                            <option value="JHARKHAND" <?php if($employee_rs->emp_pr_state=='JHARKHAND'){?> selected="selected"<?php }?>>JHARKHAND</option>
                                                            <option value="ODISHA" <?php if($employee_rs->emp_pr_state=='ODISHA'){?> selected="selected"<?php }?>>ODISHA</option>
                                                            <option value="CHHATTISGARH" <?php if($employee_rs->emp_pr_state=='CHHATTISGARH'){?> selected="selected"<?php }?>>CHHATTISGARH</option>
                                                            <option value="MADHYA PRADESH" <?php if($employee_rs->emp_pr_state=='MADHYA PRADESH'){?> selected="selected"<?php }?>>MADHYA PRADESH</option>
                                                            <option value="GUJARAT" <?php if($employee_rs->emp_pr_state=='GUJARAT'){?> selected="selected"<?php }?>>GUJARAT</option>
                                                            <option value="DAMAN AND DIU" <?php if($employee_rs->emp_pr_state=='DAMAN AND DIU'){?> selected="selected"<?php }?>>DAMAN AND DIU</option>
                                                            <option value="DADRA AND NAGAR HAVELI" <?php if($employee_rs->emp_pr_state=='DADRA AND NAGAR HAVELI'){?> selected="selected"<?php }?>>DADRA AND NAGAR HAVELI</option>
                                                            <option value="MAHARASHTRA" <?php if($employee_rs->emp_pr_state=='MAHARASHTRA'){?> selected="selected"<?php }?>>MAHARASHTRA</option>
                                                            <option value="ANDHRA PRADESH" <?php if($employee_rs->emp_pr_state=='ANDHRA PRADESH'){?> selected="selected"<?php }?>>ANDHRA PRADESH</option>
                                                            <option value="KARNATAKA" <?php if($employee_rs->emp_pr_state=='KARNATAKA'){?> selected="selected"<?php }?>>KARNATAKA</option>
                                                            <option value="GOA" <?php if($employee_rs->emp_pr_state=='GOA'){?> selected="selected"<?php }?>>GOA</option>
                                                            <option value="LAKSHADWEEP" <?php if($employee_rs->emp_pr_state=='LAKSHADWEEP'){?> selected="selected"<?php }?>>LAKSHADWEEP</option>
                                                            <option value="KERALA" <?php if($employee_rs->emp_pr_state=='KERALA'){?> selected="selected"<?php }?>>KERALA</option>
                                                            <option value="TAMIL NADU" <?php if($employee_rs->emp_pr_state=='TAMIL NADU'){?> selected="selected"<?php }?>>TAMIL NADU</option>
                                                            <option value="PUDUCHERRY" <?php if($employee_rs->emp_pr_state=='PUDUCHERRY'){?> selected="selected"<?php }?>>PUDUCHERRY</option>
                                                            <option value="ANDAMAN AND NICOBAR ISLANDS" <?php if($employee_rs->emp_pr_state=='ANDAMAN AND NICOBAR ISLANDS'){?> selected="selected"<?php }?>>ANDAMAN AND NICOBAR ISLANDS</option>
                                                            <option value="TELANGANA" <?php if($employee_rs->emp_pr_state=='TELANGANA'){?> selected="selected"<?php }?>>TELANGANA</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Country</label>
                                                         <input id="parmenent_country" name="emp_pr_country" value="<?php print_r($employee_rs->emp_pr_country) ?>" type="text" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-3">
                                                      <div class="form-group">
                                                         <label>Mobile No.</label>
                                                         <input type="text" id="parmenent_mobile" name="emp_pr_mobile" value="<?php print_r($employee_rs->emp_pr_mobile) ?>" class="form-control" >
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             
                                             <div class="row">
                                                <legend>
                                                   Present Address
                                                </legend>
                                                <input type="checkbox" onclick="presentFunc()">
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Street No. and Name</label>
                                                      <input type="text" name="emp_ps_street_no" id="present_street_name" value=""  class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Village</label>
                                                      <input type="text" id="emp_ps_village" name="emp_ps_village" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>City</label>
                                                      <input type="text" name="emp_ps_city" id="present_city" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Post Office</label>
                                                      <input type="text" id="emp_ps_post_office" name="emp_ps_post_office" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Police Station</label>
                                                      <input type="text" id="emp_ps_policestation" name="emp_ps_policestation" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Pin Code <span style="color: red">(*)</span></label>
                                                      <input type="text" name="emp_ps_pincode" id="present_pincode" value="" class="form-control" required>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>District</label>
                                                      <input type="text" id="emp_ps_dist" name="emp_ps_dist" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>State <span style="color: red">(*)</span></label>
                                                      <input type="text" id="stat" class="form-control"> 
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Country</label>
                                                      <input type="text" name="emp_ps_country" id="emp_ps_country" value="" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Mobile No.</label>
                                                      <input type="text" name="emp_ps_mobile" value="" id="emp_ps_mobilea" class="form-control" >
                                                   </div>
                                                </div>
                                             </div>
                                             <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Emergency / Next of Kin Contact Details </h3>
                                             <div class="row">
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelien" class="placeholder">Name</label>
                                                      <input id="inputFloatingLabelien" type="text" class="form-control input-border-bottom" name="em_name" value="<?php print_r($employee_rs->em_name) ?>">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelier" class="placeholder">Relationship</label>
                                                      <!-- onchange="crinabi(this.value);" -->
                                                      <select class="form-control input-border-bottom" id="inputFloatingLabelier" name="em_relation" onclick="crinabi(this.value);" >
                                                         <option value="">&nbsp;</option>
                                                         <option value="Father" <?php if($employee_rs->em_relation=='Father'){?> selected="selected"<?php }?> >Father</option>
                                                         <option value="Mother"  <?php if($employee_rs->em_relation=='Mother'){?> selected="selected"<?php }?>>Mother </option>
                                                         <option value="Wife"  <?php if($employee_rs->em_relation=='Wife'){?> selected="selected"<?php }?>>Wife</option>
                                                         <option value="Relatives"  <?php if($employee_rs->em_relation=='Relatives'){?> selected="selected"<?php }?>>Relatives</option>
                                                         <option value="Husband"  <?php if($employee_rs->em_relation=='Husband'){?> selected="selected"<?php }?>>Husband</option>
                                                         <option value="Partner" <?php if($employee_rs->em_relation=='Partner'){?> selected="selected"<?php }?> >Partner</option>
                                                         <option value="Son"  <?php if($employee_rs->em_relation=='Son'){?> selected="selected"<?php }?>>Son</option>
                                                         <option value="Daughter" <?php if($employee_rs->em_relation=='Daughter'){?> selected="selected"<?php }?> >Daughter</option>
                                                         <option value="Friend" <?php if($employee_rs->em_relation=='Friend'){?> selected="selected"<?php }?> >Friend</option>
                                                         <option value="Others" <?php if($employee_rs->em_relation=='Others'){?> selected="selected"<?php }?> >Others</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <!-- <div id="givedetails"></div>
                                                   <div class="col-md-3 " id="criman_new"    style="display:none;"  >
                                                      <div class="form-group">
                                                         <label for="relation_others" class="placeholder">Give Details </label>
                                                         <input id="relation_others"  type="text" class="form-control input-border-bottom" name="relation_others"   value="">
                                                      </div>
                                                   </div> -->
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabeliemail" class="placeholder">Email</label>
                                                      <input id="inputFloatingLabeliemail" type="email" class="form-control input-border-bottom" name="hel_em_email" value="<?php print_r($employee_rs->hel_em_email) ?>">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabeliem" class="placeholder">Emergency Contact No.</label>
                                                      <input id="inputFloatingLabeliem" type="text" class="form-control input-border-bottom" name="hel_em_phone" value="<?php print_r($employee_rs->hel_em_phone) ?>">
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelienad" class="placeholder">Address</label>
                                                      <input id="inputFloatingLabelienad" type="text" class="form-control input-border-bottom" name="em_address" value="<?php print_r($employee_rs->em_address) ?>">
                                                   </div>
                                                </div>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <h4 style="color: #1269db;">Passport Details</h4>
                                             <div class="row">
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabeldn" class="placeholder">Passport No.</label>
                                                      <input id="inputFloatingLabeldn" type="text" class="form-control input-border-bottom" name="pass_doc_no" value="<?php print_r($employee_rs->pass_doc_no) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
                                                      <select class="form-control input-border-bottom" id="selectFloatingLabelntp" name="pass_nat" >
                                                         <option value="">&nbsp;</option>
                                                         <option value="Afghanistan" <?php if($employee_rs->pass_nat=='Afghanistan'){?> selected="selected"<?php }?>>Afghanistan</option>
                                                         <option value="Albania" <?php if($employee_rs->pass_nat=='Albania'){?> selected="selected"<?php }?>>Albania</option>
                                                         <option value="America" <?php if($employee_rs->pass_nat=='America'){?> selected="selected"<?php }?>>America</option>
                                                         <option value="Argentina" <?php if($employee_rs->pass_nat=='Argentina'){?> selected="selected"<?php }?>>Argentina</option>
                                                         <option value="Aruba" <?php if($employee_rs->pass_nat=='Aruba'){?> selected="selected"<?php }?>>Aruba</option>
                                                         <option value="Australia" <?php if($employee_rs->pass_nat=='Australia'){?> selected="selected"<?php }?>>Australia</option>
                                                         <option value="Azerbaijan" <?php if($employee_rs->pass_nat=='Azerbaijan'){?> selected="selected"<?php }?>>Azerbaijan</option>
                                                         <option value="Bahamas" <?php if($employee_rs->pass_nat=='Bahamas'){?> selected="selected"<?php }?>>Bahamas</option>
                                                         <option value="Bahrain" <?php if($employee_rs->pass_nat=='Bahrain'){?> selected="selected"<?php }?>>Bahrain</option>
                                                         <option value="Bangladesh" <?php if($employee_rs->pass_nat=='Bangladesh'){?> selected="selected"<?php }?>>Bangladesh</option>
                                                         <option value="Barbados" <?php if($employee_rs->pass_nat=='Barbados'){?> selected="selected"<?php }?>>Barbados</option>
                                                         <option value="Belarus" <?php if($employee_rs->pass_nat=='Belarus'){?> selected="selected"<?php }?>>Belarus</option>
                                                         <option value="Belgium" <?php if($employee_rs->pass_nat=='Belgium'){?> selected="selected"<?php }?>>Belgium</option>
                                                         <option value="Beliz" <?php if($employee_rs->pass_nat=='Beliz'){?> selected="selected"<?php }?>>Beliz</option>
                                                         <option value="Bermuda" <?php if($employee_rs->pass_nat=='Bermuda'){?> selected="selected"<?php }?>>Bermuda</option>
                                                         <option value="Bolivia" <?php if($employee_rs->pass_nat=='Bolivia'){?> selected="selected"<?php }?>>Bolivia</option>
                                                         <option value="Bosnia and Herzegovina" <?php if($employee_rs->pass_nat=='Bosnia and Herzegovina'){?> selected="selected"<?php }?>>Bosnia and Herzegovina</option>
                                                         <option value="Botswana" <?php if($employee_rs->pass_nat=='Botswana'){?> selected="selected"<?php }?>>Botswana</option>
                                                         <option value="Brazil" <?php if($employee_rs->pass_nat=='Brazil'){?> selected="selected"<?php }?>>Brazil</option>
                                                         <option value="Brunei Darussalam" <?php if($employee_rs->pass_nat=='Brunei Darussalam'){?> selected="selected"<?php }?>>Brunei Darussalam</option>
                                                         <option value="Bulgaria" <?php if($employee_rs->pass_nat=='Bulgaria'){?> selected="selected"<?php }?>>Bulgaria</option>
                                                         <option value="Cambodia" <?php if($employee_rs->pass_nat=='Cambodia'){?> selected="selected"<?php }?>>Cambodia</option>
                                                         <option value="Canada" <?php if($employee_rs->pass_nat=='Canada'){?> selected="selected"<?php }?>>Canada</option>
                                                         <option value="Cayman Islands" <?php if($employee_rs->pass_nat=='Cayman Islands'){?> selected="selected"<?php }?>>Cayman Islands</option>
                                                         <option value="Chile" <?php if($employee_rs->pass_nat=='Chile'){?> selected="selected"<?php }?>>Chile</option>
                                                         <option value="China" <?php if($employee_rs->pass_nat=='China'){?> selected="selected"<?php }?>>China</option>
                                                         <option value="Colombia" <?php if($employee_rs->pass_nat=='Colombia'){?> selected="selected"<?php }?>>Colombia</option>
                                                         <option value="Costa Rica" <?php if($employee_rs->pass_nat=='Costa Rica'){?> selected="selected"<?php }?>>Costa Rica</option>
                                                         <option value="Croatia" <?php if($employee_rs->pass_nat=='Croatia'){?> selected="selected"<?php }?>>Croatia</option>
                                                         <option value="Cuba" <?php if($employee_rs->pass_nat=='Cuba'){?> selected="selected"<?php }?>>Cuba</option>
                                                         <option value="Cyprus" <?php if($employee_rs->pass_nat=='Cyprus'){?> selected="selected"<?php }?>>Cyprus</option>
                                                         <option value="Czech Republic" <?php if($employee_rs->pass_nat=='Czech Republic'){?> selected="selected"<?php }?>>Czech Republic</option>
                                                         <option value="Denmark" <?php if($employee_rs->pass_nat=='Denmark'){?> selected="selected"<?php }?>>Denmark</option>
                                                         <option value="Dominican Republic" <?php if($employee_rs->pass_nat=='Dominican Republic'){?> selected="selected"<?php }?>>Dominican Republic</option>
                                                         <option value="East Caribbean" <?php if($employee_rs->pass_nat=='East Caribbean'){?> selected="selected"<?php }?>>East Caribbean</option>
                                                         <option value="Egypt" <?php if($employee_rs->pass_nat=='Egypt'){?> selected="selected"<?php }?>>Egypt</option>
                                                         <option value="El Salvador" <?php if($employee_rs->pass_nat=='El Salvador'){?> selected="selected"<?php }?>>El Salvador</option>
                                                         <option value="Euro" <?php if($employee_rs->pass_nat=='Euro'){?> selected="selected"<?php }?>>Euro</option>
                                                         <option value="Falkland Islands" <?php if($employee_rs->pass_nat=='Falkland Islands'){?> selected="selected"<?php }?>>Falkland Islands</option>
                                                         <option value="Fiji" <?php if($employee_rs->pass_nat=='Fiji'){?> selected="selected"<?php }?>>Fiji</option>
                                                         <option value="France" <?php if($employee_rs->pass_nat=='France'){?> selected="selected"<?php }?>>France</option>
                                                         <option value="Germany" <?php if($employee_rs->pass_nat=='Germany'){?> selected="selected"<?php }?>>Germany</option>
                                                         <option value="Ghana" <?php if($employee_rs->pass_nat=='Ghana'){?> selected="selected"<?php }?>>Ghana</option>
                                                         <option value="Gibraltar" <?php if($employee_rs->pass_nat=='Gibraltar'){?> selected="selected"<?php }?>>Gibraltar</option>
                                                         <option value="Greece" <?php if($employee_rs->pass_nat=='Greece'){?> selected="selected"<?php }?>>Greece</option>
                                                         <option value="Guatemala" <?php if($employee_rs->pass_nat=='Guatemala'){?> selected="selected"<?php }?>>Guatemala</option>
                                                         <option value="Guernsey" <?php if($employee_rs->pass_nat=='Guernsey'){?> selected="selected"<?php }?>>Guernsey</option>
                                                         <option value="Guyana" <?php if($employee_rs->pass_nat=='Guyana'){?> selected="selected"<?php }?>>Guyana</option>
                                                         <option value="Holland (Netherlands)" <?php if($employee_rs->pass_nat=='Holland (Netherlands)'){?> selected="selected"<?php }?>>Holland (Netherlands)</option>
                                                         <option value="Honduras" <?php if($employee_rs->pass_nat=='Honduras'){?> selected="selected"<?php }?>>Honduras</option>
                                                         <option value="Hong Kong" <?php if($employee_rs->pass_nat=='Hong Kong'){?> selected="selected"<?php }?>>Hong Kong</option>
                                                         <option value="Hungary" <?php if($employee_rs->pass_nat=='Hungary'){?> selected="selected"<?php }?>>Hungary</option>
                                                         <option value="Iceland" <?php if($employee_rs->pass_nat=='Iceland'){?> selected="selected"<?php }?>>Iceland</option>
                                                         <option value="India" <?php if($employee_rs->pass_nat=='India'){?> selected="selected"<?php }?>>India</option>
                                                         <option value="Indonesia" <?php if($employee_rs->pass_nat=='Indonesia'){?> selected="selected"<?php }?>>Indonesia</option>
                                                         <option value="Iran" <?php if($employee_rs->pass_nat=='Iran'){?> selected="selected"<?php }?>>Iran</option>
                                                         <option value="Ireland" <?php if($employee_rs->pass_nat=='Ireland'){?> selected="selected"<?php }?>>Ireland</option>
                                                         <option value="Isle of Man" <?php if($employee_rs->pass_nat=='Isle of Man'){?> selected="selected"<?php }?>>Isle of Man</option>
                                                         <option value="Israel" <?php if($employee_rs->pass_nat=='Israel'){?> selected="selected"<?php }?>>Israel</option>
                                                         <option value="Italy" <?php if($employee_rs->pass_nat=='Italy'){?> selected="selected"<?php }?>>Italy</option>
                                                         <option value="Jamaica" <?php if($employee_rs->pass_nat=='Jamaica'){?> selected="selected"<?php }?>>Jamaica</option>
                                                         <option value="Japan" <?php if($employee_rs->pass_nat=='Japan'){?> selected="selected"<?php }?>>Japan</option>
                                                         <option value="Jersey" <?php if($employee_rs->pass_nat=='Jersey'){?> selected="selected"<?php }?>>Jersey</option>
                                                         <option value="Kazakhstan" <?php if($employee_rs->pass_nat=='Kazakhstan'){?> selected="selected"<?php }?>>Kazakhstan</option>
                                                         <option value="Korea (North)" <?php if($employee_rs->pass_nat=='Korea (North)'){?> selected="selected"<?php }?>>Korea (North)</option>
                                                         <option value="Korea (South)" <?php if($employee_rs->pass_nat=='Korea (South)'){?> selected="selected"<?php }?>>Korea (South)</option>
                                                         <option value="Kyrgyzstan" <?php if($employee_rs->pass_nat=='Kyrgyzstan'){?> selected="selected"<?php }?>>Kyrgyzstan</option>
                                                         <option value="Laos" <?php if($employee_rs->pass_nat=='Laos'){?> selected="selected"<?php }?>>Laos</option>
                                                         <option value="Latvia" <?php if($employee_rs->pass_nat=='Latvia'){?> selected="selected"<?php }?>>Latvia</option>
                                                         <option value="Lebanon" <?php if($employee_rs->pass_nat=='Lebanon'){?> selected="selected"<?php }?>>Lebanon</option>
                                                         <option value="Liberia" <?php if($employee_rs->pass_nat=='Liberia'){?> selected="selected"<?php }?>>Liberia</option>
                                                         <option value="Libya" <?php if($employee_rs->pass_nat=='Libya'){?> selected="selected"<?php }?>>Libya</option>
                                                         <option value="Liechtenstein" <?php if($employee_rs->pass_nat=='Liechtenstein'){?> selected="selected"<?php }?>>Liechtenstein</option>
                                                         <option value="Lithuania" <?php if($employee_rs->pass_nat=='Lithuania'){?> selected="selected"<?php }?>>Lithuania</option>
                                                         <option value="Luxembourg" <?php if($employee_rs->pass_nat=='Luxembourg'){?> selected="selected"<?php }?>>Luxembourg</option>
                                                         <option value="Macedonia" <?php if($employee_rs->pass_nat=='Macedonia'){?> selected="selected"<?php }?>>Macedonia</option>
                                                         <option value="Malaysia" <?php if($employee_rs->pass_nat=='Malaysia'){?> selected="selected"<?php }?>>Malaysia</option>
                                                         <option value="Malta" <?php if($employee_rs->pass_nat=='Malta'){?> selected="selected"<?php }?>>Malta</option>
                                                         <option value="Mauritius" <?php if($employee_rs->pass_nat=='Mauritius'){?> selected="selected"<?php }?>>Mauritius</option>
                                                         <option value="Mexico" <?php if($employee_rs->pass_nat=='Mexico'){?> selected="selected"<?php }?>>Mexico</option>
                                                         <option value="Mongolia" <?php if($employee_rs->pass_nat=='Mongolia'){?> selected="selected"<?php }?>>Mongolia</option>
                                                         <option value="Mozambique" <?php if($employee_rs->pass_nat=='Mozambique'){?> selected="selected"<?php }?>>Mozambique</option>
                                                         <option value="Myanmar" <?php if($employee_rs->pass_nat=='Myanmar'){?> selected="selected"<?php }?>>Myanmar</option>
                                                         <option value="Namibia" <?php if($employee_rs->pass_nat=='Namibia'){?> selected="selected"<?php }?>>Namibia</option>
                                                         <option value="Nepal" <?php if($employee_rs->pass_nat=='Nepal'){?> selected="selected"<?php }?>>Nepal</option>
                                                         <option value="Netherlands" <?php if($employee_rs->pass_nat=='Netherlands'){?> selected="selected"<?php }?>>Netherlands</option>
                                                         <option value="Netherlands Antilles" <?php if($employee_rs->pass_nat=='Netherlands Antilles'){?> selected="selected"<?php }?>>Netherlands Antilles</option>
                                                         <option value="New Zealand" <?php if($employee_rs->pass_nat=='New Zealand'){?> selected="selected"<?php }?>>New Zealand</option>
                                                         <option value="Nicaragua" <?php if($employee_rs->pass_nat=='Nicaragua'){?> selected="selected"<?php }?>>Nicaragua</option>
                                                         <option value="Nigeria" <?php if($employee_rs->pass_nat=='Nigeria'){?> selected="selected"<?php }?>>Nigeria</option>
                                                         <option value="North Korea" <?php if($employee_rs->pass_nat=='North Korea'){?> selected="selected"<?php }?>>North Korea</option>
                                                         <option value="Norway" <?php if($employee_rs->pass_nat=='Norway'){?> selected="selected"<?php }?>>Norway</option>
                                                         <option value="Oman" <?php if($employee_rs->pass_nat=='Oman'){?> selected="selected"<?php }?>>Oman</option>
                                                         <option value="Pakistan" <?php if($employee_rs->pass_nat=='Pakistan'){?> selected="selected"<?php }?>>Pakistan</option>
                                                         <option value="Panama" <?php if($employee_rs->pass_nat=='Panama'){?> selected="selected"<?php }?>>Panama</option>
                                                         <option value="Paraguay" <?php if($employee_rs->pass_nat=='Paraguay'){?> selected="selected"<?php }?>>Paraguay</option>
                                                         <option value="Peru" <?php if($employee_rs->pass_nat=='Peru'){?> selected="selected"<?php }?>>Peru</option>
                                                         <option value="Philippines" <?php if($employee_rs->pass_nat=='Philippines'){?> selected="selected"<?php }?>>Philippines</option>
                                                         <option value="Poland" <?php if($employee_rs->pass_nat=='Poland'){?> selected="selected"<?php }?>>Poland</option>
                                                         <option value="Portugal" <?php if($employee_rs->pass_nat=='Portugal'){?> selected="selected"<?php }?>>Portugal</option>
                                                         <option value="Qatar" <?php if($employee_rs->pass_nat=='Qatar'){?> selected="selected"<?php }?>>Qatar</option>
                                                         <option value="Republic of Uganda" <?php if($employee_rs->pass_nat=='Republic of Uganda'){?> selected="selected"<?php }?>>Republic of Uganda</option>
                                                         <option value="Romania" <?php if($employee_rs->pass_nat=='Romania'){?> selected="selected"<?php }?>>Romania</option>
                                                         <option value="Russia" <?php if($employee_rs->pass_nat=='Russia'){?> selected="selected"<?php }?>>Russia</option>
                                                         <option value="Saint Helena" <?php if($employee_rs->pass_nat=='Saint Helena'){?> selected="selected"<?php }?>>Saint Helena</option>
                                                         <option value="Saudi Arabia" <?php if($employee_rs->pass_nat=='Saudi Arabia'){?> selected="selected"<?php }?>>Saudi Arabia</option>
                                                         <option value="Serbia" <?php if($employee_rs->pass_nat=='Serbia'){?> selected="selected"<?php }?>>Serbia</option>
                                                         <option value="Seychelles" <?php if($employee_rs->pass_nat=='Seychelles'){?> selected="selected"<?php }?>>Seychelles</option>
                                                         <option value="Singapore" <?php if($employee_rs->pass_nat=='Singapore'){?> selected="selected"<?php }?>>Singapore</option>
                                                         <option value="Slovakia" <?php if($employee_rs->pass_nat=='Slovenia'){?> selected="selected"<?php }?>>Slovakia</option>
                                                         <option value="Slovenia" <?php if($employee_rs->pass_nat=='Slovenia'){?> selected="selected"<?php }?>>Slovenia</option>
                                                         <option value="Solomon Islands" <?php if($employee_rs->pass_nat=='Solomon Islands'){?> selected="selected"<?php }?>>Solomon Islands</option>
                                                         <option value="Somalia" <?php if($employee_rs->pass_nat=='Somalia'){?> selected="selected"<?php }?>>Somalia</option>
                                                         <option value="South Africa" <?php if($employee_rs->pass_nat=='South Africa'){?> selected="selected"<?php }?>>South Africa</option>
                                                         <option value="South Korea" <?php if($employee_rs->pass_nat=='South Korea'){?> selected="selected"<?php }?>>South Korea</option>
                                                         <option value="Spain" <?php if($employee_rs->pass_nat=='Spain'){?> selected="selected"<?php }?>>Spain</option>
                                                         <option value="Sri Lanka" <?php if($employee_rs->pass_nat=='Sri Lanka'){?> selected="selected"<?php }?>>Sri Lanka</option>
                                                         <option value="State of Eritrea" <?php if($employee_rs->pass_nat=='State of Eritrea'){?> selected="selected"<?php }?>>State of Eritrea</option>
                                                         <option value="Sudan" <?php if($employee_rs->pass_nat=='Sudan'){?> selected="selected"<?php }?>>Sudan</option>
                                                         <option value="Suriname" <?php if($employee_rs->pass_nat=='Suriname'){?> selected="selected"<?php }?>>Suriname</option>
                                                         <option value="Sweden" <?php if($employee_rs->pass_nat=='Sweden'){?> selected="selected"<?php }?>>Sweden</option>
                                                         <option value="Switzerland" <?php if($employee_rs->pass_nat=='Switzerland'){?> selected="selected"<?php }?>>Switzerland</option>
                                                         <option value="Syria" <?php if($employee_rs->pass_nat=='Syria'){?> selected="selected"<?php }?>>Syria</option>
                                                         <option value="Taiwan" <?php if($employee_rs->pass_nat=='Taiwan'){?> selected="selected"<?php }?>>Taiwan</option>
                                                         <option value="Thailand" <?php if($employee_rs->pass_nat=='Thailand'){?> selected="selected"<?php }?>>Thailand</option>
                                                         <option value="Trinidad and Tobago" <?php if($employee_rs->pass_nat=='Trinidad and Tobago'){?> selected="selected"<?php }?>>Trinidad and Tobago</option>
                                                         <option value="Turkey" <?php if($employee_rs->pass_nat=='Turkey'){?> selected="selected"<?php }?>>Turkey</option>
                                                         <option value="Turkey" <?php if($employee_rs->pass_nat=='Turkey'){?> selected="selected"<?php }?>>Turkey</option>
                                                         <option value="Tuvalu" <?php if($employee_rs->pass_nat=='Tuvalu'){?> selected="selected"<?php }?>>Tuvalu</option>
                                                         <option value="Ukraine" <?php if($employee_rs->pass_nat=='Ukraine'){?> selected="selected"<?php }?>>Ukraine</option>
                                                         <option value="United Arab Emirates" <?php if($employee_rs->pass_nat=='United Arab Emirates'){?> selected="selected"<?php }?>>United Arab Emirates</option>
                                                         <option value="United Kingdom" <?php if($employee_rs->pass_nat=='United Kingdom'){?> selected="selected"<?php }?>>United Kingdom</option>
                                                         <option value="United States of America" <?php if($employee_rs->pass_nat=='United States of America'){?> selected="selected"<?php }?>>United States of America</option>
                                                         <option value="Uruguay" <?php if($employee_rs->pass_nat=='Uruguay'){?> selected="selected"<?php }?>>Uruguay</option>
                                                         <option value="Uzbekistan" <?php if($employee_rs->pass_nat=='Uzbekistan'){?> selected="selected"<?php }?>>Uzbekistan</option>
                                                         <option value="Vatican City" <?php if($employee_rs->pass_nat=='Vatican City'){?> selected="selected"<?php }?>>Vatican City</option>
                                                         <option value="Venezuela" <?php if($employee_rs->pass_nat=='Venezuela'){?> selected="selected"<?php }?>>Venezuela</option>
                                                         <option value="Vietnam" <?php if($employee_rs->pass_nat=='Vietnam'){?> selected="selected"<?php }?>>Vietnam</option>
                                                         <option value="Yemen" <?php if($employee_rs->pass_nat=='Yemen'){?> selected="selected"<?php }?>>Yemen</option>
                                                         <option value="Zimbabwe" <?php if($employee_rs->pass_nat=='Zimbabwe'){?> selected="selected"<?php }?>>Zimbabwe</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>
                                                      <input id="inputFloatingLabelpb" type="text" class="form-control input-border-bottom" name="place_birth" value="<?php print_r($employee_rs->place_birth) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelib" class="placeholder">Issued By</label>
                                                      <input id="inputFloatingLabelib" type="text" class="form-control input-border-bottom"  name="issue_by" value="<?php print_r($employee_rs->issue_by) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group" >
                                                      <label for="inputFloatingLabelid" class="placeholder">Issued Date</label>
                                                      <input id="inputFloatingLabelid" type="date" class="form-control input-border-bottom" name="pas_iss_date" value="<?php print_r($employee_rs->pas_iss_date) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="pass_exp_date" class="placeholder">Expiry Date</label>
                                                      <input id="pass_exp_date" type="date" class="form-control input-border-bottom" onchange="getreviewdate();" name="pass_exp_date" value="<?php print_r($employee_rs->pass_exp_date) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="pass_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
                                                      <input id="pass_review_date" type="text" class="form-control input-border-bottom"  name="pass_review_date"  value="<?php print_r($employee_rs->pass_review_date) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Upload Document</label>
                                                      <a href="https://climbr.co.in/public/employee_doc/jbfH0cM2hcjMHEseG1LGtARb0CJGnKB6jj6EHPra.jpg" target="_blank" download />download</a>
                                                      </br>
                                                      <input type="file" class="form-control"  name="pass_docu"  id="pass_docu" onchange="Filevalidationdopassdocu()" >
                                                      <small> Please select  file which size up to 2mb</small>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-check">
                                                      <label>Is this your current passport?</label><br>
                                                      <!--<label class="form-radio-label">-->
                                                      <!--<input class="form-radio-input" type="radio" name="cur_pass" value="Yes" checked>-->
                                                      <!--<span class="form-radio-sign">Yes</span>-->
                                                      <!--</label>-->
                                                      <!--<label class="form-radio-label ml-3">-->
                                                      <!--<input class="form-radio-input" type="radio" name="cur_passss" value="No" >-->
                                                      <!--<span class="form-radio-sign">No</span>-->
                                                      <!--</label>-->
                                                      <input type="radio" id="html" name="cur_pass" value="Yes"><br/>
                                                     <label for="html">Yes</label>
                                                     <input type="radio" id="css" name="cur_pass" value="No"><br/>
                                                     <label for="css">No</label>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelrm" class="placeholder">Remarks</label>
                                                      <input id="inputFloatingLabelrm" type="text" class="form-control input-border-bottom" name="remarks" value="<?php print_r($employee_rs->remarks) ?>" >
                                                   </div>
                                                </div>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <legend>Pay Details</legend>
                                             <div class="row">
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Class Name <span style="color:red">(*)</span></label>
                                                      <select data-placeholder="Choose a Groupe..." name="emp_group" class="form-control" id="emp_group" required >
                                                         <option value="" label="Select">Select</option>
                                                         <option value="1" <?php if($employee_rs->emp_group=='1'){?> selected="selected"<?php }?>>1  PERMANENT OUT GRADED</option>
                                                         <option value="2" <?php if($employee_rs->emp_group=='2'){?> selected="selected"<?php }?>>2-PERMANENT GRADED STAFF</option>
                                                         <option value="4" <?php if($employee_rs->emp_group=='4'){?> selected="selected"<?php }?>>3-PERMANENT GRADED SUB STAFF</option>
                                                         <option value="5" <?php if($employee_rs->emp_group=='5'){?> selected="selected"<?php }?>>4- CONTRACT STAFF</option>
                                                         <option value="6" <?php if($employee_rs->emp_group=='6'){?> selected="selected"<?php }?>>5   PERMANENT NEW GRADED</option>
                                                         <option value="7" <?php if($employee_rs->emp_group=='7'){?> selected="selected"<?php }?>>6- NEW NURSING STAFF</option>
                                                         <option value="8" <?php if($employee_rs->emp_group=='8'){?> selected="selected"<?php }?>>7- DURWAN</option>
                                                         <option value="9" <?php if($employee_rs->emp_group=='9'){?> selected="selected"<?php }?>>8- PBIN STAFF</option>
                                                         <option value="10" <?php if($employee_rs->emp_group=='10'){?> selected="selected"<?php }?>>9 NEW GRADED SUB STAFF</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Basic Pay <span style="color:red">(*)</span></label>
                                                      <input type="number" step="any" id="emp_basic_pay" name="emp_basic_pay" value="<?php print_r($EmployeePayStructure->basic_pay) ?>" class="form-control"  oninput="basicpay()" required >
                                                      <!-- <select class="form-control" name="emp_basic_pay" id="emp_basic_pay" required>
                                                         </select> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>APF Deduction Rate (%) <span style="color:red">(*)</span></label>
                                                      <input type="number" step="any" id="emp_apf_percent" name="emp_apf_percent" value="<?php print_r($EmployeePayStructure->apf_percent) ?>" class="form-control" required >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>PF Type <span style="color:red">(*)</span></label>
                                                      <select data-placeholder="Choose a PF..." name="emp_pf_type" id="emp_pf_type" class="form-control" required >
                                                         <option value="" label="Select">Select</option>
                                                         <option value="nps"  <?php if($employee_rs->pf_type=='nps'){?> selected="selected"<?php }?>>NPS</option>
                                                         <option value="gpf"  <?php if($employee_rs->pf_type=='gpf'){?> selected="selected"<?php }?>>PF</option>
                                                         <option value="cpf"  <?php if($employee_rs->pf_type=='cpf'){?> selected="selected"<?php }?>>CPF </option>
                                                         <option value="na"  <?php if($employee_rs->pf_type=='na'){?> selected="selected"<?php }?>>NA </option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Passport No.</label>
                                                      <input type="text" name="emp_passport_no" value="<?php print_r($employee_rs->emp_passport_no) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <!-- <div class="col-md-3">
                                                   <label>Pension Payment Order (PPO).</label>
                                                           <input type="hidden" name="emp_pension_no" value=""  class="form-control" >
                                                   </div> -->
                                                <!-- </div>
                                                   <div class="row form-group"> -->
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>PF No. </label>
                                                      <input type="text" name="emp_pf_no" value="<?php print_r($employee_rs->emp_pf_no) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>UAN No. </label>
                                                      <input type="text" name="emp_uan_no" value="<?php print_r($employee_rs->emp_uan_no) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>PAN No.</label>
                                                      <input type="text" name="emp_pan_no" value="<?php print_r($employee_rs->emp_pan_no) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Bank Name <span style="color:red">(*)</span></label>
                                                      <select class="form-control" name="emp_bank_name" id="emp_bank_name" required onclick="populateBranch()" >
                                                          @foreach($MastersbankName as $item)
                                                         <option value="{{$item->id}}" <?php if( $item->emp_bank_name==$item->master_bank_name){?> selected="selected"<?php }?>>{{$item->master_bank_name}}</option>
                                                         @endforeach
                                                         <!--<option value="{{$employee_rs->emp_bank_name}}">{{$employee_rs->emp_bank_name}}</option>-->
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Branch <span style="color:red">(*)</span></label>
                                                      <select class="form-control" id="bank_branch_ids" name="bank_branch_id" onclick="branchfunc()" required >
                                                         <option value="{{$employee_rs->bank_branch_id}}">{{$employee_rs->bank_branch_id}}</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>IFSC Code <span style="color:red">(*)</span></label>
                                                      <!-- <input type="text" name="emp_ifsc_code" value="" id="emp_ifsc_code" class="form-control"  required> -->
                                                      <select class="form-control" id="emp_ifsc_code" name="emp_ifsc_code" required >
                                                         <option value="{{$employee_rs->emp_ifsc_code}}">{{$employee_rs->emp_ifsc_code}}</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Account No. <span style="color:red">(*)</span></label>
                                                      <input type="text" name="emp_account_no" id="emp_account_no" value="<?php print_r($employee_rs->emp_account_no) ?>" class="form-control" required >
                                                   </div>
                                                </div>
         
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Aadhaar No. </label>
                                                      <input type="text" name="emp_aadhar_no" value="<?php print_r($employee_rs->emp_aadhar_no) ?>" class="form-control" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Eligible For Pension </label>
                                                      <input type="text" class="form-control" name="emp_pension" id="emp_pension" value="<?php print_r($employee_rs->emp_pension) ?>" >
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Basic above 15K @ 12% PF </label>
                                                      <select class="form-control" name="emp_pf_inactuals" id="emp_pf_inactuals" required >
                                                         <option value="">Select</option>
                                                         <option value="Y" <?php if($employee_rs->emp_pf_inactuals=='Y'){?> selected="selected"<?php }?>>Yes</option>
                                                         <option value="N" <?php if($employee_rs->emp_pf_inactuals=='N'){?> selected="selected"<?php }?>>No</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-3">
                                                   <div class="form-group">
                                                      <label>Eligible For Bonus </label>
                                                      <select class="form-control" name="emp_bonus" id="emp_bonus" required >
                                                         <option value="">Select</option>
                                                         <option value="Y" <?php if($employee_rs->emp_bonus=='Y'){?> selected="selected"<?php }?>>Yes</option>
                                                         <option value="N" <?php if($employee_rs->emp_bonus=='N'){?> selected="selected"<?php }?>>No</option>
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <div class="row">
                                                <legend>Pay Structure</legend>
                                                <h3 class="ad">Earning</h3>
                                                <!-- <div class="addi"> -->
                                                   <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                      <thead>
                                                         <tr>
                                                            <th>Sl.No.</th>
                                                            <th>Head Name</th>
                                                            <th>Head Type</th>
                                                            <th>Value</th>
                                                             <th></th>
                                          
                                                         </tr>
                                                      </thead>
                                                      <?php
                                          $arr_name = array();
                                          $arr_type = array();
                                          $arr_value = array();
                                          $arr_name_deduct = array();
                                          $arr_type_deduct = array();
                                          $arr_value_deduct = array();
                                          // print_r($emp_pay_st->pf);die;
                                          if ($emp_pay_st->da != '') {
                                          
                                         
                                              $arr_name[] = 'da';
                                              $arr_value['da'] = $emp_pay_st->da;
                                              $arr_type['da_type'] = $emp_pay_st->da_type;
                                          
                                          }if ($emp_pay_st->vda != '') {
                                              $arr_name[] = 'vda';
                                              $arr_value['vda'] = $emp_pay_st->vda;
                                              $arr_type['vda_type'] = $emp_pay_st->vda_type;
                                          }if ($emp_pay_st->hra != '') {
                                              $arr_name[] = 'hra';
                                              $arr_value['hra'] = $emp_pay_st->hra;
                                              $arr_type['hra_type'] = $emp_pay_st->hra_type;
                                          
                                          }if ($emp_pay_st->others_alw != '') {
                                              $arr_name[] = 'others_alw';
                                              $arr_value['others_alw'] = $emp_pay_st->others_alw;
                                              $arr_type['others_alw_type'] = $emp_pay_st->others_alw_type;
                                          }if ($emp_pay_st->tiff_alw != '') {
                                              $arr_name[] = 'tiff_alw';
                                              $arr_value['tiff_alw'] = $emp_pay_st->tiff_alw;
                                              $arr_type['tiff_alw_type'] = $emp_pay_st->tiff_alw_type;
                                          }if ($emp_pay_st->conv != '') {
                                              $arr_name[] = 'conv';
                                              $arr_value['conv'] = $emp_pay_st->conv;
                                              $arr_type['conv_type'] = $emp_pay_st->conv_type;
                                          }if ($emp_pay_st->medical != '') {
                                              $arr_name[] = 'medical';
                                              $arr_value['medical'] = $emp_pay_st->medical;
                                              $arr_type['medical_type'] = $emp_pay_st->medical_type;
                                          }if ($emp_pay_st->misc_alw != '') {
                                              $arr_name[] = 'misc_alw';
                                              $arr_value['misc_alw'] = $emp_pay_st->misc_alw;
                                              $arr_type['misc_alw_type'] = $emp_pay_st->misc_alw_type;
                                          }if ($emp_pay_st->over_time != '') {
                                              $arr_name[] = 'over_time';
                                              $arr_value['over_time'] = $emp_pay_st->over_time;
                                              $arr_type['over_time_type'] = $emp_pay_st->over_time_type;
                                          }if ($emp_pay_st->bouns != '') {
                                              $arr_name[] = 'bouns';
                                              $arr_value['bouns'] = $emp_pay_st->bouns;
                                              $arr_type['bouns_type'] = $emp_pay_st->bouns_type;
                                          }if ($emp_pay_st->leave_inc != '') {
                                              $arr_name[] = 'leave_inc';
                                              $arr_value['leave_inc'] = $emp_pay_st->leave_inc;
                                              $arr_type['leave_inc_type'] = $emp_pay_st->leave_inc_type;
                                          
                                          }if ($emp_pay_st->hta != '') {
                                              $arr_name[] = 'hta';
                                              $arr_value['hta'] = $emp_pay_st->hta;
                                              $arr_type['hta_type'] = $emp_pay_st->hta_type;
                                          
                                          }if ($emp_pay_st->prof_tax != '') {
                                              $arr_name_deduct[] = 'prof_tax';
                                              $arr_value_deduct['prof_tax'] = $emp_pay_st->prof_tax;
                                              $arr_type_deduct['prof_tax_type'] = $emp_pay_st->prof_tax_type;
                                          
                                          }if ($emp_pay_st->pf != '') {
                                              $arr_name_deduct[] = 'pf';
                                              $arr_value_deduct['pf'] = $emp_pay_st->pf;
                                              $arr_type_deduct['pf_type'] = $emp_pay_st->pf_type;
                                          
                                          }if ($emp_pay_st->pf_int != '') {
                                              $arr_name_deduct[] = 'pf_int';
                                              $arr_value_deduct['pf_int'] = $emp_pay_st->pf_int;
                                              $arr_type_deduct['pf_int_type'] = $emp_pay_st->pf_int_type;
                                          
                                          }if ($emp_pay_st->apf != '') {
                                              $arr_name_deduct[] = 'apf';
                                              $arr_value_deduct['apf'] = $emp_pay_st->apf;
                                              $arr_type_deduct['apf_type'] = $emp_pay_st->apf_type;
                                          
                                          }if ($emp_pay_st->i_tax != '') {
                                              $arr_name_deduct[] = 'i_tax';
                                              $arr_value_deduct['i_tax'] = $emp_pay_st->i_tax;
                                              $arr_type_deduct['i_tax_type'] = $emp_pay_st->i_tax_type;
                                          
                                          }if ($emp_pay_st->insu_prem != '') {
                                              $arr_name_deduct[] = 'insu_prem';
                                              $arr_value_deduct['insu_prem'] = $emp_pay_st->insu_prem;
                                              $arr_type_deduct['insu_prem_type'] = $emp_pay_st->insu_prem_type;
                                          
                                          }if ($emp_pay_st->pf_loan != '') {
                                              $arr_name_deduct[] = 'pf_loan';
                                              $arr_value_deduct['pf_loan'] = $emp_pay_st->pf_loan;
                                              $arr_type_deduct['pf_loan_type'] = $emp_pay_st->pf_loan_type;
                                          
                                          }if ($emp_pay_st->esi != '') {
                                              $arr_name_deduct[] = 'esi';
                                              $arr_value_deduct['esi'] = $emp_pay_st->esi;
                                              $arr_type_deduct['esi_type'] = $emp_pay_st->esi_type;
                                          
                                          }if ($emp_pay_st->adv != '') {
                                              $arr_name_deduct[] = 'adv';
                                              $arr_value_deduct['adv'] = $emp_pay_st->adv;
                                              $arr_type_deduct['adv_type'] = $emp_pay_st->adv_type;
                                          
                                          }if ($emp_pay_st->hrd != '') {
                                              $arr_name_deduct[] = 'hrd';
                                              $arr_value_deduct['hrd'] = $emp_pay_st->hrd;
                                              $arr_type_deduct['hrd_type'] = $emp_pay_st->hrd_type;
                                          
                                          }if ($emp_pay_st->co_op != '') {
                                              $arr_name_deduct[] = 'co_op';
                                              $arr_value_deduct['co_op'] = $emp_pay_st->co_op;
                                              $arr_type_deduct['co_op_type'] = $emp_pay_st->co_op_type;
                                          
                                          }
                                          if ($emp_pay_st->furniture != '') {
                                              $arr_name_deduct[] = 'furniture';
                                              $arr_value_deduct['furniture'] = $emp_pay_st->furniture;
                                              $arr_type_deduct['furniture_type'] = $emp_pay_st->furniture_type;
                                          
                                          }
                                          if ($emp_pay_st->pf_employerc != '') {
                                              $arr_name_deduct[] = 'pf_employerc';
                                              $arr_value_deduct['pf_employerc'] = $emp_pay_st->pf_employerc;
                                              $arr_type_deduct['pf_employerc_type'] = $emp_pay_st->pf_employerc_type;
                                          
                                          }
                                          if ($emp_pay_st->misc_ded != '') {
                                              $arr_name_deduct[] = 'misc_ded';
                                              $arr_value_deduct['misc_ded'] = $emp_pay_st->misc_ded;
                                              $arr_type_deduct['misc_ded_type'] = $emp_pay_st->misc_ded_type;
                                          
                                          }
                                          
                                          ?>
                                          
                                                        <tbody id="marksheetearn">
                                                        <?php $tr_id = 0;?>
                                                        
                                                        @if(count($arr_name)!=0)
                                                           @foreach($arr_name as $valearn)
                                                          <tr class="itemslotpayearn" id="<?php echo $tr_id; ?>">
                                                                              <td><?php echo ($tr_id + 1); ?></td>
                                                                              <td>
                                          
                                                                     <select class="form-control earninigcls" name="name_earn[]" id="name_earn<?php echo $tr_id; ?>" onchange="checkearntype(this.value,<?php echo $tr_id; ?>);">
                                          
                                                                     <option value='' selected>Select</option>
                                                                     <?php
                                          $name = '';
                                          ?>
                                          @foreach($rate_master as $value)
                                          <?php
                                          if ($value->id == '1') {
                                              $name = 'da';
                                          } else if ($value->id == '2') {
                                              $name = 'vda';
                                          } else if ($value->id == '3') {
                                              $name = 'hra';
                                          } else if ($value->id == '4') {
                                              $name = 'prof_tax';
                                          } else if ($value->id == '5') {
                                              $name = 'others_alw';
                                          } else if ($value->id == '6') {
                                              $name = 'tiff_alw';
                                          } else if ($value->id == '7') {
                                              $name = 'conv';
                                          } else if ($value->id == '8') {
                                              $name = 'medical';
                                          } else if ($value->id == '9') {
                                              $name = 'misc_alw';
                                          } else if ($value->id == '10') {
                                              $name = 'over_time';
                                          } else if ($value->id == '11') {
                                              $name = 'bouns';
                                          } else if ($value->id == '12') {
                                              $name = 'leave_inc';
                                          } else if ($value->id == '13') {
                                              $name = 'hta';
                                          } else if ($value->id == '14') {
                                              $name = 'tot_inc';
                                          } else if ($value->id == '15') {
                                              $name = 'pf';
                                          } else if ($value->id == '16') {
                                              $name = 'pf_int';
                                          } else if ($value->id == '17') {
                                              $name = 'apf';
                                          } else if ($value->id == '18') {
                                              $name = 'i_tax';
                                          } else if ($value->id == '19') {
                                              $name = 'insu_prem';
                                          } else if ($value->id == '20') {
                                              $name = 'pf_loan';
                                          } else if ($value->id == '21') {
                                              $name = 'esi';
                                          } else if ($value->id == '22') {
                                              $name = 'adv';
                                          } else if ($value->id == '23') {
                                              $name = 'hrd';
                                          } else if ($value->id == '24') {
                                              $name = 'co_op';
                                          } else if ($value->id == '25') {
                                              $name = 'furniture';
                                          } else if ($value->id == '26') {
                                              $name = 'misc_ded';
                                          } else if ($value->id == '27') {
                                              $name = 'tot_ded';
                                          
                                          } else if ($value->id == '29') {
                                              $name = 'pf_employerc';
                                          }
                                          ?>
                                                   @if($value->head_type == 'earning')
                                                                     <option value='{{$name}}' @if($name== $valearn) selected @endif>{{ $value->head_name }}</option>
                                                                     @endif
                                                                     @endforeach
                                                                     </select>
                                          
                                                                  </td>
                                                                              <td><select class="form-control" name="head_type[]" id="head_type<?php echo $tr_id; ?>" onchange="checkearnvalue(this.value,<?php echo $tr_id; ?>);">
                                          
                                                                     <option value='' selected>Select</option>
                                                                     <option value='F' @if( $arr_type[$valearn.'_type']== 'F') selected @endif>Fixed</option>
                                                                     <option value='V' @if( $arr_type[$valearn.'_type']== 'V') selected @endif>Variable</option>
                                                                     </select>
                                                                     </td>
                                                                              <td><input type="text" name="value_emp[]" @if( $arr_type[$valearn.'_type']== 'F') readonly @endif  id="value<?php echo $tr_id; ?>" value="{{$arr_value[$valearn]}}" class="form-control"></td>
                                          
                                                                     <td>
                                                                     @if(($tr_id+1)==count($arr_name))
                                                                     <button class="btn-success" type="button" id="addearn<?php echo ($tr_id + 1); ?>" onClick="addnewrowearn(<?php echo ($tr_id + 1); ?>)" data-id="earn<?php echo ($tr_id + 1); ?>"> <i class="fas fa-plus"></i> </button>
                                                                  @endif
                                                                    <button class="btn-danger deleteButtonearnedit" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="delearnedit<?php echo $tr_id; ?>"  onClick="delRowearnedit(<?php echo $tr_id; ?>)"> <i class="fas fa-minus"></i> </button></td>
                                          
                                                                  </td>
                                                                          </tr>
                                                                  <?php $tr_id++;?>
                                                                  @endforeach
                                          
                                                        @else
                                          
                                                                          <tr class="itemslotpayearn" id="<?php echo $tr_id; ?>">
                                                                              <td>1</td>
                                                                              <td>
                                          
                                                                     <select class="form-control earninigcls" name="name_earn[]" id="name_earn<?php echo $tr_id; ?>" onchange="checkearntype(this.value,<?php echo $tr_id; ?>);">
                                          
                                                                     <option value='' selected>Select</option>
                                                                     <?php
                                          $name = '';
                                          ?>
                                          @foreach($rate_master as $value)
                                          <?php
                                          if ($value->id == '1') {
                                              $name = 'da';
                                          } else if ($value->id == '2') {
                                              $name = 'vda';
                                          } else if ($value->id == '3') {
                                              $name = 'hra';
                                          } else if ($value->id == '4') {
                                              $name = 'prof_tax';
                                          } else if ($value->id == '5') {
                                              $name = 'others_alw';
                                          } else if ($value->id == '6') {
                                              $name = 'tiff_alw';
                                          } else if ($value->id == '7') {
                                              $name = 'conv';
                                          } else if ($value->id == '8') {
                                              $name = 'medical';
                                          } else if ($value->id == '9') {
                                              $name = 'misc_alw';
                                          } else if ($value->id == '10') {
                                              $name = 'over_time';
                                          } else if ($value->id == '11') {
                                              $name = 'bouns';
                                          } else if ($value->id == '12') {
                                              $name = 'leave_inc';
                                          } else if ($value->id == '13') {
                                              $name = 'hta';
                                          } else if ($value->id == '14') {
                                              $name = 'tot_inc';
                                          } else if ($value->id == '15') {
                                              $name = 'pf';
                                          } else if ($value->id == '16') {
                                              $name = 'pf_int';
                                          } else if ($value->id == '17') {
                                              $name = 'apf';
                                          } else if ($value->id == '18') {
                                              $name = 'i_tax';
                                          } else if ($value->id == '19') {
                                              $name = 'insu_prem';
                                          } else if ($value->id == '20') {
                                              $name = 'pf_loan';
                                          } else if ($value->id == '21') {
                                              $name = 'esi';
                                          } else if ($value->id == '22') {
                                              $name = 'adv';
                                          } else if ($value->id == '23') {
                                              $name = 'hrd';
                                          } else if ($value->id == '24') {
                                              $name = 'co_op';
                                          } else if ($value->id == '25') {
                                              $name = 'furniture';
                                          } else if ($value->id == '26') {
                                              $name = 'misc_ded';
                                          } else if ($value->id == '27') {
                                              $name = 'tot_ded';
                                          
                                          } else if ($value->id == '29') {
                                              $name = 'pf_employerc';
                                          }
                                          ?>
                                                   @if($value->head_type == 'earning')
                                                                     <option value='{{$name}}'>{{ $value->head_name }}</option>
                                                                     @endif
                                                                     @endforeach
                                                                     </select>
                                          
                                                                  </td>
                                                                              <td><select class="form-control" name="head_type[]" id="head_type<?php echo $tr_id; ?>" onchange="checkearnvalue(this.value,<?php echo $tr_id; ?>);">
                                          
                                                                     <option value='' selected>Select</option>
                                                                     <option value='F'>Fixed</option>
                                                                     <option value='V'>Variable</option>
                                                                     </select>
                                                                     </td>
                                                                              <td><input type="text" name="value[]"  id="value<?php echo $tr_id; ?>" class="form-control"></td>
                                          
                                                                     <td><button class="btn-success" type="button" id="addearn<?php echo ($tr_id + 1); ?>" onClick="addnewrowearn(<?php echo ($tr_id + 1); ?>)" data-id="earn<?php echo ($tr_id + 1); ?>"> <i class="fas fa-plus"></i> </button></td>
                                                                          </tr>
                                                        @endif
                                          
                                                                  </tbody>
                                                                  </table>
                                             </div>
                                             <!-- </div> -->
                                             <h3 class="ad">Deduction</h3>
                                             <div class="addi">
                                                <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                   <thead>
                                                      <tr>
                                                         <th>Sl.No.</th>
                                                         <th>Head Name</th>
                                                         <th>Head Type</th>
                                                         <th>Value</th>
                                       
                                       
                                                      </tr>
                                                   </thead>
                                                     <tbody id="marksheetdeduct">
                                                     <?php $tr_id = 0;?>
                                                      @if(count($arr_name_deduct)!=0)
                                                        @foreach($arr_name_deduct as $valdeduct)
                                                       <tr class="itemslotpaydeduct" id="<?php echo $tr_id; ?>">
                                                                           <td><?php echo ($tr_id + 1); ?></td>
                                                                           <td>
                                       
                                                                  <select class="form-control deductcls" name="name_deduct[]" id="name_deduct<?php echo $tr_id; ?>" onchange="checkdeducttype(this.value,<?php echo $tr_id; ?>);">
                                                                  
                                                                  <option value='' selected>Select </option>
                                                                  <?php
                                                                 
                                       $name = '';
                                       ?>
                                       @foreach($rate_masterss as $value)
                                       <?php
                                       if ($value->id == '1') {
                                           $name = 'da';
                                       } else if ($value->id == '2') {
                                           $name = 'vda';
                                       } else if ($value->id == '3') {
                                           $name = 'hra';
                                       } else if ($value->id == '4') {
                                           $name = 'prof_tax';
                                       } else if ($value->id == '5') {
                                           $name = 'others_alw';
                                       } else if ($value->id == '6') {
                                           $name = 'tiff_alw';
                                       } else if ($value->id == '7') {
                                           $name = 'conv';
                                       } else if ($value->id == '8') {
                                           $name = 'medical';
                                       } else if ($value->id == '9') {
                                           $name = 'misc_alw';
                                       } else if ($value->id == '10') {
                                           $name = 'over_time';
                                       } else if ($value->id == '11') {
                                           $name = 'bouns';
                                       } else if ($value->id == '12') {
                                           $name = 'leave_inc';
                                       } else if ($value->id == '13') {
                                           $name = 'hta';
                                       } else if ($value->id == '14') {
                                           $name = 'tot_inc';
                                       } else if ($value->id == '15') {
                                           $name = 'pf';
                                       } else if ($value->id == '16') {
                                           $name = 'pf_int';
                                       } else if ($value->id == '17') {
                                           $name = 'apf';
                                       } else if ($value->id == '18') {
                                           $name = 'i_tax';
                                       } else if ($value->id == '19') {
                                           $name = 'insu_prem';
                                       } else if ($value->id == '20') {
                                           $name = 'pf_loan';
                                       } else if ($value->id == '21') {
                                           $name = 'esi';
                                       } else if ($value->id == '22') {
                                           $name = 'adv';
                                       } else if ($value->id == '23') {
                                           $name = 'hrd';
                                       } else if ($value->id == '24') {
                                           $name = 'co_op';
                                       } else if ($value->id == '25') {
                                           $name = 'furniture';
                                       } else if ($value->id == '26') {
                                           $name = 'misc_ded';
                                       } else if ($value->id == '27') {
                                           $name = 'tot_ded';
                                       
                                       } else if ($value->id == '29') {
                                           $name = 'pf_employerc';
                                       }
                                       ?>
                                       
                                                @if($value->head_type == 'deduction')
                                                                  <option value='{{$name}}' @if($name== $valdeduct) selected @endif>{{ $value->head_name }}</option>
                                                                  @endif
                                                                  @endforeach
                                                                  </select>
                                       
                                                               </td>
                                                                           <td><select class="form-control " name="head_typededuct[]" id="head_typededuct<?php echo $tr_id; ?>" onchange="checkdeductvalue(this.value,<?php echo $tr_id; ?>);">
                                       
                                                                  <option value='' selected>Select</option>
                                                                  <option value='F'  @if( $arr_type_deduct[$valdeduct.'_type']== 'F') selected @endif>Fixed</option>
                                                                  <option value='V' @if( $arr_type_deduct[$valdeduct.'_type']== 'V') selected @endif>Variable</option>
                                                                  </select>
                                                                  </td>
                                                                           <td><input type="text" name="valuededuct[]" value="{{$arr_value_deduct[$valdeduct]}}" @if( $arr_type_deduct[$valdeduct.'_type']== 'F') readonly @endif  id="valuededuct<?php echo $tr_id; ?>" class="form-control"></td>
                                       
                                                                  <td>
                                                                  @if(($tr_id+1)==count($arr_name_deduct))
                                                                  <button class="btn-success" type="button" id="adddeduct<?php echo ($tr_id + 1); ?>" onClick="addnewrowdeduct(<?php echo ($tr_id + 1); ?>)" data-id="deduct<?php echo ($tr_id + 1); ?>"> <i class="fas fa-plus"></i> </button>
                                                               @endif
                                                                <button class="btn-danger deleteButtondeductedit" style="background-color:#E70B0E; border-color:#E70B0E;" type="button" id="deldeductedit<?php echo $tr_id; ?>"  onClick="delRowdeductedit(<?php echo $tr_id; ?>)"> <i class="fas fa-minus"></i> </button></td>
                                       
                                                               </td>
                                                               <?php $tr_id++;?>
                                                                       </tr>
                                       
                                                     @endforeach
                                                     @else
                                                                       <tr class="itemslotpaydeduct" id="<?php echo $tr_id; ?>">
                                                                           <td>1</td>
                                                                           <td>
                                       
                                                                  <select class="form-control deductcls" name="name_deduct[]" id="name_deduct<?php echo $tr_id; ?>" onchange="checkdeducttype(this.value,<?php echo $tr_id; ?>);">
                                       
                                                                  <option value='' selected>Select</option>
                                                                  <?php
                                       $name = '';
                                       ?>
                                      
                                       @foreach($rate_masterss as $value)
                                       <?php
                                       if ($value->id == '1') {
                                           $name = 'da';
                                       } else if ($value->id == '2') {
                                           $name = 'vda';
                                       } else if ($value->id == '3') {
                                           $name = 'hra';
                                       } else if ($value->id == '4') {
                                           $name = 'prof_tax';
                                       } else if ($value->id == '5') {
                                           $name = 'others_alw';
                                       } else if ($value->id == '6') {
                                           $name = 'tiff_alw';
                                       } else if ($value->id == '7') {
                                           $name = 'conv';
                                       } else if ($value->id == '8') {
                                           $name = 'medical';
                                       } else if ($value->id == '9') {
                                           $name = 'misc_alw';
                                       } else if ($value->id == '10') {
                                           $name = 'over_time';
                                       } else if ($value->id == '11') {
                                           $name = 'bouns';
                                       } else if ($value->id == '12') {
                                           $name = 'leave_inc';
                                       } else if ($value->id == '13') {
                                           $name = 'hta';
                                       } else if ($value->id == '14') {
                                           $name = 'tot_inc';
                                       } else if ($value->id == '15') {
                                           $name = 'pf';
                                       } else if ($value->id == '16') {
                                           $name = 'pf_int';
                                       } else if ($value->id == '17') {
                                           $name = 'apf';
                                       } else if ($value->id == '18') {
                                           $name = 'i_tax';
                                       } else if ($value->id == '19') {
                                           $name = 'insu_prem';
                                       } else if ($value->id == '20') {
                                           $name = 'pf_loan';
                                       } else if ($value->id == '21') {
                                           $name = 'esi';
                                       } else if ($value->id == '22') {
                                           $name = 'adv';
                                       } else if ($value->id == '23') {
                                           $name = 'hrd';
                                       } else if ($value->id == '24') {
                                           $name = 'co_op';
                                       } else if ($value->id == '25') {
                                           $name = 'furniture';
                                       } else if ($value->id == '26') {
                                           $name = 'misc_ded';
                                       } else if ($value->id == '27') {
                                           $name = 'tot_ded';
                                       
                                       } else if ($value->id == '29') {
                                           $name = 'pf_employerc';
                                       }
                                       ?>
                                   
                                                @if($value->head_type == 'deduction')
                                               
                                                                  <option value='{{$name}}'>{{ $value->head_name }}</option>
                                                                  @endif
                                                                  @endforeach
                                                                  </select>
                                       
                                                               </td>
                                                                           <td><select class="form-control" name="head_typededuct[]" id="head_typededuct<?php echo $tr_id; ?>" onchange="checkdeductvalue(this.value,<?php echo $tr_id; ?>);">
                                       
                                                                  <option value='' selected>Select</option>
                                                                  <option value='F'>Fixed</option>
                                                                  <option value='V'>Variable</option>
                                                                  </select>
                                                                  </td>
                                                                           <td><input type="text" name="valuededuct[]"  id="valuededuct<?php echo $tr_id; ?>" class="form-control"></td>
                                       
                                                                  <td><button class="btn-success" type="button" id="adddeduct<?php echo ($tr_id + 1); ?>" onClick="addnewrowdeduct(<?php echo ($tr_id + 1); ?>)" data-id="deduct<?php echo ($tr_id + 1); ?>"> <i class="fas fa-plus"></i> </button></td>
                                                                       </tr>
                                                               @endif
                                                               </tbody>
                                                               </table>
                                             </div>
                                            
                                          </div>
                                    </div>
                                    <!-- <div class="form-group">
                                       <button class="btn btn-warning back4" type="button"><i class="ti-arrow-left"></i> Back</button>
                                       <button class="btn btn-primary open4" type="button">Next <i class="ti-arrow-right"></i></button>
                                       <img src="spinner.gif" alt="" id="loader" style="display: none">
                                       </div> -->
                                    <!------------------------------------>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div style="overflow:auto;">
               <div style="float:right;">
               <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
               <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
               </div>
               </div>
               <!-- Circles which indicates the steps of the form: -->
               <div style="text-align:center;margin-top:40px;">
               <span class="step"></span>
               <span class="step"></span>
               <span class="step"></span>
               <span class="step"></span>
               <span class="step"></span>
               <span class="step"></span>
               </div>
               <!-- <input type="submit" value="submit"> -->
               </form>
            </div>
         </div>
         </section>
         </main> 
         <!-- alerts are for fun of it -->
         <div class="alerts-container">
            <div class="row">
               <div id="timed-alert" class="alert alert-info animated tada" role="alert">
                  <span id="time"></span>
               </div>
            </div>
            <div class="row">
               <div id="click-alert" class="alert alert-warning" role="alert">
               </div>
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
      <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
      <script>
         function addnewrowdeduct(rowid)
         {
         
         
         
         if (rowid != ''){
         		$('#adddeduct'+rowid).attr('disabled',true);
         
         }
         
         
         
         $.ajax({
               url:"{{url('settings/get-add-row-deduct')}}"+'/'+rowid,
         		
         		type: "GET",
         
         		success: function(response) {
         console.log("response",response)
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
         
           function addnewrowearn(rowid)
         {
         
         if (rowid != ''){
         		$('#addearn'+rowid).attr('disabled',true);
         
         }
         
         $.ajax({
               url:"{{url('settings/get-add-row-earn')}}"+'/'+rowid,
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
         
         function basicpay(){
           var basicpay=$("#emp_basic_pay").val();
           console.log(basicpay)
           // parseInt($(YOURINPUT).val()) > 99
           if(14999>=parseInt(basicpay)){
             $("#emp_pension").val("NO")
           }else{
             $("#emp_pension").val("YES")
           }
         }
         function getreviewdate(){
           var pass_exp_date=$("#pass_exp_date").val();
           $("#pass_review_date").val(pass_exp_date);
         }
         function presentFunc(){
           var parmenent_street_name=$("#parmenent_street_name").val();
           var village=$("#village").val();
           var parmenent_city=$("#parmenent_city").val();
           var emp_per_post_office=$("#emp_per_post_office").val();
           var emp_per_policestation=$("#emp_per_policestation").val();
           var parmenent_pincode=$("#parmenent_pincode").val();
           var emp_per_dist=$("#emp_per_dist").val();
           var parmenent_state=$('#parmenent_state option:selected').text();
           var parmenent_country=$("#parmenent_country").val();
           var parmenent_mobile=$("#parmenent_mobile").val();
           console.log(parmenent_mobile)
         
           $("#present_street_name").val(parmenent_street_name);
           $("#emp_ps_village").val(village);
           $("#present_city").val(parmenent_city);
           $("#emp_ps_post_office").val(emp_per_post_office);
           $("#emp_ps_policestation").val(emp_per_policestation);
           $("#present_pincode").val(parmenent_pincode);
           $("#emp_ps_dist").val(emp_per_dist)
           $('#stat').val(parmenent_state);
           $("#emp_ps_country").val(parmenent_country);
           $("#emp_ps_mobilea").val(parmenent_mobile);
         }
         
         function crinabi($detsils){
           if($detsils==="Others"){
             $("#givedetails").html(`
             <label>Give Details</label>
             <div class="col-md-3">
             <div class="form-group">
              <input type="text" name="givedetails" class="form-control" style="width:210px">
             </div>
             </div>
             `)
           }
         }
         function addnewrow(rowid)
         {
         if (rowid != ''){
         		$('#add'+rowid).attr('disabled',true);
         
         }
         $.ajax({
              url:"{{url('settings/get-add-row-item')}}"+'/'+rowid,
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
         
         function accademinewrow(rowid){
           if (rowid != ''){
         		$('#add'+rowid).attr('disabled',true);
         
         }
         $.ajax({
              url:"{{url('settings/get-add-row-acc')}}"+'/'+rowid,
         		type: "GET",
         
         		success: function(response) {
         
         			$("#marksheet1").append(response);
         
         		}
         	});
         }
         
         function proaddnewrow(rowid){
           if (rowid != ''){
         		$('#add'+rowid).attr('disabled',true);
         
         }
         $.ajax({
              url:"{{url('settings/get-add-row-pro')}}"+'/'+rowid,
         		type: "GET",
         
         		success: function(response) {
         
         			$("#marksheet2").append(response);
         
         		}
         	});
         }
         
         function Miscnewrow(rowid){
           if (rowid != ''){
         		$('#add'+rowid).attr('disabled',true);
         
         }
         $.ajax({
              url:"{{url('settings/get-add-row-mic')}}"+'/'+rowid,
         		type: "GET",
         
         		success: function(response) {
         
         			$("#marksheet3").append(response);
         
         		}
         	});
         }
         
         function deptFunc($id){
           var deiId= $('#deptid option:selected').text();
           console.log(deiId)
           $.ajax({
              url:"{{url('employee/department-name')}}"+'/'+deiId,
         		type: "GET",
         
         		success: function(response) {
                  document.getElementById("rate_id").innerHTML = response;
         			// console.log(response);
                  // $("#des").append(response)
                 
         		}
         	});
         }
         function populateBranch(){
            var bankname= $('#emp_bank_name option:selected').val();
            console.log(bankname);
            $.ajax({
              url:"{{url('employee/emp-bank-name')}}"+'/'+bankname,
         		type: "GET",
         
         		success: function(response) {
                  document.getElementById("bank_branch_ids").innerHTML = response;
         			
                 
         		}
         	});
         } 
         
         function branchfunc(){
            var branchname=$('#bank_branch_ids option:selected').val();
           var jk= $.trim(branchname)
            // console.log(branchname)
            $.ajax({
              url:"{{url('employee/emp-branch-name')}}"+'/'+jk,
         		type: "GET",
         
         		success: function(response) {
                  console.log(response)
                  document.getElementById("emp_ifsc_code").innerHTML = response;
         			
                 
         		}
         	});
         }
         function checkearnvalue(val,row){
         var emp_basic_pay=$('#emp_basic_pay').val();
         var headname=$('#name_earn'+row).val();
         
         $.ajax({
            url:"{{url('employee/get-earn')}}"+'/'+headname+'/'+val+'/'+emp_basic_pay,
         // url:'http://bellevuepf.com/payroll/public/settings/get-earn/'+headname+'/'+val+'/'+emp_basic_pay,
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
             url:"{{url('employee/get-earn')}}"+'/'+headname+'/'+val+'/'+emp_basic_pay,
         // url:'http://bellevuepf.com/payroll/public/settings/get-earn/'+headname+'/'+val+'/'+emp_basic_pay,
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
         
      </script>
      <script>
         function dateofjoinfunc(){
           var dateofjoi=$('#dateofjoin').val();
          console.log(dateofjoi)
           $("#datecon").html(
             `
             <div class="col-md-3">
                  <div class="form-group">
                     <label>Confirmation Date</label>
                        <input type="text" name="confirmationdate" id="conDate"  class="form-control" style="width:210px">
                   </div>
            </div>
             `
           )
           var dateOfBirth = new Date(dateofjoi);
               var fiftdateOfBirth = new Date(dateofjoi);
         
            	var six_month_ago = new Date(dateOfBirth.getFullYear(),dateOfBirth.getMonth()+6,dateOfBirth.getDate());
            	$("#conDate").val(six_month_ago.toLocaleDateString())
             //  $("#renew").val(lastDayWithSlashes)
         }
         function employeeFunc(){
           var employeeEtype=$('select#type option:selected'). val();
           var dateofjoi=$('#dateofjoin').val();
           if(employeeEtype==="CONTRACT"){
             $("#reviniueDate").html(`
             <div class="col-md-3">
             <div class="form-group">
             <label>Renew Date</label>
             
             <input type="text" name="renewdate" id="renew" class="form-control" style="width:215px">
             </div>
             </div>
             
             `)
            }
         
               var dateOfBirth = new Date(dateofjoi);
               var fiftdateOfBirth = new Date(dateofjoi);
         
            	var sixty_years_ago = new Date(dateOfBirth.getFullYear()+1,dateOfBirth.getMonth(),dateOfBirth.getDate());
               var six_month=sixty_years_ago.toLocaleDateString();
              $("#renew").val(six_month)
         
         
           
         }
         $("#ImageMedias").change(function () {
         if (typeof (FileReader) != "undefined") {
         var dvPreview = $("#divImageMediaPreview");
         dvPreview.html("");            
         $($(this)[0].files).each(function () {
         	var file = $(this);                
         		var reader = new FileReader();
         		reader.onload = function (e) {
         			var img = $("<img />");
         			img.attr("style", "width: 100px; height:100px;");
         			img.attr("src", e.target.result);
         			dvPreview.append(img);
         		}
         		reader.readAsDataURL(file[0]);                
         });
         } else {
         alert("This browser does not support HTML5 FileReader.");
         }
         });
         
         function MaritalChange(){
           var marid=$("#marid").val();
          
           if(marid==="YES"){
            $("#mariddate").html(`
            <label>Date of Marriage</label>
            <input type="date" name="mariddate" class="form-control">
            `)
           }
           if(marid==="NO"){
            $("#mariddate").html(`
           
            `)
           }
         }
         
         function datefunction(){
           var emp_dob=$("#dateofbirth").val();
           // var emp_dob = $("#emp_dob").val();
            	var dateOfBirth = new Date(emp_dob);
               var fiftdateOfBirth = new Date(emp_dob);
         
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
         
               var fiftyeight_years_ago = new Date(dateOfBirth.getFullYear()+58,dateOfBirth.getMonth(),dateOfBirth.getDate());
         
            	if(fiftdateOfBirth.getDate()==1 && fiftyeight_years_ago.getMonth()==0){
            		var lastdate = new Date(fiftyeight_years_ago.getFullYear(), (fiftyeight_years_ago.getMonth()+1), 0).getDate();
            	   var fiftlastDayWithSlashes = lastdate + '/' + '12' + '/' + (fiftyeight_years_ago.getFullYear()-1);
         
            	}else if(fiftdateOfBirth.getDate()==1 && fiftyeight_years_ago.getMonth()>0){
            		var lastdate = new Date(fiftyeight_years_ago.getFullYear(), (fiftyeight_years_ago.getMonth()), 0).getDate();
            		var fiftlastDayWithSlashes = lastdate + '/' + (fiftyeight_years_ago.getMonth()) + '/' + fiftyeight_years_ago.getFullYear();
         
            	}else{
            		var lastdate = new Date(fiftyeight_years_ago.getFullYear(), (fiftyeight_years_ago.getMonth()+1), 0).getDate();
            		var fiftlastDayWithSlashes = lastdate +'/' + (fiftyeight_years_ago.getMonth()+1) + '/' + fiftyeight_years_ago.getFullYear();
            	}
               
             $("#dateofretirementDate").val(lastDayWithSlashes);
               $("#dateofretirementbvcid").val(fiftlastDayWithSlashes);
         }
           $(document).ready(function() {	
         
         // Random Alert shown for the fun of it
         function randomAlert() {
         var min = 5,
         	max = 20;
         var rand = Math.floor(Math.random() * (max - min + 1) + min); //Generate Random number between 5 - 20
         // post time in a <span> tag in the Alert
         $("#time").html('Next alert in ' + rand + ' seconds');
         $('#timed-alert').fadeIn(500).delay(3000).fadeOut(500);
         setTimeout(randomAlert, rand * 1000);
         };
         randomAlert();
         });
         
         $('.btn').click(function(event) {
           event.preventDefault();
           var target = $(this).data('target');
         // console.log('#'+target);
         $('#click-alert').html('data-target= ' + target).fadeIn(50).delay(3000).fadeOut(1000);
         
         });
         
         
         // Multi-Step Form
         var currentTab = 0; // Current tab is set to be the first tab (0)
         showTab(currentTab); // Display the crurrent tab
         
         function showTab(n) {
         // This function will display the specified tab of the form...
         var x = document.getElementsByClassName("tab");
         x[n].style.display = "block";
         //... and fix the Previous/Next buttons:
         if (n == 0) {
           document.getElementById("prevBtn").style.display = "none";
         } else {
           document.getElementById("prevBtn").style.display = "inline";
         }
         if (n == (x.length - 1)) {
           document.getElementById("nextBtn").innerHTML = "Submit";
         } else {
           document.getElementById("nextBtn").innerHTML = "Next";
         }
         //... and run a function that will display the correct step indicator:
         fixStepIndicator(n)
         }
         
         
         function nextPrev(n) {
        
         var arrayVal=[];
         
         var x = document.getElementsByClassName("tab");
         
         
         
         // if (n == 1 && !validateForm()){
         //    return false;
         // }
         // if (n == 2 && !validateForm2()){
         //    return false;
         // }
         
         x[currentTab].style.display = "none";
         currentTab = currentTab + n;
      
         
         arrayVal.push(currentTab);
         console.log(arrayVal)
         if (currentTab >= x.length) {
           document.getElementById("regForm").submit();
           return false;
         }
         showTab(currentTab);
         }
         
         
         
         function validateForm() {
         var inputIdsToValidate = ["emp_old_code","emp_fname","emp_father_name","deptid","rate_id","dateofbirth","dateofjoin","type","emp_email","emp_phone"];
         // , "emp_father_name","deptid","rate_id","dateofbirth","dateofjoin","type"
         //   ,"type","parmenent_pincode","parmenent_state","emp_group","emp_basic_pay","emp_apf_percent","emp_pf_type","emp_bank_name","bank_branch_ids","emp_ifsc_code","emp_account_no"
         var valid = true;
         
         // Loop through the list of input IDs to validate:
         for (var i = 0; i < inputIdsToValidate.length; i++) {
         var inputId = inputIdsToValidate[i];
         var inputField = document.getElementById(inputId);
         
         // Check if the input field exists and if it's empty:
         if (inputField && inputField.value.trim() === "") {
         // Add an "invalid" class to the field:
         inputField.classList.add("invalid");
         // Set the current valid status to false:
         valid = false;
         }
         }
         
         // If the valid status is true, mark the step as finished and valid:
         if (valid) {
         document.getElementsByClassName("step")[currentTab].classList.add("finish");
         }
         
         return valid; // return the valid status
         }
         
         function validateForm2() {
         // This function deals with validation of the form fields
         var inputIdsToValidate = ["docc"];
         // parmenent_pincode","parmenent_state
         //   ,"type","parmenent_pincode","parmenent_state","emp_group","emp_basic_pay","emp_apf_percent","emp_pf_type","emp_bank_name","bank_branch_ids","emp_ifsc_code","emp_account_no"
         var valid = true;
         
         // Loop through the list of input IDs to validate:
         for (var i = 0; i < inputIdsToValidate.length; i++) {
         var inputId = inputIdsToValidate[i];
         var inputField = document.getElementById(inputId);
         
         // Check if the input field exists and if it's empty:
         if (inputField && inputField.value.trim() === "") {
         // Add an "invalid" class to the field:
         inputField.classList.add("invalid");
         // Set the current valid status to false:
         valid = false;
         }
         }
         
         // If the valid status is true, mark the step as finished and valid:
         if (valid) {
         document.getElementsByClassName("step")[currentTab].classList.add("finish");
         }
         
         return valid; // return the valid status
         }
         
         
         
         // function validateForm() {
         // // This function deals with validation of the form fields
         // var x, y, i, valid = true;
         // x = document.getElementsByClassName("tab");
         // // y = x[currentTab].querySelectorAll("input[id='emp_fname'][id='emp_father_name']");
         // y = x[currentTab].getElementsByTagName("input");
         // // A loop that checks every input field in the current tab:
         // for (i = 0; i < y.length; i++) {
         //   // If a field is empty...
         //   if (y[i].value == "") {
         //     // add an "invalid" class to the field:
         //     y[i].className += " invalid";
         //     // and set the current valid status to false
         //     valid = false;
         //   }
         // }
         // // If the valid status is true, mark the step as finished and valid:
         // if (valid) {
         //   document.getElementsByClassName("step")[currentTab].className += " finish";
         // }
         // return valid; // return the valid status
         // }
         
         function fixStepIndicator(n) {
         // This function removes the "active" class of all steps...
         var i, x = document.getElementsByClassName("step");
         for (i = 0; i < x.length; i++) {
           x[i].className = x[i].className.replace(" active", "");
         }
         //... and adds the "active" class on the current step:
         x[n].className += " active";
         }
      </script>
   </body>
</html>