@extends('payroll.include.app')
@section('css')
<style>
    .card-header-fixed-loan {
    text-align: right;
    padding-right: 16px;
    margin: -30px;
}
</style>
@endsection
@section('content')
<div class="main-panel">
   <div class="page-header page-header-fixed">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
        <li class="nav-home"><a href="{{url('payroll-home-dashboard')}}"> Home</a></li>
         <li class="separator">/</li>
         <li class="nav-item"><a href="{{url('payroll/dashboard')}}">Payroll</a></li>
         <li class="separator">/</li>
         <li class="nav-item active"><a href="#">Voucher (Payroll)</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Voucher (Payroll)</h4>
                        <div class="card-header-fixed-loan">
                        <a href="{{url('payroll/voucher-payroll-generation')}}" class="btn btn-outline-primary mb-3" style="color: black">Generate Voucher (Payroll) <i class="fa fa-plus"></i></a>
                    </div>
                   
                    <div class="card-body">
                       @include('layout.message')
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                      <tr>
                             <th rowspan="2">Sl. No.</th>
                            <th rowspan="2">Employee Code</th>
                            <th rowspan="2">Employee Name</th>
                            <th rowspan="2">Designation</th>
                            <th rowspan="2">Month</th>
                            <th colspan="14" style="text-align:center;">Additions</th>
                            <th colspan="16" style="text-align:center">Deductions</th>
                            <th rowspan="2">Gross Salary</th>
                            <th rowspan="2">Total Deductions</th>
                            <th rowspan="2">Net Salary</th>
                      <!--    <th rowspan="2">Action</th>-->
                            </tr>
                            <tr class="spl">
                                  <td>Basic Pay</td>
                                @if(count($rate_master)!=0)
                                @foreach($rate_master as $rate)
                              @if($rate->id <27)
                                  @if($rate->head_type=='earning')
                                    <td>{{$rate->head_name}}</td>
                              @endif
                                @endif
                                    @endforeach
                                @endif
                                  <td>Others</td>
                                  @if(count($rate_master)!=0)
                                @foreach($rate_master as $rate)
                              @if($rate->id <27)
                                  @if($rate->head_type=='deduction')
                                    <td>{{$rate->head_name}}</td>
                              @endif

                                @endif
                                @if($rate->id ==29)
                                  @if($rate->head_type=='deduction')
                                    <td>{{$rate->head_name}}</td>
                              @endif

                                @endif
                                    @endforeach
                                @endif


                                <td>Inc. Tax.</td>
                                  <td>Others</td>
                                    </tr>
                        
                                </thead>

                               <tbody>
                                @foreach($payroll_rs as $payroll)
                                <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$payroll->old_emp_code}}</td>
                                  <td>{{$payroll->emp_name}}</td>
                                  <td>{{$payroll->emp_designation}}</td>
                                  <td>{{$payroll->month_yr}}</td>
                                  <td>{{$payroll->emp_basic_pay}}</td>
                                  <td>{{$payroll->emp_da}}</td>
                                  <td>{{$payroll->emp_vda}}</td>
                                  <td>{{$payroll->emp_hra}}</td>
                                  <td>{{$payroll->emp_others_alw}}</td>
                                  <td>{{$payroll->emp_tiff_alw}}</td>
                                  <td>{{$payroll->emp_conv}}</td>
                                  <td>{{$payroll->emp_medical}}</td>
                                  <td>{{$payroll->emp_misc_alw}}</td>
                                  <td>{{$payroll->emp_over_time}}</td>
                                  <td>{{$payroll->emp_bouns}}</td>
                                  <td>{{$payroll->emp_leave_inc}}</td>
                                  <td>{{$payroll->emp_hta}}</td>

                                  <td>{{$payroll->other_addition}}</td>
                              <td>{{$payroll->emp_prof_tax}}</td>
                                  <td>{{$payroll->emp_pf}}</td>
                                  <td>{{$payroll->emp_pf_int}}</td>
                                  <td>{{$payroll->emp_apf}}</td>
                                  <td>{{$payroll->emp_i_tax}}</td>
                                  <td>{{$payroll->emp_insu_prem}}</td>
                                  <td>{{$payroll->emp_pf_loan}}</td>
                                  <td>{{$payroll->emp_esi}}</td>
                            <td>{{$payroll->emp_adv}}</td>
                              <td>{{$payroll->emp_hrd}}</td>
                              <td>{{$payroll->emp_co_op}}</td>
                                <td>{{$payroll->emp_furniture}}</td>
                              <td>{{$payroll->emp_misc_ded}}</td>
                              <td>@if($payroll->emp_pf_employer==null) 0 @else {{$payroll->emp_pf_employer}} @endif</td>
                                  <td>{{$payroll->emp_income_tax}}</td>
                                  <td>{{$payroll->emp_others_deduction}}</td>
                                  <td>{{$payroll->emp_gross_salary}}</td>
                                  <td>{{$payroll->emp_total_deduction}}</td>
                                  <td>{{$payroll->emp_net_salary}}</td>
                    <!--  <td>@if($payroll->proces_status!='completed')
                                                                    <a href='{{url("payroll/deletepayroll/$payroll->id")}}' onclick="return confirm('Are you sure you want to delete this?');"><i class="ti-trash"></i></a>
                                        @endif
                                                                </td>-->
                                </tr>
                                @endforeach

                              </tbody>

                            </table>
                            </div>
                        </div>
                    </div>

                </div>
                </div>
            </div>
      </div>
   </div>

   @endsection
    @section('js')

    @endsection
   