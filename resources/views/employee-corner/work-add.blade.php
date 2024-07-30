<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assetsemcor/img/icon.ico')}}" type="image/x-icon" />
    <script src="{{ asset('assetsemcor/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['../assetsemcor/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assetsemcor/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assetsemcor/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assetsemcor/css/demo.css')}}">
</head>

<body>
    <div class="wrapper">


        @include('employee-corner.include.header')
        <!-- Sidebar -->

        @include('employee-corner-organisation.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title">Daily Work Update</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="#">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Employee Access Value</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="{{url('employee-corner/work-update')}}">Daily Work Update</a>
                            </li>

                        </ul>
                    </div>

                    @if(Session::has('message'))
                    <div class="alert alert-success" style="text-align:center;"><span
                            class="glyphicon glyphicon-ok"></span><em> {{ Session::get('message') }}</em></div>
                    @endif



                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fas fa-briefcase"></i> Tasks</h4>

                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{ url('employee-corner/task-save') }}"
                                        enctype="multipart/form-data">
                                        {{csrf_field()}}

                                        <input type="hidden" name="reg" value="{{$Roledata->reg}}">
                                        <input type="hidden" name="employee_code" value="{{$employee->emp_code}}">
                                        <div class="row form-group">
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="date" class="placeholder"
                                                        style="margin-top:-12px;">Date</label>
                                                    <input id="date" type="date"
                                                        class="form-control input-border-bottom" name="date" required
                                                        min="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" readonly>


                                                </div>

                                            </div>

                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="in_time" class="placeholder"> From Time</label>
                                                    <input id="in_time" type="time"
                                                        class="form-control input-border-bottom" name="in_time" required
                                                        onchange="checktime();">

                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="out_time" class="placeholder"> To Time</label>
                                                    <input id="out_time" type="time"
                                                        class="form-control input-border-bottom" name="out_time"
                                                        required onchange="checktime();">

                                                </div>

                                            </div>
                                            <div class="col-md-3">

                                                <div class="form-group">
                                                    <label for="w_hours" class="placeholder" style="margin-top:-12px;">
                                                        Time (Hours)</label>
                                                    <input id="w_hours" type="number" step="any"
                                                        class="form-control input-border-bottom" name="w_hours"
                                                        required>

                                                </div>

                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="w_min" class="placeholder" style="margin-top:-12px;">
                                                        Time (Minutes)</label>
                                                    <input id="w_min" type="number" step="any"
                                                        class="form-control input-border-bottom" name="w_min" required>

                                                </div>

                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="w_min" class="placeholder"
                                                        style="margin-top:-12px;">Upload file</label>
                                                    <input id="file" type="file" accept="image/*;capture=camera"
                                                        class="form-control input-border-bottom" name="file"
                                                        onchange="Filevalidationproimge()">

                                                </div>

                                            </div>

                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <label for="w_min" class="placeholder" style="margin-top:12px;">
                                                        Work Update</label>
                                                    <textarea class="form-control input-border-bottom" name="remarks"
                                                        required></textarea>


                                                </div>

                                            </div>

                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">

                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </div>

                                        </div>




                                </div>



                            </div>
                        </div>

                    </div>


                </div>
            </div>
            @include('attendance.include.footer')
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}">
    </script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
    <script>
    $(document).ready(function() {
        $('#basic-datatables').DataTable({});

        $('#multi-filter-select').DataTable({
            "pageLength": 5,
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $(
                            '<select class="form-control"><option value=""></option></select>'
                        )
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true,
                                    false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d +
                            '</option>')
                    });
                });
            }
        });

        // Add Row
        $('#add-row').DataTable({
            "pageLength": 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

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


    <!--<script>-->
    <!--   var timepicker = new TimePicker('in_time', {-->
    <!--  lang: 'en',-->
    <!--  theme: 'dark'-->
    <!--});-->
    <!--timepicker.on('change', function(evt) {-->

    <!--  var value = (evt.hour || '00') + ':' + (evt.minute || '00');-->
    <!--  evt.element.value = value;-->

    <!--});-->
    <!-- var timepicker1 = new TimePicker('out_time', {-->
    <!--  lang: 'en',-->
    <!--  theme: 'dark'-->
    <!--});-->
    <!--timepicker1.on('change', function(evt) {-->

    <!--  var value = (evt.hour || '00') + ':' + (evt.minute || '00');-->
    <!--  evt.element.value = value;-->

    <!--});-->
    <!--</script>-->
</body>

</html>