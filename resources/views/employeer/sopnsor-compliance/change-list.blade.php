@extends('employeer.include.app')
@section('title', 'Employee Change of Circumstance Report')

@section('content')
<!-- Page Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Change of Circumstances Report</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Change of Circumstances Report</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Filter Form -->
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form method="POST" action="{{ url('org-dashboard/change-of-circumstances') }}">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="employee_code" class="col-form-label">Employee Code</label>
                                <select id="employee_code" class="form-control" name="employee_code" required>
                                    <option value="">Select</option>
                                    @foreach($employee_type_rs as $employee_type)
                                        <option value="{{ $employee_type->emp_code }}" {{ $employee_code == $employee_type->emp_code ? 'selected' : '' }}>
                                            {{ $employee_type->emp_fname }} {{ $employee_type->emp_mname }} {{ $employee_type->emp_lname }} ({{ $employee_type->emp_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-4">
                                <button class="btn btn-primary" type="submit">Go</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Filter Form -->

    @if(Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif

    <!-- Employee Report -->
    @if(isset($employee) && isset($changeHistory))
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <h4 class="card-title">Employee Details</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Employee Name</th>
                                <td>{{ $employee->emp_fname }} {{ $employee->emp_mname }} {{ $employee->emp_lname }}</td>
                            </tr>
                            <tr>
                                <th>Employee Code</th>
                                <td>{{ $employee->emp_code }}</td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td>{{ $employee->emp_designation }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $employee->emp_ps_phone }}</td>
                            </tr>
                            <tr>
                                <th>Nationality</th>
                                <td>{{ $employee->nationality }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                      <h4 class="card-title">
                          <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Change of Circumstances History 
                      </h4>
                      <div>
                        <!-- PDF and Excel buttons side by side -->
                        <form method="POST" action="{{ url('employee/employee-circumstances-report-pdf') }}" class="d-inline-block">
                            @csrf
                            <input type="hidden" name="employee_code" value="{{ $employee->emp_code }}">
                            <button class="btn btn-info btn-sm">
                                <i class="fas fa-file-pdf"></i> Export to PDF
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ url('employee/employee-circumstances-excel') }}" class="d-inline-block">
                            @csrf
                            <input type="hidden" name="employee_code" value="{{ $employee->emp_code }}">
                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Export to Excel
                            </button>
                        </form>
                    </div>
                    
                  </div>
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date of Change</th>
                                        <th>Designation</th>
                                        <th>Phone</th>
                                        <th>Nationality</th>
                                        <th>Visa Expiration</th>
                                        <th>Passport Expiration</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($changeHistory as $change)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($change->date_change)) }}</td>
                                            <td>{{ $change->emp_designation }}</td>
                                            <td>{{ $change->emp_ps_phone }}</td>
                                            <td>{{ $change->nationality }}</td>
                                            <td>{{ $change->visa_exp_date != '1970-01-01' ? date('d/m/Y', strtotime($change->visa_exp_date)) : 'N/A' }}</td>
                                            <td>{{ $change->pass_exp_date != '1970-01-01' ? date('d/m/Y', strtotime($change->pass_exp_date)) : 'N/A' }}</td>
                                            <td>{{ $change->remarks ?? 'None' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Download buttons -->
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
