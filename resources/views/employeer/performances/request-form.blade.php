@extends('employeer.include.app')
@section('title', 'Add Performance Request')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  {{-- <h4 class="card-title"><i class="far fa-user"></i> Add Performance Request</h4> --}}
                    @if($mode == 'edit')
                    <h4 class="card-title"><i class="far fa-user"></i> Update Performance Request</h4>
                    @else
                    <h4 class="card-title"><i class="far fa-user"></i> Add Performance Request</h4>
                    @endif 
               </div>
               @if(Session::has('message'))										
               <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
               @endif
               @if(Session::has('error'))										
               <div class="alert alert-success" style="text-align:center;">{{ Session::get('error') }}</div>
               @endif
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form id="<?php if ($mode == 'edit') {
                              echo 'frm_performance_edit_request';
                          } else {
                              echo 'frm_performance_request';
                          } ?>" method="POST" action="{{url('performances/request')}}">
                  @include('performancemanagement.include.messages')
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="clearfix"></div>
                  <div class="lv-due" style="border:none;">
                      <div class="row form-group lv-due-body">
                          <div class="col-md-6">
                              <label class="col-form-label">Department <span>(*)</span></label>

                              <?php if ($mode === 'edit') {

                              ?>
                                  <input class="form-control" readonly value="<?php echo $performance->emp_department; ?>" />
                              <?php } else { ?>
                                  <select class="select" id="department">
                                      @foreach($departments as $d)
                                      <option value="{{$d->department_name}}">{{$d->department_name}}</option>
                                      @endforeach
                                  </select>
                              <?php
                              } ?>


                          </div>
                          <div class="col-md-6">
                              <label class="col-form-label">Employee Name <span>(*)</span></label>
                              <!-- <input type="text" class="form-control" id="employee" /> -->
                              <?php if ($mode === 'edit') {

                              ?>
                                  <input class="form-control" readonly value="<?php echo $performance->emp_fname . '' . ($performance->emp_mname ? ' ' . $performance->emp_mname : '') . ($performance->emp_lname ? ' ' . $performance->emp_lname : ''); ?>" />
                                  <input type="hidden" name="emp_code" value="<?php echo $performance->emp_code; ?>" />
                              <?php } else { ?>
                                  <select id="employee" class="select" name="emp_code">


                                  </select>
                              <?php } ?>

                          </div>


                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <label class="col-form-label">Job title <span>(*)</span></label>
                              <input class="form-control" id="job_title" readonly value="<?php if ($mode == 'edit') echo $performance->emp_designation; ?>" />

                          </div>
                          <div class="col-md-6">
                              <label class="col-form-label">Date of Joining <span>(*)</span></label>
                              <input class="form-control" id="doj" readonly value="<?php if ($mode == 'edit') echo date('d-m-Y', strtotime($performance->emp_doj)); ?>" />

                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <label class="col-form-label">Apprisal Period Start date<span>(*)</span></label>
                              <input class="form-control" id="app_period_start_date" name="apprisal_period_start" value="<?php if ($mode == 'edit') echo date('d-m-Y', strtotime($performance->apprisal_period_start)); ?>" <?php if ($userType !== 'employer') {
                                                                                                                                                                                                                                  echo 'readonly';
                                                                                                                                                                                                                                  echo ' disabled="disabled"';
                                                                                                                                                                                                                              } ?> />

                          </div>
                          <div class="col-md-6">
                              <label class="col-form-label">Apprisal Period End Date<span>(*)</span></label>
                              <input class="form-control" id="app_period_end_date" name="apprisal_period_end" value="<?php if ($mode == 'edit') echo date('d-m-Y', strtotime($performance->apprisal_period_end)); ?>" <?php if ($userType !== 'employer') {
                                                                                                                                                                                                                          echo 'readonly';
                                                                                                                                                                                                                          echo ' disabled="disabled"';
                                                                                                                                                                                                                      } ?> />

                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <label class="col-form-label">Reporting Manager<span>(*)</span></label>
                              <input class="form-control" id="rep_auth" readonly name="rep_auth" value="<?php if ($mode == 'edit') {
                                                                                                              echo ($performance->rep_fname ? $performance->rep_fname : "") . '' . ($performance->rep_mname ? ' ' . $performance->rep_mname : '') . ($performance->rep_lname ? ' ' . $performance->rep_lname : '');
                                                                                                          } ?>" />
                              <input class="form-control" id="rep_auth_id" type="hidden" name="rep_auth_id" value="<?php if ($mode == 'edit') {
                                                                                                                          echo $performance->emp_reporting_auth;
                                                                                                                      } ?>" />
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          </div>

                      </div>
                      @if($mode==='edit')

                      <div class="row">
                          <div class="col-md-12">

                              @if($userType=='employer')
                              @if($performance->status!=='pending')
                              <label class="col-form-label">Rating<span>(*)</span></label>
                              <input type='text' readonly name="rating" class="form-control" value="<?php echo $performance->rating; ?>" />
                              @endif
                              @else
                              <label class="col-form-label">Rating<span>(*)</span></label>
                              <select class="form-control" id="per_rating" name="rating" <?php ?>>
                                  <option value="">Select Rating</option>
                                  @for($i=1;$i<=5;$i++) <option value="{{$i}}" <?php if ($performance->rating == $i) echo "selected"; ?>>{{$i}}</option>
                                      @endfor

                              </select>
                              @endif
                          </div>
                          @if($userType=='employer')
                          @if($performance->status!=='pending')
                          <div class="col-md-12">
                              <label class="col-form-label">Comments<span>(*)</span></label>
                              <textarea class="form-control" id="performance_comments" name="performance_comments" <?php if ($userType == 'employer') echo "readonly"; ?>>{{$performance->performance_comments}}</textarea>

                          </div>
                          @endif
                          @else
                          <div class="col-md-12">
                              <label class="col-form-label">Comments<span>(*)</span></label>
                              <textarea class="form-control" id="performance_comments" name="performance_comments" <?php if ($userType == 'employer') echo "readonly"; ?>>{{$performance->performance_comments}}</textarea>

                          </div>
                          @endif

                      </div>
                      @endif
                      <?php


                      ?>
                      <br>
                      <div class="row">
                          <div class="col-md-4 btn-up">
                              @if($userType=='employer')
                              <!-- <button type="submit" class="btn btn-danger btn-sm" id="btn_project_create">Submit</button> -->
                              <button class="btn btn-primary" type="submit" id="btn_performance_request_create">Submit</button>
                              @else
                              @if($mode=='edit' && (strtotime($performance->apprisal_period_start)<=time() && strtotime($performance->apprisal_period_end)>=time()))
                                  <button class="btn btn-default" type="submit" id="btn_performance_request_update">Submit</button>
                                  @endif
                                  @endif
                                  <!-- <button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Reset</button> -->
                          </div>

                          <div class="clearfix"></div>
                      </div>

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
</div>
@endsection
@section('script')
<script>
   function departmentChangeEvent() {
  $("#department").on("change", () => {
    alert('okk');
    getEmployeesByDepertment($("#department").val());
    setEmployeeDetailsInForm(null);
  });
}
function getEmployeesByDepertment(dep) {
  console.log("dept>>", dep);
  if (typeof dep !== "undefined") {
    $.ajax({
      url: base_url + "/getEmployeeByDept",
      method: "POST",
      data: {
        dept: dep,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: (data) => {
        console.log(data);
        if (data.status) {
          setEmployeeList(data?.data?.employees);
        }
      },
      error: (err) => {
        console.log(err);
      },
    });
  }
}

function setEmployeeDetailsInForm(data) {
  if (data) {
    $("#job_title").val(data?.emp_designation);
    $("#doj").val(moment(new Date(data?.emp_doj)).format("DD/MM/YYYY"));
    $("#rep_auth").val(
      data?.rep_fname +
        (data?.rep_mname ? " " + data?.rep_mname : "") +
        (data?.rep_lname ? " " + data?.rep_lname : "")
    );
    $("#rep_auth_id").val(data?.rep_emp_code);
    // $("#job_title").val(data?.emp_designation);
  } else {
    $("#job_title").val("");
    $("#doj").val("");
    $("#rep_auth").val("");
    $("#rep_auth_id").val("");
  }
}
</script>

@endsection