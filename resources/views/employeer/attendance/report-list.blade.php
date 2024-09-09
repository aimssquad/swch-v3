@extends('employeer.include.app')
@section('title', 'Attendance History')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Attendance History</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Attendance History</li>
            </ul>
         </div>
      </div>
   </div>
   @if(Session::has('message'))										
   <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
   @endif
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               <form  method="post" action="{{ url('attendance-management/attendance-report') }}" enctype="multipart/form-data" >
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
                           <select id="employee_code" type="text" class="select" name="employee_code" required  style="">
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">Form Date</label>
                           <input id="inputFloatingLabel-select-date"  type="date"  name="start_date" class="form-control input-border-bottom" required="" style="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">To Date</label>
                           <input id="inputFloatingLabel-select-date"  type="date" name="end_date" class="form-control input-border-bottom" required="" style="">
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <a href="#">	
                        <button class="btn btn-primary" type="submit" >Go</button></a>
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
            <div class="card-header">
               <h4 class="card-title"><i class="fa fa-history" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Attendance History</h4>
               <?php
                  if(isset($result) && $result!=''  ){
                  											?>
               <form  method="post" action="{{ url('attendance/attendance-month-report') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input  value="<?php echo $employee_code;?>"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
                  <input  value="<?php echo $department;?>"  name="department" type="hidden" class="form-control input-border-bottom" required="" >	
                  <input  value="<?php echo $designation;?>"  name="designation" type="hidden" class="form-control input-border-bottom" required="" >
                  <input  value="<?php echo $start_date;?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                  <input  value="<?php echo $end_date;?>"  name="end_date" type="hidden" class="form-control input-border-bottom" required="" >
                  <button data-toggle="tooltip" data-placement="bottom" title="Download PDF" class="btn btn-default" style="background:none !important;margin-top: -30px;float:right;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>	
               </form>
               <form  method="post" action="{{ url('attendance/attendance-month-report-excel') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input  value="<?php echo $employee_code;?>"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
                  <input  value="<?php echo $department;?>"  name="department" type="hidden" class="form-control input-border-bottom" required="" >	
                  <input  value="<?php echo $designation;?>"  name="designation" type="hidden" class="form-control input-border-bottom" required="" >
                  <input  value="<?php echo $start_date;?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                  <input  value="<?php echo $end_date;?>"  name="end_date" type="hidden" class="form-control input-border-bottom" required="" >
                  <button data-toggle="tooltip" data-placement="bottom" title="Download Excel"  class="btn btn-default" style="margin-top: -30px;float:right;background:none !important" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>	
               </form>
               <?php
                  }?>
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
                url:'{{url('pis/getEmployeedailyattandeaneshightByIdnewr')}}/'+empid,
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