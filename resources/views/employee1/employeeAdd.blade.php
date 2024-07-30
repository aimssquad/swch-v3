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
        .table thead th{
            padding: 10px 6px!important;
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
               /*margin-right: 20px;*/
               /*margin-top: 10px;*/
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
                          
                           
                          
                           
                           <div class="card-body">
                               
                              <main class="content" role="content">
                                  
                                   <div class="col-sm-12">
                                       <div class="row">
                                        <div class="col-sm-2">
                                             <div>
                                                  <div id="divImageMediaPreview" class="profile_img"></div>
                                               </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <section id="section1">
                                    <div class="container-fluid">
                                       <form id="regForm" action="{{url('employee/savemploy')}}" method="POST" enctype="multipart/form-data">
                                          @csrf
                                          <div class="tab">
                                             <p>Personal and Service Details</p>
                                             <hr/>
                                             <input type="hidden" value="<?php if (!empty($employee_code)) {echo $employee_code;}if (request()->get('q') != '') {echo $employee_rs[0]->emp_code;}?>" placeholder="Employee Code..." class="form-control"   name="emp_code"></p>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Code <span style="color: red">(*)</label>
                                                      <input type="text"  placeholder="Employee Code..." class="form-control"   name="emp_old_code" id="emp_old_code"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Salutation</label>
                                                      <select name="salutation" class="form-control">
                                                         <option value="">select</option>
                                                         <option value="MR." >MR.</option>
                                                         <option value="MRS." >MRS.</option>
                                                         <option value="MS." >MS.</option>
                                                         <option value="DR." >DR.</option>
                                                         <option value="MISS" >MISS</option>
                                                      </select>
                                                      <!-- <input type="text" placeholder="Salutation..."  class="form-control" name="salutation"></p> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>First Name <span style="color:red">(*)</span></label>
                                                      <input type="text" placeholder="First Name..."  class="form-control" name="emp_fname" id="emp_fname" required></p>
                                                      <span id="fname"></span>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Middle Name</label>
                                                      <input type="text" placeholder="Middle Name..."  class="form-control" name="emp_mname"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Last Name</label>
                                                      <input type="text" placeholder="Last Name..."  class="form-control" name="emp_lname"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Father Name<span style="color:red">(*)</span></label>
                                                      <input type="text" placeholder="Father Name..."  class="form-control" id="emp_father_name" name="emp_father_name"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Spouse Name</label>
                                                      <input type="text" placeholder="Spouse Name..."  class="form-control" name="spousename"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Email <span style="color: red">(*)</span></label>
                                                      <input type="text" placeholder="Employee Email..."  class="form-control" name="em_email" id="emp_email"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Phone <span style="color: red">(*)</span></label>
                                                      <input type="text" placeholder="Phone Number..."  class="form-control" name="em_phone" id="emp_phone"></p>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Caste</label>
                                                      <select class="form-control" name="emp_caste">
                                                         <option>Select</option>
                                                         <option value="GENERAL" >GENERAL</option>
                                                         @foreach($cast as $item)
                                                         <option value='{{ $item->cast_name }}'>{{ $item->cast_name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Sub Caste</label>
                                                      <select class="form-control" name="emp_sub_caste" >
                                                         <option>Select</option>
                                                         @foreach($sub_cast as $item)
                                                         <option value='{{ $item->sub_cast_name }}'>{{ $item->sub_cast_name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Religion</label>
                                                      <select class="form-control" name="emp_religion" >
                                                         <option>Select</option>
                                                         @foreach($religion as $item)
                                                         <option value='{{ $item->religion_name }}'>{{ $item->religion_name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Marital Status</label>
                                                      <select class="form-control" name="maritalstatus"  id="marid" onchange="MaritalChange()">
                                                         <option>Select</option>
                                                         <option value="YES">YES</option>
                                                         <option value="NO">NO</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <div id="mariddate"></div>
                                                   </div>
                                                </div>
                                             </div>
                                             <p>Service Details</p>
                                             <hr/>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Department<span style="color:red">(*)</span></label>
                                                      <select class="form-control" name="department" id="deptid" onclick="deptFunc()">
                                                         <option></option>
                                                         @foreach($department as $dept)
                                                         <option value='{{ $dept->department_name }}'>{{ $dept->department_name }}</option>
                                                         @endforeach   
                                                      </select>
                                                      <!-- <input type="text" class="form-control" name="department" placeholder="Your Department"> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Designation <span style="color:red">(*)</span></label>
                                                      <select class="form-control" id="rate_id" name="designation" required>
                                                         <option value="" selected disabled required>Select</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Date Of Birth <span style="color:red">(*)</span></label>
                                                      <input type="date" name="dateofbirth" class="form-control" id="dateofbirth" onchange="datefunction()"><br/>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Date Of Retirement</label>
                                                      <input type="text" name="dateofretirement" id="dateofretirementDate" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Date Of Retirement BVC</label>
                                                      <input type="text" name="dateofretirementbvc" id="dateofretirementbvcid" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Date of Joining <span style="color:red">(*)</span></label>
                                                      <input type="date" name="dateofJoining" class="form-control" id="dateofjoin" onchange="dateofjoinfunc()">
                                                   </div>
                                                </div>
                                                <div id="datecon"></div>
                                                <!-- <div class="col-md-4">
                                                   <div class="form-group">
                                                     <label>Confirmation Date</label>
                                                     <input type="text" name="confirmationdate"  class="form-control">
                                                   </div>
                                                   </div> -->
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Next Increment Date</label>
                                                      <input type="date" name="nextincrementdate"  class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Eligible for Promotion</label>
                                                      <select class="form-control" name="eligibleforpromotion">
                                                         <option>Eligible for Promotion</option>
                                                         <option value="YES">YES</option>
                                                         <option value="NO">NO</option>
                                                      </select>
                                                      <br/>
                                                      <!-- <input type="date" name="nextincrementdate"  class="form-control"> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Type <span style="color:red">(*)</span></label>
                                                      <select name="employeetype" class="form-control" id="type" onchange="employeeFunc()">
                                                         <option>Employee Type</option>
                                                         
                                                         @foreach($EmployeeType_master as $emp)
                                                         <option value="{{$emp->employ_type_name}}" >{{$emp->employ_type_name}}</option>
                                                         @endforeach
                                                         {{-- <option value="PERMANENT" >PERMANENT</option>
                                                         <option value="PROBATIONARY EMPLOYEE" >PROBATIONARY EMPLOYEE</option>
                                                         <option value="CONTRACT" >CONTRACT</option>
                                                         <option value="EX-EMPLOYEE" >EX- EMPLOYEE</option> --}}
                                                      </select>
                                                      <!-- <input type="date" name="nextincrementdate"  class="form-control"> -->
                                                   </div>
                                                </div>
                                                <div id="reviniueDate"></div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="imageUpload">Profile Image</label>
                                                      <input type="file" class="form-control" id="ImageMedias" multiple="multiple" accept=".png, .jpg, .jpeg" name="profileimage">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Reporting Authority</label>
                                                      <select class="form-control" name="reportingauthority">
                                                         <option>Reporting Authority</option>
                                                         <option>Reporting Authority</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Leave Sanctioning Authority</label>
                                                      <select class="form-control" name="leaveauthority">
                                                         <option>Leave Sanctioning Authority</option>
                                                         <option></option>
                                                      </select>
                                                      <br/>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Grade</label>
                                                      <input type="text" name="grade" class="form-control" placeholder="Employee Grade">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Registration No</label>
                                                      <input type="text" name="registration_no" class="form-control" placeholder="Employee Registration No">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Registration Date</label>
                                                      <input type="date" name="registration_date" class="form-control" placeholder="Employee Registration No">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Registration Council</label>
                                                      <input type="text" name="registration_counci" class="form-control" placeholder="Employee Registration Council"><br/>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Employee Date Of Up Gradation</label>
                                                      <input type="date" name="date_of_up_gradation" class="form-control" placeholder="Employee Registration No">
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
                                                      </tr>
                                                   </thead>
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
                                                      </tr>
                                                   </thead>
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
                                                      </tr>
                                                   </thead>
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
                                                </table>
                                                <legend>Misc. Documents </legend>
                                                <table border="1" class="table table-bordered table-responsove" style="border-collapse:collapse;overflow-x:scroll;">
                                                   <thead>
                                                      <tr>
                                                         <th>Sl.No.</th>
                                                         <th>Category</th>
                                                         <th>Document Upload</th>
                                                      </tr>
                                                   </thead>
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
                                                </table>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <div class="row">
                                                <legend>Medical Information</legend>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Blood Group</label>
                                                      <select class="form-control" name="emp_blood_grp" >
                                                         <option value="">Select</option>
                                                         <option value="A +"  >A +</option>
                                                         <option value="A -"  >A -</option>
                                                         <option value="B +"  >B +</option>
                                                         <option value="B -"  >B -</option>
                                                         <option value="AB +"  >AB +</option>
                                                         <option value="AB -"  >AB -</option>
                                                         <option value="O +"  >O +</option>
                                                         <option value="O -"  >O -</option>
                                                         <option value="Unknown">Unknown</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Eye Sight (Left)</label>
                                                      <input type="text" name="emp_eye_sight_left" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Eye Sight (Right)</label>
                                                      <input type="text" name="emp_eye_sight_right" value="" class="form-control" id="">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label class="">Family Plan Status</label>
                                                      <select class="form-control" name="emp_family_plan_status">
                                                         <option value="">Select</option>
                                                         <option value="yes"  >yes</option>
                                                         <option value="no"  >No</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Family Plan Date</span></label>
                                                      <input type="date" name="emp_family_plan_date" value="" class="form-control" id="">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Height (in cm)</label>
                                                      <input type="text" name="emp_height" value="" class="form-control" id="">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label class="">Weight (in Kgs)</label><br>
                                                      <input type="text" name="emp_weight" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Identification Mark (1)</label><br>
                                                      <input type="text" name="emp_identification_mark_one" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Identification Mark (2)</label><br>
                                                      <input type="text" name="emp_identification_mark_two" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Physically Challenged</label>
                                                      <select class="form-control" name="emp_physical_status">
                                                         <option value="no" >No</option>
                                                         <option value="yes" >Yes</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <legend>Permanent Address</legend>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Street No. and Name</label>
                                                         <input type="text" name="emp_pr_street_no" value="" id="parmenent_street_name" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Village</label>
                                                         <input  name="emp_per_village" id="village" value="" type="text" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>City</label>
                                                         <input type="text" name="emp_pr_city" value="" id="parmenent_city" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Post Office</label>
                                                         <input id="emp_per_post_office" name="emp_per_post_office" value="" type="text" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Police Station</label>
                                                         <input type="text" id="emp_per_policestation" name="emp_per_policestation" value="" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Pin Code <span style="color:red">(*)</span> </label>
                                                         <input id="parmenent_pincode" name="emp_pr_pincode" value="" type="text" class="form-control" required >
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>District</label>
                                                         <input type="text" id="emp_per_dist" name="emp_per_dist" value="" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>State <span style="color:red">(*)</span></label>
                                                         <select name="emp_pr_state" id="parmenent_state" class="form-control" required>
                                                            <option value="" label="Select">Select</option>
                                                            <option value="JAMMU AND KASHMIR" >JAMMU AND KASHMIR</option>
                                                            <option value="HIMACHAL PRADESH" >HIMACHAL PRADESH</option>
                                                            <option value="PUNJAB" >PUNJAB</option>
                                                            <option value="CHANDIGARH" >CHANDIGARH</option>
                                                            <option value="UTTARAKHAND" >UTTARAKHAND</option>
                                                            <option value="HARYANA" >HARYANA</option>
                                                            <option value="DELHI" >DELHI</option>
                                                            <option value="RAJASTHAN" >RAJASTHAN</option>
                                                            <option value="UTTAR PRADESH" >UTTAR PRADESH</option>
                                                            <option value="BIHAR" >BIHAR</option>
                                                            <option value="SIKKIM" >SIKKIM</option>
                                                            <option value="ARUNACHAL PRADESH" >ARUNACHAL PRADESH</option>
                                                            <option value="NAGALAND" >NAGALAND</option>
                                                            <option value="MANIPUR" >MANIPUR</option>
                                                            <option value="MIZORAM" >MIZORAM</option>
                                                            <option value="TRIPURA" >TRIPURA</option>
                                                            <option value="MEGHALAYA" >MEGHALAYA</option>
                                                            <option value="ASSAM" >ASSAM</option>
                                                            <option value="WEST BENGAL" >WEST BENGAL</option>
                                                            <option value="JHARKHAND" >JHARKHAND</option>
                                                            <option value="ODISHA" >ODISHA</option>
                                                            <option value="CHHATTISGARH" >CHHATTISGARH</option>
                                                            <option value="MADHYA PRADESH" >MADHYA PRADESH</option>
                                                            <option value="GUJARAT" >GUJARAT</option>
                                                            <option value="DAMAN AND DIU" >DAMAN AND DIU</option>
                                                            <option value="DADRA AND NAGAR HAVELI" >DADRA AND NAGAR HAVELI</option>
                                                            <option value="MAHARASHTRA" >MAHARASHTRA</option>
                                                            <option value="ANDHRA PRADESH" >ANDHRA PRADESH</option>
                                                            <option value="KARNATAKA" >KARNATAKA</option>
                                                            <option value="GOA" >GOA</option>
                                                            <option value="LAKSHADWEEP" >LAKSHADWEEP</option>
                                                            <option value="KERALA" >KERALA</option>
                                                            <option value="TAMIL NADU" >TAMIL NADU</option>
                                                            <option value="PUDUCHERRY" >PUDUCHERRY</option>
                                                            <option value="ANDAMAN AND NICOBAR ISLANDS" >ANDAMAN AND NICOBAR ISLANDS</option>
                                                            <option value="TELANGANA" >TELANGANA</option>
                                                         </select>
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Country</label>
                                                         <input id="parmenent_country" name="emp_pr_country" value="" type="text" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div class="col-md-4">
                                                      <div class="form-group">
                                                         <label>Mobile No.</label>
                                                         <input type="text" id="parmenent_mobile" name="emp_pr_mobile" value="" class="form-control" >
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
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelien" class="placeholder">Name</label>
                                                      <input id="inputFloatingLabelien" type="text" class="form-control input-border-bottom" name="em_name" value="RABIA BIBI">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelier" class="placeholder">Relationship</label>
                                                      <!-- onchange="crinabi(this.value);" -->
                                                      <select class="form-control input-border-bottom" id="inputFloatingLabelier" name="em_relation" onclick="crinabi(this.value);" >
                                                         <option value="">&nbsp;</option>
                                                         <option value="Father"  >Father</option>
                                                         <option value="Mother"  >Mother </option>
                                                         <option value="Wife"  selected>Wife</option>
                                                         <option value="Relatives"  >Relatives</option>
                                                         <option value="Husband"  >Husband</option>
                                                         <option value="Partner"  >Partner</option>
                                                         <option value="Son"  >Son</option>
                                                         <option value="Daughter"  >Daughter</option>
                                                         <option value="Friend"  >Friend</option>
                                                         <option value="Others"  >Others</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <!-- <div id="givedetails"></div>
                                                   <div class="col-md-4 " id="criman_new"    style="display:none;"  >
                                                      <div class="form-group">
                                                         <label for="relation_others" class="placeholder">Give Details </label>
                                                         <input id="relation_others"  type="text" class="form-control input-border-bottom" name="relation_others"   value="">
                                                      </div>
                                                   </div> -->
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabeliemail" class="placeholder">Email</label>
                                                      <input id="inputFloatingLabeliemail" type="email" class="form-control input-border-bottom" name="hel_em_email" value="">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabeliem" class="placeholder">Emergency Contact No.</label>
                                                      <input id="inputFloatingLabeliem" type="text" class="form-control input-border-bottom" name="hel_em_phone" value="07863786953">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelienad" class="placeholder">Address</label>
                                                      <input id="inputFloatingLabelienad" type="text" class="form-control input-border-bottom" name="em_address" value="2 Ashby Close BIRMINGHAM B8 2RB">
                                                   </div>
                                                </div>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <h4 style="color: #1269db;">Passport Details</h4>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabeldn" class="placeholder">Passport No.</label>
                                                      <input id="inputFloatingLabeldn" type="text" class="form-control input-border-bottom" name="pass_doc_no" value="127743129">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="selectFloatingLabelntp" class="placeholder">Nationality</label>
                                                      <select class="form-control input-border-bottom" id="selectFloatingLabelntp" name="pass_nat" >
                                                         <option value="">&nbsp;</option>
                                                         <option value="Afghanistan" >Afghanistan</option>
                                                         <option value="Albania" >Albania</option>
                                                         <option value="America" >America</option>
                                                         <option value="Argentina" >Argentina</option>
                                                         <option value="Aruba" >Aruba</option>
                                                         <option value="Australia" >Australia</option>
                                                         <option value="Azerbaijan" >Azerbaijan</option>
                                                         <option value="Bahamas" >Bahamas</option>
                                                         <option value="Bahrain" >Bahrain</option>
                                                         <option value="Bangladesh" >Bangladesh</option>
                                                         <option value="Barbados" >Barbados</option>
                                                         <option value="Belarus" >Belarus</option>
                                                         <option value="Belgium" >Belgium</option>
                                                         <option value="Beliz" >Beliz</option>
                                                         <option value="Bermuda" >Bermuda</option>
                                                         <option value="Bolivia" >Bolivia</option>
                                                         <option value="Bosnia and Herzegovina" >Bosnia and Herzegovina</option>
                                                         <option value="Botswana" >Botswana</option>
                                                         <option value="Brazil" >Brazil</option>
                                                         <option value="Brunei Darussalam" >Brunei Darussalam</option>
                                                         <option value="Bulgaria" >Bulgaria</option>
                                                         <option value="Cambodia" >Cambodia</option>
                                                         <option value="Canada" >Canada</option>
                                                         <option value="Cayman Islands" >Cayman Islands</option>
                                                         <option value="Chile" >Chile</option>
                                                         <option value="China" >China</option>
                                                         <option value="Colombia" >Colombia</option>
                                                         <option value="Costa Rica" >Costa Rica</option>
                                                         <option value="Croatia" >Croatia</option>
                                                         <option value="Cuba" >Cuba</option>
                                                         <option value="Cyprus" >Cyprus</option>
                                                         <option value="Czech Republic" >Czech Republic</option>
                                                         <option value="Denmark" >Denmark</option>
                                                         <option value="Dominican Republic" >Dominican Republic</option>
                                                         <option value="East Caribbean" >East Caribbean</option>
                                                         <option value="Egypt" >Egypt</option>
                                                         <option value="El Salvador" >El Salvador</option>
                                                         <option value="Euro" >Euro</option>
                                                         <option value="Falkland Islands" >Falkland Islands</option>
                                                         <option value="Fiji" >Fiji</option>
                                                         <option value="France" >France</option>
                                                         <option value="Germany" >Germany</option>
                                                         <option value="Ghana" >Ghana</option>
                                                         <option value="Gibraltar" >Gibraltar</option>
                                                         <option value="Greece" >Greece</option>
                                                         <option value="Guatemala" >Guatemala</option>
                                                         <option value="Guernsey" >Guernsey</option>
                                                         <option value="Guyana" >Guyana</option>
                                                         <option value="Holland (Netherlands)" >Holland (Netherlands)</option>
                                                         <option value="Honduras" >Honduras</option>
                                                         <option value="Hong Kong" >Hong Kong</option>
                                                         <option value="Hungary" >Hungary</option>
                                                         <option value="Iceland" >Iceland</option>
                                                         <option value="India" >India</option>
                                                         <option value="Indonesia" >Indonesia</option>
                                                         <option value="Iran" >Iran</option>
                                                         <option value="Ireland" >Ireland</option>
                                                         <option value="Isle of Man" >Isle of Man</option>
                                                         <option value="Israel" >Israel</option>
                                                         <option value="Italy" >Italy</option>
                                                         <option value="Jamaica" >Jamaica</option>
                                                         <option value="Japan" >Japan</option>
                                                         <option value="Jersey" >Jersey</option>
                                                         <option value="Kazakhstan" >Kazakhstan</option>
                                                         <option value="Korea (North)" >Korea (North)</option>
                                                         <option value="Korea (South)" >Korea (South)</option>
                                                         <option value="Kyrgyzstan" >Kyrgyzstan</option>
                                                         <option value="Laos" >Laos</option>
                                                         <option value="Latvia" >Latvia</option>
                                                         <option value="Lebanon" >Lebanon</option>
                                                         <option value="Liberia" >Liberia</option>
                                                         <option value="Libya" >Libya</option>
                                                         <option value="Liechtenstein" >Liechtenstein</option>
                                                         <option value="Lithuania" >Lithuania</option>
                                                         <option value="Luxembourg" >Luxembourg</option>
                                                         <option value="Macedonia" >Macedonia</option>
                                                         <option value="Malaysia" >Malaysia</option>
                                                         <option value="Malta" >Malta</option>
                                                         <option value="Mauritius" >Mauritius</option>
                                                         <option value="Mexico" >Mexico</option>
                                                         <option value="Mongolia" >Mongolia</option>
                                                         <option value="Mozambique" >Mozambique</option>
                                                         <option value="Myanmar" >Myanmar</option>
                                                         <option value="Namibia" >Namibia</option>
                                                         <option value="Nepal" >Nepal</option>
                                                         <option value="Netherlands" >Netherlands</option>
                                                         <option value="Netherlands Antilles" >Netherlands Antilles</option>
                                                         <option value="New Zealand" >New Zealand</option>
                                                         <option value="Nicaragua" >Nicaragua</option>
                                                         <option value="Nigeria" >Nigeria</option>
                                                         <option value="North Korea" >North Korea</option>
                                                         <option value="Norway" >Norway</option>
                                                         <option value="Oman" >Oman</option>
                                                         <option value="Pakistan" >Pakistan</option>
                                                         <option value="Panama" >Panama</option>
                                                         <option value="Paraguay" >Paraguay</option>
                                                         <option value="Peru" >Peru</option>
                                                         <option value="Philippines" >Philippines</option>
                                                         <option value="Poland" >Poland</option>
                                                         <option value="Portugal" >Portugal</option>
                                                         <option value="Qatar" >Qatar</option>
                                                         <option value="Republic of Uganda" >Republic of Uganda</option>
                                                         <option value="Romania" >Romania</option>
                                                         <option value="Russia" >Russia</option>
                                                         <option value="Saint Helena" >Saint Helena</option>
                                                         <option value="Saudi Arabia" >Saudi Arabia</option>
                                                         <option value="Serbia" >Serbia</option>
                                                         <option value="Seychelles" >Seychelles</option>
                                                         <option value="Singapore" >Singapore</option>
                                                         <option value="Slovakia" >Slovakia</option>
                                                         <option value="Slovenia" >Slovenia</option>
                                                         <option value="Solomon Islands" >Solomon Islands</option>
                                                         <option value="Somalia" >Somalia</option>
                                                         <option value="South Africa" >South Africa</option>
                                                         <option value="South Korea" >South Korea</option>
                                                         <option value="Spain" >Spain</option>
                                                         <option value="Sri Lanka" >Sri Lanka</option>
                                                         <option value="State of Eritrea" >State of Eritrea</option>
                                                         <option value="Sudan" >Sudan</option>
                                                         <option value="Suriname" >Suriname</option>
                                                         <option value="Sweden" >Sweden</option>
                                                         <option value="Switzerland" >Switzerland</option>
                                                         <option value="Syria" >Syria</option>
                                                         <option value="Taiwan" >Taiwan</option>
                                                         <option value="Thailand" >Thailand</option>
                                                         <option value="Trinidad and Tobago" >Trinidad and Tobago</option>
                                                         <option value="Turkey" >Turkey</option>
                                                         <option value="Turkey" >Turkey</option>
                                                         <option value="Tuvalu" >Tuvalu</option>
                                                         <option value="Ukraine" >Ukraine</option>
                                                         <option value="United Arab Emirates" >United Arab Emirates</option>
                                                         <option value="United Kingdom" selected>United Kingdom</option>
                                                         <option value="United States of America" >United States of America</option>
                                                         <option value="Uruguay" >Uruguay</option>
                                                         <option value="Uzbekistan" >Uzbekistan</option>
                                                         <option value="Vatican City" >Vatican City</option>
                                                         <option value="Venezuela" >Venezuela</option>
                                                         <option value="Vietnam" >Vietnam</option>
                                                         <option value="Yemen" >Yemen</option>
                                                         <option value="Zimbabwe" >Zimbabwe</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelpb" class="placeholder">Place of Birth</label>
                                                      <input id="inputFloatingLabelpb" type="text" class="form-control input-border-bottom" name="place_birth" value="SYLHET">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelib" class="placeholder">Issued By</label>
                                                      <input id="inputFloatingLabelib" type="text" class="form-control input-border-bottom"  name="issue_by" value="HMPO">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group" >
                                                      <label for="inputFloatingLabelid" class="placeholder">Issued Date</label>
                                                      <input id="inputFloatingLabelid" type="date" class="form-control input-border-bottom" name="pas_iss_date" value="2021-07-03" >
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="pass_exp_date" class="placeholder">Expiry Date</label>
                                                      <input id="pass_exp_date" type="date" class="form-control input-border-bottom" onchange="getreviewdate();" name="pass_exp_date" value="2031-07-03">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="pass_review_date" class="placeholder"  style="margin-top:-12px;">Eligible Review Date</label>
                                                      <input id="pass_review_date" type="text" class="form-control input-border-bottom" readonly name="pass_review_date"  value="2031-06-03">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Upload Document</label>
                                                      <a href="https://climbr.co.in/public/employee_doc/jbfH0cM2hcjMHEseG1LGtARb0CJGnKB6jj6EHPra.jpg" target="_blank" download />download</a>
                                                      </br>
                                                      <input type="file" class="form-control"  name="pass_docu"  id="pass_docu" onchange="Filevalidationdopassdocu()">
                                                      <small> Please select  file which size up to 2mb</small>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-check">
                                                      <label>Is this your current passport?</label><br>
                                                      <!--<label class="form-radio-label">-->
                                                      <!--<input id="html" type="radio" name="cur_pass" value="Yes">-->
                                                      <!--<label for="html">Yes</label><br>-->
                                                      <!--<span class="form-radio-sign">Yes</span>-->
                                                      <!--</label>-->
                                                      <!--<label class="form-radio-label ml-3">-->
                                                      <!--<input id="No" type="radio" name="cur_passss" value="No" >-->
                                                      <!--<label for="No">No</label><br>-->
                                                      <!--</label>-->
                                                      
                                                      <table>

                                                          <tbody>
                                                            <tr>
                                                              <th style="width:40px" scope="row">Yes</th>
                                                              <td><input class="mt-2" type="radio" id="html" name="cur_pass" value="Yes"></label></td>
                                                            </tr>
                                                            <tr>
                                                              <th scope="row">No</th>
                                                              <td><input class="mt-2" type="radio" id="css" name="cur_pass" value="No"></td>
                                                            </tr>
                                                          </tbody>
                                                        </table>
                                                                                                             
                                                     <!--<label for="html"><span>Yes</span>  <input type="radio" id="html" name="cur_pass" value="Yes"></label><br/>-->
                                                     
                                                     <!--<label for="css"><span>No</span> </label>-->
                                                    
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label for="inputFloatingLabelrm" class="placeholder">Remarks</label>
                                                      <input id="inputFloatingLabelrm" type="text" class="form-control input-border-bottom" name="remarks" value="">
                                                   </div>
                                                </div>
                                             </div>
                                            
                                          </div>
                                          <div class="tab">
                                             <legend>Pay Details</legend>
                                             <div class="row">
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Class Name <span style="color:red">(*)</span></label>
                                                      <select data-placeholder="Choose a Groupe..." name="emp_group" class="form-control" id="emp_group" required>
                                                         <option value="" label="Select">Select</option>
                                                         <option value="1">1  PERMANENT OUT GRADED</option>
                                                         <option value="2">2-PERMANENT GRADED STAFF</option>
                                                         <option value="4">3-PERMANENT GRADED SUB STAFF</option>
                                                         <option value="5">4- CONTRACT STAFF</option>
                                                         <option value="6">5   PERMANENT NEW GRADED</option>
                                                         <option value="7">6- NEW NURSING STAFF</option>
                                                         <option value="8">7- DURWAN</option>
                                                         <option value="9">8- PBIN STAFF</option>
                                                         <option value="10">9 NEW GRADED SUB STAFF</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Basic Pay <span style="color:red">(*)</span></label>
                                                      <input type="number" step="any" id="emp_basic_pay" name="emp_basic_pay" value="" class="form-control"  oninput="basicpay()" required>
                                                      <!-- <select class="form-control" name="emp_basic_pay" id="emp_basic_pay" required>
                                                         </select> -->
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>APF Deduction Rate (%) <span style="color:red">(*)</span></label>
                                                      <input type="number" step="any" id="emp_apf_percent" name="emp_apf_percent" value="" class="form-control" required>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>PF Type <span style="color:red">(*)</span></label>
                                                      <select data-placeholder="Choose a PF..." name="emp_pf_type" id="emp_pf_type" class="form-control" required>
                                                         <option value="" label="Select">Select</option>
                                                         <option value="nps"  >NPS</option>
                                                         <option value="gpf"  >PF</option>
                                                         <option value="cpf"  >CPF </option>
                                                         <option value="na"  >NA </option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Passport No.</label>
                                                      <input type="text" name="emp_passport_no" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <!-- <div class="col-md-4">
                                                   <label>Pension Payment Order (PPO).</label>
                                                           <input type="hidden" name="emp_pension_no" value=""  class="form-control" >
                                                   </div> -->
                                                <!-- </div>
                                                   <div class="row form-group"> -->
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>PF No. </label>
                                                      <input type="text" name="emp_pf_no" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>UAN No. </label>
                                                      <input type="text" name="emp_uan_no" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>PAN No.</label>
                                                      <input type="text" name="emp_pan_no" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Bank Name <span style="color:red">(*)</span></label>
                                                      <select class="form-control" name="emp_bank_name" id="emp_bank_name" required onclick="populateBranch()">
                                                         <option value="" label="Select">Select</option>
                                                         @foreach($MastersbankName as $item)
                                                         <option value="{{$item->id}}">{{$item->master_bank_name}}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Branch <span style="color:red">(*)</span></label>
                                                      <select class="form-control" id="bank_branch_ids" name="bank_branch_id" onclick="branchfunc()" required>
                                                         <option value="" selected disabled required>Select</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>IFSC Code <span style="color:red">(*)</span></label>
                                                      <!-- <input type="text" name="emp_ifsc_code" value="" id="emp_ifsc_code" class="form-control"  required> -->
                                                      <select class="form-control" id="emp_ifsc_code" name="emp_ifsc_code" required>
                                                         <option value="" selected disabled required>Select</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Account No. <span style="color:red">(*)</span></label>
                                                      <input type="text" name="emp_account_no" id="emp_account_no" value="" class="form-control" required>
                                                   </div>
                                                </div>
                                                <!-- <input type="hidden" name="emp_gradess" value=""> -->
                                                <!-- <div class="col-md-4">
                                                   <label style="color:#C0C0C0">Pay Level </label>
                                                               <select class="form-control" name="emp_grade">
                                                   <option value="" label="Select">Select</option>
                                                                              <option value="LEVEL II" >LEVEL II</option>
                                                               <option value="LEVEL III" >LEVEL III</option>
                                                               <option value="LEVEL IV" >LEVEL IV</option>
                                                               <option value="LEVEL I" >LEVEL I</option>
                                                               <option value="LEVEL V" >LEVEL V</option>
                                                           </select>
                                                   </div> -->
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Aadhaar No. </label>
                                                      <input type="text" name="emp_aadhar_no" value="" class="form-control">
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Eligible For Pension </label>
                                                      <!-- <select class="form-control" name="emp_pension" id="emp_pension" required >
                                                         <option value="">Select</option>
                                                         <option value="Y" >Yes</option>
                                                         <option value="N" >No</option>
                                                         </select> -->
                                                      <input type="text" class="form-control" name="emp_pension" id="emp_pension" readonly>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Basic above 15K @ 12% PF </label>
                                                      <select class="form-control" name="emp_pf_inactuals" id="emp_pf_inactuals" required >
                                                         <option value="">Select</option>
                                                         <option value="Y" >Yes</option>
                                                         <option value="N" >No</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-4">
                                                   <div class="form-group">
                                                      <label>Eligible For Bonus </label>
                                                      <select class="form-control" name="emp_bonus" id="emp_bonus" required >
                                                         <option value="">Select</option>
                                                         <option value="Y" >Yes</option>
                                                         <option value="N" >No</option>
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
                                                      </tr>
                                                   </thead>
                                                   <tbody id="marksheetearn">
                                                      <tr class="itemslotpayearn" id="0">
                                                         <td>1</td>
                                                         <td>
                                                            <select class="form-control earninigcls" name="name_earn[]" id="name_earn0">
                                                               <option value='' selected>Select</option>
                                                               <?php
                                                                  $name = '';
                                                                  ?>
                                                               @foreach($EARNING as $value)
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
                                                                  }
                                                                  ?>
                                                               @if($value->head_type == 'earning')
                                                               <option value='{{$name}}'>{{ $value->head_name}}</option>
                                                               @endif
                                                               @endforeach
                                                            </select>
                                                         </td>
                                                         <td>
                                                            <select class="form-control" name="head_type[]" id="head_type0" onchange="checkearnvalue(this.value,0);">
                                                               <option value='' selected>Select</option>
                                                               <option value='F'>Fixed</option>
                                                               <option value='V'>Variable</option>
                                                            </select>
                                                         </td>
                                                         <td><input type="text" name="value_emp[]"  id="value0" class="form-control"></td>
                                                         <td>
                                                            <button class="btn-success" type="button" id="addearn1" onClick="addnewrowearn(1)" data-id="earn1"> <i class="fas fa-plus"></i> </button>
                                                         </td>
                                                      </tr>
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
                                                      <tr class="itemslotpaydeduct" id="0">
                                                         <td>1</td>
                                                         <td>
                                                            <select class="form-control deductcls" name="name_deduct[]" id="name_deduct0" onchange="checkdeducttype(this.value,0);">
                                                               <option value='' selected>Select</option>
                                                               <?php
                                                                  $name = '';
                                                                  ?>
                                                               @foreach($DEDUCATION as $value)
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
                                                                  }
                                                                  ?>
                                                               @if($value->head_type == 'deduction')
                                                               <option value='{{$name}}'>{{ $value->head_name }}</option>
                                                               @endif
                                                               @endforeach
                                                            </select>
                                                         </td>
                                                         <td>
                                                            <select class="form-control" name="head_typededuct[]" id="head_typededuct0" onchange="checkdeductvalue(this.value,0);">
                                                               <option value='' selected>Select</option>
                                                               <option value='F'>Fixed</option>
                                                               <option value='V'>Variable</option>
                                                            </select>
                                                         </td>
                                                         <td><input type="text" name="valuededuct[]"  id="valuededuct0" class="form-control"></td>
                                                         <td><button class="btn-success" type="button" id="adddeduct1" onClick="addnewrowdeduct(1)" data-id="deduct1"> <i class="fas fa-plus"></i> </button></td>
                                                      </tr>
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
                                        </div>
                                    </div>
                                   </div>
                           
                                 
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
             <div class="col-md-4">
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
         
           $.ajax({
              url:"{{url('employee/department-name')}}"+'/'+deiId,
         		type: "GET",
         
         		success: function(response) {
                  document.getElementById("rate_id").innerHTML = response;
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
             <div class="col-md-4">
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
             <div class="col-md-4">
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