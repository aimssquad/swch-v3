<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon" />
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['{{ asset("assets/css/fonts.min.css")}}']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
    </script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
    <style>
    .check-clr {
        color: #1572e8;
        font-size: 30px;
        font-weight: 300;
    }
    </style>
</head>

<body>
    <div class="wrapper">

        @include('interroata.include.header')
        <!-- Sidebar -->

        @include('interroata.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">


                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="#">
                            Home
                        </a>
                    </li>

                    <li class="separator">
                        /
                    </li>
                    <li class="nav-item active">
                        <a href="{{url('interroata/work-update')}}">Daily Work Update</a>
                    </li>

                </ul>
            </div>
            <div class="content">
                <div class="page-inner">
                    <?php	$member = Session::get('admin_userpp_member');
$duty_reracs = DB::Table('duty_roster_emp')
    ->where('employee_id', '=', $member)
    ->where('start_date', 'like', date('Y-m') . '%')
    ->first();

if (!empty($duty_reracs)) {
    $passnew = DB::Table('duty_emp_leave')

        ->where('a_id', '=', $duty_reracs->id)
        ->where('date', '=', date('Y-m-d'))

        ->first();

}

?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title">Daily Work Update
                                        @if(!empty($duty_reracs) && isset($passnew) && !empty($passnew) &&
                                        isset($passnew->hours) && $passnew->hours!='') <span> <a data-toggle="tooltip"
                                                data-placement="bottom" title="Add Work Update"
                                                href="{{ url('interroata/add-work-update') }}"> <img width="25px;"
                                                    src="{{ asset('img/plus1.png')}}" /></a></span> @endif </h4>
                                    @if(Session::has('message'))
                                    <div class="alert alert-success" style="text-align:center;"><span
                                            class="glyphicon glyphicon-ok"></span><em>
                                            {{ Session::get('message') }}</em></div>
                                    @endif

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="display table table-striped table-hover">
                                            <thead>

                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Organisation Name</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>From Time</th>
                                                    <th>To Time</th>
                                                    <th>Time </th>

                                                    <th>Remarks </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $i = 1;?>
                                                @foreach($employee_type_rs as $candidate)
                                                <?php
$employee_desigrs = DB::table('registration')
    ->where('reg', '=', $candidate->emid)
    ->where('reg', 'like', 'EM%')
    ->first();

?>
                                                <tr>
                                                    <td><?=$i?></td>
                                                    <td> @if(!empty( $employee_desigrs))
                                                        {{ $employee_desigrs->com_name }} @endif</td>
                                                    <td>{{ $candidate->type }} @if($candidate->type=='Others') (
                                                        {{ $candidate->rect_deatils }} ) @endif </td>
                                                    <td>{{ date('d/m/Y',strtotime($candidate->date)) }} </td>
                                                    <td>{{ date('h:i A',strtotime($candidate->in_time)) }} </td>
                                                    <td>{{ date('h:i A',strtotime($candidate->out_time)) }} </td>
                                                    <td> {{ $candidate->w_hours }} Hours {{ $candidate->w_min }} Minutes
                                                    </td>
                                                    <td> {{ $candidate->remarks }}</td>
                                                    <td>


                                                        <a
                                                            href="{{url('interroata/add-work-update')}}?id={{base64_encode($candidate->id) }}"><img
                                                                style="width: 30px;"
                                                                src="{{ asset('assets/img/edit.png')}}"></a>

                                                    </td>
                                                </tr>
                                                <?php $i++;?>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
            @include('interroata.include.footer')
        </div>

    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

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
                                .search(val ? '^' + val + '$' : '', true, false)
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
    </script>
</body>

</html>