@extends('attendance.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="#">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="#">Process Attendence</a>
         </li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                  @endif
                  <div class="card-body">
                     <form  method="post" action="{{url('attendance/view-montly-attendance-data-all')}}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                            <div class="col-md-3">
                            </div>
                           <div class="col-md-6">
                              <div class=" form-group">
                                 <label for="department" class="placeholder"> Select Month</label>
                                 <select data-placeholder="Choose an Month..." class="form-control" name="month_yr" id="month_yr" required>
                                    <option value="" selected disabled> Select </option>
                                    <?php foreach ($monthlist as $month) {?>
                                        @if($month->month_yr!='')
                                        <option value="<?php echo $month->month_yr; ?>" @if(isset($month_yr_new) && $month_yr_new==$month->month_yr) selected @endif ><?php echo $month->month_yr; ?></option>
                                        @endif
                                    <?php }?>
                                </select>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                            </div>
                           <div class="col-md-3">
                              <a href="#">	
                              <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Go</button></a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         @if($result !='')
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Process Attendance</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{url('attendance/update-montly-attendance-data-all')}}" method="post" id="myForm">
                            {{csrf_field()}}
                            <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
                            <input type="hidden" id="deleteme" name="deleteme" class="deleteme" value="" />
                            <input type="hidden" id="deletemy" name="deletemy" class="deletemy" value="@if(isset($month_yr_new)){{$month_yr_new}} @endif" />
                            <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl" class="sm_emp_code_ctrl" value="" />
                            <input type="hidden" id="sm_emp_name_ctrl" name="sm_emp_name_ctrl" class="sm_emp_name_ctrl" value="" />
                            <input type="hidden" id="sm_emp_designation_ctrl" name="sm_emp_designation_ctrl" class="sm_emp_designation_ctrl" value="" />
                            <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl" class="sm_month_yr_ctrl" value="" />

                            <input type="hidden" id="sm_n_workingd_ctrl" name="sm_n_workingd_ctrl" class="sm_n_workingd_ctrl" value="" />
                            <input type="hidden" id="sm_n_absentd_ctrl" name="sm_n_absentd_ctrl" class="sm_n_absentd_ctrl" value="" />
                            <input type="hidden" id="sm_n_leaved_ctrl" name="sm_n_leaved_ctrl" class="sm_n_leaved_ctrl" value="" />
                            <input type="hidden" id="sm_n_presentd_ctrl" name="sm_n_presentd_ctrl" class="sm_n_presentd_ctrl" value="" />
                            <input type="hidden" id="sm_n_salaryd_ctrl" name="sm_n_salaryd_ctrl" class="sm_n_salaryd_ctrl" value="" />
                            <input type="hidden" id="sm_n_salaryadjd_ctrl" name="sm_n_salaryadjd_ctrl" class="sm_n_salaryadjd_ctrl" value="" />

                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <tr>
                                        <th style="width:6%;">Sl. No.</th>
                                        <th style="width:10%;">Employee Id</th>
                                        {{-- <th style="width:10%;">Employee Code</th> --}}
                                        <th style="width:12%;">Employee Name</th>
                                        
                                        <th style="width:10%;">Month</th>
                                        <th >Days In Month</th>
                                        <th >No. of Present Days</th>
                                        <th >No. of Leave Taken</th>
                                        <th >No. of Absent Days</th>
                                        <th >No. of Salary Days</th>
                                        <th >No. of Salary Adjustment Days</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php print_r($result);?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="6" style="border:none;">
                                            <button type="button" class="btn btn-info checkall" style="margin-right:1%;">Check All</button>
                                            <button type="submit" class="btn btn-default btn-sm" onclick="map_controls();">Save</button>
                                            <button type="reset" class="btn btn-warning btn-sm"> Reset</button>
                                           <button type="submit" name="btnDelete" class="btn btn-warning btn-sm" style="background-color:red !important" onclick="confirmDelete(event);">Delete All Records for the month</button>
                                    
                                        </td>
                                        

                                    </tr>
                                </tfoot>


                            </table>
                        </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
         @endif
      </div>
   </div>

   @endsection
    @section('js')
    <script>
        var clicked = false;
        $(".checkall").on("click", function() {
        // $(".checkhour").prop("checked", !clicked);
        // clicked = !clicked;
    
        var ele=document.getElementsByName('empcode_check[]');
       // alert(ele.length);
        for(var i=0; i<ele.length; i++){
            if(ele[i].type=='checkbox')
                ele[i].checked=true;
        }
        map_controls();
    });
    
    function map_controls(){
    
        var cb = $('.checkhour:checked').map(function() {return this.value;}).get().join(',');
        $('#cboxes').val(cb);
    
        var cb1 = $('.sm_emp_code').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_code_ctrl').val(cb1);
    
        var cb2 = $('.sm_emp_name').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_name_ctrl').val(cb2);
    
        var cb3 = $('.sm_emp_designation').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_designation_ctrl').val(cb3);
    
        var cb4 = $('.sm_month_yr').map(function() {return this.value;}).get().join(',');
        $('#sm_month_yr_ctrl').val(cb4);
    
        var cb5 = $('.sm_n_workingd').map(function() {return this.value;}).get().join(',');
        $('#sm_n_workingd_ctrl').val(cb5);
    
        var cb6 = $('.sm_n_absentd').map(function() {return this.value;}).get().join(',');
        $('#sm_n_absentd_ctrl').val(cb6);
    
        var cb7 = $('.sm_n_leaved').map(function() {return this.value;}).get().join(',');
        $('#sm_n_leaved_ctrl').val(cb7);
    
        var cb8 = $('.sm_n_presentd').map(function() {return this.value;}).get().join(',');
        $('#sm_n_presentd_ctrl').val(cb8);
    
        var cb9 = $('.sm_n_salaryd').map(function() {return this.value;}).get().join(',');
        $('#sm_n_salaryd_ctrl').val(cb9);
    
    
        var cb10 = $('.sm_n_salaryadjd').map(function() {return this.value;}).get().join(',');
        $('#sm_n_salaryadjd_ctrl').val(cb10);
    
    
    }
    function calculate_days(empcode){
    
        var working_day=$('#n_workingd_'+empcode).val();
        var present_day=$('#n_presentd_'+empcode).val();
        var leave_day=$('#n_leaved_'+empcode).val();
    
        var salary_day=$('#n_salaryd_'+empcode).val();
    
        $('#n_absentd_'+empcode).val(eval(working_day)-(eval(present_day)+eval(leave_day)));
        var absent_day=$('#n_absentd_'+empcode).val();
    
        $('#n_salaryd_'+empcode).val(eval(working_day)-eval(absent_day));
        //alert(working_day);
    
    }
    
    function confirmDelete(e){
        e.preventDefault();
        if (confirm("Do you want to delete all the generated records for the month?") == true) {
        //text = "You pressed OK!";
            $('#deleteme').val('yes');
            $('#myForm').submit();
        }
    }
    
    
    </script>
	
    @endsection
   