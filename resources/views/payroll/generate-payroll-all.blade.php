@extends('payroll.include.app')
@section('content')
    <div class="main-panel">
        <div class="page-header">
            <!-- <h4 class="page-title">Attendance Management</h4> -->
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="{{ url('payroll-home-dashboard') }}"> Home</a></li>
                <li class="separator"> / </li>
                <li class="nav-item"><a href="{{ url('payroll/dashboard') }}">Payroll</a></li>
                <li class="separator"> / </li>
                <li class="nav-item active"><a href="#">Generate All Employee Payroll</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-card">
                            {{-- <div class="card-header d-flex justify-content-end">
                                <a href="{{ url('payroll/add-montly-overtimes') }}"
                                    class="btn btn-outline-primary mb-3">Generate Monthly Overtimes <i
                                        class="fa fa-plus"></i></a>
                            </div> --}}
                            @include('layout.message')
                            <div class="card-body">
                                <form action="{{ url('payroll/vw-generate-payroll-all') }}" method="post"
                                    enctype="multipart/form-data"
                                    style="width:50%;margin:0 auto;padding: 18px 20px 1px;background: #ecebeb;">
                                    {{ csrf_field() }}
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label for="text-input" class=" form-control-label"
                                                style="text-align:right;">Select
                                                Month</label>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="month_yr" id="month_yr" required>

                                                <option value="" selected disabled> Select </option>
                                                <?php
