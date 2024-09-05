@extends('employeer.include.app')
@section('title', 'Edit User Configuration')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  @if(isset($user) && !empty($user->id))  
                  @php $addclass ='form-control'; @endphp          	
                  <h4 class="card-title"><i class="far fa-user"></i> Edit User Configuration</h4>
                  @else   
                  @php $addclass ='select'; @endphp  
                  <h4 class="card-title"><i class="far fa-user"></i> Add User Configuration</h4>
                  @endif 
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{ url('user-access-role/vw-user-config') }}" method="post" enctype="multipart/form-data" >
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">	
                              <div class="row form-group">
                                 <div class="col-md-3">
                                    <div class="form-group ">
                                       <label for="selectFloatingLabel" class="col-form-label">Employee Code</label>
                                       <select  class="<?=$addclass?>" id="selectFloatingLabel"   <?php if(empty($user->id)){ ?>required=""  <?php } ?> name="emp_code" onchange="getEmployeeName()" <?php if(!empty($user->id)){echo 'style="display:none"';}?>>
                                          <option value="">Select Employee Code</option>
                                          <?php foreach($employees as $employee){?>
                                          <option value="<?php echo $employee['emp_code']; ?>" <?php if(!empty($user->id)){ if($user->employee_id== $employee['emp_code']){echo 'selected'; }} ?> ><?php echo $employee['emp_fname']." ".$employee['emp_mname']." ".$employee['emp_lname']." (".$employee['emp_code'].") "; ?></option>
                                          <?php } ?>
                                       </select>
                                       <input type="text" name="employee_id" value="<?php if(!empty($user->id)){echo $user->employee_id;} ?>" <?php if(empty($user->id)){echo 'style="display:none"';}?> class="form-control input-border-bottom" id="selectFloatingLabel" readonly="1" />
                                       @if ($errors->has('emp_code'))
                                       <div class="error" style="color:red;">{{ $errors->first('emp_code') }}</div>
                                       @endif
                                    </div>
                                 </div>
                                 <?php if(!empty($user->id)){
                                    $job_details=DB::table('employee')->where('emp_code', '=', $user->employee_id )->where('emid', '=', $Roledata->reg )->orderBy('id', 'DESC')->first();
                                    
                                    
                                    }	?>
                                 <div class="col-md-3">
                                    <div class="form-group ">
                                       <label for="inputFloatingLabel" class="col-form-label">Employee Name</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control " required="" name="name" value="<?php if(!empty($user->id)){echo $job_details->emp_fname.' '.$job_details->emp_mname.' '.$job_details->emp_lname;}?>"  readonly="1">
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group ">
                                       <label for="inputFloatingLabel1" class="col-form-label">Email</label>
                                       <input id="inputFloatingLabel1" type="email" class="form-control " required="" name="user_email" value="<?php if(!empty($user->id)){echo $user->email;}?>"  >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel2" class="col-form-label">User Password</label>
                                       <input id="inputFloatingLabel2" type="text" class="form-control input-border-bottom"  name="user_pass" value="<?php if(!empty($user->id)){echo $user->password;}?>">
                                       @if ($errors->has('user_pass'))
                                       <div class="error" style="color:red;">{{ $errors->first('user_pass') }}</div>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="col-md-3" <?php if(empty($user->id)){ ?>style="display:none" <?php } ?>>
                                    <div class="form-group">
                                       <label for="selectFloatingLabel3" class="col-form-label">User Password</label>
                                       <select id="selectFloatingLabel3"  class="select"   name="status">
                                          <option value="active" <?php if(!empty($user->status)){  if($user->status == "active"){ ?> selected="selected" <?php } }?>  >Active</option>
                                          <option value="inactive" <?php if(!empty($user->status)){ if($user->status == "inactive"){ ?> selected="selected" <?php } } ?>>Inactive</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <br>
                              <div class="row form-group">
                                 <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                 </div>
                              </div>
                        </div>
                        </form>
                     </div>
                  </div>
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
   function getEmployeeName()
	{	
		//$('#emplyeename').show();		
		var emp_code = $("#selectFloatingLabel option:selected").text();
		var empid = $("#selectFloatingLabel option:selected").val();
		var name = emp_code.split("(");
		
$.ajax({
				type:'GET',
				url:'{{url('role/get-employee-all-details')}}/'+empid,
				success: function(response){


 

				  
				   var obj = jQuery.parseJSON(response);
				  console.log(obj);
				  
					  var bank_sort=obj[0].em_email; 
					  

					  $("#inputFloatingLabel1").val(bank_sort);
				   $("#inputFloatingLabel1").attr("readonly", true);
				   
				  
				   
				
				  
			  
				}
			});
		$("#inputFloatingLabel").val(name[0]); 
			


		//$("#emp_name").attr("readonly", true);  
	}
</script>
@endsection