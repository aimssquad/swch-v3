@extends('employeer.include.app')
@section('title', 'Daily Attendance Details')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Edit Daily Attendance Details</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Edit Daily Attendance Details</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            @include('employeer.layout.message')
            <div class="card-body">
               <form action="{{url('attendance-management/edit-daily')}}" method="post" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Department Name</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly  name="department"  value="{{ $job_details->emp_department}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Designation Name</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly  name="designation"  value="{{ $job_details->emp_designation}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Employee Code</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly name="employee_code"   value="{{ $job->employee_code}}">
                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Employee Name</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly   value="{{ $job->employee_name}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Date</label>
                           <input id="inputFloatingLabel2" type="date" class="form-control " readonly  name="date"    value="{{ $job->date}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Clock In</label>
                           <input id="inputFloatingLabel2" type="time" class="form-control " name="time_in"    value="{{$job->time_in}}">
                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Clock In Location</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly   value="{{ $job->time_in_location}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Clock Out</label>
                           <input id="inputFloatingLabel2" type="time" class="form-control " name="time_out"   value="{{ $job->time_out}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Clock Out Location</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly   value="{{ $job->time_out_location}}">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group ">
                           <label for="inputFloatingLabel2" class="col-form-label">Duty Hours</label>
                           <input id="inputFloatingLabel2" type="text" class="form-control " readonly  value="{{ $job->duty_hours}}">
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-12">
                        <button class="btn btn-primary sub" type="submit">Submit</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
