@extends('employeer.include.app')
@section('title', 'Absent Report')
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
            <h3 class="page-title"> Absent Report</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active">Absent Report</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
    <div class="col-md-12">
       <div class="card custom-card">
          <div class="card-body">
             <form  method="post" action="{{ url('org-dashboard/absent-report') }}" enctype="multipart/form-data" >
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
                         <select id="employee_code" type="text" class="select" name="employee_code"   style="" required>
                         </select>
                      </div>
                   </div>
                   <div class="col-md-3">
                      <div class="form-group">
                         <label for="inputFloatingLabel-choose-year" class="col-form-label">Choose Year</label>
                         <select id="inputFloatingLabel-choose-year" name="year_value" class="select" required="">
                            <option value="">&nbsp;</option>
                            <?php for($i = date("Y")-2; $i <=date("Y")+5; $i++){
                               echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;
                               } ?>
                         </select>
                      </div>
                   </div>
                </div>    
                   <br>
               <div class="row form-group">
                   <div class="col-md-3">
                      <a href="#">	
                      <button class="btn btn-primary" type="submit">View</button></a>
                      <a href="#">	
                      <button class="btn btn-primary" type="reset">Reset</button></a>
                   </div>
               </div>
             </form>
          </div>
       </div>
    </div>
 </div>
 @include('employeer.layout.message')
   <div class="row">
      <div class="card">
      <div class="card-header">
         <h4 class="card-title"> <i class="far fa-file" aria-hidden="true" style="color: color:#10277f;"></i> &nbsp;Absent Report
                            <?php

if(isset($result) && $result!=''  ){
            ?>
            <span>		<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{ url('dashboard/absent-record-card/'.base64_encode($employee_code).'/'.base64_encode($year_value)) }}" target="_blank"><img  style="width: 35px;" src="{{ asset('img/view.png')}}"></a></span>
               <span>		<a data-toggle="tooltip" data-placement="bottom" title="Download PDF" href="{{ url('dashboard/absent-record-card-pdf/'.base64_encode($employee_code).'/'.base64_encode($year_value)) }}"  ><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></a></span>
            <?php
}?>
</h4>	
      </div>
      <div class="card-body">
      <div class="col-md-12">
         <div class="table-responsive">
            <table class="table table-striped custom-table" id="basic-datatables">
               <thead>
                  <tr>
                     <th>Sl No</th>
												
													<th>Department</th>
													<th>Designation</th>
													<th>Employee Code</th>
													<th>Employee Name</th>
														<th>Month</th>
													<th>No.of Working Days</th>
													<th>No.of Present Days</th>
												
													<th>No.of Leave Taken</th>
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
        $('#allval').click(function(event) {  
		
      if(this.checked) {
         //alert("test");
         // Iterate each checkbox
         $(':checkbox').each(function() {
            this.checked = true;                        
         });
      } else {
         $(':checkbox').each(function() {
            this.checked = false;                       
         });
      }
   });
      function employeetype(val){
   var empid=val;
   
            $.ajax({
   type:'GET',
   url:'{{url('pis/getEmployeedailyattandeaneById')}}/'+empid,
     cache: false,
   success: function(response){
      
      
      document.getElementById("employee_code").innerHTML = response;
   }
   });
}


   function chngdepartmentdesign(val){
   var empid=val;

            $.ajax({
   type:'GET',
   url:'{{url('pis/getEmployeedailyattandeaneshightById/absent')}}/'+empid,
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