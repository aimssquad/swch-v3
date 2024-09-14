@extends('employeer.include.app')
@section('title', 'Daily Attendence')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Daily Attendance</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Daily Attendance</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            @if(Session::has('message'))										
            <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
            @endif
            <div class="card-body">
               <form  method="post" action="{{ url('attendance-management/daily-attendance') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row form-group">
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-grade" class="col-form-label"> Select Department</label>
                           <select class="select" id="selectFloatingLabel" name="department" required="" onchange="chngdepartment(this.value);">
                              <option value="">&nbsp;</option>
                              @foreach($departs as $dept)
                              <option value='{{ $dept->id }}'  >{{ $dept->department_name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="designation" class="col-form-label"> Select Designation </label>
                           <select class="select" id="designation"  name="designation" required="" onchange="chngdepartmentdesign(this.value);">
                              <option value="">&nbsp;</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="employee_code" class="col-form-label">Employee Code</label>
                           <select id="employee_code" type="text" class="select" name="employee_code"  style="">
                              <?php if(isset($employee_code) && $employee_code!='') {
                                 ?>
                              <option value="{{$employee_code->emp_code}}"> {{$employee_code->emp_fname}} {{$employee_code->emp_mname}} {{$employee_code->emp_lname}} ({{$employee_code->emp_code}})</option>
                              <?php }
                                 ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">Select Date</label>
                           <input id="inputFloatingLabel-select-date" name="date" value="<?php if(isset($date) && $date) { echo $date;}?>"  type="date" class="form-control input-border-bottom" required="" style="">
                        </div>
                     </div>
                     <br>
                     <div class="col-md-3 p-3">
                        <a href="#">	
                        <button class="btn btn-primary" type="submit" >View</button></a>
                        <a href="#">	
                        <button class="btn btn-primary" type="reset" >Reset</button></a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                   <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;
               </h4>
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
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="basic-datatables" class="display table table-striped table-hover" >
                     <thead>
                        <tr>
                           <th>Sl No.</th>
                           <th>Department</th>
                           <th>Designation</th>
                           <th>Employee Code</th>
                           <th>Employee Name</th>
                           <th>Date</th>
                           <th>Clock In</th>
                           <th>Clock In Location</th>
                           <th>Clock Out</th>
                           <th>Clock Out Location</th>
                           <th>Duty Hours</th>
                           <th>Action</th>
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
@endsection
@section('script')                  
    <script >
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
        function chngdepartmentdesign(val){
    var empid=val;
    
                $.ajax({
    type:'GET',
    url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+empid,
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