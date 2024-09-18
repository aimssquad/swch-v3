@extends('employeer.include.app')
@section('title', 'Department Wise Duty Roaster')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Department Wise Duty Roaster</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('rota-org/dashboard')}}">Rota Dashboard</a></li>
               <li class="breadcrumb-item active"> Add Department Wise Duty Roaster</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               @if(Session::has('message'))
               <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
               @endif
               <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateAndSubmitForm();">
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
                         <select class="select" id="designation"  name="designation" required="" onchange="chngdepartmentshift(this.value);">
                            <option value="">&nbsp;</option>
                            @if(app('request')->input('id'))
                            @foreach($desig as $desig)
                            <option value="{{$desig->id}}" <?php  if(app('request')->input('id')){  if($shift_management->designation==$desig->id){ echo 'selected';} } ?>>{{$desig->designation_name}}</option>
                            @endforeach
                            @endif
                         </select>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <label for="inputFloatingLabel-select-date" class="col-form-label" > From Date </label>
                         <input type="date" class="form-control input-border-bottom" name="start_date" id="form_date" required="">
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="form-group">
                         <label for="inputFloatingLabel-select-date" class="col-form-label" > To Date </label>
                         <input type="date" class="form-control input-border-bottom" name="end_date" id="to_date" onChange="dateValidation()" required="" >
                      </div>
                   </div>
                </div>
                <div class="row form-group shift-field" id="shift_code">
                </div>
                <br>
                <div class="row form-group">
                   <div class="col-md-4">
                      <div class="sub-reset-btn">
                         <a href="#">	
                         <button class="btn btn-primary" type="submit" >Submit</button></a>
                         <!-- <i class="fas fa-ban reset-ban-icon"></i> -->
                         {{-- <a href="#">	
                         <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Reset</button></a> --}}
                      </div>
                   </div>
                </div>
             </form>
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
      function chngdepartmentshift(empid) {
$.ajax({
   type: 'GET',
   url: '{{url('pis/getEmployeedesigBydutytshiftId')}}/' + empid,
   cache: false,
   success: function (response) {
       if (!response.trim()) {
           // Response is empty, display an alert
           alert('Shift not created. Please create a shift.');
       }

       // Set the "shift_code" field to the received response or empty if response is not available
       document.getElementById("shift_code").innerHTML = response || '';
   },
   error: function () {
       // Handle the error case if the AJAX request fails
       alert('Error occurred during the AJAX request.');
       // Set the "shift_code" field to empty
       document.getElementById("shift_code").innerHTML = '';
   }
});
}
     
         
        function chngdepartmentshiftcode(val)
    {	
    //$('#emplyeename').show();		
    
    
    $.ajax({
            type:'GET',
            url:'{{url('role/get-employee-all-details-shift')}}/'+val,
            success: function(response){
    
    
    
    
              
               var obj = jQuery.parseJSON(response);
              console.log(obj);
              
                  var bank_sort=obj[0].time_in; 
    
                  $("#time_in").val(bank_sort);
               $("#time_in").attr("readonly", true);
               
              
               
            
              
          
            }
        });
    $("#inputFloatingLabel").val(name[0]); 
        
    
    
    //$("#emp_name").attr("readonly", true);  
    }
    
    // Add this function to your script
       function validateAndSubmitForm() {
           var shiftCode = document.getElementById("shift_code").innerHTML;
       
           if (!shiftCode.trim()) {
               // Shift code is blank, display an alert
               alert('Shift not created. Please create a shift.');
               return false; // Prevent form submission
           }
       
           // If shift code is not blank, proceed with form submission
           return true;
       }

   
</script>
@endsection