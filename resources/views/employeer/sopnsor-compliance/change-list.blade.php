@extends('employeer.include.app')
@section('title', 'Change Of Circumstances')
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
            <h3 class="page-title"> Change Of Circumstances</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Change Of Circumstances</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               <form  method="post" action="{{ url('org-dashboard/change-of-circumstances') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row form-group">
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="employee_type" class="col-form-label">Employment Type</label>
                           <select id="employee_type" type="text" class="select" required="" name="employee_type" onchange="employeetype(this.value);"  style="margin-top: 20px;">
                              <option value="">Select</option>
                              @foreach($employee_type_rs as $employee_typ)
                              <option value="{{$employee_typ->employee_type_name}}" <?php if(isset($employee_type) && $employee_type==$employee_typ->employee_type_name) { echo 'selected';}?> >{{$employee_typ->employee_type_name}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="employee_code" class="col-form-label">Employee Code</label>
                           <select id="employee_code" type="text" class="select"  required=""  name="employee_code"  style="margin-top: 20px;">
                              <?php if(isset($employee_type)) {
                                 $employee_rs=DB::table('employee')
                                 
                                 ->where('emp_status', '=',  $employee_type)
                                 ->where('emid', '=',  $Roledata->reg)
                                 ->get();
                                 ?>
                              <option value=''>Select</option>
                              ";
                              <?php
                                 foreach($employee_rs as $bank)
                                 {
                                 ?>
                              <option value="<?=$bank->emp_code;?>" <?php  if(isset($employee_code) && $employee_code==$bank->emp_code) { echo 'selected';}?>><?= $bank->emp_fname;?> <?= $bank->emp_mname;?> <?= $bank->emp_lname;?> (<?=$bank->emp_code;?>)</option>
                              <?php } } ?>
                           </select>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <a href="#">	
                        <button class="btn btn-primary" type="submit">Go</button></a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   @if(Session::has('message'))										
   <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
   @endif
   <div class="row">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title"><i class="far fa-user"></i> Change Of Circumstances</h4>
            <?php
               if(isset($result) && $result!=''  ){
                                                   ?>
            <form  method="post" action="{{ url('employee/employee-circumstances-report') }}" enctype="multipart/form-data" >
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="employee_code" value="{{$employee_code}}">
               <input type="hidden" name="employee_type" value="{{$employee_type}}">
               <button class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Download PDF" style="margin-top: -30px;float:right;font-size:16px; margin-bottom:10px;background:none!important;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>	
            </form>
            <form  method="post" action="{{ url('employee/employee-circumstances-report-excel') }}" enctype="multipart/form-data" >
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <input type="hidden" name="employee_code" value="{{ $employee_code }}">
               <input type="hidden" name="employee_type" value="{{$employee_type}}">
               <button  data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="margin-top: -30px;float:right;background:none!important;font-size:16px; margin-bottom:10px;" type="submit"><<img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}">  </button>	
            </form>
            <?php
               }?>	
         </div>
         <div class="card-body">
            <div class="col-md-12">
               <div class="table-responsive">
                  <table class="table table-striped custom-table datatable" id="employeeTable">
                     <thead>
                        <tr>
                           <th>Sl No</th>
                           <th>Updated Date</th>
                           <th>Employment Type</th>
                           <th>Employee ID</th>
                           <th>Employee Name</th>
                           <th>Job  Title</th>
                           <th>Address</th>
                           <th>Contact Number</th>
                           <th>Nationality</th>
                           <th>BRP  Number</th>
                           <th>Visa Expired</th>
                           <th>Remarks/Restriction to work</th>
                           <th>Passport No</th>
                           <th>EUSS Details</th>
                           <th>DBS Details</th>
                           <th>National Id Details</th>
                           <th>Other Documents</th>
                           <th>Are Sponsored migrants aware that they must<br> inform [HR/line manager] promptly of changes<br> in contact Details? </th>
                           <th>Are Sponsored migrants  aware that they need to<br> cooperate Home Office interview by presenting original passports<br> during the Interview (In applicable cases)?</th>
                           <th>Annual  Reminder Date</th>
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
   
</script>
@endsection