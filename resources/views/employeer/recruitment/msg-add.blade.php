@extends('employeer.include.app')
@section('title', 'Message Center')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            @if(isset($_GET['id']))
            <h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Message Center</h4>
            @else
            <h4 class="card-title"><i class="fas fa-briefcase"></i> Add Message Center</h4>
            @endif 
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Message Center</li>
            </ul>
         </div>
         @include('employeer.layout.message')
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="card">
         <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <div class="row form-group">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="selectFloatingLabel" class="col-form-label">Select Candidate</label>				
                        <select class="form-control input-border-bottom" id="selectFloatingLabel" name="user_id" required="" onchange="billvalue(this.value);" >
                           <option value="">&nbsp;</option>
                           @foreach($or_rs as $billdept)
                           <option value='{{ $billdept->id}}' >{{ $billdept->name }}</option>
                           @endforeach					
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class=" form-group">
                        <label for="email" class="col-form-label">Candidate Email</label>
                        <input id="email" type="text"  name="email"    class="form-control input-border-bottom" required="">
                     </div>
                  </div>
               </div>
               <div  class="row form-group" id="payment" style="display:none">
                  <div class="col-md-12">
                     <div class=" form-group">
                        <label for="subject" class="col-form-label">CC</label>
                        <input id="cc" type="email"  name="cc"    class="form-control input-border-bottom">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class=" form-group">
                        <label for="subject" class="col-form-label">Subject</label>
                        <input id="subject" type="text"  name="subject"    class="form-control input-border-bottom" required="">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <textarea id="editor" name="msg" style="margin-top:20px">
                     </textarea>
                  </div>
                  <div class="col-md-12">
                     <div class=" form-group">
                        <label for="subject" class="col-form-label">Upload Attachment</label>
                        <input id="file" type="file"  name="photos[]"  multiple    class="form-control input-border-bottom">
                     </div>
                  </div>
               </div>
               <br>
               <div class="row form-group">
                  <div class="col-md-4">
                     <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> SEND</button>
                  </div>
               </div>
         </div>
         </form>
      </div>
   </div>
</div>
</div>
<!-- /Page Content -->
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
              function billvalue(empid){
   
       $.ajax({
    type:'GET',
    url:'{{url('pis/getbillorganmsgniuById')}}/'+empid,
    cache: false,
    success: function(response){
        
        
        var obj = jQuery.parseJSON(response);
         $("#payment").show();
         console.log(obj);
        
         
                $("#email").val(obj[0].email);
               $("#email").attr("readonly", true);
              
               
    }
    });
}
</script>
@endsection