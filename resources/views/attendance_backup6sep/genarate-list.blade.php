@extends('attendance.include.app')
@section('content')
<div class="main-panel">
   <div class="page-header">
      <!-- <h4 class="page-title">Attendance Management</h4> -->
      <ul class="breadcrumbs">
         <li class="nav-home">
            <a href="{{url('attendancedashboard')}}">
            Home
            </a>
         </li>
         <li class="separator">
            /
         </li>
         <li class="nav-item active">
            <a href="{{url('attendance/generate-data')}}">Generate Attendence</a>
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
                     <form  method="post" action="{{ url('attendance/generate-data') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                           <div class="col-md-3">
                              <div class=" form-group">
                                 <label for="department" class="placeholder"> Select Department</label>
                                 <select class="form-control input-border-bottom" id="department" name="department" required="" onchange="chngdepartment(this.value);">
                                    <option value="">&nbsp;</option>
                                    @foreach($departs as $dept)
                                    <option value='{{ $dept->id }}'  >{{ $dept->department_name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="designation" class="placeholder"> Select Designation </label>
                                 <select class="form-control input-border-bottom" id="designation"  name="designation" required="" onchange="chngdepartmentdesign(this.value);">
                                    <option value="">&nbsp;</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class=" form-group">		
                                 <label for="employee_code" class="placeholder">Employee Code</label>
                                 <select id="employee_code" type="text" class="form-control input-border-bottom"  required="" name="employee_code"  style="">
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class=" form-group">
                                 <label for="start_date"  class="placeholder">Form Date</label>
                                 <input id="start_date"  type="date"  name="start_date" class="form-control input-border-bottom" required="" style="">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class=" form-group">
                                 <label for="inputFloatingLabel-select-date"  class="placeholder">To Date</label>
                                 <input id="end_date"  type="date" name="end_date" class="form-control input-border-bottom" required="" style="" onchange="chngshift(this.value);">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="designation" class="placeholder"> Select Shift </label>
                                 <select class="form-control input-border-bottom" id="shift_code"  name="shift_code" required="" >
                                    <option value="">&nbsp;</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
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
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Generate Attendance</h4>
                  </div>
                  <div class="card-body">
                     <form method="post" action="{{ url('attendance/save-generate-attandance') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="table-responsive">
                           <table id="basic-datatables" class="display table table-striped table-hover" >
                              <thead>
                                 <tr>
                                    <th>Sl No.</th>
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
                              <tfoot>
                                 <?php
                                    if(isset($result) && $result!=''  ){
                                    											 
                                    ?>
                                 <tr>
                                    <td colspan="11"><button style="float:right" type="submit" class="btn btn-default">Save</button></td>
                                 </tr>
                                 <?php }
                                    ?>
                              </tfoot>
                           </table>
                           </table>
                     </form>
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
    
     function chngshift(empid){
   var emid="<?= $Roledata->reg;?>";  
   var department=document.getElementById("department").value;  
   var  designation=document.getElementById("designation").value;  
   var  employee_code=document.getElementById("employee_code").value; 
   var  start_date=document.getElementById("start_date").value;  
   	var  end_date=document.getElementById("end_date").value;  
     	$.ajax({
   type:'GET',
   url:'{{url('pis/getEmployeedesigByshiftIdcode')}}/'+department+'/'+designation+'/'+employee_code+'/'+start_date+'/'+end_date+'/'+emid,
         cache: false,
   success: function(response){
   	
   	
   	document.getElementById("shift_code").innerHTML = response;
   }
   });
    }
    
    function setDutyHours(val){
   var timein="time_in"+val;
   var timeout="time_out"+val;
   var duty_hours="duty_hours"+val;
   
   var timein_val=$.base64.encode($('#'+timein).val());
   var timeout_val=$.base64.encode($('#'+timeout).val());
   // console.log(timein);
   // console.log($('#'+timein).val());
   // console.log($('#'+timeout).val());
   $.ajax({
   type:'GET',
   url:'{{url('pis/gettimemintuesnew')}}/'+timein_val+'/'+timeout_val,
         cache: false,
   success: function(response){
   	const obj = JSON.parse(response);
   	console.log(obj.hour);
   	var dh=obj.hour+':'+obj.min;
   	$('#'+duty_hours).val(dh)
   	
   }
   });
    }
   </script>
	   
   @endsection
   
   