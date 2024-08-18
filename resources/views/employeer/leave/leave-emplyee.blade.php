@extends('employeer.include.app')
@section('title', 'Leave Rule')
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
   <div class="page-inner">
      @if(Session::has('message'))										
      <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
      @endif
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <form  method="post" action="{{ url('leave/leave-report-employee') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row form-group">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputFloatingLabel-choose-year" class="col-form-label">Choose Year</label>
                                <select id="inputFloatingLabel-choose-year" name="year_value" class="form-control input-border-bottom" required="">
                                    <option value="">&nbsp;</option>
                                    <?php for($i = date("Y")-2; $i <=date("Y")+20; $i++){
                                        ?>
                                    <option value="<?= $i?>"  
                                        <?php if(isset($result) && $result!= ""  ){ if($i==$year_value){ echo "selected" ;}}?>> <?= $i ?></option>
                                    <?php
                                        } ?>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class=" form-group">
                                <label for="employee_code" class="col-form-label">Employee Code</label>
                                <select  type="text" class="form-control  select" name="employee_code"   required>
                                    <option value="">&nbsp;</option>
                                    @foreach($employee_rs as $employee)
                                    <option value='{{ $employee->emp_code }}' <?php if(isset($result) && $result!= ""  ){ if($employee->emp_code ==$employee_code){ echo "selected" ;}}?>  >{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{ $employee->emp_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                            <a href="#">	
                            <button class="btn btn-primary" type="submit" style="margin-top:10px;">View</button></a>
                            <a href="#">	
                            <button class="btn btn-primary" type="reset" style="margin-top:10px;">Reset</button></a>
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
                  <h4 class="card-title"><i class="far fa-file-archive" aria-hidden="true" style="color:#f78a0f;"></i> &nbsp;Leave Report Employee Wise</h4>
                  <?php
                     if(isset($result) && $result!=''  ){
                                                                 ?>
                  <form  method="post" action="{{ url('leave/leave-report-employee-wise') }}" enctype="multipart/form-data" >
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input  value="<?php echo $employee_code;?>"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
                     <input  value="<?php echo $year_value;?>"  name="year_value" type="hidden" class="form-control input-border-bottom" required="" >	
                     <button data-toggle="tooltip" data-placement="bottom" title="Download PDF" class="btn btn-default" style="margin-top: -30px;background:none !important;float:right;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>	
                  </form>
                  <form  method="post" action="{{ url('leave/leave-report-employee-wise-excel') }}" enctype="multipart/form-data" >
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <input  value="<?php echo $employee_code;?>"  name="employee_code" type="hidden" class="form-control input-border-bottom" required="" >
                     <input  value="<?php echo $year_value;?>"  name="year_value" type="hidden" class="form-control input-border-bottom" required="" >	
                     <buttondata-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="margin-top: -30px;background:none !important;float:right;margin-right: 15px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>	
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
                              <th>Employee Code</th>
                              <th>Employee Name</th>
                              <th>Leave Type</th>
                              <th>Date Of Application	</th>
                              <th>Duration</th>
                              <th>No. Of Days</th>
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
</div>
</div>    
<!-- /Page Content -->
@endsection
@section('script')
<!-- Include jQuery and DataTables JS library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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