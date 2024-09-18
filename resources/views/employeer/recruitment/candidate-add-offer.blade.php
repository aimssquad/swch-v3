@extends('employeer.include.app')
@section('title', 'Generate Offer Letter')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            @if(isset($_GET['id']))
            <h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Generate Offer Letter</h4>
            @else
            <h4 class="card-title"><i class="fas fa-briefcase"></i> Add Generate Offer Letter</h4>
            @endif 
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
               <li class="breadcrumb-item active">Generate Offer Letter</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
      <div class="card">
         <div class="card-body">
            <form action="{{url('org-recruitment/edit-offer-letter')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <div class="row form-group">
                  <div class="col-md-4">
                     <div class="form-group ">
                        <label for="user_id" class="col-form-label">Select Candidate</label>	
                        <select class="select" required="" name="user_id"  id="user_id" onchange="canuser(this.value);">
                           <option value="">Select</option>
                           <?php foreach($employees as $employee){ ?>
                           <option value="<?php echo $employee->user_id; ?>"  ><?php echo $employee->name; ?></option>
                           <?php } ?>
                        </select>
                        <!--<label for="inputFloatingLabel-recruitment" class="col-form-label">Current Stage of Recruitment</label>-->
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class=" form-group ">
                        <label for="offered_sal" class="col-form-label">Offered Salary</label>
                        <input type="text" id="offered_sal" class="form-control "  required="" name="offered_sal">
                     </div>
                  </div>
                  <div class="col-md-4"   >
                     <div class=" form-group ">
                        <label for="payment_type" class="col-form-label">Payment Type</label>
                        <select id="payment_type" class="select"  required="" name="payment_type">
                           <option value="">Select</option>
                           <option value="Year">Year</option>
                           <option value="Month">Month</option>
                           <option value="Month">Month</option>
                           <option value="Week">Week</option>
                           <option value="Day">Day</option>
                           <option value="Hour">Hour</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row form-group">
                  <div class="col-md-4"   >
                     <div class=" form-group ">
                        <label for="date_jo" class="col-form-label">Date Of Joining</label>
                        <input type="date" id="date_jo" class="form-control "  required="" name="date_jo">
                     </div>
                  </div>
                  <div class="col-md-4"   >
                     <div class="form-group ">
                        <label for="selectFloatingLabelra" class="col-form-label">Reporting Authority</label>
                        <select class="select" id="selectFloatingLabelra" name="reportauthor" >
                           <option value="">Select</option>
                           @foreach($employeelists as $employeelist)
                           <option value="{{$employeelist->emp_code}}" >{{$employeelist->emp_fname}} {{$employeelist->emp_mname}} {{$employeelist->emp_lname}} ({{$employeelist->emp_code}})</option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4" style="display:none;"  id="jot">
                     <div class="app-form-text">
                     </div>
                  </div>
                  <div class="col-md-4" style="display:none;" id="ej">
                     <div class="app-form-text" >
                     </div>
                  </div>
                  <div class="col-md-4" style="display:none;"  id="pj">
                     <div class="app-form-text" >
                     </div>
                  </div>
                  <div class="row form-group" >
                  </div>
               </div>
               <!-- 3rd row -->
               <div class="row form-group" style="margin-top:15px;background:none;">
                  <div class="col-md-12">
                     <button class="btn btn-primary sub" type="submit">Submit</button>
                  </div>
               </div>
               <!-- -----4th Row--------- -->
               <!-- -----5th Row-------- -->
         </div>
         <!--------------------  -->
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
    function canuser(val) {
        
        
            $.ajax({
            type:'GET',
            url:'{{url('recruitment/get-employee')}}/'+val,
            success: function(response){




              
               var obj = jQuery.parseJSON(response);
               
              if(obj===null){
                   
              }else{
                  
                  var job_title=obj.job_title; 
                   var email=obj.email; 
                    var phone=obj.phone; 
                    document.getElementById("pj").style.display = "block";	
                    document.getElementById("ej").style.display = "block";	
                    document.getElementById("jot").style.display = "block";	
                 document.getElementById("pj").innerHTML = '<div class="app-form-text"><h5>Contact Number:<span><br>+'+ phone +'</span></h5></div>';
               document.getElementById("ej").innerHTML = '<div class="app-form-text"><h5>Email:<span><br>'+ email +'</span></h5></div>';
               document.getElementById("jot").innerHTML = '<div class="app-form-text"><h5>Job Title:<span><br>'+ job_title +'</span></h5></div>';
               
              }
               
            
          
          
            }
        });


}
</script>
@endsection