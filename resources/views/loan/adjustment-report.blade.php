@extends('loan.include.app')
@section('css')
@endsection
@section('content')
<div class="main-panel">
   <div class="page-header page-header-fixed">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home"><a href="#">Home</a></li>
         <li class="separator">/</li>
         <li class="nav-home"><a href="#">Loan</a></li>
         <li class="separator">/</li>
         <li class="nav-item active"><a href="#">Adjustment Report</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Adjustment Report</h4>
                        <div class="card-header-fixed-loan">
                        <form  method="post" action="{{ url('loans/xls-export-adjustment-report') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button  title="Download Excel" class="btn float-right excel-button" type="submit" ><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                        </form>
                    </div>
                    </div>
                   
                    <div class="card-body">
                    @if(Session::has('message'))										
                    <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                    <br><br>
                    @endif
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover" >
                                <thead style="text-align:center;vertical-align:middle;">
                                    <th style="width:8%;">Sl. No.</th>
                                    <th style="width:200.4px;">Employee ID</th>
                                    <th style="width:200.4px;">Employee Code</th>
                                    <th>Employee Name</th>
                                    <th style="width:5%;">Designation</th>
                                    <th>Loan type</th>
                                    <th style="width:5%;"> Loan start month </th>
                                    <th style="width:5%;"> Loan Amount </th>
                                    <th style="width:5%;"> Adjustment Amount </th>
                                    <th style="width:5%;"> Installment </th>
                                    <th style="width:5%;"> Deduction </th>
                                </thead>

                                <tbody>
                                    <?php //print_r($result);?>
                                    @php
                                        $total_loan_amount=0;
                                        $total_balance=0;
                                        $total_installment=0;
                                        $total_pf_interest=0;
                                        $total_deduction=0;
                                        $total_loanadjust=0;
                                    @endphp

                                    @foreach ($result as $index=>$record)
                                    @php
                                        $balance=0;
                                        if($record->recoveries==null){
                                            $balance = $record->loan_amount;
                                        }else{
                                            $balance = $record->loan_amount-$record->recoveries;
                                        }

                                        $total_loan_amount=$total_loan_amount+$record->loan_amount;
                                        $total_installment=$total_installment+$record->payroll_deduction;
                                        $total_pf_interest=$total_pf_interest+$record->pf_iterest;
                                        $total_deduction=$total_deduction+$record->payroll_deduction+$record->pf_iterest;

                                        $total_balance=$total_balance+$balance;
                                        $total_loanadjust=$total_loanadjust+$record->adjust_amount;
                                        $pf_interest=$record->pf_iterest;
                                    @endphp

                                    <tr>
                                        <td>{{$loop->iteration}}</td>

                                        <td>{{$record->emp_code}}</td>
                                        <td>{{$record->old_emp_code}}</td>
                                        <td>{{$record->salutation}} {{$record->emp_fname}} {{$record->emp_mname}} {{$record->emp_lname}}</td>

                                        <td>{{ucwords($record->emp_designation??'N/A')}}</td>
                                        <td>{{$record->loan_type}}</td>
                                        <td>{{ date('m/Y',strtotime($record->start_month??'N/A')) }}</td>

                                        <td>{{$record->loan_amount??'N/A'}}</td>
                                        <td>{{$record->adjust_amount??'N/A'}}</td>

                                        <td>{{$record->installment_amount??'N/A'}}</td>
                                        <td>
                                            @if ($record->deduction == 'Y')
                                                Yes
                                            @else
                                               No
                                            @endif
                                        </td>
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

    <script>

$(document).ready(function(){
	$("#basic-datatables").dataTable().fnDestroy();
	$('#basic-datatables').DataTable({
		lengthMenu: [[10, 20, 50, -1], [10, 20, 50, "All"]],
		initComplete: function(settings, json) {
			//doSumCoop();
			//doSumInsu();
			//doSumMisc();
			//cal_sum();
		}
	});
	//cal_sum();
});
function doSumCoop() {
    var table = $('#basic-datatables').DataTable();
    var nodes = table.column(6).nodes();
    var total = table.column(6 ).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
   	$(".total_coop").html(total);
}
function doSumInsu() {
    var table = $('#basic-datatables').DataTable();
    var nodes = table.column(7).nodes();
    var total = table.column(7).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	$(".total_insu").html(total);
}
function doSumMisc() {
    var table = $('#basic-datatables').DataTable();
    var nodes = table.column(8).nodes();
    var total = table.column(8).nodes()
      .reduce( function ( sum, node ) {
        return sum + parseFloat($( node ).find( 'input' ).val());
      }, 0 );
	$(".total_misc").html(total);
}
        
    </script>

    @endsection
   