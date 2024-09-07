@extends('employeer.employee-corner.main')
@section('title', 'Daily Work Update')
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <div class="card custom-card">
                  <div class="card-header">
                     <h4 class="card-title"><i class="far fa-user"></i> Daily Work Update</h4>
                  </div>
                  <div class="card-body">
                     <div class="multisteps-form">
                        @if(Session::has('message'))										
                        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                        @endif
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                                <form method="post" action="{{ url('org-employee-corner/task-save') }}" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <input type="hidden" name="reg" value="{{$Roledata->reg}}">
                                <input type="hidden" name="employee_code" value="{{$employee->emp_code}}">
                                <div class="row form-group">
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="date" class="col-form-label"
                                                style="margin-top:-12px;">Date</label>
                                            <input id="date" type="date"
                                                class="form-control input-border-bottom" name="date" required
                                                min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" readonly>


                                        </div>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="in_time" class="col-form-label"> From Time</label>
                                            <input id="in_time" type="time"
                                                class="form-control input-border-bottom" name="in_time" required
                                                onchange="checktime();">

                                        </div>

                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="out_time" class="col-form-label"> To Time</label>
                                            <input id="out_time" type="time"
                                                class="form-control input-border-bottom" name="out_time"
                                                required onchange="checktime();">

                                        </div>

                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="w_hours" class="col-form-label" style="margin-top:-12px;">
                                                Time (Hours)</label>
                                            <input id="w_hours" type="number" step="any"
                                                class="form-control input-border-bottom" name="w_hours"
                                                required>

                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="w_min" class="col-form-label" style="margin-top:-12px;">
                                                Time (Minutes)</label>
                                            <input id="w_min" type="number" step="any"
                                                class="form-control input-border-bottom" name="w_min" required>

                                        </div>

                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="w_min" class="col-form-label"
                                                style="margin-top:-12px;">Upload file</label>
                                            <input id="file" type="file" accept="image/*;capture=camera"
                                                class="form-control input-border-bottom" name="file"
                                                onchange="Filevalidationproimge()">

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label for="w_min" class="col-form-label" style="margin-top:12px;">
                                                Work Update</label>
                                            <textarea class="form-control input-border-bottom" name="remarks"
                                                required></textarea>


                                        </div>

                                    </div>

                                </div>
                                <br>
                                <div class="row form-group">
                                    <div class="col-md-12">

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
   </div>
</div>
@endsection
@section('script')
    <script>
     function checktime() {
        var in_time = btoa(document.getElementById("in_time").value);

        var out_time = btoa(document.getElementById("out_time").value);

        $.ajax({
            type: 'GET',
            url: '{{url("pis/gettimemintuesnew")}}/' + in_time + '/' + out_time,
            cache: false,
            success: function(responsejj) {

                var objh = jQuery.parseJSON(responsejj);
                console.log(objh);
                $("#w_hours").val(objh.hour);
                $("#w_hours").attr("readonly", true);
                $("#w_min").val(objh.min);
                $("#w_min").attr("readonly", true);

            }
        });
    }
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>

    <script>
    $(function() {
        $('#in_time, #out_time').timepicker({
            format: 'HH:mm',
            pickDate: false,
            pickSeconds: false,
            pick12HourFormat: false
        });
    });

    Filevalidationproimge = () => {
        const fi = document.getElementById('file');
        // Check if any file is selected.

        if (fi.files.length > 0) {
            for (const i = 0; i <= fi.files.length - 1; i++) {

                const fsize = fi.files.item(i).size;
                const file = Math.round((fsize / 1024));
                // The size of the file.
                if (file <= 2048) {

                } else {
                    alert(
                        "File is too Big, please select a file up to 2mb");
                    $("#file").val('');
                }
            }
        }
    }
    </script>



    <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
@endsection