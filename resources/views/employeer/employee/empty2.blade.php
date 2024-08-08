@extends('employeer.include.app')
@section('title', 'Home - HRMS admin template')
@section('css')
<style>
    .tab, .tab2, .tab3, .tab4, .tab5, .tab6, .tab7 {
      display: none;
    }
    .active {
      display: block;
    }
    .btn {
      margin: 10px;
      padding: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    .btn:disabled {
      background-color: #dcdcdc;
      cursor: not-allowed;
    }
  </style>
@endsection
@section('content')
<div class="main-panel">
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
                        <form name="basicform" id="basicform" method="post" action="" enctype="multipart/form-data" class="multisteps-form__form">
                           {{ csrf_field() }}
                           <!--single form panel-->
                           <div class="tab active">
                           <div class="multisteps-form__panel rounded bg-white js-active" data-animation="scaleIn">
                              <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Personal Details</h3>
                              <div class="multisteps-form__content">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel" class="col-form-label" style="margin-top:-12px;">Employee Code<span style="color:red;">*</span></label>
                                          <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" value="" readonly name="emp_code"  >
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel1" class="col-form-label">First Name <span style="color:red;">*</span></label>
                                          <input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="emp_fname"   >
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel2" class="col-form-label">Middle Name</label>
                                          <input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom" name="emp_mid_name">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel3" class="col-form-label">Last Name <span style="color:red;">*</span></label>
                                          <input id="inputFloatingLabel3" type="text" class="form-control input-border-bottom" name="emp_lname"  required="" >
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabel" class="col-form-label">Gender </label>
                                          <select class="select" id=""  name="emp_gender">
                                             <option value="">&nbsp;</option>
                                             <option value="Male">Male</option>
                                             <option value="Female">Female</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabelni" class="col-form-label">NI No.</label>
                                          <input id="inputFloatingLabelni" type="text" class="form-control input-border-bottom" name="ni_no" >
                                       </div>
                                    </div>
                                    <!--<div class="col-md-4">
                                       <div class="form-group form-floating-label">
                                       <input id="inputFloatingLabelfon" type="text" class="form-control input-border-bottom"  name="emp_father_name">
                                       <label for="inputFloatingLabelfon" class="col-form-label">Father's Name </label>
                                       </div>
                                       </div>
                                       -->
                                 </div>
                                 <div class="row ">
                                    <!--	<div class="col-md-4">
                                       <div class="form-group form-floating-label">
                                       <input id="inputFloatingLabel4" type="date" class="form-control input-border-bottom" name="marital_date">
                                       <label for="inputFloatingLabel4" class="col-form-label">Date of Marriage</label>
                                       </div>
                                       </div>-->
                                    <!--<div class="col-md-4">
                                       <div class="form-group form-floating-label">
                                       <input id="inputFloatingLabel5" type="text" class="form-control input-border-bottom" required="" name="spouse_name">
                                       <label for="inputFloatingLabel5" class="col-form-label">Spouse  Name</label>
                                       </div>
                                       </div>-->
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabeldob" style="padding-left: 10px;">Date of Birth </label>
                                          <input id="inputFloatingLabeldob" type="date" class="form-control input-border-bottom datepicker-here" name="emp_dob" data-language='en' data-position='top left'>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabel1" class="col-form-label">Marital Status</label>
                                          <select class="select" id="selectFloatingLabel1"  name="marital_status">
                                             <option value="">&nbsp;</option>
                                             <option value="Single">Single</option>
                                             <option value="Married">Married</option>
                                             <option value="Unmarried">Unmarried</option>
                                             <option value="Widow">Widow</option>
                                             <option value="Divorce">Divorce</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabel3" class="col-form-label"> Select Nationality</label>
                                          <select class="form-control input-border-bottom" id="selectFloatingLabel3" name="nationality">
                                             <option value="">&nbsp;</option>
                                             
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabelfon" class="col-form-label">Email <span style="color:red;">*</span></label>
                                          <input id="inputFloatingLabelfon" type="email" class="form-control input-border-bottom" required="" name="emp_ps_email">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabelphone" class="col-form-label">Contact Number <span style="color:red;">*</span></label>
                                          <input id="inputFloatingLabelphone" type="tel" class="form-control input-border-bottom" required="" name="emp_ps_phone">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabelphonealter" class="col-form-label">Alternative Number</label>
                                          <input id="inputFloatingLabelphonealter" type="tel" class="form-control input-border-bottom" name="em_contact">
                                       </div>
                                    </div>
                                 </div>
                                 <h3 style="margin-top:20px;color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Service Details</h3>
                                 <div class="row ">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabel3" class="col-form-label">Department </label>
                                          <select class="select" id="selectFloatingLabel3" name="emp_department"  onchange="chngdepartment(this.value);">
                                             <option value="">&nbsp;</option>
                                            
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabel4" class="col-form-label">Designation </label>
                                          <select class="select" id="selectFloatingLabel4"  name="emp_designation">
                                             <option value="">&nbsp;</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group ">
                                          <label for="inputFloatingLabel4" class="col-form-label">Date of Joining </label>
                                          <input id="inputFloatingLabel4 form-date" type="date" class="form-control "  name="emp_doj" max="<?= date('Y-m-d')?>" >
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabel5" class="col-form-label">Employment  Type  </label>
                                          <select class="select" id="selectFloatingLabel5"  name="emp_status">
                                             <option value="">&nbsp;</option>
                                            
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel6" class="col-form-label">Date of Confirmation</label>
                                          <input id="inputFloatingLabel6" type="date" class="form-control input-border-bottom"  name="date_confirm">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel7" class="col-form-label">Contract Start Date</label>
                                          <input id="inputFloatingLabel7" type="date" class="form-control input-border-bottom" name="start_date">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel8" class="col-form-label">Contract End Date (If Applicable)</label>
                                          <input id="inputFloatingLabel8" type="date" class="form-control input-border-bottom" name="end_date">
                                       </div>
                                    </div>
                                    <!--<div class="col-md-4">
                                       <div class="form-group form-floating-label">
                                       <input id="inputFloatingLabel9" type="text" class="form-control input-border-bottom" required="" name="fte" >
                                       <label for="inputFloatingLabel9" class="col-form-label">FTE</label>
                                       </div>
                                       </div>-->
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="inputFloatingLabel10" class="col-form-label">Job Location</label>
                                          <input id="inputFloatingLabel10" type="text" class="form-control input-border-bottom" name="job_loc" >
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4 form-group">
                                       <label class="col-form-label">Profile Picture</label>
                                       <input type="file" class=" form-control" name="emp_image" id="emp_image" onchange="Filevalidationproimge()">
                                       <small> Please select  image which size up to 2mb</small>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabelra" class="col-form-label">Reporting Authority</label>
                                          <select class="select" id="selectFloatingLabelra" name="emp_reporting_auth" >
                                             <option value="">&nbsp;</option>
                                           
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="selectFloatingLabells" class="col-form-label">Leave Sanction Authority</label>
                                          <select class="select" id="selectFloatingLabells"  name="emp_lv_sanc_auth" >
                                             <option value="">&nbsp;</option>
                                           
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div style="text-align: right;">
                                    <p style="color:red">(*) marked fields are mandatory fields</p>
                                 </div>
                              </div>
                           </div>
                           </div>
                           <!--single form panel-->
                           <!--single form panel-->
                           <div class="tab2">
                           <div class="multisteps-form__panel rounded bg-white " data-animation="scaleIn">
                              <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Educational  Details</h3>
                              <div class="multisteps-form__content">
                                 <div class="table-responsive">
                                    <table class="table table-bordered modify_input " style="width:100%;border-top: 1px solid #ddd;margin-top:15px;">
                                       <thead>
                                          <tr>
                                             <th>Sl. No.</th>
                                             <th>Qualification</th>
                                             <th>Subject</th>
                                             <th>Institution Name</th>
                                             <th>Awarding Body/ University</th>
                                             <th>Year of Passing</th>
                                             <th>Percentage</th>
                                             <th>Grade/Division</th>
                                             <th>Transcript Document 
                                             </th>
                                             <th>Certificate Document</th>
                                             <th></th>
                                          </tr>
                                       </thead>
                                       <tbody id="dynamic_row">
                                          <?php $tr_id=0; ?>
                                          <tr class="itemslot" id="<?php echo $tr_id; ?>" >
                                             <td>1</td>
                                             <td><input type="text" class="form-control" name="quli[]"></td>
                                             <td><input type="text" class="form-control" name="dis[]"></td>
                                             <td><input type="text" class="form-control" name="ins_nmae[]"></td>
                                             <td><input type="text" class="form-control" name="board[]"></td>
                                             <td><input type="text" class="form-control" name="year_passing[]"></td>
                                             <td><input type="text" class="form-control" name="perce[]"></td>
                                             <td><input type="text" class="form-control" name="grade[]"></td>
                                             <td><input type="file" id="doc<?= $tr_id ?>" class="form-control" name="doc[]" onchange="Filevalidationdocnew(<?= $tr_id ?>)">  <small> Please select  file which size up to 2mb</small></td>
                                             <td><input type="file" id="doc2<?= $tr_id ?>" class="form-control" name="doc2[]"  onchange="Filevalidationdocnewdoc(<?= $tr_id ?>)">  <small> Please select  file which size up to 2mb</small></td>
                                             <td><button class="btn-success" type="button" id="add<?php echo ($tr_id+1); ?>" onClick="addnewrow(<?php echo ($tr_id+1); ?>)" data-id="<?php echo ($tr_id+1); ?>"> <i class="fas fa-plus"></i> </button>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                                 <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Job Details</h3>
                                 <?php $tredu_id=0; ?>
                                 <div id="dynamic_row_edu">
                                    <div class="itemslotedu" id="<?php echo $tredu_id; ?>">
                                       <div class="row " >
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="inputFloatingLabel-jobt" class="col-form-label">Job Title</label>
                                                <input id="inputFloatingLabel-jobt" type="text" class="form-control input-border-bottom"  name="job_name[]">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="inputFloatingLabel-jobs" class="col-form-label">Start Date</label>
                                                <input id="inputFloatingLabel-jobs" type="date" class="form-control input-border-bottom" name="job_start_date[]">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="inputFloatingLabel-jobe" class="col-form-label">End Date </label>
                                                <input id="inputFloatingLabel-jobe" type="date" class="form-control input-border-bottom" name="job_end_date[]">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class="form-group">
                                                <label for="selectFloatingLabelexp" class="col-form-label">Year of Experience</label>
                                                <select class="select" id="selectFloatingLabelexp"  name="exp[]">
                                                   <option value="">&nbsp;</option>
                                                 
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label for="inputFloatingLabel-jobs" class="col-form-label">Job Description</label>
                                                <textarea id="inputFloatingLabel-jobs"  rows="5" class="form-control"  style="height:135px !important;resize:none;"  name="des[]"> </textarea>  
                                             </div>
                                          </div>
                                          <div class="col-md-2" style="margin-top:27px;">
                                             <button class="btn-success" type="button"  id="addedu<?php echo $tredu_id; ?>" onClick="addnewrowedu(<?php echo $tredu_id; ?>)" data-id="<?php echo $tredu_id; ?>"><i class="fas fa-plus"></i> </button>
                                          </div>
                                       </div>
                                    </div>
                                    </br>	
                                 </div>
                                 <div style="text-align: right;">
                                    <p style="color:red">(*) marked fields are mandatory fields</p>
                                 </div>
                                 
                              </div>
                           </div>
                           </div>

                            <div class="tab3">
                            <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                               <div class="multisteps-form__content">
                                  <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Emergency  / Next of Kin  Contact Details</h3>
                                  <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabelien" class="col-form-label">Name</label>
                                           <input id="inputFloatingLabelien" type="text" class="form-control input-border-bottom" name="em_name">
                                        </div>
                                     </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabelier" class="col-form-label">Relationship</label>
                                           <!-- <input id="inputFloatingLabelier" type="text" class="form-control input-border-bottom" name="em_relation">-->
                                           <select class="select" id="inputFloatingLabelier" name="em_relation" onchange="crinabi(this.value);">
                                              <option value="">&nbsp;</option>
                                
                                           </select>
                                        </div>
                                     </div>
                                     <div class="col-md-3 " id="criman_new"   <?php  if(request()->get('q')!=''){  if($employee_rs[0]->em_relation=='Others'){ ?> style="display:block;" <?php }else { ?> style="display:none;" <?php   } }else{ ?> style="display:none;" <?php } ?> >
                                        <div class="form-group form-floating-label">
                                           <input id="relation_others"  type="text" class="form-control input-border-bottom" name="relation_others"  >
                                           <label for="relation_others" class="col-form-label">Give Details </label>
                                        </div>
                                     </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabeliemail" class="col-form-label">Email</label>
                                           <input id="inputFloatingLabeliemail" type="email" class="form-control input-border-bottom" name="em_email" >
                                        </div>
                                     </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabeliem" class="col-form-label">Emergency Contact No.</label>
                                           <input id="inputFloatingLabeliem" type="text" class="form-control input-border-bottom" name="em_phone" >
                                        </div>
                                     </div>
                                  </div>
                                  <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="inputFloatingLabelienad" class="col-form-label">Address</label>
                                           <input id="inputFloatingLabelienad" type="text" class="form-control input-border-bottom" name="em_address" >
                                        </div>
                                     </div>
                                  </div>
                                  <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Certified Membership</h3>
                                  <div class="row">
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabelicl" class="col-form-label">Title of Certified License</label>
                                           <input id="inputFloatingLabelicl" type="text" class="form-control input-border-bottom" name="titleof_license">
                                        </div>
                                     </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabeliln" class="col-form-label">License Number</label>
                                           <input id="inputFloatingLabeliln" type="text" class="form-control input-border-bottom" name="cf_license_number" >
                                        </div>
                                     </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabelisd" class="col-form-label">Start Date</label>
                                           <input id="inputFloatingLabelisd" type="date" class="form-control input-border-bottom" name="cf_start_date" >
                                        </div>
                                     </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                           <label for="inputFloatingLabelied" class="col-form-label">End Date</label>
                                           <input id="inputFloatingLabelied" type="date" class="form-control input-border-bottom" name="cf_end_date" >
                                        </div>
                                     </div>
                                  </div>
                                  <div style="text-align: right;">
                                     <p style="color:red">(*) marked fields are mandatory fields</p>
                                  </div>
                                  <div class="button-row d-flex mt-4">
                                     {{-- <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                                     <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button> --}}
                                  </div>
                               </div>
                            </div>
                            </div>

                            <div class="tab4">
                            <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Contact Information (Correspondence Address)</h3>
                                <div class="multisteps-form__content">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parmenent_pincode" class="col-form-label">Post Code</label>
                                            <input id="parmenent_pincode" type="text" class="form-control input-border-bottom"  onchange="getcode();"  name="emp_pr_pincode">
                                        </div>
                                    </div>
                                    {{-- 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="se_add" class="col-form-label">Select Address  </label>
                                            <select class="form-control input-border-bottom" id="se_add" name="se_add" onchange="countryfunjj(this.value);">
                                            <option value="">&nbsp;</option>
                                            </select>
                                        </div>
                                    </div>
                                    --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parmenent_street_name" class="col-form-label">Address Line 1</label>
                                            <input id="parmenent_street_name" type="text" class="form-control input-border-bottom"  name="emp_pr_street_no" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parmenent_village" class="col-form-label">Address Line 2</label>
                                            <input id="parmenent_village" type="text" class="form-control input-border-bottom"  name="emp_per_village">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_pr_state" class="col-form-label">Address Line 3</label>
                                            <input id="emp_pr_state" type="text" class="form-control input-border-bottom"  name="emp_pr_state" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parmenent_city" class="col-form-label">City / County</label>
                                            <input  id="parmenent_city"  type="text" class="form-control input-border-bottom" name="emp_pr_city" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parmenent_country" class="col-form-label">Country</label>
                                            <select class="select"   name="emp_pr_country" id="parmenent_country">
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}"   @if(trim($currency_valu->country)=='United Kingdom') selected  @endif>{{$currency_valu->country}}</option>
                                            @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label for="pr_add_proof" class="col-form-label">Proof Of Address</label>
                                            <input  type="file" class="form-control "  name="pr_add_proof"  id="pr_add_proof" onchange="Filevalidationdoproff()">
                                            <small> Please select  file which size up to 2mb</small>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Other Documents</h3>
                                <?php $trupload_id=0; ?>
                                <div id="dynamic_row_upload">
                                    <div class="row itemslotupload" id="<?php echo $trupload_id; ?>">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                            <label for="selectFloatingLabel" class="col-form-label">Type of Document</label>
                                            <input id="selectFloatingLabel" type="text" class="form-control input-border-bottom"  name="type_doc[]">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Uplaod Documents</label>
                                            <input type="file" class="form-control-file" id="docu_nat<?php echo $trupload_id; ?>" onchange="Filevalidationdocother(<?php echo $trupload_id; ?>)" name="docu_nat[]">
                                            <small> Please select  file which size up to 2mb</small>
                                        </div>
                                        <div class="col-md-4" style="margin-top:13px;"><button class="btn-success" type="button"  id="addupload<?php echo $trupload_id; ?>" onClick="addnewrowupload(<?php echo $trupload_id; ?>)" data-id="<?php echo $trupload_id; ?>"><i class="fas fa-plus"></i> </button></div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <p style="color:red">(*) marked fields are mandatory fields</p>
                                </div>
                                <div class="button-row d-flex mt-4">
                                    {{-- <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                                    <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button> --}}
                                </div>
                                </div>
                            </div>
                            </div>

                            <div class="tab5">
                            <div class="multisteps-form__panel  rounded bg-white" data-animation="scaleIn">
                                <h4 style="color: #1269db;">Passport Details</h4>
                                <div class="multisteps-form__content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabeldn" class="col-form-label">Passport No.</label>
                                            <input id="inputFloatingLabeldn" type="text" class="form-control input-border-bottom" name="pass_doc_no">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
                                            <select class="select" id="selectFloatingLabelntp" name="pass_nat">
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                            @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label for="inputFloatingLabelpb" class="col-form-label">Place of Birth</label>	
                                            <input id="inputFloatingLabelpb" type="text" class="form-control input-border-bottom"  name="place_birth">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelib" class="col-form-label">Issued By</label>	
                                            <input id="inputFloatingLabelib" type="text" class="form-control input-border-bottom"  name="issue_by">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group" >
                                            <label for="inputFloatingLabelid" class="col-form-label">Issued Date</label>			
                                            <input id="inputFloatingLabelid" type="date" class="form-control input-border-bottom" name="pas_iss_date" >	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pass_exp_date" class="col-form-label">Expiry Date</label>		
                                            <input id="pass_exp_date" type="date" class="form-control input-border-bottom" name="pass_exp_date" onchange="getreviewdate();">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">	
                                            <label>Upload Document</label>
                                            <input id="pass_review_date" type="date" class="form-control input-border-bottom" readonly name="pass_review_date" >	
                                            <label for="pass_review_date" class="col-form-label"  style="margin-top:-12px;">Eligible Review Date</label>																												
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="file" class="form-control"  name="pass_docu" id="pass_docu" onchange="Filevalidationdopassdocu()">
                                        <small> Please select  file which size up to 2mb</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label>Is this your current passport?</label><br>
                                            <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="cur_pass" value="Yes" checked="">
                                            <span class="form-radio-sign">Yes</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="cur_pass" value="No">
                                            <span class="form-radio-sign">No</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelrm" class="col-form-label">Remarks</label>
                                            <input id="inputFloatingLabelrm" type="text" class="form-control input-border-bottom" name="remarks">
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <br>
                                <hr>
                                <h4 style="color: #1269db;">Visa/BRP Details</h4>
                                <div class="multisteps-form__content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">Visa/BRP No.</label>	
                                            <input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="visa_doc_no">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
                                            <select class="select" id="selectFloatingLabelntp"  name="visa_nat" >
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                            @endforeach		 --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabel" class="col-form-label">Country of Residence</label>
                                            <select class="select" id="selectFloatingLabel" name="country_residence">
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                            @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelib1" class="col-form-label">Issued By</label>	
                                            <input id="inputFloatingLabelib1" type="text" class="form-control input-border-bottom"  name="visa_issue">	
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelid1" class="col-form-label">Issued Date</label>		
                                            <input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="visa_issue_date">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-floating-label" >
                                            <label for="visa_exp_date" class="col-form-label">Expiry Date</label>	
                                            <input id="visa_exp_date" type="date" class="form-control input-border-bottom" name="visa_exp_date" 
                                            onchange="getreviewvisdate();">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="visa_review_date" class="col-form-label"  style="">Eligible Review Date</label>		
                                            <input id="visa_review_date" type="date" readonly class="form-control input-border-bottom" name="visa_review_date">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Upload Front Side Document</label>
                                        <input type="file" class="form-control" name="visa_upload_doc" id="visa_upload_doc" onchange="Filevalidationdopassdvisae()">
                                        <small> Please select  file which size up to 2mb</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Upload Back Side Document</label>
                                        <input type="file" class="form-control" name="visaback_doc" id="visaback_doc" onchange="Filevalidationdopassdvisaeback()">
                                        <small> Please select  file which size up to 2mb</small>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label>Is this your current visa?</label><br>
                                            <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="visa_cur" value="Yes" checked="">
                                            <span class="form-radio-sign">Yes</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="visa_cur" value="No">
                                            <span class="form-radio-sign">No</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelrm1" class="col-form-label">Remarks</label>
                                            <input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="visa_remarks" >
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </br>
                                <hr>
                                <h4 style="color: #1269db;">EUSS/Time limit details </h4>
                                <div class="multisteps-form__content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">Reference Number.</label>
                                            <input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="euss_ref_no">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
                                            <select class="select" id="selectFloatingLabelntp"  name="euss_nation" >
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                            @endforeach		 --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelid1" class="col-form-label">Issued Date</label>
                                            <input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="euss_issue_date">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" >
                                            <label for="euss_exp_date" class="col-form-label">Expiry Date</label>		
                                            <input id="euss_exp_date" type="date" class="form-control input-border-bottom" name="euss_exp_date" 
                                            onchange="getrevieweussdate();">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="euss_review_date" class="col-form-label">Eligible Review Date</label>	
                                            <input id="euss_review_date" type="date" readonly class="form-control input-border-bottom" name="euss_review_date">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Upload Document</label>
                                        <input type="file" class="form-control" name="euss_upload_doc" id="euss_upload_doc" onchange="Filevalidationdopassduploadae()">
                                        <small> Please select  file which size up to 2mb</small>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label>Is this your current status?</label><br>
                                            <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="euss_cur" value="Yes" checked="">
                                            <span class="form-radio-sign">Yes</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="euss_cur" value="No">
                                            <span class="form-radio-sign">No</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelrm1" class="col-form-label">Remarks</label>
                                            <input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="euss_remarks" >
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <br>
                                <hr>
                                <h4 style="color: #1269db;">Disclosure and Barring Service (DBS) details </h4>
                                <div class="multisteps-form__content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">DBS Type</label>
                                            <select class="select" id="dbs_type"  name="dbs_type" >
                                            <option value="">&nbsp;</option>
                                            <option value="Basic">Basic</option>
                                            <option value="Standard">Standard</option>
                                            <option value="Advanced">Advanced</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">Reference Number.</label>
                                            <input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="dbs_ref_no"  value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
                                            <select class="select" id="selectFloatingLabelntp"  name="dbs_nation" >
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}"  >{{$currency_valu->country}}</option>
                                            @endforeach		 --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelid1" class="col-form-label">Issued Date</label>
                                            <input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="dbs_issue_date" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group" >
                                            <label for="dbs_exp_date" class="col-form-label">Expiry Date</label>
                                            <input id="dbs_exp_date" type="date" class="form-control input-border-bottom" name="dbs_exp_date"
                                            onchange="getreviewdbsdate();"  value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="dbs_review_date" class="col-form-label"  style="margin-top:-12px;">Eligible Review Date</label>
                                            <input id="dbs_review_date" type="date" readonly class="form-control input-border-bottom" name="dbs_review_date"   value="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Upload Document</label>
                                        <input type="file" class="form-control" name="dbs_upload_doc" id="dbs_upload_doc" onchange="Filevalidationdopassduploadae()">
                                        <small> Please select  file which size up to 2mb</small>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label>Is this your current status?</label><br>
                                            <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio"   name="dbs_cur" value="Yes" checked="">
                                            <span class="form-radio-sign">Yes</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="dbs_cur"    value="No">
                                            <span class="form-radio-sign">No</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelrm1" class="col-form-label">Remarks</label>
                                            <input id="inputFloatingLabelrm1" type="text"  value=""  class="form-control input-border-bottom" name="dbs_remarks" >
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </br>
                                <hr>
                                <h4 style="color: #1269db;">National Id details </h4>
                                <div class="multisteps-form__content">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">National id number.</label>	
                                            <input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="nat_id_no">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
                                            <select class="select" id="selectFloatingLabelntp"  name="nat_nation" >
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                            @endforeach		 --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Country of Residence</label>
                                            <select class="select" id="selectFloatingLabelntp"  name="nat_country_res" >
                                            <option value="">&nbsp;</option>
                                            {{-- @foreach($currency_user as $currency_valu)
                                            <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                            @endforeach		 --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelid1" class="col-form-label">Issued Date</label>	
                                            <input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="nat_issue_date">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-floating-label" ><input id="nat_exp_date" type="date" class="form-control input-border-bottom" name="nat_exp_date" 
                                            onchange="getreviewnatdate();">	
                                            <label for="nat_exp_date" class="col-form-label">Expiry Date</label>																												
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nat_review_date" class="col-form-label">Eligible Review Date</label>	
                                            <input id="nat_review_date" type="date" readonly class="form-control input-border-bottom" name="nat_review_date">	
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Upload Document</label>
                                        <input type="file" class="form-control" name="nat_upload_doc" id="nat_upload_doc" onchange="Filevalidationdopassduploadnat()">
                                        <small> Please select  file which size up to 2mb</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <label>Is this your current status?</label><br>
                                            <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="nat_cur" value="Yes" checked="">
                                            <span class="form-radio-sign">Yes</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="nat_cur" value="No">
                                            <span class="form-radio-sign">No</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="inputFloatingLabelrm1" class="col-form-label">Remarks</label>
                                            <input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="nat_remarks" >
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </br>
                                <hr>
                                <h4 style="color: #1269db;">Other Details </h4>
                                <div class="multisteps-form__content">
                                <?php $truotherdocpload_id=0; ?>
                                <div id="dynamic_row_upload_other">
                                    <div class="row itemslototherupload" id="<?php echo $truotherdocpload_id; ?>">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">Document name.</label>
                                            <input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_name[]">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="inputFloatingLabeldn1" class="col-form-label">Document reference number.</label>
                                            <input id="inputFloatingLabeldn1" type="text" class="form-control input-border-bottom"  name="doc_ref_no[]">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="selectFloatingLabelntp" class="col-form-label">Nationality</label>
                                            <select class="select" id="selectFloatingLabelntp"  name="doc_nation[]" >
                                                <option value="">&nbsp;</option>
                                                {{-- @foreach($currency_user as $currency_valu)
                                                <option value="{{trim($currency_valu->country)}}" >{{$currency_valu->country}}</option>
                                                @endforeach		 --}}
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="inputFloatingLabelid1" class="col-form-label">Issued Date</label>	
                                            <input id="inputFloatingLabelid1" type="date" class="form-control input-border-bottom" name="doc_issue_date[]">	
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" >
                                            <label for="doc_exp_date" class="col-form-label">Expiry Date</label>	
                                            <input id="doc_exp_date<?php echo $truotherdocpload_id; ?>" type="date" class="form-control input-border-bottom" name="doc_exp_date[]" 
                                                onchange="getreviewnatdateother(<?php echo $truotherdocpload_id; ?>);">	
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="doc_review_date" class="col-form-label"  style="margin-top:-12px;">Eligible Review Date</label>  
                                            <input id="doc_review_date<?php echo $truotherdocpload_id; ?>" type="date" readonly class="form-control input-border-bottom" name="doc_review_date[]">	
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Upload Document</label>
                                            <input type="file" class="form-control" name="doc_upload_doc[]" id="doc_upload_doc<?php echo $truotherdocpload_id; ?>" onchange="Filevalidationdopassduploadnatother(<?php echo $truotherdocpload_id; ?>)">
                                            <small> Please select  file which size up to 2mb</small>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                            <label>Is this your current status?</label><br>
                                            <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" name="doc_cur[]" value="Yes" checked="">
                                            <span class="form-radio-sign">Yes</span>
                                            </label>
                                            <label class="form-radio-label ml-3">
                                            <input class="form-radio-input" type="radio" name="doc_cur[]" value="No">
                                            <span class="form-radio-sign">No</span>
                                            </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <label for="inputFloatingLabelrm1" class="col-form-label">Remarks</label>
                                            <input id="inputFloatingLabelrm1" type="text" class="form-control input-border-bottom" name="doc_remarks[]" >
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin-top:27px;"><button class="btn-success" type="button"  id="adduploadother<?php echo $truotherdocpload_id; ?>" onClick="addnewrowuploadother(<?php echo $truotherdocpload_id; ?>)" data-id="<?php echo $truotherdocpload_id; ?>"><i class="fas fa-plus"></i> </button></div>
                                    </div>
                                    </br>
                                </div>
                                </div>
                                <div style="text-align: right;">
                                <p style="color:red">(*) marked fields are mandatory fields</p>
                                </div>
                                <div class="button-row d-flex mt-4">
                                {{-- <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                                <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button> --}}
                                <!--<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>-->
                                </div>
                            </div>
                            </div>
                           <div class="tab6">
                           <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                            <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Pay Details</h3>
                            <div class="multisteps-form__content">
                               <div class="row">
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="emp_group_name" class="col-form-label">Pay Group </label>
                                        <select class="select" id="emp_group_name" name="emp_group_name" onchange="paygr(this.value);">
                                           <option value="">&nbsp;</option>
                                           {{-- @foreach($grade as $gradeval)
                                           <option value="{{$gradeval->id}}" >{{$gradeval->grade_name}}</option>
                                           @endforeach --}}
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="emp_pay_scale" class="col-form-label">Annual Pay</label>
                                        <select class="form-control input-border-bottom" id="emp_pay_scale"  name="emp_pay_scale">
                                           <option value="">&nbsp;</option>
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="wedges_paymode" class="col-form-label">Wedges pay mode </label>
                                        <select class="select" id="wedges_paymode" name="wedges_paymode">
                                           <option value="">&nbsp;</option>
                                           {{-- @foreach($payment_wedes_rs as $gradevalwed)
                                           <option value="{{$gradevalwed->id}}" >{{$gradevalwed->pay_type}}</option>
                                           @endforeach --}}
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="selectFloatingLabelpt" class="col-form-label">Payment Type</label>
                                        <select class="select" id="selectFloatingLabelpt" name="emp_payment_type" onchange="pay_type_epmloyee(this.value);">
                                           <option value="">&nbsp;</option>
                                           {{-- @foreach($payment_type_master as $valtion)
                                           <option value="{{$valtion->id}}" >{{$valtion->pay_type}}</option>
                                           @endforeach --}}
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label for="daily" class="col-form-label">Basic / Daily Wedges</label>
                                        <input id="daily" type="text" class="form-control input-border-bottom" name="daily">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label for="min_work" class="col-form-label">Min. Working Hour</label>
                                        <input id="min_work" type="text" class="form-control" name="min_work">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label for="min_rate" class="col-form-label">Rate</label>
                                        <input id="min_rate" type="text" class="form-control "  name="min_rate">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="selectFloatingLabeltc" class="col-form-label">Tax Code</label>
                                        <select class="select" id="selectFloatingLabeltc"  name="tax_emp" onchange="tax_epmloyee(this.value);">
                                           <option value="">&nbsp;</option>
                                           {{-- @foreach($tax_master as $taxtion)
                                           <option value="{{$taxtion->id}}" >{{$taxtion->tax_code}}</option>
                                           @endforeach --}}
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label for="tax_ref" class="col-form-label">Tax Reference</label>
                                        <input id="tax_ref" type="text" class="form-control "  name="tax_ref">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label for="tax_per" class="col-form-label">Tax Percentage</label>
                                        <input id="tax_per" type="text" class="form-control "  name="tax_per">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="selectFloatingLabepm" class="col-form-label">Payment Mode</label>
                                        <select class="select" id="selectFloatingLabepm"  name="emp_pay_type">
                                           <option value="">&nbsp;</option>
                                           <option value="Cash">Cash</option>
                                           <option value="Bank">Bank</option>
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="emp_bank_name" class="col-form-label">Bank Name</label>
                                        <select class="select" name="emp_bank_name" id="emp_bank_name"  onchange="populateBranch(this.value);">
                                           <option value="">&nbsp;</option>
                                           {{-- @if(isset($bank) && !empty($bank))
                                           @foreach($bank as $key=>$value)
                                           <option value="{{ $value->id}}" >{{ $value->master_bank_name}}</option>
                                           @endforeach
                                           @endif --}}
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="inputFloatingLabelbrn" class="col-form-label">Branch Name</label>
                                        <input id="inputFloatingLabelbrn" type="text" class="form-control input-border-bottom"  name="bank_branch_id">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="inputFloatingLabelbn" class="col-form-label">Account No</label>
                                        <input id="inputFloatingLabelbn" type="text" class="form-control input-border-bottom" name="emp_account_no">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group ">
                                        <label for="emp_sort_code" class="col-form-label">Sort Code</label>
                                        <input id="emp_sort_code" type="text" class="form-control"  name="emp_sort_code">
                                     </div>
                                  </div>
                                  <div class="col-md-4">
                                     <div class="form-group">
                                        <label for="selectFloatingLabelpc" class="col-form-label">Payment Currency</label>
                                        <select class="select" id="selectFloatingLabelpc" name="currency">
                                           <option value="">&nbsp;</option>
                                           {{-- @foreach($currency_master as $currtion)
                                           <option value="{{$currtion->code}}" >{{$currtion->code}}</option>
                                           @endforeach --}}
                                        </select>
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <div style="text-align: right;">
                               <p style="color:red">(*) marked fields are mandatory fields</p>
                            </div>
                            <div class="button-row d-flex mt-4">
                               {{-- <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                               <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button> --}}
                               <!--<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>-->
                            </div>
                           </div>
                           </div>
                            <div class="tab7">
                                <div class="multisteps-form__panel rounded bg-white" data-animation="scaleIn">
                                    <h3 class="multisteps-form__title" style="color: #1269db;border-bottom: 1px solid #ddd;padding-bottom: 11px;">Pay Structure</h3>
                                    <div class="multisteps-form__content">
                                       <h3 class="multisteps-form__title" style="background: #1572e8;color: #fff;padding: 4px 15px;">Payment (Taxable)</h3>
                                       <div class="row form-group">
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox"   name="da" value="1"> Dearness Allowance</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox"  name="hra" value="1"> House Rent Allowance</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox" name="conven_ta" value="1"> Conveyance Allowance</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox"  name="perfomance" value="1"> Performance Allowance</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox"  name="monthly_al" value="1"> Monthly Fixed Allowance</label>
                                       </div>
                                       <h3 class="multisteps-form__title" style="background: #1572e8;color: #fff;padding: 4px 15px;">Deduction</h3>
                                       <div class="row form-group">
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox" name="pf_al" value="1" > NI Deduction</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox" name="income_tax" value="1"> I. Tax Deduction</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox" name="cess" value="1"> I. Tax Cess</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox" name="esi" value="1"> ESI</label>
                                          <label class="col-md-3 checkbox-inline"><input type="checkbox" name="professional_tax" value="1"> Prof Tax</label>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="button-row d-flex mt-4">
                                       {{-- <button class="btn btn-primary js-btn-prev" type="button" title="Prev">Back</button>
                                       <button class="btn btn-info ml-auto"  type="submit" title="Submit">Submit</button> --}}
                                       <!--<button class="btn btn-success ml-auto" type="button" title="Send">Send</button>-->
                                    </div>
                                 </div>
                                 </div>
                           <div class="button-row d-flex mt-4">
                            {{-- <button class="btn btn-primary js-btn-prev" type="button" title="Prev"  id="myBtn" onclick="topFunction()">Back</button>
                            <button class="btn btn-primary ml-auto js-btn-next" type="button" title="Next"  id="myBtn" onclick="topFunction()">Next</button> --}}
                            <button class="btn" id="prevBtn" onclick="showTab(-1)" disabled>Previous</button>
                            <button class="btn" id="nextBtn" onclick="showTab(1)">Next</button>
                         </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script>
    let currentTab = 0;
    
    function showTab(n) {
      const tabs = document.querySelectorAll('.tab, .tab2, .tab3, .tab4, .tab5, .tab6, .tab7');
      tabs[currentTab].classList.remove('active');
      currentTab = currentTab + n;
  
      if (currentTab < 0) {
        currentTab = 0;
      }
      if (currentTab >= tabs.length) {
        currentTab = tabs.length - 1;
      }
  
      tabs[currentTab].classList.add('active');
      
      document.getElementById("prevBtn").disabled = currentTab === 0;
      document.getElementById("nextBtn").disabled = currentTab === tabs.length - 1;
    }
  </script>
<script type="text/javascript" src="{{ asset('employeeassets/js/datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('employeeassets/js/datepicker.en.js')}}"></script>
@endsection