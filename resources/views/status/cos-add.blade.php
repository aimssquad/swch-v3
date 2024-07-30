<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />


    <!-- Fonts and icons -->
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
    .autocomplete {
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    input[type=text] {
        background-color: #f1f1f1;
        width: 100%;
    }

    input[type=submit] {
        background-color: DodgerBlue;
        color: #fff;
        cursor: pointer;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
    </style>
</head>

<body>
    <div class="wrapper">

        @include('status.include.header')
        <!-- Sidebar -->

        @include('status.include.sidebar')
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

                    <li class="nav-item">
                        <a href="{{url('organisation-status/view-cos')}}"> COS File</a>
                    </li>
                    <li class="separator">
                        /
                    </li>
                    <li class="nav-item active">
                        <a href="#"> Add COS File</a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <div class="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="far fa-folder"></i> Add COS File</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{url('organisation-status/add-cos')}}" method="post"
                                        enctype="multipart/form-data" id="myForm">
                                        {{csrf_field()}}


                                        <div class="row form-group">

                                            <?php
if (!empty($bill_rs)) {
    $type = $bill_rs->post_date;
    $d_type = date('Y-m-d', strtotime($bill_rs->post_date . '  + 3 Weeks'));
    $sub_date = date('Y-m-d', strtotime($bill_rs->post_date . '  + 4  Weeks'));
} else {
    $type = '';
    $d_type = '';
    $sub_date = '';
}
?>


                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos" class="placeholder">Name of candidate
                                                    </label>
                                                    <!-- <select class="form-control input-border-bottom"
                                                        id="com_employee_id" name="com_employee_id"
                                                        style="margin-top: 22px;" required>
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $record)
                                                        <option value="{{$record->id}}">{{$record->emp_fname}}
                                                            {{$record->emp_mname}} {{$record->emp_lname}}</option>
                                                        @endforeach
                                                    </select> -->
                                                    <input id="employee_name" type="text" name="employee_name"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="" required>
                                                    <input id="com_employee_id" type="hidden" name="com_employee_id"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="0" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos" class="placeholder">Applied for CoS?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="cos" name="cos"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes
                                                        </option>
                                                        <option value="No">No
                                                        </option>
                                                        <option value="Not Known">Not Known</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="applied_cos_date" class="placeholder">Applied for CoS - Date </label>
                                                    <input id="applied_cos_date" type="date" name="applied_cos_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="client" class="placeholder">Type of CoS
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="type_of_cos"
                                                        name="type_of_cos" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="defined">Defined
                                                        </option>
                                                        <option value="undefined">Undefined
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="type_of_cos_date" class="placeholder">Type of CoS - Date </label>
                                                    <input id="type_of_cos_date" type="date" name="type_of_cos_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">
                                                </div>
                                            </div> -->

                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="additional_info_requested" class="placeholder">Additional information requested?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="additional_info_requested"
                                                        name="additional_info_requested" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes
                                                        </option>
                                                        <option value="No">No
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="additional_info_request_date" class="placeholder">Additional information requested - Date </label>
                                                    <input id="additional_info_request_date" type="date" name="additional_info_request_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="additional_info_sent" class="placeholder">Additional information sent?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="additional_info_sent"
                                                        name="additional_info_sent" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes
                                                        </option>
                                                        <option value="No">No
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="additional_info_sent_date" class="placeholder">Additional information sent - Date </label>
                                                    <input id="additional_info_sent_date" type="date" name="additional_info_sent_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos_assigned" class="placeholder">CoS assigned?
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="cos_assigned"
                                                        name="cos_assigned" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes
                                                        </option>
                                                        <option value="No">No
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos_assigned_date" class="placeholder">CoS assigned - Date </label>
                                                    <input id="cos_assigned_date" type="date" name="cos_assigned_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">
                                                </div>
                                            </div>


                                            <!-- <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="client" class="placeholder">Communication with Client
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="client"
                                                        name="client" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes
                                                        </option>
                                                        <option value="No">No
                                                        </option>





                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="identified" class="placeholder">Candidate
                                                        Identified</label>
                                                    <select class="form-control input-border-bottom" id="identified"
                                                        name="identified" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No
                                                        </option>


                                                    </select>


                                                </div>
                                            </div> -->
                                            <div class="col-md-8">
                                                <div class=" form-group">
                                                    <label for="remarks_cos" class="placeholder">Remarks</label>
                                                    <textarea id="remarks_cos" name="remarks_cos"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;">@if(isset($cos_apply->remarks_cos)){{$cos_apply->remarks_cos}}@endif</textarea>



                                                </div>
                                            </div>

                                            <!-- <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="target_date" class="placeholder">Target Date for Sending
                                                        Request to Home Office </label>
                                                    <input id="target_date" type="date" name="target_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="allocation_status" class="placeholder">Allocation Status
                                                    </label>
                                                    <select class="form-control input-border-bottom"
                                                        id="allocation_status" name="allocation_status"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>





                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="job_offer_status" class="placeholder">Job Offer Status
                                                    </label>
                                                    <select class="form-control input-border-bottom"
                                                        id="job_offer_status" name="job_offer_status"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>



                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_date" class="placeholder">Target Date for Making
                                                        Visa Application </label>
                                                    <input id="visa_date" type="date" name="visa_date"
                                                        class="form-control input-border-bottom"
                                                        style="margin-top: 22px;" value="">


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_app" class="placeholder">Visa Application Status
                                                    </label>
                                                    <select class="form-control input-border-bottom" id="visa_app"
                                                        name="visa_app" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No
                                                        </option>




                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="fur_query" class="placeholder">Further Query </label>
                                                    <select class="form-control input-border-bottom" id="fur_query"
                                                        name="fur_query" onchange="bank_epmloyee(this.value);"
                                                        style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No
                                                        </option>

                                                        <option value="Not Known">Not Known</option>


                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-6 " id="criman_bank_new" style="display:none;">
                                                <div class="form-group">

                                                    <label for="other" class="placeholder">Give Details </label><input
                                                        id="other" type="text" class="form-control input-border-bottom"
                                                        name="other" value="">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="visa_stat" class="placeholder">Visa Status </label>
                                                    <select class="form-control input-border-bottom" id="visa_stat"
                                                        name="visa_stat" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No
                                                        </option>

                                                        <option value="Not Known">Not Known</option>

                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="appeal" class="placeholder">Need for Appeal </label>
                                                    <select class="form-control input-border-bottom" id="appeal"
                                                        name="appeal" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Yes">Yes
                                                        </option>
                                                        <option value="No">No
                                                        </option>



                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="responsible" class="placeholder"
                                                        style="padding-top:0;margin-top: -10px;">Responsible
                                                        Person</label>
                                                    <input type="text" class="form-control input-border-bottom"
                                                        id="responsible" type="text" name="responsible" value="">


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="app_stat" class="placeholder">Appeal Status </label>
                                                    <select class="form-control input-border-bottom" id="app_stat"
                                                        name="app_stat" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Done">Done</option>
                                                        <option value="Not Done">Not Done</option>

                                                        <option value="NA">NA
                                                        </option>




                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="app_out" class="placeholder">Appeal Outcome</label>
                                                    <select class="form-control input-border-bottom" id="app_out"
                                                        name="app_out" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>
                                                        <option value="Further Proceedings">Further Proceedings</option>

                                                        <option value="No">No
                                                        </option>




                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" form-group">
                                                    <label for="cos_aloca" class="placeholder">COS Allocation
                                                        Status</label>
                                                    <select class="form-control input-border-bottom" id="cos_aloca"
                                                        name="cos_aloca" style="margin-top: 22px;">
                                                        <option value="">&nbsp;</option>

                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No
                                                        </option>


                                                    </select>


                                                </div>
                                            </div> -->

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder"
                                                        style="padding-top:0;margin-top: -10px;">Status</label>
                                                    <select class="form-control input-border-bottom" id="status"
                                                        name="status">
                                                        <option value="">&nbsp;</option>
                                                        <!-- <option value="Request">Request</option> -->
                                                        <option value="Granted">Granted</option>
                                                        <option value="Rejected">Rejected</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-default btn-up">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
            @include('status.include.footer')
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




    <script>
    function checkcompany() {
        var empid = document.getElementById("emidname").value;

        $.ajax({
            type: 'GET',
            url: '{{url("pis/getremidnamepaykkById")}}/' + empid,
            cache: false,
            success: function(response) {


                var obj = jQuery.parseJSON(response);

                console.log(obj);

                var reg = obj[0].reg;


                $("#emid").val(reg);
            }
        });
    }

    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            var empid = document.getElementById("job_date").value;
            e.preventDefault();
            if (empid != '') {
                this.submit();
            } else {
                $("#job_date").focus();
            }
        });
    });

    function bank_epmloyee(val) {
        if (val == 'Yes') {
            document.getElementById("criman_bank_new").style.display = "block";
        } else {
            document.getElementById("criman_bank_new").style.display = "none";
        }

    }

    function bank_yyepmloyee(val) {
        if (val == 'Yes') {
            document.getElementById("criman_banknn_new").style.display = "block";
        } else {
            document.getElementById("criman_banknn_new").style.display = "none";
        }

    }
    </script>
</body>

</html>