@extends('employeer.include.app')
@section('title', 'Day Off')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Day Off</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('rota-org/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active"> Add Day Off Details</li>
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
               <form action="" method="post" enctype="multipart/form-data">
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
                        <div class=" form-group">
                           <label for="shift_code" class="col-form-label">Shift Code</label>
                           <select  id="shift_code"  name="shift_code"class="select" required="" >
                              <option value="">&nbsp;</option>
                              @if(app('request')->input('id'))
                              @foreach($shiftc as $shiftcval)
                              <option value="{{$shiftcval->id}}" <?php  if(app('request')->input('id')){  if($shift_management->shift_code==$shiftcval->id){ echo 'selected';} } ?>>{{$shiftcval->shift_code}} ( {{ $shiftcval->shift_des }}  )</option>
                              @endforeach
                              @endif
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-monday"  type="checkbox" name="mon" value="1" <?php  if(app('request')->input('id')){  if($shift_management->mon=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-monday" class="day-check">Monday</label>
                     </div>
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-tuesday" type="checkbox" name="tue" value="1" <?php  if(app('request')->input('id')){  if($shift_management->tue=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-tuesday" class="day-check">Tuesday</label>
                     </div>
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-wednesday" type="checkbox" name="wed" value="1" <?php  if(app('request')->input('id')){  if($shift_management->wed=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-wednesday" class="day-check">Wednesday</label>
                     </div>
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-thursday" type="checkbox" name="thu" value="1" <?php  if(app('request')->input('id')){  if($shift_management->thu=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-thursday" class="day-check">Thursday</label>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-friday" type="checkbox" name="fri" value="1" <?php  if(app('request')->input('id')){  if($shift_management->fri=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-friday" class="day-check">Friday</label>
                     </div>
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-saturday" type="checkbox" name="sat" value="1" <?php  if(app('request')->input('id')){  if($shift_management->sat=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-saturday" class="day-check">Saturday</label>
                     </div>
                     <div class="col-md-3">
                        <input id="inputFloatingLabel-sunday" type="checkbox" name="sun" value="1" <?php  if(app('request')->input('id')){  if($shift_management->sun=='1'){ echo 'checked';} } ?>>
                        <label for="inputFloatingLabel-sunday" class="col-form-label">Sunday</label>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="sub-reset-btn">
                           <a href="#">	
                           <button class="btn btn-default" type="submit" style="margin-top: 28px; background-color: #1572E8!important; color: #fff!important;">Submit</button></a>
                           <!-- <i class="fas fa-ban reset-ban-icon"></i> -->
                           <a href="#">	
                           <button class="btn btn-default" type="submit" style="margin-top: 28px; background-color: #1572E8!important; color: #fff!important;">Reset</button></a>
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
   function chngdepartmentshift(empid){
       $.ajax({
           type:'GET',
           url:'{{url('pis/getEmployeedesigBylateId')}}/'+empid,
           cache: false,
           success: function(response){
               document.getElementById("shift_code").innerHTML = response;
           }
       });
   }
   
   
</script>
@endsection