for ($yy = 2022; $yy <= date('Y'); $yy++) {
for ($mm = 1; $mm <= 12; $mm++) {
if ($mm < 10) {
    $month_yr = '0' . $mm . "/" . $yy;
} else {
    $month_yr = $mm . "/" . $yy;
}
?>
                                                <option value="<?php echo $month_yr; ?>"
                                                    @if (isset($month_yr_new) && $month_yr_new == $month_yr) selected @endif><?php echo $month_yr; ?>
                                                </option>
                                                <?php

}
}
?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-info"
                                                style="color: #fff;background-color: #0884af;border-color: #0884af;padding: 0px 8px;
            height: 32px;">Go</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($result != '')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                {{-- <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Process Attendance</h4>
                    </div> --}}
                                <div class="card-body">
                                    <form action="{{ url('payroll/save-payroll-all') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="cboxes" name="cboxes" class="cboxes" value="" />
                                        <input type="hidden" id="sm_emp_code_ctrl" name="sm_emp_code_ctrl"
                                            class="sm_emp_code_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_name_ctrl" name="sm_emp_name_ctrl"
                                            class="sm_emp_name_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_designation_ctrl" name="sm_emp_designation_ctrl"
                                            class="sm_emp_designation_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_basic_pay_ctrl" name="sm_emp_basic_pay_ctrl"
                                            class="sm_emp_basic_pay_ctrl" value="" />
                                        <input type="hidden" id="sm_month_yr_ctrl" name="sm_month_yr_ctrl"
                                            class="sm_month_yr_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_no_of_working_ctrl"
                                            name="sm_emp_no_of_working_ctrl" class="sm_emp_no_of_working_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_emp_no_of_present_ctrl"
                                            name="sm_emp_no_of_present_ctrl" class="sm_emp_no_of_present_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_emp_no_of_days_absent_ctrl"
                                            name="sm_emp_no_of_days_absent_ctrl" class="sm_emp_no_of_days_absent_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_emp_no_of_days_salary_ctrl"
                                            name="sm_emp_no_of_days_salary_ctrl" class="sm_emp_no_of_days_salary_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_emp_tot_cl_ctrl" name="sm_emp_tot_cl_ctrl"
                                            class="sm_emp_tot_cl_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_el_ctrl" name="sm_emp_tot_el_ctrl"
                                            class="sm_emp_tot_el_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_hpl_ctrl" name="sm_emp_tot_hpl_ctrl"
                                            class="sm_emp_tot_hpl_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_rh_ctrl" name="sm_emp_tot_rh_ctrl"
                                            class="sm_emp_tot_rh_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_cml_ctrl" name="sm_emp_tot_cml_ctrl"
                                            class="sm_emp_tot_cml_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_eol_ctrl" name="sm_emp_tot_eol_ctrl"
                                            class="sm_emp_tot_eol_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_lnd_ctrl" name="sm_emp_lnd_ctrl"
                                            class="sm_emp_lnd_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_ml_ctrl" name="sm_emp_tot_ml_ctrl"
                                            class="sm_emp_tot_ml_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tot_pl_ctrl" name="sm_emp_tot_pl_ctrl"
                                            class="sm_emp_tot_pl_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_totccl_ctrl" name="sm_emp_totccl_ctrl"
                                            class="sm_emp_totccl_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_tour_leave_ctrl" name="sm_emp_tour_leave_ctrl"
                                            class="sm_emp_tour_leave_ctrl" value="" />
                                        <input type="hidden" id="sm_e_da_ctrl" name="sm_e_da_ctrl" class="sm_e_da_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_e_vda_ctrl" name="sm_e_vda_ctrl"
                                            class="sm_e_vda_ctrl" value="" />
                                        <input type="hidden" id="sm_e_hra_ctrl" name="sm_e_hra_ctrl"
                                            class="sm_e_hra_ctrl" value="" />
                                        <input type="hidden" id="sm_e_tiffalw_ctrl" name="sm_e_tiffalw_ctrl"
                                            class="sm_e_tiffalw_ctrl" value="" />
                                        <input type="hidden" id="sm_e_othalw_ctrl" name="sm_e_othalw_ctrl"
                                            class="sm_e_othalw_ctrl" value="" />
                                        <input type="hidden" id="sm_e_conv_ctrl" name="sm_e_conv_ctrl"
                                            class="sm_e_conv_ctrl" value="" />
                                        <input type="hidden" id="sm_e_medical_ctrl" name="sm_e_medical_ctrl"
                                            class="sm_e_medical_ctrl" value="" />
                                        <input type="hidden" id="sm_e_miscalw_ctrl" name="sm_e_miscalw_ctrl"
                                            class="sm_e_miscalw_ctrl" value="" />
                                        <input type="hidden" id="sm_e_overtime_ctrl" name="sm_e_overtime_ctrl"
                                            class="sm_e_overtime_ctrl" value="" />
                                        <input type="hidden" id="sm_e_bonus_ctrl" name="sm_e_bonus_ctrl"
                                            class="sm_e_bonus_ctrl" value="" />
                                        <input type="hidden" id="sm_e_leaveenc_ctrl" name="sm_e_leaveenc_ctrl"
                                            class="sm_e_leaveenc_ctrl" value="" />
                                        <input type="hidden" id="sm_e_hta_ctrl" name="sm_e_hta_ctrl"
                                            class="sm_e_hta_ctrl" value="" />
                                        <input type="hidden" id="sm_e_others_ctrl" name="sm_e_others_ctrl"
                                            class="sm_e_others_ctrl" value="" />

                                        <input type="hidden" id="sm_d_proftax_ctrl" name="sm_d_proftax_ctrl"
                                            class="sm_d_proftax_ctrl" value="" />
                                        <input type="hidden" id="sm_d_pf_ctrl" name="sm_d_pf_ctrl" class="sm_d_pf_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_d_pfint_ctrl" name="sm_d_pfint_ctrl"
                                            class="sm_d_pfint_ctrl" value="" />
                                        <input type="hidden" id="sm_d_apf_ctrl" name="sm_d_apf_ctrl"
                                            class="sm_d_apf_ctrl" value="" />
                                        <input type="hidden" id="sm_d_itax_ctrl" name="sm_d_itax_ctrl"
                                            class="sm_d_itax_ctrl" value="" />
                                        <input type="hidden" id="sm_d_insuprem_ctrl" name="sm_d_insuprem_ctrl"
                                            class="sm_d_insuprem_ctrl" value="" />
                                        <input type="hidden" id="sm_d_pfloan_ctrl" name="sm_d_pfloan_ctrl"
                                            class="sm_d_pfloan_ctrl" value="" />
                                        <input type="hidden" id="sm_d_esi_ctrl" name="sm_d_esi_ctrl"
                                            class="sm_d_esi_ctrl" value="" />
                                        <input type="hidden" id="sm_d_adv_ctrl" name="sm_d_adv_ctrl"
                                            class="sm_d_adv_ctrl" value="" />
                                        <input type="hidden" id="sm_d_hrd_ctrl" name="sm_d_hrd_ctrl"
                                            class="sm_d_hrd_ctrl" value="" />
                                        <input type="hidden" id="sm_d_coop_ctrl" name="sm_d_coop_ctrl"
                                            class="sm_d_coop_ctrl" value="" />
                                        <input type="hidden" id="sm_d_furniture_ctrl" name="sm_d_furniture_ctrl"
                                            class="sm_d_furniture_ctrl" value="" />
                                        <input type="hidden" id="sm_d_pf_employer_ctrl" name="sm_d_pf_employer_ctrl"
                                            class="sm_d_pf_employer_ctrl" value="" />
                                        <input type="hidden" id="sm_d_miscded_ctrl" name="sm_d_miscded_ctrl"
                                            class="sm_d_miscded_ctrl" value="" />
                                        <input type="hidden" id="sm_d_incometax_ctrl" name="sm_d_incometax_ctrl"
                                            class="sm_d_incometax_ctrl" value="" />
                                        <input type="hidden" id="sm_d_others_ctrl" name="sm_d_others_ctrl"
                                            class="sm_d_others_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_total_gross_ctrl" name="sm_emp_total_gross_ctrl"
                                            class="sm_emp_total_gross_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_total_deduction_ctrl"
                                            name="sm_emp_total_deduction_ctrl" class="sm_emp_total_deduction_ctrl"
                                            value="" />
                                        <input type="hidden" id="sm_emp_net_salary_ctrl" name="sm_emp_net_salary_ctrl"
                                            class="sm_emp_net_salary_ctrl" value="" />
                                        <input type="hidden" id="sm_emp_d_status_co_ctrl" name="sm_emp_d_status_co_ctrl"
                                            class="sm_emp_d_status_co_ctrl" value="" />


                                        <table id="basic-datatables" class="table table-striped table-bordered table-responsive">
                                            <thead style="text-align:center;vertical-align:middle;">
                                                <tr>
                                                    <th rowspan="2" style="text-align:center;">Sl. No.</th>
                                                    <th rowspan="2" style="text-align:center">Employee Code</th>
                                                    <th rowspan="2" style="text-align:center">Employee Name</th>
                                                    <th rowspan="2" style="text-align:center">Designation</th>
                                                    <th rowspan="2" style="text-align:center">Month</th>
                                                    <th rowspan="2" style="text-align:center">Basic Pay</th>
                                                    <th rowspan="2" style="text-align:center">Working Days</th>
                                                    <th rowspan="2" style="text-align:center">Present Days</th>
                                                    <th rowspan="2" style="text-align:center">Absent Days</th>
                                                    <th rowspan="2" style="text-align:center">Salary Days</th>
                                                    <th colspan="11" style="text-align:center;">Leave Details</th>
                                                    <th colspan="13" style="text-align:center;">Earnings</th>
                                                    <th colspan="16" style="text-align:center;">Deductions</th>
                                                    <th rowspan="2" style="text-align:center">Gross Salary</th>
                                                    <th rowspan="2" style="text-align:center">Total Deductions</th>
                                                    <th rowspan="2" style="text-align:center">Net Salary</th>
                                                </tr>
                                                <tr class="spl">
                                                    <td>CL</td>
                                                    <td>EL</td>
                                                    <td>HPL</td>
                                                    <td>RH</td>
                                                    <td>Commuted Medical Leave</td>
                                                    <td>EOL</td>
                                                    <td>LND</td>
                                                    <td>Maternity Leave</td>
                                                    <td>Paternity Leave</td>
                                                    <td>CCL</td>
                                                    <td>Tour Leave</td>
                                                    <td>DA</td>
                                                    <td>VDA</td>
                                                    <td>HRA</td>
                                                    <td>TIFF. ALW.</td>
                                                    <td>OTH. ALW.</td>
                                                    <td>CONV</td>
                                                    <td>MEDICAL</td>
                                                    <td>MISC. ALW.</td>
                                                    <td>OVER TIME</td>
                                                    <td>BONUS</td>
                                                    <td>LEAVE ENC.</td>
                                                    <td>HTA</td>
                                                    <td>OTHERS</td>
                                                    <td>PROF. TAX</td>
                                                    <td>PF</td>
                                                    <td>PF INT.</td>
                                                    <td>APF</td>
                                                    <td>ITAX</td>
                                                    <td>INSU. PREM.</td>
                                                    <td>PF LOAN</td>
                                                    <td>ESI</td>
                                                    <td>ADV.</td>
                                                    <td>HRD</td>
                                                    <td>CO-OP</td>
                                                    <td>FURNITURE</td>
                                                    <td>PF Employer Contribution</td>
                                                    <td>MISC. DED.</td>
                                                    <td>INCOME TAX</td>
                                                    <td>Others</td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php print_r($result); ?>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="32" style="border:none;">
                                                        <button type="button" class="btn btn-info btn-sm checkall"
                                                            style="margin-right:2%;">Check All</button>
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            onclick="map_controls();">Save</button>
                                                        <button type="reset" class="btn btn-warning btn-sm">
                                                            Reset</button>
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
    
        var cb5 = $('.sm_emp_basic_pay').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_basic_pay_ctrl').val(cb5);
    
        var cb6 = $('.sm_emp_no_of_working').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_no_of_working_ctrl').val(cb6);
    
        var cb7 = $('.sm_emp_no_of_present').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_no_of_present_ctrl').val(cb7);
    
        var cb8 = $('.sm_emp_no_of_days_absent').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_no_of_days_absent_ctrl').val(cb8);
    
        var cb9 = $('.sm_emp_no_of_days_salary').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_no_of_days_salary_ctrl').val(cb9);
    
        var cb10 = $('.sm_emp_tot_cl').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_cl_ctrl').val(cb10);
    
        var cb11 = $('.sm_emp_tot_el').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_el_ctrl').val(cb11);
    
        var cb12 = $('.sm_emp_tot_hpl').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_hpl_ctrl').val(cb12);
    
        var cb13 = $('.sm_emp_tot_rh').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_rh_ctrl').val(cb13);
    
        var cb14 = $('.sm_emp_tot_cml').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_cml_ctrl').val(cb14);
    
        var cb15 = $('.sm_emp_tot_eol').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_eol_ctrl').val(cb15);
    
        var cb16 = $('.sm_emp_lnd').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_lnd_ctrl').val(cb16);
    
        var cb17 = $('.sm_emp_tot_ml').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_ml_ctrl').val(cb17);
    
        var cb18 = $('.sm_emp_tot_pl').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tot_pl_ctrl').val(cb18);
    
        var cb19 = $('.sm_emp_totccl').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_totccl_ctrl').val(cb19);
    
        var cb20 = $('.sm_emp_tour_leave').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_tour_leave_ctrl').val(cb20);
    
        //Earnings
        var cb21 = $('.sm_e_da').map(function() {return this.value;}).get().join(',');
        $('#sm_e_da_ctrl').val(cb21);
    
        var cb22 = $('.sm_e_vda').map(function() {return this.value;}).get().join(',');
        $('#sm_e_vda_ctrl').val(cb22);
    
        var cb23 = $('.sm_e_hra').map(function() {return this.value;}).get().join(',');
        $('#sm_e_hra_ctrl').val(cb23);
    
        var cb24 = $('.sm_e_tiffalw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_tiffalw_ctrl').val(cb24);
    
        var cb25 = $('.sm_e_othalw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_othalw_ctrl').val(cb25);
    
        var cb26 = $('.sm_e_conv').map(function() {return this.value;}).get().join(',');
        $('#sm_e_conv_ctrl').val(cb26);
    
        var cb27 = $('.sm_e_medical').map(function() {return this.value;}).get().join(',');
        $('#sm_e_medical_ctrl').val(cb27);
    
        var cb28 = $('.sm_e_miscalw').map(function() {return this.value;}).get().join(',');
        $('#sm_e_miscalw_ctrl').val(cb28);
    
        var cb29 = $('.sm_e_overtime').map(function() {return this.value;}).get().join(',');
        $('#sm_e_overtime_ctrl').val(cb29);
    
        var cb30 = $('.sm_e_bonus').map(function() {return this.value;}).get().join(',');
        $('#sm_e_bonus_ctrl').val(cb30);
    
        var cb31 = $('.sm_e_leaveenc').map(function() {return this.value;}).get().join(',');
        $('#sm_e_leaveenc_ctrl').val(cb31);
    
        var cb32 = $('.sm_e_hta').map(function() {return this.value;}).get().join(',');
        $('#sm_e_hta_ctrl').val(cb32);
    
        var cb33 = $('.sm_e_others').map(function() {return this.value;}).get().join(',');
        $('#sm_e_others_ctrl').val(cb33);
    
        //Deductions
        var cb34 = $('.sm_d_proftax').map(function() {return this.value;}).get().join(',');
        $('#sm_d_proftax_ctrl').val(cb34);
    
        var cb35 = $('.sm_d_pf').map(function() {return this.value;}).get().join(',');
        $('#sm_d_pf_ctrl').val(cb35);
    
        var cb36 = $('.sm_d_pfint').map(function() {return this.value;}).get().join(',');
        $('#sm_d_pfint_ctrl').val(cb36);
    
        var cb37 = $('.sm_d_apf').map(function() {return this.value;}).get().join(',');
        $('#sm_d_apf_ctrl').val(cb37);
    
        var cb38 = $('.sm_d_itax').map(function() {return this.value;}).get().join(',');
        $('#sm_d_itax_ctrl').val(cb38);
    
        var cb39 = $('.sm_d_insuprem').map(function() {return this.value;}).get().join(',');
        $('#sm_d_insuprem_ctrl').val(cb39);
    
        var cb40 = $('.sm_d_pfloan').map(function() {return this.value;}).get().join(',');
        $('#sm_d_pfloan_ctrl').val(cb40);
    
        var cb41 = $('.sm_d_esi').map(function() {return this.value;}).get().join(',');
        $('#sm_d_esi_ctrl').val(cb41);
    
        var cb42 = $('.sm_d_adv').map(function() {return this.value;}).get().join(',');
        $('#sm_d_adv_ctrl').val(cb42);
    
        var cb43 = $('.sm_d_hrd').map(function() {return this.value;}).get().join(',');
        $('#sm_d_hrd_ctrl').val(cb43);
    
        var cb44 = $('.sm_d_coop').map(function() {return this.value;}).get().join(',');
        $('#sm_d_coop_ctrl').val(cb44);
    
        var cb45 = $('.sm_d_furniture').map(function() {return this.value;}).get().join(',');
        $('#sm_d_furniture_ctrl').val(cb45);
    
        var cb46 = $('.sm_d_miscded').map(function() {return this.value;}).get().join(',');
        $('#sm_d_miscded_ctrl').val(cb46);
    
        var cb47 = $('.sm_d_incometax').map(function() {return this.value;}).get().join(',');
        $('#sm_d_incometax_ctrl').val(cb47);
    
        var cb48 = $('.sm_d_others').map(function() {return this.value;}).get().join(',');
        $('#sm_d_others_ctrl').val(cb48);
    
        var cb49 = $('.sm_emp_total_gross').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_total_gross_ctrl').val(cb49);
    
        var cb50 = $('.sm_emp_total_deduction').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_total_deduction_ctrl').val(cb50);
    
        var cb51 = $('.sm_emp_net_salary').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_net_salary_ctrl').val(cb51);
    
        var cb52 = $('.sm_d_pf_employer').map(function() {return this.value;}).get().join(',');
        $('#sm_d_pf_employer_ctrl').val(cb52);
        
        var cb53 = $('.sm_emp_d_status_co').map(function() {return this.value;}).get().join(',');
        $('#sm_emp_d_status_co_ctrl').val(cb53);
    
    
    }
    
    function recalculate(ele) {
        var elementId = ele.id;
        var splitter = elementId.includes('_');
        const myArray = elementId.split("_");
        var recordNum = 0;
    
        if (splitter) {
            if (myArray.length == 3) {
                recordNum = myArray[myArray.length - 1];
            }
        }
    
        if (eval(recordNum) > 0) {
    
            //Earnings
            var e_da = $('#e_da_' + recordNum).val();
            e_da = (e_da != '') ? e_da : 0;
    
    
            var e_vda = $('#e_vda_' + recordNum).val();
            e_vda = (e_vda != '') ? e_vda : 0;
    
            var e_hra = $('#e_hra_' + recordNum).val();
            e_hra = (e_hra != '') ? e_hra : 0;
    
            var e_tiffalw = $('#e_tiffalw_' + recordNum).val();
            e_tiffalw = (e_tiffalw != '') ? e_tiffalw : 0;
    
            var e_othalw = $('#e_othalw_' + recordNum).val();
            e_othalw = (e_othalw != '') ? e_othalw : 0;
    
            var e_conv = $('#e_conv_' + recordNum).val();
            e_conv = (e_conv != '') ? e_conv : 0;
    
            var e_medical = $('#e_medical_' + recordNum).val();
            e_medical = (e_medical != '') ? e_medical : 0;
    
            var e_miscalw = $('#e_miscalw_' + recordNum).val();
            e_miscalw = (e_miscalw != '') ? e_miscalw : 0;
    
            var e_overtime = $('#e_overtime_' + recordNum).val();
            e_overtime = (e_overtime != '') ? e_overtime : 0;
    
            var e_bonus = $('#e_bonus_' + recordNum).val();
            e_bonus = (e_bonus != '') ? e_bonus : 0;
    
            var e_leaveenc = $('#e_leaveenc_' + recordNum).val();
            e_leaveenc = (e_leaveenc != '') ? e_leaveenc : 0;
    
            var e_hta = $('#e_hta_' + recordNum).val();
            e_hta = (e_hta != '') ? e_hta : 0;
    
            var e_others = $('#e_others_' + recordNum).val();
            e_others = (e_others != '') ? e_others : 0;
    
            var total_earnings = Math.round(parseFloat(e_da) + parseFloat(e_vda) + parseFloat(e_hra) + parseFloat(
                    e_tiffalw) + parseFloat(e_othalw) + parseFloat(e_conv) + parseFloat(e_medical) + parseFloat(
                    e_miscalw) +
                parseFloat(e_overtime) + parseFloat(e_bonus) + parseFloat(e_leaveenc) + parseFloat(e_hta) + parseFloat(
                    e_others));
    
            //basic pay
            var basic_pay = $('#emp_basic_pay_' + recordNum).val();
            basic_pay = (basic_pay != '') ? basic_pay : 0;
    
            //alert(basic_pay);
           // alert(d_pf_employer);
    
    
    
            var total_gross_sal = Math.round(parseFloat(basic_pay) + parseFloat(total_earnings));
    
            // alert(total_gross_sal);
    
            //Deductions
            var d_proftax = $('#d_proftax_' + recordNum).val();
            d_proftax = (d_proftax != '') ? d_proftax : 0;
    
            var d_pf = $('#d_pf_' + recordNum).val();
            d_pf = (d_pf != '') ? d_pf : 0;
    
            var d_pfint = $('#d_pfint_' + recordNum).val();
            d_pfint = (d_pfint != '') ? d_pfint : 0;
    
            var d_apf = $('#d_apf_' + recordNum).val();
            d_apf = (d_apf != '') ? d_apf : 0;
    
            var d_itax = $('#d_itax_' + recordNum).val();
            d_itax = (d_itax != '') ? d_itax : 0;
    
            var d_insuprem = $('#d_insuprem_' + recordNum).val();
            d_insuprem = (d_insuprem != '') ? d_insuprem : 0;
    
            var d_pfloan = $('#d_pfloan_' + recordNum).val();
            d_pfloan = (d_pfloan != '') ? d_pfloan : 0;
    
            var d_esi = $('#d_esi_' + recordNum).val();
            d_esi = (d_esi != '') ? d_esi : 0;
    
            var d_adv = $('#d_adv_' + recordNum).val();
            d_adv = (d_adv != '') ? d_adv : 0;
    
            var d_hrd = $('#d_hrd_' + recordNum).val();
            d_hrd = (d_hrd != '') ? d_hrd : 0;
    
            var d_coop = $('#d_coop_' + recordNum).val();
            d_coop = (d_coop != '') ? d_coop : 0;
    
            var d_furniture = $('#d_furniture_' + recordNum).val();
            d_furniture = (d_furniture != '') ? d_furniture : 0;
    
            var d_pf_employer = $('#d_pf_employer_' + recordNum).val();
            d_pf_employer = (d_pf_employer != '') ? d_pf_employer : 0;
            
            // alert(d_pf_employer,'d_pf_employer');
            
            var d_miscded = $('#d_miscded_' + recordNum).val();
            d_miscded = (d_miscded != '') ? d_miscded : 0;
    
            var d_incometax = $('#d_incometax_' + recordNum).val();
            d_incometax = (d_incometax != '') ? d_incometax : 0;
    
            var d_others = $('#d_others_' + recordNum).val();
            d_others = (d_others != '') ? d_others : 0;
            
            var deduct_co = "Deducted";
            var non_deduct_co = "Non Deducted";
            
            
            var remain_gross_salary=0;
            var remain_salary1=0;
             var remain_salary2=0;
             var remain_salary3=0;
             var remain_salary4=0;
             var remain_salary5=0;
             var remain_salary6=0;
             var remain_salary7=0;
             var remain_salary8=0;
             var remain_salary9=0;
             var remain_salary10=0;
             var remain_salary11=0;
             var remain_salary12=0;
             var remain_salary13=0;
             var remain_salary14=0;
             var remain_salary15=0;
             
             
             var total_deduction1=0;
             var total_deduction2=0;
             var total_deduction3=0;
             var total_deduction4=0;
             var total_deduction5=0;
             var total_deduction6=0;
             var total_deduction7=0;
             var total_deduction8=0;
             var total_deduction9=0;
             var total_deduction10=0;
             var total_deduction11=0;
             var total_deduction12=0;
             var total_deduction13=0;
             var total_deduction14=0;
             var total_deduction15=0;
             
             
                if(basic_pay > (parseFloat(d_proftax) + parseFloat(d_pf))){ 
                    total_deduction1 = parseFloat(d_proftax) + parseFloat(d_pf);
                    remain_salary1 =(parseFloat(basic_pay) - parseFloat(total_deduction1)); 
                    remain_gross_salary = parseFloat(total_gross_sal) - parseFloat(total_deduction1);
                    
                }else {
                    total_deduction1 = 0;
                }
                
                if(remain_gross_salary > d_itax){
                //   alert("cut itax"); 
                    total_deduction2 = d_itax;
                    remain_salary2 =  (parseFloat(remain_gross_salary)  - parseFloat(total_deduction2)); 
               
                }else{
                    total_deduction2 = 0;
                    $('#d_itax_' + recordNum).val(total_deduction2);
                }
                
                if( remain_salary2  >  d_insuprem){
                    // alert("cut insurance"); 
                    total_deduction3 = d_insuprem; 
                    remain_salary3 =  parseFloat(remain_salary2) - parseFloat(total_deduction3) ;
                   
                }else{
                    total_deduction3 = 0;
                    $('#d_insuprem_' + recordNum).val(total_deduction3);
                } 
                if(remain_salary3 > d_pfloan){
                    // alert("cut pf_loan"); 
                    total_deduction4 = d_pfloan;
                    remain_salary4 =  parseFloat(remain_salary3) - parseFloat(total_deduction4);
                }else {
                    total_deduction4 = 0;
                    $('#d_pfloan_' + recordNum).val(total_deduction4);
                }
                if(remain_salary4 > d_adv){
                    // alert("cut adv"); 
                    total_deduction5 = d_adv;
                    remain_salary5 =  parseFloat(remain_salary4) - parseFloat(total_deduction5) ;
                }else
                {
                    total_deduction5 = 0;
                    $('#d_adv_' + recordNum).val(total_deduction5);
                } 
                if( remain_salary5  >  d_coop){
                    // alert("cut cooperative"); 
                    total_deduction6 = d_coop;
                    remain_salary6 =  parseFloat(remain_salary5) - parseFloat(total_deduction6) ;
                    $('#status_co_' + recordNum).val(deduct_co);
                }else{
                    total_deduction6 = 0;
                    $('#d_coop_' + recordNum).val(total_deduction6);
                    $('#status_co' + recordNum).val(non_deduct_co);
                }
    
                if(remain_salary6 > d_esi){
                    // alert("cut esi"); 
                    total_deduction7 = d_esi;
                    remain_salary7 =  parseFloat(remain_salary6) - parseFloat(total_deduction7) ;
                }else
                {
                    total_deduction7 = 0;
                    $('#d_esi_' + recordNum).val(total_deduction7);
                } 
            
         
                if(remain_salary7 > d_hrd){
                    // alert("cut hrd"); 
                    total_deduction8 = d_hrd;
                    remain_salary8 =  parseFloat(remain_salary7) - parseFloat(total_deduction8) ;
                }else
                {
                    total_deduction8 = 0;
                    $('#d_hrd_' + recordNum).val(total_deduction8);
                } 
       
                if(remain_salary8 > d_furniture){
                    // alert("cut furniture"); 
                    total_deduction9 = d_furniture;
                    remain_salary9 =  parseFloat(remain_salary8) - parseFloat(total_deduction9) ;
                }else
                {
                    total_deduction9 = 0;
                    $('#d_furniture_' + recordNum).val(total_deduction9);
                } 
                
                if(remain_salary9 > d_pf_employer){
                    // alert("cut pf_employee"); 
                    total_deduction10 = d_pf_employer;
                    remain_salary10 =  parseFloat(remain_salary9) - parseFloat(total_deduction10) ;
                }else
                {
                    total_deduction10 = 0;
                    $('#d_pf_employer_' + recordNum).val(total_deduction10);
                } 
                
                if(remain_salary10 > d_pfint){
                    // alert("cut pf_int"); 
                    total_deduction11 = d_pfint;
                    remain_salary11 =  parseFloat(remain_salary10) - parseFloat(total_deduction11) ;
                }else
                {
                    total_deduction11 = 0;
                    $('#d_pfint_' + recordNum).val(total_deduction11);
                } 
                
                if(remain_salary11 > d_apf){
                    // alert("cut apf"); 
                    total_deduction12 = d_apf;
                    remain_salary12 =  parseFloat(remain_salary11) - parseFloat(total_deduction12) ;
                }else
                {
                    total_deduction12 = 0;
                    $('#d_apf_' + recordNum).val(total_deduction12);
                } 
                
                if(remain_salary12 > d_miscded){
                    // alert("cut apf"); 
                    total_deduction13 = d_miscded;
                    remain_salary13 =  parseFloat(remain_salary12) - parseFloat(total_deduction13) ;
                }else
                {
                    total_deduction13 = 0;
                    $('#d_miscded_' + recordNum).val(total_deduction13);
                } 
                
                if(remain_salary13 > d_incometax){
                    // alert("cut apf"); 
                    total_deduction14 = d_incometax;
                    remain_salary14 =  parseFloat(remain_salary13) - parseFloat(total_deduction14) ;
                }else
                {
                    total_deduction14 = 0;
                    $('#d_incometax_' + recordNum).val(total_deduction14);
                } 
                
                if(remain_salary14 > d_others){
                    // alert("cut apf"); 
                    total_deduction15 = d_others;
                    remain_salary15 =  parseFloat(remain_salary13) - parseFloat(total_deduction15) ;
                }else
                {
                    total_deduction15 = 0;
                    $('#d_incometax_' + recordNum).val(total_deduction15);
                } 
                
             
            // Math.round(parseFloat(d_proftax) + parseFloat(d_pf) + parseFloat(d_pfint) + parseFloat(
            //         d_apf) + parseFloat(d_itax) + parseFloat(d_insuprem) + parseFloat(d_pfloan) +
            //     parseFloat(d_esi) + parseFloat(d_adv) + parseFloat(d_hrd) + parseFloat(d_coop) + parseFloat(
            //         d_furniture) + parseFloat(d_pf_employer) + parseFloat(d_miscded) + parseFloat(d_incometax) + parseFloat(d_others));
            
            var total_deductions = (parseFloat(total_deduction1) + parseFloat(total_deduction2) +
                    parseFloat(total_deduction3) + parseFloat(total_deduction10) + parseFloat(total_deduction11) + parseFloat(total_deduction12) + parseFloat(total_deduction4) +
                    parseFloat(total_deduction5) + parseFloat(total_deduction6) + parseFloat(total_deduction7)  + parseFloat(total_deduction8) + parseFloat(total_deduction9) + parseFloat(total_deduction13)
                 + parseFloat(total_deduction14) + parseFloat(total_deduction15));
    
            var total_net_sal = Math.round(parseFloat(basic_pay) + parseFloat(total_earnings) - parseFloat(
                total_deductions));
    
            // alert(total_net_sal);
    
            $('#emp_total_gross_' + recordNum).val(total_gross_sal);
            $('#emp_total_deduction_' + recordNum).val(total_deductions);
            $('#emp_net_salary_' + recordNum).val(total_net_sal);
    
            //emp_total_gross_3532
            //emp_total_deduction_3532
            //emp_net_salary_3532
    
        }
    
    
    }
    
    
    // $('input[type=text]').on('blur', function() {
    //     var bid = this.id; // button ID
    //     var trid = $(this).closest('tr').attr('id'); // table row ID
    //     //alert(trid);
    //     var emp_gross_pay = $('#emp_total_gross_' + trid).val();
    //     var emp_ltc = $('#ltc_' + trid).val();
    //     var emp_cea = $('#cea_' + trid).val();
    //     var emp_travelling_allowance = $('#tra_' + trid).val();
    //     var emp_daily_allowance = $('#dla_' + trid).val();
    //     var emp_spcl_allowance = $('#spcl_allowance_' + trid).val();
    //     var emp_adv = $('#adv_' + trid).val();
    //     var emp_adjustment = $('#adjadv_' + trid).val();
    //     var emp_medical = $('#mr_' + trid).val();
    //     var other_addition = $('#other1_' + trid).val();
    
    //     var total_gross_on_blur = (parseInt(emp_gross_pay) + parseInt(emp_ltc) + parseInt(emp_cea) + parseInt(
    //             emp_travelling_allowance) + parseInt(emp_daily_allowance) + parseInt(emp_spcl_allowance) +
    //         parseInt(emp_adv) + parseInt(emp_adjustment) + parseInt(emp_medical) + parseInt(other_addition));
    //     var emp_gross_pay = $('#emp_total_gross_' + trid).val(total_gross_on_blur);
    //     var Tot_deduction = $('#emp_total_deduction_' + trid).val();
    //     var netsal = (parseInt(total_gross_on_blur) - parseInt(Tot_deduction));
    //     $('#emp_net_salary_' + trid).val(netsal);
    
    // });
    
    
    // $('input[type=text]').on('blur', function() {
    //     var bid = this.id; // button ID
    //     var trid = $(this).closest('tr').attr('id'); // table row ID
    //     //alert(trid);
    
    //     var emp_nps = $('#nps_' + trid).val();
    //     var emp_gsli = $('#gsli_' + trid).val();
    //     var emp_income_tax = $('#income_tax_' + trid).val();
    //     var emp_tax = $('#tax_' + trid).val();
    //     var emp_other2 = $('#other2_' + trid).val();
    //     var emp_total_deduction = (parseInt(emp_nps) + parseInt(emp_gsli) + parseInt(emp_income_tax) + parseInt(
    //         emp_tax) + parseInt(emp_other2));
    //     $('#emp_total_deduction_' + trid).val(emp_total_deduction);
    //     var emp_gross_pay = $('#emp_total_gross_' + trid).val();
    //     var netsal = (parseInt(emp_gross_pay) - parseInt(emp_total_deduction));
    //     $('#emp_net_salary_' + trid).val(netsal);
    
    // });
    </script>
@endsection
