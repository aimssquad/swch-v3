@extends('employeer.include.app')
@section('title', 'Role Management')
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title"><i class="far fa-user"></i> Add Role Management</h4>
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{ url('user-access-role/user-role') }}" method="post" enctype="multipart/form-data">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">	
                           <div class="row form-group">
                              <div class="col-md-3">
                                 <label class="col-form-label">Select Module</label>
                                 <select  class="select" name="module_name" onchange="getSubModules(this.value);" required>
                                    <option value="" selected disabled>Select Module</option>
                                    @foreach($module as $mod)
                                    <option value="{{$mod->id}}" <?php if(!empty($role_authorization->module_name)){  if($role_authorization->module_name == $mod->id){ ?> selected="selected" <?php } }?> >{{$mod->module_name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <label class="col-form-label">Menu</label>												
                                 <select id="role_menus" name="menu_name[]"  class="select"  multiple data-live-search="true" required>
                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <label class="col-form-label">Rights</label><br>
                                 <select class="select" multiple data-live-search="true"   name="user_rights_name[]" required>
                                    <option value="" label="default" ></option>
                                    <option value="Add">Add</option>
                                    <option value="Edit">Edit</option>
                                    <!--  <option value="Delete">Delete</option>-->
                                 </select>
                              </div>
                              <div class="col-md-3">
                                 <label class="col-form-label" >Select User</label>
                                 <select class="select" multiple data-live-search="true" name="member_id[]" required>
                                    <option value="" label="default"></option>
                                    @foreach($users as $user)
                                    <option value="{{$user->email}}">{{$user->name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <br>
                           <div class="row form-group">
                              <div class="col-md-12">
                                 <button class="btn btn-primary" type="submit">Submit</button>
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
   function getSubModules(module_id)
	{	
		$.ajax({
			type:'GET',
			url:'{{url('role/get-sub-modules')}}/'+module_id,				
			success: function(response){
			//console.log(response); 
				$("#role_menus").html(response);
			}
		});
	}

	function getMenu(sub_module_id)
	{	
		$.ajax({
			type:'GET',
			url:'{{url('role/get-role-menu')}}/'+sub_module_id,				
			success: function(response){
			console.log(response); 
			$("#role_menus").html(response);
			}
		});
	}
</script>
@endsection