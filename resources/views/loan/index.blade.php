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
         <li class="nav-item active"><a href="#">View Loans</a></li>
      </ul>
   </div>
   <div class="content">
      <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;View Loans</h4>
                        <div class="card-header-fixed-loan">
                        <form  method="post" action="{{ url('loans/xls-export-loan-list') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button  title="Download Excel" class="btn float-right excel-button" type="submit" ><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
                        </form>
                        <a href="{{ url('loans/add-loan') }}" class="btn btn-primary float-right">Add Loan <i class="fa fa-plus"></i></a>
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
                                    <tr>
                                    <th>Sl No.</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Loan ID</th>
                                    <th>Loan Start Month</th>
                                    <th>Loan Type</th>
                                    <th>Loan Amount</th>
                                    <th>Installment Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Deduction</th>
                                    <th>Adjust</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($employee_rs as $employee)

                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $employee->emp_code}}</td>
                                    <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                    <td>{{ $employee->Designation }}</td>
                                    <td>{{ $employee->loan_id }}</td>
                                    <td>{{ date('m/Y',strtotime($employee->start_month)) }}</td>
                                    <td>
                                        @if($employee->loan_type=='SA')
                                            Salary Advance
                                        @endif
                                        @if($employee->loan_type=='PF')
                                            PF Loan
                                        @endif
                                    </td>
                                    <td>{{ $employee->loan_amount }}</td>
                                    <td>{{ $employee->installment_amount }}</td>
                                    <td>{{ $employee->balance==null? $employee->loan_amount : $employee->loan_amount - $employee->balance }}</td>
                                    <td>{{ ($employee->deduction=='Y')?'Yes':'No' }}</td>
                                    <td>
                                        @if($employee->adjust_date==null || $employee->adjust_date=='0000-00-00')
                                        <a class="btn btn-info btn-sm " href="{{url('loans/adjust-loan')}}/{{$employee->id}}">Adjust</a>

                                        @else
                                        <a class="btn btn-sm" href="{{url('loans/view-adjust-loan')}}/{{$employee->id}}" style="background:green;color:white;">View</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($employee->adjust_date==null || $employee->adjust_date=='0000-00-00')
                                        <a href="{{url('loans/edit-loan')}}/{{$employee->id}}"><i class="fas fa-pencil-alt"></i></a>
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

    @endsection
   