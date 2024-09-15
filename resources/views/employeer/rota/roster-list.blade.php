@extends('employeer.include.app')
@section('title', 'Duty Roaster')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
function my_simple_crypt( $string, $action = 'encrypt' ) {
// you may change these values to your own
$secret_key = 'bopt_saltlake_kolkata_secret_key';
$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
$output = false;
$encrypt_method = "AES-256-CBC";
$key = hash( 'sha256', $secret_key );
$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
if( $action == 'encrypt' ) {
$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
}
else if( $action == 'decrypt' ){
$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
}
return $output;
}
@endphp
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Duty Roster</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Duty Roster</li>
            </ul>
         </div>
      </div>
   </div>
   {{-- @include('layout.message') --}}
   @if(Session::has('message'))										
   <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
   @endif
   @if(Session::has('error'))										
   <div class="alert alert-danger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
   @endif
   <div class="row">
    <div class="col-md-12">
       <div class="card custom-card">
          <div class="card-header d-flex justify-content-between align-items-center">
             <h4 class="card-title"><i class="fa fa-briefcase" aria-hidden="true" style="color:#FF902F;"></i>&nbsp;Duty Roster</h4>
          </div>
          <div class="card-body">
             <form  method="post" action="{{ url('rota-org/add-duty-roster') }}" enctype="multipart/form-data" >
                {{csrf_field()}}
                <div class="row form-group">
                   <div class="col-md-4">
                      <div class=" form-group">
                         <label for="inputFloatingLabel-grade" class="col-form-label"> Select Department</label>
                         <select class="select" id="selectFloatingLabel" name="department" required="" onchange="chngdepartment(this.value);">
                            <option value="">&nbsp;</option>
                            @foreach($departs as $dept)
                            <option value='{{ $dept->id }}' <?php  if(app('request')->input('id')){ if($shift_management->department==$dept->id){ echo 'selected'; } } ?> >{{ $dept->department_name }}</option>
                            @endforeach
                         </select>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <label for="designation" class="col-form-label"> Select Designation </label>
                         <select class="select" id="designation"  name="designation" required="" onchange="chngdepartmentshift();">
                            <option value="">&nbsp;</option>
                         </select>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class=" form-group">		
                         <label for="employee_code" class="col-form-label">Employee Code</label>
                         <select id="employee_code" type="text" class="select"  name="employee_code">
                         ?></select>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <label for="inputFloatingLabel-select-date" class="col-form-label" > From Date </label>
                         <input type="date" class="form-control input-border-bottom" name="start_date" id="inputFloatingLabel-select-date" required=""  style="margin-top: 16px;">
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <label for="inputFloatingLabel-select-date" class="col-form-label" > To Date </label>
                         <input type="date" class="form-control input-border-bottom " name="end_date" id="inputFloatingLabel-select-date" required=""  style="margin-top: 16px;">
                      </div>
                   </div>
                </div>
                <br>
                <div class="row form-group">
                   <div class="col-md-4">
                      <div class="sub-reset-btn">	
                         <a href="#">	
                         <button class="btn btn-primary" type="submit">View Schedule</button></a>
                      </div>
                   </div>
                </div>
             </form>
          </div>
       </div>
    </div>
 </div>
   <!-- /Page Header -->
   <div class="row">
    <div class="col-md-12">
       <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
             <h4 class="card-title">Shift Schedule</h4>
             <div>
               <!-- Excel Link -->
               <a href="path_to_excel_export" class="btn btn-success btn-sm">
                   <i class="fas fa-file-excel"></i> Export to Excel
               </a>
               
               <!-- PDF Link -->
               <a href="path_to_pdf_export" class="btn btn-info btn-sm">
                   <i class="fas fa-file-pdf"></i> Export to PDF
               </a>
           </div>
             @if(isset($department) ? $department : '')
                   <form  method="post" action="{{ url('rota/duty-roster-report') }}" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input  value="{{ isset($employee_code) ? $employee_code : '' }}"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
                       <input  value="{{ isset($department) ? $department : '' }}"  name="department" type="hidden" class="form-control input-border-bottom" required="" >    
                       <input  value="{{ isset($designation) ? $designation : '' }}"  name="designation" type="hidden" class="form-control input-border-bottom" required="" >
                       <input  value="{{ isset($start_date) ? $start_date : '' }}"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                       <input  value="{{ isset($end_date) ? $end_date : '' }}"  name="end_date" type="hidden" class="form-control input-border-bottom" required="" >
                       <button data-toggle="tooltip" data-placement="bottom" title="Download PDF" class="btn btn-default" style="background:none !important;margin-top: -30px;float:right;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>    
                   </form>
               @endif
               
               @if(isset($department) ? $department : '')
                   <form  method="post" action="{{ url('rota/duty-roster-report-excel') }}" enctype="multipart/form-data" >
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input  value="{{ isset($employee_code) ? $employee_code : '' }}"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
                       <input  value="{{ isset($department) ? $department : '' }}"  name="department" type="hidden" class="form-control input-border-bottom" required="" >    
                       <input  value="{{ isset($designation) ? $designation : '' }}"  name="designation" type="hidden" class="form-control input-border-bottom" required="" >
                       <input  value="{{ isset($start_date) ? $start_date : '' }}"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                       <input  value="{{ isset($end_date) ? $end_date : '' }}"  name="end_date" type="hidden" class="form-control input-border-bottom" required="" >
                       <button data-toggle="tooltip" data-placement="bottom" title="Download excel"  class="btn btn-default" style="background:none !important;margin-top: -30px;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>    
                   </form>
               @endif
          </div>
          <div class="col-auto float-end ms-auto">
            @if($user_type == 'employee')
            @foreach($sidebarItems as $value)
            @if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
            <a href="{{ url('rota-org/add-employee-duty')}}" class="btn add-shift-btn" data-toggle="tooltip" data-placement="bottom" title="Add Duty Roster(Employee wise)"
                   style="background: none !important;"> &nbsp;<img  style="width: 35px;" src="{{ asset('img/user-image.png')}}"></a>
                   <a href="{{ url('rota-org/add-department-duty') }}" class="btn add-btn"><i class="la la-plus"></i>Add Duty Roster(Department wise)</a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{ url('rota-org/add-employee-duty')}}" class="btn add-shift-btn" data-toggle="tooltip" data-placement="bottom" title="Add Duty Roster(Employee wise)"
                   style="background: none !important;"> &nbsp;<img  style="width: 35px;" src="{{ asset('img/user-image.png')}}"></a>
                   <a href="{{ url('rota-org/add-department-duty') }}" class="btn add-btn"><i class="la la-plus"></i>Add Duty Roster(Department wise)</a>
            @endif
            {{-- <div class="view-icons"> --}}
                {{-- <a href="{{url('organization/employeeee')}}" class="btn add-btn"><i class="la la-plus"></i>Add Duty Roster(Department wise)</a> --}}
            {{-- </div> --}}
        </div>
          <div class="card-body">
             {{-- <div class="add-shift">
                <a href="{{ url('rota/add-employee-duty') }}" class="btn add-shift-btn" data-toggle="tooltip" data-placement="bottom" title="Add Duty Roster(Employee wise)"
                   style="background: none !important;"> &nbsp;<img  style="width: 35px;" src="{{ asset('img/user-image.png')}}"></a>
                <a href="{{ url('rota/add-department-duty') }}" class="btn add-shift-btn" data-toggle="tooltip" data-placement="bottom" title="Add Duty Roster(Department wise)" style="background: none !important;"> &nbsp;<img  style="width: 35px;" src="{{ asset('img/plus1.png')}}"></a>
             </div> --}}
             <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover" >
                   <thead>
                      <tr>
                         <th>Department</th>
                         <th>Designation</th>
                         <th>Employee Name</th>
                         <th>Shift Code</th>
                         <th>Work In Time</th>
                         <th>Work Out Time</th>
                         <th>Break Time From</th>
                         <th>Break Time  To</th>
                         <th>From Date</th>
                         <th>To Date</th>
                      </tr>
                   </thead>
                   <tbody>
                      <?php
                         if(isset($result) && $result!=''  ){
                             print_r($result); 
                         }?>
                   </tbody>
                </table>
             </div>
          </div>
       </div>
    </div>
 </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<script>
   $(document).ready(function() {
            $('#basic-datatables').DataTable({
            });
        
            $('#multi-filter-select').DataTable( {
                "pageLength": 5,
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select class="form-control"><option value=""></option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                                );
        
                            column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                        } );
        
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });
        
            // Add Row
            $('#add-row').DataTable({
                "pageLength": 5,
            });
        
            var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
        
            $('#addRowButton').click(function() {
                $('#add-row').dataTable().fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action
                    ]);
                $('#addRowModal').modal('hide');
        
            });
        });
   
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }

        function chngdepartmentshift(){  
            var degId= $('#designation option:selected').text();
            $.ajax({
                type:'GET',
                url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+degId,
                        cache: false,
                success: function(response){
                    document.getElementById("employee_code").innerHTML = response;
                }
            });
        }
        function chngdepartment(empid){
       
            $.ajax({
                type:'GET',
                url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
                        cache: false,
                success: function(response){
                    
                    
                    document.getElementById("designation").innerHTML = response;
                }
            });
        }
    
</script>
@endsection