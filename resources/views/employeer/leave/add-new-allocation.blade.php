@extends('employeer.include.app')
@section('title', 'Add Leave Allocation')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i>  Add New Leave Allocation</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{ url('leave/get-leave-allocation') }}" method="post" enctype="multipart/form-data" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_type" class="col-form-label">Employment Type</label>
                                            <select id="employee_type"   name="employee_type" type="date" class="select" required="" onchange="paygr(this.value);">
                                                <option value=""></option>
                                                @foreach($employee_type_rs as $emp)
                                                <option value="{{$emp->employ_type_name}}">{{$emp->employ_type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="employee_code" class="col-form-label">Employee Code</label>
                                            <select id="employee_code"  id="employee_code" name="employee_code" class="select">
                                                <?php if(isset($remp) && $remp!=''){?>
                                                @foreach($employees as $empval)
                                                <option value="{{$empval->emp_code}}" <?php if( $empval->emp_code==$remp){echo 'selected';}?>>{{$empval->emp_fname }} {{$empval->emp_mname }} {{$empval->emp_lname }} ({{$empval->emp_code }})</option>
                                                @endforeach
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                    <br>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" style="margin-top: 10px;margin-bottom: 10px;">Submit</button>
                                        </div>
                                    </div>
                                </div>
                           </form>
                        </div>
                        <form method="post" action="{{ url('leave-management/save-leave-allocation') }}">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <div class="table-responsive">
                              <table id="basic-datatables" class="table table-striped custom-table "  >
                                 <thead>
                                    <tr>
                                       <th>
                                          <div class="form-check"><label class="form-check-label">
                                             <span class="form-check-sign"> Select</span></label>
                                          </div>
                                       </th>
                                       <th>Employment Type</th>
                                       <th>Employee Code</th>
                                       <th>Employee name</th>
                                       <th>Leave Name</th>
                                       <th>Maximum No.</th>
                                       <th>Leave in Hand</th>
                                       <th>Effective Year</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php print_r($result); ?>
                                 </tbody>
                                 <tfoot>
                                    <?php if(isset($result) && $result!=''){ ?>
                                    <tr>
                                       <td colspan="4">
                                          <div class="form-check"><label class="form-check-label"><input id="selectAllval" class="form-check-input" type="checkbox" name="allval" >
                                             <span class="form-check-sign"> </span>Check All</label>
                                          </div>
                                       </td>
                                       <td colspan="4"><button style="float:right" class="btn btn-default">Save</button></td>
                                    </tr>
                                    <?php
                                       }
                                       ?>
                                 </tfoot>
                              </table>
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
	<!-- Include jQuery and DataTables JS library -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable({
            paging: true,
            searching: true,
            info: true,
            dom: '<"d-flex justify-content-between"lf>t<"d-flex justify-content-between"ip>',
            language: {
                lengthMenu: "Show _MENU_ entries",
                search: "Search:"
            }
        });
    });
</script>
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = url;
        }
    }
</script> --}}

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
</script>
<script>
$("#selectAll").click(function() {
$("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});
$("input[type=checkbox]").click(function() {
if (!$(this).prop("checked")) {
    $("#selectAll").prop("checked", false);
}
});

$("#selectAllval").click(function() {
$("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});
$("input[type=checkbox]").click(function() {
if (!$(this).prop("checked")) {
    $("#selectAllval").prop("checked", false);
}
});

jackHarnerSig();


function paygr(val){
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