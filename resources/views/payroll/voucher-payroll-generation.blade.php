@extends('payroll.include.app')
@section('css')
<style>
    .left select {
        width: 100px;
    }
    
    .right {
        float: right;
    }
    
    .right select {
        width: 100px;
    
    }
    
    .card-body.card-block span {
        color: #000;
    }
    
    .main-card legend {
        color: #fff;
        background: #1c9ac5;
        padding: 0 15px;
    }
    
    .demo {
        /* width: 75%; */
        margin: 15px auto;
        background: #e2e1e1;
        padding: 15px;
    }
    
    .demo .form-control {
        /*width:170px;*/
    }
    
    .pd-0 {
        padding: 0;
    }
    
    .sal {
        background: #e0e0e0;
        padding: 7px 15px 1px;
        margin-bottom: 15px;
    }
    </style>
@endsection
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home"><a href="{{url('payroll-home-dashboard')}}"> Home</a></li>
         <li class="separator"> / </li>
         <li class="nav-item"><a href="{{url('payroll/dashboard')}}">Payroll</a></li>
         <li class="separator"> / </li>
         <li class="nav-item active"><a href="#">Employee Voucher (Payroll)</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                @include('layout.message')
                  <div class="card-body">
                    
                    <form action="{{ url('payroll/voucher-payroll-generation') }}" method="post"
                    id="single_payroll_generation">
                    {{ csrf_field() }}
                    <!-- <div class="mon" style="float:right;">

                    </div> -->
                    <div class="row form-group demo">
                        <div class="col-sm-10">
                            <label>Employee Name</label>
                            <div class="empnamediv">
                                <select id="empname" name="empname" onchange="getEmpCode();"
                                    class="form-control employee select2_el">
                                    <option selected disabled value="">Select</option>
                                    @foreach($Employee as $emp)
                                    <option value="{{$emp->emp_code}}">
                                        {{($emp->emp_fname . ' '. $emp->emp_mname.' '.$emp->emp_lname)}} -
                                        {{$emp->old_emp_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                        <label>Month</label>
                        <div class="input-group mb-3">
                            <input class="demo-1 form-control" id="month_yr" type="date" value="<?php echo date('Y-m-d');
                                ?>" name="month_yr"   />

                            <!-- <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-calendar"
                                        aria-hidden="true"></i></span>
                            </div> -->
                        </div>
                        </div>

                    </div>
                    <div class="row form-group">

                        <div class="col-md-4">
                            <label for="text-input" class=" form-control-label">Employee Name</span></label>
                            <input type="text" id="emp_name" readonly="" name="emp_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class=" form-control-label">Designation</label>
                            <input type="text" id="emp_designation" readonly="" name="emp_designation"
                                class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Basic Pay</label>
                            <input type="text"  id="emp_basic_pay" name="emp_basic_pay"
                                class="form-control" onblur="OnblurCalculateAddition();" onchange="OnblurCalculateAddition();">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="form-control-label">Working Days</label>
                            <input id="emp_working_days"  name="emp_working_days" type="text"
                                class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">Present Days</label>
                            <input type="text" name="emp_present_days"  id="emp_present_days"
                                class="form-control">
                        </div>


                        <div class="col-md-4">
                            <label class="form-control-label">Absent Days</label>
                            <input type="text" id="emp_absent_days"  name="emp_absent_days"
                                class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-control-label">No. of Days Salary</label>
                            <input type="text" id="emp_no_of_days_salary"  name="emp_no_of_days_salary"
                                class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Adjustment Days</label>
                            <input type="text" name="emp_adjust_days" id="emp_adjust_days" readonly
                                class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <legend>Leave Details</legend>
                        </div>
                        <div class="col-md-3">
                            <label>CL</label>
                            <input type="text" name="emp_cl" readonly id="emp_cl" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>EL</label>
                            <input type="text" name="emp_el" readonly id="emp_el" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>HPL</label>
                            <input type="text" name="emp_hpl" readonly id="emp_hpl" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>RH</label>
                            <input type="text" name="emp_rh" readonly id="emp_rh" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>Commuted Medical Leave</label>
                            <input type="text" name="emp_cml" id="emp_cml" readonly name="emp_cml"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>EOL</label>
                            <input type="text" id="emp_eol" readonly name="emp_eol" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>LND</label>
                            <input type="text" name="emp_lnd" readonly id="emp_lnd" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Maternity Leave</label>
                            <input type="text" name="emp_maternity_leave" readonly id="emp_maternity_leave"
                                class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>Paternity Leave</label>
                            <input type="text" name="emp_paternity_leave" readonly id="emp_paternity_leave"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>CCL</label>
                            <input type="text" name="emp_ccl" id="emp_ccl" readonly class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Tour Leave</label>
                            <input type="text" name="emp_tour_leave" id="emp_tour_leave" readonly
                                class="form-control">
                        </div>
                        
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <legend>Calculate Earning Part</legend>
                        </div>
                        <div class="col-md-3">
                            <label>DA</label>
                            <input type="number" id="emp_da" name="emp_da" class="form-control"
                                onblur="OnblurCalculateAddition();" value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>VDA</label>
                            <input type="number" id="emp_vda" name="emp_vda" class="form-control"
                                onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>HRA</label>
                            <input type="number" id="emp_hra" name="emp_hra" class="form-control"
                                onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>TIFF ALW.</label>
                            <input type="number" id="emp_tiff_alw" name="emp_tiff_alw"
                                class="form-control" onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                    </div>

                    <div class="row form-group">

                        <div class="col-md-3">
                            <label>OTH ALW</label>
                            <input type="numer" id="emp_others_alw" name="emp_others_alw" class="form-control"
                                 onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>CONV</label>
                            <input type="number" id="emp_conv" name="emp_conv" class="form-control" 
                                onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>MEDICAL</label>
                            <input type="number" id="emp_medical" name="emp_medical" class="form-control"
                               onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label> MISC ALW</label>
                            <input type="number" id="emp_misc_alw" name="emp_misc_alw" class="form-control"
                               onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>


                    </div>

                    <div class="row form-group">
                        <div class="col-md-3">
                            <label> OVER TIME</label>
                            <input type="number" id="emp_over_time" name="emp_over_time" class="form-control"
                         onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>BONUS</label>
                            <input type="number" name="emp_bouns" id="emp_bouns" class="form-control"
                                onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>LEAVE ENC</label>
                            <input type="number" id="emp_leave_inc" name="emp_leave_inc" class="form-control"
                              onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>HTA</label>
                            <input type="number" id="emp_hta" name="emp_hta" class="form-control"
                                onblur="OnblurCalculateAddition();"  value="0" step="any">
                        </div>

                        <div class="col-md-3">
                            <label>Others</label>
                            <input onblur="OnblurCalculateAddition();" name="other_addition" id="other_addition"
                                type="number" class="form-control"  value="0" step="any">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <legend>Calculate Deduction Part</legend>
                        </div>
                        <div class="col-md-3">
                            <label>PROF TAX</label>
                            <input name="emp_prof_tax" id="emp_prof_tax" type="number" class="form-control"
                             onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>PF</label>
                            <input name="emp_pf" id="emp_pf" type="number" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>PF Employer Contribution</label>
                            <input name="emp_pf_employer" id="emp_pf_employer" type="number" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>PF INT</label>
                            <input name="emp_pf_int" id="emp_pf_int" type="number" class="form-control"
                             onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>APF</label>
                            <input name="emp_apf" id="emp_apf" type="number" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                    <!-- </div>

                    <div class="row form-group"> -->
                        <div class="col-md-3">
                            <label>Income TAX</label>
                            <input type="number" id="emp_i_tax" name="emp_i_tax" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>INSU PREM</label>
                            <input type="number" id="emp_insu_prem" name="emp_insu_prem" class="form-control"
                             onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>PF LOAN</label>
                            <input type="number" name="emp_pf_loan" id="emp_pf_loan" class="form-control"
                             onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>ESI</label>
                            <input type="number" name="emp_esi" id="emp_esi" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>ADV</label>
                            <input type="number" name="emp_adv" id="emp_adv" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>HRD</label>
                            <input type="number" name="emp_hrd" id="emp_hrd" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>CO-OP</label>
                            <input type="number" name="emp_co_op" id="emp_co_op" class="form-control"
                                onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>FURNITURE</label>
                            <input type="number" name="emp_furniture" id="emp_furniture" class="form-control"
                             onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <div class="col-md-3">
                            <label>MISE DED</label>
                            <input type="number" name="emp_misc_ded" id="emp_misc_ded" class="form-control"
                             onblur="OnBlurCalculateSubtraction();"  value="0" step="any">
                        </div>
                        <!-- <div class="col-md-3">
                            <label>Income Tax</label>
                            <input onblur="OnBlurCalculateSubtraction();" type="text" name="emp_income_tax"
                                id="emp_income_tax" class="form-control">
                        </div> -->

                        <div class="col-md-3">
                            <label>Others</label>
                            <input onblur="OnBlurCalculateSubtraction();" type="number" id="other_deduction"
                                name="other_deduction" class="form-control"  value="0" step="any">
                        </div>

                    </div>


                    <div class="sal">
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label>Gross Salary</label>
                                <input type="number" id="emp_gross_salary" name="emp_gross_salary"
                                    class="form-control" readonly="1"  value="0" step="any">
                            </div>
                            <div class="col-md-4">
                                <label>Total Deductions</label>
                                <input type="number" id="emp_total_deduction" name="emp_total_deduction"
                                    class="form-control" readonly="1"  value="0" step="any">
                            </div>
                            <div class="col-md-4">
                                <label>Net Salary</label>
                                <input name="emp_net_salary" id="emp_net_salary" type="number"
                                    class="form-control" readonly="1"  value="0" step="any">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm">Save</button>

                </form>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   @endsection
    @section('js')

    <script type="text/javascript">
        function sc(empid) {
        
            var html =
                '<select id="emp_id" name="emp_id" onclick="getEmpID(this.value);" class="form-control employee"><option value="">Select</option><option value="' +
                empid + '" selected="selected">' + empid + '<option></select>';
            $('.empiddiv').html('').html(html);
        }
        
        var transport_allowance = 0;
        var cess = 0;
        
        
        function getEmpCode() {
            //$('#single_payroll_generation')[0].reset();
            //$("form input[type='text']").val('0');
            var empid = $("#empname option:selected").val();
            var month_yr = $("#month_yr").val();
        
            var d = new Date(month_yr);
        
            var currentMonth = (d.getMonth() + 1);
            var monthCount = currentMonth.toString().length;
        
            var current_month_days = new Date(d.getFullYear(), (d.getMonth() + 1), 0).getDate();
            //alert(current_month_days);
            // if (monthCount = 1) {
            //     var monthYR = '0' + (d.getMonth() - 1) + '/' + d.getFullYear();
        
            // } else {
        
            //     var monthYR = (d.getMonth() - 1) + '/' + d.getFullYear();
            // }
            if (monthCount < 10) {
                var monthYR = '0' + (d.getMonth() + 1) + '/' + d.getFullYear();
        
            } else {
        
                var monthYR = (d.getMonth() + 1) + '/' + d.getFullYear();
            }
        
            $.ajax({
                type: 'GET',
                url: '{{url("payroll/getEmployeePayrollById")}}/' + empid + '/' + monthYR,
                cache: false,
                success: function(response) {
                    // console.log(response);
                    var obj = jQuery.parseJSON(response);
        
                    //alert(obj);
                    //console.log(obj); return;
                    // if(obj[2]==null){
                    //     alert('Please generate attendance for the month before generating payroll.');
                    //     return;
                    // }
                    
        
                    var basicpay = obj[0].basic_pay;
                    var apf_rate = obj[0].apf_percent;
                    var calculate_basic_salary = 0;
                    var no_of_working_days = 0;
                    var no_of_present = 0;
                    var no_of_days_absent = 0;
                    var no_of_days_salary = 0;
                    var no_of_tour_leave = 0;
                    var no_sal_adjust_days = 0;
                    var no_of_leave = 0;
                    var emp_da = 0;
                    var emp_vda = 0;
                    var emp_hra = 0;
                    var emp_prof_tax = 0;
                    var emp_others_alw = 0;
                    var emp_tiff_alw = 0;
                    var emp_conv = 0;
                    var emp_medical = 0;
                    var emp_misc_alw = 0;
                    var emp_over_time = 0;
                    var emp_bouns = 0;
                    var emp_co_op = 0;
                    var emp_pf = 0;
                    var emp_pf_int = 0;
                    var emp_apf = 0;
                    var emp_i_tax = 0;
                    var emp_insu_prem = 0;
                    var emp_pf_loan = 0;
                    var emp_esi = 0;
                    var emp_adv = 0;
                    var emp_hrd = 0;
                    var emp_furniture = 0;
                    var emp_misc_ded = 0;
                    var emp_hta = 0;
        
                    $("#empname option:selected").val(empid);
                    $("#emp_name").val(obj[0].emp_fname + ' ' + obj[0].emp_mname + ' ' + obj[0].emp_lname);
                    $("#emp_designation").val(obj[0].designation);
        
                    $("#emp_cl").val('0');
                    $("#emp_el").val('0');
                    $("#emp_hpl").val('0');
                    $("#emp_rh").val('0');
                    $("#emp_cml").val('0');
                    $("#emp_eol").val('0');
                    $("#emp_maternity_leave").val('0');
                    $("#emp_paternity_leave").val('0');
                    $("#emp_ccl").val('0');
                    $("#emp_lnd").val('0');
        
        
                    if (obj[2] == null) {
        
                        $("#emp_working_days").val(no_of_working_days);
                        $("#emp_present_days").val(no_of_present);
                        $("#emp_absent_days").val(no_of_days_absent);
                        $("#emp_no_of_days_salary").val(no_of_days_salary);
                        $("#emp_tour_leave").val(no_of_tour_leave);
                        $("#emp_adjust_days").val(no_sal_adjust_days);
        
                        $("#emp_basic_pay").val(basicpay);
        
                    } else {
        
                        no_of_working_days = obj[2].no_of_working_days;
                        $("#emp_working_days").val(no_of_working_days);
        
                        no_of_present = obj[2].no_of_present;
                        $("#emp_present_days").val(no_of_present);
        
                        no_of_days_absent = obj[2].no_of_days_absent;
                        $("#emp_absent_days").val(no_of_days_absent);
        
                        no_of_days_salary = obj[2].no_of_days_salary;
                        $("#emp_no_of_days_salary").val(no_of_days_salary);
        
                        no_of_tour_leave = obj[2].no_of_tour_leave;
                        $("#emp_tour_leave").val(obj[2].no_of_tour_leave);
        
                        no_sal_adjust_days = obj[2].no_sal_adjust_days;
                        $("#emp_adjust_days").val(obj[2].no_sal_adjust_days);
        
                        //calculate_basic_salary=parseInt((basicpay / current_month_days) * (current_month_days-no_of_days_absent));
                        if (no_of_days_absent > 0) {
        
                            var perDaySal=basicpay / current_month_days;
                           // perDaySal=Math.round((perDaySal + Number.EPSILON) * 1000) / 1000;
                            var days_present=no_of_working_days - no_of_days_absent;
        
                            console.log('=====',current_month_days);console.log(basicpay);
                            console.log('=====');console.log(perDaySal);
        
                            calculate_basic_salary =eval(perDaySal)*eval(days_present);
                            calculate_basic_salary=Math.round((calculate_basic_salary + Number.EPSILON) * 100) / 100;
                            //calculate_basic_salary = parseInt((basicpay / current_month_days) * (no_of_working_days - no_of_days_absent));
                        } else {
                            calculate_basic_salary = parseFloat(basicpay);
        
                        }
                        calculate_basic_salary=Math.round((calculate_basic_salary + Number.EPSILON) * 100) / 100;
                        $("#emp_basic_pay").val(calculate_basic_salary);
                        //console.log(calculate_basic_salary);
                    }
        
                    var basic = $('#emp_basic_pay').val();
        
        
        
                    if (obj[1].length > 0) {
                        for (var i = 0; i < obj[1].length; i++) {
        
                            if (obj[1][i].leave_type_name == 'CASUAL LEAVE') {
        
                                if (obj[1][i].no_of_leave != '') {
                                    no_of_leave = obj[1][i].no_of_leave;
                                }
                                $("#emp_cl").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'EARN LEAVE') {
        
                                if (obj[1][i].no_of_leave != '') {
                                    no_of_leave = obj[1][i].no_of_leave;
                                }
                                $("#emp_el").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'HALF PAY LEAVE') {
                                var no_of_leave = obj[1][i].no_of_leave;
        
                                $("#emp_hpl").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'Restricted Holidays') {
                                var no_of_leave = obj[1][i].no_of_leave;
                                $("#emp_rh").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'Commuted Medical Leave') {
        
                                if (obj[1][i].no_of_leave != '') {
                                    no_of_leave = obj[1][i].no_of_leave;
                                }
                                $("#emp_cml").val(no_of_leave);
                                //var no_of_leave=obj[1][i].no_of_leave;
                                //$("#emp_cml").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'Extra Ordinary Leave') {
                                var no_of_leave = obj[1][i].no_of_leave;
        
                                $("#emp_eol").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'Maternity Leave') {
                                var no_of_leave = obj[1][i].no_of_leave;
        
                                $("#emp_maternity_leave").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'LND') {
        
                                if (obj[1][i].no_of_leave != '') {
                                    no_of_leave = obj[1][i].no_of_leave;
                                }
                                $("#emp_lnd").val(no_of_leave);
                            }
        
                            if (obj[1][i].leave_type_name == 'Paternity Leave') {
                                var no_of_leave = obj[1][i].no_of_leave;
        
                                $("#emp_paternity_leave").val(no_of_leave);
                            }
                            if (obj[1][i].leave_type_name == 'Child Care Leave') {
                                var no_of_leave = obj[1][i].no_of_leave;
        
                                $("#emp_ccl").val(no_of_leave);
                            }
                        }
                    }
        
                    for (var j = 0; j < obj[3].length; j++) {
        
        
                        if (obj[3][j].rate_id == '1') {
                            if (obj[0].da == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_da = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_da").val(emp_da);
        
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_da").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                                //$("#emp_da").prop("readonly", true);
        
                            } else if (obj[0].da != null && obj[0].da != '') {
        
                                $("#emp_da").val(obj[0].da);
                               // $("#emp_da").prop("readonly", false);
        
                            } else {
                                emp_da = 0;
        
                                $("#emp_da").val(emp_da);
                               // $("#emp_da").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '2') {
                            if (obj[0].vda == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_vda = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_vda").val(emp_vda);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_vda").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                              //  $("#emp_vda").prop("readonly", true);
        
                            } else if (obj[0].vda != null && obj[0].vda != '') {
                                $("#emp_vda").val(obj[0].vda);
                               // $("#emp_vda").prop("readonly", false);
                            } else {
                                emp_vda = 0;
                                $("#emp_vda").val(emp_vda);
                                //$("#emp_vda").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '3') {
                            console.log('*******');console.log(obj[0].hra);
                            if (obj[0].hra == '1') {
        
                                if (obj[3][j].inpercentage != '0') {
        
                                    emp_hra = (basic * obj[3][j].inpercentage / 100);
                                    emp_hra = Math.round(emp_hra );
                                    $("#emp_hra").val(emp_hra);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_hra").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                               // $("#emp_hra").prop("readonly", true);
        
                            } else if (obj[0].hra != null && obj[0].hra != '') {
                                if(obj[0].hra_type=='V'){
                                    emp_hra=obj[0].hra;
                                    var perDayHRA=emp_hra / current_month_days;
                                    perDayHRA=Math.round((perDayHRA + Number.EPSILON) * 100) / 100;
                                    
                                    var days_present=no_of_working_days - no_of_days_absent;
                                    console.log('Perday HRA='+perDayHRA);
                                    var calculate_hra =eval(perDayHRA)*eval(days_present);
                                    console.log('PF Present days='+days_present);
        
                                    emp_hra = Math.round(calculate_hra);
                                    console.log('HRA Calc='+emp_hra);
                                    $("#emp_hra").val(emp_hra);
                                 //   $("#emp_hra").prop("readonly", false);
        
                                }else{
        
                                    if (obj[3][j].inpercentage != '0') {
            
                                        emp_hra = (basic * obj[3][j].inpercentage / 100);
                                        emp_hra = Math.round(emp_hra);
                                        $("#emp_hra").val(emp_hra);
                                    } else {
            
                                        if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
                                                $("#emp_hra").val(obj[3][j].inrupees);
                                        }else{
                                            $("#emp_hra").val(obj[0].hra);
                                    //        $("#emp_hra").prop("readonly", false);
                                        }
                                    }
                                }
                            } else {
                                emp_hra = 0;
                                $("#emp_hra").val(emp_hra);
                               // $("#emp_hra").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '5') {
                            if (obj[0].others_alw == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_others_alw = (basic * obj[3][j].inpercentage / 100);
                                    emp_others_alw = Math.round((emp_others_alw + Number.EPSILON) * 100) / 100;
                                    $("#emp_others_alw").val(emp_others_alw);
                                } else {
                                    if(obj[0].others_alw_type=='V'){
                                        if(no_of_days_absent>0){
                                            var actual_perday_otheralw=eval(obj[0].others_alw)/eval(no_of_working_days);
                                            emp_others_alw=eval(actual_perday_otheralw)*eval(no_of_days_salary);
                                            emp_others_alw = Math.round((emp_others_alw + Number.EPSILON) * 100) / 100;
                                            $("#emp_others_alw").val(emp_others_alw);
                                         //   $("#emp_others_alw").prop("readonly", false);
        
                                        } else{
                                            $("#emp_others_alw").val(obj[0].others_alw);
                                         //   $("#emp_others_alw").prop("readonly", false);
                                        }
        
                                    }else{
                                        if (obj[3][j].inpercentage != '0') {
                                            emp_others_alw = (basic * obj[3][j].inpercentage / 100);
                                            emp_others_alw = Math.round((emp_others_alw + Number.EPSILON) * 100) / 100;
                                            $("#emp_others_alw").val(emp_others_alw);
                                        }else{
                                            if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
                                                $("#emp_others_alw").val(obj[3][j].inrupees);
                                            }
                                        }
                                       // $("#emp_others_alw").prop("readonly", true);
                                    }
        
                                }
                               
                            } else if (obj[0].others_alw != null && obj[0].others_alw != '') {
                                // $("#emp_others_alw").val(obj[0].others_alw);
                                // $("#emp_others_alw").prop("readonly", false);
                                if(obj[0].others_alw_type=='V'){
                                    if(no_of_days_absent>0){
                                        var actual_perday_otheralw=eval(obj[0].others_alw)/eval(no_of_working_days);
                                        emp_others_alw=eval(actual_perday_otheralw)*eval(no_of_days_salary);
                                        emp_others_alw = Math.round((emp_others_alw + Number.EPSILON) * 100) / 100;
                                        $("#emp_others_alw").val(emp_others_alw);
                                      //  $("#emp_others_alw").prop("readonly", false);
        
                                    } else{
                                        $("#emp_others_alw").val(obj[0].others_alw);
                                      //  $("#emp_others_alw").prop("readonly", false);
                                    }
                                }else{
                                    if (obj[3][j].inpercentage != '0') {
                                        emp_others_alw = (basic * obj[3][j].inpercentage / 100);
                                        emp_others_alw = Math.round((emp_others_alw + Number.EPSILON) * 100) / 100;
                                        $("#emp_others_alw").val(emp_others_alw);
                                    }else{
                                        if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
                                            $("#emp_others_alw").val(obj[3][j].inrupees);
                                        }
                                    }
                                  //  $("#emp_others_alw").prop("readonly", true);
                                }
                            } else {
                                emp_others_alw = 0;
                                $("#emp_others_alw").val(emp_others_alw);
                              //  $("#emp_others_alw").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '6') {
                            if (obj[0].tiff_alw == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_tiff_alw = (basic * obj[3][j].inpercentage / 100);
                                    emp_tiff_alw = Math.round((emp_tiff_alw + Number.EPSILON) * 100) / 100;
                                    $("#emp_tiff_alw").val(emp_tiff_alw);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_tiff_alw").val(obj[3][j].inrupees);
        
                                    }
                                }
                              //  $("#emp_tiff_alw").prop("readonly", true);
        
        
                            } else if (obj[0].tiff_alw != null && obj[0].tiff_alw != '') {
                                $("#emp_tiff_alw").val(obj[0].tiff_alw);
                             //   $("#emp_tiff_alw").prop("readonly", true);
                            } else {
                                emp_tiff_alw = 0;
                                $("#emp_tiff_alw").val(emp_tiff_alw);
                              //  $("#emp_tiff_alw").prop("readonly", true);
                            }
        
                            //from allowance
                            $("#emp_tiff_alw").val(obj[6].tiffin_alw);
        
                        } else if (obj[3][j].rate_id == '7') {
                            if (obj[0].conv == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_conv = (basic * obj[3][j].inpercentage / 100);
                                    emp_conv = Math.round((emp_conv + Number.EPSILON) * 100) / 100;
                                    $("#emp_conv").val(emp_conv);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_conv").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                             //   $("#emp_conv").prop("readonly", true);
        
                            } else if (obj[0].conv != null && obj[0].conv != '') {
                                $("#emp_conv").val(obj[0].conv);
                             //   $("#emp_conv").prop("readonly", true);
                            } else {
                                emp_conv = 0;
                                $("#emp_conv").val(emp_conv);
                            //    $("#emp_conv").prop("readonly", true);
                            }
        
                            //from allowance
                            $("#emp_conv").val(obj[6].convence_alw);
        
                        } else if (obj[3][j].rate_id == '8') {
                            if (obj[0].medical == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_medical = Math.round(basicpay * obj[3][j].inpercentage / 100);
                                    $("#emp_medical").val(emp_medical);
                                } else {
        
        
                                    if ((basicpay <= obj[3][j].max_basic) && (basicpay >= obj[3][j].min_basic)) {
        
                                        $("#emp_medical").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                              //  $("#emp_medical").prop("readonly", true);
        
                            } else if (obj[0].medical != null && obj[0].medical != '') {
                                $("#emp_medical").val(obj[0].medical);
                              //  $("#emp_medical").prop("readonly", false);
                            } else {
                                emp_medical = 0;
                                $("#emp_medical").val(emp_medical);
                               // $("#emp_medical").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '9') {
                            if (obj[0].misc_alw == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_misc_alw = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_misc_alw").val(emp_misc_alw);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_misc_alw").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                            //    $("#emp_misc_alw").prop("readonly", true);
        
                            } else if (obj[0].misc_alw != null && obj[0].misc_alw != '') {
                                $("#emp_misc_alw").val(obj[0].misc_alw);
                                //$("#emp_misc_alw").prop("readonly", false);
                             //   $("#emp_misc_alw").prop("readonly", true);
                            } else {
                                emp_misc_alw = 0;
                                $("#emp_misc_alw").val(emp_misc_alw);
                            //    $("#emp_misc_alw").prop("readonly", true);
                            }
        
                             //from allowance
                             $("#emp_misc_alw").val(obj[6].misc_alw);
        
                        } else if (obj[3][j].rate_id == '10') {
                            if (obj[0].over_time == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_over_time = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_over_time").val(emp_over_time);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_over_time").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                            //    $("#emp_over_time").prop("readonly", true);
        
                            } else if (obj[0].over_time != null && obj[0].over_time != '') {
                                $("#emp_over_time").val(obj[0].over_time);
                               // $("#emp_over_time").prop("readonly", false);
                            //    $("#emp_over_time").prop("readonly", true);
                            } else {
                                emp_over_time = 0;
                                $("#emp_over_time").val(emp_over_time);
                            //    $("#emp_over_time").prop("readonly", true);
                            }
        
                            $("#emp_over_time").val(obj[7].ot_alws);
        
                        } else if (obj[3][j].rate_id == '11') {
                            if (obj[0].bouns == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_bouns = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_bouns").val(emp_bouns);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_bouns").val(obj[3][j].inrupees);
        
                                    }
                                }
        
        
                            //    $("#emp_bouns").prop("readonly", true);
                            } else if (obj[0].bouns != null && obj[0].bouns != '') {
                                $("#emp_bouns").val(obj[0].bouns);
                            //    $("#emp_bouns").prop("readonly", false);
                            } else {
                                emp_bouns = 0;
                                $("#emp_bouns").val(emp_bouns);
                            //    $("#emp_bouns").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '12') {
                            if (obj[0].leave_inc == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_leave_inc = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_leave_inc").val(emp_leave_inc);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_leave_inc").val(obj[3][j].inrupees);
        
                                    }
                                }
        
        
                            //    $("#emp_leave_inc").prop("readonly", true);
                            } else if (obj[0].leave_inc != null && obj[0].leave_inc != '') {
                                $("#emp_leave_inc").val(obj[0].leave_inc);
                             //   $("#emp_leave_inc").prop("readonly", false);
                            } else {
                                emp_leave_inc = 0;
                                $("#emp_leave_inc").val(emp_leave_inc);
                             //   $("#emp_leave_inc").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '13') {
                            if (obj[0].hta == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_hta = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_hta").val(emp_hta);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_hta").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                            //    $("#emp_hta").prop("readonly", true);
        
                            } else if (obj[0].hta != null && obj[0].hta != '') {
                                $("#emp_hta").val(obj[0].hta);
                            //    $("#emp_hta").prop("readonly", false);
        
                            } else {
                                emp_hta = 0;
                                $("#emp_hta").val(emp_hta);
                            //    $("#emp_hta").prop("readonly", true);
                            }
        
                        } else if (obj[3][j].rate_id == '15') {
                            console.log('====');
                            console.log(obj[3]);
        
                            if (obj[0].pf == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_pf = Math.round(basic * obj[3][j].inpercentage / 100);
                                    
                                    $("#emp_pf").val(emp_pf);
        
                                    // $("#emp_pf").val('1800');
                                    // console.log('hello percent');
        
        
                                } else {
                                    // console.log('hello not percent');
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_pf").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                            //    $("#emp_pf").prop("readonly", true);
        
                            } else if (obj[0].pf != null && obj[0].pf != '') {
                                if (obj[3][j].inpercentage != '0') {
                                    if(basic>15000){
                                        $("#emp_pf").val('1800');
                                    }else{
                                        emp_pf = Math.round(basic * obj[3][j].inpercentage / 100);
                                        $("#emp_pf").val(emp_pf);
                                    }
                                     //$("#emp_pf").val('1800');
                                     //console.log('hello percent--'+basic);
        
                                } else {
                                     console.log('hello not percent');
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
                                        $("#emp_pf").val(obj[3][j].inrupees);
                                    }
                                }
                                // $("#emp_pf").val(obj[0].pf);
                                if (obj[3][j].cal_type != 'F') {
                                //    $("#emp_pf").prop("readonly", false);
                                }else{
                                 //   $("#emp_pf").prop("readonly", true);
                                }
        
                            } else {
                                emp_pf = 0;
                                $("#emp_pf").val(emp_pf);
                             //   $("#emp_pf").prop("readonly", true);
                            }
                            // if(eval(emp_pf)>1800) emp_pf=1800;
                            // $("#emp_pf").val(emp_pf);
        
                        } else if (obj[3][j].rate_id == '16') {
                            if (obj[0].pf_int == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_pf_int = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_pf_int").val(emp_pf_int);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_pf_int").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                             //   $("#emp_pf_int").prop("readonly", true);
        
                            } else if (obj[0].pf_int != null && obj[0].pf_int != '') {
                                $("#emp_pf_int").val(obj[0].pf_int);
                              //  $("#emp_pf_int").prop("readonly", false);
                            } else {
                                emp_pf_int = 0;
                                $("#emp_pf_int").val(emp_pf_int);
                             //   $("#emp_pf_int").prop("readonly", true);
                            }
        
                            //from loan balance PF
                            if(obj[10].length>0){
                                var emp_pf_loan_balance=0;
                                for(li=0;li<obj[10].length;li++){
                                    emp_pf_loan_balance=eval(emp_pf_loan_balance)+eval(obj[10][li]['balance_amount']);
                                }
                                //$("#emp_pf_loan").val(emp_pf_loan);
                                $intRatePfLoan=9.5;
                                if(obj[11]){
                                    $intRatePfLoan=obj[11];
                                }
        
                                emp_pf_int = (eval(emp_pf_loan_balance)* eval($intRatePfLoan) / 100)/12;
                                emp_pf_int = Math.round((emp_pf_int + Number.EPSILON) * 100) / 100;
                                $("#emp_pf_int").val(emp_pf_int);
                            //    $("#emp_pf_int").prop("readonly", true);
                            }else{
                                //$("#emp_pf_loan").val(0);
                                emp_pf_int = 0;
                                $("#emp_pf_int").val(emp_pf_int);
                          //      $("#emp_pf_int").prop("readonly", true);
                            }
        
        
        
                        } else if (obj[3][j].rate_id == '17') {
                            //apf_rate
        
                            emp_apf = Math.round(basic * apf_rate / 100);
                            $("#emp_apf").val(emp_apf);
                         //   $("#emp_apf").prop("readonly", true);
        
                            // if (obj[0].apf == '1') {
                            //     if (obj[3][j].inpercentage != '0') {
                            //         emp_apf = Math.round(basic * obj[3][j].inpercentage / 100);
                            //         $("#emp_apf").val(emp_apf);
                            //     } else {
        
        
                            //         if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                            //             $("#emp_apf").val(obj[3][j].inrupees);
        
                            //         }
                            //     }
        
                            //     $("#emp_apf").prop("readonly", true);
        
                            // } else if (obj[0].apf != null && obj[0].apf != '') {
                            //     $("#emp_apf").val(obj[0].apf);
                            //     $("#emp_apf").prop("readonly", false);
        
        
                            // } else {
                            //     emp_apf = 0;
                            //     $("#emp_apf").val(emp_apf);
                            //     $("#emp_apf").prop("readonly", true);
        
                            // }
        
        
                        } else if (obj[3][j].rate_id == '18') {
                            if (obj[0].i_tax == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_i_tax = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_i_tax").val(emp_i_tax);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_i_tax").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                            //    $("#emp_i_tax").prop("readonly", true);
        
        
                            } else if (obj[0].i_tax != null && obj[0].i_tax != '') {
                                $("#emp_i_tax").val(obj[0].i_tax);
                                //$("#emp_i_tax").prop("readonly", false);
                            //    $("#emp_i_tax").prop("readonly", true);
        
        
        
                            } else {
                                emp_i_tax = 0;
                                $("#emp_i_tax").val(emp_i_tax);
                            //    $("#emp_i_tax").prop("readonly", true);
        
                            }
        
                            //from income tax
                            $("#emp_i_tax").val(obj[5].itax_amount);
        
                        } else if (obj[3][j].rate_id == '19') {
                            if (obj[0].insu_prem == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_insu_prem = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_insu_prem").val(emp_insu_prem);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_insu_prem").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                            //    $("#emp_insu_prem").prop("readonly", true);
        
        
                            } else if (obj[0].insu_prem != null && obj[0].insu_prem != '') {
                                $("#emp_insu_prem").val(obj[0].insu_prem);
                            //    $("#emp_insu_prem").prop("readonly", true);
        
                            } else {
                                emp_insu_prem = 0;
                                $("#emp_insu_prem").val(emp_insu_prem);
                            //    $("#emp_insu_prem").prop("readonly", true);
        
                            }
                            $("#emp_insu_prem").val(obj[4].insurance_prem);
        
                        } else if (obj[3][j].rate_id == '20') {
                            if (obj[0].pf_loan == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_pf_loan = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_pf_loan").val(emp_pf_loan);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_pf_loan").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                                //$("#emp_pf_loan").prop("readonly", true);
        
        
                            } else if (obj[0].pf_loan != null && obj[0].pf_loan != '') {
                                $("#emp_pf_loan").val(obj[0].pf_loan);
                                //$("#emp_pf_loan").prop("readonly", true);
        
        
        
                            } else {
                                emp_pf_loan = 0;
                                $("#emp_pf_loan").val(emp_pf_loan);
                                //$("#emp_pf_loan").prop("readonly", true);
        
                            }
        
                            //from loan PF
                            if(obj[9].length>0){
                                var emp_pf_loan=0;
                                for(li=0;li<obj[9].length;li++){
                                   emp_pf_loan=eval(emp_pf_loan)+eval(obj[9][li]['installment_amount']);
                                }
                                $("#emp_pf_loan").val(emp_pf_loan);
                            }else{
                                $("#emp_pf_loan").val(0);
                            }
        
        
                        } else if (obj[3][j].rate_id == '21') {
                            if (obj[0].esi == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_esi = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_esi").val(emp_esi);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_esi").val(obj[3][j].inrupees);
        
                                    }
                                }
                               // $("#emp_esi").prop("readonly", true);
        
        
        
                            } else if (obj[0].esi != null && obj[0].esi != '') {
                                $("#emp_esi").val(obj[0].esi);
                              //  $("#emp_esi").prop("readonly", false);
        
        
        
                            } else {
                                emp_esi = 0;
                                $("#emp_esi").val(emp_esi);
                              //  $("#emp_esi").prop("readonly", true);
        
                            }
        
                        } else if (obj[3][j].rate_id == '22') {
                            if (obj[0].adv == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_adv = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_adv").val(emp_adv);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_adv").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                               // $("#emp_adv").prop("readonly", true);
        
        
                            } else if (obj[0].adv != null && obj[0].adv != '') {
                                $("#emp_adv").val(obj[0].adv);
                               // $("#emp_adv").prop("readonly", true);
        
                            } else {
                                emp_adv = 0;
                                $("#emp_adv").val(emp_adv);
                               // $("#emp_adv").prop("readonly", true);
        
                            }
                            //from loan SA
                            if(obj[8].length>0){
                                var emp_adv=0;
                                for(li=0;li<obj[8].length;li++){
                                   // alert(obj[8][li]['installment_amount']);
                                    emp_adv=eval(emp_adv)+eval(obj[8][li]['installment_amount']);
                                }
                                $("#emp_adv").val(emp_adv);
                            }else{
                                $("#emp_adv").val(0);
                            }
        
        
                            
        
                        } else if (obj[3][j].rate_id == '23') {
                            if (obj[0].hrd == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_hrd = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_hrd").val(emp_hrd);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_hrd").val(obj[3][j].inrupees);
        
                                    }
                                }
        
                               // $("#emp_hrd").prop("readonly", true);
        
        
                            } else if (obj[0].hrd != null && obj[0].hrd != '') {
                                $("#emp_hrd").val(obj[0].hrd);
                             //   $("#emp_hrd").prop("readonly", false);
        
                            } else {
                                emp_hrd = 0;
                                $("#emp_hrd").val(emp_hrd);
                              //  $("#emp_hrd").prop("readonly", true);
        
                            }
        
                        } else if (obj[3][j].rate_id == '24') {
                            if (obj[0].co_op == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_co_op = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_co_op").val(emp_co_op);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_co_op").val(obj[3][j].inrupees);
        
                                    }
                                }
        
        
                              //  $("#emp_co_op").prop("readonly", true);
        
                            } else if (obj[0].co_op != null && obj[0].co_op != '') {
                                $("#emp_co_op").val(obj[0].co_op);
                                //$("#emp_co_op").prop("readonly", false);
                              //  $("#emp_co_op").prop("readonly", true);
        
        
                            } else {
                                emp_co_op = 0;
                                $("#emp_co_op").val(emp_co_op);
                             //   $("#emp_co_op").prop("readonly", true);
        
                            }
        
                            //from cooperative
                            $("#emp_co_op").val(obj[4].coop_amount);
        
                        } else if (obj[3][j].rate_id == '25') {
                            if (obj[0].furniture == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_furniture = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_furniture").val(emp_furniture);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_furniture").val(obj[3][j].inrupees);
        
                                    }
                                }
        
        
                              //  $("#emp_furniture").prop("readonly", true);
        
                            } else if (obj[0].furniture != null && obj[0].furniture != '') {
                                $("#emp_furniture").val(obj[0].furniture);
                              //  $("#emp_furniture").prop("readonly", false);
        
                            } else {
                                emp_furniture = 0;
                                $("#emp_furniture").val(emp_furniture);
                              //  $("#emp_furniture").prop("readonly", true);
        
                            }
        
                        } else if (obj[3][j].rate_id == '26') {
                            if (obj[0].misc_ded == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_misc_ded = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_misc_ded").val(emp_misc_ded);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_misc_ded").val(obj[3][j].inrupees);
        
                                    }
                                }
                               // $("#emp_misc_ded").prop("readonly", true);
        
        
        
                            } else if (obj[0].misc_ded != null && obj[0].misc_ded != '') {
                                $("#emp_misc_ded").val(obj[0].misc_ded);
                               // $("#emp_misc_ded").prop("readonly", true);
        
        
                            } else {
                                emp_misc_ded = 0;
                                $("#emp_misc_ded").val(emp_misc_ded);
                              //  $("#emp_misc_ded").prop("readonly", true);
        
                            }
                            //from entry
                            $("#emp_misc_ded").val(obj[4].misc_ded);
        
                        }else if (obj[3][j].rate_id == '29') {
                            if (obj[0].pf_employerc == '1') {
                                if (obj[3][j].inpercentage != '0') {
                                    pf_employerc = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_pf_employer").val(pf_employerc);
                                } else {
        
        
                                    if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
        
                                        $("#emp_pf_employer").val(obj[3][j].inrupees);
        
                                    }
                                }
                              //  $("#emp_pf_employer").prop("readonly", true);
        
        
        
                            } else if (obj[0].pf_employerc != null && obj[0].pf_employerc != '') {
                                $("#emp_pf_employer").val(obj[0].pf_employerc);
                              //  $("#emp_pf_employer").prop("readonly", false);
        
        
                            } else {
                                pf_employerc = 0;
                                $("#emp_pf_employer").val(pf_employerc);
                              //  $("#emp_pf_employer").prop("readonly", true);
        
                            }
        
                        }
                    }
        
        
        
                    $("#emp_income_tax").val('0');
                    $("#other_deduction").val('0');
                    $("#other_addition").val('0');
        
                    // var gross_salary = (parseFloat(basic) + parseFloat($('#emp_da').val()) + parseFloat(
                    //         $('#emp_vda').val()) + parseFloat($('#emp_hra').val()) + parseFloat($(
                    //         '#emp_others_alw').val()) + parseFloat($('#emp_tiff_alw').val()) + parseFloat($(
                    //         '#emp_conv').val()) + parseFloat($('#emp_medical').val()) + parseFloat($('#emp_misc_alw').val()) + parseFloat($('#emp_over_time').val()) + parseFloat($('#emp_bouns').val()) + parseFloat($('#emp_leave_inc').val()) + parseFloat($('#emp_hta').val()));
        
                    var gross_salary = parseFloat(basic) + parseFloat($('#emp_da').val()) + parseFloat($('#emp_vda').val())+ parseFloat($('#emp_hra').val())+ parseFloat($('#emp_tiff_alw').val())+ parseFloat($('#emp_others_alw').val())+ parseFloat($('#emp_conv').val())+ parseFloat($('#emp_medical').val()) + parseFloat($('#emp_misc_alw').val())+parseFloat($('#emp_over_time').val())+ parseFloat($('#emp_bouns').val()) + parseFloat($('#emp_leave_inc').val())+ parseFloat($('#emp_hta').val())+ parseFloat($('#other_addition').val()) ;
        
                        gross_salary = Math.round((gross_salary + Number.EPSILON) * 100) / 100;
                        
                        console.log('Gross='+gross_salary);
        
                    for (var j = 0; j < obj[3].length; j++) {
                        if (obj[3][j].rate_id == '4') {
                            console.log('----ptax');
                            if (obj[0].prof_tax == '1' || obj[0].prof_tax > '0') {
                                if (obj[3][j].inpercentage != '0') {
                                    emp_prof_tax = Math.round(basic * obj[3][j].inpercentage / 100);
                                    $("#emp_prof_tax").val(emp_prof_tax);
                                } else {
        
                                    if ((gross_salary <= obj[3][j].max_basic) && (gross_salary >= obj[3][j]
                                            .min_basic)) {
                                        emp_prof_tax = obj[3][j].inrupees;
                                        $("#emp_prof_tax").val(emp_prof_tax);
                                    }
                                    if ((gross_salary >= obj[3][j].max_basic) && (gross_salary <= obj[3][j]
                                            .min_basic)) {
                                        emp_prof_tax = obj[3][j].inrupees;
                                        $("#emp_prof_tax").val(emp_prof_tax);
                                    }
        
        
                                }
        
        
                             //   $("#emp_prof_tax").prop("readonly", true);
        
                            } else if (obj[0].prof_tax != null && obj[0].prof_tax != '') {
                                $("#emp_prof_tax").val(obj[0].prof_tax);
                            //    $("#emp_prof_tax").prop("readonly", false);
        
                            } else {
                                emp_prof_tax = 0;
                                $("#emp_prof_tax").val(emp_prof_tax);
                            //    $("#emp_prof_tax").prop("readonly", true);
        
                            }
        
                        }
                        if (obj[3][j].rate_id == '15') {
                            console.log('====PF=====');
                            console.log(obj[0].pf);
                            console.log('cal_type--- '+obj[0].pf_type);
        
                            if (obj[0].pf_type != 'V') {
                                console.log('hello --- Fixed');
                                if (obj[0].pf == '1') {
                                    if (obj[3][j].inpercentage != '0') {
                                        emp_pf = Math.round(basic * obj[3][j].inpercentage / 100);
                                        $("#emp_pf").val(emp_pf);
                                    } else {
                                        // console.log('hello not percent');
                                        if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
                                            $("#emp_pf").val(obj[3][j].inrupees);
                                        }
                                    }
                                    console.log('-----PF equal one----');
        
                                 //   $("#emp_pf").prop("readonly", true);
        
                                } else if (obj[0].pf != null && obj[0].pf != '') {
                                    console.log('****R****');
                                    //console.log(obj[0].emp_pf_inactuals);
                                    if(obj[0].pf>0){
                                        console.log('-----PF greater zero----');
                                        console.log('-----basic----'+basic);
                                        
                                        if (obj[3][j].inpercentage != '0') {
                                            if(basic>15000){
                                                if(obj[0].emp_pf_inactuals=='Y'){
                                                    emp_pf = Math.round(basic * obj[3][j].inpercentage / 100);
                                                    console.log('flagged----Y');
                                                }else{
                                                    emp_pf=1800;
                                                }
                                                $("#emp_pf").val(emp_pf);
                                            }else{
                                                console.log('*****basic less equal 15k***');
                                                console.log('flagged----'+obj[0].emp_pf_inactuals);
                                                var accountable_basic=parseFloat(gross_salary)-parseFloat($('#emp_hra').val())
                                                emp_pf = Math.round(accountable_basic * obj[3][j].inpercentage / 100);
                                                console.log('----acc_basic--'+accountable_basic);
                                                console.log('----acc_basic pf--'+emp_pf);
                                                if(obj[0].emp_pf_inactuals=='Y'){
                                                    emp_pf = Math.round(basic * obj[3][j].inpercentage / 100);
                                                }else{
                                                    if(emp_pf>1800){
                                                        emp_pf=1800;
                                                    }else{
                                                        console.log('Normal calculation less than 15k.');
                                                        //emp_pf = Math.round(basic * obj[3][j].inpercentage / 100);
                                                    }
                
                                                }
                
                                                $("#emp_pf").val(emp_pf);
                                            }
                                            //$("#emp_pf").val('1800');
                                            console.log('hello percent LP');
                
                
                                        } else {
                                            console.log('hello not percent');
                                            if ((basic <= obj[3][j].max_basic) && (basic >= obj[3][j].min_basic)) {
                                                $("#emp_pf").val(obj[3][j].inrupees);
                                            }
                                        }
                                    }
                                    else {
                                        emp_pf = 0;
                                        $("#emp_pf").val(emp_pf);
                                       // $("#emp_pf").prop("readonly", true);
                                        console.log('PF equal zero');
                                    }
                                    // $("#emp_pf").val(obj[0].pf);
                                    if (obj[3][j].cal_type != 'F') {
                                       // $("#emp_pf").prop("readonly", false);
                                    }else{
                                       // $("#emp_pf").prop("readonly", true);
                                    }
        
                                } else {
                                    emp_pf = 0;
                                    $("#emp_pf").val(emp_pf);
                                   // $("#emp_pf").prop("readonly", true);
                                }
        
                            }else{
                                console.log('hello --- Variable');
                                emp_pf =obj[0].pf;
                                if(emp_pf>0){
                                    var perDayPF=emp_pf / current_month_days;
                                    perDayPF=Math.round((perDayPF + Number.EPSILON) * 100) / 100;
                                    
                                    var days_present=no_of_working_days - no_of_days_absent;
                                    console.log('Perday PF='+perDayPF);
                                    var calculate_pf =eval(perDayPF)*eval(days_present);
                                    console.log('PF Present days='+days_present);
                                   
        
                                    emp_pf = Math.round(calculate_pf);
                                    console.log('PF Calc='+emp_pf);
                                }else{
                                    emp_pf=0;
                                }
                                $("#emp_pf").val(emp_pf);
                               // $("#emp_pf").prop("readonly", true);
                            }
        
        
                        }
        
        
                    }
        
        
                    $("#emp_gross_salary").val(gross_salary);
        
        
                    var total_deduction = (parseFloat($('#emp_prof_tax').val()) + parseFloat($(
                            '#emp_co_op').val()) +
                        parseFloat($('#emp_pf').val()) + parseFloat($('#emp_pf_employer').val()) + parseFloat($('#emp_pf_int').val()) + parseFloat($(
                            '#emp_apf').val()) + parseFloat($('#emp_i_tax').val()) +
                        parseFloat($('#emp_pf_loan').val()) + parseFloat($('#emp_insu_prem').val()) +
                        parseFloat($('#emp_esi').val()) + parseFloat($('#emp_adv').val()) + parseFloat($(
                            '#emp_hrd').val()) + parseFloat($('#emp_furniture').val()) + parseFloat($(
                            '#emp_misc_ded').val())
                    );
        
                    total_deduction = Math.round((total_deduction + Number.EPSILON) * 100) / 100;
        
                    $("#emp_total_deduction").val(total_deduction);
                    var net_salary = (parseFloat(gross_salary) - parseFloat(total_deduction));
        
                    net_salary = Math.round((net_salary + Number.EPSILON) * 100) / 100;
        
                    $("#emp_net_salary").val(net_salary);
        
                    OnblurCalculateAddition();
                    
        
                }
        
        
            });
        }
        
        function OnblurCalculateAddition() {
        
            var basic_pay = $('#emp_basic_pay').val();
        
            var other_addition = $('#other_addition').val();
        
            $('#emp_gross_salary').val('');
        
            //Total Addition
            var total_gross_on_blur = (parseFloat(basic_pay) + parseFloat($('#emp_da').val()) + parseFloat($(
                    '#emp_vda').val()) + parseFloat($('#emp_hra').val()) + parseFloat($('#emp_others_alw').val()) +
                parseFloat($('#emp_tiff_alw').val()) + parseFloat($('#emp_conv').val()) +
                parseFloat($('#emp_medical').val()) + parseFloat($('#emp_misc_alw').val()) + parseFloat($(
                    '#emp_over_time').val()) + parseFloat($('#emp_bouns').val()) + parseFloat($('#emp_leave_inc')
                    .val()) + parseFloat($('#emp_hta').val()) + parseFloat(other_addition));
        
            total_gross_on_blur = Math.round((total_gross_on_blur + Number.EPSILON) * 100) / 100;
        
            $('#emp_gross_salary').val(total_gross_on_blur);
        
        
            var Tot_deduction = $("#emp_total_deduction").val();
            var netsal = (parseFloat(total_gross_on_blur) - parseFloat(Tot_deduction));
            netsal = Math.round((netsal + Number.EPSILON) * 100) / 100;
            $('#emp_net_salary').val(netsal);
        
            //alert(netsal);
        
        }
        
        function OnBlurCalculateSubtraction() {
            //Deduction Part
        
        
            //var emp_income_tax = $('#emp_income_tax').val();
        
            var other_deduction = $('#other_deduction').val();
        
            // var tot_cess = Number(emp_income_tax) * Number(cess) / 100;
            // tot_cess = Math.round(tot_cess);
        
            var total_deduction = (parseFloat($('#emp_prof_tax').val()) + parseFloat($('#emp_co_op').val()) +
                parseFloat($('#emp_pf').val()) + parseFloat($('#emp_pf_employer').val()) + parseFloat($('#emp_pf_int').val()) + parseFloat($('#emp_apf').val()) + parseFloat($('#emp_i_tax').val()) + parseFloat($('#emp_pf_loan').val()) + parseFloat($('#emp_insu_prem').val()) + parseFloat($('#emp_esi').val())+ parseFloat($('#emp_adv').val()) + parseFloat($('#emp_hrd').val()) + parseFloat($('#emp_furniture').val())+ parseFloat($('#emp_misc_ded').val()) + parseFloat(other_deduction) );
        
            total_deduction = Math.round((total_deduction + Number.EPSILON) * 100) / 100;
        
            $("#emp_total_deduction").val(total_deduction);
        
            //alert(total_deduction);
        
            var Gross_Sal = $('#emp_gross_salary').val();
            var Tot_deduction = $("#emp_total_deduction").val();
            var netsal = (parseFloat(Gross_Sal) - parseFloat(Tot_deduction));
        
            netsal = Math.round((netsal + Number.EPSILON) * 100) / 100;
        
            $('#emp_net_salary').val('');
            $('#emp_net_salary').val(netsal);
        }
        
        
        
        function getEmployeeType(company_id) {
            $.ajax({
                type: 'GET',
                url: '{{url("attendance/get-employee-type")}}/' + company_id,
                success: function(response) {
        
                    $("#employee_type_id").html(response);
        
                }
        
            });
        }
        </script>
        <script src="{{ asset('js/select2.min.js')}}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                initailizeSelect2();
            });
            // Initialize select2
            function initailizeSelect2() {
        
                $(".select2_el").select2();
            }
        </script>
        
        
        <script src="{{ asset('js/monthpicker.min.js') }}"></script>
        
    
	
    @endsection
   