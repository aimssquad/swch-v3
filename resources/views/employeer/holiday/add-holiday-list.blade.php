@extends('employeer.include.app')
@if(!empty($holidaydtl->id))
@section('title', 'Edit Holiday')
@else
@section('title', 'Add Holiday')
@endif
@section('content')
<div class="main-panel">
<div class="content">
<div class="page-inner">
   <div class="row">
      <div class="col-md-12">
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('orgaization/holiday-dashboard')}}">Dashboard</a></li>
            @if(!empty($holidaydtl->id))
            <li class="breadcrumb-item active">Edit Holiday list</li>
            @else
            <li class="breadcrumb-item active">Add New Holiday list</li>
            @endif
         </ul>
         <div class="card custom-card">
            <div class="card-header">
               @if(!empty($holidaydtl->id))
               <h4 class="card-title"><i class="far fa-user"></i>  Edit New Holiday List</h4>
               @else
               <h4 class="card-title"><i class="far fa-user"></i>  Add New Holiday List</h4>
               @endif
            </div>
            <div class="card-body">
               <div class="multisteps-form">
                  <!--form panels-->
                  <div class="row">
                     <div class="col-12 col-lg-12 m-auto">
                        <form action="{{ url('organization/save-holiday-list') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                           {{csrf_field()}}
                           <input type="hidden" name="id" value="<?php  if(!empty($holidaydtl->id)){echo $holidaydtl->id;} ?>">
                           <div class="row form-group">
                              <div class="col-md-3">
                                 <div class="form-group ">
                                    <label for="inputFloatingLabel1" class="col-form-label">From Date</label>
                                    <input id="inputFloatingLabel1" type="date" class="form-control "  required="" name="from_date"  value="<?php  if(!empty($holidaydtl->from_date)){echo $holidaydtl->from_date;} ?>" >
                                    @if ($errors->has('from_date'))
                                    <div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group ">
                                    <label for="inputFloatingLabel2" class="col-form-label">To Date</label>
                                    <input id="inputFloatingLabel2" type="date" class="form-control " name="to_date"  required=""  value="<?php  if(!empty($holidaydtl->to_date)){echo $holidaydtl->to_date;} ?>"  onchange="calculateDays()" onclick="calculateDays()">
                                    @if ($errors->has('to_date'))
                                    <div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group ">
                                    <label for="selectFloatingLabel" class="col-form-label">Day</label>
                                    <select class="select" id="" required="" name="weekname"  required="">
                                       <option value="sunday" <?php if(!empty($holidaydtl->weekname)){ if("sunday"== $holidaydtl->weekname) { echo "selected"; } } ?>>Sunday</option>
                                       <option value="monday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'monday'){ echo "selected"; } } ?>>Monday</option>
                                       <option value="tuesday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'tuesday'){ echo "selected"; } } ?>>Tuesday</option>
                                       <option value="wednesday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'wednesday'){ echo "selected"; } } ?>>Wednesday</option>
                                       <option value="thrusday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'thrusday'){ echo "selected"; } } ?>>Thursday</option>
                                       <option value="friday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'friday'){ echo "selected"; } } ?>>Friday</option>
                                       <option value="saturday" <?php if(!empty($holidaydtl->weekname)){ if($holidaydtl->weekname == 'saturday'){ echo "selected"; } } ?>>Saturday</option>
                                    </select>
                                    @if ($errors->has('weekname'))
                                    <div class="error" style="color:red;">{{ $errors->first('weekname') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="selectFloatingLabel" class="col-form-label">Holiday Type</label>
                                    <select class="select" id="selectFloatingLabel" required="" name="holiday_type">
                                       @foreach($holiday_type as $value):
                                       <option value="{{ $value->id }}" <?php if(!empty($holidaydtl->holiday_type)){ if($value->id== $holidaydtl->holiday_type) { echo "selected"; } } ?>>
                                          {{ $value->name }} 
                                       </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('holiday_type'))
                                    <div class="error" style="color:red;">{{ $errors->first('holiday_type') }}</div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <div class="row form-group">
                              <div class="col-md-3">
                                 <div class="form-group ">
                                    <label for="inputFloatingLabel3" class="col-form-label">No. of Days</label>
                                    <input id="inputFloatingLabel3" type="text" class="form-control " required=""  name="day" value="<?php  if(!empty($holidaydtl->day)){echo $holidaydtl->day;} ?>"  readonly>
                                    @if ($errors->has('day'))
                                    <div class="error" style="color:red;">{{ $errors->first('day') }}</div>
                                    @endif
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="inputFloatingLabel4" class="col-form-label">Holiday Description</label>
                                    <input id="inputFloatingLabel4" type="text" class="form-control input-border-bottom" required="" name="holiday_descripion" value="<?php  if(!empty($holidaydtl->holiday_descripion)){echo $holidaydtl->holiday_descripion;} ?>">
                                    @if ($errors->has('holiday_descripion'))
                                    <div class="error" style="color:red;">{{ $errors->first('holiday_descripion') }}</div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                           <br>
                           <div class="row form-group">
                              <div class="col-md-12 text-center">
                                 <button type="submit" class="btn btn-primary">Submit</button>
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
        function calculateDays(){
        var from_date= $("#inputFloatingLabel1").val();
        var to_date= $("#inputFloatingLabel2").val();
        var fromdate = new Date(from_date);
        var todate = new Date(to_date);
        var diffDays = (todate.getDate() - fromdate.getDate()) + 1 ;
        $("#inputFloatingLabel3").val(diffDays);
    }
</script>
@endsection